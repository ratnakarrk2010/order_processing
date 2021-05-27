<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class MenuMasterModel extends Model{
    protected $table = 'menu_master';

    public function __construct()
    {

        $this->fillable = [
            'id', 'menu_name', 'menu_path','menu_icon','href','menu_type','parent_menu_id',
            'menu_status','created_at', 'updated_at','created_by','updated_by'
        ];

        $this->created_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
        $this->updated_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
    }
    
        
    /**
	 * function to Fetch Cities
	 */
	public function getAllMenus()
	{
		$menuQry = DB::table('menu_master')
        ->where('menu_master.menu_status', '1')
        ->join('users','users.id' ,'=', 'menu_master.created_by')
        ->select('menu_master.*','users.first_name','users.last_name')->get();   
        //$allRoles = $roleQry->get();
		return $menuQry;
	}
    public function getAllMenusActiveInactive()
	{
		$menuQry = DB::table('menu_master')
        ->join('users','users.id' ,'=', 'menu_master.created_by')
        ->select('menu_master.*','users.first_name','users.last_name')->get();   
        //$allRoles = $roleQry->get();
		return $menuQry;
	}
    public function getAllSubMenu($parentMenuId)
	{
		$subMenuQry = DB::table('menu_master')
        ->where('menu_master.menu_type', '2')
        ->where('menu_master.parent_menu_id', $parentMenuId )
        ->select('menu_master.*')->get();   
        return $subMenuQry;
	}
    public function getAllParentMenus()
	{
		$parentMenuQry = DB::table('menu_master')
        ->where('menu_master.menu_status', '1')
        ->where('menu_master.menu_path', '#')
        ->select('menu_master.*')->get();   
		return $parentMenuQry;
	}
       
    public function updateMenuDetails($menuData) {
        $menuObj = MenuMasterModel::find($menuData['id']);
        $menuData['updated_by'] = Session::get("loggedInUserId");
        
        $isUpdated = $menuObj->update($menuData);
        return $isUpdated;
    }


    public function softDeleteMenu($menuId){
        
            $menuData = array();
            $menuRecord = MenuMasterModel::find($menuId);
            $isUpdated = 0;
            if ($menuRecord->menu_status == "1") {
                $menuData['menu_status'] = "0";
                $isUpdated = $menuRecord->update($menuData);
            }
            return $isUpdated;
    }
    
}