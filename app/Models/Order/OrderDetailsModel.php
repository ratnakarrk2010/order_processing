<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderDetailsModel extends Model{
    protected $table = 'order_details';

    public function __construct()
    {

        $this->fillable = [
            'id','order_id', 'customer_id', 'materials', 'quantity', 'dc_no',
            'dc_date', 'product_serial_no', 'created_at', 'updated_at','created_by', 'updated_by'
        ];

    
    }

    
    /**
    * This function is used to get orderDetails record for edit
    */
    public function getOrderDetailsRecordForEdit($Id) {
        $orderDetailsQueryResult = DB::table('order_details')
        //->join('orders', 'orders.id', '=', 'order_details.order_id')
        ->where('order_details.order_id',$Id)->get();
        //->select('order_details.*')->get();  
        return $orderDetailsQueryResult;
    } 

    
}