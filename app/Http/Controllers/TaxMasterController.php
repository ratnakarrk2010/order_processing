<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Tax\TaxModel;
use App\Http\Controllers\CommonController;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Users\UsersModel;

class TaxMasterController extends CommonController
{
    public function index(Request $request) {
        $taxModel = new TaxModel();
        $allTaxes = $taxModel-> getAllTaxDetails();
        $this->data['allTaxes'] = $allTaxes;
        return View::make("master.tax_list", $this->data);
    }

    public function saveTax(Request $request) {
        try {
                $taxModel = new TaxModel() ;
                $taxModel->tax_name = $request->input('tax_name');
                $taxModel->tax_value = $request->input('tax_value');
                $taxModel->created_by = Session::get("loggedInUserId");
                $isSaved = $taxModel->save();
                //Log::info("IsSaved==>" . $isSaved);
                if ($isSaved) {
                    return back()->with('success', 'Tax Created Successfully!');
                }
            } catch (Exception $e) {
                Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
                return back()->with('error', 'Something went wrong...!');
                Log::error($e);
            }

    }

    public function deleteTax(Request $request, $taxId){
        try {
            $taxModel = new TaxModel() ;
            $isUpdated = $taxModel->softDeleteTax($taxId);
            $allTaxes = $taxModel-> getAllTaxDetails();
            $this->data['allTaxes'] = $allTaxes;
            
            if($isUpdated) {
                $this->data['success_message'] = "Tax Deleted Successfully!";
            }else {
                $this->data['error_message'] = "Something went wrong while deleting the Tax Data!";
            }
            return View::make("master.tax_list", $this->data);
        } catch(Exception $e) {
            $allTaxes = $taxModel-> getAllTaxDetails();
            $this->data['allTaxes'] = $allTaxes;
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return View::make('master.tax_list', $this->data);
        }
    }
    public function updateTaxDetails(Request $request){
        try {
            //$roleId = $request->input('id');
            $taxData = $request->all();
            $taxModel = new TaxModel() ;
            $isUpdated = $taxModel->updateTaxDetails($taxData);
            if($isUpdated) {
                return back()->with('success', 'Tax Created Successfully!');
            }
            //Log::info("roleData==>".json_encode($taxData));
            return View::make('master.tax_list', $this->data);
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            $this->data['exception_message'] = "Something went wrong...";
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }
    
}
