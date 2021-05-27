const validatorObjects = {
    addCustomerForm: {
        client_name: {
            required: true,
            fieldText: "Client Name",
        },
        type_of_customer: {
            required: true,
            fieldText: "Type of Customer",
        },

        address: {
            required: true,
            fieldText: "Address",
        },

        contact_person1: {
            required: true,
            fieldText: "Contact Person1",
        },
        designation_main: {
            required: true,
            fieldText: "Designation Main",
        },
        email_id: {
            required: true,
            fieldText: "Email Id",
            regex: {
                pattern: /^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/,
                errorMessage: "The email should be as abc@gmail.com",
            },
        },
        contact1: {
            required: true,
            fieldText: "Contact No1",
            regex: {
                pattern: /^(\+\d{1,3}[- ]?)?\d{10}$/,
                errorMessage:
                    "The contact number should be minimum 10 digit number",
            },
        },
        /*contact_person2: {
            required: true,
            fieldText: "Contact Person2",
        },
        /*email_installation: {
            required: true,
            fieldText: "Email Id Of Installation Person",
            regex: {
                pattern: /^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/,
                errorMessage: "The email should be as abc@gmail.com",
            },
        },
        contact2: {
            required: true,
            fieldText: "Contact No2",
            regex: {
                pattern: /^(\+\d{1,3}[- ]?)?\d{10}$/,
                errorMessage:
                    "The contact number should be minimum 10 digit number",
            },
        },*/
        /*contact_person3: {
            required: true,
            fieldText: "Contact Person3",
        },
        email_payment: {
            required: true,
            fieldText: "Email Id Of Payment Contact Person",
            regex: {
                pattern: /^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/,
                errorMessage: "The email should be as abc@gmail.com",
            },
        },
        contact3: {
            required: true,
            fieldText: "Contact No3",
            regex: {
                pattern: /^(\+\d{1,3}[- ]?)?\d{10}$/,
                errorMessage: "The contact number should be 10 digit number",
            },
        },*/
    },

    editCustomerForm: {
        client_name: {
            required: true,
            fieldText: "Client Name",
        },
        type_of_customer: {
            required: true,
            fieldText: "Type of Customer",
        },
        address: {
            required: true,
            fieldText: "Address",
        },

        contact_person1: {
            required: true,
            fieldText: "Contact Person1",
        },
        designation_main: {
            required: true,
            fieldText: "Designation Main",
        },
        email_id: {
            required: true,
            fieldText: "Email Id",
            regex: {
                pattern: /^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/,
                errorMessage: "The email should be as abc@gmail.com",
            },
        },
        contact1: {
            required: true,
            fieldText: "Contact No1",
            regex: {
                pattern: /^(\+\d{1,3}[- ]?)?\d{10}$/,
                errorMessage:
                    "The contact number should be minimum 10 digit number",
            },
        }
        /*contact_person2: {
            required: true,
            fieldText: "Contact Person2",
        },
        email_installation: {
            required: true,
            fieldText: "Email Id Of Installation Person",
            regex: {
                pattern: /^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/,
                errorMessage: "The email should be as abc@gmail.com",
            },
        },
        contact2: {
            required: true,
            fieldText: "Contact No2",
            regex: {
                pattern: /^(\+\d{1,3}[- ]?)?\d{10}$/,
                errorMessage:
                    "The contactnumber should be minimum 10 digit number",
            },
        },
        contact_person3: {
            required: true,
            fieldText: "Contact Person3",
        },
        /*email_payment: {
            required: true,
            fieldText: "Email Id Of Payment Contact Person",
            regex: {
                pattern: /^[a-zA-Z0-9+_.-]+@[a-zA-Z0-9.-]+$/,
                errorMessage: "The email should be as abc@gmail.com",
            },
        },
        contact3: {
            required: true,
            fieldText: "Contact No3",
            regex: {
                pattern: /^(\+\d{1,3}[- ]?)?\d{10}$/,
                errorMessage:
                    "The contactnumber should be minimum 10 digit number",
            },
        },*/
    },
};
