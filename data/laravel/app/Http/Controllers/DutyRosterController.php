<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DutyRoster;

class DutyRosterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view(Request $request)
    {
        $items = DutyRoster::all();
        //return view('duty-roster.view', ['items' => $items]);
        return view('duty-roster.view');
    }

    public function setting(Request $request)
    {
        dd($request->name);
        return view('duty-roster.setting');
    }
}
