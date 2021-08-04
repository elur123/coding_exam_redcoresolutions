<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
class LoginController extends Controller
{
    function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $check = DB::table('users')
        ->where('email', $request->email)
        ->first();

        if ($check !== null) {
            if (Hash::check($request->password, $check->password)) {
                return response()->json(['success' => true, "user" => $check], 200);
            }
            else{
                return response()->json(['success' => false, "user" => null], 500);
            }
        }
        else{
            return response()->json(['success' => false, "user" => null], 500);
        }
    }
}
