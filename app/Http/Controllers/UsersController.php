<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Users\UsersModel;
use App\Models\Role\RoleModel;
use App\Http\Controllers\CommonController;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Exports\UserExport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Redirect;
class UsersController extends CommonController
{
    //
    public function __construct(){
        parent::__construct();
    }

    public function index() {
        $roleModel = new RoleModel();
        $allRoles = $roleModel-> getAllUsersRole();
        $this->data['allRoles'] = $allRoles;
        return View::make('users.add_new_user', $this->data);
    }
    
    /**"
     * Save users
     */
    
    public function createUser(Request $request)
    {
        try {
            
            $roleModel = new RoleModel();
            $allRoles = $roleModel-> getAllUsersRole();
            $this->data['allRoles'] = $allRoles;

            $usersModel = new UsersModel();
            $usersModel->first_name = $request->input('first_name');
            $usersModel->last_name = $request->input('last_name');
            $usersModel->email = $request->input('email');
            $usersModel->username = $request->input('username');
            //$usersModel->password =  Hash::make(Str::random(8));
            $usersModel->password = md5($request->input('password'));
            $usersModel->created_by = Session::get("loggedInUserId");
            $usersModel->role_id = $request->input("role_id");
            $isSaved = $usersModel->save();
          
            Log::info("IsSaved==>" . $isSaved);
            if ($isSaved) {
                //$this->data['success_message'] = "User Created Successfully!";
                //return View::make('users.add_new_user', $this->data);
                return back()->with('success', 'User Created Successfully!');
            }
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            //$this->data['exception_message'] = "Something went wrong...";
            //return View::make('users.add_new_user', $this->data);
            return back()->with('error', 'Something went wrong...!');
            Log::error($e);
        }
    }
    
     /**
     * This method is used to fetch all astrologers list
     */
    public function list(Request $request)
    {
        try {
            $usersModel = new UsersModel();
            $usersList = $usersModel->getUserList();
            Log::info("userList==>".json_encode($usersList));
            $this->data['userLists'] = $usersList;
            return View::make('users.all_users', $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('users.all_users', $this->data);
            Log::error($e);
        }
    }
     /**
     * This function is used to get record for edit details
     */
    public function edit($userId) {
        try {
           
            $roleModel = new RoleModel();
            $allRoles = $roleModel-> getAllUsersRole();
            $this->data['allRoles'] = $allRoles;
                   
            $usersModel = new UsersModel();
            $usersData = $usersModel->getUserRecordForEditByID($userId);
            $this->data['usersData'] = $usersData;
            return View::make('users.edit_user', $this->data);
        } catch(Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('users.edit_user', $this->data);
        }
    }
    public function update(Request $request){
        try {
            $usersData = $request->all();
            $usersModel = new UsersModel();
            $isUpdated = $usersModel->updateUserDetails($usersData);
            Log::info("isUpdated==>".$isUpdated);
            $usersList = $usersModel->getUserList();
            $this->data['userLists'] = $usersList;
            
            if($isUpdated) {
                $this->data['success_message'] = "Users Data Updated Successfully!";
            }else {
                $this->data['error_message'] = "Something went wrong while updating the Users Data!";
            }
            //return Redirect::back()->with(['success', 'Users Data Updated Successfully!']);
            //return back()->with('success', 'Users Data Updated Successfully!');
            //return redirect('/all/user');
            return View::make('users.all_users', $this->data);

        } catch(Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return back()->with('error', 'Something went wrong...!');
            //return View::make('users.all_users', $this->data);
        }
    }
    public function deleteUser(Request $request, $userId){
        try {
            $usersModel = new UsersModel();
            $isUpdated = $usersModel->softDeleteUser($userId);
            $usersList = $usersModel->getUserList();
            $this->data['userLists'] = $usersList;
            
            if($isUpdated) {
                $this->data['success_message'] = "Users Deleted Successfully!";
            }else {
                $this->data['error_message'] = "Something went wrong while deleting the Users Data!";
            }
            return View::make('users.all_users', $this->data);
        } catch(Exception $e) {
            $usersList = $usersModel->getUserList();
            $this->data['userLists'] = $usersList;
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('users.all_users', $this->data);
        }
    }

    public function excel() 
    {
        return Excel::download(new UserExport, 'user_data.xlsx');
    }

    public function getUserRecordForUpdate(){
       
        $usersModel = new UsersModel();
        $usersData = $usersModel->getUserRecordForEdit();
        $this->data['usersData'] = $usersData; 
        return View::make('users.user_profile', $this->data);
    }

    public function changeUserPassword(Request $request) {

        $loggedInUserId = Session::get("loggedInUserId");
        $user = UsersModel::find($loggedInUserId);
        $current_password =  md5($request->input('password'));
        $new_password =  md5($request->input('new_password'));
        $confirm_password =  md5($request->input('confirm_password'));

        if ($user->password == $current_password) {
            if ($new_password == $confirm_password) {
                // Change Password
                $isUpdated = $user->update(array("password" => $new_password));
                if ($isUpdated) {
                    // Return view with success
                   // return View::make('users.user_profile', $this->data);
                    return back()->with('success', 'Password Updated Successfully!');
                } else {
                    return back()->with('error', 'Something Went Wrong!');
                }
            } else {
                // Return view with error: New password doesn't match with confirm password
                return back()->with('error', "New password doesn't match with confirm password!");
            }
        } else {
            // Return view with error: Invalid password. Please enter correct old password
            return back()->with('error', "Invalid password. Please enter correct old password!");
        }

    }
    public function updateLoggedInUserProfile(Request $request){
        try {
            $usersData = $request->all();
            $usersModel = new UsersModel();
            $isUpdated = $usersModel->updateUserDetails($usersData);
            Log::info("isUpdated==>".$isUpdated);
            $usersList = $usersModel->getUserList();
            $this->data['userLists'] = $usersList;
            
            if($isUpdated) {
                $this->data['success_message'] = "Users Data Updated Successfully!";
                return back()->with('success', 'Users Profile Updated Successfully!');
            }else {
                $this->data['error_message'] = "Something went wrong while updating the Users Data!";
                return back()->with('error', "Something went wrong while updating the Users Data!");
            }
            
          
        } catch(Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return back()->with('error', 'Something went wrong...!');
            //return View::make('users.all_users', $this->data);
        }
    }

    /**
     * This method is used to check the email is already exist or not
     */
    public function checkEmail(Request $request) {
        if($request->get('username')){
             $username = $request->get('username');
             $qry = DB::table('users')
                    ->where('username', $username)
                    ->count();
            if($qry > 0){
                return response()->json(array('msg' => 'not unique'), 200);
            } else{
                return response()->json(array('msg' => 'unique'), 200);
            }
        }
    }

   
}