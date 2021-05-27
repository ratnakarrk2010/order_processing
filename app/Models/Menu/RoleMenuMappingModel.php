<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class RoleMenuMappingModel extends Model{

    
    protected $table = 'role_menu_mapping';

    public function __construct()
    {

        $this->fillable = [
            'id', 'role_id', 'role_description','menu_id','mapping_status','created_at', 
            'updated_at','created_by', 'updated_by'
        ];
       /* $this->fillable = [
            'id', 'role_id', 'menu_id', 'mapping_status', 'created_at', 'updated_at','created_by', 'updated_by'
        ];*/

        $this->created_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
        $this->updated_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
    }
    
        
    /**
	 * function to Fetch Cities
	 */
	public function getAllRoleMenuMapping()
	{
		$roleQry = DB::table('role_menu_mapping')
        ->where('role_menu_mapping.mapping_status', '1')
        ->join('users','users.id' ,'=', 'role_menu_mapping.created_by')
        ->select('role_menu_mapping.*','users.first_name','users.last_name')->get();   
        //$allRoles = $roleQry->get();
		return $roleQry;
	}
    public function getAllRoleMenuMappingList()
	{
		$rolemenuQry = DB::table('role_menu_mapping')
        ->join('users','users.id' ,'=', 'role_menu_mapping.created_by')
        ->join('roles', 'roles.id', '=', 'role_menu_mapping.role_id')
        ->join('menu_master', 'menu_master.id', '=', 'role_menu_mapping.menu_id')
        ->select('role_menu_mapping.*','users.first_name','users.last_name', 'roles.role_name', 'menu_master.menu_name')->get();   
        return $rolemenuQry;
       
	}
   
    public function updateRoleMenuMapDetails($roleMenuMapData) {
        $roleManuMapObj = RoleMenuMappingModel::find($roleMenuMapData['id']);
        $roleMenuMapData['updated_by'] = Session::get("loggedInUserId");
        
        $isUpdated = $roleManuMapObj->update($roleMenuMapData);
        return $isUpdated;
    }


    public function softDeleteRoleMenuMap($roleId){
        
            $roleData = array();
            $roleRecord = RoleMenuMappingModel::find($roleId);
            $isUpdated = 0;
            if ($roleRecord->mapping_status == "1") {
                $roleData['mapping_status'] = "0";
                $isUpdated = $roleRecord->update($roleData);
            }
            return $isUpdated;
    }
    
}
       

