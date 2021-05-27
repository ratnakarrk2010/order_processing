@include('common.header')
<script>
   let isEdit = false;
</script>
<script src="{!! asset('js/order/order_form_validations.js') !!}"></script>
<script src="{!! asset('js/order/order.js') !!}"></script>
<style>
fieldset {
  background-color: #eeeeee;
  border: 1px solid #c0c0c0;
  margin: 0 2px;
  padding: 0.35em 0.625em 0.75em
}

legend {
  background-color: gray;
  color: white;
  padding: 5px 10px;
}
.evenRow{
    background-color: red;
}
.oddRow{
    background-color: #eeeeee;
}

</style>
<script>
   var detailsDivSubDivIdCount = 0;
   var installation_address_row = 1;
   /**
    * Material Div append 
    */
   
   $(document).ready(function() {
      //$("#customer_id").select2();
      $("#btnAdd").click(function () {
         detailsDivSubDivIdCount++;
         let className = '';
         if(detailsDivSubDivIdCount % 2 == 0){
               className="evenRow";
         } else{
            className="oddRow";
         }
         $("#rowAppend").append(`
            <div class="col-sm-12">
            <div class="form-group" id="materialDiv${detailsDivSubDivIdCount}">
                  <div class="col-sm-3">
                     <div class="form-material">
                        <input class="form-control" type="text" id="materials${detailsDivSubDivIdCount}" name="materials[]" placeholder="Materials">
                        <label for="materials${detailsDivSubDivIdCount}" class="required">Materials</label>
                        <div class="field-error" id="materials_${detailsDivSubDivIdCount}_error"></div>
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="form-material">
                        <input class="form-control" type="text" id="make${detailsDivSubDivIdCount}" name="make[]" placeholder="Make">
                        <label for="make${detailsDivSubDivIdCount}" class="required">Make</label>
                        <div class="field-error" id="make_${detailsDivSubDivIdCount}_error"></div>
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <div class="form-material">
                        <input class="form-control" type="text" id="model${detailsDivSubDivIdCount}" name="model[]" placeholder="Model">
                        <label for="model${detailsDivSubDivIdCount}" class="required">Model</label>
                        <div class="field-error" id="model_${detailsDivSubDivIdCount}_error"></div>
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="form-material">
                        <input class="form-control" type="text" id="quantity${detailsDivSubDivIdCount}" name="quantity[]" placeholder="Quantity">
                        <label for="quantity" class="required">Quantity</label>
                        <div class="field-error" id="quantity_${detailsDivSubDivIdCount}_error"></div>
                     </div>
                  </div>
                  <div class="col-sm-1">
                     <div class="form-material">
                        <button  type="button" class="btn btn-danger" id="del${detailsDivSubDivIdCount}" divcnt='${detailsDivSubDivIdCount}'><i class="fa fa-trash"></i> Delete</button>
                     </div>
                  </div>
               </div>
            </div>
         `);

         /*
         <div class="col-sm-2">
                     <div class="form-material">
                        <input class="form-control" type="text" id="dc_no${detailsDivSubDivIdCount}" name="dc_no[]" placeholder="DC No.">
                        <label for="dc_no" class="required">DC No</label>
                        <div class="field-error" id="dc_no_${detailsDivSubDivIdCount}_error"></div>
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="form-material">
                        <input class="form-control" type="date" id="dc_date${detailsDivSubDivIdCount}" name="dc_date[]" placeholder="DC Date">
                        <label for="dc_date" class="required">DC Date</label>
                        <div class="field-error" id="dc_date_${detailsDivSubDivIdCount}_error"></div>
                     </div>
                  </div>
                  <div class="col-sm-2">
                     <div class="form-material">
                        <input class="form-control" type="text" id="product_serial_no${detailsDivSubDivIdCount}" name="product_serial_no[]" placeholder="Product serial no">
                        <label for="product_serial_no" class="required">Product Sr.No</label>
                        <div class="field-error" id="product_serial_no_${detailsDivSubDivIdCount}_error"></div>
                     </div>
                  </div>
         */

         let inputsEls = $("#rowAppend :input").get();
         Object.keys(inputsEls).forEach((key) => {
            let el = inputsEls[key];
            if (!(el.id instanceof HTMLElement)) {
               $(`#${el.id}`).blur(function () {
                  validateField($(this), validatorObjects["poDetails"]);
               });
            }
         });

         $(`#del${detailsDivSubDivIdCount}`).click(function() {
            let divcnt = $(this).attr("divcnt");
            let materials = document.getElementsByName("materials[]");
            if (materials === undefined || materials.length === 1) {
               bootbox.alert("You must add at least one record for PO Details!", function() {
               });
            } else {
               $(`#materialDiv${divcnt}`).remove();
            }
         });
      });
   });
