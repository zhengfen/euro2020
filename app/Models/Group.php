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

    public function matches()
    {
        return $this->hasMany(Match::class)->orderBy('id');
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
        // update values according to each match
        foreach ($this->matches as $match) {  // only group matches
            if (is_null($match->score_h) || is_null($match->score_a)) break;  // match not finished
            $standings[$match->team_h]['played'] += 1;
            $standings[$match->team_a]['played'] += 1;
            $standings[$match->team_h]['goalsFor'] += $match->score_h;
            $standings[$match->team_h]['goalsAgainst'] += $match->score_a;
            $standings[$match->team_a]['goalsFor'] += $match->score_a;
            $standings[$match->team_a]['goalsAgainst'] += $match->score_h;
            switch ($match->score_h <=> $match->score_a) {
                case 0:
                    $standings[$match->team_h]['draws'] += 1;
                    $standings[$match->team_a]['draws'] += 1;
                    break;
                case 1:
                    $standings[$match->team_h]['wins'] += 1;
                    $standings[$match->team_a]['losses'] += 1;
                    break;  // home team wins
                case -1:
                    $standings[$match->team_h]['losses'] += 1;
                    $standings[$match->team_a]['wins'] += 1;
                    break;  // home team loses
            }
        }
        usort($standings, array($this, "cmp_standings"));
        return $standings;
    }
}
