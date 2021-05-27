<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RoleModel extends Model{
    protected $table = 'roles';

    public function __construct()
    {

        $this->fillable = [
            'id', 'role_name', 'role_description','is_deleted','created_at', 'updated_at','created_by', 
            'updated_by'
        ];

        $this->created_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
        $this->updated_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
    }
    
        
    /**
	 * function to Fetch Cities
	 */
	public function getAllUsersRole()
	{
		$roleQry = DB::table('roles')
        ->where('roles.is_deleted', 'N')
        ->join('users','users.id' ,'=', 'roles.created_by')
        ->select('roles.*','users.first_name','users.last_name')->get();   
        //$allRoles = $roleQry->get();
		return $roleQry;
	}
    public function getCustomerList() {
        $query = DB::table('customer_details')
        ->where('customer_details.is_deleted', 'N')
        ->select('customer_details.*')->get();   
        return $query;
    }  
    
    public function updateRoleDetails($roleData) {
        $roleObj = RoleModel::find($roleData['id']);
        $roleData['updated_by'] = Session::get("loggedInUserId");
        
        $isUpdated = $roleObj->update($roleData);
        return $isUpdated;
    }


    public function softDeleteRole($roleId){
        
            $roleData = array();
            $roleRecord = RoleModel::find($roleId);
            $isUpdated = 0;
            if ($roleRecord->is_deleted == "N") {
                $roleData['is_deleted'] = "Y";
                $isUpdated = $roleRecord->update($roleData);
            }
            return $isUpdated;
    }
    
}