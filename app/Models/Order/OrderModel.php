<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Order\PaymentModel;
use App\Models\Order\OrderInstallationAddress;
use App\Models\DAppModel;
use App\Models\RoleModel;
use App\Models\Users\UsersModel;
use App\Models\Order\InstallationModel;

class OrderModel extends DAppModel {
    protected $table = 'orders';

    public function __construct()
    {
        parent::__construct();
        $this->fillable = [
            'id', 'customer_id', 'opf_no', 'opf_num', 'opf_date', 'po_no', 'po_date','invoice_no', 'invoice_date',
             'installation_address', 'material_procurement_date','approved_by','approved_by_id', 'tax_amount',
            'order_collected_by', 'order_collected_by_id','qc_testting_result', 'dispatch_date','remarks', 
            'sales_initiator_by', 'sales_initiator_by_id','tax_id','tax_value','total_po_value', 'total_order_amount', 'payment_terms',
            'payment_terms_id', 'warranty_period','is_payment_done', 'is_installation_done','is_installation_assigned','is_deleted',
            'order_status', 'created_at','updated_at','created_by', 'updated_by', 'ld_clause_applicable',
            'delivery_period', 'other_terms'
        ];
    }

    public function getOrdersCountForCurrentFinYear() {

        //DB::enableQueryLog();
        $order_count_query = $this->getOrdersForFinYear();
        $orders = $order_count_query->get();

        //Log::info("orders: " .json_encode($orders));
        $count = sizeof($orders);

        //Log::info(DB::getQueryLog());

        return $count;
    }

    public function getOrderTotalForCurrentFinYear() {
        $order_count_query = $this->getOrdersForFinYear();
        $orders = $order_count_query->get();
        $totalOrderAmount = 0;
        foreach($orders as $order) {
            $totalOrderAmount += $order->total_order_amount;
        }

        Log::info("totalOrderAmount: " . $totalOrderAmount);

        return $totalOrderAmount;
    }

    public function getBalancePaymentForOrders() {
        $query = "SELECT SUM((o.total_order_amount - T.payment_recevied)) AS balance_payment FROM
        orders AS o, (SELECT order_id, SUM(payment_received) AS payment_recevied FROM payment_details GROUP BY order_id)
        AS T WHERE T.order_id = o.id";

        if (Session::get("loggedInUserRole") == 2) {
            Log::info("In if");
            $query .= " AND o.created_by = " . Session::get("loggedInUserId");
        }

        $balance_payment_rs = DB::select(DB::raw($query));

        if ($balance_payment_rs) {
            if ($balance_payment_rs[0]->balance_payment) {
                return $balance_payment_rs[0]->balance_payment;
            } else {
                // If the sum of balance payment is null then select the total order payment. i.e. the total order amount is pending
                $query = "SELECT SUM(o.total_order_amount) AS balance_payment FROM orders AS o";
                if (Session::get("loggedInUserRole") == 2) {
                    $query .= " WHERE o.created_by = " . Session::get("loggedInUserId");
                }
                $balance_payment_rs = DB::select(DB::raw($query));
                if ($balance_payment_rs) {
                    if ($balance_payment_rs[0]->balance_payment) {
                        return $balance_payment_rs[0]->balance_payment;
                    }
                }
            }
        } else {
            return 0;
        }
    }

    public function getPendinOrdersCountForCurrentFinYearForInstallation() {

        //DB::enableQueryLog();
        $order_count_query = $this->getOrdersForFinYear();
        $orders = $order_count_query->get();
      
        $count = sizeof($orders);

        //Log::info(DB::getQueryLog());

        return $count;
    }

    public function getOrdersForFinYear() {

        $finYear = $this->getFinYear();
        /*$order_count_query = OrderModel::where('is_deleted','N')->where(function($query) use ($finYear) {
            $query->whereYear('created_at', '>=', $finYear['lowerYear'])->whereMonth('created_at', '>=', $finYear['lowerMonth']);
        })->where(function($query) use ($finYear) {
            $query->whereYear('created_at', '<=', $finYear['upperYear'])->whereMonth('created_at', '<=', $finYear['upperMonth']);
        });*/

        $finYearStartDate = $finYear['finYearStartDate'];
        $finYearEndDate = $finYear['finYearEndDate'];

        $order_count_query = OrderModel::where('orders.is_deleted','N')->where(function($query) use ($finYearStartDate) {
            $query->whereDate('orders.created_at', '>=', $finYearStartDate->format('Y-m-d'));
        })->where(function($query) use ($finYearEndDate) {
            $query->whereDate('orders.created_at', '<=', $finYearEndDate->format('Y-m-d'));
        });

        $order_count_query->join('customer_details', 'customer_details.id', '=', 'orders.customer_id');

        if (Session::get("loggedInUserRole") == 2) {
            $order_count_query = $order_count_query->where('orders.created_by', Session::get('loggedInUserId'));
        } else if (Session::get("loggedInUserRole") == 5) {
            $assignedInstallations = InstallationModel::where('installation_assigned_to_id', Session::get("loggedInUserId"))->get();
            $orderIds = array();
            foreach ($assignedInstallations as $installation) {
                array_push($orderIds, $installation->order_id);
            }
            $order_count_query = $order_count_query->where('is_installation_assigned', true);
            if ($orderIds && sizeof($orderIds) > 0) {
                $order_count_query = $order_count_query->whereIn('orders.id', $orderIds);
            }
        }
        return $order_count_query;
    }

