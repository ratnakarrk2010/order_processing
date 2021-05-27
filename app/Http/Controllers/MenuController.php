<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Customer\CustomerModel;
use App\Models\Users\UsersModel;
use App\Http\Controllers\CommonController;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\Menu\MenuModel;
use App\Models\Role\RoleModel;

class MenuController extends CommonController
{
    public function __construct(){
        parent::__construct();
        $roleModel = new RoleModel();
        $this->data['roles'] = $roleModel->getAllUsersRole();
    }

    public function showMenuMappingPage(Request $request) {
        return view('master.menu_mapping', $this->data);
    }

    public function getMenuMappingForRole(Request $request) {
        $roleId = $request->input('role_id');
        $this->data['selectedRole'] = $roleId;

        $menuModel = new MenuModel();
        $this->data['menus'] = $menuModel->getAllMenus($roleId);
        return view('master.menu_mapping', $this->data);
    }

    public function updateMenuMapping(Request $request) {
        $requestData = $request->all();
        $menuModel = new MenuModel();
        $menuModel->updateMenuMaping($requestData);
        $this->data['selectedRole'] = "0";

        $this->data['success_message'] = "Menu mapping updated successfully!";
        return view('master.menu_mapping', $this->data);
    }
}
