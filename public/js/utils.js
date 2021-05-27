const initDatepicker = (initObj) => {
    const {
        title = "",
        autoclose = true,
        todayHighlight = true,
        endDate = new Date(moment().add(100, "years").valueOf()),
        format = "dd/mm/yyyy",
    } = initObj;

    return {
        title,
        autoclose,
        todayHighlight,
        endDate,
        format,
    };
};

const getAllFormFieldNames = (formId) => {
    var inputs = document.getElementById(formId).elements;
    var ids = [];
    for (i = 0; i < inputs.length; i++) {
        if (
            inputs[i].nodeName === "INPUT" ||
            inputs[i].nodeName === "SELECT" ||
            inputs[i].nodeName === "PASSWORD"
        ) {
            ids.push(inputs[i].name);
        }
    }
    return _.join(ids, ",");
};

const validateField = (el, validatorObj) => {
    let isValid = true;
    let fieldName = el.attr("name");
    let fieldVal = el.val();
    //console.log("isValidField: " + isValidField(fieldName, fieldVal));
    isValidField(fieldName, fieldVal, validatorObj, el);
};

const isValidField = (fieldName, fieldVal, validatorObj, el) => {
    if (
        validatorObj[fieldName] !== undefined &&
        validatorObj[fieldName] !== null
    ) {
        let isValid = true;
        if (
            fieldVal !== undefined &&
            fieldVal !== null &&
            typeof fieldVal !== "string"
        ) {
            fieldVal = fieldVal.toString();
        }

        if (validatorObj[fieldName].required) {
            //Convert the value to string
            isValid =
                fieldVal !== undefined && fieldVal !== null && fieldVal !== "";
            if (!isValid) {
                let errorFieldText = "";
                if (validatorObj[fieldName].fieldText) {
                    errorFieldText = validatorObj[fieldName].fieldText;
                } else {
                    errorFieldText = fieldName;
                }
                if (validatorObj[fieldName].multipleFields) {
                    $(`#${_.snakeCase(el.attr("id"))}_error`).html(
                        `Field ${errorFieldText} is required!`
                    );
                } else {
                    $(`#${_.snakeCase(fieldName)}_error`).html(
                        `Field ${errorFieldText} is required!`
                    );
                }
                //console.log("ErrorfieldTetx: " + errorFieldText);
                $(`#${_.snakeCase(fieldName)}`).addClass("highlight_error");
                //break;
            } else {
                if (validatorObj[fieldName].multipleFields) {
                    $(`#${_.snakeCase(el.attr("id"))}_error`).html("");
                } else {
                    $(`#${_.snakeCase(fieldName)}_error`).html("");
                }

                $(`#${_.snakeCase(fieldName)}`).removeClass("highlight_error");
            }
        }

        if (validatorObj[fieldName].regex) {
            let regex = validatorObj[fieldName].regex;
            isValid = regex.pattern.test(fieldVal);

            if (!isValid) {
                if (validatorObj[fieldName].multipleFields) {
                    $(`#${_.snakeCase(el.attr("id"))}_error`).html(
                        regex.errorMessage
                            ? regex.errorMessage
                            : `Invalid Input!`
                    );
                } else {
                    $(`#${_.snakeCase(fieldName)}_error`).html(
                        regex.errorMessage
                            ? regex.errorMessage
                            : `Invalid Input!`
                    );
                }
                $(`#${_.snakeCase(key)}`).addClass("highlight_error");
                //break;
            } else {
                if (validatorObj[fieldName].multipleFields) {
                    $(`#${_.snakeCase(el.attr("id"))}_error`).html("");
                } else {
                    $(`#${_.snakeCase(fieldName)}_error`).html("");
                }
                $(`#${_.snakeCase(fieldName)}`).removeClass("highlight_error");
            }
        }

        if (validatorObj[fieldName].compare) {
            let comparator = validatorObj[fieldName].compare;
            let fieldValToCompare = formInputs[comparator.with];
            if (comparator.condition === "eq") {
                isValid = fieldVal === fieldValToCompare;
            } else if (comparator.condition === "gt") {
                isValid = fieldVal > fieldValToCompare;
            } else if (comparator.condition === "lt") {
                isValid = fieldVal < fieldValToCompare;
            } else if (comparator.condition === "gte") {
                isValid = fieldVal >= fieldValToCompare;
            } else if (comparator.condition === "lte") {
                isValid = fieldVal <= fieldValToCompare;
            }

            if (!isValid) {
                if (validatorObj[fieldName].multipleFields) {
                    $(`#${_.snakeCase(el.attr("id"))}_error`).html(
                        comparator.errorMessage
                            ? comparator.errorMessage
                            : `Invalid Input!`
                    );
                } else {
                    $(`#${_.snakeCase(fieldName)}_error`).html(
                        comparator.errorMessage
                            ? comparator.errorMessage
                            : `Invalid Input!`
                    );
                }
                $(`#${_.snakeCase(fieldName)}`).addClass("highlight_error");
                //break;
            } else {
                if (validatorObj[fieldName].multipleFields) {
                    $(`#${_.snakeCase(el.attr("id"))}_error`).html("");
                } else {
                    $(`#${_.snakeCase(fieldName)}_error`).html("");
                }

                $(`#${_.snakeCase(fieldName)}`).removeClass("highlight_error");
            }
        }
        return isValid;
    }
};

