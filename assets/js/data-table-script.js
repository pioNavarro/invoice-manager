jQuery(document).ready(function ($) {
    console.log('data-table');
    var imDataTable = $('#im-data-table').DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"<"#im-status">><"col-sm-12 col-md-6 im-left-section"<"#im-filter">f<"#im-btn-actions">>>rt<"row"ip><"clear">',
        language: {
            search: "_INPUT_", //To remove Search Label
            searchPlaceholder: "Search",
            info:"PAGE _PAGE_ OF _PAGES_"
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: imAjax.ajaxurl,
            data : {"action": "im_get_data"},
            type: 'POST',
        },
        columns: [
            { data: 'id' },
            { data: 'invoice_id' },
            { data: 'restaurant_name' },
            { data: 'status' },
            { data: 'start_date' },
            { data: 'end_date' },
            { data: 'total' },
            { data: 'fees' },
            { data: 'transfer' },
            { data: 'orders' },
            { data: 'id' },
        ],
    });

    $('#im-btn-actions').html('<button class="btn btn-warning btn-sm">Mark as paid</button>');
    $('#im-filter').html('Filter dates here');
    $('#im-status').html('<span class="badge bg-secondary">All</span>'
                        +'<span class="badge text-dark">ONGOING</span>'
                        +'<span class="badge text-dark">VERIFIED</span>'
                        +'<span class="badge text-dark">PENDING</span>');
});