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
            'id', 'role_name', 'created_at', 'updated_at','created_by', 'updated_by'
        ];

        $this->created_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
        $this->updated_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
    }
    /**
	 * function to Fetch Cities
	 */
	public function getAllUsersRole()
	{
		$roleQry = DB::table('roles');
		$allRoles = $roleQry->get();
		return $allRoles;
	}

}