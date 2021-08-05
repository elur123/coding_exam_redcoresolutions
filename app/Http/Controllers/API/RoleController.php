<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Role;
class RoleController extends Controller
{
    function index(){
        return Role::all();;
    }

    function details($id){
        return Role::find($id);
    }

    function create(Request $request){
        $this->validate($request, [
            'role_name' => 'required|unique:roles',
            'description' => 'required'
        ]);

        $role = new Role;
        $role->role_name = $request->role_name;
        $role->description = $request->description;
        $role->save();

        return response()->json(["success" => true, "roles" => $this->index()], 200);
    }

    function update(Request $request, $id){
        $this->validate($request, [
            'role_name' => 'required|unique:roles,role_name,'.$id,
            'description' => 'required'
        ]);

        $role = Role::find($id);
        $role->role_name = $request->role_name;
        $role->description = $request->description;
        $role->save();

        return response()->json(["success" => true, "roles" => $this->index()], 200);
    }

    function delete($id){
        $role = Role::find($id);
        $role->delete();

        return response()->json(["success" => true, "roles" => $this->index()], 200);
    }
}
