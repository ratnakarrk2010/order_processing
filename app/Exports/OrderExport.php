<?php
namespace App\Exports;

use App\Models\Order\OrderModel;
use App\Models\Order\OrderDetailsModel;
use App\Models\Order\PaymentModel;
use App\Models\Order\InstallationModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Order\ViewModel;

class OrderExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return ViewModel::all();
       
    }
    public function headings(): array
    {
        return [
            'ORDER_ID', 
            'OPF_NO', 'OPF_DATE', 'PO_NO', 'PO_DATE', 'CUSTOMER',
            'TYPE_OF_CUSTOMER', 'CUSTOMER_EMAIL', 'CUSTOMER_ADDRESS', 'CONTACT_PERSON_1',
            'CONTACT_NO_1', 'CONTACT_PERSON_2','CONTACT_NO_2', 'INSTALLATION_ADDRESS', 'ORDER_COLLECTED_BY',
            'WARRANTY_PERIOD', 'SALES_INITIATED_BY','APPROVED_BY', 'TOTAL_PO_VALUE', 'MATERIAL_PROCUREMENT_DATE',
            'QC_TESTING_RESULT', 'DISPATCH_DATE', 'REMARKS','INVOICE_NO', 'INVOICE_DATE','PAYMENT_TERMS',
            'INSTALLATION_DONE', 'FINAL_PAYMENT_DONE', 'ORDER_CREATED_BY', 'ORDER_CREATED_AT', 
            'INSTALLATION_ASSIGNED_TO', 'INSTALLATION_START_DATE','INSTALLTION_COMPLETION_DATE', 
            'DOCUMENTATION_COMPLETED', 'INSTALLATION_SERVICE_COMPLETED',
            'INSTALLATION_CREATED_BY', 'INSTALLATION_CREATED_AT','MATERIALS','QUANTITY','DC_NO',
            'DC_DATE','PRODUCT_SERIAL_NUMBER','TOTAL_PAYMENT_RECEIVED','BALANCE_PAYMENT','LAST_PAYMENT_RECEIVED_DATE',
            'FINAL_PAYMENT', 'FINAL_PAYMENT_DATE','OS_DAYS'
         
        ];
    }
}