@include('common.header')
<script src="{!! asset('js/users/user_form_validations.js') !!}"></script>
<script src="{!! asset('js/customer/customer.js') !!}"></script>
<script>
    $(function() {
       $("#customerTable").DataTable({
            "autoWidth": false,
            "searching": true,
        });
       
    });
</script>
@include('common.sidebar')
<main class="app-layout-content" id="app-layout-content">

    <!-- Page Content -->
    <div class="container-fluid p-y-md">
        <!-- Dynamic Table Full -->
        <div class="card">
            <div class="card-header">
                <h4>Customer List</h4>
            </div>
            <div class="card-block">
                <div class="row">
                                      
                    <div class="col-sm-12 topButtonClass">
                    <a href="{{ url('/add/customer') }}" class="btn btn-app"><i class="ion-android-add-circle"></i>&nbsp;Add</a>
                     <a href="{{ url('/customer_export/excel')}}" class="btn btn-app"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>

                    </div>
                </div><br>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter" id="customerTable">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Name</th>
                            <th>Customer&nbsp;Type</th>
                            <th class="">Email</th>
                            <th class="">Address</th>
                            <th class="">Person1</th>
                            <th class="">Contact1</th>
                                                                               
                            <th style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($customerList as $customer)
                    <input type="hidden" value="{{$customer->id}}" name="id" id="customerId{{$loop->index}}">
                        <tr>
                            <td class="text-center">{{$loop->index + 1}}</td>
                            <td class="">{{$customer->client_name}}</td>
                            <td class="">{{$customer->type_of_customer}}</td>
                            <td class="">{{$customer->email_id}}</td>
                            <td class="">{{$customer->address}}</td>
                            <td class="">{{$customer->contact1}}</td>
                            <td class="">{{$customer->contact_person1}}</td>
                          
                            <td class="text-center">
                                <div class="">
                                   
                                    <a href="{{ url('/customer/edit/'.$customer->id) }}" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Edit Customer"><i class="ion-edit"></i></a>                                    
                                    <button class="btn btn-xs btn-danger btnRemoveCustomer" type="button" data-toggle="tooltip" title="Remove Customer" customer-id="{{ $customer->id }}"><i class="ion-close"></i></button>
                                </div>
                            </td>
                        </tr>
                     @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            <!-- .card-block -->
        </div>
        <!-- .card -->
        <!-- End Dynamic Table Full -->


    </div>
    <!-- .container-fluid -->
    <!-- End Page Content -->

</main>
@include('common.footer')