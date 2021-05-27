<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UsersModel extends Model{
    protected $table = 'users';

    public function __construct()
    {

        $this->fillable = [
            'id', 'role_id', 'first_name', 'last_name', 'email', 'username',
            'password',  'is_active','is_deleted','created_at', 'updated_at', 'is_active','created_by', 'updated_by'
        ];

        $this->created_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
        $this->updated_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
    }

    public function getUserList() {
        $query = DB::table('users')
        ->where('users.is_deleted', 'N')
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->select('users.*','roles.role_name')->get();   
        return $query;
    }   
     
    public function getSalesUserList() {
        $query = DB::table('users')
        ->where('users.is_deleted', 'N')
        ->where('users.role_id','!=', 1)
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->select('users.*','roles.role_name')->get();   
        return $query;
    }   
    public function getManagerUserList() {
        $query = DB::table('users')
        ->where('users.is_deleted', 'N')
        ->where('users.role_id','=', 6)
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->select('users.*','roles.role_name')->get();   
        return $query;
    }  

    public function getManagementUserList() {
        $query = DB::table('users')
        ->where('users.is_deleted', 'N')
        ->where('users.role_id','=', 7)
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->select('users.*','roles.role_name')->get();   
        return $query;
    }  

    public function getInstallationUserList() {
        $query = DB::table('users')
        ->where('users.is_deleted', 'N')
        ->where('users.role_id','=', 5)
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->select('users.*','roles.role_name')->get();   
        return $query;
    }  
    /**
     * This function is used to get record for edit
     */
    public function getUserRecordForEdit() {
        $userID = Session::get("loggedInUserId");
        $usersQueryResult = DB::table('users')
        ->where('users.id',$userID)
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->select('users.*','roles.role_name')->get();   
        return $usersQueryResult[0];
    }
	/**
     * This function is used to get record for edit
     */
    public function getUserRecordForEditByID($userID) {
        //userID = Session::get("loggedInUserId");
        $usersQueryResult = DB::table('users')
        ->where('users.id',$userID)
        ->join('roles', 'roles.id', '=', 'users.role_id')
        ->select('users.*','roles.role_name')->get();   
        return $usersQueryResult[0];
    }

    public function updateUserDetails($usersData) {
        $userObj = UsersModel::find($usersData['id']);
        $usersData['updated_by'] = Session::get("loggedInUserId");
        
        $isUpdated = $userObj->update($usersData);
        return $isUpdated;
    }

    public function softDeleteUser($userId) {
        $usersData = array();
        $userRecord = UsersModel::find($userId);
        $isUpdated = 0;
        if ($userRecord->is_deleted == "N") {
            $usersData['is_deleted'] = "Y";
            $usersData['is_active'] = 0;
            $isUpdated = $userRecord->update($usersData);
        }
        return $isUpdated;
    }
}