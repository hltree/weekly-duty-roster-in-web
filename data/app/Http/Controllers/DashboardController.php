<?php

namespace App\Http\Controllers;

use App\Calendar\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {

        $Calendar = new Calendar();
        $beforeWeek = Carbon::now()->subWeek(1)->format('Y-m-d');
        $Calendar->make($beforeWeek, 14);

        return view('dashboard', ['Calendar' => $Calendar]);
    }
}
