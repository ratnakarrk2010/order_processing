@include('common.header')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js" integrity="sha256-LddDRH6iUPqbp3x9ClMVGkVEvZTrIemrY613shJ/Jgw=" crossorigin="anonymous"></script>
<style>
fieldset {
  background-color: #eeeeee;
}

legend {
  background-color: gray;
  color: white;
  padding: 5px 10px;
}
#loader1 {
  position: fixed;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 120px;
  height: 120px;
  margin: -76px 0 0 -76px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}
#materialDiv2{
   background-color: #eeeeee !important;
}
</style>
<script>
var baseURL = "{{ url('/') }}";

var detailsDivSubDivIdCount = 0;

 $(document).ready(function() {
    console.log("baseURL==>"+ baseURL);
   $("#loader1").hide();
   $("#btnSubmit").click(function() {
      if($("#spreadsheetName").val() == "") {
         alert("Please enter SpreadSheet Name!");
      }else if($("#sheetName").val() == "") {
         alert("Please enter SheetName!");
      } else{
               
         var form = $("#orderForm");
         $("#loader1").show();
         //console.log("In Final ELse: ", form.serialize());
         form.ajaxSubmit({
                url: `${baseURL}/api/order`,
                processData: false,  // Important!
                contentType: false,
                cache: false,
                method: 'POST',
                data: form.serialize(),
                headers: {"Content-Type": "application/x-www-form-urlencoded"}, 
                success:function (response) {
                  $("#loader1").hide();
                   //console.log(response);
                   //window.location.href =baseURL+'/order/process';
                   $("#successMessage").show();
                   //document.getElementById("#orderForm").reset();


                },
                error: function(xhr, textStatus, err) {
                  $("#loader1").hide();
                  
                },
                resetForm: true
         });
      }
   });

   $("#poDate" ).datepicker({
      format: 'mm/dd/yyyy',
   });
   $('#opfDate').datepicker({
      format: 'mm/dd/yyyy',
   });

   $("#materialProcurmentDate").datepicker({
      format: 'mm/dd/yyyy',
   });
   $("#dispatchDate").datepicker({
      format: 'mm/dd/yyyy',
   });
   $("#installationStartDate").datepicker({
      format: 'mm/dd/yyyy',
   });
   $("#installationCompletionDate").datepicker({
      format: 'mm/dd/yyyy',
   });
   $("#completionCollectedOn").datepicker({
      format: 'mm/dd/yyyy',
   });
   $("#finalPaymentDate").datepicker({
      format: 'mm/dd/yyyy',
   });
   
   /**
   Material Div append */
   $("#btnAdd").click(function() {
      detailsDivSubDivIdCount++;
      $("#rowAppend").append('<div class="row" id="detaildDivSubDiv'+detailsDivSubDivIdCount+'">'+
                              '<div class="input-field col s3">'+
                                 '<input placeholder="MATERIAL" id="materials'+detailsDivSubDivIdCount+'" name="materials[]" type="text">'+
                                 '<label for="MATERIAL">MATERIAL: </label>'+
                              '</div>'+
                              '<div class="input-field col s1">'+
                                 '<input placeholder="Qty" id="qty'+detailsDivSubDivIdCount+'" name="qty[]" type="text">'+
                                 '<label for="Qty">Qty: </label>'+
                              '</div>'+
                              '<div class="input-field col s2">'+
                                 '<input placeholder="INV.NO & DT" id="invoiceNoDate'+detailsDivSubDivIdCount+'" name="invoiceNoDate[]" type="text">'+
                                 '<label for="INV.NO & DT">INV.NO & DT:</label>'+
                              '</div>'+
                              '<div class="input-field col s2">'+
                                 '<input placeholder="D.C.& DT" id="dcdt'+detailsDivSubDivIdCount+'" name="dcdt[]" type="text">'+
                                 '<label for="D.C.& DT">D.C.& DT:</label>'+
                              '</div>'+
                              '<div class="input-field col s3">'+
                                 '<input placeholder="Product  Serial No" id="productSerialNo'+detailsDivSubDivIdCount+'" name="productSerialNo[]" type="text">'+
                                 '<label for="Product  Serial No">PRODUCT SERIAL NO:</label>'+
                              '</div>'+
                              '<div class="input-field col s1">'+
                              '<i class="material-icons" id="del" divcnt='+detailsDivSubDivIdCount+' style="font-size:35px;color:red;">close</i>'+
                              '</div>'+
                           '</div>');
        
    });
    $('#rowAppend').on('click','#del',function() {
         var divCnt = $(this).attr("divcnt");
         $("#detaildDivSubDiv"+divCnt).remove();
    });
   
  });

 
  </script>
