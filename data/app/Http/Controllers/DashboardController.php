<?php

namespace App\Http\Controllers;

use App\Calendar\Calendar;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $Calendar = new Calendar();
        $User = new User();

        $beforeWeek = Carbon::now()->subWeek(1)->format('Y-m-d');
        $Calendar->make($beforeWeek, 14);

        $isAdmin = true;
        $userScheduleActive = false;
        if (false === $User->isAdmin(auth()->id())) {
            $isAdmin = false;
            $activeUserKeys = $User->getScheduleActiveUsersId();
            if (in_array(auth()->id(), $activeUserKeys, true)) {
                $userScheduleActive = true;
            }
        }

        return view('dashboard', ['Calendar' => $Calendar, 'userScheduleActive' => $userScheduleActive, 'isAdmin' => $isAdmin]);
    }

    public function store(Request $request)
    {
        $switchScheduleActive = $request->get('switch_schedule_active');

        $User = new User();
        $Schedule = new Schedule();

        $userBuilder = $User->find(auth()->id());

        if (!$userBuilder->exists()) return redirect()->back();

        $userBuilder->update(['is_schedule_active' => $switchScheduleActive]);
        if (false == $switchScheduleActive) {
            $Schedule->deleteDeActiveUserRecord(auth()->id());
        }

        return redirect()->back();
    }
}
