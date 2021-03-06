<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    public function register() {
        return view('frontend.pages.register');
    }

    public function save_register(Request $request)
    {
     
        $user = User::where('email', $request['email'])->first();

        if($user) {
            return response()->json(['exists' => 'Email already exists']);
        } else {
            $user = new User;
            $user->fname = $request['fname'];
            $user->lname = $request['lname'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
        }
        if($user->save()) {
            return response()->json(['success' => 'Data Submitted Successfully']);
        }
    }

    public function verify_phone_num($phone) {
        dd($phone);
        $userId = "";
        if(Auth::check()){
            $userId = Auth::user()->id;
        }
        $update = DB::table('users')->where('id', $userId)->update([
            'phone_verified' => 1,
            'contact_no' => $phone
        ]);
        if($update){
            echo json_encode('success'); die; 
        }
        echo json_encode('failed'); die; 
    }
}
