<?php

namespace App\Models\PaymentTerms;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentTermsModel extends Model{
    protected $table = 'payment_terms';

    public function __construct()
    {

        $this->fillable = [
            'id', 'payment_terms','value_figure','is_deleted','created_at', 'updated_at','created_by', 
            'updated_by'
        ];

        $this->created_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
        $this->updated_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
    }
    
        
    /**
	 * function to Fetch Cities
	 */
	public function getAllPaymentTerms()
	{
		$roleQry = DB::table('payment_terms')
        ->where('payment_terms.is_deleted', 'N')
        ->join('users','users.id' ,'=', 'payment_terms.created_by')
        ->select('payment_terms.*','users.first_name','users.last_name')->get();   
        return $roleQry;
    }
       
    public function updatePaymentDetails($paymentTermsData) {
        $ptObj = PaymentTermsModel::find($paymentTermsData['id']);
        $paymentTermsData['updated_by'] = Session::get("loggedInUserId");
        $isUpdated = $ptObj->update($paymentTermsData);
        return $isUpdated;
    }


    public function softDeletePaymentTerms($paymentTermsId){
        
            $paymentTermsData = array();
            $paymentTermsRecord = PaymentTermsModel::find($paymentTermsId);
            $isUpdated = 0;
            if ($paymentTermsRecord->is_deleted == "N") {
                $paymentTermsData['is_deleted'] = "Y";
                $isUpdated = $paymentTermsRecord->update($paymentTermsData);
            }
            return $isUpdated;
    }
    
}