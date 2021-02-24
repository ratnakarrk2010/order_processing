<?php
namespace App\Exports;

use App\Models\Users\UsersModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return UsersModel::all();
       
    }
    public function headings(): array
    {
        return [
            'Id',
            'Role',
            'Username',
            'Password',
            'First Name',
            'Last Name',
            'Email',
            'Created By',
            'Created Date',
            'Updated By',
            'Updated Date',
            'Is Active',
            'Is Deleted'




        ];
    }
}