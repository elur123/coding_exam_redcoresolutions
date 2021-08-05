<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
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

        $user = User::where('email', $request->email)
        ->first();

        if ($user !== null) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json(['success' => true, "user" => $user], 200);
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
