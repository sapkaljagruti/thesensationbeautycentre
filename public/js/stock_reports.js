function allowOnlyNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function allowOnlyNumberWithDecimal(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31
            && (charCode < 48 || charCode > 57))
        return false;

    return true;
}

function showSuccess(msg, timeout) {
    $('.alert').removeClass('alert-danger');
    $('.alert').addClass('alert-success');
    $('.alert').find('h4').html('<i class="icon fa fa-check"></i> Success!');
    $('.alert').find('p').html(msg);
    $('.alert').fadeIn();
    $('.alert').fadeOut(timeout);
}

function showError(msg, timeout) {
    $('.alert').removeClass('alert-success');
    $('.alert').addClass('alert-danger');
    $('.alert').find('h4').html('<i class="icon fa fa-ban"></i> Alert!');
    $('.alert').find('p').html(msg);
    $('.alert').fadeIn();
    $('.alert').fadeOut(timeout);
}

function ucwords(str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

$(document).on('keypress', '.decimal', function (evt) {
    var ele_val = $(this).val();
    var decimal_index = ele_val.indexOf('.');
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (decimal_index != '-1' && charCode == 46) {
        return false;
    }
});

$(document).on('click', '#filter', function () {
    var product_category_id = $('#product_category_id').val();
    var top = $('input[name="top"]:checked').val();
    var data = {};
    if (product_category_id != '') {
        data.product_category_id = product_category_id;
    }
    if (top != 'none') {
        data.top = top;
    }
    if ($.isEmptyObject(data)) {
        data.show_all = 'show_all';
    }

    filter(data);
});

$(document).on('click', '#reset_filter', function () {
    $.each($('input, select', '#filter_form'), function () {
        if ($(this).attr('name') != 'top') {
            $(this).val('');
        }
    });
    $('#none').prop('checked', 'checked');

    var data = {'show_all': 'show_all'};
    filter(data);
});

function filter(data) {
    $('#loader').show();

    $.ajax({
        url: '?controller=reports&action=getStockReports',
        type: "POST",
        dataType: "json",
        data: data,
        success: function (response) {
            $('#products_table').dataTable().fnClearTable();
            if (!(response.no_data)) {
                $.each(response, function (k, v) {
                    var table = $('#products_table').DataTable();
                    var rowNode = table.row.add([v.id, ucwords(v.name), v.qty1, v.qty2]).draw().node();
                    $(rowNode).attr('id', 'tr_' + v.id);
                });
            }
        },
        error: function (xhr, status, error) {
            showError('Something went wrong. Please try again later.', 5000);
        },
        complete: function () {
            $('#loader').hide();
        }
    });
}

$(function () {
    var t = $('#products_table').DataTable({
        "paging": true,
        "lengthChange": true,
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        "searching": true,
        "ordering": true,
        "order": [[0, "desc"]],
        "info": true,
        "autoWidth": false,
        "aaSorting": [],
        "columnDefs": [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            }
        ]
    });
});