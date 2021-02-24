<?php
namespace App\Exports;

use App\Models\Customer\CustomerModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomerExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return CustomerModel::all();
       
    }
    public function headings(): array
    {
        return [
            'Id',
            'Customer Name',
            'Type Of Customer',
            'Eamil Id',
            'Address',
            'Contact1',
            'Contact Person1',
            'Contact2',
            'Contact Person2',
            'Is Deleted',
            'Created At',
            'Created By',
            'Updated Date',
            'Updated By'
         
        ];
    }
}