<?php

namespace App\Models\Tax;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TaxModel extends Model{
    protected $table = 'tax_master';

    public function __construct()
    {

        $this->fillable = [
            'id', 'tax_name', 'tax_value','is_deleted','created_at', 'updated_at','created_by', 
            'updated_by'
        ];

        $this->created_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
        $this->updated_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
    }
    
        
    /**
	 * function to Fetch Cities
	 */
	public function getAllTaxDetails()
	{
		$roleQry = DB::table('tax_master')
        ->where('tax_master.is_deleted', 'N')
        ->join('users','users.id' ,'=', 'tax_master.created_by')
        ->select('tax_master.*','users.first_name','users.last_name')->get();   
        //$allRoles = $roleQry->get();
		return $roleQry;
	}
  
    
    public function updateTaxDetails($taxData) {
        $taxObj = TaxModel::find($taxData['id']);
        $taxData['updated_by'] = Session::get("loggedInUserId");
        
        $isUpdated = $taxObj->update($taxData);
        return $isUpdated;
    }


    public function softDeleteTax($taxId){
        
            $taxData = array();
            $taxRecord = TaxModel::find($taxId);
            $isUpdated = 0;
            if ($taxRecord->is_deleted == "N") {
                $taxData['is_deleted'] = "Y";
                $isUpdated = $taxRecord->update($taxData);
            }
            return $isUpdated;
    }
    
}