<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $title = 'Profile';

        return view('home.profile.index', compact(
            'title'
        ));
    }

    public function changePassword()
    {
        $title = 'Change Password';

        return view('home.profile.change-password', compact(
            'title'
        ));
    }

    public function updatePassword(Request $request)
    {
        // validate
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6'
        ]);

        // Check Current password status
        $currentPasswordStatus = Hash::check(
            $request->current_password,
            auth()->user()->password
        );

        if($currentPasswordStatus){
            if($request->password == $request->confirm_password){
                // Get user login by Auth
                $user = auth()->user();

                // update password
                $user->password = Hash::make($request->password);
                $user->save();

                return redirect()->back()->with('success', 'Password Has Been Updated');

            } else {
                return redirect()->back()->with(
                    'error',
                    'password not found'
                );
            }

        } else {
            return redirect()->back()->with('error', 'Current Password Is Worng');
        }

    }
}
