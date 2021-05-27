@include('common.header')
<script src="{!! asset('js/users/user_form_validations.js') !!}"></script>
<script src="{!! asset('js/users/user.js') !!}"></script>
<script>
    $(function() {
        $("#userTable").DataTable({
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
        {{ csrf_field() }}
            <div class="card-header">
                <h4>User Table</h4>
            </div>
            <div class="card-block">
                <div class="row">
                                     
                    <div class="col-sm-12 topButtonClass">
                     <a href="{{ url('/add/user') }}" class="btn btn-app"><i class="ion-android-add-circle"></i>&nbsp;Add</a>
                     <a href="{{ url('/export_excel/excel') }}" class="btn btn-app"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>
                    </div>
                </div><br>
                <!-- DataTables init on table by adding .js-dataTable-full class, functionality initialized in js/pages/base_tables_datatables.js -->
                <div class="table-responsive">
                <table class="table table-striped table-bordered table-vcenter" id="userTable">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Role</th>
                            <th>Full Name</th>
                            <th class="">Username</th>
                            <th class="">Email</th>
                            <th style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($userLists as $list)
                    <input type="hidden" value="{{$list->id}}" name="id" id="userId{{$loop->index}}">
                        <tr>
                            <td class="text-center">{{$loop->index + 1}}</td>
                            <td class="">{{$list->role_name}}</td>
                            <td class="">{{$list->first_name}} {{$list->last_name}}</td>
                            <td class="">{{$list->username}}</td>
                            <td class="">{{$list->email}}</td>

                            <td class="text-center">
                                <div class="">
                                   
                                    <a href="{{ url('/users/edit/'.$list->id) }}" class="btn btn-xs btn-success" type="button" data-toggle="tooltip" title="Edit User"><i class="ion-edit"></i></a>                                    
                                    <button class="btn btn-xs btn-danger btnRemoveUser" type="button" data-toggle="tooltip" title="Remove User" user-id="{{ $list->id }}"><i class="ion-close"></i></button>
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