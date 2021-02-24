<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ViewModel extends Model{
    protected $table = 'v_order_info_excel';

    public function __construct()
    {

        $this->fillable = [
            'ORDER_ID', 'OPF_NO', 'OPF_DATE', 'PO_NO', 'PO_DATE', 'CUSTOMER',
            'TYPE_OF_CUSTOMER', 'CUSTOMER_EMAIL', 'CUSTOMER_ADDRESS', 'CONTACT_PERSON_1',
            'CONTACT_NO_1', 'CONTACT_PERSON_2','CONTACT_NO_2', 'INSTALLATION_ADDRESS', 'ORDER_COLLECTED_BY',
            'WARRANTY_PERIOD', 'SALES_INITIATED_BY','APPROVED_BY', 'TOTAL_PO_VALUE', 'MATERIAL_PROCUREMENT_DATE',
            'QC_TESTING_RESULT', 'DISPATCH_DATE', 'REMARKS','INVOICE_NO', 'INVOICE_DATE','PAYMENT_TERMS',
            'INSTALLATION_DONE', 'FINAL_PAYMENT_DONE', 'ORDER_CREATED_BY', 'ORDER_CREATED_AT', 
            'INSTALLATION_ASSIGNED_TO', 'INSTALLATION_START_DATE','INSTALLTION_COMPLETION_DATE', 
            'DOCUMENTATION_COMPLETED', 'INSTALLATION_SERVICE_COMPLETED',
            'INSTALLATION_CREATED_BY', 'INSTALLATION_CREATED_AT','MATERIALS','QUANTITY','DC_NO',
            'DC_DATE','PRODUCT_SERIAL_NUMBER','TOTAL_PAYMENT_RECEIVED','BALANCE_PAYMENT','LAST_PAYMENT_RECEIVED_DATE',
            'FINAL_PAYMENT', 'FINAL_PAYMENT_DATE','OS_DAYS'
        ];

        //$this->created_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
       // $this->updated_by = Session::get("loggedInUserId") != '' ? Session::get("loggedInUserId") : 0;
    }
}