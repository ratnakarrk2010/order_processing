$(document).ready(function () {
    $("#loader").hide();
    $("#loader_edit").hide();
    $("#btnAddNewUser").click(function () {
        const isValid = isValidForm(
            "addUserFormID",
            validatorObjects["addUserForm"]
        );
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the details for creating the user?",
                function (r) {
                    if (r) {
                        var addUserForm = document.getElementById(
                            "addUserFormID"
                        );
                        addUserForm.submit();
                        $("#loader").show();
                    }
                }
            );
        }else {
            let invalidFields = getInvalidFields(
                "addUserFormID",
                validatorObjects["addUserForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });

    $("#btnUpdateUser").click(function () {
        const isValid = isValidForm(
            "editUserFormId",
            validatorObjects["editUserForm"]
        );
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the form for updating the user details?",
                function (r) {
                    if (r) {
                        var editUserForm = document.getElementById(
                            "editUserFormId"
                        );
                        editUserForm.submit();
                        $("#loader_edit").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "editUserFormId",
                validatorObjects["editUserForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });
    $(".btnRemoveUser").click(function () {
        let userId = $(this).attr("user-id");
        bootbox.confirm(
            "Are you sure you want to delete this user?",
            function (r) {
                if (r) {
                    window.location = `${baseURL}/users/delete/${userId}`;
                }
            }
        );
    });

    $("#btnChangePass").click(function () {
        const isValid = isValidForm(
            "changePassFormID",
            validatorObjects["changePassForm"]
        );
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the form for updating the user password?",
                function (r) {
                    if (r) {
                        var changePassFormID = document.getElementById(
                            "changePassFormID"
                        );
                        changePassFormID.submit();
                        $("#profile-tab3").click(function () {
                            $("#profile-tab3").addClass("in active");
                        });
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "changePassFormID",
                validatorObjects["changePassForm"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
    });
    $("#btnProfileUpdate").click(function () {
        const isValid = isValidForm(
            "profileUpdateId",
            validatorObjects["profileUpdate"]
        );
        console.log("isValid: " + isValid);
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the form for updating the user profile details?",
                function (r) {
                    if (r) {
                        var profileUpdateId = document.getElementById(
                            "profileUpdateId"
                        );
                        profileUpdateId.submit();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "profileUpdateId",
                validatorObjects["profileUpdate"]
            );
            bootbox.alert(
                `<b>Fill values for the fields:</b> ${_.join(invalidFields, ",&nbsp;")}`,
                function () {}
            );
        }
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

    /**
     * Set Email as a Username
     */
    $("#username").change(function () {
        var username = $("#username").val();
        $("#email").val(username);
        $("#email").attr("readonly", true);
    });
    var url = baseURL + "/api/email_available/check";
    //console.log("url====>",url );
    $("#username").blur(function () {
        var error_username = "";
        var username = $("#username").val();
        var _token = $('input[name = "_token"]').val();
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(username)) {
            $("#username_error").html("Invalid Email");
            $("#username_error").addClass("field-error");
            $("#btnAddNewUser").attr("disabled", "disabled");
        } else {
            $.ajax({
                url: baseURL + "/api/email_available/check",
                //url: "{{ route('email_available.check') }}",
                method: "POST",
                data: { username: username, _token: _token },
                type: "json",
                success: function (response) {
                    //var r = JSON.parse(response);
                    // console.log("response====>");
                    let msg = response.msg;
                    //console.log("response====>"+msg);
                    if (msg == "unique") {
                        $("#username_error").html("Email Available");
                        $("#username_error").removeClass("field-error");
                        $("#username_error").addClass("success");
                        $("#btnAddNewUser").attr("disabled", false);
                    } else {
                        $("#username_error").html("Email not Available");
                        $("#username_error").addClass("field-error");
                        $("#username_error").removeClass("success");
                        $("#btnAddNewUser").attr("disabled", "disabled");
                    }
                },
            });
        }
    });
});
