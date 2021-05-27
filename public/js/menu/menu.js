const validatorObjects = {
    menuDetailsForm: {
        menu_name: {
            required: true,
            fieldText: "Menu Name",
        },
        menu_type: {
            required: true,
            fieldText: "Menu Type",
        },
        menu_icon: {
            required: true,
            fieldText: "Menu Icon",
        },
        menu_path: {
            required: true,
            fieldText: "Menu Path",
        },
        parent_menu_id: {
            required: true,
            fieldText: "Parent Menu Name",
        },
    },
    menuDetailsEditForm: {
        menu_name: {
            required: true,
            fieldText: "Menu Name",
        },
        menu_type: {
            required: true,
            fieldText: "Menu Type",
        },
        menu_icon: {
            required: true,
            fieldText: "Menu Icon",
        },
        menu_path: {
            required: true,
            fieldText: "Menu Path",
        },
        parent_menu_id: {
            required: true,
            fieldText: "Parent Menu Name",
        },
    },
};
$(document).ready(function () {
    $("#menu_add").modal("hide");

    $("#addMenu").click(function () {
        $("#menu_add").modal("show");
    });
    $("#btnSubmitMenu").click(function () {
        let myForm = document.getElementById("menuDetailsFormID");
        let isValid = isValidForm(
            "menuDetailsFormID",
            validatorObjects["menuDetailsForm"]
        );

        if (isValid) {
            bootbox.confirm(
                "Are you sure you want to submit the details for creating the menu?",
                function (r) {
                    if (r) {
                        myForm.submit();
                    }
                }
            );
        } else {
            let invalidFields = getInvalidFields(
                "menuDetailsFormID",
                validatorObjects["menuDetailsForm"]
            );
            bootbox.alert(
                `Fill values for the fields: ${_.join(invalidFields, ",")}`,
                function () {}
            );
        }
    });
    $(".btnEditMenu").click(function () {
        let row_num = $(this).attr("row_num");
        let menuId = $(`#menuId${row_num}`).val();
        let roleName = $(`#roleName${row_num}`).val();
        let roleDescription = $(`#roleDescription${row_num}`).val();
        $(`#role_name_edit`).val(roleName);
        $(`#role_description_edit`).val(roleDescription);
        $(`#role_id_edit`).val(roleId);
        $("#role_edit").modal("show");
    });
});
$(document).ready(function () {
	$("#role_id").change(function() {
		$("#menu_mapping_div").html("");
	});
    $("#btnGetMenuMapping").click(function () {
        if ($("#role_id").val() != "0") {
            let myForm = document.getElementById("menuMappingFormId");
            myForm.action = `${baseURL}/search/menu/mapping`;
            myForm.submit();
        } else {
            bootbox.alert(
                "Select <b>ROLE</b> for which you want to show the menu mapping!"
            );
        }
    });
    $("#btnReset").click(function () {
        window.location = `${baseURL}/menu/mapping`;
    });
    $("#btnUpdateMapping").click(function () {
		if($("#role_id").val() !== "" && $("#role_id").val() != 0) {
			bootbox.confirm(
				"Are you sure you want to update the menu mapping?",
				function (r) {
					if (r) {
						let myForm = document.getElementById("menuMappingFormId");
						myForm.action = `${baseURL}/map/menu`;
						myForm.submit();
					}
				}
			);
		} else {
			bootbox.alert("Select Role!", function() {});
		}
    });
    $(".main-menus").change(function () {
        let isChecked = $(this).is(":checked");
        let loopIndex = $(this).attr("loop-index");
        if (isChecked) {
            // If main menu is checked then select all the submenus
            $(`.sub-menu-${loopIndex}`).prop("checked", "checked");
        } else {
            // If main menu is unchecked then deselect all submenus
            $(`.sub-menu-${loopIndex}`).attr("checked", false);
            $(`.sub-menu-${loopIndex}`).removeProp("checked");
        }
    });

    $(".sub-menus").change(function () {
        let isChecked = $(this).is(":checked");
        let loopIndex = $(this).attr("loop-index");
        let mainMenuIndex = $(this).attr("main-menu-index");
        if (isChecked) {
            // If main menu is checked then select all the submenus
            let isMenumenuChecked = $(`#mainMenu${mainMenuIndex}`).is(
                ":checked"
            );
            if (!isMenumenuChecked) {
                $(`#mainMenu${mainMenuIndex}`).prop("checked", "checked");
            }
        } else {
            /*
             * Check if any submeny for the given main menu is checked
             * If no submenu is cheched then uncheck the main menu
             */
            let subMenus = $(`.sub-menu-${mainMenuIndex}`).get();
            let totalChecked = _.sum(
                subMenus.map((subMenuEl) => {
                    let isChecked = $(`#${subMenuEl.id}`).is(":checked");
                    if (isChecked) return 1;
                    else return 0;
                })
            );
            if (totalChecked === 0) {
                $(`#mainMenu${mainMenuIndex}`).attr("checked", false);
                $(`#mainMenu${mainMenuIndex}`).removeProp("checked");
            }
        }
    });
});
