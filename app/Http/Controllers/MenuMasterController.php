<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Menu\MenuMasterModel;
use App\Models\Menu\RoleMenuMappingModel;
use App\Models\Role\RoleModel;
use App\Http\Controllers\CommonController;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class MenuMasterController extends CommonController
{
    public function index(Request $request) {
        $menuModel = new MenuMasterModel();
        $allMenus = $menuModel-> getAllMenus();
        $this->data['allMenusMaster'] = $allMenus;
        $allParentMenus = $menuModel-> getAllParentMenus();
        $this->data['allParentMenus'] = $allParentMenus;
        return View::make("master.menu_master", $this->data);
    }

    public function saveMenu(Request $request) {
        try {
                $menuModel = new MenuMasterModel() ;
                
                $menuModel->menu_name = $request->input('menu_name');
                $menuModel->menu_path = $request->input('menu_path');
                $menuModel->menu_icon = $request->input('menu_icon');
                $menuModel->menu_type = $request->input('menu_type');
                $menuModel->href = $request->input('href');
                $menuModel->parent_menu_id = $request->input('parent_menu_id');
                $menuModel->created_by = Session::get("loggedInUserId");
                $isSaved = $menuModel->save();
                if ($isSaved) {
                    return back()->with('success', 'Menu Created Successfully!');
                }
            } catch (Exception $e) {
                Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
                return back()->with('error', 'Something went wrong while save Menu...!');
                Log::error($e);
            }

    }

    public function menuMappingList(Request $request) {
        $roleModel = new RoleModel();
        $allRoles = $roleModel->getAllUsersRole();
        $this->data['allRoles'] = $allRoles;

        $menuModel = new MenuMasterModel();
        $allMenus = $menuModel->getAllMenusActiveInactive();
        $this->data['allMenusMaster'] = $allMenus;

        $roleMenuMapModel = new RoleMenuMappingModel();
        $menuMappingList = $roleMenuMapModel->getAllRoleMenuMappingList();
        $this->data['menuMappingList'] = $menuMappingList;

        return View::make("master.role_menu_map", $this->data);
    }
    public function saveRoleMenuMap(Request $request) {
        try {
                $roleMenuMapModel = new RoleMenuMappingModel() ;
                
                $roleMenuMapModel->menu_id = $request->input('menu_id');
                $roleMenuMapModel->role_id = $request->input('role_id');
                $roleMenuMapModel->created_by = Session::get("loggedInUserId");
                $isSaved = $roleMenuMapModel->save();
                if ($isSaved) {
                    return back()->with('success', 'Role Menu Mapping Created Successfully!');
                }
            } catch (Exception $e) {
                Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
                return back()->with('error', 'Something went wrong while save Menu Mapping...!');
                Log::error($e);
            }

            
    }
    public function deleteRoleMap(Request $request, $roleMapId){
        try {
            $roleMenuMapModel = new RoleMenuMappingModel();
            $isUpdated = $roleMenuMapModel->softDeleteRoleMenuMap($roleMapId);
            $roleModel = new RoleModel();
            $allRoles = $roleModel->getAllUsersRole();
            $this->data['allRoles'] = $allRoles;
    
            $menuModel = new MenuMasterModel();
            $allMenus = $menuModel->getAllMenusActiveInactive();
            $this->data['allMenusMaster'] = $allMenus;
    
            $menuMappingList = $roleMenuMapModel->getAllRoleMenuMappingList();
            $this->data['menuMappingList'] = $menuMappingList;
            
            if($isUpdated) {
                $this->data['success_message'] = "Role Mapping Deleted Successfully!";
            }else {
                $this->data['error_message'] = "Something went wrong while deleting the role map Data!";
            }
            return View::make("master.role_menu_map", $this->data);
        } catch(Exception $e) {
            $menuMappingList = $roleMenuMapModel->getAllRoleMenuMappingList();
            $this->data['menuMappingList'] = $menuMappingList;
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make("master.role_menu_map", $this->data);
        }
    }
    public function updateRoleMenuMap(Request $request){
        try {
            $roleMenuData = $request->all();
            $roleMenuMapModel = new RoleMenuMappingModel();
            $isUpdated = $roleMenuMapModel->updateRoleMenuMapDetails($roleMenuData);
            if($isUpdated) {
                return back()->with('success', 'Role Mapping Updated Successfully!');
            }
            Log::info("roleData==>".json_encode($roleMenuData));
            return View::make("master.role_menu_map", $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            //return View::make('orders.add_installation', $this->data);
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }
  
    public function getAllSubMenu(Request $request, $parentMenuId) {
        $menuModel = new MenuMasterModel();
        $getAll = $menuModel->getAllSubMenu($parentMenuId);

        if ($getAll) {
            return response()->json(array("success" => true, 
            "message" => "Submenu Data Returned!",
            "submenuList" => $getAll
        ), 200);
        } else {
            return response()->json(array("success" => false, "message" => "Something went wrong !"), 400);
        }
    }
   
}