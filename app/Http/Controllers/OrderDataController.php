<?php 

namespace App\Http\Controllers;
use Google\Spreadsheet\SpreadsheetService;
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Illuminate\Support\Facades\Log;
use Google_Client;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\Order\OrderModel;
use App\Models\Order\ViewModel;
use App\Models\Order\OrderDetailsModel;
use App\Models\Customer\CustomerModel;
use App\Models\Order\InstallationModel;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;
use Exception;
use App\Models\Order\PaymentModel;
use Carbon\Carbon;
use App\Models\Users\UsersModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
//use PDF;
use Barryvdh\DomPDF\Facade as PDF;
use PhpOffice\PhpSpreadsheet\Writer\Pdf as WriterPdf;
use Codedge\Fpdf\Fpdf\Fpdf;
ini_set('max_execution_time', 300);
class OrderDataController extends CommonController {

    function __construct() {
    }
    
    public function index() {
        $customerModel = new CustomerModel();
        $customerList = $customerModel->getCustomerList();
        $this->data['customerList'] = $customerList;

        $usersModel = new UsersModel();
        $usersList = $usersModel->getSalesUserList();
        $this->data['salesmanLists'] = $usersList;

        $usersModel = new UsersModel();
        $usersList = $usersModel->getManagerUserList();
        $this->data['managerLists'] = $usersList;

        $usersModel = new UsersModel();
        $usersList = $usersModel->getManagementUserList();
        $this->data['managementLists'] = $usersList;

        return View::make("orders.order-form", $this->data);
        
    }
    function showOrderForm() {
        //return view("orders/order-form");
        return View::make('order_processing_form');
    }
   public function createOrder(Request $request) {
    try {
            $customerModel = new CustomerModel();
            $customerList = $customerModel->getCustomerList();
            Log::info("customerList==>".json_encode($customerList));
            $this->data['customerList'] = $customerList;

            $usersModel = new UsersModel();
            $usersList = $usersModel->getSalesUserList();
            $this->data['salesmanLists'] = $usersList;
    
            $usersModel = new UsersModel();
            $usersList = $usersModel->getManagerUserList();
            $this->data['managerLists'] = $usersList;
    
            $usersModel = new UsersModel();
            $usersList = $usersModel->getManagementUserList();
            $this->data['managementLists'] = $usersList;
            $orderModel = new OrderModel();
            //$orderModel->order_id = $request->input('order_id');
            $orderModel->customer_id = $request->input('customer_id');
            $orderModel->opf_no = $request->input('opf_no');
                                
            $opf_date = $request->input('opf_date');
            $orderModel->opf_date= Carbon::parse($opf_date)->format('Y-m-d');
            $orderModel->po_no = $request->input('po_no');
            $orderModel->po_date = $request->input('po_date');
            $orderModel->invoice_no = $request->input('invoice_no');
            $orderModel->invoice_date = $request->input('invoice_date');
            $orderModel->installation_address = $request->input('installation_address');
            $orderModel->material_procurement_date = $request->input('material_procurement_date');
            $orderModel->approved_by = $request->input('approved_by');
            $orderModel->approved_by_id = $request->input('approved_by_id');
            $orderModel->order_collected_by = $request->input('order_collected_by');
            $orderModel->order_collected_by_id = $request->input('order_collected_by_id');
            $orderModel->qc_testting_result = $request->input('qc_testting_result');
            $orderModel->remarks = $request->input('remarks');
            $orderModel->sales_initiator_by = $request->input('sales_initiator_by');
            $orderModel->sales_initiator_by_id = $request->input('sales_initiator_by_id');
            
            $orderModel->total_po_value = $request->input('total_po_value');
            $orderModel->warranty_period = $request->input('warranty_period');
            $orderModel->dispatch_date = $request->input('dispatch_date');
            $orderModel->payment_terms = $request->input('payment_terms');
            //Order Details Save
            $materialsArr = $request->input('materials');
            $quantityArr = $request->input('quantity');
            //$invoice_noArr = $request->input('invoice_no');
            //$invoice_dateArr = $request->input('invoice_date');
            $dc_noArr = $request->input('dc_no');
            $dc_dateArr = $request->input('dc_date');
            $product_serial_noArr = $request->input('product_serial_no');
            $orderModel->created_by = Session::get("loggedInUserId");
            $isSaved = $orderModel->save();
          
            for ($i = 0; $i < count($materialsArr); $i++) {
                $orderDetails = new OrderDetailsModel();
                $orderDetails->materials = $materialsArr[$i];
                $orderDetails->quantity = $quantityArr[$i];
                //$orderDetails->invoice_no = $invoice_noArr[$i];
                //$orderDetails->invoice_date = $invoice_dateArr[$i];
                $orderDetails->dc_no = $dc_noArr[$i];
                $orderDetails->dc_date = $dc_dateArr[$i];
                $orderDetails->product_serial_no = $product_serial_noArr[$i];
                $orderDetails->order_id = $orderModel->id;
                $orderDetails->customer_id = $orderModel->customer_id;
                $orderDetails->created_by = Session::get("loggedInUserId");
                $isSaved = $orderDetails->save();
               
            }

            if ($isSaved) {
                $this->data['success_message'] = "Order Processed Successfully!";
                //return view('customer.add_new_customer', $this->data);
                return back()->with('success', 'Order Processed Successfully!');
            }
        }catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            return back()->with('error', 'Something went wrong...!');
            //return View::make('customer.add_new_customer', $this->data);
            Log::error($e);
        }
   }

      /**
     * This method is used to fetch all astrologers list
     */
    public function list(Request $request)
    {
        try {
            $orderModel = new OrderModel();
            $orderList = $orderModel->getOrderList();
            Log::info("orderList==>".json_encode($orderList));
            $this->data['orderList'] = $orderList;
            return View::make('orders.all_orders', $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('orders.all_orders', $this->data);
            Log::error($e);
        }
    }
      /**
     * This function is used to get record for edit details
     */
    public function edit($orderId) {
        try {
           
            $customerModel = new CustomerModel();
            $customerList = $customerModel->getCustomerList();
            $this->data['customerList'] = $customerList;
            
            $usersModel = new UsersModel();
            $salesmanLists = $usersModel->getSalesUserList();
            $this->data['salesmanLists'] = $salesmanLists;
    
            $usersModel = new UsersModel();
            $managerLists = $usersModel->getManagerUserList();
            $this->data['managerLists'] = $managerLists;
    
            $usersModel = new UsersModel();
            $managementLists = $usersModel->getManagementUserList();
            $this->data['managementLists'] = $managementLists;

            $orderModel = new OrderModel();
            $orderDetails = $orderModel->getOrderRecordForEdit($orderId);
            $this->data['orderDetails'] = $orderDetails;

            $orderDetailsModel = new OrderDetailsModel();
            $orderDetailsArr = $orderDetailsModel->getOrderDetailsRecordForEdit($orderId);
            $this->data['orderDetailsArr'] = $orderDetailsArr;
            Log::info("orderDetailsArr==>".json_encode($orderDetailsArr));
            return View::make('orders.edit_order', $this->data);
        } catch(Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('orders.edit_order', $this->data);
        }
    }

    public function update(Request $request){
        try {
            
            $orderData = $request->all();
            $orderModel = new OrderModel();
            $isUpdated = $orderModel->updateOrderDetails($orderData);
            Log::info("orderData==>".json_encode($orderData));
             //Order Details Save
             $materialsArr = $request->input('materials');
             $quantityArr = $request->input('quantity');
             //$invoice_noArr = $request->input('invoice_no');
             //$invoice_dateArr = $request->input('invoice_date');
             $dc_noArr = $request->input('dc_no');
             $dc_dateArr = $request->input('dc_date');
             $product_serial_noArr = $request->input('product_serial_no');
             $orderDetailsIdArr = $request->input("orderDetailsId");
            if(sizeof($orderDetailsIdArr) > 0) {
                for ($i = 0; $i < sizeof($orderDetailsIdArr); $i++) {
                    $orderDetailId = $orderDetailsIdArr[$i];
                    if ($orderDetailId == 0) {
                        // Insert
                        $orderDetails = new OrderDetailsModel();
                        $orderDetails->materials = $materialsArr[$i];
                        $orderDetails->quantity = $quantityArr[$i];
                        //$orderDetails->invoice_no = $invoice_noArr[$i];
                        //$orderDetails->invoice_date = $invoice_dateArr[$i];
                        $orderDetails->dc_no = $dc_noArr[$i];
                        $orderDetails->dc_date = $dc_dateArr[$i];
                        $orderDetails->product_serial_no = $product_serial_noArr[$i];
                        $orderDetails->order_id = $request->input('id');
                        $orderDetails->customer_id = $request->input('customer_id');
                        $orderDetails->created_by = Session::get("loggedInUserId");
                        $isSaved = $orderDetails->save();
                    } else {
                        // Update
                        $orderDetails = OrderDetailsModel::find($orderDetailId);
                        if ($orderDetails != null) {
                            $orderDetails->update(array(
                                'materials' => $materialsArr[$i],
                                'quantity' => $quantityArr[$i],
                                //'invoice_no' => $invoice_noArr[$i],
                                //'invoice_date'=> $invoice_dateArr[$i],
                                'dc_no' => $dc_noArr[$i],
                                'dc_date' => $dc_dateArr[$i],
                                'product_serial_no' => $product_serial_noArr[$i],
                                'order_id' => $request->input('id'),
                                'customer_id' => $request->input('customer_id'),
                                'created_by' => Session::get("loggedInUserId"),
                                'updated_by' => Session::get("loggedInUserId")
                               
                            ));
                        }
                       
                    }
                }
                
            }         
            if($isUpdated) {
                //$this->data['success_message'] = "Orders Data Updated Successfully!";
                //return back()->with('success', 'Orders Data Updated Successfully!!');
                return redirect('/all/orders');
            }else {
                $this->data['error_message'] = "Something went wrong while updating the Users Data!";
                return back()->with('error', 'Something went wrong while updating the Orders Data!');
            }
           
        } catch(Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            //$this->data['exception_message'] = "Something went wrong...";
            //return View::make('orders.edit_order', $this->data);
            return back()->with('error', 'Something went wrong...');
        }
    }

    /**
     * This method is used to delete the order
     */
    public function deleteOrder(Request $request, $orderId) {
        try {
            $orderModel = new OrderModel();
            $isUpdated = $orderModel->softDeleteOrder($orderId);
            $orderList = $orderModel->getOrderList();
            $this->data['orderList'] = $orderList;
            
            if($isUpdated) {
                $this->data['success_message'] = "Order Deleted Successfully!";
            }else {
                $this->data['error_message'] = "Something went wrong while deleting the Order Data!";
            }
            return View::make('orders.all_orders', $this->data);
        } catch(Exception $e) {
            $orderList = $orderModel->getOrderList();
            $this->data['customerList'] = $orderList;
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('orders.all_orders', $this->data);
        }
    }
   
    public function details($orderId) {
        try {
            $orderModel = new OrderModel();
            $orderDetails = $orderModel->getOrderRecordForView($orderId);
            $this->data['orderDetails'] = $orderDetails;

            $orderDetailsModel = new OrderDetailsModel();
            $orderDetailsArr = $orderDetailsModel->getOrderDetailsRecordForEdit($orderId);
            $this->data['orderDetailsArr'] = $orderDetailsArr;

            $installationModel = new InstallationModel();
            $installationDetailsArr = $installationModel->getInstallationDetailsRecordForView($orderId); 
            $this->data['installationDetailsArr'] = $installationDetailsArr;

            $payment = new PaymentModel();
            $paymentArr = $payment->getPaymentetailsRecordForView($orderId); 
            $this->data['paymentArr'] = $paymentArr;
            
            return View::make('orders.show_order_details', $this->data);
        }catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            //return View::make('orders.add_installation', $this->data);
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }

    }
    public function showInstallation() {
        try {
            $orderModel = new OrderModel();
            $orderList = $orderModel->getOrderList();
            $this->data['orderList'] = $orderList;

            $usersModel = new UsersModel();
            $installationPersonList = $usersModel->getInstallationUserList();
            $this->data['installationPersonList'] = $installationPersonList;

            return View::make('orders.add_installation', $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            //return View::make('orders.add_installation', $this->data);
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
        
    }

    /*
    ** add installation details
     */
    public function updateInstallationDetails(Request $request){
        try {
            $orderId = $request->input('orderIdToSubmit');
            $installationData = $request->all();
            $installationModel = new InstallationModel();
            $installationModel = $installationModel->updateInstallationDetails($installationData);
            if($installationModel) {
                //$orderModel = new OrderModel();
                $orderDetails = OrderModel::find($orderId);
                if ($orderDetails != null) {
                    $orderDetails->update(array(
                        'is_installation_done' => true,
                    ));
                }
            }

            Log::info("orderData==>".json_encode($installationData));
            return View::make('orders.add_installation', $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            //return View::make('orders.add_installation', $this->data);
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }
    public function showPaymentDetails() {
        try {
            $orderModel = new OrderModel();
            $orderList = $orderModel->getOrderList();
            //Log::info("orderList==>".json_encode($orderList));
            $this->data['orderList'] = $orderList;
            return View::make('orders.add_payment_details', $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            //return View::make('orders.add_installation', $this->data);
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }

    public function getOrderPaymentDetails(Request $request, $orderId) {
        try {
            $orderModel = new OrderModel();
            $paymentList = $orderModel->getOrderPaymentDetails($orderId);
            return response()->json(array('paymentList' => $paymentList), 200);
        } catch (Exception $e) {
            Log::info("Something went wrong while fetching order payment details!" . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }

    public function submitPaymentDetails(Request $request) {
        try {
            $paymentModel = new PaymentModel();
            $paymentDetails = $request->all();
            $payment = $paymentModel->savePaymentDetails($paymentDetails);
            if ($payment) {
                return redirect('/add/paymentdetails');
            } else {
                return back()->with('error', 'Something went wrong...');
            }
        } catch (Exception $e) {
            Log::info("Something went wrong while saving order payment details!" . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }

    public function orderCount () {
        $orderModel = new OrderModel();
        $count = $orderModel->getAllOrdersCount();
        $this->data['count'] = $count;
    }
     /**
     * This method is used to export Customer Data
     */
    public function exportOrderData() 
    {
        return Excel::download(new OrderExport, 'order_master_data.xlsx');
    }

    /**
     * This method is used to genearte Order Form PDF
     */
    public function generateOrderFormPDF($orderId) {

        /*$this->fpdf = new Fpdf;
        $this->fpdf->AddPage("L", ['100', '100']);
        $this->fpdf->Text(10, 10, "Hello FPDF");       
        $this->fpdf->SetFont('Times');
        $this->fpdf->Output();
        exit;*/
        try {
            $orderModel = new OrderModel();
            $orderDetails = $orderModel->getOrderRecordForView($orderId);
            $this->data['orderDetails'] = $orderDetails;

            $orderDetailsModel = new OrderDetailsModel();
            $orderDetailsArr = $orderDetailsModel->getOrderDetailsRecordForEdit($orderId);
            $this->data['orderDetailsArr'] = $orderDetailsArr;

            $installationModel = new InstallationModel();
            $installationDetailsArr = $installationModel->getInstallationDetailsRecordForView($orderId); 
            $this->data['installationDetailsArr'] = $installationDetailsArr;

            $payment = new PaymentModel();
            $paymentArr = $payment->getPaymentetailsRecordForView($orderId); 
            $this->data['paymentArr'] = $paymentArr;
            Log::info("Details captured:::::::");
           $pdf = PDF::loadView('orders.order_form_pdf',  $this->data);
            return $pdf->download('orderform.pdf');
           // return view('orders.order_form_pdf', $this->data);
           
        }catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            //return View::make('orders.add_installation', $this->data);
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }

      
          
    }

}
