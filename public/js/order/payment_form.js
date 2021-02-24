//const validatorPaymentObj = {
   /* payment_terms: {
        required: true,
        fieldText: "Payment Terms",
    },*/


$(document).ready(function () {
    $("#Payment_detail").modal("hide");
    $("#paymentTable").DataTable({
        autoWidth: false,
        searching: true,
    });

    $(".btn_payment_details").click(function () {
        let loopIndex = $(this).attr("loopIndex");
        let orderId = $(`#orderId${loopIndex}`).val();
        let totalPOValue = $(`#totalPOValue${loopIndex}`).val();
        let paymentTerms = $(`#payment_terms${loopIndex}`).val();
        let invoice_no = $(`#invoice_no${loopIndex}`).val();
        $(`#totalPaymentToBeReceived`).val(totalPOValue);
        $(`#paymentOrderId`).val(orderId);
        $(`#payment_terms`).val(paymentTerms);
        $(`#invoice_no`).val(invoice_no);
        axios
            .get(`/api/order/payment/details/${orderId}`)
            .then(function (response) {
                let paymentDetails = response.data.paymentList;
                $("#Payment_detail").modal("show");
                console.table(paymentDetails);

                let totalPaymentReceived = 0;
                if ($.fn.DataTable.isDataTable("#orderPaymentDetailsTable")) {
                    $("#orderPaymentDetailsTable").DataTable().destroy();
                }
                $("#orderPaymentDetailsTable tbody").empty();
                paymentDetails.forEach((paymentDetail) => {
                    $("#orderPaymentDetailsTable tbody").append(`
                        <tr>
                            <td>${paymentDetail.payment_received}</td>
                            <td>${moment(
                                paymentDetail.payment_received_date
                            ).format("DD/MM/YYYY")}</td>
                            <td>${paymentDetail.balance_payment}</td>
                        </tr>
                    `);
                    totalPaymentReceived += Number(paymentDetail.payment_received);
                    //$("#payment_terms").val(paymentDetail.payment_terms);
                    //$("#balance_payment").val(paymentDetail.balance_payment);
                });

                $("#orderPaymentDetailsTable").DataTable({
                    autoWidth: false,
                    searching: true,
                });
                //hard reload and check  ok
                $("#totalPaymentReceived").val(totalPaymentReceived);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
    });

    $("#payment_received").change(function () {
        let paymentReceived = Number($(this).val());
        let totalPaymentToBeReceived = Number(
            $("#totalPaymentToBeReceived").val()
        );

        let totalPaymentReceived = Number($("#totalPaymentReceived").val());// search for this hidden field

        let pendingPayment = totalPaymentToBeReceived - totalPaymentReceived;
        let balancePayment = pendingPayment - paymentReceived;
        console.table({paymentReceived, totalPaymentToBeReceived, totalPaymentReceived, pendingPayment, balancePayment});
        $("#balance_payment").val(balancePayment);
    });

    $("#btnSubmit").click(function (event) {
        event.preventDefault();
        console.log("btnAddPaymnetDetails: ");
        let isValid = isValidForm("paymentDetailsFormID", validatorObjects["paymentDetailsForm"]);
        
        console.log("isValid: " + isValid);
        let myForm = document.getElementById("paymentDetailsFormID");
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the payment details?",
                function (r) {
                    if (r) {
                        myForm.submit();
                    }
                }
            );
        }
    });
});
