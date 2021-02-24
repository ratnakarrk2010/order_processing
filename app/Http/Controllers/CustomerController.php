<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Customer\CustomerModel;
use App\Models\Users\UsersModel;
use App\Http\Controllers\CommonController;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;
class CustomerController extends CommonController
{
    //
    public function __construct(){
        parent::__construct();
    }

    public function index() {
       
        return View::make('customer.add_new_customer', $this->data);
    }
    
    /**"
     * Save users
     */
    
    public function createCustomer(Request $request)
    {
        try {
            
            $customerModel = new CustomerModel();
            $customerModel->client_name = $request->input('client_name');
            $customerModel->type_of_customer = $request->input('type_of_customer');
            $customerModel->email_id = $request->input('email_id');
            $customerModel->address = $request->input('address');
            $customerModel->contact1 = $request->input('contact1');
            $customerModel->contact_person1 = $request->input('contact_person1');
            $customerModel->contact2 = $request->input('contact2');
            $customerModel->contact_person2 = $request->input('contact_person2');
            $customerModel->created_by = Session::get("loggedInUserId");
            $isSaved = $customerModel->save();
          
            Log::info("IsSaved==>" . $isSaved);

            if ($isSaved) {
                $this->data['success_message'] = "Customer Created Successfully!";
                //return view('customer.add_new_customer', $this->data);
                return back()->with('success', 'Customer Created Successfully!');
            }
        } catch (Exception $e) {
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
            $customerModel = new CustomerModel();
            $customerList = $customerModel->getCustomerList();
            Log::info("customerList==>".json_encode($customerList));
            $this->data['customerList'] = $customerList;
            return View::make('customer.all_customers', $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('customer.all_customers', $this->data);
            Log::error($e);
        }
    }
     /**
     * This function is used to get record for edit details
     */
    public function edit($userId) {
        try {
                     
            $customerModel = new CustomerModel();
            $customerData = $customerModel->getCustomerRecordForEdit($userId);
            $this->data['customerData'] = $customerData;
            return View::make('customer.edit_customer', $this->data);
        } catch(Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('customer.edit_customer', $this->data);
        }
    }
    public function update(Request $request){
        try {
            $customerData = $request->all();
            $customerModel = new CustomerModel();
            $isUpdated = $customerModel->updateCustomerDetails($customerData);
            Log::info("isUpdated==>".$isUpdated);
            $customerList = $customerModel->getCustomerList();
            $this->data['customerList'] = $customerList;
            
            if($isUpdated) {
                $this->data['success_message'] = "Customer Data Updated Successfully!";
            }else {
                $this->data['error_message'] = "Something went wrong while updating the Customer Data!";
            }
            return View::make('customer.all_customers', $this->data);
            //return back()->with('success', 'Customer Updated Successfully!');
            //return redirect('')
        } catch(Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return back()->with('error', 'Something went wrong!');
        }
    }
    public function deleteCustomer(Request $request, $custId){
        try {
            $customerModel = new CustomerModel();
            $isUpdated = $customerModel->softDeleteCustomer($custId);
            $customerList = $customerModel->getCustomerList();
            $this->data['customerList'] = $customerList;
            
            if($isUpdated) {
                $this->data['success_message'] = "Customer Deleted Successfully!";
            }else {
                $this->data['error_message'] = "Something went wrong while deleting the Customer Data!";
            }
            return View::make('customer.all_customers', $this->data);
        } catch(Exception $e) {
            $customerList = $customerModel->getCustomerList();
            $this->data['customerList'] = $customerList;
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('customer.all_customers', $this->data);
        }
    }

    /**
     * This method is used to export Customer Data
     */
    public function exportCustomerData() 
    {
        return Excel::download(new CustomerExport, 'customer_data.xlsx');
    }

}