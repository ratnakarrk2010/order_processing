@include('common.header')
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
         var detailsDivSubDivIdCount = Number("<?php echo sizeof($orderDetailsArr); ?>") -1;
         var installationAddressesCount = Number("<?php echo sizeof($installationAddresses); ?>");
         /**
         Material Div append */
         
         $(document).ready(function() {
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
                              <input name="orderDetailsId[]" id ="orderDetailsId${detailsDivSubDivIdCount}" type="hidden" value="0">
                              <label for="materials">Materials</label>
                           </div>
                        </div>
                        <div class="col-sm-2">
                           <div class="form-material">
                              <input class="form-control" type="text" id="quantity${detailsDivSubDivIdCount}" name="quantity[]" placeholder="Quantity">
                              <label for="quantity">Quantity</label>
                           </div>
                        </div>
                        <div class="col-sm-2">
                           <div class="form-material">
                              <input class="form-control" type="text" id="dc_no${detailsDivSubDivIdCount}" name="dc_no[]" placeholder="DC No.">
                              <label for="dc_no">DC No</label>
                           </div>
                        </div>
                        <div class="col-sm-2">
                           <div class="form-material">
                              <input class="form-control" type="date" id="dc_date${detailsDivSubDivIdCount}" name="dc_date[]" placeholder="DC Date">
                              <label for="dc_date">DC Date</label>
                           </div>
                        </div>
                        <div class="col-sm-2">
                           <div class="form-material">
                              <input class="form-control" type="text" id="product_serial_no${detailsDivSubDivIdCount}" name="product_serial_no[]" placeholder="Product serial no">
                              <label for="product_serial_no">Product Sr.No</label>
                           </div>
                        </div>
                        <div class="col-sm-1">
                           <div class="form-material">
                              <button  type="button" class="btn btn-danger btnOrderDTDelete" id="del${detailsDivSubDivIdCount}" loop-idx="${detailsDivSubDivIdCount}" divcnt='${detailsDivSubDivIdCount}' order-details-address-id="0"><i class="fa fa-trash"></i> Delete</button>
                           </div>
                        </div>
                     </div>
                  </div>
               `);
               $(`#del${detailsDivSubDivIdCount}`).click(function() {
                  let divcnt = $(this).attr("divcnt");
                  $(`#materialDiv${divcnt}`).remove();
               });
            });
         });
      </script>
