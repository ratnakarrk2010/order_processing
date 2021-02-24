<?php 

namespace App\Http\Controllers;
use Google\Spreadsheet\SpreadsheetService;
use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use Illuminate\Support\Facades\Log;
use Google\Spreadsheet\ListEntry;
use Google_Client;
use Illuminate\Http\Request;


class GoogleSpreadSheetController extends Controller {

    private $accessToken = null;

    function __construct() {
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . app_path() . '/GSheetIntegration-b41181b9e994.json');
        $client = new Google_Client;
        $client->useApplicationDefaultCredentials();

        $client->setApplicationName("Something to do with my representatives");
        $client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds']);

        if ($client->isAccessTokenExpired()) {
            $client->refreshTokenWithAssertion();
        }

        //Log::info("=====>".json_encode($client->fetchAccessTokenWithAssertion()));

        $this->accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
        ServiceRequestFactory::setInstance(new DefaultServiceRequest($this->accessToken));
    }

    function submitOrder(Request $request) {
        //Log::info("Token: ".$this->accessToken);
        /*$serviceRequest = new DefaultServiceRequest($this->accessToken);
        ServiceRequestFactory::setInstance($serviceRequest);*/
        try {
            // Get our spreadsheet
            $spreadsheetService = new SpreadsheetService();
            //$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
            //$spreadsheet = $spreadsheetService->getSpreadsheetFeed()->getByTitle($request->spreadsheetName);

            $spreadsheet = $spreadsheetService->getSpreadsheetFeed()->getByTitle('Test_Spreadsheet');

            //$spreadsheet = $spreadsheetService->getPublicSpreadsheet('1DL0RlVqVm_HUggltjVAk0cUlUTd0uWSYj3mJowiKW-0');

            // Get the first worksheet (tab)
            $worksheets = $spreadsheet->getWorksheetFeed()->getEntries();

            $worksheet = null;
            if ($request->input('sheetName') !== "") {
                foreach ($worksheets as $ws) {
                    if ($ws->getTitle() == $request->input('sheetName')) {
                        $worksheet = $ws;
                        break;
                    }
                }
                if($worksheet == null){
                    $worksheet = $worksheets[0];
                }
            } else {
                $worksheet = $worksheets[0];
            } 
           

            $cellFeed = $worksheet->getCellFeed();
            //$rows = $cellFeed->toArray();

            $attributesToInsert = array(
                "opfNo" => array("row" => 2, "column" => 3),
                "opfDate" => array("row" => 2, "column" => 5),
                "poNo" => array("row" => 2, "column" => 7),
                "clientName" => array("row" => 3, "column" => 3)
            );

            foreach ($attributesToInsert as $attr => $cellRowCol) {
                $cell = $cellFeed->getCell($cellRowCol['row'], $cellRowCol['column']);
                if ($cell != null) {
                    $cell->update($request->input($attr));
                }
            }

            // OPF No
            /*$opfNoCell = $cellFeed->getCell(2, 3);
            $opfNoCell->update($request->input('opfNo'));

            //OPF Date
            $opfDateCell = $cellFeed->getCell(2, 5);
            $opfDateCell->update($request->input('opfDate'));
            
            //PO No.
            $poNoCell = $cellFeed->getCell(2, 7);
            $poNoCell->update($request->input('poNo'));

            //Client Name
            $clientNameCell = $cellFeed->getCell(3, 3);
            $clientNameCell->update($request->input('clientName'));*/

            /**
             * Second sheet having table view
             * Order Tracking Master file 2020-21
             */

            $listSpreadsheet = $spreadsheetService->getSpreadsheetFeed()->getByTitle('Order Tracking Master file 2020-21');
            $wsList = $listSpreadsheet->getWorksheetFeed()->getEntries();
            $ws = $wsList[0];

            $listFeed = $ws->getListFeed();
            $entries = $listFeed->getEntries();

            $wsCellFeed = $ws->getCellFeed();
            $rows = $wsCellFeed->toArray();

            /*$row = new ListEntry();
            $row->data = ["ABC", "EXISTING (OLD)", 123, "01/23/2021"];

            $listFeed->insert($row);*/

            $entryList = array();
            foreach ($entries as $entry) {
                array_push($entryList, $entry->getValues());
            }

            $nextRowIndex = 0;

            $index = 0;
            foreach ($rows as $key => $row) {
                if ($index == (sizeof($rows) - 1)) {
                    $nextRowIndex = ((int) $key) + 1;
                }
                $index += 1;
            }

             $rowAttributesToInsert = array(
                "clientName" => array("row" => $nextRowIndex, "column" => 1),
                "typeOfCustomer" => array("row" => $nextRowIndex, "column" => 2, "data" => "EXISITNG (OLD)"),
                "opfNo" => array("row" => $nextRowIndex, "column" => 3),
                "opfDate" => array("row" => $nextRowIndex, "column" => 4),
             );

             $messages = array();
             foreach ($rowAttributesToInsert as $attr => $cellRowCol) {
                $cell = $wsCellFeed->getCell($cellRowCol['row'], $cellRowCol['column']);
                if ($cell != null) {
                    $cell->update($request->input($attr));
                } else {
                    Log::info("Cell (" . $cellRowCol['row'] . ", " . $cellRowCol['column'] . ") : is null.");
                    Log::info("Creating Cell (" . $cellRowCol['row'] . ", " . $cellRowCol['column'] . ")....");

                    $data = "";
                    if ($request->input($attr) == null) {
                        $data = $cellRowCol['data'];
                    } else {
                        $data = $request->input($attr);
                    }

                    $cellEntry = $wsCellFeed->createCell($cellRowCol['row'], $cellRowCol['column'], $data);
                    $wsCellFeed->editCell($cellRowCol['row'], $cellRowCol['column'], $data);
                }
             }

            //$nextRowIndex
            /*$wsCellFeed->createCell($nextRowIndex, 1, $request->input('clientName'));
            $wsCellFeed->createCell($nextRowIndex, 2, "EXISTING (OLD)");
            $wsCellFeed->createCell($nextRowIndex, 5, $request->input('opfNo'));*/

            return response()->json(array("sheetName" => $worksheet->getTitle(), "rows" => $rows, "entries" =>
            $entryList, "nextRowIndex" => $nextRowIndex));
        } catch(\Exception $e) {
            Log::error($e);
        }
    }

    function testCreateCell() {
        $spreadsheetService = new SpreadsheetService();
        $listSpreadsheet = $spreadsheetService->getSpreadsheetFeed()->getByTitle('Order_Tracking_Master_2020-21');
        $wsList = $listSpreadsheet->getWorksheetFeed()->getEntries();
        $ws = $wsList[0];

        $listFeed = $ws->getListFeed();
        $entries = $listFeed->getEntries();

        $wsCellFeed = $ws->getCellFeed();
        $rows = $wsCellFeed->toArray();

        /*$row = new ListEntry();
        $row->data = ["ABC", "EXISTING (OLD)", 123, "01/23/2021"];

        $listFeed->insert($row);*/

        $entryList = array();
        foreach ($entries as $entry) {
            array_push($entryList, $entry->getValues());
        }

        $nextRowIndex = 0;

        $index = 0;
        foreach ($rows as $key => $row) {
            if ($index == (sizeof($rows) - 1)) {
                $nextRowIndex = ((int) $key) + 1;
            }
            $index += 1;
        }

        $attributesToInsert = array(
            "opfNo" => array("row" => $nextRowIndex, "column" => 1, "data" => "My Client"),
            "opfDate" => array("row" => $nextRowIndex, "column" => 2, "data" => "EXISTING (OLD)"),
            "poNo" => array("row" => $nextRowIndex, "column" => 3, "data" => 15468454),
        );

        $messages = array();
        foreach ($attributesToInsert as $attr => $cellRowCol) {
            $cell = $wsCellFeed->getCell($cellRowCol['row'], $cellRowCol['column']);
            if ($cell != null) {
                $cell->update($cellRowCol['data']);
            } else {
                Log::info("Cell (" . $cellRowCol['row'] . ", " . $cellRowCol['column'] . ") : is null.");
                Log::info("Creating Cell (" . $cellRowCol['row'] . ", " . $cellRowCol['column'] . ")....");
                $cellEntry = $wsCellFeed->createCell($cellRowCol['row'], $cellRowCol['column'], $cellRowCol['data']);
                Log::info("cellEntry content: " . $cellEntry->getContent());
                
                $wsCellFeed->editCell($cellRowCol['row'], $cellRowCol['column'], $cellRowCol['data']);
            }
        }

        //$nextRowIndex
        /*$wsCellFeed->createCell($nextRowIndex, 1, "My Clinet");
        $wsCellFeed->createCell($nextRowIndex, 2, "EXISTING (OLD)");
        $wsCellFeed->createCell($nextRowIndex, 5, 7458451);*/

        return response()->json(array("sheetName" => $ws->getTitle(), "rows" => $rows, "entries" =>
        $entryList, "nextRowIndex" => $nextRowIndex));
    }
}
