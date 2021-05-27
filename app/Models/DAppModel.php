<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use App\Models\Order\PaymentModel;
use App\Models\Order\OrderInstallationAddress;
use \DateTime;

class DAppModel extends Model {
    public function getFinYear() {
        // Get current Year and month
        $currentYear = intVal(date("Y"));
        $currentShortYear = intVal(date("y"));
        $currentMonth = intVal(date("m"));

        $lowerMonth = 0;
        $upperMonth = 0;
        $lowerYear = 0;
        $upperYear = 0;

        if ($currentMonth > 3 && $currentMonth <= 12) { $lowerMonth=4; $lowerYear=$currentYear;
            $lowerShortYear = $currentShortYear;
            $upperMonth = 3;
            $upperYear = $currentYear + 1;
            $upperShortYear = $currentShortYear + 1;
        } else {
            $lowerMonth = 4;
            $lowerYear = $currentYear - 1;
            $upperMonth = 3;
            $upperYear = $currentYear;
            $lowerShortYear = $currentShortYear - 1;
            $upperShortYear = $currentShortYear;
        }
        return array(
            "lowerMonth"=> $lowerMonth,
            "lowerYear" => $lowerYear,
            "upperMonth" => $upperMonth,
            "upperYear" => $upperYear,
            "finYear" => $lowerYear . "-" . $upperYear,
            "shortFinYear" => $lowerShortYear . "-" . $upperShortYear,
            "finYearStartDate" => DateTime::createFromFormat('d/m/Y', '01/' . $lowerMonth . '/' . $lowerYear),
            "finYearEndDate" => DateTime::createFromFormat('d/m/Y', '31/' . $upperMonth . '/' . $upperYear)
        );
    }
}
