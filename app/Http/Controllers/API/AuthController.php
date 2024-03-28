<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            // validate
            $this->validate($request, [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // cek credentials (login)
            $credentials = request(['email', 'password']);
            if (!Auth::attempt([
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ])) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            };

            // cek jika password tidak sesuai
            $user = User::where('email', $credentials['email'])->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Invalid Credentials');
            }

            // jika berhasil cek password maka loginkan
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated', 200);
        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function register(Request $request)
    {
        try {
            // validate
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6'
            ]);

            // cek kondisi jika password dan confirm password tidak sama (!= artinya tidak sama)
            if ($request->password != $request->confirm_password) {
                return ResponseFormatter::error([
                    'message' => 'Password not match'
                ], 'Authentication Failed', 401);
            }

            // create akun
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // get data akun
            $user = User::where('email', $request->email)->first();

            // create token
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ], 'Authenticated', 200);
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success([
            $token = 'Token revoked'
        ], 'Token revoked', 200);
    }

    public function allUsers()
    {
        $user = User::where('role', 'user')->get();
        return ResponseFormatter::success($user, 'Data user berhasil diambil', 200);
    }

    public function updatePassword(Request $request)
    {
        try {
            //Validate
            $this->validate($request, [
                'old_password' => 'required',
                'new_password' => 'required|string|min:6',
                'confirm_password' => 'required|string|min:6'
            ]);

            // Get data user
            $user = Auth::user();

            // Cek password
            if (!Hash::check($request->old_password, $user->password)) {
                return ResponseFormatter::error([
                    'message' => 'Password lama tidak sesuai'
                ], 'Authentication Failed', 401);
            }

            // Cek password baru dan confirm password baru
            if ($request->new_password != $request->confirm_password) {
                return ResponseFormatter::error([
                    'message' => 'Password tidak sesuai'
                ], 'Authentication Failed', 401);
            }

            // update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return ResponseFormatter::success([
                'message' => 'Password Berhasil diUbah'
            ], 'Authentication', 200);
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function storeProfile(Request $request)
    {
        try {
            //validate
            $this->validate($request, [
                'first_name' => 'required',
                'image' => 'required|image|max:2048|mimes:png,jpg,jpeg'
            ]);

            // get data user
            $user = auth()->user();

            //uploud image
            $image = $request->file('image');
            $image->storeAs('public/profile', $image->hashName());

            //create profile
            $user->profile()->create([
                'first_name' => $request->first_name,
                'image' => $image->hashName()
            ]);

            //Get data profile
            $profile = $user->profile;

            return ResponseFormatter::success(
                $profile,
                'Profile berhasil di update'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'something Went Wrong',
                'error' => $error
            ], 'Authentication', 500);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            // Validate
            $this->validate($request, [
                'first_name' => '',
                'image' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Get user login
            $user = auth()->user();

            // Cek kondisi
            if (!$user->profile) {
                return ResponseFormatter::success([
                    'message' => 'Profile Not Found, Please Create Your profile first'
                ], 'Authentication', 404);
            }

            // Update profile
            if ($request->file('image') == '') {
                $user->profile->update([
                    'first_name' => $request->first_name
                ]);
                return ResponseFormatter::success([
                    'message' => 'First Name Berhasil di ubah'
                ], 'Authentication', 200);
            } else {

                if ($request->first_name == '') {
                    Storage::delete('public/profile/' . basename($user->profile->image));

                    // Store Image
                    $image = $request->file('image');
                    $image->storeAs('public/profile', $image->getClientOriginalName());
                    $user->profile->update([
                        $image = $request->file('image')
                    ]);
                } else {
                    // delete Image
                    Storage::delete('public/profile/' . basename($user->profile->image));

                    // Store Image
                    $image = $request->file('image');
                    $image->storeAs('public/profile', $image->getClientOriginalName());

                    // Update data
                    $user->profile->update([
                        'first_name' => $request->first_name,
                        'image' => $image->getClientOriginalName()
                    ]);
                }
            }



            return ResponseFormatter::success([
                'message' => ' First Name & Gambar Berhasil di ubah'
            ], 'Authentication', 200);
        } catch (\Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Authentication', 500);
        }
    }
}
