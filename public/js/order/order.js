$(document).ready(function () {
    /*$("#opf_date").datepicker({
        format: "mm/dd/yyyy",
        onSelect: function (selectedDate) {
            $("#opf_date").val(selectedDate);
            console.log("selectedDate: ", selectedDate);
            validateField($("#opf_date"));
        },
    });*/
    $("#order_collected_by_id").change(function(){
        var orderCollectedBy = $("#order_collected_by_id option:selected").text();
        //console.log("orderCollectedBy==>"+orderCollectedBy);
        $("#order_collected_by").val(orderCollectedBy);
    });
    $("#sales_initiator_by_id").change(function(){
        var salesInitiatordBy = $("#sales_initiator_by_id option:selected").text();
        $("#sales_initiator_by").val(salesInitiatordBy);
        //console.log("salesInitiatordBy==>"+salesInitiatordBy);
    });
    $("#approved_by_id").change(function(){
        var approvedBy = $("#approved_by_id option:selected").text();
        $("#approved_by").val(approvedBy);
        //console.log("approvedBy==>"+approvedBy);
    });
    $("#installation_assigned_to_id").change(function() {
        var installationAssignedTo = $("#installation_assigned_to_id option:selected").text();
        $("#installation_assigned_to").val(installationAssignedTo);
    });

    $("#btnAddOrder").click(function () {
        const isValid = isValidForm("orderFormID", validatorObjects["orderForm"]);
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the order?",
                function (r) {
                    var orderFormID = document.getElementById("orderFormID");
                    orderFormID.submit();
                }
            );
        }
    });

    $("#btnUpdateOrder").click(function () {
        const isValid = isValidForm("editOrderFormID",  validatorObjects["editOrderForm"]);
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to update the order details?",
                function (r) {
                    var editOrderFormID = document.getElementById("editOrderFormID");
                    editOrderFormID.submit();
                }
            );
        }
    });

   
    $("#btnAddPaymnetDetails").click(function () {
        console.log("paymentValidatorObj", validatorPaymentObj);
        const isValid = isValidForm(
            "paymentDetailsFormID",
            validatorObjects["paymentDetailsForm"]
        );
        if (isValid) {
            var paymentDetailsFormID = document.getElementById(
                "paymentDetailsFormID"
            );
            paymentDetailsFormID.submit();
        }
    });
    $(".btnRemoveOrder").click(function () {
        let customerId = $(this).attr("order-id");
        bootbox.confirm(
            "Are you sure you want to delete this order?",
            function (r) {
                if (r) {
                    window.location = `${baseURL}/order/delete/${customerId}`;
                }
            }
        );
    });

    /*$("form").each(function () {
        let inputs = $(this).find(":input");
        Object.keys(inputs).forEach((key) => {
            try {
                let el = inputs[key];
                $(`#${el.id}`).blur(function () {
                    validateField($(this), validatorObj);
                });
            } catch (e) {
                console.log("Exception: ", e.message);
            }
        });
    });

    $("form").each(function () {
        let inputs = $(this).find(":input");
        let formName = $(this).attr("name");
        Object.keys(inputs).forEach((key) => {
            let el = inputs[key];
            $(`#${el.id}`).blur(function () {
                validateField($(this), validatorObjects[formName]);
            });
        });
    });*/
	$("form").each(function () {
        let inputs = $(this).find(":input");
        let formName = $(this).attr("name");
        Object.keys(inputs).forEach((key) => {
            let el = inputs[key];
	    if (!(el.id instanceof HTMLElement)) {
            $(`#${el.id}`).blur(function () {
                validateField($(this), validatorObjects[formName]);
            });
	    }
        });
    });
});
