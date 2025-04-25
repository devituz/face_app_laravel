<?php

namespace App\Http\Controllers\Frontend\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class LoginController extends Controller
{


    public function __construct()
    {
        // Auth foydalanuvchi ma'lumotlarini har bir view bilan ulash
        view()->share('user', Auth::user());
    }

    public function profile()
    {
        return view('components.sidebar');
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('candidatelist.index');
        }
        return back()->withErrors(['error' => 'Email or password is incorrect']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