const isValidForm = (formId, validatorObj) => {
    let isValid = true;
    const formInputs = {};
    $(`#${formId}`)
        .serializeArray()
        .forEach((formInput) => {
            formInputs[formInput.name] = formInput.value;
        });

    let keys = Object.keys(validatorObj);
    for (let key of keys) {
        if (validatorObj[key] !== undefined && validatorObj[key] !== null) {
            let isValidField = true;
            let fieldVal = formInputs[key];

            if (
                fieldVal !== undefined &&
                fieldVal !== null &&
                typeof fieldVal !== "string"
            ) {
                fieldVal = fieldVal.toString();
            }

            if (validatorObj[key].required) {
                //Convert the value to string
                isValidField =
                    fieldVal !== undefined &&
                    fieldVal !== null &&
                    fieldVal !== "";

                let errorFieldText = "";
                if (validatorObj[key].fieldText) {
                    errorFieldText = validatorObj[key].fieldText;
                } else {
                    errorFieldText = key;
                }
                if (!isValidField) {
                    if (validatorObj[key].multipleFields) {
                        showErrorForMultipleFields(
                            key,
                            errorFieldText,
                            "required"
                        );
                    } else {
                        $(`#${_.snakeCase(key)}_error`).html(
                            `Field ${errorFieldText} is required!`
                        );
                    }

                    $(`#${_.snakeCase(key)}`).addClass("highlight_error");
                    isValid = false;
                    //break;
                    //console.log(`${key} field is not valid`);
                } else {
                    if (validatorObj[key].multipleFields) {
                        showErrorForMultipleFields(
                            key,
                            errorFieldText,
                            "required"
                        );
                    } else {
                        $(`#${_.snakeCase(key)}_error`).html("");
                    }

                    $(`#${_.snakeCase(key)}`).removeClass("highlight_error");
                }
            }

            if (validatorObj[key].regex) {
                let regex = validatorObj[key].regex;
                isValidField = regex.pattern.test(fieldVal);

                if (!isValidField) {
                    if (validatorObj[key].multipleFields) {
                        showErrorForMultipleFields(
                            key,
                            errorFieldText,
                            "regex",
                            regex
                        );
                    } else {
                        $(`#${_.snakeCase(key)}_error`).html(
                            regex.errorMessage
                                ? regex.errorMessage
                                : `Invalid Input!`
                        );
                    }

                    $(`#${_.snakeCase(key)}`).addClass("highlight_error");
                    isValid = false;
                    //break;
                } else {
                    if (validatorObj[key].multipleFields) {
                        showErrorForMultipleFields(
                            key,
                            errorFieldText,
                            "regex",
                            regex
                        );
                    } else {
                        $(`#${_.snakeCase(key)}_error`).html("");
                    }
                    $(`#${_.snakeCase(key)}`).removeClass("highlight_error");
                }
            }

            if (validatorObj[key].compare) {
                let comparator = validatorObj[key].compare;
                let fieldValToCompare = formInputs[comparator.with];
                if (comparator.condition === "eq") {
                    isValidField = fieldVal === fieldValToCompare;
                } else if (comparator.condition === "gt") {
                    isValidField = fieldVal > fieldValToCompare;
                } else if (comparator.condition === "lt") {
                    isValidField = fieldVal < fieldValToCompare;
                } else if (comparator.condition === "gte") {
                    isValidField = fieldVal >= fieldValToCompare;
                } else if (comparator.condition === "lte") {
                    isValidField = fieldVal <= fieldValToCompare;
                }

                if (!isValidField) {
                    if (validatorObj[key].multipleFields) {
                        showErrorForMultipleFields(
                            key,
                            errorFieldText,
                            "compare",
                            { ...comparator, fieldValToCompare }
                        );
                    } else {
                        $(`#${_.snakeCase(key)}_error`).html(
                            comparator.errorMessage
                                ? comparator.errorMessage
                                : `Invalid Input!`
                        );
                    }
                    $(`#${_.snakeCase(key)}`).addClass("highlight_error");
                    isValid = false;
                    //break;
                } else {
                    if (validatorObj[key].multipleFields) {
                        showErrorForMultipleFields(
                            key,
                            errorFieldText,
                            "compare",
                            comparator
                        );
                    } else {
                        $(`#${_.snakeCase(key)}_error`).html("");
                    }
                    $(`#${_.snakeCase(key)}`).removeClass("highlight_error");
                }
            }
        }
    }
    return isValid;
};

