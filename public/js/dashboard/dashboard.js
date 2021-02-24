
$(document).ready(function () {
    $("#displayCustomerList").hide();
    $("#displayOrderList").hide();
    $("#displayPendingOrderList").hide();
    //$("#Payment_detail").modal("hide");
    $("#customerTable").DataTable({
        autoWidth: false,
        searching: true,
    });
   

    $("#clientMaster").click(function() {
        $("#displayOrderList").hide();
        $("#displayPendingOrderList").hide();
        customerToggelFunction();
    });
    $("#orderList").click(function() {
        $("#displayCustomerList").hide();
        $("#displayPendingOrderList").hide();
        orderToggelFunction();
    });
    $("#pendingOrderList").click(function() {
        $("#displayCustomerList").hide();
        $("#displayOrderList").hide();
        pendingOrderToggelFunction();
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
    var pendingOrderListForm = document.getElementById("displayPendingOrderList");
    if (pendingOrderListForm.style.display === "none") {
        pendingOrderListForm.style.display = "block";
    } else {
        pendingOrderListForm.style.display = "none";
    }
}