@include('common.sidebar')
<main class="app-layout-content" id="app-layout-content">
               <!-- Page Content -->
               <div class="container-fluid p-y-md">
                  <!-- Material Design -->
                  <div class="row">
                     <div class="col-md-12">
                        <!-- Static Labels -->
                        <div class="card">
                           <div class="card-header">
                              <h4>Edit Order</h4>
                           </div>
                           <hr />
                           <div class="card-block">
                              <form class="form-horizontal m-t-sm" action="{{ url('/order/update') }}" method="post" id="editOrderFormID" name="editOrderForm">
                              <input type="hidden" id="id" name="id" value="{{$orderDetails->id}}">
                              <input type="hidden" id="loggedInUser" name="loggedInUser" value="{{$loggedInUser}}">
                                   
                              {{ csrf_field() }}
                              @include('common.flash-message')
                                 <div class="form-group">
                                    <div class="col-sm-3">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="opf_no" name="opf_no" 
                                           placeholder="Please enter OPF No" value="{{$orderDetails->opf_no}}"/>
                                          <label for="opf_no" class="required">OPF No</label>
                                          <div class="field-error" id="opf_no_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-material">
                                          <input class="form-control" type="date" id="opf_date" name="opf_date" 
                                          placeholder="Please select OPF Date" value="{{$orderDetails->opf_date}}"/>
                                          <label for="opf_date" class="required">OPF Date</label>
                                          <div class="field-error" id="opf_date_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="po_no" name="po_no" 
                                          placeholder="Please enter PO No" value="{{$orderDetails->po_no}}"/>
                                          <label for="po_no" class="required">PO No</label>
                                          <div class="field-error" id="po_no_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-material">
                                          <input class="form-control" type="Date" id="po_date" name="po_date" 
                                          placeholder="Please select OPF Date" value="{{$orderDetails->po_date}}"/>
                                          <label for="po_date" class="required">PO Date</label>
                                          <div class="field-error" id="po_date_error"></div>
                                       </div>
                                    </div>
                                 </div>
                                
                                 <div class="form-group">
                                    <div class="col-sm-6">
                                          <div class="form-material">
                                             <select class="js-select2 form-control" id="customer_id" name="customer_id" style="width: 100%;" data-placeholder="Choose one..">
                                                <option value="">---Select---</option>
                                                @if(isset($customerList))
                                                   @foreach($customerList as $customer)
                                                    @if (isset($orderDetails->customer_id) && ($customer->id == $orderDetails->customer_id))
                                                        <option value="{{$customer->id}}" selected="selected">{{ $customer->client_name }}</option>
                                                        @else
                                                    <option value="{{$customer->id}}">{{ $customer->client_name}}</option>
                                                    @endif
                                                   @endforeach
                                                @endif
                                             </select>
                                             <label for="customer" class="required">Customer</label>
                                             <div class="field-error" id="customer_id_error"></div>

                                          </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-material">
                                          <button  type="button" class="btn btn-app" id="addInstallationAddressEdit"
                                           name="addInstallationAddressEdit" style="width:100%">ADD INSTALLATION ADDRESS</button>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="form-group" id="installationAddressesEdit">
                                    @foreach ($installationAddresses as $installationAddress)
                                       <div id="installationAddressDiv{{$loop->index}}">
                                          <div class="col-sm-4">
                                             <div class="form-material">
                                                <textarea class="form-control" id="installation_address{{$loop->index}}" name="installation_address[]" rows="1" placeholder="Installation Address" style="resize: none;">{{ $installationAddress->installation_address }}</textarea>
                                                <input type="hidden" id="installation_addr{{ $loop->index }}" name="installation_address_id[]" value="{{ $installationAddress->id }}">
                                                <label for="installation_address{{$loop->index}}" class="required">Installation Address {{$loop->index + 1}}</label>
                                                <div class="field-error" id="installation_address_{{$loop->index}}_error"></div>
                                             </div>
                                             <i class="fa fa-trash delInstallationAddress btnRemoveInstallationAddress" installation-address-id="{{ $installationAddress->id }}" 
                                              loop-idx="{{ $loop->index }}"></i>
                                          </div>
                                          
                                       </div>
                                       @endforeach
                                 </div>
                                <div class="form-group">
                                    <div class="col-sm-2">
                                       <div class="form-material">
                                       <input type="hidden" id="order_collected_by" name="order_collected_by" value="{{ $orderDetails->order_collected_by}}">
                                           <select class="js-select2 form-control" id="order_collected_by_id" name="order_collected_by_id" style="width: 100%;" data-placeholder="Choose one..">
                                                <option value="">---Select---</option>
                                                @if(isset($salesmanLists))
                                                   @foreach($salesmanLists as $sales)
                                                   @if (isset($orderDetails->order_collected_by_id) && ($sales->id == $orderDetails->order_collected_by_id))
                                                   <option value="{{$sales->id}}" selected="selected">{{ $sales->first_name}} {{ $sales->last_name}}</option>
													            
                                                    @else
                                                    <option value="{{$sales->id}}">{{ $sales->first_name}} {{ $sales->last_name}}</option>
                                                   @endif
                                                   @endforeach
                                                @endif
                                          </select>
                                          <label for="order_collected_by" class="required">Order Collected By</label>
                                          <div class="field-error" id="order_collected_by_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-2">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="warranty_period" name="warranty_period" 
                                          placeholder="Please enter warranty period" value="{{$orderDetails->warranty_period}}">
                                          <label for="warranty_period" class="required">Warranty Period</label>
                                          <div class="field-error" id="warranty_period_error"></div>
                                       </div>
                                    </div>
                                    
                                    <div class="col-sm-3">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="total_po_value" name="total_po_value" 
                                             placeholder="Please enter total po value" value="{{$orderDetails->total_po_value}}">
                                             <label for="total_po_value" class="required">Total PO Value (excluding taxes)</label>
                                             <div class="field-error" id="total_po_value_error"></div>
                                          </div>
                                    </div>
                                    <div class="col-sm-2">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="tax_amount" name="tax_amount" value="{{$orderDetails->tax_amount}}" readonly>
                                          <label for="tax_amount">Tax Amount</label>
                                          <div class="field-error" id="tax_amount_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-3">
                                       <div class="form-material">
                                          <input class="form-control" type="text" id="total_order_amount" name="total_order_amount" value="{{$orderDetails->total_order_amount}}" readonly>
                                          <label for="total_order_amount">Total PO Value (including taxes)</label>
                                          <div class="field-error" id="total_order_amount_error"></div>
                                       </div>
                                    </div>
                                 </div>

                                 <div class="form-group">
                                 <div class="col-sm-6">
                                       <div class="form-material">
                                       <input  type="hidden" id="payment_terms" name="payment_terms" value="{{ $orderDetails->payment_terms }}">
                                          <select class="js-select2 form-control" id="payment_terms_id" name="payment_terms_id" style="width: 100%;" data-placeholder="Choose one..">
                                             <option value="">---Select---</option>
                                              @if(isset($allPaymentTerms))
                                                @foreach($allPaymentTerms as $pt)
                                                @if (isset($orderDetails->payment_terms_id) && ($pt->id == $orderDetails->payment_terms_id))
                                                   <option value="{{$pt->id}}"  selected="selected">{{ $pt->payment_terms}}</option>
                                                   
                                                @else
                                                   <option value="{{$pt->id}}">{{ $pt->payment_terms}}</option>
                                                @endif
                                                @endforeach
                                              @endif
                                          </select>
                                          <label for="payment_terms" class="required">Payment Terms</label>
                                          <div class="field-error" id="payment_terms_id_error"></div>
                                       </div>
                                    </div>
                                    <div class="col-sm-6">
                                       <div class="form-material">
										         
                                          <select class="js-select2 form-control" id="sales_initiator_by_id" name="sales_initiator_by_id" style="width: 100%;" data-placeholder="Choose one..">
                                                <option value="">---Select---</option>
                                                @if(isset($managerLists))
                                                   @foreach($managerLists as $manager)
                                                      @if (isset($orderDetails->sales_initiator_by_id) && ($manager->id == $orderDetails->sales_initiator_by_id))
                                                         <option value="{{$manager->id}}"  selected="selected">{{ $manager->first_name}} {{ $manager->last_name}}</option>
                                                         <input  type="hidden" id="sales_initiator_by" name="sales_initiator_by" value="{{ $manager->first_name}} {{ $manager->last_name}}">
                                                      @else
                                                         <option value="{{$manager->id}}">{{ $manager->first_name}} {{ $manager->last_name}}</option>
                                                      @endif
                                                   @endforeach
                                                @endif
                                          </select>
                                          <label for="sale_initialtor_by" class="required">Initiate By Manager</label>
                                          <div class="field-error" id="sales_initiator_by_error"></div>
                                       </div>
                                    </div>
                                    
                                    
                                 </div>
                                
                                 <!-- Changes -->
                                 <div class="form-group">
                                     <fieldset>
                                       <legend>
                                            <h4>PO Details:</h4>
                                        </legend>
                                    <div class="row col-sm-12" id="rowAppend">
									         @foreach($orderDetailsArr as $od)
                                    <div class="form-group" id="materialDiv{{$loop->index}}">
                                       <div class="col-sm-3">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="materials0" name="materials[]" 
                                             placeholder="Materials" value="{{$od->materials}}">
                                             <input name="orderDetailsId[]" id ="orderDetailsId{{$loop->index}}" type="hidden" value="{{ $od->id}}">

                                             <label for="materials">Materials</label>
                                          </div>
                                       </div>
                                       <div class="col-sm-2">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="quantity0" name="quantity[]" 
                                             placeholder="Quantity" value="{{$od->quantity}}">
                                             <label for="quantity">Quantity</label>
                                          </div>
                                       </div>
                                    
                                       <div class="col-sm-2">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="dc_no0" name="dc_no[]" 
                                             placeholder="DC No."  value="{{$od->dc_no}}" >
                                             <label for="dc_no">DC No</label>
                                          </div>
                                       </div>
                                       <div class="col-sm-2">
                                          <div class="form-material">
                                             <input class="form-control" type="date" id="dc_date0" name="dc_date[]"
                                              placeholder="DC Date" value="{{$od->dc_date}}">
                                             <label for="dc_date">DC Date</label>
                                          </div>
                                       </div>
                                       <div class="col-sm-2">
                                          <div class="form-material">
                                             <input class="form-control" type="text" id="product_serial_no0" 
                                             name="product_serial_no[]" placeholder="Product serial no" value="{{$od->product_serial_no}}">
                                             <label for="product_serial_no">Product Sr.No</label>
                                          </div>
                                       </div>
									            <div class="col-sm-1">
                                          <div class="form-material">
                                             <button  type="button" class="btn btn-danger btnOrderDTDelete" order-details-address-id="{{ $od->id }}" 
                                                loop-idx="{{ $loop->index }}"><i class="fa fa-trash"></i> Delete</button>
                                          </div>
                                       </div>
                                    </div>
                                       @endforeach
                                    </div>
                                    
									</fieldset>
									</div>
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <div class="form-material">
                                    <button  type="button" class="btn btn-app" id="btnAdd" name="addRow">ADD ROW</button>
                                 </div>
                              </div>
                           </div>
                          
                           <!-- div class="form-group">
                              <div class="col-sm-6">
                                 <div class="form-material">
                                    <input class="form-control" type="text" id="invoice_no" name="invoice_no" 
                                       placeholder="Please enter Invoice Number" value="$orderDetails->invoice_no">
                                    <label for="invoice_no" class="required">Invoice Number</label>
                                    <div class="field-error" id="invoice_no_error"></div>
                                 </div>
                              </div>
                              <div class="col-sm-6">
                                 <div class="form-material">
                                    <input class="form-control" type="date" id="invoice_date" name="invoice_date" 
                                       placeholder="Please enter Invoice Date"  value="$orderDetails->invoice_date">
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
                                                   <input class="form-control" type="date" id="material_procurement_date" name="material_procurement_date"
                                                    placeholder="Please enter material procurement date" value="{{$orderDetails->material_procurement_date}}">
                                                   <label for="material_procurement_date" class="">Material Procurement Date</label>
                                                  
                                                </div>
                                             </div>
                                             <div class="col-sm-4">
                                                <div class="form-material">
                                                   <input class="form-control" type="text" id="qc_testting_result" name="qc_testting_result" 
                                                   placeholder="Please enter QC Testting Result" value="{{$orderDetails->qc_testting_result}}">
                                                   <label for="qc_testting_result" class="">QC Testting Result</label>
                                                  
                                                </div>
                                             </div>
                                             <div class="col-sm-4">
                                                <div class="form-material">
                                                   <input class="form-control" type="date" id="dispatch_date" name="dispatch_date" 
                                                   placeholder="Please enter dispatch date"  value="{{$orderDetails->dispatch_date}}">
                                                   <label for="dispatch_date" class="">Dispatch Date</label>
                                                  
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
                                                @if (isset($orderDetails->order_status) && ($orderDetails->order_status == 0))
                                                <option value="0" selected="selected">Pending</option>
                                                @else
                                                <option value="0">Pending</option>
                                                @endif
                                               
                                                @if (isset($orderDetails->order_status) && ($orderDetails->order_status == 1))
                                                <option value="1" selected="selected">Approved</option>
                                                @else
                                                <option value="1">Approved</option>
                                                @endif
                                                @if (isset($orderDetails->order_status) && ($orderDetails->order_status == 2))
                                                <option value="2" selected="selected">Rejected</option>
                                                @else
                                                <option value="2">Rejected</option>
                                                @endif
                                          </select>
                                          <label for="order_status_id" class="">Order Status</label>
                                          <div class="field-error" id="order_status_error"></div>
                                       </div>
                                    </div>
                              <div class="col-sm-8">
                                 <div class="form-material">
                                 <input  type="hidden" id="approved_by" name="approved_by" value="{{ $orderDetails->approved_by}}">

                                    <select class="js-select2 form-control" id="approved_by_id" name="approved_by_id" style="width: 100%;" data-placeholder="Choose one..">
                                          <option value="">---Select---</option>
                                          @if(isset($managementLists))
                                             @foreach($managementLists as $management)
                                                @if (isset($orderDetails->approved_by_id) && ($management->id == $orderDetails->approved_by_id))
                                                   <option value="{{$management->id}}" selected="selected">{{ $management->first_name}} {{ $management->last_name}}</option>
                                                @else
                                                   <option value="{{$management->id}}">{{ $management->first_name}} {{ $management->last_name}}</option>
                                                @endif
                                             @endforeach
                                          @endif
                                    </select>
                                    <label for="sale_initialtor_by" class="">Approved / Rejected By Management</label>
                                    <div class="field-error" id="approved_by_error"></div>
                                 </div>
                              </div>
                           </div>
                           @endif
                           <div class="form-group">
                              <div class="col-sm-12">
                                 <div class="form-material">
                                    <input class="form-control" type="text" id="remarks" name="remarks" 
                                    placeholder="Please enter remarks" value="{{$orderDetails->remarks}}">
                                    <label for="remarks">Remarks if any</label>
                                 </div>
                              </div>
                           </div>
                                  
                           <div class="form-group m-b-0">
                              <div class="col-sm-9">
                                    <button class="btn btn-app" type="button" id="btnUpdateOrder">Update</button>
                                     @if(Session::get('loggedInUserRole') == 1 || Session::get('loggedInUserRole') == 2 || Session::get('loggedInUserRole') == 6 || Session::get('loggedInUserRole') == 7)
                                    <a href="{{ url('/all/orders')}}" class="btn btn-app-red">Cancel</a>
                                @endif
                                @if(Session::get('loggedInUserRole') == 5)
                                    <a href="{{ url('/add/installation')}}" class="btn btn-app-red">Cancel</a>
                                @endif
                                @if(Session::get('loggedInUserRole') == 4)
                                    <a href="{{ url('/add/paymentdetails')}}" class="btn btn-app-red">Cancel</a>
                                @endif
                              </div>
                           </div>
                           </div>
                           <div id="loader_edit">
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