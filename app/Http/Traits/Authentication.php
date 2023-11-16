<?php

namespace App\Http\Traits;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait Authentication{
    
    public function logout()
    {
        Auth::guard('web')->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect('/');
    }


    // Open for Conditional Customer and Admin Future Features.
    // Possible Use case technique will be used.
    
    protected function authenticate(array $data){
        if( $this->attempt($data) ){
            request()->session()->regenerate();

            return redirect()->intended($this->getUserIntendedDashboard());
        }

        return back()->withErrors([
            'username' => 'Credentials does not match in our records',
        ]);
    }

    protected function attempt(array $data){
        return Auth::attempt(['username' => $data['username'], 'password' => $data['password']], $data['remember'] ?? 0 );
    }

    protected function getUserIntendedDashboard(){
        $intended = request()->user()->isAdmin ? 'admin.dashboard.containers' : 'dashboard.profile';

        return route($intended); 
    }
}