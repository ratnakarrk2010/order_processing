<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Order\PaymentModel;

class OrderModel extends Model{
    protected $table = 'orders';

    public function __construct()
    {

        $this->fillable = [
            'id', 'customer_id', 'opf_no', 'opf_date', 'po_no', 'po_date','invoice_no', 'invoice_date',
             'installation_address', 'material_procurement_date','approved_by','approved_by_id',
            'order_collected_by', 'order_collected_by_id','qc_testting_result', 'dispatch_date','remarks', 
            'sales_initiator_by', 'sales_initiator_by_id',
            'total_po_value', 'payment_terms', 'warranty_period','is_payment_done',
             'is_installation_done','is_deleted','created_at', 'updated_at','created_by', 'updated_by'
        ];

    
    }
   
    
    public function getOrderList() {
        $query = DB::table('orders')
        ->join('customer_details', 'customer_details.id', '=', 'orders.customer_id')
        ->where('orders.is_deleted', 'N')
        ->select('orders.*','customer_details.client_name')->get();   
        return $query;
        
    }

    /**
     * Function for all order count
     */
    public function getAllOrdersCount() {
        $query = DB::table('orders');
        $orderList = $query->get();
        return $orderList;
    }

    /**
     * This function returns the list of orders not having final payment
     */
    public function getPaymentPendingOrders() {
         $orders = DB::table('orders')
         ->join('customer_details', 'customer_details.id', '=', 'orders.customer_id')
         ->where('orders.is_payment_done', false)
         ->select('orders.*','customer_details.client_name')->get();

         return $orders;
    }
    
     /**
     * This function is used to get order record for edit
     * 
     */
    public function getOrderRecordForEdit($orderId) {
        $orderQueryResult = DB::table('orders')
        ->where('id',$orderId)->get();
        return $orderQueryResult[0];
    } 

    public function getOrderRecordForView($orderId) {
        $orderQueryResult = DB::table('orders')
        ->join('customer_details', 'customer_details.id', '=', 'orders.customer_id')
        ->where('orders.id',$orderId)
        ->select('orders.*','customer_details.*')->get();
        //Log::info('orderQueryResult'.json_encode($orderQueryResult[0]));
        return $orderQueryResult[0];
    } 

    public function updateOrderDetails($orderData) {
        $orderObj = OrderModel::find($orderData['id']);
        Log::info("orderObj->".$orderObj);
        $orderData['updated_by'] = Session::get("loggedInUserId");
        $isUpdated = $orderObj->update($orderData);
        return $isUpdated;
    }

    public function getOrderPaymentDetails($orderId) {
        $paymentModel = new PaymentModel();
        return $paymentModel->getPyamentDetailsByOrderId($orderId);
    }

    /*public function updateOrderMaterialDetails($orderDetailsData) {
        $orderDetailsObj = OrderDetailsModel::find($orderDetailsData['id']);
        $orderDetailsData['updated_by'] = Session::get("loggedInUserId");
        $isUpdated = $orderDetailsObj->update($orderDetailsData);
        return $isUpdated;
    }*/

    /**
     * This method is used to delete the Users record with relevant data
     */
    public function softDeleteOrder($orderId)
    {
        //$order = OrderModel::find($orderId);
        $orderData = array();
        $orderRecord = OrderModel::find($orderId);
        $isUpdated = 0;
        if ($orderRecord->is_deleted == "N") {
            $orderData['is_deleted'] = "Y";
            $isUpdated = $orderRecord->update($orderData);
        }
        return $isUpdated;
    }
}
