<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\PaymentTerms\PaymentTermsModel;
use App\Http\Controllers\CommonController;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class PaymentTermsController extends CommonController
{
    public function index(Request $request) {
        $paymentTermsModel = new PaymentTermsModel();
        $allPaymentTerms = $paymentTermsModel->getAllPaymentTerms();
        $this->data['allPaymentTerms'] = $allPaymentTerms;
        return View::make("master.payment_terms", $this->data);
    }

    public function savePaymentTerms(Request $request) {
        try {
                $paymentTermsModel = new PaymentTermsModel() ;
                $paymentTermsModel->payment_terms = $request->input('payment_terms');
                $paymentTermsModel->value_figure = $request->input('value_figure');
                $paymentTermsModel->created_by = Session::get("loggedInUserId");
                $isSaved = $paymentTermsModel->save();
                //Log::info("IsSaved==>" . $isSaved);
                if ($isSaved) {
                    return back()->with('success', 'Payment Terms Created Successfully!');
                }
            } catch (Exception $e) {
                Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
                return back()->with('error', 'Something went wrong...!');
                Log::error($e);
            }

    }

    public function deletePaymentTerms(Request $request, $ptId){
        try {
            $paymentTermsModel = new PaymentTermsModel();
            $isUpdated = $paymentTermsModel->softDeletePaymentTerms($ptId);
            $allPaymentTerms = $paymentTermsModel->getAllPaymentTerms();
            $this->data['allPaymentTerms'] = $allPaymentTerms;
            
            if($isUpdated) {
                $this->data['success_message'] = "Payment Terms Deleted Successfully!";
            }else {
                $this->data['error_message'] = "Something went wrong while deleting the PaymentTerms Data!";
            }
            return View::make("master.payment_terms", $this->data);
        } catch(Exception $e) {
            $allPaymentTerms = $paymentTermsModel->getAllPaymentTerms();
            $this->data['allPaymentTerms'] = $allPaymentTerms;
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('master.role_list', $this->data);
        }
    }
    public function updatePaymentTermsDetails(Request $request){
        try {
            //$roleId = $request->input('id');
            $paymentTermsData = $request->all();
            $paymentTermsModel = new PaymentTermsModel();
            $isUpdated = $paymentTermsModel->updatePaymentDetails($paymentTermsData);
            if($isUpdated) {
                return back()->with('success', 'Payement Terms Updated Successfully!');
            }
            //Log::info("roleData==>".json_encode($roleData));
            return View::make("master.payment_terms", $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }
}