<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return Inertia::render('Authentication/Login');
    }

    public function login(Request $request){

        $request->validate([
            'password' => 'required|string',
            'username' => 'required|string',
        ]);

        $data = $request->all();

        if(Auth::attempt(['username' => $data['username'], 'password' => $data['password']], $data['remember'])){
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard.containers'));
        }
        else if(Auth::attempt(['email' => $data['username'], 'password' => $data['password']], $data['remember'])){
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard.containers'));
        }

        return back()->withErrors([
            'username' => 'Credentials does not match in our records',
        ]);
    }
    
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
