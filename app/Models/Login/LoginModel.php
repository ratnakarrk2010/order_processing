<?php

namespace App\Models\Login;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LoginModel extends Model{
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
    
    

}
