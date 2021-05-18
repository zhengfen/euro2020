<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pronostic extends Model
{
    protected $fillable = ['user_id', 'match_id', 'team_h', 'team_a', 'score_h', 'score_a'];
    // The relationships to always eager-load.
    protected $with = ['match'];
    // The accessors to append to the model's array form.
    protected $appends = ['group_name'];

    //relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function match()
    {
        return $this->belongsTo(Match::class, 'match_id');
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'team_h');
    }
    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'team_a');
    }
    // accessors
    public function getGroupNameAttribute()
    {
        $group_name = ['A', 'B', 'C', 'D', 'E', 'F'];
        $group_id = $this->match->group_id;
        if ($group_id)
            return $group_name[$group_id - 1];
        else return null;
    }
}
