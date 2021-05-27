const validatorObjects = {
    roleDetailsForm: {
        role_name: {
            required: true,
            fieldText: "Role Name",
        },
    },
    roleEditForm: {
        role_name: {
            required: true,
            fieldText: "Role Name",
        },
    },
};
$(document).ready(function () {
    $("#loader").hide();
    $("#loader_edit").hide();
    $("#role_add").modal("hide");

    $("#addRole").click(function () {
        $("#role_add").modal("show");
    });
    $(".btnEditRole").click(function () {
        let row_num = $(this).attr("row_num");
        let roleId = $(`#roleId${row_num}`).val();
        let roleName = $(`#roleName${row_num}`).val();
        let roleDescription = $(`#roleDescription${row_num}`).val();
        $(`#role_name_edit`).val(roleName);
        $(`#role_description_edit`).val(roleDescription);
        $(`#role_id_edit`).val(roleId);
        $("#role_edit").modal("show");
    });

    $("#btnRoleSubmit").click(function () {
        let myForm = document.getElementById("roleDetailsFormID");
        let isValid = isValidForm(
            "roleDetailsFormID",
            validatorObjects["roleDetailsForm"]
        );

        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the details for creating the role?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "roleDetailsFormID",
                validatorObjects["roleDetailsForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });
    $("#btnEditRole").click(function () {
        let myForm = document.getElementById("roleEditFormID");
        let isValid = isValidForm(
            "roleEditFormID",
            validatorObjects["roleEditForm"]
        );

        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the form for updating the role details?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader_edit").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "roleEditFormID",
                validatorObjects["roleEditForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });

    $(".btnRemoveRole").click(function () {
        let roleId = $(this).attr("role-id");
        bootbox.confirm(
            "Are you sure you want to delete this role?",
            function (r) {
                if (r) {
                    window.location = `${baseURL}/role/delete/${roleId}`;
                }
            }
        );
    });

    $("#btnCancelRole").click(function () {
        $("#role_name").val("");
        $("#role_description").val("");
        $("#role_add").modal("hide");
    });
    $("#btnCloseRoleModal").click(function () {
        $("#role_name").val("");
        $("#role_description").val("");
        $("#role_add").modal("hide");
    });
    $("#roleMasterClose").click(function() {
        $("#role_edit").modal("hide");
    });
    $("#btnCancelEditRole").click(function() {
        $("#role_edit").modal("hide");
    });
    
        
});
