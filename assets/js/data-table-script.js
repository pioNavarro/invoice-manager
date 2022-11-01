jQuery(document).ready(function ($) {
    console.log('data-table');
    var imDataTable = $('#im-data-table').DataTable({
        dom: '<"row"<"col-sm-12 col-md-6"<"#im-status">><"col-sm-12 col-md-6 im-left-section"<"#im-filter">f<"#im-btn-actions">>>r<"#im-table-wrap"t<"#im-footer.row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>><"clear">',
        responsive: true,
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
        order: [[1, 'asc']],
        columns: [
            { 
                data: 'id',
                className: 'text-center',
                render: function ( data, type, row ) {
                if ( type === 'display' ) {
                    return '<input type="checkbox" class="form-check-input im-selected">';
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
                        return '<span class="badge fw-normal text-uppercase rounded-pill '+color+'">' + data + '</span>';
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
                        return '<a href="#" class="im-download" title="download invoice"><i class="bi bi-cloud-arrow-down"></i></a>';
                    }
                    return data;
                }
            },
        ],
    });

    $('#im-toggle').click(function(e){
        $('.im-selected').prop('checked', this.checked);
        e.stopPropagation();
    });
    $('.im-selected').click(function(e){
        e.stopPropagation();
    });

    $('#im-btn-actions').html('<button class="btn btn-warning text-white btn-sm">Mark as paid</button>');
    $('#im-filter').html('<div class="input-group input-group-sm">'
        + '<span class="input-group-text im-select-calendar" ><i class="bi bi-calendar4"></i> From</span>'
        +'<span class="input-group-text bg-white" ><span class="im-ds-input">DD/MM/YYYY</span><i class="bi bi-arrow-right ms-2 me-2"></i><span class="im-de-input">DD/MM/YYYY</span></span>'
        +'</div>');
    $('#im-status').html('<span class="badge bg-secondary">All</span>'
                        +'<span class="badge text-dark">ONGOING</span>'
                        +'<span class="badge text-dark">VERIFIED</span>'
                        +'<span class="badge text-dark">PENDING</span>');
});