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
use App\Models\Order\InstallationModel;
use App\Models\Role\RoleModel;

class DashboardController extends CommonController {

    function __construct() {
    }

    public function dashboard() {
        try {
            /*$orderModel = new OrderModel();
            $count = $orderModel->getAllOrdersCount();*/
            //$confirmed = Subscriber::where('status', 'confirmed')->count();

            /*$order_count_query = OrderModel::where('is_deleted','N');

            if (Session::get("loggedInUserRole") == 2) {
                $order_count_query->where('created_by', Session::get('loggedInUserId'));
            }
            $count = $order_count_query->count();*/
            $orderModel = new OrderModel();
            $this->data['allorders'] = $orderModel->getOrdersCountForCurrentFinYear();

            $this->data['totalOrderAmount'] = $orderModel->getOrderTotalForCurrentFinYear();

            $this->data['balancePayment'] = $orderModel->getBalancePaymentForOrders();

            $allusers = UsersModel::where('is_deleted','N')->count();
            $this->data['allusers'] = $allusers;

            $allcustomer = CustomerModel::where('is_deleted','N')->count();
            $this->data['allcustomers'] = $allcustomer;

            /*$pendingOrderQuery = OrderModel::where('is_payment_done' , 0);
            if (Session::get("loggedInUserRole") == 2) {
                $pendingOrderQuery->where('created_by', Session::get("loggedInUserId"));
            } else if (Session::get("loggedInUserRole") == 5) {
                $pendingOrderQuery = InstallationModel::where("installation_assigned_to_id", Session::get("loggedInUserId"))->whereNull("installation_start_date");
            }

            //$allPendingOrders = OrderModel::where('is_payment_done' , 0);
            $allPendingOrdersCount = $pendingOrderQuery->count();
            //$this->data['allPendingOrders'] = $allPendingOrdersCount;
            */

            // Get pending orders list for the Users according to user's role and userId
            $pendingOrdersListQuery = $orderModel->getOrderForFinYearByRole(Session::get("loggedInUserRole"), Session::get("loggedInUserId"))->where('is_payment_done', false);
			$pendingOrdersListQuery = $pendingOrdersListQuery->where(function($query) {
				$query->whereNull('orders.order_status')->orWhere('orders.order_status', 0);
			});
            $pendingOrdersListQuery = $pendingOrdersListQuery->join('customer_details', 'customer_details.id', '=', 'orders.customer_id');
            $pendingOrdersListQuery = $pendingOrdersListQuery->select('orders.*', 'customer_details.client_name');
            $this->data['pendinOrderList'] = $pendingOrdersListQuery->get();
            
            // Get all orders by the logged in user role and userId
            $orderQuery = $orderModel->getOrdersForFinYear()->select('orders.*', 'customer_details.client_name');
            $this->data['orderList'] = $orderModel->getOrdersForFinYear()->get();

            if (Session::get("loggedInUserRole") == 5) {
                $this->data['allPendingOrders'] = sizeof($orderModel->getPendingOrderForInstallationUser());
                $this->data['pendinOrderList'] = $orderModel->getPendingOrderForInstallationUser();
            } else {
                $this->data['allPendingOrders'] = sizeof($this->data['pendinOrderList']);
            }

            $customerModel = new CustomerModel();
            $customerList = $customerModel->getCustomerList();
            $this->data['customerList'] = $customerList;

            /*$orderModel = new OrderModel();
            $orderList = $orderModel->getOrderList();
            $this->data['orderList'] = $orderList;

            $orderModel = new OrderModel();
            $pendinOrderList = $orderModel->getPaymentPendingOrders();
            $this->data['pendinOrderList'] = $pendinOrderList;*/

            $this->data['roles'] = RoleModel::whereIn('id', array(2, 4, 5))->get();

            return View::make('dashboard/dashboard', $this->data);
        } catch(Exception $e) {
            Log::error($e);
            Log::info("Exception occured while returning the dashboard details! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('dashboard/dashboard', $this->data);
        }
        //return View::make('dashboard/dashboard');
    }

    public function getDashboardCountForUser(Request $request, $roleId, $userId) {
        $orderModel = new OrderModel();
        $reposneArray = array();
        if ($roleId == 2) {
            // Sales User
            $reposneArray['orders'] = $orderModel->getUsersOrdersCountForCurrentFinYear($roleId, $userId);
            $reposneArray['totalOrderAmount'] = $orderModel->getUserOrderTotalForCurrentFinYear($roleId, $userId);
            $reposneArray['balancePayment'] = $orderModel->getBalancePaymentForOrdersOfUser($roleId, $userId);
            $reposneArray['pendingOrders'] = $orderModel->getPendingOrderCountForUser($roleId, $userId);
        } else if ($roleId == 5) {
            // Installation User
            $reposneArray['pendingOrders'] = $orderModel->getPendingOrderCountForInstallationUser($roleId, $userId);
            $reposneArray['completedOrders'] = $orderModel->getOrdersExecutedForInstallationUser($roleId, $userId);
            $reposneArray['totalOrderAmount'] = $orderModel->getExecutedOrdersValueForInstallationUser($roleId, $userId);
        } else if ($roleId == 4) {
            // Accountant User
            $reposneArray['balancePayment'] = $orderModel->getBalancePaymentForOrders();
        } else {
            return response()->json(array('message' => "Invalid user role!"), 400);
        }

        return response()->json($reposneArray, 200);
    }
}
