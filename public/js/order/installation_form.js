
     $(function() {
        $("#Installation_detail").modal('hide');
        $("#installationTable").DataTable({
            "autoWidth": false,
            "searching": true,
        });
        $(".btn_installation").click(function() {
            let loopIndex = $(this).attr('loopIndex');
            let orderId = $("#orderId" + loopIndex).val()
            $("#orderIdToSubmit").val(orderId);
            $("#Installation_detail").modal('show');
        });

        $("#btnSubmit").click(function() {
            let myForm = document.getElementById("installationFormID");
            let isValid = isValidForm("installationFormID",  validatorObjects["installationForm"]);

            if (isValid) {
                bootbox.confirm("Are you sure you want to submit the installation details?", function(r) {
                    if (r) {
                        myForm.submit();
                    }
                })
            }
        })
    });