<div id="main">
   <!-- START WRAPPER -->
   <div class="wrapper">
      <!-- Form with placeholder -->
      <div class="container">
         <div class="section">
            <p class="caption">ORDER PROCESSING FORM</p>
            <div class="divider"></div>
            <div id="successMessage" style="display:none; color:green;">Order Processing Form Submitted Successfully!</div>
            <br> 
            <div class="col s12 m12 l6">
               <div class="card-panel">
                  <div class="row">
                     <form class="col s12" action="{{url('/order')}}" method="post" id="orderForm" autocomplete="off">
                     {{ csrf_field() }}
                        <div class="row">
                        <div class="input-field col s6">
                           <input type="text" placeholder="Spreadsheet Name" name="spreadsheetName" id="spreadsheetName" class="form-control" />
                           <label>SPREADSHEET NAME (required):</label>
                        </div>
                        <div class="input-field col s6">
                           <input type="text" placeholder="Sheet Name" name="sheetName" id="sheetName" class="form-control" />
                           <label>SHEET NAME (required): </label>
                        </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s3">
                              <input placeholder="OPF NO" id="opfNo" name="opfNo" type="text">
                              <label for="OPF NO">OPF NO:</label>
                           </div>
                           <div class="input-field col s3">
                              <input placeholder="OPF DATE" id="opfDate" name="opfDate" type="text" readonly>
                              <label for="OPF DATE">OPF DATE:</label>
                           </div>
                           <div class="input-field col s3">
                              <input placeholder="PO NO" id="poNo" name="poNo" type="text">
                              <label for="PO NO">PO NO:</label>
                           </div>
                           <div class="input-field col s3">
                              <input placeholder="PO DATE" id="poDate" name="poDate" type="text" readonly>
                              <label for="PO DATE">PO DATE:</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s4">
                              <input placeholder="CLIENT NAME" id="clientName" name="clientName" type="text">
                              <label for="CLIENT NAME">CLIENT NAME:</label>
                           </div>
                           <div class="input-field col s4">
                           <select id="typeOfCustomer" name="typeOfCustomer">
                              <option value="">---- Please Select ----</option>
                              <option value="EXISITNG (OLD)">EXISITNG (OLD)</option>
                              <option value="NEW">NEW</option>
                              <option value="WIN BACK (> 6 MONTHS)">WIN BACK (> 6 MONTHS)</option>
                           </select>
                           <label for="TYPE OF CUSTOMER NAME">TYPE OF CUSTOMER NAME:</label>
                           </div>
                           <div class="input-field col s4">
                              <input placeholder="EMAIL ID" id="emailID" name="emailID" type="text">
                              <label for="EMAIL ID">EMAIL ID:</label>
                          </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s6">
                              <textarea placeholder="ADDRESS" id="address" class="materialize-textarea" name="address"></textarea>
                              <label for="ADDRESS">ADDRESS</label>
                           </div>
                           <div class="input-field col s6">
                              <textarea placeholder="INSTALLATION ADDRESS" id="installationAddress" name="installationAddress" class="materialize-textarea"></textarea>
                              <label for="INSTALLATION ADDRESS">INSTALLATION ADDRESS</label>
                           </div>
                        </div>
                        <fieldset>
                        <legend>Contact Details:</legend>
                        <div class="row">
                           <div class="input-field col s6">
                              <input placeholder="CLCONTACT PERSON / S" id="contactPersons1" name="contactPersons1" type="text">
                              <label for="CONTACT PERSON / S">CONTACT PERSON1:</label>
                           </div>
                           <div class="input-field col s6">
                              <input placeholder="CONTACT NO" id="contactNO1" name="contactNO1" type="text" maxlength="10">
                              <label for="CONTACT NO">CONTACT NO:</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s6">
                              <input placeholder="CLCONTACT PERSON / S" id="contactPersons2" name="contactPersons2" type="text">
                              <label for="CONTACT PERSON / S">CONTACT PERSON2:</label>
                           </div>
                           <div class="input-field col s6">
                              <input placeholder="CONTACT NO" id="contactNO2" name="contactNO2" type="text" maxlength="10">
                              <label for="CONTACT NO">CONTACT NO:</label>
                           </div>
                        </div>
                        </fieldset>
                        <div class="row"></div>
                        <div class="row">
                           <div class="input-field col s4">
                              <input placeholder="ORDER COLLECTED BY" id="orderCollectedBy" name="orderCollectedBy" type="text">
                              <label for="ORDER COLLECTED BY">ORDER COLLECTED BY:</label>
                           </div>
                           <div class="input-field col s4">
                              <input placeholder="WARRANTY PERIOD" id="warrabtyPeriod" name="warrabtyPeriod" type="text">
                              <label for="WARRANTY PERIOD">WARRANTY PERIOD :</label>
                           </div>
                           <div class="input-field col s4">
                              <input placeholder="OS DAYS" id="osDays" name="osDays" type="text">
                              <label for="OS DAYS">OS DAYS:</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s3">
                              <input placeholder="PAYMENT TERMS" id="paymentsTerms" name="paymentsTerms" type="text">
                              <label for="PAYMENT TERMS">PAYMENT TERMS:</label>
                           </div>
                           <div class="input-field col s3">
                              <input placeholder="PAYMENT RECEIVED" id="paymentReceived" name="paymentReceived" type="text">
                              <label for="PAYMENT RECEIVED">PAYMENT RECEIVED :</label>
                           </div>
                           <div class="input-field col s3">
                              <input placeholder="BALANCE PAYMENT" id="balancePayment" name="balancePayment" type="text">
                              <label for="BALANCE PAYMENT">BALANCE PAYMENT:</label>
                           </div>
                           <div class="input-field col s3">
                              <input placeholder="FINAL PAYMENT DATE" id="finalPaymentDate" name="finalPaymentDate" type="text" readonly>
                              <label for="FINAL PAYMENT DATE">FINAL PAYMENT DATE:</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s6">
                              <input placeholder="Name and Signature of Sale Initiator" id="nameAndSignature" name="nameAndSignature" type="text">
                              <label for="Name and Signature of Sale Initiator ">NAME AND SIGNATURE OF SALE INITIATOR :</label>
                           </div>
                           <div class="input-field col s6">
                              <input placeholder="Approved & Accepted by" id="approvedAndAcceptedBy" name="approvedAndAcceptedBy" type="text">
                              <label for="Approved & Accepted by">APPROVED & ACCEPTED BY:</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s12">
                              <input placeholder="TOTAL PO VALUE" id="totalPOValue" name="totalPOValue" type="text">
                              <label for="TOTAL PO VALUE">TOTAL PO VALUE:</label>
                           </div>
                        </div>
                      <fieldset>
                      <legend>This section to be enetered after receipt of Purchase Order</legend>
                        <div class="row">
                           <div class="input-field col s4">
                              <input placeholder="Material  Procurement Date" id="materialProcurmentDate" name="materialProcurmentDate" type="text" readonly>
                              <label for="Material  Procurement Date">MATERIAL PROCUREMENT DATE:</label>
                           </div>
                           <div class="input-field col s4">
                              <input placeholder="QC / In House Testing  results" id="qcInHouseTestingResult" name="qcInHouseTestingResult" type="text">
                              <label for="QC / In House Testing  results">QC / IN HOUSE TESTING RESULT:</label>
                           </div>
                           <div class="input-field col s4">
                              <input placeholder="Dispatch Date" id="dispatchDate" name="dispatchDate" type="text" readonly>
                              <label for="Dispatch Date:">DISPATCH DATE:</label>
                           </div>
                        </div>
                      </fieldset>
                      <div class="row"></div>
                        <fieldset>
                        <legend>Material Details:</legend>
                        <div id="rowAppend">
                        <div class="row" id ="detaildDivSubDiv">
                           <div class="input-field col s3">
                              <input placeholder="MATERIAL" id="materials" name="materials[]" type="text">
                              <label for="MATERIAL">MATERIAL: </label>
                           </div>
                           <div class="input-field col s1">
                              <input placeholder="Qty" id="qty" name="qty[]" type="text">
                              <label for="Qty">Qty: </label>
                           </div>
                           <div class="input-field col s3">
                              <input placeholder="INV.NO & DT" id="invoiceNoDate" name="invoiceNoDate[]" type="text">
                              <label for="INV.NO & DT">INV.NO & DT:</label>
                           </div>
                           <div class="input-field col s3">
                              <input placeholder="D.C.& DT" id="dcdt" name="dcdt[]" type="text">
                              <label for="D.C.& DT">D.C.& DT:</label>
                            </div>
                           <div class="input-field col s2">
                              <input placeholder="Product  Serial No" id="productSerialNo" name="productSerialNo[]" type="text">
                              <label for="Product  Serial No">PRODUCT SERIAL NO:</label>
                           </div>
                           </div>
                        </div>
                        </fieldset>
                        <div class="row">
                        <div class="input-field col s12">
                           <button class="btn waves-effect waves-light right" name="addRow" type="button" id="btnAdd">Add Row</button>
                        </div>
                        </div>                                              
                        <div class="row">
                           <div class="input-field col s4">
                              <input placeholder="INSTALLATION ASSIGNED TO" id="installationAssignedTo" name="installationAssignedTo" type="text">
                              <label for="INSTALLATION ASSIGNED TO">INSTALLATION ASSIGNED TO:</label>
                           </div>
                           <div class="input-field col s4">
                              <input placeholder="INSTALLATION START DATE" id="installationStartDate" name="installationStartDate" type="text" readonly>
                              <label for="INSTALLATION START DATE">INSTALLATION START DATE:</label>
                           </div>
                           <div class="input-field col s4">
                              <input placeholder="INSTALLATION COMPLETION DATE" id="installationCompletionDate" name="installationCompletionDate" type="text" readonly>
                              <label for="INSTALLATION COMPLETION DATE">INSTALLATION COMPLETION DATE:</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s6">
                              <input placeholder="INSTALLATION ALERT" id="installationAlert" name="installationAlert" type="text">
                              <label for="INSTALLATION ALERT">INSTALLATION ALERT:</label>
                           </div>
                           <div class="input-field col s6">
                              <input placeholder="AMC ALERT" id="amcAlert" name="amcAlert" type="text">
                              <label for="AMC ALERT">AMC ALERT:</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s12">
                              <input placeholder="COMPLETION CERTIFICATE COLLECTED ON" id="completionCollectedOn" name="completionCollectedOn" type="text" readonly>
                              <label for="COMPLETION CERTIFICATE COLLECTED ON">COMPLETION CERTIFICATE COLLECTED ON:</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s12">
                              <input placeholder="REMARKS IF ANY" id="remark" name="remark" type="text">
                              <label for="REMARKS IF ANY">REMARKS IF ANY: </label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s6">
                              <input placeholder="SIGNATURE OF PROJECT EXECUTIVE" id="signatureOFProjectExecutive" name="signatureOFProjectExecutive" type="text">
                              <label for="SIGNATURE OF PROJECT EXECUTIVE">SIGNATURE OF PROJECT EXECUTIVE: </label>
                           </div>
                           <div class="input-field col s6">
                              <input placeholder="SIGNATURE OF CS MANAGER" id="signatureOfManager" name="signatureOfManager" type="text">
                              <label for="SIGNATURE OF CS MANAGER">SIGNATURE OF CS MANAGER:</label>
                           </div>
                        </div>
                        <div class="row">
                           <div class="input-field col s12">
                              <button class="btn waves-effect waves-light right" type="button" id="btnSubmit" name="action">Submit
                              <i class="material-icons right">send</i>
                              </button>
                           </div>
                        </div>
                       
                       <div id="loader1"></div>
                           
                       

                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
</div>

@include("common.footer")