<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['team_h','team_a','date','score_h','score_a','pen_h','pen_a','stadium_id','type','qual_h','qual_a',
    'group_id', // group_id to make calculate group standings easier
];

    //relationships
    public function group()
    {
        return $this->belongsTo('App\Group','group_id');
    }

    public function stadium()
    {
       return $this->belongsTo('App\Stadium','stadium_id');
    }
    public function homeTeam()
    {
        return $this->belongsTo('App\Team','team_h');
    }
    public function awayTeam()
    {
        return $this->belongsTo('App\Team','team_a');
    }
        /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'datetime:Y-m-d\TH:i',
    ];
}
