<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DashboardController extends Model
{
    public function index()
    {
        return view('layouts.dashboard.index');
    }
}
