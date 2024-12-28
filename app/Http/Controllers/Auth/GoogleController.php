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
            $googleUser = Socialite::driver('google')->stateless()->user(); 
            
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $names = explode(' ', $googleUser->name);
                $firstName = $names[0] ?? '';
                $lastName = $names[1] ?? '';

                $user = User::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(16)),
                    'role' => 0,
                ]);
            } else {
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            }
            dd($user);
            Auth::login($user);

            return redirect()->intended(route('home'));

        } catch (Exception $e) {
            return redirect()->route('login')
                ->with('error', 'Something went wrong with Google login: ' . $e->getMessage());
        }
    }
}