const getInvalidFields = (formId, validatorObj) => {
    let invalidFieldNames = [];
    let isValid = true;
    const formInputs = {};
    $(`#${formId}`)
        .serializeArray()
        .forEach((formInput) => {
            formInputs[formInput.name] = formInput.value;
        });

    let keys = Object.keys(validatorObj);
    for (let key of keys) {
        if (validatorObj[key] !== undefined && validatorObj[key] !== null) {
            let isValidField = true;
            let fieldVal = formInputs[key];

            if (
                fieldVal !== undefined &&
                fieldVal !== null &&
                typeof fieldVal !== "string"
            ) {
                fieldVal = fieldVal.toString();
            }

            if (validatorObj[key].required) {
                //Convert the value to string
                isValidField =
                    fieldVal !== undefined &&
                    fieldVal !== null &&
                    fieldVal !== "";
                if (!isValidField) {
                    let errorFieldText = "";
                    if (validatorObj[key].fieldText) {
                        errorFieldText = validatorObj[key].fieldText;
                    } else {
                        errorFieldText = key;
                    }
                    $(`#${_.snakeCase(key)}_error`).html(
                        `Field ${errorFieldText} is required!`
                    );
                    $(`#${_.snakeCase(key)}`).addClass("highlight_error");
                    isValid = false;
                    if (!invalidFieldNames.includes(errorFieldText))
                        invalidFieldNames.push(errorFieldText);
                    //break;
                    //console.log(`${key} field is not valid`);
                } else {
                    $(`#${_.snakeCase(key)}_error`).html("");
                    $(`#${_.snakeCase(key)}`).removeClass("highlight_error");
                }
            }

            if (validatorObj[key].regex) {
                let regex = validatorObj[key].regex;
                isValidField = regex.pattern.test(fieldVal);

                if (!isValidField) {
                    let errorFieldText = "";
                    if (validatorObj[key].fieldText) {
                        errorFieldText = validatorObj[key].fieldText;
                    } else {
                        errorFieldText = key;
                    }

                    $(`#${_.snakeCase(key)}_error`).html(
                        regex.errorMessage
                            ? regex.errorMessage
                            : `Invalid Input!`
                    );
                    $(`#${_.snakeCase(key)}`).addClass("highlight_error");
                    isValid = false;
                    if (!invalidFieldNames.includes(errorFieldText))
                        invalidFieldNames.push(errorFieldText);
                    //break;
                } else {
                    $(`#${_.snakeCase(key)}_error`).html("");
                    $(`#${_.snakeCase(key)}`).removeClass("highlight_error");
                }
            }

            if (validatorObj[key].compare) {
                let comparator = validatorObj[key].compare;
                let fieldValToCompare = formInputs[comparator.with];
                if (comparator.condition === "eq") {
                    isValidField = fieldVal === fieldValToCompare;
                } else if (comparator.condition === "gt") {
                    isValidField = fieldVal > fieldValToCompare;
                } else if (comparator.condition === "lt") {
                    isValidField = fieldVal < fieldValToCompare;
                } else if (comparator.condition === "gte") {
                    isValidField = fieldVal >= fieldValToCompare;
                } else if (comparator.condition === "lte") {
                    isValidField = fieldVal <= fieldValToCompare;
                }

                if (!isValidField) {
                    let errorFieldText = "";
                    if (validatorObj[key].fieldText) {
                        errorFieldText = validatorObj[key].fieldText;
                    } else {
                        errorFieldText = key;
                    }

                    $(`#${_.snakeCase(key)}_error`).html(
                        comparator.errorMessage
                            ? comparator.errorMessage
                            : `Invalid Input!`
                    );
                    $(`#${_.snakeCase(key)}`).addClass("highlight_error");
                    isValid = false;
                    if (!invalidFieldNames.includes(errorFieldText))
                        invalidFieldNames.push(errorFieldText);
                    //break;
                } else {
                    $(`#${_.snakeCase(key)}_error`).html("");
                    $(`#${_.snakeCase(key)}`).removeClass("highlight_error");
                }
            }
        }
    }
    return invalidFieldNames;
};

