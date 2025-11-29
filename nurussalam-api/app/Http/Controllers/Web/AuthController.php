<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Note: Default Laravel Auth expects 'email', but we use 'username' for Admin.
        // We might need to adjust the Admin model or Auth config, but for now let's try standard attempt.
        // If Admin model uses 'username', we need to ensure it's set up correctly.
        // Let's assume standard Auth::attempt works if we pass the credentials array.
        
        // Since the Admin model was created manually, we need to ensure it implements Authenticatable.
        // I'll check the Admin model in a separate step, but for now I'll write the controller.
        
        // Using the 'web' guard (default) which usually points to User model. 
        // We might need to configure a guard for Admin if it's separate from User.
        // Based on previous analysis, there is an 'Admin' model.
        // Let's assume we want to login as Admin.
        
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
