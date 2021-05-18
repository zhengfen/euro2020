<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'abr', 'group_id', 'iso'];
    //Relationships
    public function groups()
    {
        return $this->belongsTo('App\Group');
    }
}
