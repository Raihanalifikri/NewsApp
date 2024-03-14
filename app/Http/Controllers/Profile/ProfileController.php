<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
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

    public function allUser(){
         $title = 'All User';

         $user = User::where('role', 'user')->get();

         return view('home.user.index', compact(
            'title',
            'user'
         ));
    }

    public function resetPassword($id){
        // get user by id
        $user = User::find($id);
        $user->password = Hash::make('123456');
        $user->save();

        // return
        return redirect()->back()->with('success', 'Password has been reset');
    }

    public function createProfile(){
        $title = 'Create Profile';

        return view('home.profile.create', compact(
            'title'
        ));
    }

    public function storeProfile(Request $request){
        //Validate
        $this->validate($request, [
            'first_name' => 'required',
            'image' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        // Sote image
        $image = $request->file('image');
        $image->storeAs('public/profile/', $image->getClientOriginalName());

        // Get user Login
        $user = auth()->user();

        // Create data Profile
        $user->profile()->create([
            'first_name' => $request->first_name,
            'image' => $image->getClientOriginalName()
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile hes been created');
    }


}
