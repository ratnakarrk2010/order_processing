$(document).ready(function () {
    $("#loader").hide();
    $("#loader_edit").hide();
    $("#loader_payment").hide();

    /*$("#opf_date").datepicker({
        format: "mm/dd/yyyy",
        onSelect: function (selectedDate) {
            $("#opf_date").val(selectedDate);
            console.log("selectedDate: ", selectedDate);
            validateField($("#opf_date"));
        },
    });*/
    $("#order_collected_by_id").change(function () {
        var orderCollectedBy = $(
            "#order_collected_by_id option:selected"
        ).text();
        //console.log("orderCollectedBy==>"+orderCollectedBy);
        $("#order_collected_by").val(orderCollectedBy);
    });
    $("#sales_initiator_by_id").change(function () {
        var salesInitiatordBy = $(
            "#sales_initiator_by_id option:selected"
        ).text();
        $("#sales_initiator_by").val(salesInitiatordBy);
        //console.log("salesInitiatordBy==>" + salesInitiatordBy);
    });
    $("#approved_by_id").change(function () {
        var approvedBy = $("#approved_by_id option:selected").text();
        $("#approved_by").val(approvedBy);
        //console.log("approvedBy==>"+approvedBy);
    });
    $("#payment_terms_id").change(function () {
        var paymentTerms = $("#payment_terms_id option:selected").text();
        $("#payment_terms").val(paymentTerms);
        //console.log("payment_terms==>" + paymentTerms);
    });
    /*$("#installation_assigned_to_id").change(function () {
        var installationAssignedTo = $(
            "#installation_assigned_to_id option:selected"
        ).text();
        $("#installation_assigned_to").val(installationAssignedTo);
    });*/

    $("#btnAddOrder").click(function () {
        const isValid = isValidForm(
            "orderFormID",
            validatorObjects["orderForm"]
        );
        const isValidOrderDetails = isValidForm(
            "rowAppend :input",
            validatorObjects["poDetails"]
        );
        if (isValid && isValidOrderDetails) {
            bootbox.confirm(
                "Are you sure you want to submit the order?",
                function (r) {
                    if (r) {
                        var orderFormID = document.getElementById(
                            "orderFormID"
                        );
                        orderFormID.submit();
                        $("#loader").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "orderFormID",
                validatorObjects["orderForm"]
            );
            if (invalidFields.length <= 0) {
                invalidFields = getInvalidFields(
                    "rowAppend :input",
                    validatorObjects["poDetails"]
                );
                //console.log("invalidFields: ", invalidFields);
            }
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(
                    invalidFields,
                    ",&nbsp;"
                )}`,
                function () {}
            );
        }
    });

    $("#btnUpdateOrder").click(function () {
        /*const isValid = isValidForm(
            "editOrderFormID",
            validatorObjects["editOrderForm"]
        );*/

        let formValidatorObject = { ...validatorObjects["editOrderForm"] };

        if (loggedInUserRole === 1 || loggedInUserRole === 7) {
            formValidatorObject = {
                ...formValidatorObject,
                order_status: {
                    required: true,
                    fieldText: "Order Status",
                },
                approved_by_id: {
                    required: true,
                    fieldText: "Approved / Rejected By Management",
                },
            };
        }

        const isValid = isValidForm("editOrderFormID", formValidatorObject);
        console.log("isValid: " + isValid);
        const isValidOrderDetails = isValidForm(
            "rowAppend :input",
            validatorObjects["poDetails"]
        );
        if (isValid && isValidOrderDetails) {
            bootbox.confirm(
                "Are you sure you want to update the order details?",
                function (r) {
                    if (r) {
                        var editOrderFormID = document.getElementById(
                            "editOrderFormID"
                        );
                        editOrderFormID.submit();
                        $("#loader_edit").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "editOrderFormID",
                formValidatorObject
            );
            if (invalidFields.length <= 0) {
                invalidFields = getInvalidFields(
                    "rowAppend :input",
                    validatorObjects["poDetails"]
                );
                //console.log("invalidFields: ", invalidFields);
            }
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(
                    invalidFields,
                    ",&nbsp;"
                )}`,
                function () {}
            );
        }
    });

    $("#btnAddPaymnetDetails").click(function () {
        //console.log("paymentValidatorObj", validatorPaymentObj);
        const isValid = isValidForm(
            "paymentDetailsFormID",
            validatorObjects["paymentDetailsForm"]
        );
        if (isValid) {
            var paymentDetailsFormID = document.getElementById(
                "paymentDetailsFormID"
            );
            paymentDetailsFormID.submit();
            $("#loader_payment").show();
        } else {
            let invalidFields = getInvalidFields(
                "paymentDetailsFormID",
                validatorObjects["paymentDetailsForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(
                    invalidFields,
                    ",&nbsp;"
                )}`,
                function () {}
            );
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

    /*(".btnOrderDTDelete").click(function () {
        let orderDetailsId = $(this).attr("order-details-address-id");
        let loopIndex = $(this).attr("loop-idx");
        console.log("loopIndex: " + loopIndex);

        $.ajax({
            url: `${baseURL}/api/order/details/${orderDetailsId}`,
            method: "DELETE",
            type: "json",
            success: function (response) {
                $(`#materialDiv${loopIndex}`).remove();
            },
            error: function (err, errorText, xhr) {
                console.log("Error: " + err.message);
            },
        });
    });*/

    $(".btnOrderDTDelete").click(function () {
        let orderDetailsId = $(this).attr("order-details-address-id");
        let loopIndex = $(this).attr("loop-idx");
        console.log("loopIndex: " + loopIndex);

        if (Number(orderDetailsId) != 0) {
            $.ajax({
                url: `${baseURL}/api/order/details/${orderDetailsId}`,
                method: "DELETE",
                type: "json",
                success: function (response) {
                    $(`#materialDiv${loopIndex}`).remove();
                },
                error: function (err, errorText, xhr) {
                    console.log("Error: " + err.message);
                },
            });
        } else {
            $(`#materialDiv${loopIndex}`).remove();
        }
    });

    $("#addInstallationAddress").click(function () {
        installation_address_row += 1;
        $("#installation_addresses").append(`
            <div class="col-sm-4 addressDivs" id="installationAddressDiv${installation_address_row}">
                <div class="form-material">
                    <textarea class="form-control" id="installation_address${installation_address_row}" divcnt="${installation_address_row}" name="installation_address[]" rows="1" placeholder="Installation Address" style="resize: none;"></textarea>
                    <label for="installation_address${installation_address_row}" id="installation_address_label${installation_address_row}" class="required installation_address_label">Installation Address ${installation_address_row}</label>
                    <div class="field-error" id="installation_address_${installation_address_row}_error"></div>
                </div>
                <button class="btn btn-xs delInstallationAddress btnRemoveInstallationAddress" id="delInst${installation_address_row}" type="button" data-toggle="tooltip" 
                title="Remove Address" installation-address-id="0" loop-idx="${installation_address_row}"><i class="fa fa-trash"></i></button>
            </div>
        `);

        // Register a function to remove the installation address on the add new order form after clicking on "Add New Installation Address" button
        $(".btnRemoveInstallationAddress").click(function () {
            let installationAddressId = $(this).attr("installation-address-id");
            let loopIndex = $(this).attr("loop-idx");
            removeInstallationAddress(loopIndex, installationAddressId);
        });

        // Register the blur function to validate the newly address installation addresses
        $(`#installation_address${installation_address_row}`).blur(function () {
            validateField(
                $(this),
                validatorObjects[isEdit ? "editOrderForm" : "orderForm"]
            );
        });

        /*$(`#delInst${installation_address_row}`).click(function () {
            console.log("delete address");
            let loopIndex = $(this).attr("loop-idx");
            $(`#addressDiv${loopIndex}`).remove();
            let addrs = document.getElementsByName("installation_address[]");
            console.log("Address==>" + addrs);
            if (addrs === undefined || addrs.length === 0) {
                let addBtn = $("#addInstallationAddress");
                console.log("In If addreslength");
                $("#addInstallationAddress").click();
            }
        });*/
    });

    // Register a delete function on the edit page
    $(".btnRemoveInstallationAddress").click(function () {
        let installationAddressId = $(this).attr("installation-address-id");
        let loopIndex = $(this).attr("loop-idx");
        removeInstallationAddress(loopIndex, installationAddressId);
    });

    $("#addInstallationAddressEdit").click(function () {
        installation_address_row += 1;
        $("#installationAddressesEdit").append(`
            <div class="addressDivs" id="installationAddressDiv${installation_address_row}">
                <div class="col-sm-4">
                    <div class="form-material">
                    <textarea class="form-control" id="installation_address${installation_address_row}" name="installation_address[]" rows="1" placeholder="Installation Address" style="resize: none;"></textarea>
                    <input type="hidden" id="installation_address_${installation_address_row}" name="installation_address_id[]" value="0">
                    <label for="installation_address${installation_address_row}" id="installation_address_label${installation_address_row}" class="required">Installation Address ${installation_address_row}</label>
                    <div class="field-error" id="installation_address_${installation_address_row}_error"></div>
                    </div>
                    <button class="btn btn-xs delInstallationAddress btnRemoveInstallationAddress" type="button" data-toggle="tooltip" 
                    title="Remove Address" installation-address-id="0" loop-idx="${installation_address_row}"><i class="fa fa-trash"></i></button>
                </div>
               
            </div>
        `);

        // Register remove function after appending the new installation address
        $(".btnRemoveInstallationAddress").click(function () {
            let installationAddressId = $(this).attr("installation-address-id");
            let loopIndex = $(this).attr("loop-idx");
            removeInstallationAddress(loopIndex, installationAddressId);
        });

        // Register the blur function to validate the newly address installation addresses
        $(`#installation_address${installation_address_row}`).blur(function () {
            console.log("In blur");
            validateField(
                $(this),
                validatorObjects[isEdit ? "editOrderForm" : "orderForm"]
            );
        });
    });

    $("#btnCancel").click(function () {
        window.location = `${getBaseURL()}/add/order`;
    });

    $("#btnCancelEdit").click(function () {
        window.location = `${getBaseURL()}/all/orders`;
    });
    /*Tax Change 21April2021*/
    $("#total_po_value").change(function () {
        let po_value = Number($(this).val());
        let tax_value = Number($("#tax_value").val());
        console.log("taxValue==>"+tax_value);
        let tax = (po_value * tax_value) / 100;
        let total_amount = Math.round(po_value + tax);
        $("#tax_amount").val(tax);
        $("#total_order_amount").val(total_amount);
    });
    $("#tax_id").change(function () {
        var taxValue = $("#tax_id option:selected").text();
        $("#tax_value").val(taxValue);
        if ($("#total_po_value").val() !== "") {
            let po_value = Number($("#total_po_value").val());
            let tax_value = Number($("#tax_value").val());
            console.log("taxValue==>"+tax_value);
            let tax = (po_value * tax_value) / 100;
            let total_amount = Math.round(po_value + tax);
            $("#tax_amount").val(tax);
            $("#total_order_amount").val(total_amount);
        }
    });
});

const removeInstallationAddress = (loopIndex, installationAddressId) => {
    let addrs = document.getElementsByName("installation_address[]");
    let totalAddresses = addrs.length;
    let remainingAddresses = totalAddresses - 1;
    if (remainingAddresses === 0) {
        bootbox.alert(
            "You must keep at least one installation address!",
            function () {
                /*if (isEdit) {
                    $("#addInstallationAddressEdit").click();
                } else {
                    $("#addInstallationAddress").click();
                }*/
            }
        );
    } else {
        if (Number(installationAddressId) != 0) {
            $.ajax({
                url: `${baseURL}/api/installation/address/${installationAddressId}`,
                method: "DELETE",
                type: "json",
                success: function (response) {
                    $(`#installationAddressDiv${loopIndex}`).remove();
                },
                error: function (err, errorText, xhr) {
                    console.log("Error: " + err.message);
                },
            });
        } else {
            $(`#installationAddressDiv${loopIndex}`).remove();
        }

        let address_labels = $(".installation_address_label").get();
        installation_address_row = address_labels.length;
        address_labels.forEach((address_label, index) => {
            $(`#${address_label.id}`).html(`InstallationAddress ${index + 1}`);
        });
    }
};
