<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class InstallationModel extends Model{
    protected $table = 'installation_details';

    public function __construct()
    {

        $this->fillable = [
            'id', 'customer_id', 'order_id', 'installation_assigned_to_id','installation_assigned_to',
            'installation_start_date', 'installation_completion_date', 'doc_completed',
            'installation_serivice_completed','created_at', 'updated_at','created_by', 'updated_by'
        ];

    
    }
    public function getOrderList() {
        $query = DB::table('orders')
        ->join('customer_details', 'customer_details.id', '=', 'orders.customer_id')
        ->select('orders.*','customer_details.client_name')->get();   
        return $query;
        
    }  
    
    public function updateInstallationDetails($installationData) {
        $installationObj = OrderModel::find($installationData['orderIdToSubmit']);

        $order = OrderModel::find($installationData['orderIdToSubmit']);
        $installationModel = null;
        $installationModel = InstallationModel::where('order_id', $installationData['orderIdToSubmit']);
        if($installationModel == null) {
            $installationModel = new InstallationModel();

            $installationModel->customer_id = $order->customer_id;
            $installationModel->order_id = $order->id;
            $installationModel->installation_assigned_to = $installationData['installation_assigned_to'];
            $installationModel->installation_assigned_to_id = $installationData['installation_assigned_to_id'];
            
            $installationModel->installation_start_date = $installationData['installation_start_date'];
            $installationModel->installation_completion_date = $installationData['installation_completion_date'];
            $installationModel->doc_completed = $installationData['doc_completed'];
            $installationModel->installation_serivice_completed = $installationData['installation_serivice_completed'];
            
    
            $installationModel->created_by = Session::get("loggedInUserId");
            $installationModel->save();
        } else{
            $installationModel->update(array(
                'customer_id' => $order->customer_id,
                'installation_assigned_to' => $installationData['installation_assigned_to'],
                'installation_assigned_to_id' => $installationData['installation_assigned_to_id'],
                'installation_start_date' => $installationData['installation_start_date'],
                'installation_completion_date' => $installationData['installation_completion_date'],
                'doc_completed' => $installationData['doc_completed'],
                'installation_serivice_completed' => $installationData['installation_serivice_completed'],
                'created_by' => Session::get("loggedInUserId")
                
            ));
        }
      
        return $installationModel;
        /*
        Log::info("installationObj->".$installationObj);
        $installationData['updated_by'] = Session::get("loggedInUserId");
        $isUpdated = $installationObj->update($installationData);
        return $isUpdated;*/
    }

     /**
    * This function is used to get orderDetails record for edit
    */

  
    public function getInstallationDetailsRecordForView($orderId) {
        $installationDetailsQueryResult = DB::table('installation_details')
        ->join('orders', 'orders.id', '=', 'installation_details.order_id')
        ->where('installation_details.order_id',$orderId)
        ->select('installation_details.*')->get();
        Log::info("size" . sizeof($installationDetailsQueryResult));
        Log::info("::::".json_encode($installationDetailsQueryResult));
        if (sizeof($installationDetailsQueryResult) > 0) {
            return $installationDetailsQueryResult[0];
        } else {
            return [];
        }
    } 

    public function getInstalltionAssignedTo($orderId){
        $installationModel = new InstallationModel();
        $installationAssignedToDetails = InstallationModel::where('order_id', $orderId)->get();
        return $installationAssignedToDetails;
    }

   
   
}
