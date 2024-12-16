<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function dashboard()
    {
        $staffCount = User::where('is_admin', 0)->count();
        return view('admin.dashboard',compact('staffCount'));
    }

    public function staffList()
    {
        $staff = User::where('is_admin', 0)->with('timesheets')->get();
        return view('admin.staff-list', compact('staff'));
    }

    public function createStaff()
    {
        return view('admin.add-staff');
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = $photoName = null;
        if ($request->hasFile('profile_image')) {
            $photoPath = $request->file('profile_image')->store('photos', 'public');

            $photoName = basename($photoPath);
        }

        $staff=  User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => 0,
            'profile_image' => $photoName,
        ]);

        $staff->user_password = $request->password;

        $data = ['staff' => $staff];
        Mail::send('emails.welcome', $data, function($message) use ($staff) {
            $message->to($staff->email)
                    ->subject('Welcome to Our Company!');
        });

        if (Auth::user()->is_admin == 1) {
            return redirect()->route('admin.staff-list')->with('success', 'Staff member added successfully.');
        } else {
            return  redirect()->route('login.staff')->with('success', 'Staff member added successfully.');
        }
    }

    public function editStaff($id)
    {
        $staff = User::findOrFail($id); 
        return view('admin.edit-staff', compact('staff')); 
    }

    public function updateStaff(Request $request, $id)
    {
        $staff = User::findOrFail($id); 

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, 
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($request->hasFile('profile_image')) {
            if ($staff->profile_image) {
                $oldImagePath = public_path('storage/photos/' . $staff->profile_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); 
                }
            }
            $photoPath = $request->file('profile_image')->store('photos', 'public');
            $photoName = basename($photoPath);
        } else {
            $photoName = $staff->profile_image;
        }
        $staff->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $staff->password, 
            'profile_image' => $photoName,
        ]);

        return redirect()->route('admin.staff-list')->with('success', 'Staff member updated successfully.');
    }
}
