@include('common.header')
<script src="{!! asset('js/customer/customer_form_validations.js') !!}"></script>
<script src="{!! asset('js/customer/customer.js') !!}"></script>
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
                        <h4>Edit Customer</h4>
                    </div>
                    <hr />
                    <div class="card-block">
                        <form class="form-horizontal m-t-sm" action="{{ url('/customer/update') }}" method="post" id="editCustomerFormID" name="editCustomerForm">
                        <input type="hidden" id="customerId" name="id" class="form-control" value="{{ isset($customerData->id) ? $customerData ->id: ''}}">
                        {{ csrf_field() }}
                        @include('common.flash-message')
                            <div class="form-group">
                                <div class="col-sm-4">
                                   
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="client_name" name="client_name"
                                         placeholder="Please enter Client Name" value="{{ $customerData->client_name }}"/>
                                        <label for="client_name" class="required">Client Name</label>
                                        <div class="field-error" id="client_name_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-material">
                                        <select class="form-control" id="type_of_customer" name="type_of_customer" size="1">
                                            <option value="">---- Please Select ----</option>
                                            @if (isset($customerData->type_of_customer) && $customerData->type_of_customer =='EXISITNG (OLD)')
                                                <option value="EXISITNG (OLD)"  selected='selected'>EXISITNG (OLD)</option>
                                            @else
                                                <option value="EXISITNG (OLD)">EXISITNG (OLD)</option>
                                            @endif
                                            @if (isset($customerData->type_of_customer) && $customerData->type_of_customer =='NEW')
                                                <option value="NEW" selected='selected'>NEW</option>
                                            @else
                                                <option value="NEW">NEW</option>
                                            @endif
                                            @if (isset($customerData->type_of_customer) && $customerData->type_of_customer =='WIN BACK (> 6 MONTHS)')
                                                <option value="WIN BACK (> 6 MONTHS)" selected='selected'>WIN BACK (> 6 MONTHS)</option>
                                            @else
                                                 <option value="WIN BACK (> 6 MONTHS)">WIN BACK (> 6 MONTHS)</option>
                                            @endif
                                        </select>
                                        <label for="user_role" class="required">Type Of Customer</label>
                                        <div class="field-error" id="type_of_customer_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-material">
                                        <input class="form-control" type="email" id="email_id" name="email_id" 
                                        placeholder="Please enter email" required value="{{ $customerData->email_id}}">
                                        <label for="email" class="required">Email</label>
                                        <div class="field-error" id="email_id_error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-4">
                                    
                                    <div class="form-material">
                                        <textarea class="form-control" id="address" name="address" rows="6" 
                                        placeholder="Please add address" style="resize: none;"> {{$customerData->address }}</textarea>
                                        <label for="address" class="required">Address</label>
                                        <div class="field-error" id="address_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <div class="form-material">
                                                <input class="form-control" type="text" id="contact1" name="contact1"
                                                 maxlength="10" placeholder="Please enter contact 1" value="{{ $customerData-> contact1}}">
                                                <label for="email" class="required">Contact No1</label>
                                                <div class="field-error" id="contact1_error"></div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-material">
                                                <input class="form-control" type="text" id="contact_person1" name="contact_person1"
                                                 placeholder="Please enter contact person 1"  value="{{ $customerData-> contact_person1}}">
                                                <label for="email" class="required">Contact Person 1</label>
                                                <div class="field-error" id="contact_person1_error"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <div class="form-material">
                                                <input class="form-control" type="text" id="contact2" name="contact2"  
                                                maxlength="10" placeholder="Please enter contact 2" value="{{ $customerData-> contact2}}">
                                                <label for="email">Contact No2</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-material">
                                                <input class="form-control" type="text" id="contact_person2" name="contact_person2" 
                                                placeholder="Please enter contact person 2" value="{{ $customerData-> contact_person2}}">
                                                <label for="email">Contact Person 2</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            

                            <div class="form-group m-b-0">
                                <div class="col-sm-9">
                                    <button class="btn btn-app" type="button" name="btnUpdateCustomer" id="btnUpdateCustomer">Update</button>
                                    <a href="/all/customer" ><button class="btn btn-app-red	" type="button" id="">Cancel</button></a>
                                </div>
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