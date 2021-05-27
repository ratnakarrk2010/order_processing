<?php

namespace App\Models\Order;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class OrderInstallationAddress extends Model {
    protected $table = 'order_installation_addresses';

    public function __construct()
    {
        $this->fillable = [
            'id','order_id', 'order_installation_id', 'installation_address', 'created_at', 'updated_at','created_by', 'updated_by'
        ];
    
    }
}
