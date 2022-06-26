<?php

namespace App\Http\Controllers\Auth;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function handleGoogleLogin(request $request)
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(request $request)
    {
        DB::beginTransaction();
        try {
            $user = Socialite::driver('google')->user();

            $checkCorreo = User::where('email', $user->email)->first();
            if ($checkCorreo) {
                Auth::login($checkCorreo);
                return redirect()->action('App\Http\Controllers\LandingController@index');
            } else {
                return view('auth.register', compact('user'));
                // $newUser = new user;
                // $newUser->name = $user->name;
                // $newUser->email = $user->email;
                // $newUser->password = Hash::make($user->id);
                // $newUser->id_role = '2'; //ROL DE CLIENTE 
                // // $newUser->address = 'Sin dirección';
                // $newUser->phone = '0';
                // $newUser->save();

                // Auth::login($newUser);
                // DB::connection(session()->get('database'))->commit();
                // return redirect()->action('App\Http\Controllers\LandingController@index');
            }
        } catch (\Throwable $th) {
            DB::connection(session()->get('database'))->rollBack();
            return back()->withErrors(['message' => 'Ocurrió un error al iniciar sesión']);
            //throw $th;
        }
    }
}
