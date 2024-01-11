<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ParentController extends Controller
{
    public function login() {
    
        return view('auth.parent-login');
    }

    public function auth(Request $request) {
        $validator = Validator::make($request->all(), [
            'nis' => ['required', 'numeric'],
            'password' => ['required']
        ], [
            'nis.required' => 'NIS diperlukan',
            'nis.numeric' => 'NIS tidak valid',
            'password.required' => 'Password diperlukan'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $credentials = $validator->validated();

        if (!Auth::guard('parent')->attempt($credentials)) {
            return redirect()->back()->withErrors(['unathenticated', 'NIS atau Password salah']);
        }

        return redirect()->route('parent.home');
    }

    public function home() {
        

        return view('parent-home');
    }
}
