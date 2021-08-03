<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class RoleController extends Controller
{
    function index(){
        $roles = DB::table('roles')
        ->get();

        return $roles;
    }

    function details($id){
        $details = DB::table('roles')
        ->where('id', $id)
        ->first();

        return $details;
    }

    function create(Request $request){
        $this->validate($request, [
            'role_name' => 'required',
            'description' => 'required'
        ]);

        $create = DB::table('roles')
        ->insert([
            'role_name' => $request->role_name,
            'description' => $request->description,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if ($create) {
            return response()->json(["success" => true, "roles" => $this->index()], 200);
        }
        else{
            return response()->json(["success" => false, "roles" => $this->index()], 500);
        }
    }

    function update(Request $request, $id){
        $this->validate($request, [
            'role_name' => 'required',
            'description' => 'required'
        ]);

        $update = DB::table('roles')
        ->where('id', '!=', $id)
        ->update([
            'role_name' => $request->role_name,
            'description' => $request->description,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($update) {
            return response()->json(["success" => true, "roles" => $this->index()], 200);
        }
        else{
            return response()->json(["success" => false, "roles" => $this->index()], 500);
        }
    }

    function delete($id){
        $delete = DB::table('roles')
        ->where('id', '!=', $id)
        ->delete();

        if ($delete) {
            return response()->json(["success" => true, "roles" => $this->index()], 200);
        }
        else{
            return response()->json(["success" => false, "roles" => $this->index()], 500);
        }
    }
}
