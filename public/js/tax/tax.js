const validatorObjects = {
    taxDetailsForm: {
        tax_name: {
            required: true,
            fieldText: "Tax Name",
        },
        tax_value: {
            required: true,
            fieldText: "Tax Value",
        },
    },
    taxEditForm: {
        tax_name: {
            required: true,
            fieldText: "Tax Name",
        },
        tax_value: {
            required: true,
            fieldText: "Tax Value",
        },
    },
};
$(document).ready(function () {
    $("#loader").hide();
    $("#loader_edit").hide();
    $("#tax_add").modal("hide");

    $("#addTax").click(function () {
        $("#tax_add").modal("show");
    });
    $(".btnEditTax").click(function () {
        let row_num = $(this).attr("row_num");
        let taxId = $(`#taxId${row_num}`).val();
        let taxName = $(`#taxName${row_num}`).val();
        let taxValue = $(`#taxValue${row_num}`).val();
        $(`#tax_name_edit`).val(taxName);
        $(`#tax_value_edit`).val(taxValue);
        $(`#tax_id_edit`).val(taxId);
        $("#tax_edit").modal("show");
    });

    $("#btnTaxSubmit").click(function () {
        let myForm = document.getElementById("taxDetailsFormID");
        let isValid = isValidForm(
            "taxDetailsFormID",
            validatorObjects["taxDetailsForm"]
        );

        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the details for creating the tax?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "taxDetailsFormID",
                validatorObjects["taxDetailsForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });
    $("#btnEditTax").click(function () {
        let myForm = document.getElementById("taxEditFormID");
        let isValid = isValidForm(
            "taxEditFormID",
            validatorObjects["taxEditForm"]
        );

        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the form for updating the tax details?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader_edit").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "taxEditFormID",
                validatorObjects["taxEditForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });

    $(".btnRemoveTax").click(function () {
        let taxId = $(this).attr("tax-id");
        bootbox.confirm(
            "Are you sure you want to delete this tax?",
            function (r) {
                if (r) {
                    window.location = `${baseURL}/tax/delete/${taxId}`;
                }
            }
        );
    });

    $("#btnCancelTax").click(function () {
        $("#tax_name").val("");
        $("#tax_value").val("");
        $("#tax_add").modal("hide");
    });
    $("#btnCloseRoleModal").click(function () {
        $("#tax_name").val("");
        $("#tax_value").val("");
        $("#tax_add").modal("hide");
    });
    $("#taxMasterClose").click(function() {
        $("#tax_edit").modal("hide");
    });
    $("#btnCancelEditTax").click(function() {
        $("#tax_edit").modal("hide");
    });
    
        
});
