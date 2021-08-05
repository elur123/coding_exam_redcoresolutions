<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\User;
class UserController extends Controller
{
    function index(){
        return User::with('role:id,role_name')->get();
    }

    function details($id){
        return User::find($id);
    }

    function create(Request $request){
        $this->validate($request, [
            'fullname' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'role_id' => 'required'
        ]);

        $user = new User;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->password_confirmation = Hash::make($request->password_confirmation);
        $user->role_id = $request->role_id;
        $user->created_at = date('Y-m-d H:i:s');
        $user->save();

        return response()->json(["success" => true, "users" => $this->index()], 200);
    }

    function update(Request $request, $id){
        $this->validate($request, [
            'fullname' => 'required|unique:users,fullname,'. $id,
            'email' => 'required|email|unique:users,email,'. $id,
            'role_id' => 'required'
        ]);

        $user = User::find($id);

        if ($request->password != null) {
            $this->validate($request, [
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password',
            ]);

            $user->password = $request->password;
            $user->password_confirmation = $request->password_confirmation;
        }

        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->updated_at = date('Y-m-d H:i:s');
        $user->save();

        return response()->json(["success" => true, "users" => $this->index()], 200);
    }

    function delete($id){
        $user = User::find($id);
        $user->delete();

        return response()->json(["success" => true, "users" => $this->index()], 200);
    }
}
