<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Clock;
use App\Models\Timesheet;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $photoName = null;
        if ($request->hasFile('profile_image')) {
            $photoPath = $request->file('profile_image')->store('photos', 'public');
            $photoName = basename($photoPath);
        }

        $staff = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
            'profile_image' => $photoName,
        ]);

        Mail::send('emails.welcome', ['staff' => $staff], function ($message) use ($staff) {
            $message->to($staff->email)->subject('Welcome to Our Company!');
        });

        return response()->json(['message' => 'Staff member registered successfully', 'staff' => $staff], 201);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $staff = User::where('email', $request->email)->first();

        if ($staff && Hash::check($request->password, $staff->password)) {
            $token = $staff->createToken('StaffAccessToken')->accessToken;
            return response()->json(['token' => $token, 'staff' => $staff], 200);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    public function getProfile()
    {
        $staff = Auth::user();
        return response()->json(['staff' => $staff], 200);
    }


    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . Auth::id(),
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $staff = Auth::user();

        if ($request->hasFile('profile_image')) {
            $photoPath = $request->file('profile_image')->store('photos', 'public');
            $staff->profile_image = basename($photoPath);
        }

        $staff->update($request->only(['first_name', 'last_name', 'email']));
        return response()->json(['message' => 'Profile updated successfully', 'staff' => $staff], 200);
    }


    public function clockIn()
    {
        $staff = Auth::user();
        $clock = Timesheet::create([
            'user_id' => $staff->id,
            'clock_in_time' => Carbon::now(),
        ]);

        return response()->json(['message' => 'Clocked in successfully', 'clock' => $clock], 200);
    }

    public function clockOut()
    {
        $staff = Auth::user();
        $clock = Timesheet::where('user_id', $staff->id)->whereNull('clock_out_time')->first();
        if ($clock) {
            $clock->update(['clock_out_time' => Carbon::now()]);
            return response()->json(['message' => 'Clocked out successfully', 'clock' => $clock], 200);
        }

        return response()->json(['message' => 'No active clock-in found'], 404);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->token()->revoke();
        return response()->json([
            'message' => 'Logged out successfully'
        ], 200);
    }
}
