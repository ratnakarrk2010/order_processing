<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CustomerModel extends Model{
    protected $table = 'customer_details';

    public function __construct()
    {

        $this->fillable = [
            'id', 'client_name', 'type_of_customer', 'email_id', 'address', 'contact1',
            'contact_person1', 'contact2', 'contact_person2', 'is_deleted', 'created_at', 'updated_at',
            'created_by', 'updated_by'
        ];

        //$this->created_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
       // $this->updated_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
    }

    public function getCustomerList() {
        $query = DB::table('customer_details')
        ->where('customer_details.is_deleted', 'N')
        ->select('customer_details.*')->get();   
        return $query;
    }   
     
    /**
     * This function is used to get record for edit
     */
    public function getCustomerRecordForEdit($customerId) {
        $customerQueryResult = DB::table('customer_details')
        ->where('id',$customerId)->get();
        return $customerQueryResult[0];
    }
    public function updateCustomerDetails($customerData) {
        $customerObj = CustomerModel::find($customerData['id']);
        $customerData['updated_by'] = Session::get("loggedInUserId");
        
        $isUpdated = $customerObj->update($customerData);
        return $isUpdated;
    }

    public function softDeleteCustomer($custId) {
        $customerData = array();
        $customerRecord = CustomerModel::find($custId);
        $isUpdated = 0;
        if ($customerRecord->is_deleted == "N") {
            $customerData['is_deleted'] = "Y";
            $isUpdated = $customerRecord->update($customerData);
        }
        return $isUpdated;
    }
}