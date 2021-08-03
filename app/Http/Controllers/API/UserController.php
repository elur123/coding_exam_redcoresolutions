<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    function index(){
        $users = DB::table('users')
        ->select('users.*', 'roles.role_name')
        ->leftJoin('roles', 'users.role_id', 'roles.id')
        ->get();

        return $users;
    }

    function details($id){
        $details = DB::table('users')
        ->where('id', $id)
        ->first();

        return $details;
    }

    function create(Request $request){
        $this->validate($request, [
            'fullname' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|confirmed',
            'role_id' => 'required'
        ]);

        $create = DB::table('users')
        ->insert([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_confirmation' => Hash::make($request->password_confirmation),
            'role_id' => $request->role_id,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if ($create) {
            return response()->json(["success" => true, "users" => $this->index()], 200);
        }
        else{
            return response()->json(["success" => false, "users" => $this->index()], 500);
        }
    }

    function update(Request $request, $id){
        $this->validate($request, [
            'role_name' => 'required',
            'description' => 'required'
        ]);

        $update = DB::table('users')
        ->where('id', '!=', $id)
        ->update([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'password_confirmation' => Hash::make($request->password_confirmation),
            'role_id' => $request->role_id,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($update) {
            return response()->json(["success" => true, "users" => $this->index()], 200);
        }
        else{
            return response()->json(["success" => false, "users" => $this->index()], 500);
        }
    }

    function delete($id){
        $delete = DB::table('users')
        ->where('id', '!=', $id)
        ->delete();

        if ($delete) {
            return response()->json(["success" => true, "users" => $this->index()], 200);
        }
        else{
            return response()->json(["success" => false, "users" => $this->index()], 500);
        }
    }
}
