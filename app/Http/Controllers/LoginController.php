<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Logout con log
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            Log::info("LOGOUT: Utente {$user->email} (ID: {$user->id}) si è disconnesso da IP: {$request->ip()}");
        }
        Auth::logout();
        return redirect('/');
    }
}