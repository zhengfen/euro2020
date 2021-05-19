<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

use App\Models\Game;

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

    // team standings according to user pronostics, grouped by group
    public function standings($groups = null)
    {
        $standings = array();
        if (!$groups) {
            $groups = Group::with(['games', 'teams'])->get();
        }
        foreach ($groups as $group) {
            $standings[$group->id] = array();
            // assign initial values for the teams in the group
            foreach ($group->teams as $team) {
                $standings[$group->id][$team->id] = array(
                    'team_id' => $team->id,
                    'team_name' => $team->name,
                    'team_iso' => $team->iso,
                    'played' => 0,
                    'wins' => 0,
                    'draws' => 0,
                    'losses' => 0,
                    'goalsFor' => 0,
                    'goalsAgainst' => 0,
                );
            }
            // parse the pronostics for the group games
            foreach ($group->games as $game) {
                $pronostic = $this->pronostics->where('game_id', $game->id)->first();  // ->first() return an instance of the first found model, or null otherwise.
                if (!$pronostic || is_null($pronostic->score_h) || is_null($pronostic->score_a)) continue;
                $team_h = $game->team_h;  // team id
                $team_a = $game->team_a;
                $standings[$group->id][$team_h]['played'] += 1;
                $standings[$group->id][$team_a]['played'] += 1;
                $standings[$group->id][$team_h]['goalsFor'] += $pronostic->score_h;
                $standings[$group->id][$team_h]['goalsAgainst'] += $pronostic->score_a;
                $standings[$group->id][$team_a]['goalsFor'] += $pronostic->score_a;
                $standings[$group->id][$team_a]['goalsAgainst'] += $pronostic->score_h;
                switch ($pronostic->score_h <=> $pronostic->score_a) {
                    case 0:
                        $standings[$group->id][$team_h]['draws'] += 1;
                        $standings[$group->id][$team_a]['draws'] += 1;
                        break;   // tie
                    case 1:
                        $standings[$group->id][$team_h]['wins'] += 1;
                        $standings[$group->id][$team_a]['losses'] += 1;
                        break;  // home team wins
                    case -1:
                        $standings[$group->id][$team_h]['losses'] += 1;
                        $standings[$group->id][$team_a]['wins'] += 1;
                        break;  // home team loses
                }
            }
            usort($standings[$group->id], array($this, "cmp_standings"));
        }
        return $standings;
    }

    // compare team standings in group phase, with values of user pronostics
    function cmp_standings($a, $b)
    {
        //if both teams have no pronostics yet
        if ($a['played'] == 0 && $b['played'] == 0) return 0;
        // Points (3 points for a win, 1 point for a draw, 0 points for a loss)
        $result = ($b['wins'] * 3 + $b['draws']) <=> ($a['wins'] * 3 + $a['draws']);
        if ($result !== 0) return $result;
        // Overall goal difference
        $result = ($b['goalsFor'] - $b['goalsAgainst']) <=> ($a['goalsFor'] - $a['goalsAgainst']);
        if ($result !== 0) return $result;
        // Overall goals scored
        $result = $b['goalsFor'] <=> $a['goalsFor'];
        if ($result !== 0) return $result;
        // Points in games between tied teams
        $game = Game::group_game_between($a['team_id'], $b['team_id']);
        if ($winner_id = $this->pronostic_winner($game->id)) {
            if ($winner_id == $a['team_id']) return -1;
            if ($winner_id == $b['team_id']) return 1;
        }
        return 0;
    }

    // get winner of a game according to user pronostics
    function pronostic_winner(int $game_id)
    {
        $pronostic = $this->pronostics->where('game_id', $game_id)->first();
        if ($pronostic && $pronostic->score_h !== null && $pronostic->score_a !== null) {
            switch ($pronostic->score_h <=> $pronostic->score_a) {
                case 1:
                    return $pronostic->game->team_h;
                case 0:
                    return null;
                case -1:
                    return $pronostic->game->team_a;
            }
        }
        return null;
    }

    // get the 16 qualified teams from game 49-56
    public function qualified_16($pronostics = null)
    {
        $qualified = [];
        if (!$pronostics) $pronostics = $this->pronostics->where('game_id', '>=', '37')->where('game_id', '<=', '44')->all();
        foreach ($pronostics as $pronostic) {
            if ($pronostic->team_h)  array_push($qualified, $pronostic->team_h);
            if ($pronostic->team_a)  array_push($qualified, $pronostic->team_a);
        }
        return $qualified;
    }

    // get the 8 qualified teams from game 57-60
    public function qualified_8($pronostics = null)
    {
        $qualified = [];
        if (!$pronostics) $pronostics = $this->pronostics->where('game_id', '>=', '45')->where('game_id', '<=', '48')->all();
        foreach ($pronostics as $pronostic) {
            if ($pronostic->team_h)  array_push($qualified, $pronostic->team_h);
            if ($pronostic->team_a)  array_push($qualified, $pronostic->team_a);
        }
        return $qualified;
    }

    // get the 4 qualified teams  from game 61,62
    public function qualified_4($pronostics = null)
    {
        $qualified = [];
        if (!$pronostics) $pronostics = $this->pronostics->where('game_id', '>=', '49')->where('game_id', '<=', '50')->all();
        foreach ($pronostics as $pronostic) {
            if ($pronostic->team_h)  array_push($qualified, $pronostic->team_h);
            if ($pronostic->team_a)  array_push($qualified, $pronostic->team_a);
        }
        return $qualified;
    }

    // get the 2 qualified teams  from game 64
    public function qualified_2($pronostic = null)
    {
        $qualified = [];
        if (!$pronostic) $pronostic = $this->pronostics->where('game_id', '51')->first();
        if ($pronostic->team_h)  array_push($qualified, $pronostic->team_h);
        if ($pronostic->team_a)  array_push($qualified, $pronostic->team_a);
        return $qualified;
    }

    // get the champion  from game 64
    public function first($pronostic = null)
    {
        if (!$pronostic) $pronostic = $this->pronostics->where('game_id', '51')->first();
        if ($pronostic && $pronostic->team_h !== null && $pronostic->team_a !== null && $pronostic->score_h !== null && $pronostic->score_a !== null) {
            if ($pronostic->score_h > $pronostic->score_a) return $pronostic->team_h;
            return $pronostic->team_a;
        }
        return null;
    }

    // if the user has filled all the pronostics for the given group
    public function filled_group(Group $group)
    {
        foreach ($group->games as $game) {
            if (is_null($this->score_h($game->id)) || is_null($this->score_a($game->id))) return false;
        }
        return true;
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
            if ((is_null($game->score_h) || is_null($game->score_a)) && $game->id < 49)   break;   // the game is not finished yet
            if (is_null($game->team_h) && is_null($game->team_a))   break;
            else {
                $pronostic = $pronostics->where('game_id', $game->id)->first();
                if (is_null($pronostic) || is_null($pronostic->score_h) || is_null($pronostic->score_a)) {
                    $point += 0;
                    array_push($points, $point);
                    continue;
                }  // user have not complete the pronostics for the game
                switch (true) {
                        //                    case($game->id<49): // group game[1-48]
                    case ($game->type == 'group'):
                        if (($pronostic->score_h <=> $pronostic->score_a) == ($game->score_h <=> $game->score_a)) {
                            $point += 2;
                            if ($pronostic->score_h == $game->score_h) $point += 1;
                            if ($pronostic->score_a == $game->score_a) $point += 1;
                        }
                        array_push($points, $point);
                        break;
                        /*
                    case($game->id==49): // qualified [49-56] 1/8 // points for Huiti�mes de finale: 4 points pour avoir choisi la bonne �quipe qualifi�e
                        $point += count(array_intersect($this->qualified_16(),Game::qualified_16()))*4;
                        array_push($points,$point);
                        break;*/

                        //                    case($game->id>48 && $game->id<57): // qualified [49-56] 1/8
                    case ($game->knockout_id == 1):
                        $qualified_16 = $this->qualified_16();
                        if (in_array($game->team_h, $qualified_16))   $point += 4;
                        if (in_array($game->team_a, $qualified_16))   $point += 4;
                        array_push($points, $point);
                        break;

                        //                    case($game->id>56 && $game->id<61):  // Quarts de finale  [57-60] 1/4
                    case ($game->knockout_id == 2):
                        $qualified_8 = $this->qualified_8();
                        if (in_array($game->team_h, $qualified_8))   $point += 6;
                        if (in_array($game->team_a, $qualified_8))   $point += 6;
                        array_push($points, $point);
                        break;
                        //                    case($game->id>60 && $game->id<63):  // demi [61-62]
                    case ($game->knockout_id == 3):
                        $qualified_4 = $this->qualified_4();
                        if (in_array($game->team_h, $qualified_4))   $point += 8;
                        if (in_array($game->team_a, $qualified_4))   $point += 8;
                        array_push($points, $point);
                        break;
                        //                    case($game->id==64): // final
                    case ($game->knockout_id == 4):
                        $qualified_2 = $this->qualified_2($pronostics->where('game_id', '64')->first());
                        if (in_array($game->team_h, $qualified_2))   $point += 10;
                        if (in_array($game->team_a, $qualified_2))   $point += 10;
                        // if the champion is right
                        if ($game->score_h > $game->score_a)  $first = $game->team_h;
                        else $first = $game->team_a;
                        if ($this->first() == $first)   $point += 20;
                        array_push($points, $point);
                        break;
                }
            }
        }
        return $points;
    }

    // create initial pronostics for user
    public function create_pronostics()
    {
        $max = Game::orderBy('id', 'desc')->first();
        for ($i = 1; $i <= $max; $i++) {
            $pronostic = Pronostic::firstOrCreate(
                ['user_id' => $this->id, 'game_id' => $i]
            );
        }
    }

    // update knockout when user pronostics changed
    public function update_knockouts()
    {
        $knockout_games = Game::where('type', '>=', 1)->orderBy('date')->get();
        $standings = $this->standings();
        foreach ($knockout_games as $game) {
            $pronostic = Pronostic::firstOrCreate([
                'user_id' => $this->id,
                'game_id' => $game->id
            ]);

            $team = $this->getPronosticKnockoutTeam($game->type, $game->qualification_h, $standings);
            if ($team !== $pronostic->team_h) {
                $pronostic->update(['team_h' => $team, 'score_h' => null]);
            }
            $team = $this->getPronosticKnockoutTeam($game->type, $game->qualification_a, $standings);
            if ($team !== $pronostic->team_a) {
                $pronostic->update(['team_a' => $team, 'score_a' => null]);
            }
        }
    }

    /**
     * update table pronostics team for knockout game
     * 
     * @param int $game_type [0 => 'group', 1 => 'round16', 2=>'round8', 3 => 'round4', 4 => 'round2'] 
     * @param string $qualification   example: '2_A', '3_ABC', 'W49'
     */
    public function getPronosticKnockoutTeam(int $game_type, string $qualification, array $standings)
    {
        switch ($game_type) {
            default:
                return null;
            case 1: // round 16 , '2_A' or '3_ABC', 
                $splitted = explode('_', $qualification);
                $position = $splitted[0];
                $groups = $splitted[1];

                if ($position == 1 || $position == 2) {
                    // get the group
                    $group = Group::where('name', strtoupper($groups))->first();
                    if (!$group) {
                        throw new Exception('Group not found in ' . $qualification);
                    }
                    // pronostic group winner team
                    if ($this->pronostic_finished($group)) {
                        return $standings[$group->id][$position - 1]['team_id'];
                    }
                    return null;
                }

                if ($position == 3) {

                    $this->get_best_third( $this->standings(), $groups); 
                }


            case 2-4:  // 'W51'
                $game_id = ltrim($qualification, 'W');
                $pronostic = $this->pronostics->where('game_id', intval($game_id))->first();
                if ($pronostic->score_h !== null && $pronostic->score_a !== null) {
                    if ($pronostic->score_h > $pronostic->score_a) {
                        return $pronostic->team_h;
                    } else {
                        return $pronostic->team_a;
                    }
                }
                return null;
        }
    }

    /**
     *  check of the pronostic is complet for the group 
     */
    public function pronostic_finished(Group $group)
    {
        foreach ($group->games as $game) {
            $pronostic = $this->pronostics->where('game_id', $game->id)->first();
            if (is_null($pronostic->score_h) || is_null($pronostic->score_a)) {
                return false;
            }
        }
        return true;
    }

    /**
     * get the best third team for qualification
     * @param array $standing
     * @param string $groupcode   example: 'ABC'
     */
    public function get_best_third(array $standings, string $groupcode)
    {
        $thirdarray = array();
        foreach ($standings as $group_id => $standing) {
            $standing[2]['group'] = $group_id;

            //            array_push($thirdarray, $standing[2]);

            $thirdarray[$standing[2]['team_id']] = $standing[2];
        }

        usort($thirdarray, array($this, "cmp_standings"));



        $thirdgroupcodearray = array($thirdarray[0]['group'], $thirdarray[1]['group'], $thirdarray[2]['group'], $thirdarray[3]['group']);

        sort($thirdgroupcodearray);

        $thirdgroupcode = implode($thirdgroupcodearray);

        $decodearray = array(

            "1234" => array(1, 4, 2, 3),

            "1235" => array(1, 5, 2, 3),

            "1236" => array(1, 6, 2, 3),

            "1245" => array(4, 5, 1, 2),

            "1246" => array(4, 6, 1, 2),

            "1256" => array(5, 6, 2, 1),

            "1345" => array(5, 4, 3, 1),

            "1346" => array(6, 4, 3, 1),

            "1356" => array(5, 6, 3, 1),

            "1456" => array(5, 6, 4, 1),

            "2345" => array(5, 4, 2, 3),

            "2346" => array(6, 4, 3, 2),

            "2356" => array(6, 5, 3, 2),

            "2456" => array(6, 5, 4, 2),

            "3456" => array(6, 5, 4, 3)

        );

        switch ($groupcode) {

            case "ADEF":

                return $standings[$decodearray[$thirdgroupcode][0]][2]['team_id'];

                break;

            case "ABC":

                return $standings[$decodearray[$thirdgroupcode][3]][2]['team_id'];

                break;

            case "ABCD":

                return $standings[$decodearray[$thirdgroupcode][2]][2]['team_id'];

                break;

            case "DEF":

                return $standings[$decodearray[$thirdgroupcode][1]][2]['team_id'];

                break;

            default:

                break;
        }
    }
}
