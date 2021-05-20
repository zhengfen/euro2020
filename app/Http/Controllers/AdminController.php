<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function truncate(string $name)
    {
        DB::table($name)->truncate();
        echo '<p>table ' . $name . ' truncated</p>';
    }
}
