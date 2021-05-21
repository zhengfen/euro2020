<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prediction extends Model
{
    protected $fillable = ['user_id', 'game_id', 'team_h', 'team_a', 'score_h', 'score_a'];

}
