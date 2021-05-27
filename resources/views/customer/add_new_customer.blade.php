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
                        <h4>Add Customer</h4>
                    </div>
                    <hr />
                    <div class="card-block">
                        <form class="form-horizontal m-t-sm" action="{{ url('/save/customer') }}" method="post" id="addCustomerFormID" name="addCustomerForm">
                        {{ csrf_field() }}
                        @include('common.flash-message')
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="client_name" name="client_name" placeholder="Please enter Client Name" />
                                        <label for="client_name" class="required">Client Name</label>
                                        <div class="field-error" id="client_name_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-material">
                                        <select class="form-control" id="type_of_customer" name="type_of_customer" size="1">
                                            <option value="">---- Please Select ----</option>
                                            <option value="EXISITNG (OLD)">EXISITNG (OLD)</option>
                                            <option value="NEW">NEW</option>
                                            <option value="WIN BACK (> 6 MONTHS)">WIN BACK (> 6 MONTHS)</option>
                                        </select>
                                        <label for="user_role" class="required">Type Of Customer</label>
                                        <div class="field-error" id="type_of_customer_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                        <div class="form-material">
                                            <textarea class="form-control" id="address" name="address" rows="1" placeholder="Please add address" style="resize: none;"></textarea>
                                            <label for="address" class="required">Address</label>
                                            <div class="field-error" id="address_error"></div>
                                        </div>
                                </div>
                                
                            </div>
                            <!--<div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="form-material">
                                            <input class="form-control" type="email" id="email_id" name="email_id" placeholder="Please enter email" required>
                                            <label for="email" class="required">Email</label>
                                            <div class="field-error" id="email_id_error"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-material">
                                            <textarea class="form-control" id="address" name="address" rows="1" placeholder="Please add address" style="resize: none;"></textarea>
                                            <label for="address" class="required">Address</label>
                                            <div class="field-error" id="address_error"></div>
                                        </div>
                                    </div>
                            </div>-->
                                                                                      
                            <div class="form-group">
                                <fieldset>
                                <legend>
                                    <h4>Main Contact Person Details:</h4>
                                </legend>  
                               
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="contact_person1" name="contact_person1" placeholder="Please enter contact person 1">
                                        <label for="contact_person1" class="required">Contact Person 1</label>
                                        <div class="field-error" id="contact_person_1_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="designation_main" name="designation_main" placeholder="Please enter designation">
                                        <label for="designation_main" class="required">Designation</label>
                                        <div class="field-error" id="designation_main_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="email" id="email_id" name="email_id" placeholder="Please enter emailId">
                                        <label for="" class="required">Email</label>
                                        <div class="field-error" id="email_id_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="contact1" name="contact1" minlength="10" maxlength="10" 
                                        placeholder="Please enter contact">
                                        <label for="contact1" class="required">Contact No1</label>
                                        <div class="field-error" id="contact_1_error"></div>
                                    </div>
                                </div>
                                </fieldset>
                            </div>
                            
                            <div class="form-group">
                                <fieldset>
                                    <legend>
                                        <h4>For Installation Contact Details:</h4>
                                    </legend>  
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="contact_person2" name="contact_person2" placeholder="Please enter contact person name">
                                        <label for="email" class="">Contact Person 2</label>
                                        <div class="field-error" id="contact_person_2_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="designation_installation" name="designation_installation" placeholder="Please enter designation">
                                        <label for="designation_installation">Designation</label>
                                       
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="email" id="email_installation" name="email_installation" placeholder="Please enter emailId">
                                        <label for="email_installation">Email</label>
                                        <div class="field-error" id="email_installation_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="contact2" name="contact2" minlength="10" maxlength="10" placeholder="Please enter contact no">
                                        <label for="contact2" class="">Contact No2</label>
                                        <div class="field-error" id="contact_2_error"></div>
                                    </div>
                                </div>
                                </fieldset>
                            </div>
                            <div class="form-group">
                                <fieldset>
                                    <legend>
                                        <h4>For Payment Contact Details:</h4>
                                    </legend>  
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="contact_person3" name="contact_person3" placeholder="Please enter contact person name">
                                        <label for="contact_person3" class="">Contact Person 3</label>
                                        <div class="field-error" id="contact_person_3_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="designation_payment" name="designation_payment" placeholder="Please enter contact designation">
                                        <label for="designation_payment">Designation</label>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="email" id="email_payment" name="email_payment" placeholder="Please enter email ID">
                                        <label for="email_payment">Email</label>
                                        <div class="field-error" id="email_payment_error"></div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-material">
                                        <input class="form-control" type="text" id="contact3" name="contact3" minlength="10" maxlength="10" placeholder="Please enter contact name">
                                        <label for="contact3"  class="">Contact No3</label>
                                        <div class="field-error" id="contact_3_error"></div>
                                    </div>
                                </div>
                                </fieldset>
                            </div>
                            
                            <div class="form-group m-b-0">
                                <div class="col-sm-9">
                                    <button class="btn btn-app" type="button" id="btnAddCustomer">Submit</button>
                                    <button class="btn btn-app-red" type="button" id="btnCancel">Cancel</button>
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