<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function loginform()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try{
            $credentials = $request->only('email', 'password');
            if (auth()->attempt($credentials)) {
                Alert::toast('Login successful!', 'success');
                return redirect()->route('dashboard');
            }

            Alert::toast('Invalid credentials', 'error');
            return back()->withErrors(['email' => 'Invalid credentials']);
        } catch (\Exception $e) {
            Alert::toast('An error occurred', 'error');
            return back()->withErrors(['email' => 'An error occurred']);
        }
    }
    public function logout()
    {
        auth()->logout();
        Alert::toast('Logout successful!', 'success');
        return redirect()->route('login');
    }
}
