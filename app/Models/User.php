<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use App\Models\Game;
use App\Models\Pronostic; 

class User extends \TCG\Voyager\Models\User
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // relationship
    public function pronostics()
    {
        return $this->hasMany(Pronostic::class);
    }


    public function isSuperAdmin()
    {
        return $this->email == 'ricardo.gomes@alro.ch';  // admin middleware
    }

    public function isAdmin()
    {
        return ($this->role_id == 1);  // admin middleware
    }

    /**
     * get qualified teams id
     */
    public function qualified(int $type)
    {
        $games_id = DB::table('games')->where('type', $type)->pluck('id'); 
        $pronostics = Pronostic::where('user_id', $this->id)->whereIn('game_id', $games_id)->get(); 
        foreach ($pronostics as $pronostic) {
            if ($pronostic->team_h)  array_push($qualified, $pronostic->team_h);
            if ($pronostic->team_a)  array_push($qualified, $pronostic->team_a);
        }
        return $qualified;
    }

    // get the champion team id
    public function first()
    {
        $game_id = DB::table('games')->where('type', 4)->first()->pluck('id'); 
        $pronostic = Pronostic::where('user_id', $this->id)->where('game_id', $game_id)->first(); 
        if ($pronostic && $pronostic->team_h !== null && $pronostic->team_a !== null && $pronostic->score_h !== null && $pronostic->score_a !== null) {
            if ($pronostic->score_h > $pronostic->score_a) return $pronostic->team_h;
            return $pronostic->team_a;
        }
        return null;
    }

    public function points($games = null)
    {
        $points = [];
        $point = 0;
        array_push($points, 0);
        if (!$games) {
            $games = Game::orderBy('date')->get();
        }
        $pronostics = DB::table('pronostics')->where('user_id', $this->id)->get();
        foreach ($games as $game) {
            if ((is_null($game->score_h) || is_null($game->score_a)))   break;   // the game is not finished yet
            if (is_null($game->team_h) && is_null($game->team_a))   break;
            else {
                $pronostic = $pronostics->where('game_id', $game->id)->first();
                if (is_null($pronostic) || is_null($pronostic->score_h) || is_null($pronostic->score_a)) {
                    $point += 0;
                    array_push($points, $point);
                    continue;
                }  // user have not complete the pronostics for the game
                switch ($game->type) {
                    case 0:
                        if (($pronostic->score_h <=> $pronostic->score_a) == ($game->score_h <=> $game->score_a)) {
                            $point += 2;
                            if ($pronostic->score_h == $game->score_h) $point += 1;
                            if ($pronostic->score_a == $game->score_a) $point += 1;
                        }
                        array_push($points, $point);
                        break;
                    case 1:
                        $qualified = $this->qualified_16(1);
                        if (in_array($game->team_h, $qualified))   $point += 4;
                        if (in_array($game->team_a, $qualified))   $point += 4;
                        array_push($points, $point);
                        break;
                    case 2:
                        $qualified = $this->qualified(2);
                        if (in_array($game->team_h, $qualified))   $point += 6;
                        if (in_array($game->team_a, $qualified))   $point += 6;
                        array_push($points, $point);
                        break;
                    case 3:
                        $qualified = $this->qualified(3);
                        if (in_array($game->team_h, $qualified))   $point += 8;
                        if (in_array($game->team_a, $qualified))   $point += 8;
                        array_push($points, $point);
                        break;
                    case 4:
                        $qualified = $this->qualified(1);
                        if (in_array($game->team_h, $qualified))   $point += 10;
                        if (in_array($game->team_a, $qualified))   $point += 10;
                        // if the champion is right
                        $first = $game->score_h > $game->score_a ?  $game->team_h : $game->team_a; 
                        if ($this->first() == $first)   $point += 20;
                        array_push($points, $point);
                        break;
                }
            }
        }
        return $points;
    }

}
