$(document).ready(function () {
    $("#loader").hide();
    $("#loader_edit").hide();
    $("#btnAddCustomer").click(function () {
        const isValid = isValidForm(
            "addCustomerFormID",
            validatorObjects["addCustomerForm"]
        );
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want submit the details for creating the customer",
                function (r) {
                    if (r) {
                        var addCustomerForm = document.getElementById(
                            "addCustomerFormID"
                        );
                        addCustomerForm.submit();
                        $("#loader").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "addCustomerFormID",
                validatorObjects["addCustomerForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields</b>: ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });

    $("#btnUpdateCustomer").click(function () {
        const isValid = isValidForm(
            "editCustomerFormID",
            validatorObjects["editCustomerForm"]
        );
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want submit the details for updating the customer",
                function (r) {
                    if (r) {
                        var editCustomerForm = document.getElementById(
                            "editCustomerFormID"
                        );
                        editCustomerForm.submit();
                        $("#loader_edit").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "editCustomerFormID",
                validatorObjects["editCustomerForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });

    $(".btnRemoveCustomer").click(function () {
        let customerId = $(this).attr("customer-id");
        bootbox.confirm(
            "Are you sure you want to delete this customer?",
            function (r) {
                if (r) {
                    window.location = `${baseURL}/customer/delete/${customerId}`;
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

    $("#btnCancel").click(function () {
        window.location = `${baseURL}/all/customer`;
    });
    $("#btnCancelEdit").click(function () {
        window.location = `${baseURL}/all/customer`;
    });
});
