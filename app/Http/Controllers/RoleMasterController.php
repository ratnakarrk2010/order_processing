<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Role\RoleModel;
use App\Http\Controllers\CommonController;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Users\UsersModel;

class RoleMasterController extends CommonController
{
    public function index(Request $request) {
        $roleModel = new RoleModel();
        $allRoles = $roleModel-> getAllUsersRole();
        $this->data['allRoles'] = $allRoles;
        return View::make("master.role_list", $this->data);
    }

    public function saveRole(Request $request) {
        try {
                $roleModel = new RoleModel() ;
                $roleModel->role_name = $request->input('role_name');
                $roleModel->role_description = $request->input('role_description');
                $roleModel->created_by = Session::get("loggedInUserId");
                $isSaved = $roleModel->save();
                //Log::info("IsSaved==>" . $isSaved);
                if ($isSaved) {
                    return back()->with('success', 'Role Created Successfully!');
                }
            } catch (Exception $e) {
                Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
                return back()->with('error', 'Something went wrong...!');
                Log::error($e);
            }

    }

    public function deleteRole(Request $request, $userId){
        try {
            $roleModel = new RoleModel() ;
            $isUpdated = $roleModel->softDeleteRole($userId);
            $allRoles = $roleModel-> getAllUsersRole();
            $this->data['allRoles'] = $allRoles;
            
            if($isUpdated) {
                $this->data['success_message'] = "Users Deleted Successfully!";
            }else {
                $this->data['error_message'] = "Something went wrong while deleting the Users Data!";
            }
            return View::make("master.role_list", $this->data);
        } catch(Exception $e) {
            $allRoles = $roleModel-> getAllUsersRole();
            $this->data['allRoles'] = $allRoles;
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('master.role_list', $this->data);
        }
    }
    public function updateRoleDetails(Request $request){
        try {
            //$roleId = $request->input('id');
            $roleData = $request->all();
            $roleModel = new RoleModel() ;
            $isUpdated = $roleModel->updateRoleDetails($roleData);
            if($isUpdated) {
                return back()->with('success', 'Role Created Successfully!');
            }

            Log::info("roleData==>".json_encode($roleData));
            return View::make('master.role_list', $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            //return View::make('orders.add_installation', $this->data);
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }

    public function getRoleWiseUsers(Request $request, $roleId) {
        try {
            $users = UsersModel::where('role_id', $roleId)->get();
            return response()->json(array("users" => $users), 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(array('message' => "Something went wrong!", 'exception' => $e->getMessage()), 400);
        }
    }
}
