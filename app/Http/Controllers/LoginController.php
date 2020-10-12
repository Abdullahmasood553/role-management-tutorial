<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
        public function login() {
            return view('frontend.pages.login');
        }


        public function user_login(Request $request) {
            if (Auth::attempt([
                'email' => $request->input('email'),
                'password' => $request->input('password')])) {
                $user = Auth()->user();
                if ($user) {
                    return response()->json(['success' => 'Successfully Logged In']);
                }
            } else {
                return response()->json(['error'=> 'Something went wrong']);
            }
        }
}
