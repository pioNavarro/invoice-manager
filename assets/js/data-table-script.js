jQuery(document).ready(function ($) {
    console.log('data-table');
    var imDataTable = $('#im-data-table').DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"<"#im-status">><"col-sm-12 col-md-6 im-left-section"<"#im-filter">f<"#im-btn-actions">>>rt<"#im-footer.row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>><"clear">',
        language: {
            search: "_INPUT_", //To remove Search Label
            searchPlaceholder: "Search",
            info:"PAGE _PAGE_ OF _PAGES_",
            paginate: {
                previous: '<',
                next: '>',
            }
        },
        pageLength: 10,
        processing: true,
        serverSide: true,
        ajax: {
            url: imAjax.ajaxurl,
            data : {"action": "im_get_data"},
            type: 'POST',
        },
        columnDefs: [
            { orderable: false, targets: [0,10] }
        ],
        columns: [
            { 
                data: 'id',
                render: function ( data, type, row ) {
                if ( type === 'display' ) {
                    return '<input type="checkbox" class="editor-active">';
                }
                return data;
                }
            },
            { data: 'post_title' },
            { data: '_restaurant_name' },
            { 
                data: '_status', 
                className: "im-status",
                render: function ( data, type, row ) {
                    var color = 'bg-success';
                    color = (data == 'ongoing')? 'bg-secondary' : color;
                    color = (data =='pending')? 'bg-warning' : color;
                    if ( type === 'display' ) {
                        return '<span class="badge rounded-pill '+color+'">' + data + '</span>';
                    }
                    return data;
                }
            },
            { data: '_start_date' },
            { data: '_end_date' },
            { data: '_total' },
            { data: '_fees' },
            { data: '_transfer' },
            { data: '_orders' },
            { 
                data: 'id',
                render: function ( data, type, row ) {
                    if ( type === 'display' ) {
                        return '<i class="bi bi-cloud-arrow-down"></i>';
                    }
                    return data;
                }
            },
        ],
    });

    $('#im-btn-actions').html('<button class="btn btn-warning btn-sm">Mark as paid</button>');
    $('#im-filter').html('Filter dates here');
    $('#im-status').html('<span class="badge bg-secondary">All</span>'
                        +'<span class="badge text-dark">ONGOING</span>'
                        +'<span class="badge text-dark">VERIFIED</span>'
                        +'<span class="badge text-dark">PENDING</span>');
});