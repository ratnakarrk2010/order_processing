const validatorObjects = {
    orderForm: {
        opf_no: {
            required: true,
            fieldText: "OPF No",
        },
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
        total_po_value: {
            required: true,
            fieldText: "Total PO Value",
        },
        payment_terms_id: {
            required: true,
            fieldText: "Payment Terms",
        },
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
    editOrderForm: {
        opf_no: {
            required: true,
            fieldText: "OPF No",
        },
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
        total_po_value: {
            required: true,
            fieldText: "Total PO Value",
        },
        payment_terms_id: {
            required: true,
            fieldText: "Payment Terms",
        },
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
        installation_assigned_to: {
            required: true,
            fieldText: "Installation Assigned To",
        },
        installation_start_date: {
            required: true,
            fieldText: "Installation Start Date",
        },
        installation_completion_date: {
            required: true,
            fieldText: "Installation Completion date",
        },
    },
};
