const validatorObjects = {
    addUserForm: {
        role_id: {
            required:true,
            fieldText: "Role"
        },
        first_name: {
            required: true,
            fieldText: "First Name"
        },
        username: {
            required: true,
            fieldText: "Username"
        },
    
        password: {
            required: true,
            fieldText: "Password"
        }
    },
    editUserForm: {
        role_id: {
            required:true,
            fieldText: "Role"
        },
        first_name: {
            required: true,
            fieldText: "First Name"
        },
        username: {
            required: true,
            fieldText: "Username"
        }
    },
    profileUpdate :{
   
        first_name: {
            required: true,
            fieldText: "First Name"
        },
        username: {
            required: true,
            fieldText: "Username"
        }
    },
    changePassForm:{
        password: {
            required:true,
            fieldText: "Password"
        },
        new_password: {
            required:true,
            fieldText: "New Password"
        },
        confirm_password: {
            required:true,
            fieldText: "Confirm Password"
        }
    }
   
   
};


