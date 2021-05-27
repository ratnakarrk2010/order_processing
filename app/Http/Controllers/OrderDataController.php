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
use App\Models\Tax\TaxModel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
//use PDF;
use Barryvdh\DomPDF\Facade as PDF;
use PhpOffice\PhpSpreadsheet\Writer\Pdf as WriterPdf;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Models\Order\OrderInstallationAddress;
ini_set('max_execution_time', 300);
use App\Models\PaymentTerms\PaymentTermsModel;
class OrderDataController extends CommonController {

    function __construct() {
        parent::__construct();
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

        $paymentTermsModel = new PaymentTermsModel();
        $allPaymentTerms = $paymentTermsModel->getAllPaymentTerms();
        $this->data['allPaymentTerms'] = $allPaymentTerms;

		 $taxModel = new TaxModel();
        $allTaxes = $taxModel-> getAllTaxDetails();
        $this->data['allTaxes'] = $allTaxes;
		
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

            $paymentTermsModel = new PaymentTermsModel();
            $allPaymentTerms = $paymentTermsModel->getAllPaymentTerms();
            $this->data['allPaymentTerms'] = $allPaymentTerms;
			 
			$taxModel = new TaxModel();
			$allTaxes = $taxModel-> getAllTaxDetails();
			$this->data['allTaxes'] = $allTaxes;
		
            $orderModel = new OrderModel();
            //$orderModel->order_id = $request->input('order_id');
            $orderModel->customer_id = $request->input('customer_id');
            // $orderModel->opf_no = $request->input('opf_no');

            // Generate OPF Number
            //$opfNumDetails = $orderModel->getNextOpfNo();
		
			$opf_date = $request->input('opf_date');
            $opfNumDetails = $orderModel->getNextOpfNoByOPFDate($opf_date);
		
            $orderModel->opf_no = $opfNumDetails['opfNo'];
            $orderModel->opf_num = $opfNumDetails['opfNum'];
                                
            //$opf_date = $request->input('opf_date');
            $orderModel->opf_date= Carbon::parse($opf_date)->format('Y-m-d');
            $orderModel->po_no = $request->input('po_no');
            $orderModel->po_date = $request->input('po_date');
            
            /*$orderModel->invoice_no = $request->input('invoice_no');
            $orderModel->invoice_date = $request->input('invoice_date');*/

            //$orderModel->installation_address = $request->input('installation_address');
            $orderModel->material_procurement_date = $request->input('material_procurement_date');
            $orderModel->approved_by = $request->input('approved_by');
            $orderModel->approved_by_id = $request->input('approved_by_id');
            $orderModel->order_collected_by = $request->input('order_collected_by');
            $orderModel->order_collected_by_id = $request->input('order_collected_by_id');
            $orderModel->qc_testting_result = $request->input('qc_testting_result');
            $orderModel->remarks = $request->input('remarks');
            $orderModel->sales_initiator_by = $request->input('sales_initiator_by');
            $orderModel->sales_initiator_by_id = $request->input('sales_initiator_by_id');
            
			$orderModel->tax_id = $request->input('tax_id');
            $orderModel->tax_value = $request->input('tax_value');
            $orderModel->total_po_value = $request->input('total_po_value');
            $orderModel->total_order_amount = $request->input('total_order_amount');
            $orderModel->tax_amount = $request->input('tax_amount');
            $orderModel->warranty_period = $request->input('warranty_period');
            $orderModel->dispatch_date = $request->input('dispatch_date');
            $orderModel->payment_terms = $request->input('payment_terms');
            $orderModel->payment_terms_id = $request->input('payment_terms_id');
            $orderModel->order_status = $request->input('order_status');
            
            //Order Details Save
            $materialsArr = $request->input('materials');
            $quantityArr = $request->input('quantity');
            //$invoice_noArr = $request->input('invoice_no');
            //$invoice_dateArr = $request->input('invoice_date');
            $makeArr = $request->input('make');
            $modelsArr = $request->input('model');
            //$dc_noArr = $request->input('dc_no');
            //$dc_dateArr = $request->input('dc_date');
            //$product_serial_noArr = $request->input('product_serial_no');
            $orderModel->created_by = Session::get("loggedInUserId");

            //$orderModel->ld_clause_applicable = $request->input('ld_clause_applicable');
            $orderModel->delivery_period = $request->input('delivery_period');
            $orderModel->other_terms = $request->input('other_terms');

            $isSaved = $orderModel->save();

            //OrderInstallationAddress

            $installation_addresses = $request->input('installation_address');
            for ($i = 0; $i < sizeof($installation_addresses); $i++) {
                $orderInstallationAddress = new OrderInstallationAddress();
                $orderInstallationAddress->order_id = $orderModel->id;
                $orderInstallationAddress->installation_address = $installation_addresses[$i];
                $orderInstallationAddress->created_by = Session::get("loggedInUserId");
                $orderInstallationAddress->save();
            }
          
            for ($i = 0; $i < count($materialsArr); $i++) {
                $orderDetails = new OrderDetailsModel();
                $orderDetails->materials = $materialsArr[$i];
                $orderDetails->make = $makeArr[$i];
                $orderDetails->model = $modelsArr[$i];
                $orderDetails->quantity = $quantityArr[$i];
                //$orderDetails->invoice_no = $invoice_noArr[$i];
                //$orderDetails->invoice_date = $invoice_dateArr[$i];
                /*$orderDetails->dc_no = $dc_noArr[$i];
                $orderDetails->dc_date = $dc_dateArr[$i];
                $orderDetails->product_serial_no = $product_serial_noArr[$i];*/
                $orderDetails->order_id = $orderModel->id;
                $orderDetails->customer_id = $orderModel->customer_id;
                $orderDetails->created_by = Session::get("loggedInUserId");
                $isSaved = $orderDetails->save();
               
            }

            if ($isSaved) {
                $this->data['success_message'] = "Order Processed Successfully! OPF No: " . $opfNumDetails['opfNo'];;
                //return view('customer.add_new_customer', $this->data);
                return back()->with('success', 'Order Processed Successfully! OPF No: ' . $opfNumDetails['opfNo']);
            }
        }catch (Exception $e) {
            Log::error($e);
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            Log::error($e);
            return back()->with('error', 'Something went wrong...!');
            //return View::make('customer.add_new_customer', $this->data);
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

            $paymentTermsModel = new PaymentTermsModel();
            $allPaymentTerms = $paymentTermsModel->getAllPaymentTerms();
            $this->data['allPaymentTerms'] = $allPaymentTerms;

			$taxModel = new TaxModel();
            $allTaxes = $taxModel-> getAllTaxDetails();
            $this->data['allTaxes'] = $allTaxes;
			
            $orderDetailsModel = new OrderDetailsModel();
            $orderDetailsArr = $orderDetailsModel->getOrderDetailsRecordForEdit($orderId);

            $installationAddresses = $orderModel->getOrderInstallationAddress($orderId);

            $this->data['orderDetailsArr'] = $orderDetailsArr;
            $this->data['installationAddresses'] = $installationAddresses;
            $this->data['loggedInUser'] = Session::get("loggedInUserId");
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
            $makeArr = $request->input('make');
            $modelArr = $request->input('model');
            //$dc_noArr = $request->input('dc_no');
            //$dc_dateArr = $request->input('dc_date');
            //$product_serial_noArr = $request->input('product_serial_no');
            $orderDetailsIdArr = $request->input("orderDetailsId");
            $installationAddresses = $request->input("installation_address");
            $installationAddressIdArr = $request->input("installation_address_id");
            $loggedInUser = $request->input("loggedInUser");
            if($orderDetailsIdArr && sizeof($orderDetailsIdArr) >0) {
                for ($i = 0; $i < sizeof($orderDetailsIdArr); $i++) {
                    $orderDetailId = $orderDetailsIdArr[$i];
                    if ($orderDetailId == 0) {
                        // Insert
                        $orderDetails = new OrderDetailsModel();
                        $orderDetails->materials = $materialsArr[$i];
                        $orderDetails->make = $makeArr[$i];
                        $orderDetails->model = $modelArr[$i];
                        $orderDetails->quantity = $quantityArr[$i];
                        //$orderDetails->invoice_no = $invoice_noArr[$i];
                        //$orderDetails->invoice_date = $invoice_dateArr[$i];
                        /*$orderDetails->dc_no = $dc_noArr[$i];
                        $orderDetails->dc_date = $dc_dateArr[$i];
                        $orderDetails->product_serial_no = $product_serial_noArr[$i];*/
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
                                'make' => $makeArr[$i],
                                'model' => $modelArr[$i],
                                'quantity' => $quantityArr[$i],
                                //'invoice_no' => $invoice_noArr[$i],
                                //'invoice_date'=> $invoice_dateArr[$i],
                                /*'dc_no' => $dc_noArr[$i],
                                'dc_date' => $dc_dateArr[$i],
                                'product_serial_no' => $product_serial_noArr[$i],*/
                                'order_id' => $request->input('id'),
                                'customer_id' => $request->input('customer_id'),
                                'created_by' => Session::get("loggedInUserId"),
                                'updated_by' => Session::get("loggedInUserId")
                               
                            ));
                        }
                       
                    }
                }
            }

            if ($installationAddresses && sizeof($installationAddresses) > 0) {
                for ($i = 0; $i < sizeof($installationAddresses); $i++) {
                    $installationAddress = $installationAddresses[$i];
                    $installationAddressId = $installationAddressIdArr[$i];
                    Log::info("installationAddressId: " . $installationAddressId);
                    if ($installationAddressId == 0) {
                        $orderInstallationAddress = new OrderInstallationAddress();
                        $orderInstallationAddress->order_id = $orderData['id'];
                        $orderInstallationAddress->installation_address = $installationAddress;
                        $orderInstallationAddress->updated_by = $loggedInUser;
                        $orderInstallationAddress->updated_at = date('Y-m-d H:i:s');
                        $orderInstallationAddress->save();
                    } else {
                        $orderInstallationAddress = OrderInstallationAddress::find($installationAddressId);
                        if ($orderInstallationAddress != null) {
                            $orderInstallationAddress->update(array(
                                'order_id' => $orderData['id'],
                                'installation_address' => $installationAddress,
                                'created_by' => $loggedInUser,
                                'created_at' => date('Y-m-d H:i:s')
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

            //Get installation address
            $this->data['installationAddresses'] = $orderModel->getInstallationAddressesForOrder($orderId);

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
            $orderList = $orderModel->getOrderListForInstallation();
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
    ** Assigned installation Person
     */
    public function saveInstallationPerson(Request $request) {
        try{
            $installationModel = new InstallationModel();
            $installationModel->installation_assigned_to_id = $request->input("installation_assigned_to_id");
            $installationModel->installation_assigned_to = $request->input("installation_assigned_to");
            $order = OrderModel::find($request->input('orderIdToSubmitForAssignedTo'));
            $installationModel->customer_id = $order->customer_id;
            $installationModel->order_id = $order->id;
            $isSaved = $installationModel->save();
              
            Log::info("IsSaved==>" . $isSaved);
    
            if ($isSaved) {
                if ($order != null) {
                    $order->update(array(
                        'is_installation_assigned' => true,
                    ));
                }
                //$this->data['success_message'] = "Installation Person Assigned Successfully!";
                //return view('customer.add_new_customer', $this->data);
                //return back()->with('success', 'Installation Person Assigned Successfully!');
                //return View::make('orders.add_installation', $this->data);
                return redirect('/add/installation');
            }
        } catch (Exception $e) {
            Log::error($e);
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            return back()->with('error', 'Something went wrong...!');
            //return View::make('customer.add_new_customer', $this->data);
        }
    }
    /*
    * This function is used to fetch instalationassigned to 
    */
    public function fetchInstallationAssignedTo($orderId) {
        try{
            $installationModel = new InstallationModel();
            $installationDetails = $installationModel->getInstalltionAssignedTo($orderId);
            Log::info("installationAddress==>".$installationDetails);
            if ($installationDetails) {
                return response()->json(array("success" => true, 
                "message" => "Installation Details Returned Successfully!",
                "assigedTo" => $installationDetails), 200);
            } else {
                return response()->json(array("success" => false, "message" => "Something went wrong while get the installation details!"), 400);
               
            }
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            Log::error($e);
        }

    }

    /*
    ** add installation details
     */
    public function updateInstallationDetails(Request $request){
        try {
            $orderModel = new OrderModel();
            $orderList = $orderModel->getOrderListForInstallation();
            $this->data['orderList'] = $orderList;

            $usersModel = new UsersModel();
            $installationPersonList = $usersModel->getInstallationUserList();
            $this->data['installationPersonList'] = $installationPersonList;
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
            Log::info("thisdata: " . json_encode($this->data));
            //return View::make('orders.add_installation', $this->data);
            return redirect('/add/installation');
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
            $orderList = $orderModel->getOrderListForPayment();
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

            //Get installation address
            $this->data['installationAddresses'] = $orderModel->getInstallationAddressesForOrder($orderId);

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
           //$pdf = PDF::loadView('orders.order_form_pdf', $this->data)->setPaper('a4', 'landscape');
           $pdf = PDF::loadView('orders.order_form_pdf', $this->data);
           return $pdf->download('orderform.pdf');
           // return view('orders.order_form_pdf', $this->data);
           
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            //return View::make('orders.add_installation', $this->data);
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }

    function removeInstallationAddress(Request $request, $installationAddressId) {
        $orderModel = new OrderModel();
        $isDeleted = $orderModel->deleteInstallationAddress($installationAddressId);

        if ($isDeleted) {
            return response()->json(array("success" => true, "message" => "Installation Address Deleted Successfully!"), 200);
        } else {
            return response()->json(array("success" => false, "message" => "Something went wrong while deleting the installation address!"), 400);
        }
    }

    function removeOrderDetails(Request $request, $orderDetailsId) {
        try {
            $orderDetailsModel = new OrderDetailsModel();
            $isDeleted = $orderDetailsModel->deleteOrderDetails($orderDetailsId);
            if ($isDeleted) {
                return response()->json(array("success" => true, "message" => "Orders Details Deleted Successfully!"), 200);
            } else {
                return response()->json(array("success" => false, "message" => "Something went wrong while deleting the Order Details address!"), 400);
            }
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            Log::error($e);
        }
    }

    function updatePaymentDetails(Request $request) {
        try {
            $paymentModel = new PaymentModel();
            $paymentDetails = $request->all();
            Log::info("paymentDetails ::: " . json_encode($paymentDetails));
            $payment = $paymentModel->updatePaymentDetail($paymentDetails);
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

    function validateInvoiceNo(Request $request) {
        try {
            $invocieNo = $request->input('invoiceNo');
            $paymentDetails = PaymentModel::where('invoice_no', $invocieNo)->get();
            if (sizeof($paymentDetails) > 0) {
                return response()->json(array("isValid" => false), 200);
            } else {
                return response()->json(array("isValid" => true), 200);
            }
        } catch (Exception $e) {
            Log::info("Something went wrong while validating invoice number!" . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong while validating invoice number";
            return response()->json(array("isValid" => false, 'message' => "Something went wrong while validating invoice number"), 400);
            Log::error($e);
        }
    }
}
