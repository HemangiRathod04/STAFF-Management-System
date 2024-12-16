<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffLoginController extends Controller
{

    public function dashboard()
    {
        $staffCount = User::where('is_admin', 0)->count();
        return view('admin.staff-dashboard',compact('staffCount'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials) && Auth::user()->is_admin == 0) {
            return redirect()->route('staff.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials or not a staff user.']);
    }

    public function clockIn(Request $request)
    {
        $user = Auth::user();
        $timesheet = $user->timesheets()->create(['clock_in_time' => now()]);
    
        return response()->json(['success' => true]);
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();
        $lastTimesheet = $user->timesheets()->latest()->first();

        if ($lastTimesheet && !$lastTimesheet->clock_out_time) {
            $lastTimesheet->update(['clock_out_time' => now()]);

            $clockInTime = Carbon::parse($lastTimesheet->clock_in_time);
            $clockOutTime = Carbon::parse($lastTimesheet->clock_out_time);
            $totalTime = $clockOutTime->diffForHumans($clockInTime, true);

            return response()->json(['success' => true, 'total_time' => $totalTime]);
        }

        return response()->json(['success' => false]);
    }
}
