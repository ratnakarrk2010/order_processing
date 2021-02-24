$(document).ready(function () {
    $("#loader").hide();
    $("#btnLogin").click(function () {
        //$("#loader").show();
        console.log("In login");
        const isValid = isValidForm("loginFormID", validatorObjects["loginForm"]);
        if (isValid) {
            $("#loader").show();
            var loginForm = document.getElementById("loginFormID");
            loginForm.submit();
        } 
    });

    $("form").each(function () {
        let inputs = $(this).find(":input");
        let formName = $(this).attr("name");
        Object.keys(inputs).forEach((key) => {
            let el = inputs[key];
            $(`#${el.id}`).blur(function () {
                validateField($(this), validatorObjects[formName]);
            });
        });
    });
});
