$(function () {
    $("#loader").hide();
    $("#loader_assigned").hide();
    $("#Installation_detail").modal("hide");
    $("#installtionAssignedToModal").modal("hide");

    $("#installation_assigned_to_id").change(function () {
        console.log("change function");
        var installationAssignedTo = $(
            "#installation_assigned_to_id option:selected"
        ).text();
        $("#installation_assigned_to_setvalue").val(installationAssignedTo);
    });

    $(".btn_installation").click(function () {
        let loopIndex = $(this).attr("loopIndex");
        let orderId = $("#orderId" + loopIndex).val();
        $("#orderIdToSubmit").val(orderId);
        //$("#Installation_detail").modal("show");
        $.ajax({
            url: `${baseURL}/api/order/installation/details/${orderId}`,
            method: "GET",
            type: "json",
            success: function (response) {
                //let assigedTo = response.assigedTo;
                if (response != null) {
                    if (Object.keys(response.assigedTo).length > 0) {
                        var obj = response.assigedTo[0];
                        $(`#installation_assigned_to_readonly`).val(
                            obj.installation_assigned_to
                        );
                        $(`#installation_assigned_to_id_readonly`).val(
                            obj.installation_assigned_to_id
                        );
                    }
                }

                $("#Installation_detail").modal({
                    backdrop: "static",
                    keyboard: false,
                    show: true,
                });
            },
            error: function (err, errorText, xhr) {
                console.log("Error: " + err.message);
            },
        });
    });
    $(".btn_installationAssignedTo").click(function () {
        let loopIndex = $(this).attr("loopIndex");
        console.log("in assign");
        let orderId = $("#orderId" + loopIndex).val();
        $("#orderIdToSubmitForAssignedTo").val(orderId);

        //$("#Installation_detail").modal("show");
        $("#installtionAssignedToModal").modal({
            backdrop: "static",
            keyboard: false,
            show: true,
        });
    });

    $("#btnSubmit").click(function () {
        let myForm = document.getElementById("installationFormID");
        let isValid = isValidForm(
            "installationFormID",
            validatorObjects["installationForm"]
        );

        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the installation details?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "installationFormID",
                validatorObjects["installationForm"]
            );
            bootbox.alert(
                `Fill values for the fields: ${_.join(invalidFields, ",")}`,
                function () {}
            );
        }
    });
    $("#btnAssignedTo").click(function () {
        let myForm = document.getElementById("installationAssignedFormID");
        let isValid = isValidForm(
            "installationAssignedFormID",
            validatorObjects["installationAssignedForm"]
        );

        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to assigned this installation person for this order?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader_assigned").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "installationAssignedFormID",
                validatorObjects["installationAssignedForm"]
            );
            bootbox.alert(
                `Fill values for the fields: ${_.join(invalidFields, ",")}`,
                function () {}
            );
        }
    });
    $("#btnCancelAssignedToModal").click(function () {
        $("#installation_assigned_to_id").val("");
        $("#installation_assigned_to").val("");
        $("#installtionAssignedToModal").modal("hide");
    });
    $("#btnAddCloseInstallationAssignedToModal").click(function () {
        $("#installation_assigned_to_id").val("");
        $("#installation_assigned_to").val("");
        $("#installtionAssignedToModal").modal("hide");
    });

    $("#btnAddCloseInstallationModal").click(function () {
        //$("#installation_assigned_to_id").val("");
        $("#installation_start_date").val("");
        $("#installation_completion_date").val("");
        $("#Installation_detail").modal("hide");
    });
    $("#btnCancelInstallationModal").click(function () {
        //$("#installation_assigned_to_id").val("");
        $("#installation_start_date").val("");
        $("#installation_completion_date").val("");
        $("#Installation_detail").modal("hide");
    });

    $("#installationTable").DataTable({
        autoWidth: false,
        searching: true,
    });
});
