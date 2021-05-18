<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stadium extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['name', 'city', 'lat', 'lng'];
    //Relationships
}
