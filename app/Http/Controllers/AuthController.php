<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) { // Перевіряємо, чи введені облікові дані правильні
            return redirect()->intended('/'); // Якщо успішно, перенаправляємо користувача на запитувану сторінку або на головну
        } else {
            return redirect()->back() // Якщо автентифікація не вдалася, повертаємо користувача назад
                ->with('error', 'Invalid credentials'); // Додаємо флеш-повідомлення про помилку 
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
