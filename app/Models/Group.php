<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name'];

    //Relationships
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class)->orderBy('id');
    }

    // team standings within a group  // team: TeamModel|string, played: number = 0, wins: number = 0, draws: number = 0, losses: number = 0, goalsFor: number = 0, goalsAgainst: number = 0)
    public function standings()
    {
        $standings = array();
        // define initial velues
        foreach ($this->teams as $team) {
            $standings[$team->id] = array(
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
        // update values according to each game
        foreach ($this->games as $game) {  // only group games
            if (is_null($game->score_h) || is_null($game->score_a)) break;  // game not finished
            $standings[$game->team_h]['played'] += 1;
            $standings[$game->team_a]['played'] += 1;
            $standings[$game->team_h]['goalsFor'] += $game->score_h;
            $standings[$game->team_h]['goalsAgainst'] += $game->score_a;
            $standings[$game->team_a]['goalsFor'] += $game->score_a;
            $standings[$game->team_a]['goalsAgainst'] += $game->score_h;
            switch ($game->score_h <=> $game->score_a) {
                case 0:
                    $standings[$game->team_h]['draws'] += 1;
                    $standings[$game->team_a]['draws'] += 1;
                    break;
                case 1:
                    $standings[$game->team_h]['wins'] += 1;
                    $standings[$game->team_a]['losses'] += 1;
                    break;  // home team wins
                case -1:
                    $standings[$game->team_h]['losses'] += 1;
                    $standings[$game->team_a]['wins'] += 1;
                    break;  // home team loses
            }
        }
        usort($standings, array($this, "cmp_standings"));
        return $standings;
    }
}
