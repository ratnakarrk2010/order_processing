<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Menu\RoleMenuMappingModel;

class MenuModel extends Model {
    protected $table = 'menu_master';

    public function __construct()
    {
        $this->fillable = [
            'id', 'menu_name', 'menu_path', 'menu_icon','href', 'menu_type', 'parent_menu_id', 'menu_status', 
            'created_at', 'updated_at','created_by', 'updated_by'
        ];
    }

    public function getAllMenus($roleId) {
        $menus = MenuModel::leftJoin('role_menu_mapping', function($join) use ($roleId) {
            $join->on('role_menu_mapping.menu_id', '=', 'menu_master.id')->where('role_menu_mapping.role_id', '=', $roleId);
        })->where('menu_type', 1)->select('menu_master.id', 'menu_master.menu_name',
        'menu_master.menu_path', 'menu_master.menu_icon', 'menu_master.href', 'menu_master.menu_type',
        'menu_master.parent_menu_id', 'menu_master.menu_status', 'role_menu_mapping.mapping_status')->orderBy('id',
        'ASC')->get();
        $menuList = array();
        foreach ($menus as $menu) {
            $subMenus = MenuModel::leftJoin('role_menu_mapping', function($join) use ($roleId) {
                $join->on('role_menu_mapping.menu_id', '=', 'menu_master.id')->where('role_menu_mapping.role_id', '=',
                $roleId);
            })->where(array(array('menu_type', '=', 2), array('parent_menu_id', '=',
            $menu->id)))->select('menu_master.id', 'menu_master.menu_name',
            'menu_master.menu_path', 'menu_master.menu_icon', 'menu_master.href', 'menu_master.menu_type',
            'menu_master.parent_menu_id', 'menu_master.menu_status', 'role_menu_mapping.mapping_status')->orderBy('id',
            'ASC')->get();
            $menu->subMenus = $subMenus;

            array_push($menuList, $menu);
        }
        return $menuList;
    }

    public function updateMenuMaping($data) {
        $assignedMainMenus = array();
        $assignedSubMenus = array();
        if (isset($data['chkMainMenu'])) {
            $assignedMainMenus = $data['chkMainMenu'];
        }

        if (isset($data['chkSubMenu'])) {
            $assignedSubMenus = $data['chkSubMenu'];
        }

        $allAssignedMenus = array();
        foreach ($assignedMainMenus as $mainMenuId) {
            array_push($allAssignedMenus, $mainMenuId);
        }
        foreach ($assignedSubMenus as $subMenuId) {
            array_push($allAssignedMenus, $subMenuId);
        }

        Log::info("allAssignedMenus: " . json_encode($allAssignedMenus));

        foreach ($allAssignedMenus as $menuId) {
            $role_menu_mapping_arr = RoleMenuMappingModel::where('role_id', $data['role_id'])->where('menu_id', $menuId)->get();
            $role_menu_mapping = null;
            if ($role_menu_mapping_arr && sizeof($role_menu_mapping_arr) > 0) {
                $role_menu_mapping = $role_menu_mapping_arr[0];
            }
            if ($role_menu_mapping) {
                Log::info("Updating role_menu_mapping having id: " . $role_menu_mapping->id . " Menu Id: " . $menuId);
                $role_menu_mapping->update(array('mapping_status' => 1, 'updated_by' => Session::get("loggedInUserId"), 'updated_at' => date('Y-m-d H:i:s')));
            } else {
                Log::info("Creating role_menu_mapping having Menu Id: " . $menuId);

                $role_menu_mapping = new RoleMenuMappingModel();
                $role_menu_mapping->menu_id = $menuId;
                $role_menu_mapping->role_id = $data['role_id'];
                $role_menu_mapping->mapping_status = 1;
                $role_menu_mapping->created_by = Session::get("loggedInUserId");
                $role_menu_mapping->created_at = date('Y-m-d H:i:s');

                $role_menu_mapping->save();
            }
        }

        if (sizeof($allAssignedMenus) > 0) {
            $role_menu_mappings = RoleMenuMappingModel::where('role_id', $data['role_id'])->whereNotIn('menu_id', $allAssignedMenus)->get();
        } else {
            $role_menu_mappings = RoleMenuMappingModel::where('role_id', $data['role_id'])->get();
        }
        foreach ($role_menu_mappings as $mapping) {
            Log::info("Updating role_menu_mapping having id: " . $mapping->id . " Menu Id: " . $mapping->menu_id);
            $updateArr = array();
            $updateArr['mapping_status'] = 0;
            $mapping->update($updateArr);
            //$mapping->update(array('mapping_status' => 0, 'updated_by' => Session::get("loggedInUserId"), 'updated_at' => date('Y-m-d H:i:s')));
        }
    }
}
