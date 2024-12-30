<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            // Retrieve user from Google
            $googleUser = Socialite::driver('google')->stateless()->user();
            // Attempt to find an existing user by Google ID or email
            $existingUser = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();
            if ($existingUser) {
                // Update Google ID if the user was found by email
                if ($existingUser->google_id !== $googleUser->id) {
                    $existingUser->google_id = $googleUser->id;
                    $existingUser->save();
                }
                Auth::login($existingUser);

            } else {
                $names = explode(' ', $googleUser->name);
                $firstName = $names[0] ?? '';
                $lastName = $names[1] ?? '';
                
                // Create a new user
                $createUser = User::create([
                    'first_name' => $firstName,
                    'last_name'=> $lastName,
                    'email' => $googleUser->email,
                    'phone'=> '00000000',
                    'google_id' => $googleUser->id,
                    'role' => 0,
                    'password' => bcrypt(Str::random(16)),
                ]);
                Auth::login($createUser);
            }
            return redirect()->to('/');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}