    public function getOrderList() {
        $query = DB::table('orders')
        ->join('customer_details', 'customer_details.id', '=', 'orders.customer_id')
        ->where('orders.is_deleted', 'N')
		->orderBy('orders.id', 'DESC')
        ->select('orders.*','customer_details.client_name')->get();   
        return $query;
        
    }

    /**
     * This method is used to order processing list for approved orders only.
     */
    public function getOrderListForInstallation() {

        $orderIds = array();
        if (Session::get("loggedInUserRole") == 5) {
            $instalaltions = InstallationModel::where("installation_assigned_to_id", Session::get("loggedInUserId"))->get();
            foreach ($instalaltions as $installation) {
                array_push($orderIds, $installation->order_id);
            }
        }

        $query = DB::table('orders')
        ->join('customer_details', 'customer_details.id', '=', 'orders.customer_id')
        ->where('orders.is_deleted', 'N')
        ->where('orders.order_status', '1');

        if (sizeof($orderIds) > 0) {
            $query = $query->whereIn('orders.id', $orderIds);
        }

        $installations = $query->select('orders.*','customer_details.client_name')->get();
        return $installations;
        
    }
     /**
     * This method is used to order processing list for approved orders only for Payment.
     */
    public function getOrderListForPayment() {
        $query = DB::table('orders')
        ->join('customer_details', 'customer_details.id', '=', 'orders.customer_id')
        ->where('orders.is_deleted', 'N')
        ->where('orders.order_status', '1')
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
        //Log::info("orderObj->".$orderObj);
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

    public function getOrderInstallationAddress($orderId) {
        $installationAddresses = DB::table('order_installation_addresses')->where('order_id', '=', $orderId)->get();
        return $installationAddresses;
    }

    public function deleteInstallationAddress($installationAddressId) {
        $installationAddress = OrderInstallationAddress::find($installationAddressId);
        if ($installationAddress != null) {
            $installationAddress->delete();
            return true;
        } else {
            return false;
        }
    }

    public function getInstallationAddressesForOrder($orderId) {
        $installationAddresses = DB::table('order_installation_addresses')->where('order_id', '=', $orderId)->get();
        if ($installationAddresses) {
            //Log::info("Total Installation Addresses Count: " . sizeof($installationAddresses));
            return $installationAddresses;
        } else {
            //Log::info("No installation address found for orderId: " . $orderId);
            return array();
        }
    }

    public function getNextOpfNo() {
        $finYear = $this->getFinYear();
        $shortFinYear = $finYear['shortFinYear'];

        // Get the last opf num
        $max_opf_num_rs = DB::select(DB::raw("SELECT IFNULL(MAX(opf_num), 0) AS max_opf_num FROM orders"));
        return array (
            "opfNo" => $shortFinYear . "/" . str_pad(strval($max_opf_num_rs[0]->max_opf_num + 1), 3, "0", STR_PAD_LEFT),
            "opfNum" => $max_opf_num_rs[0]->max_opf_num + 1
        );
        //return $shortFinYear . "/" . str_pad(strval($max_opf_num_rs[0]->max_opf_num + 1), 3, "0", STR_PAD_LEFT);
    }
	
	/**
     * This function calculates the opf number from the opf_date.
     */
    public function getNextOpfNoByOPFDate($opf_date) {
        $dt = Carbon::parse($opf_date);
        $shortYear = intVal(Carbon::parse($opf_date)->format('y'));

        $currentYear = 0;
        $nextYear = 0;
        if ($dt->month >= 4) {
            $currentYear = $shortYear;
            $nextYear = $shortYear + 1;
        }

        if ($dt->month <= 3) {
            $currentYear = $shortYear - 1;
            $nextYear = $shortYear;
        }

        $calculatedFinYear = $currentYear . "-" . $nextYear;

        // Get the last opf num
        $max_opf_num_rs = DB::select(DB::raw("SELECT IFNULL(MAX(opf_num), 0) AS max_opf_num FROM orders WHERE opf_no LIKE '" . $calculatedFinYear . "%'"));
        return array (
            "opfNo" => $calculatedFinYear . "/" . str_pad(strval($max_opf_num_rs[0]->max_opf_num + 1), 3, "0", STR_PAD_LEFT),
            "opfNum" => $max_opf_num_rs[0]->max_opf_num + 1
        );   
    }

    /*
    *********************************************************** API Methods ***********************************************************
    */
    public function getUsersOrdersCountForCurrentFinYear($roleId, $userId) {
        DB::enableQueryLog();
        $order_count_query = $this->getOrderForFinYearByRole($roleId, $userId);
        $orders = $order_count_query->get();
        $count = sizeof($orders);
        Log::info(DB::getQueryLog());
        return $count;
    }

    public function getPendingOrderCountForUser($roleId, $userId) {
        $ordersQuery = $this->getOrderForFinYearByRole($roleId, $userId);
        if ($roleId == 2) {
            $ordersQuery = $ordersQuery->where('is_payment_done', false);
        }

        $pendingOrdersCount = $ordersQuery->count();
        return $pendingOrdersCount;
    }

    public function getUserOrderTotalForCurrentFinYear($roleId, $userId) {
        $order_count_query = $this->getOrdersForFinYear();
        $orders = $order_count_query->get();
        $totalOrderAmount = 0;
        foreach($orders as $order) {
            $totalOrderAmount += $order->total_order_amount;
        }
        return $totalOrderAmount;
    }

    public function getBalancePaymentForOrdersOfUser($roleId, $userId) {
        $query = "SELECT SUM((o.total_order_amount - T.payment_recevied)) AS balance_payment FROM orders AS o, (SELECT order_id, SUM(payment_received) AS payment_recevied FROM payment_details GROUP BY order_id) AS T WHERE T.order_id = o.id";
        
        if ($roleId == 2) {
            $query .= " AND o.created_by = " . $userId;
        }
        
        $balance_payment_rs = DB::select(DB::raw($query));

        if ($balance_payment_rs) {
            if ($balance_payment_rs[0]->balance_payment) {
                return $balance_payment_rs[0]->balance_payment;
            } else {
                // If the sum of balance payment is null then select the total order payment. i.e. the total order amount is pending
                $query = "SELECT SUM(o.total_order_amount) AS balance_payment FROM orders AS o";
                if ($roleId == 2) {
                    $query .= " WHERE o.created_by = " . $userId;
                }
                $balance_payment_rs = DB::select(DB::raw($query));
                if ($balance_payment_rs) {
                    if ($balance_payment_rs[0]->balance_payment) {
                        return $balance_payment_rs[0]->balance_payment;
                    }
                }
            }
        } else {
            return 0;
        }
    }

    public function getOrderForFinYearByRole($roleId, $userId) {
        $finYear = $this->getFinYear();
        $finYearStartDate=$finYear['finYearStartDate'];
        $finYearEndDate=$finYear['finYearEndDate'];
        $order_count_query=OrderModel::where('orders.is_deleted','N')->where(function($query) use ($finYearStartDate) {
            $query->whereDate('orders.created_at', '>=', $finYearStartDate->format('Y-m-d'));
        })->where(function($query) use ($finYearEndDate) {
            $query->whereDate('orders.created_at', '<=', $finYearEndDate->format('Y-m-d'));
        });

        if ($roleId == 2) {
            $order_count_query = $order_count_query->where('orders.created_by', $userId);
        }

        return $order_count_query;
    }

    public function getPendingOrderForInstallationUser() {

        DB::enableQueryLog();
        $finYear = $this->getFinYear();
        $finYearStartDate = $finYear['finYearStartDate'];
        $finYearEndDate = $finYear['finYearEndDate'];

        $pendingInstallations = InstallationModel::whereNotNull('installation_assigned_to_id')->whereNull('installation_completion_date')
            ->where('installation_assigned_to_id', Session::get("loggedInUserId"))->get();
        
        Log::info(DB::getQueryLog());
        if ($pendingInstallations && sizeof($pendingInstallations) > 0) {
            $ordersIdArray = array();

            foreach ($pendingInstallations as $installation) {
                array_push($ordersIdArray, $installation->order_id);
            }

            if (sizeof($ordersIdArray) > 0) {
                $order_count_query=OrderModel::where('orders.is_deleted','N')->where(function($query) use ($finYearStartDate) {
                $query->whereDate('orders.created_at', '>=', $finYearStartDate->format('Y-m-d'));
                })->where(function($query) use ($finYearEndDate) {
                    $query->whereDate('orders.created_at', '<=', $finYearEndDate->format('Y-m-d'));
                });
                $order_count_query->join('customer_details', 'customer_details.id', '=', 'orders.customer_id');
                $order_count_query->where('is_installation_done', false)->where('is_installation_assigned', true)->whereIn('orders.id', $ordersIdArray);

                Log::info("ordersIdArray ::: " . json_encode($ordersIdArray));
                $pendingOrders = $order_count_query->select('orders.*', 'customer_details.client_name')->get();
                Log::info(DB::getQueryLog());
                return $pendingOrders;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    public function getPendingOrderCountForInstallationUser($roleId, $userId) {
        DB::enableQueryLog();
        $finYear = $this->getFinYear();
        $finYearStartDate=$finYear['finYearStartDate'];
        $finYearEndDate=$finYear['finYearEndDate'];
        $order_count_query=OrderModel::where('is_deleted','N')->where(function($query) use ($finYearStartDate) {
            $query->whereDate('created_at', '>=', $finYearStartDate->format('Y-m-d'));
        })->where(function($query) use ($finYearEndDate) {
            $query->whereDate('created_at', '<=', $finYearEndDate->format('Y-m-d'));
        });

        $order_count_query->where('is_installation_done', false)->where('is_installation_assigned', true);

        $orders = $order_count_query->get();
        $ordersIdArray = array();
        foreach ($orders as $order) {
            array_push($ordersIdArray, $order->id);
        }

        $pendingInstallations = InstallationModel::whereNotNull('installation_assigned_to_id')->whereNull('installation_completion_date')
        ->whereIn('order_id',$ordersIdArray)->where('installation_assigned_to_id', $userId)->get();
        
        Log::info(DB::getQueryLog());
        if ($pendingInstallations != null) {
            return sizeof($pendingInstallations);
        } else {
            return 0;
        }
    }
    public function getOrdersExecutedForInstallationUser($roleId, $userId) {
        $finYear = $this->getFinYear();
        $finYearStartDate=$finYear['finYearStartDate'];
        $finYearEndDate=$finYear['finYearEndDate'];
        $order_count_query=OrderModel::where('is_deleted','N')->where(function($query) use ($finYearStartDate) {
            $query->whereDate('created_at', '>=', $finYearStartDate->format('Y-m-d'));
        })->where(function($query) use ($finYearEndDate) {
            $query->whereDate('created_at', '<=', $finYearEndDate->format('Y-m-d'));
        });

        $order_count_query->where('is_installation_done', true)->where('is_installation_assigned', true);

        $orders = $order_count_query->get();
        $ordersIdArray = array();
        foreach ($orders as $order) {
            array_push($ordersIdArray, $order->id);
        }

        $completedInstallations = InstallationModel::whereIn('order_id', $ordersIdArray)
            ->whereNotNull('installation_assigned_to_id')->where('installation_assigned_to_id', $userId)->get();

        if ($completedInstallations != null) {
            return sizeof($completedInstallations);
        } else {
            return 0;
        }
    }

    public function getExecutedOrdersValueForInstallationUser($roleId, $userId) {
        
        $completedInstallations = InstallationModel::whereNotNull('installation_assigned_to_id')->where('installation_assigned_to_id', $userId)->get();
        $ordersIdArray = array();
        foreach ($completedInstallations as $installation) {
            array_push($ordersIdArray, $installation->order_id);
        }

        $finYear = $this->getFinYear();
        $finYearStartDate=$finYear['finYearStartDate'];
        $finYearEndDate=$finYear['finYearEndDate'];
        $order_count_query=OrderModel::where('is_deleted','N')->where(function($query) use ($finYearStartDate) {
            $query->whereDate('created_at', '>=', $finYearStartDate->format('Y-m-d'));
        })->where(function($query) use ($finYearEndDate) {
            $query->whereDate('created_at', '<=', $finYearEndDate->format('Y-m-d'));
        });

        $order_count_query->where('is_installation_done', true)->where('is_installation_assigned', true)->whereIn('id', $ordersIdArray);

        $orders = $order_count_query->get();
        $totalOrderAmount = 0;
        if ($orders != null) {
            foreach ($orders as $order) {
                $totalOrderAmount += $order->total_order_amount;
            }
            return $totalOrderAmount;
        } else {
            return 0;
        }
    }
}
