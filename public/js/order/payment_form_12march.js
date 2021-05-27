//const validatorPaymentObj = {
/* payment_terms: {
        required: true,
        fieldText: "Payment Terms",
    },*/

$(document).ready(function () {
    $("#loader_payment").hide();
    $("#Payment_detail").modal("hide");
    $("#btnEditDiv").hide();
    $("#btnSaveDiv").show();
    $("#paymentTable").DataTable({
        autoWidth: false,
        searching: true,
        info: false,
        ordering: false,
    });


    $(".btn_payment_details").click(function () {
        let loopIndex = $(this).attr("loopIndex");
        let orderId = $(`#orderId${loopIndex}`).val();
        let totalPOValue = $(`#totalPOValue${loopIndex}`).val();
        let totalOrderAmount = $(`#totalOrderAmount${loopIndex}`).val();
        let paymentTerms = $(`#payment_terms${loopIndex}`).val();
        //let invoice_no = $(`#invoice_no${loopIndex}`).val();
        //$(`#totalPaymentToBeReceived`).val(totalPOValue);
        $(`#totalPaymentToBeReceived`).val(totalOrderAmount);
        $(`#total_po_value`).val(totalPOValue);

        let taxAmount = (Number(totalPOValue) * 18) / 100;

        $(`#tax_amount`).val(taxAmount.toFixed(2));
        $(`#total_order_amount`).val(totalOrderAmount);
        $(`#paymentOrderId`).val(orderId);
        $(`#payment_terms`).val(paymentTerms);
        //$(`#invoice_no`).val(invoice_no);
        axios
            .get(`/public/index.php/api/order/payment/details/${orderId}`)
            .then(function (response) {
                let paymentDetails = response.data.paymentList;
                $("#Payment_detail").modal("show");
                //console.table(paymentDetails);

                let totalPaymentReceived = 0;
                if ($.fn.DataTable.isDataTable("#orderPaymentDetailsTable")) {
                    $("#orderPaymentDetailsTable").DataTable().destroy();
                }
                $("#orderPaymentDetailsTable tbody").empty();
                paymentList = [...paymentDetails];
                paymentDetails
                    .sort((p1, p2) => {
                        if (p1.id > p2.id) return -1;
                        if (p1.id < p2.id) return 1;
                        return 0;
                    })
                    .forEach((paymentDetail, index) => {
                        let btnEdit = "";
                        if (index === 0) {
                            btnEdit = `<button type="button" class="btn btn-success btnEditPayment" id="btnEditPayment${index}" divcnt='${index}' payment-detail-id="${paymentDetail.id}"><i class="ion-edit"></i></button>`;
                        }
					  	if(paymentDetail.payment_remark === null){
                            var payRemak = paymentDetail.payment_remark = "";
                        } else{
                            var payRemak  = paymentDetail.payment_remark;
                        }
						if(paymentDetail.invoice_no === null){
                            var invoiceNO = paymentDetail.invoice_no = "";
                        } else{
                            var invoiceNO  = paymentDetail.invoice_no;
                        }
                        if(paymentDetail.invoice_no === null){
                            var invoiceDate = paymentDetail.invoice_date = "";
                        } else{
							let dt = moment(paymentDetail.invoice_date, "YYYY-MM-DD").format("DD/MM/YYYY");
                            var invoiceDate  = dt;
						}
                        $("#orderPaymentDetailsTable tbody").append(`
                        <tr>
                            <td>${invoiceNO}</td>
                            <td>${invoiceDate}</td>
                            <td>${paymentDetail.amount_paid}</td>
                            <td>${paymentDetail.tax_paid}</td>
                            <td>${paymentDetail.payment_received}</td>
                            <td>${paymentDetail.balance_payment}</td>
 							<td>${payRemak}</td>
							<td style="text-align: center">
                                ${btnEdit}
                            </td>
                        </tr>
                    `);
                        totalPaymentReceived += Number(
                            paymentDetail.payment_received
                        );
                        //$("#payment_terms").val(paymentDetail.payment_terms);
                        //$("#balance_payment").val(paymentDetail.balance_payment);
                    });

                $(".btnEditPayment").click(function () {
                    console.log("Editing...");
                    let paymentDetailId = Number(
                        $(this).attr("payment-detail-id")
                    );
                    $("#btnEditDiv").show();
                    $("#btnSaveDiv").hide();

                    let totalPaymentToBeReceived = Number(
                        $("#totalPaymentToBeReceived").val()
                    );

                    let totalPaymentReceived = Number(
                        $("#totalPaymentReceived").val()
                    );

                    paymentCalc.totalPaymentToBeReceived = totalPaymentToBeReceived;
                    paymentCalc.totalPaymentReceived = totalPaymentReceived;

                    for (let payment of paymentList) {
                        if (paymentDetailId === payment.id) {
                            $("#invoice_no").val(payment.invoice_no);
                            $("#invoice_date").val(payment.invoice_date);
                            $("#amount_paid").val(payment.amount_paid);
                            $("#taxes").val(payment.tax_paid);
                            $("#os_days").val(payment.os_days);
                            $("#payment_received").val(
                                payment.payment_received
                            );
                            $("#balance_payment").val(payment.balance_payment);
                            $("#payment_received_date").val(
                                payment.payment_received_date
                            );
							$("#payment_remark").val(
                                payment.payment_remark
                            );
                            $("#paymentDetailId").val(paymentDetailId);

                            /*let tobeReceived =
                                Number(payment.balance_payment) +
                                Number(payment.payment_received);
                            $("#totalPaymentToBeReceived").val(tobeReceived);*/
                            let totalPaymentReceivedCal = Number(
                                $("#totalPaymentReceived").val()
                            );
                            $("#totalPaymentReceived").val(
                                totalPaymentReceivedCal -
                                    payment.payment_received
                            );
                            break;
                        }
                    }
                });

                $("#orderPaymentDetailsTable").DataTable({
                    autoWidth: false,
                    searching: false,
                });
                $("#totalPaymentReceived").val(totalPaymentReceived);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            });
    });
    $("#btnCancelAddPayment").click(function () {
        $("#os_days").val("");
        $("#amount_paid").val("");
        $("#invoice_no").val("");
        $("#invoice_date").val("");
        $("#taxes").val("");
        $("#payment_received").val("");
        $("#balance_payment").val("");
        $("#payment_received_date").val("");
		$("#payment_remark").val("");
        $("#paymentDetailid").val("");
        $("#Payment_detail").modal("hide");
        $("#btnEditDiv").hide();
        $("#btnSaveDiv").show();
    });

    $("#btnClosePaymentModal").click(function () {
        $("#os_days").val("");
        $("#amount_paid").val("");
        $("#invoice_no").val("");
        $("#invoice_date").val("");
        $("#taxes").val("");
        $("#payment_received").val("");
        $("#balance_payment").val("");
        $("#payment_received_date").val("");
		$("#payment_remark").val("");
        $("#paymentDetailid").val("");
        $("#Payment_detail").modal("hide");
        $("#btnEditDiv").hide();
        $("#btnSaveDiv").show();
    });
 
    $("#btnCancelEditPayment").click(function () {
        $("#os_days").val("");
        $("#invoice_no").val("");
        $("#invoice_date").val("");
        $("#amount_paid").val("");
        $("#taxes").val("");
        $("#payment_received").val("");
        $("#balance_payment").val("");
        $("#payment_received_date").val("");
        $("#paymentDetailid").val("");
        $("#btnEditDiv").hide();
        $("#btnSaveDiv").show();

        $("#totalPaymentToBeReceived").val(
            paymentCalc.totalPaymentToBeReceived
        );
        $("#totalPaymentReceived").val(paymentCalc.totalPaymentReceived);

        paymentCalc.totalPaymentToBeReceived = 0;
        paymentCalc.totalPaymentReceived = 0;
    });

    $("#payment_received").change(function () {
        let paymentReceived = Number($(this).val());
        let totalPaymentToBeReceived = Number(
            $("#totalPaymentToBeReceived").val()
        );

        let totalPaymentReceived = Number($("#totalPaymentReceived").val());

        let pendingPayment = totalPaymentToBeReceived - totalPaymentReceived;
        let balancePayment = pendingPayment - paymentReceived;
        console.table({
            paymentReceived,
            totalPaymentToBeReceived,
            totalPaymentReceived,
            pendingPayment,
            balancePayment,
        });
        $("#balance_payment").val(balancePayment);
    });

    $("#btnSubmit").click(function (event) {
        event.preventDefault();
        let isValid = isValidForm(
            "paymentDetailsFormID",
            validatorObjects["paymentDetailsForm"]
        );
        let myForm = document.getElementById("paymentDetailsFormID");
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the payment details?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "paymentDetailsFormID",
                validatorObjects["paymentDetailsForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });

    $("#btnUpdate").click(function (event) {
        event.preventDefault();
        let isValid = isValidForm(
            "paymentDetailsFormID",
            validatorObjects["paymentDetailsForm"]
        );
        let myForm = document.getElementById("paymentDetailsFormID");
        myForm.action = `${baseURL}/update/paymentdetails`;
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to update the payment details?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader_payment").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "paymentDetailsFormID",
                validatorObjects["paymentDetailsForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });

    $("#amount_paid").change(function () {
        let amount = Number($(this).val());
        let tax_paid = (amount * 18) / 1000;
        $("#taxes").val(tax_paid);
        let payment_received = amount + tax_paid;
        $("#payment_received").val(payment_received);
        $("#payment_received").change();
    });
});
