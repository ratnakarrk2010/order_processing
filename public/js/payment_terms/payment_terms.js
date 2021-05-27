const validatorObjects = {
    ptDetailsForm: {
        payment_terms: {
            required: true,
            fieldText: "Payment Terms",
        },
    },
    ptEditForm: {
        payment_terms: {
            required: true,
            fieldText: "Payment Terms",
        },
    },
};
$(document).ready(function () {
    $("#loader").hide();
    $("#loader-edit").hide();
    $("#payment_terms_add").modal("hide");

    $("#addPaymentTerms").click(function () {
        $("#payment_terms_add").modal("show");
    });
    $(".btnEditPT").click(function () {
        let row_num = $(this).attr("row_num");
        let paymentTermsId = $(`#paymentTermsId${row_num}`).val();
        let paymentTerms = $(`#paymentTerms${row_num}`).val();
        let paymentTermsValue = $(`#paymentTermsValue${row_num}`).val();
        $(`#payment_terms_edit`).val(paymentTerms);
        $(`#value_figure_edit`).val(paymentTermsValue);
        $(`#payment_terms_id_edit`).val(paymentTermsId);
        $("#payment_terms_editID").modal("show");
        $("#loader").hide();
    });

    $("#btnPTSubmit").click(function () {
        let myForm = document.getElementById("ptDetailsFormID");
        let isValid = isValidForm(
            "ptDetailsFormID",
            validatorObjects["ptDetailsForm"]
        );
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the Payment Terms?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "ptDetailsFormID",
                validatorObjects["ptDetailsForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });
    $("#btnEditPaymentTerms").click(function () {
        let myForm = document.getElementById("ptEditFormID");
        let isValid = isValidForm(
            "ptEditFormID",
            validatorObjects["ptEditForm"]
        );
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the form for updating the Payment Terms details?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader-edit").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "ptEditFormID",
                validatorObjects["ptEditForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });

    $(".btnRemovePaymentTerms").click(function () {
        let ptId = $(this).attr("pt-id");
        bootbox.confirm(
            "Are you sure you want to delete this payment terms?",
            function (r) {
                if (r) {
                    window.location = `${baseURL}/payment/terms/delete/${ptId}`;
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

    $("#btnCancelPaymentTerms").click(function () {
        $("#payment_terms").val("");
        $("#value_figure").val("");
        $("#payment_terms_add").modal("hide");
    });
    $("#btnClosePaymentTermsModal").click(function () {
        $("#payment_terms").val("");
        $("#value_figure").val("");
        $("#payment_terms_add").modal("hide");
    });
    $("#paymentMasterEditClose").click(function() {
        $("#payment_terms_editID").modal("hide");
    });
    $("#btnCancelEditPaymentTersm").click(function() {
        $("#payment_terms_editID").modal("hide");
    });
});
