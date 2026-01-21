<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        // VULNERABILE 
        Auth::user()->update($request->all());

        return redirect()->back()->with('message', 'Profilo aggiornato!');
    }
}