</script>
@include('common.sidebar')
<main class="app-layout-content" id="app-layout-content">
               <!-- Page Content -->
               <div class="container-fluid p-y-md">
      <!-- Material Design <i class="fa fa-trash" id="del${detailsDivSubDivIdCount}" divcnt='${detailsDivSubDivIdCount}' style="font-size:25px;color:red;cursor: pointer;"></i>
-->
                  <div class="row">
                     <div class="col-md-12">
                        <!-- Static Labels -->
                        <div class="card">
                           <div class="card-header">
                              <h4>Order</h4>
                           </div>
                           <hr />
                           <div class="card-block">
                              <form class="form-horizontal m-t-sm" action="{{ url('/save/order') }}" method="post" id="orderFormID" name="orderForm">
                              {{ csrf_field() }}
                              @include('common.flash-message')
                                 <div class="form-group">
                                    <!-- div class="col-sm-3">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="opf_no" name="opf_no" placeholder="Please enter OPF No" />
                                          <label for="opf_no" class="required">OPF No</label>
                                          <div class="field-error" id="opf_no_error"></div>
                                       </div>
                                    </div -->
                                    <div class="col-sm-4">
                                       <div class="form-material">
                                          <input class="form-control" type="date" id="opf_date" name="opf_date" placeholder="Please select OPF Date" />
                                          <label for="opf_date" class="required">OPF Date</label>
                                          <div class="field-error" id="opf_date_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="po_no" name="po_no" placeholder="Please enter PO No" />
                                          <label for="po_no" class="required">PO No</label>
                                          <div class="field-error" id="po_no_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-material">
                                          <input class="form-control" type="Date" id="po_date" name="po_date" placeholder="Please select OPF Date" />
                                          <label for="po_date" class="required">PO Date</label>
                                          <div class="field-error" id="po_date_error"></div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    
                                                                     
                                 </div>

                                 <div class="form-group">
                                    <div class="col-sm-4">
                                          <div class="form-material">
                                             <select class="js-select2 form-control" id="customer_id" name="customer_id" style="width: 100%;" data-placeholder="Choose one..">
                                                <option value="">---Select---</option>
                                                @if(isset($customerList))
                                                   @foreach($customerList as $customer)
                                                   <option value="{{$customer->id}}">{{ $customer->client_name}}</option>
                                                   @endforeach
                                                @endif
                                             </select>
                                             <label for="customer" class="required">Customer</label>
                                             <div class="field-error" id="customer_id_error"></div>
                                          </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-material">
                                          <textarea class="form-control" id="installation_address0" name="installation_address[]" rows="1" placeholder="Installation Address" style="resize: none;"></textarea>
                                          <label for="installation_address" class="required">Installation Address</label>
                                          <div class="field-error" id="installation_address_0_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-4">
                                       <div class="form-material">
                                          <button  type="button" class="btn btn-app" id="addInstallationAddress" name="addInstallationAddress" style="width:100%;">ADD INSTALLATION ADDRESS</button>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group" id="installation_addresses"></div>
								 <div class="form-group">
                                    <div class="col-sm-6">
                                       <div class="form-material">
                                          <input type="hidden" id="order_collected_by" name="order_collected_by">
                                          <select class="js-select2 form-control" id="order_collected_by_id" name="order_collected_by_id" style="width: 100%;" data-placeholder="Choose one..">
                                                <option value="">---Select---</option>
                                                @if(isset($salesmanLists))
                                                   @foreach($salesmanLists as $sales)
                                                   <option value="{{$sales->id}}">{{ $sales->first_name}} {{ $sales->last_name}}</option>
                                                   @endforeach
                                                @endif
                                          </select>
                                          <label for="order_collected_by" class="required">Order Collected By</label>
                                          <div class="field-error" id="order_collected_by_id_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="warranty_period" name="warranty_period" placeholder="Please enter warranty period in months">
                                          <label for="warranty_period" class="required">Warranty Period</label>
                                          <div class="field-error" id="warranty_period_error"></div>
                                       </div>
                                    </div>
                                    
                                 </div>
                                 <div class="form-group">
                                 <div class="col-sm-3">
                                       <div class="form-material">
                                          <input type="hidden" id="tax_value" name="tax_value">
                                          <select class="js-select2 form-control" id="tax_id" name="tax_id"  data-placeholder="Choose one..">
                                                <option value="">---Select---</option>
                                                @if(isset($allTaxes))
                                                   @foreach($allTaxes as $tax)
                                                   <option value="{{$tax->id}}">{{ $tax->tax_value }}</option>
                                                   @endforeach
                                                @endif
                                          </select>
                                          <label for="tax_value" class="required">Tax value (%)</label>
                                          <div class="field-error" id="tax_id_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="total_po_value" name="total_po_value" placeholder="Please enter total po value">
                                          <label for="total_po_value" class="required">Total PO Value (excluding taxes)</label>
                                          <div class="field-error" id="total_po_value_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="tax_amount" name="tax_amount" readonly>
                                          <label for="tax_amount">Tax Amount</label>
                                          <div class="field-error" id="tax_amount_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="total_order_amount" name="total_order_amount" readonly>
                                          <label for="total_order_amount">Total PO Value (including taxes)</label>
                                          <div class="field-error" id="total_order_amount_error"></div>
                                       </div>
                                    </div>
                                 </div> 
                                                                
                                 <div class="form-group">
                                    <div class="col-sm-6">
                                       <div class="form-material">
                                          <input  type="hidden" id="payment_terms" name="payment_terms">
                                          <select class="js-select2 form-control" id="payment_terms_id" name="payment_terms_id" style="width: 100%;" data-placeholder="Choose one..">
                                             <option value="">---Select---</option>
                                             @if(isset($allPaymentTerms))
                                                @foreach($allPaymentTerms as $pt)
                                                <option value="{{$pt->id}}">{{ $pt->payment_terms}}</option>
                                                @endforeach
                                             @endif
                                          </select>
                                          <label for="payment_terms" class="required">Payment Terms</label>
                                          <div class="field-error" id="payment_terms_id_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-material">
                                          <input  type="hidden" id="sales_initiator_by" name="sales_initiator_by">
                                          <select class="js-select2 form-control" id="sales_initiator_by_id" name="sales_initiator_by_id" style="width: 100%;" data-placeholder="Choose one..">
                                                <option value="">---Select---</option>
                                                @if(isset($managerLists))
                                                   @foreach($managerLists as $manager)
                                                   <option value="{{$manager->id}}">{{ $manager->first_name}} {{ $manager->last_name}}</option>
                                                   @endforeach
                                                @endif
                                          </select>
                                          <label for="sale_initialtor_by" class="required">Initiate By Manager</label>
                                          <div class="field-error" id="sales_initiator_by_id_error"></div>
                                       </div>
                                    </div>  
                                 </div>

                                 <div class="form-group">
                                     <fieldset>
                                       <legend>
                                            <h4>PO Details:</h4>
                                        </legend>
                                     
                                    <div class="row col-sm-12" id="rowAppend">
									
                                       <div class="col-sm-3">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="materials0" name="materials[]" placeholder="Materials">
                                             <label for="materials" class="required">Materials</label>
                                             <div class="field-error" id="materials_0_error"></div>
                                          </div>
                                       </div>
                                       <div class="col-sm-3">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="make0" name="make[]" placeholder="Make">
                                             <label for="make0" class="required">Make</label>
                                             <div class="field-error" id="make_0_error"></div>
                                          </div>
                                       </div>
                                       <div class="col-sm-3">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="model0" name="model[]" placeholder="Model">
                                             <label for="model0" class="required">Model</label>
                                             <div class="field-error" id="model_0_error"></div>
                                          </div>
                                       </div>
                                       <div class="col-sm-2">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="quantity0" name="quantity[]" placeholder="Quantity">
                                             <label for="quantity" class="required">Quantity</label>
                                             <div class="field-error" id="quantity_0_error"></div>
                                          </div>
                                       </div>
                                       <!--<div class="col-sm-1">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="invoice_no0" name="invoice_no[]" placeholder="Invoice no">
                                             <label for="invoice_no">INV No</label>
                                          </div>
                                       </div>
                                       <div class="col-sm-2">
                                          <div class="form-material">
                                             <input class="form-control" type="date" id="invoice_date0" name="invoice_date[]" placeholder="Invoice date">
                                             <label for="invoice_date">INV Date</label>
                                          </div>
                                       </div>
                                       <div class="col-sm-2">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="dc_no0" name="dc_no[]" placeholder="DC No.">
                                             <label for="dc_no" class="required">DC No</label>
                                             <div class="field-error" id="dc_no_0_error"></div>
                                          </div>
                                       </div>
                                       <div class="col-sm-2">
                                          <div class="form-material">
                                             <input class="form-control" type="date" id="dc_date0" name="dc_date[]" placeholder="DC Date">
                                             <label for="dc_date" class="required">DC Date</label>
                                             <div class="field-error" id="dc_date_0_error"></div>
                                          </div>
                                       </div>
                                       <div class="col-sm-2">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="product_serial_no0" name="product_serial_no[]" placeholder="Product serial no">
                                             <label for="product_serial_no" class="required">Product Sr.No</label>
                                             <div class="field-error" id="product_serial_no_0_error"></div>
                                          </div>
                                       </div -->
									            <div class="col-sm-1">
                                          <div class="form-material">
                                             <i class="fa fa-trash" style="display:none;"></i>
                                          </div>
                                       </div>
                                    
                                     </div>
                                    
									</fieldset>
									</div>
                           <!-- div id="rowAppend"></div -->
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <div class="form-material">
                                    <button  type="button" class="btn btn-app" id="btnAdd" name="addRow">ADD ROW</button>
                                 </div>
                              </div>
                           </div>
                          <!-- <div class="form-group">
                           <div class="col-sm-4">
                              <div class="form-material">
                                    <select class="js-select2 form-control" id="order_status" name="order_status" style="width: 100%;" data-placeholder="Choose one..">
                                          <option value="">---Select---</option>
                                          <option value="1">Approved</option>
                                          <option value="2">Rejected</option>
                                    </select>
                                    <label for="order_status_id" class="required">Order Status</label>
                                    <div class="field-error" id="order_status_error"></div>
                                 </div>
                              </div>
                              <div class="col-sm-8">
                                 <div class="form-material">
                                 <input  type="hidden" id="approved_by" name="approved_by">
                                    <select class="js-select2 form-control" id="approved_by_id" name="approved_by_id" style="width: 100%;" data-placeholder="Choose one..">
                                          <option value="">---Select---</option>
                                          @if(isset($managementLists))
                                             @foreach($managementLists as $management)
                                                <option value="{{$management->id}}">{{ $management->first_name}} {{ $management->last_name}}</option>
                                             @endforeach
                                          @endif
                                    </select>
                                    <label for="approved_by_id" class="required">Approved / Rejected By Management</label>
                                    <div class="field-error" id="approved_by_id_error"></div>
                                 </div>
                              </div>
                           </div>-->
                           <!-- div class="form-group">
                                    <div class="col-sm-6">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="invoice_no" name="invoice_no" 
                                            placeholder="Please enter Invoice Number">
                                          <label for="invoice_no" class="required">Invoice Number</label>
                                          <div class="field-error" id="invoice_no_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-material">
                                          <input class="form-control" type="date" id="invoice_date" name="invoice_date" 
                                            placeholder="Please enter Invoice Date">
                                          <label for="invoice_date" class="required">Invoice Date</label>
                                          <div class="field-error" id="invoice_date_error"></div>
                                       </div>
                                    </div>
                              </div -->
                              <div class="form-group">
                                    <fieldset>
                                        <legend>
                                            <h4>This section to be enetered after receipt of Purchase Order:</h4>
                                        </legend>
                                          <div class="row col-sm-12">
                                            
                                             <div class="col-sm-4">
                                                <div class="form-material">
                                                   <input class="form-control" type="date" id="material_procurement_date" name="material_procurement_date" placeholder="Please enter material procurement date">
                                                   <label for="material_procurement_date">Material Procurement Date</label>
                                                   <div class="field-error" id="material_procurement_date_error"></div>
                                                </div>
                                             </div>
                                             <div class="col-sm-4">
                                                <div class="form-material">
                                                   <input class="form-control" type="text" id="qc_testting_result" name="qc_testting_result" placeholder="Please enter QC Testting Result">
                                                   <label for="qc_testting_result">QC Testting Result</label>
                                                   <div class="field-error" id="qc_testting_result_error"></div>
                                                </div>
                                             </div>
                                             <div class="col-sm-4">
                                                <div class="form-material">
                                                   <input class="form-control" type="date" id="dispatch_date" name="dispatch_date" placeholder="Please enter dispatch date">
                                                   <label for="dispatch_date">Dispatch Date</label>
                                                   <div class="field-error" id="dispatch_date_error"></div>
                                                </div>
                                             </div>
                                          </div>
                                    </fieldset>
                                 </div>
                                 @if(Session::get('loggedInUserRole') == 1  || Session::get('loggedInUserRole') == 6 || Session::get('loggedInUserRole') == 7)
                                  <div class="form-group">
                                    <div class="col-sm-4">
                                       <div class="form-material">
                                             <select class="js-select2 form-control" id="order_status" name="order_status" style="width: 100%;" data-placeholder="Choose one..">
                                                   <option value="">---Select---</option>
                                                   <option value="1">Approved</option>
                                                   <option value="2">Rejected</option>
                                             </select>
                                             <label for="order_status_id" class="">Order Status</label>
                                             <div class="field-error" id="order_status_error"></div>
                                          </div>
                                       </div>
                                       <div class="col-sm-8">
                                          <div class="form-material">
                                          <input  type="hidden" id="approved_by" name="approved_by">
                                             <select class="js-select2 form-control" id="approved_by_id" name="approved_by_id" style="width: 100%;" data-placeholder="Choose one..">
                                                   <option value="">---Select---</option>
                                                   @if(isset($managementLists))
                                                      @foreach($managementLists as $management)
                                                         <option value="{{$management->id}}">{{ $management->first_name}} {{ $management->last_name}}</option>
                                                      @endforeach
                                                   @endif
                                             </select>
                                             <label for="approved_by_id" class="">Approved / Rejected By Management</label>
                                             <div class="field-error" id="approved_by_id_error"></div>
                                          </div>
                                       </div>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                       <!--<div class="col-sm-4">
                                          <div class="form-material">
                                                <select class="js-select2 form-control" id="ld_clause_applicable" name="ld_clause_applicable" style="width: 100%;" data-placeholder="Choose one..">
                                                      <option value="">---Select---</option>
                                                      <option value="Y">Yes</option>
                                                      <option value="N">No</option>
                                                </select>
                                                <label for="ld_clause_applicable" class="required">LD Clause applicable</label>
                                                <div class="field-error" id="ld_clause_applicable_error"></div>
                                             </div>
                                       </div>-->
                                       <div class="col-sm-6">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="delivery_period" name="delivery_period" placeholder="Enter delivery period">
                                             <label for="delivery_period" class="">Delivery Period</label>
                                             <div class="field-error" id="delivery_period_error"></div>
                                          </div>
                                       </div>
                                       <div class="col-sm-6">
                                          <div class="form-material">
                                             <textarea class="form-control" id="other_terms" name="other_terms" rows="1" placeholder="Other terms" style="resize: none;"></textarea>
                                             <label for="other_terms">Any Other Terms</label>
                                             <div class="field-error" id="other_terms_error"></div>
                                          </div>
                                       </div>
                                    </div>
                                 <!-- Changes -->
                                    <div class="form-group">
                                       <div class="col-sm-12">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="remarks" name="remarks" placeholder="Please enter remarks">
                                             <label for="remarks">Remarks if any</label>
                                          </div>
                                       </div>
                                    </div>
                                   
                                    <div class="form-group m-b-0">
                                    <div class="col-sm-9">
                                        <button class="btn btn-app" type="button" id="btnAddOrder">Submit</button>
                                        <a href="{{ url('/all/orders') }}" class="btn btn-app-red" type="button" id="btnCancel">Cancel</a>
                                    </div>
                                </div>
                                 </div>
                                 <div id="loader">
                                    <img class="loading-img" src="{!! asset('img/ajax-loader.gif') !!}">
                                 </div>
                                
                              </form>
                           </div>
                           <!-- .card-block -->
                        </div>
                        <!-- .card -->
                        <!-- End Static Labels -->
                     </div>
                  </div>
                  <!-- .row -->
                  <!-- End CSS Checkboxes -->
               </div>
               <!-- End Page Content -->
            </main>

@include('common.footer')