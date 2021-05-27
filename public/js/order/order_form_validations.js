const validatorObjects = {
    orderForm: {
        /*opf_no: {
            required: true,
            fieldText: "OPF No",
        },*/
        opf_date: {
            required: true,
            fieldText: "OPF Date",
        },
        po_no: {
            required: true,
            fieldText: "PO No",
        },
        po_date: {
            required: true,
            fieldText: "PO Date",
        },
        customer_id: {
            required: true,
            fieldText: "Customer Name",
        },

        "installation_address[]": {
            required: true,
            fieldText: "Installation Address",
            multipleFields: true,
        },
        order_collected_by_id: {
            required: true,
            fieldText: "Order Collected By",
        },
        warranty_period: {
            required: true,
            fieldText: "Waranty Period",
        },
        sales_initiator_by_id: {
            required: true,
            fieldText: "Initiate By Manager",
        },
        /* order_status: {
            required: true,
            fieldText: "Order Status",
        },
        approved_by_id: {
            required: true,
            fieldText: "Approved and Accepted By Management",
        },*/
		tax_id: {
            required: true,
            fieldText: "Tax Value",
        },
        total_po_value: {
            required: true,
            fieldText: "Total PO Value",
        },
        payment_terms_id: {
            required: true,
            fieldText: "Payment Terms",
        },
        /*delivery_period: {
            required: true,
            fieldText: "Delivery Period",
        },
        ld_clause_applicable: {
            required: true,
            fieldText: "LD Clause Applicable",
        },*/
        /*material_procurement_date: {
            required: true,
            fieldText: "Material Prcurement Date",
        },
        qc_testting_result: {
            required: true,
            fieldText: "QC Test Result",
        },
        dispatch_date: {
            required: true,
            fieldText: "Dispatch Date",
        },*/
    },
    poDetails: {
        "materials[]": {
            required: true,
            fieldText: "Materials",
            multipleFields: true,
        },
        "make[]": {
            required: true,
            fieldText: "Make",
            multipleFields: true,
        },
        "model[]": {
            required: true,
            fieldText: "Model",
            multipleFields: true,
        },
        "quantity[]": {
            required: true,
            fieldText: "Quantity",
            multipleFields: true,
        },
        /*"dc_no[]": {
            required: true,
            fieldText: "DC No",
            multipleFields: true,
        },
        "dc_date[]": {
            required: true,
            fieldText: "DC Date",
            multipleFields: true,
        },
        "product_serial_no[]": {
            required: true,
            fieldText: "Product Serial No",
            multipleFields: true,
        },*/
    },
    editOrderForm: {
        /*opf_no: {
            required: true,
            fieldText: "OPF No",
        },*/
        opf_date: {
            required: true,
            fieldText: "OPF Date",
        },
        po_no: {
            required: true,
            fieldText: "PO No",
        },
        po_date: {
            required: true,
            fieldText: "PO Date",
        },
        customer_id: {
            required: true,
            fieldText: "Customer Name",
        },

        "installation_address[]": {
            required: true,
            fieldText: "Installation Address",
            multipleFields: true,
        },
        order_collected_by_id: {
            required: true,
            fieldText: "Order Collected By",
        },
        warranty_period: {
            required: true,
            fieldText: "Waranty Period",
        },
        sales_initiator_by_id: {
            required: true,
            fieldText: "Initiate By Manager",
        },
        /*order_status: {
            required: true,
            fieldText: "Order Status",
        },
        approved_by_id: {
            required: true,
            fieldText: "Approved and Accepted By Management",
        },*/
		tax_id: {
            required: true,
            fieldText: "Tax Value",
        },
        total_po_value: {
            required: true,
            fieldText: "Total PO Value",
        },
        payment_terms_id: {
            required: true,
            fieldText: "Payment Terms",
        },
        /*delivery_period: {
            required: true,
            fieldText: "Delivery Period",
        },
        ld_clause_applicable: {
            required: true,
            fieldText: "LD Clause Applicable",
        },*/
        /*material_procurement_date: {
            required: true,
            fieldText: "Material Prcurement Date",
        },
        qc_testting_result: {
            required: true,
            fieldText: "QC Test Result",
        },
        dispatch_date: {
            required: true,
            fieldText: "Dispatch Date",
        },*/
    },
    paymentDetailsForm: {
        invoice_no: {
            required: true,
            fieldText: "Invoice Number",
        },
        invoice_date: {
            required: true,
            fieldText: "Invoice Date",
        },
        os_days: {
            required: true,
            fieldText: "Outstanding Days",
        },
        amount_paid: {
            required: true,
            fieldText: "Amount Paid",
        },
        dc_no: {
            required: true,
            fieldText: "DC No",
        },
        dc_date: {
            required: true,
            fieldText: "DC Date",
        },
        product_serial_no: {
            required: true,
            fieldText: "Product Serial No",
        },
        payment_received: {
            required: true,
            fieldText: "Payment Received",
        },
        balance_payment: {
            required: true,
            fieldText: "Balance Payment",
        },
        payment_received_date: {
            required: true,
            fieldText: "Payment Received Date",
        },
    },
    installationForm: {
        /*installation_assigned_to: {
            required: true,
            fieldText: "Installation Assigned To",
        },*/
        installation_start_date: {
            required: true,
            fieldText: "Installation Start Date",
        },
        installation_completion_date: {
            required: true,
            fieldText: "Installation Completion date",
        },
    },

    installationAssignedForm: {
        installation_assigned_to_id: {
            required: true,
            fieldText: "Installation Assigned To",
        },
    }
};
