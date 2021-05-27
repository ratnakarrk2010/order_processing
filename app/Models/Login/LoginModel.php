<?php

namespace App\Models\Login;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginModel extends Model {
      /**
     * This function is used to authenticate the user
     */
    public function authenticateuser($userName, $password)
    {
        $sql = "SELECT id, role_id,first_name, last_name, email, password
                FROM users 
                WHERE username = ? AND password = ? AND is_active = '1'";
        $userInfo = DB::select($sql, array($userName, $password));
        Log::info(json_encode($userInfo));
        return $userInfo;
    }
    /*
      * This function is used to get Menus by role_id 
      */
      public function getMenu($roleId, $parentMenuId = 0, $menuType = 1) {
            $menuSQL = "SELECT mm.id AS menu_id, mm.menu_name, mm.menu_path, mm.menu_icon, mm.href 
            FROM menu_master AS mm, role_menu_mapping AS rmm
            WHERE mm.id = rmm.menu_id
                AND mm.menu_type = ?
                AND mm.parent_menu_id = ?
                AND rmm.role_id = ?
                AND rmm.mapping_status = ? ORDER BY mm.id ";
            $parameterArray = array($menuType, $parentMenuId, $roleId, 1);
            $menuArray = DB::select($menuSQL, $parameterArray);
            return $menuArray;
      }
    

}
