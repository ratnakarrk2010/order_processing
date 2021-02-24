<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Order\OrderModel;

class PaymentModel extends Model {
    protected $table = 'payment_details';

    public function __construct()
    {

        $this->fillable = [
            'id', 'customer_id', 'os_days','order_id', 'invoice_no','payment_terms', 'payment_received', 
            'balance_payment', 'final_payment_date', 'payment_received_date','is_final_payment', 'created_at',
            'updated_at', 'created_by', 'updated_by'
        ];
        /*
        ALTER TABLE payment_details ADD COLUMN payment_received_date DATE AFTER balance_payment;
        ALTER TABLE payment_details ADD COLUMN is_final_payment BOOLEAN DEFAULT false AFTER payment_received_date;
        */ 
    }
   
    public function updatePaymentDetails($orderData) {
        $orderObj = OrderModel::find($orderData['id']);
        Log::info("orderObj->".$orderObj);
        $orderData['updated_by'] = Session::get("loggedInUserId");
        $isUpdated = $orderObj->update($orderData);
        return $isUpdated;
    }

    public function getPyamentDetailsByOrderId($orderId) {
        $paymentDetails = PaymentModel::where('order_id', $orderId)->get();
        return $paymentDetails;
    }

    public function savePaymentDetails($paymentDetails) {
        $orderId = $paymentDetails['paymentOrderId'];

        //Get Order
        $order = OrderModel::find($orderId);

        if ($order != null) {
            $payment = new PaymentModel();
            $payment->customer_id = $order->customer_id;
            $payment->order_id = $order->id;
            $payment->invoice_no = $paymentDetails['invoice_no'];
            $payment->os_days = $paymentDetails['os_days'];
            $payment->payment_terms = $paymentDetails['payment_terms'];
            $payment->payment_received = $paymentDetails['payment_received'];
            $payment->balance_payment = $paymentDetails['balance_payment'];
            $payment->payment_received_date = $paymentDetails['payment_received_date'];
            $payment->created_by = Session::get("loggedInUserId");

            if ($paymentDetails['balance_payment'] == 0) {
                //Cosider this as a final payment
                $payment->final_payment_date = date('Y-m-d');
                $payment->is_final_payment = true;

                // Update the order as payment done
                $order->update(array('is_payment_done' => true));
            }
            $payment->save();

            return $payment;
        }
    }


    public function getPaymentetailsRecordForView($orderId) {
        $paymentDetailsQueryResult = DB::table('payment_details')
        ->join('orders', 'orders.id', '=', 'payment_details.order_id')
        ->where('payment_details.order_id',$orderId)
        ->select('payment_details.*')->get();
        if (sizeof($paymentDetailsQueryResult) > 0) {
            return $paymentDetailsQueryResult;
        } else {
            return [];
        }
               
    } 
}
