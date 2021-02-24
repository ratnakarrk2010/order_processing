$(document).ready(function () {
    $("#btnAddCustomer").click(function () {
        const isValid = isValidForm("addCustomerFormID", validatorObjects["addCustomerForm"]);
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want submit the details for creating the customer",
                function (r) {
                    if (r) {
                        var addCustomerForm = document.getElementById(
                            "addCustomerFormID"
                        );
                        addCustomerForm.submit();
                    }
                }
            );
        }
    });

    $("#btnUpdateCustomer").click(function () {
        const isValid = isValidForm("editCustomerFormID", validatorObjects["editCustomerForm"]);
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want submit the details for updating the customer",
                function (r) {
                    if (r) {
                        var editCustomerForm = document.getElementById(
                            "editCustomerFormID"
                        );
                        editCustomerForm.submit();
                    }
                }
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
});
