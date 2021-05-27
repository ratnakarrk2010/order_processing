$(document).ready(function () {
    $("#displayCustomerList").hide();
    $("#displayOrderList").hide();
    $("#loader").hide();
    $("#displayPendingOrderList").hide();
    //$("#Payment_detail").modal("hide");
    $("#customerTable").DataTable({
        autoWidth: false,
        searching: true,
    });
    $("#orderId").DataTable({
        autoWidth: false,
        searching: true,
    });
    $("#pendingorderId").DataTable({
        autoWidth: false,
        searching: true,
    });

    $("#clientMaster").click(function () {
        $("#displayOrderList").hide();
        $("#displayPendingOrderList").hide();
        customerToggelFunction();
    });
    $("#orderList").click(function () {
        $("#displayCustomerList").hide();
        $("#displayPendingOrderList").hide();
        orderToggelFunction();
    });
    $("#pendingOrderList").click(function () {
        $("#displayCustomerList").hide();
        $("#displayOrderList").hide();
        pendingOrderToggelFunction();
    });
    $("#role_id").change(function () {
        let role = $(this).val();
        $("#userId")
            .find("option")
            .remove()
            .end()
            .append("<option value=''>---Select---</option>");
        $("#userDashboard").html("");
        if (role !== "") {
            $("#loader").show();
            axios
                .get(`${baseURL}/api/users/byrole/${role}`)
                .then((response) => {
                    $("#loader").hide();
                    let users = response.data.users;
                    console.log(users);
                    users.forEach((user) => {
                        $("#userId").append(
                            new Option(
                                `${user.first_name} ${user.last_name}`,
                                user.id
                            )
                        );
                    });
                })
                .catch((err) => {
                    console.log(err);
                    $("#loader").hide();
                });
        }
    });

    $("#userId").change(function () {
        $("#loader").show();
        $("#userDashboard").html("");
        let userId = $(this).val();
        let roleId = $("#role_id").val();
        $("#userDashboard").html("");
        if (userId !== "") {
            axios
                .get(`${baseURL}/api/user/dashboard/${roleId}/${userId}`)
                .then((response) => {
                    $("#loader").hide();
                    let userDashboard = "<div class='row'>";
                    Object.keys(response.data).forEach((key) => {
                        userDashboard += getUserDashboards(
                            key,
                            response.data[key]
                        );
                    });
                    userDashboard += "</div>";
                    $("#userDashboard").html(userDashboard);
                })
                .catch((err) => {
                    $("#loader").hide();
                    console.log(err);
                });
        }
    });
});

function customerToggelFunction() {
    var customerListForm = document.getElementById("displayCustomerList");
    if (customerListForm.style.display === "none") {
        customerListForm.style.display = "block";
    } else {
        customerListForm.style.display = "none";
    }
}

function orderToggelFunction() {
    var orderListForm = document.getElementById("displayOrderList");
    if (orderListForm.style.display === "none") {
        orderListForm.style.display = "block";
    } else {
        orderListForm.style.display = "none";
    }
}
function pendingOrderToggelFunction() {
    var pendingOrderListForm = document.getElementById(
        "displayPendingOrderList"
    );
    if (pendingOrderListForm.style.display === "none") {
        pendingOrderListForm.style.display = "block";
    } else {
        pendingOrderListForm.style.display = "none";
    }
}

const getUserDashboards = (key, widgetValue) => {
    let dashboardCountWidgets = {
        orders: `<div class="col-sm-6 col-lg-4">
                <a class="card" href="javascript:void(0)" id="orderList">
                <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs">Total Orders (Per Finantial Year)</p>
                            <p class="h3 text-blue m-t-sm m-b-0">${widgetValue}</p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-blue bg-inverse"><i class="ion-ios-bell fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>`,
        totalOrderAmount: `<div class="col-sm-6 col-lg-4">
                <a class="card" href="javascript:void(0)">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs">Total Order Value</p>
                            <p class="h3 text-blue m-t-sm m-b-0">${widgetValue}</p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-blue bg-inverse"><i class="ion-ios-bell fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>`,
        pendingOrders: `<div class="col-sm-6 col-lg-4">
                <a class="card bg-purple bg-inverse" href="javascript:void(0)" id="pendingOrderList">
                <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs">Pending Orders</p>
                            <p class="h3 m-t-sm m-b-0">${widgetValue}</p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-gray-light-o"><i class="ion-ios-email fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>`,
        balancePayment: `<div class="col-sm-6 col-lg-4">
                <a class="card" href="javascript:void(0)">
                    <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs">Payment Outstanding</p>
                            <p class="h3 text-blue m-t-sm m-b-0">${widgetValue}</p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-blue bg-inverse"><i class="ion-ios-bell fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>`,
        completedOrders: `<div class="col-sm-6 col-lg-4">
                <a class="card" href="javascript:void(0)" id="orderList">
                <div class="card-block clearfix">
                        <div class="pull-right">
                            <p class="h6 text-muted m-t-0 m-b-xs">Orders Executed</p>
                            <p class="h3 text-blue m-t-sm m-b-0">${widgetValue}</p>
                        </div>
                        <div class="pull-left m-r">
                            <span class="img-avatar img-avatar-48 bg-blue bg-inverse"><i class="ion-ios-bell fa-1-5x"></i></span>
                        </div>
                    </div>
                </a>
            </div>`,
    };
    return dashboardCountWidgets[key];
};
