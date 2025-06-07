<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        return view('login');
    }
    function login(Request $request)
    {
        $request->validate(
            [
                'NIS' => 'required',
                'password' => 'required'
            ],
            [
                'NIS.required' => 'NIS/NIP harus diisi',
                'password.required' => 'Password harus diisi',
            ]
        );

        $infologin = [
            'NIS' => $request->NIS,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin)) {
            return redirect('/index');
        } else {
            return redirect('')->withErrors('NIS/NIP dan password yang dimasukkan tidak sesuai')->withInput();
        }
    }
    public function lupaPassword()
    {
        return view('lupaPassword');
    }
}
