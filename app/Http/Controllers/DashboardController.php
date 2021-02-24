<?php 

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\LoginModel;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\CommonController;
use App\Models\Order\OrderModel;
use App\Models\Users\UsersModel;
use App\Models\Customer\CustomerModel;

class DashboardController extends CommonController {

    function __construct() {
    }

    public function dashboard() {
        try {
            /*$orderModel = new OrderModel();
            $count = $orderModel->getAllOrdersCount();*/
            //$confirmed = Subscriber::where('status', 'confirmed')->count();
            $count = OrderModel::where('is_deleted','N')->count();
            $this->data['allorders'] = $count;

            $allusers = UsersModel::where('is_deleted','N')->count();
            $this->data['allusers'] = $allusers;

            $allcustomer = CustomerModel::where('is_deleted','N')->count();
            $this->data['allcustomers'] = $allcustomer;

            $allPendingOrders = OrderModel::where('is_payment_done' , 0);
            $allPendingOrdersCount = $allPendingOrders->count();
            $this->data['allPendingOrders'] = $allPendingOrdersCount;

            $customerModel = new CustomerModel();
            $customerList = $customerModel->getCustomerList();
            $this->data['customerList'] = $customerList;

            $orderModel = new OrderModel();
            $orderList = $orderModel->getOrderList();
            $this->data['orderList'] = $orderList;

            $orderModel = new OrderModel();
            $pendinOrderList = $orderModel->getPaymentPendingOrders();
            $this->data['pendinOrderList'] = $pendinOrderList;

            return View::make('dashboard/dashboard', $this->data);
        } catch(Exception $e) {
            Log::info("Exception occured while returning the dashboard details! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('dashboard/dashboard', $this->data);
        }
        //return View::make('dashboard/dashboard');
    }
}