const validatorObjects = {
    menuMapForm: {
        role_id: {
            required: true,
            fieldText: "Role",
        },
        menu_id: {
            required: true,
            fieldText: "Menu Name",
        },
    },
    menuMapEditForm: {
        role_id_edit: {
            required: true,
            fieldText: "Role",
        },
        menu_id: {
            required: true,
            fieldText: "Menu Name",
        },
    },
};
$(document).ready(function () {
    $("#loader").hide();
    $("#loader_edit").hide();

    $("#menu_map_add").modal("hide");

    //Populate submenu dropdown
    $("#menu_id").change(function () {
        let parentMenuId = $("#menu_id").val();
        console.log("menu_id==>" + parentMenuId);
        if (Number(parentMenuId) != null) {
            $.ajax({
                url: `${baseURL}/api/submenu/all/${parentMenuId}`,
                method: "GET",
                type: "json",
                success: function (response) {
                    console.log("Response==>", response.submenuList);
                    //var menus = response.submenuList;
                    var len = response.submenuList.length;
                    console.log("len==>" + len);

                    $("#subMenu").empty();
                    var s = '<option value="0">Please Select</option>';
                    for (var i = 0; i < len; i++) {
                        var id = response.submenuList[i]["id"];
                        console.log("ID==>" + id);
                        var menu_name = response.submenuList[i]["menu_name"];
                        //$("#subMenu").append("<option value='"+id+"'>"+menu_name+"</option>");
                        //$("#subMenu").append(new Option(menu_name,id));

                        s +=
                            '<option value="' +
                            id +
                            '">' +
                            menu_name +
                            "</option>";
                    }
                    $("#subMenu").html(s);
                },
                error: function (err, errorText, xhr) {
                    console.log("Error: " + err.message);
                },
            });
        } else {
            console.log("In else");
        }
    });
    $("#menu_id_edit").change(function () {
        let parentMenuId = $("#menu_id_edit").val();
        console.log("menu_id_edit==>" + parentMenuId);
        if (Number(parentMenuId) != null) {
            $.ajax({
                url: `${baseURL}/api/submenu/all/${parentMenuId}`,
                method: "GET",
                type: "json",
                success: function (response) {
                    //console.log("Response==>", response.submenuList);
                    //var menus = response.submenuList;
                    var len = response.submenuList.length;
                    //console.log("len==>"+len);

                    $("#subMenuEdit").empty();
                    var s = '<option value="0">---Select--</option>';
                    for (var i = 0; i < len; i++) {
                        var id = response.submenuList[i]["id"];
                        //console.log("ID==>"+id);
                        var menu_name = response.submenuList[i]["menu_name"];
                        //$("#subMenu").append("<option value='"+id+"'>"+menu_name+"</option>");
                        //$("#subMenu").append(new Option(menu_name,id));
                        s +=
                            '<option value="' +
                            id +
                            '" selected="selected">' +
                            menu_name +
                            "</option>";
                    }
                    $("#subMenuEdit").html(s);
                },
                error: function (err, errorText, xhr) {
                    console.log("Error: " + err.message);
                },
            });
        } else {
            console.log("In else");
        }
    });

    $("#addRoleMenuMap").click(function () {
        $("#menu_map_add").modal("show");
    });
    $("#btnSubmitMenuMap").click(function () {
        let myForm = document.getElementById("menuMapFormID");
        let isValid = isValidForm(
            "menuMapFormID",
            validatorObjects["menuMapForm"]
        );

        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the details?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "menuMapFormID",
                validatorObjects["menuMapForm"]
            );
            bootbox.alert(
                `Fill values for the fields: ${_.join(invalidFields, ",")}`,
                function () {}
            );
        }
    });
    $(".btnEditMenuMap").click(function () {
        let row_num = $(this).attr("row_num");
        let menuId = $(`#menuId${row_num}`).val();
        let roleID = $(`#roleID${row_num}`).val();
        let menuMapStatus = $(`#mappinStatus${row_num}`).val();
        let subMenuEdit = $(`#subMenu${row_num}`).val();

        let roleMenuMapId = $(`#roleMenuMapId${row_num}`).val();
        $(`#menu_id_edit`).val(menuId);
        $(`#role_id_edit`).val(roleID);
        $(`#mapping_status_edit`).val(menuMapStatus);
        $(`#subMenuEdit`).val(subMenuEdit);
        $(`#role_menu_map_id`).val(roleMenuMapId);
        $("#menu_map_edit").modal("show");
    });
    $("#btnEditMapSubmit").click(function () {
        let myForm = document.getElementById("menuMapEditFormID");
        let isValid = isValidForm(
            "menuMapEditFormID",
            validatorObjects["menuMapEditForm"]
        );
        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to update menu mapping details?",
                function (r) {
                    if (r) {
                        myForm.submit();
                        $("#loader_edit").show();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "menuMapEditFormID",
                validatorObjects["menuMapEditForm"]
            );
            bootbox.alert(
                `Fill values for the fields: ${_.join(invalidFields, ",")}`,
                function () {}
            );
        }
    });
    $(".btnRemoveMenuMap").click(function () {
        let menuMapID = $(this).attr("menu-map-id");
        bootbox.confirm(
            "Are you sure you want to delete this role mapping?",
            function (r) {
                if (r) {
                    window.location = `${baseURL}/rolemenu/delete/${menuMapID}`;
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
