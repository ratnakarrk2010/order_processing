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
        set_time_limit(8000000);

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
        Log::info("In submitOrder. Request data: " . json_encode($request->all()));
        //Log::info("Token: ".$this->accessToken);
        /*$serviceRequest = new DefaultServiceRequest($this->accessToken);
        ServiceRequestFactory::setInstance($serviceRequest);*/
        try {
            // Get our spreadsheet
            $spreadsheetService = new SpreadsheetService();
            //$spreadsheetService = new Google\Spreadsheet\SpreadsheetService();
            $spreadsheet = $spreadsheetService->getSpreadsheetFeed()->getByTitle($request->spreadsheetName);

            //$spreadsheet = $spreadsheetService->getSpreadsheetFeed()->getByTitle('Test_Spreadsheet');

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
            } else {
                $worksheet = $worksheets[0];
            }

            $cellFeed = $worksheet->getCellFeed();
            //$rows = $cellFeed->toArray();

            $attributesToInsert = array(
                "opfNo" => array("row" => 2, "column" => 3),
                "opfDate" => array("row" => 2, "column" => 5),
                "poNo" => array("row" => 2, "column" => 7),
                "poDate" => array("row" => 3, "column" => 7),
                "clientName" => array("row" => 3, "column" => 3),
                "address" => array("row" => 4, "column" =>3),
                "installationAddress" => array("row" => 6, "column" =>3),
                "contactPersons1" => array("row" => 8, "column" =>3),
                "contactNO1" => array("row" => 9, "column" =>3),
                "contactPersons2" => array("row" => 8, "column" =>5),
                "contactNO2" => array("row" => 9, "column" =>5),
                "emailID" => array("row" => 10, "column" =>3),
                "orderCollectedBy" => array("row" => 11, "column" =>3),
                "warrabtyPeriod" => array("row" => 11, "column" =>7),
                "paymentsTerms" => array("row" => 12, "column" =>3),
                "paymentReceived" => array("row" => 13, "column" =>3),
                "nameAndSignature" => array("row" => 14, "column" =>3),
                "approvedAndAcceptedBy" => array("row" => 14, "column" =>7),
                "totalPOValue" => array("row" => 15, "column" =>3),
                "materialProcurmentDate" => array("row" => 18, "column" =>3),
                "qcInHouseTestingResult" => array("row" => 19, "column" =>3),
                "dispatchDate" => array("row" => 20, "column" =>3),

                "installationAssignedTo" => array("row" => 31, "column" =>3),
                "installationStartDate" => array("row" => 32, "column" =>3),
                "installationCompletionDate" => array("row" => 33, "column" =>3),
                "completionCollectedOn" => array("row" => 34, "column" =>3),
                "remark" => array("row" => 35, "column" =>3),
                "signatureOFProjectExecutive" => array("row" => 36, "column" =>3),
                //"signatureOfManager" => array("row" => 36, "column" =>4),
                                
            );
          

            foreach ($attributesToInsert as $attr => $cellRowCol) {
                $cell = $cellFeed->getCell($cellRowCol['row'], $cellRowCol['column']);
                if ($cell != null) {
                    $cell->update($request->input($attr));
                } else {
                    //Log::info("Cell (" . $cellRowCol['row'] . ", " . $cellRowCol['column'] . ") : is null.");
                    //Log::info("Creating Cell (" . $cellRowCol['row'] . ", " . $cellRowCol['column'] . ")....");

                    $cellEntry = $cellFeed->createCell($cellRowCol['row'], $cellRowCol['column'], $request->input($attr));
                    $cellFeed->editCell($cellRowCol['row'], $cellRowCol['column'], $request->input($attr));
                }
            }

            $signatureOfManagerCell = $cellFeed->getCell(36, 4);
            $signatureOfManagerCell->update($request->input('signatureOfManager')."\n Signature of CS Manager");
           
            // Write Table

            $materials = $request->input('materials');

            $tblInsertArray = array(
                "materials" => array("column" => 2),
                "qty" => array("column" => 4),
                "invoiceNoDate" => array("column" => 5),
                "dcdt" => array("column" => 6),
                "productSerialNo" => array("column" => 7)
                
            );

            $tableArraySize = sizeof($materials);
            $rowStartIndex = 22;
            for ($i = 0; $i < $tableArraySize; $i++) {
                if ($rowStartIndex > 30) {
                    break;
                }
                foreach ($tblInsertArray as $attr => $cellRowCol) {
                    $cell = $cellFeed->getCell($rowStartIndex, $cellRowCol['column']);
                    if ($cell != null) {
                        $cell->update($request->input($attr)[$i]);
                    } else {
                        //Log::info("Cell (" . $rowStartIndex . ", " . $cellRowCol['column'] . ") : is null.");
                        ///Log::info("Creating Cell (" . $rowStartIndex . ", " . $cellRowCol['column'] . ")....");

                        $cellEntry = $cellFeed->createCell($rowStartIndex, $cellRowCol['column'],
                        $request->input($attr)[$i]);
                        $cellFeed->editCell($rowStartIndex, $cellRowCol['column'], $request->input($attr)[$i]);
                    }
                }
                $rowStartIndex += 1;
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
                "typeOfCustomer" => array("row" => $nextRowIndex, "column" => 2),
                "poNo" => array("row" => $nextRowIndex, "column" => 3),
                "opfDate" => array("row" => $nextRowIndex, "column" => 4),
                "opfNo" => array("row" => $nextRowIndex, "column" => 5),
                "materials" => array("row" => $nextRowIndex, "column" => 6),
                "qty" => array("row" => $nextRowIndex, "column" => 7),
                "contactPersons1" => array("row" => $nextRowIndex, "column" => 8),
                "contactNO1" => array("row" => $nextRowIndex, "column" => 9),
                "contactPersons2" => array("row" => $nextRowIndex, "column" => 8),
                "contactNO2" => array("row" => $nextRowIndex, "column" => 9),
                "orderCollectedBy" => array("row" => $nextRowIndex, "column" => 10),
                "dispatchDate" => array("row" => $nextRowIndex, "column" => 11),
                "installationStartDate" => array("row" => $nextRowIndex, "column" => 12),
                "installationCompletionDate" => array("row" => $nextRowIndex, "column" => 13),
                "installationAlert" => array("row" => $nextRowIndex, "column" => 14),
                //"installationAlert" => array("row" => $nextRowIndex, "column" => 14, "data" => "Installation ALetr"),
                "paymentsTerms" => array("row" => $nextRowIndex, "column" => 15),
                "totalPOValue" => array("row" => $nextRowIndex, "column" => 16),
                "paymentReceived" => array("row" => $nextRowIndex, "column" => 17),
                "remark" => array("row" => $nextRowIndex, "column" => 18),
                //"balancePayment" => array("row" => $nextRowIndex, "column" => 19, "data" => "Balance Payment Value"),
                "balancePayment" => array("row" => $nextRowIndex, "column" => 19),
                "finalPaymentDate" => array("row" => $nextRowIndex, "column" => 20),
                //"finalPaymentDate" => array("row" => $nextRowIndex, "column" => 20, "data" =>"01/01/2021"),
                //"osDays" => array("row" => $nextRowIndex, "column" => 21, "data" =>"22"),
                "osDays" => array("row" => $nextRowIndex, "column" => 21),  
                "warrabtyPeriod" => array("row" => $nextRowIndex, "column" => 22),  
                //"amcAlert" => array("row" => $nextRowIndex, "column" => 23, "data" => "AMC Alert"),  
                "amcAlert" => array("row" => $nextRowIndex, "column" => 23),        
                
             );

             $messages = array();
             foreach ($rowAttributesToInsert as $attr => $cellRowCol) {
                $cell = $wsCellFeed->getCell($cellRowCol['row'], $cellRowCol['column']);
                if ($cell != null) {
                    $cell->update($request->input($attr));
                } else {
                    //Log::info("Cell (" . $cellRowCol['row'] . ", " . $cellRowCol['column'] . ") : is null.");
                    //Log::info("Creating Cell (" . $cellRowCol['row'] . ", " . $cellRowCol['column'] . ")....");

                    $data = "";
                    if ($request->input($attr) == null) {
                        if (isset($cellRowCol['data'])) {
                            $data = $cellRowCol['data'];
                        }
                        
                    } else {
                        $data = $request->input($attr);
                    }

                    if (is_array($data)) {
                        $data = implode(", ", $data);
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