const showErrorForMultipleFields = (
    fieldName,
    errorFieldText,
    validationType,
    validationTypeObj = null
) => {
    //let els = $(`input[name="${fieldName}"]`);
    let els = document.getElementsByName(fieldName);

    if (validationType === "required") {
        Object.keys(els).forEach((key) => {
            let el = els[key];
            if (el !== undefined) {
                console.log(el);
                if (
                    el.value === undefined ||
                    el.value === null ||
                    el.value === ""
                ) {
                    $(`#${_.snakeCase(el.id)}_error`).html(
                        `Field ${errorFieldText} is required`
                    );
                } else {
                    $(`#${_.snakeCase(el.id)}_error`).html("");
                }
            }
        });
    } else if (validationType === "regex") {
        Object.keys(els).forEach((key) => {
            let el = els[key];
            let isValidField = validationTypeObj.pattern.test(el.value);

            if (!isValidField) {
                $(`#${_.snakeCase(el.id)}_error`).html(
                    regex.errorMessage ? regex.errorMessage : `Invalid Input!`
                );
            } else {
                $(`#${_.snakeCase(el.id)}_error`).html("");
            }
        });
    } else if (validationType === "compare") {
        let fieldValToCompare = validationTypeObj.fieldValToCompare;
        if (validationTypeObj.condition === "eq") {
            isValidField = el.value === fieldValToCompare;
        } else if (validationTypeObj.condition === "gt") {
            isValidField = el.value > fieldValToCompare;
        } else if (validationTypeObj.condition === "lt") {
            isValidField = el.value < fieldValToCompare;
        } else if (validationTypeObj.condition === "gte") {
            isValidField = el.value >= fieldValToCompare;
        } else if (validationTypeObj.condition === "lte") {
            isValidField = el.value <= fieldValToCompare;
        }

        Object.keys(els).forEach((key) => {
            let el = els[key];
            let isValidField = validationTypeObj.pattern.test(el.value);

            if (!isValidField) {
                $(`#${_.snakeCase(el.id)}_error`).html(
                    regex.errorMessage ? regex.errorMessage : `Invalid Input!`
                );
            } else {
                $(`#${_.snakeCase(el.id)}_error`).html("");
            }
        });
    }
    //field-error
};
