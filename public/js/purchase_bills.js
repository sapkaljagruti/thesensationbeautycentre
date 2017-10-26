function allowOnlyNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
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

function enterKeyEvent(e) {
    if (e.keyCode == 13) {
        var party_id = $.trim($('#party_id').val());
        if (party_id == '') {
            $('#address').val('');
            $('#contact_person').val('');
            $('#email').val('');
            $('#mobile1').val('');
            $('#mobile2').val('');
            $('#residence_no').val('');
            $('#office_no').val('');
            $('#bank_name').val('');
            $('#bank_branch').val('');
            $('#ifsc_code').val('');
            $('#bank_account_no').val('');
            $('#pan').val('');
            $('#gst_type_id').val('');
            $('#gstin').val('');
        }
    }
}

$(document).on('focusout', '#party_name', function (e) {
    var party_id = $.trim($('#party_id').val());
    if (party_id == '') {
        $('#address').val('');
        $('#contact_person').val('');
        $('#email').val('');
        $('#mobile1').val('');
        $('#mobile2').val('');
        $('#residence_no').val('');
        $('#office_no').val('');
        $('#bank_name').val('');
        $('#bank_branch').val('');
        $('#ifsc_code').val('');
        $('#bank_account_no').val('');
        $('#pan').val('');
        $('#gst_type_id').val('');
        $('#gstin').val('');
    }
});

$(function () {
    $('#delete_selected').attr('disabled', true);
});

$(document).on('change', '.select-all', function (e) {
    var status = this.checked;
    $('input[name="select_customers[]"]').each(function () {
        this.checked = status;
    });
    $('#delete_selected').attr('disabled', !(status));
});

$(document).on('change', 'input[name="select_customers[]"]', function (e) {
    if (this.checked == false) {
        $(".select-all")[0].checked = false;
    }

    if ($('input[name="select_customers[]"]:checked').length > 0) {
        $('#delete_selected').prop('disabled', false);
    } else {
        $('#delete_selected').prop('disabled', true);
    }
});

$(document).on('click', '.view', function (e) {
    e.preventDefault();
    var data_id = $(this).attr('data-id');
    $('#loader').show();
    $.ajax({
        url: '?controller=customer&action=getCustomer',
        type: "POST",
        data: {'id': data_id},
        dataType: "json",
        success: function (response) {
            $.each(response, function (item, obj) {
                for (var key in obj) {
                    if (key != 'id' && key != 'created_at' && key != 'updated_at') {
                        $('#view_' + key).html(obj[key]);
                    }
                }
            });
            $("#view_modal").modal('show');
        },
        error: function (xhr, status, error) {
            showError('Something went wrong. Please try again later.', 5000);
        },
        complete: function () {
            $('#loader').hide();
        }
    });
});

$(document).on('hidden.bs.modal', '#confirm_delete_modal', function (e) {
    $('#delete_type').val('single');
    $('#data_to_delete').val('');
});

$(document).on('click', '#delete_selected', function () {
    $('#delete_type').val('multiple');
    $('#confirm_delete_modal').modal('show');
});

$(document).on('click', '.delete', function (e) {
    e.preventDefault();
    var data_id = $(this).attr('data-id');
    $('#data_to_delete').val(data_id);
    $('#delete_type').val('single');
    $('#confirm_delete_modal').modal('show');
});

$(document).on('click', '#delete', function () {
    var delete_type = $('#delete_type').val();
    if (delete_type == 'single') {
        var data_to_delete = $('#data_to_delete').val();
        $('#loader').show();
        $.ajax({
            url: '?controller=customer&action=deleteCutomer',
            type: "POST",
            data: {'id': data_to_delete},
            success: function (response) {
                if ($.trim(response) == 'deleted') {
                    var table = $('#customers_table').DataTable();
                    table.row($('#tr_' + data_to_delete)).remove().draw(false);
                    showSuccess('Customer was removed.', 10000);
                } else {
                    showError(response, 10000);
                }
                $("#confirm_delete_modal").modal('hide');
            },
            error: function (xhr, status, error) {
                $("#confirm_delete_modal").modal('hide');
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('#loader').hide();
            }
        });
    } else if (delete_type == 'multiple') {
        var data_to_delete = [];
        $('input[name="select_customers[]"]:checked').each(function () {
            data_to_delete.push($(this).attr('data-id'));
        });
        $('#loader').show();
        $.ajax({
            url: '?controller=customer&action=deleteCutomer',
            type: "POST",
            data: {'id': data_to_delete},
            dataType: "json",
            success: function (response) {
                var table = $('#customers_table').DataTable();
                for (var j in response) {
                    table.row($('#tr_' + response[j])).remove().draw(false);
                }
                if (data_to_delete.length == response.length) {
                    showSuccess('Selected customers were removed.', 10000);
                    $('#delete_selected').attr('disabled', true);
                }
                $(".select-all")[0].checked = false;
                $("#confirm_delete_modal").modal('hide');
            },
            error: function (xhr, status, error) {
                $("#confirm_delete_modal").modal('hide');
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('#loader').hide();
            }
        });
    }
});

$(document).on('keyup', '#party_name', function () {
    if ($(this).val() == '') {
        $('#party_id').val('');
    }
});

$('#party_name').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "?controller=party&action=getPartyNameByTerm",
            type: "POST",
            dataType: "json",
            data: {
                term: request.term
            },
            success: function (data) {
                if (data.length == 0) {
                    $('#party_id').val('');
                }
                response($.map(data, function (item) {
                    return {
                        label: item.name,
                        value: item.name,
                        id: item.id,
                        address: item.address,
                        contact_person: item.contact_person,
                        email: item.email,
                        mobile1: item.mobile1,
                        mobile2: item.mobile2,
                        residence_no: item.residence_no,
                        office_no: item.office_no,
                        bank_name: item.bank_name,
                        bank_branch: item.bank_branch,
                        ifsc_code: item.ifsc_code,
                        bank_account_no: item.bank_account_no,
                        pan: item.pan,
                        gst_type_id: item.gst_type_id,
                        gstin: item.gstin,
                    }
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        $('#party_id').val(ui.item.id);
        $('#address').val(ui.item.address);
        $('#contact_person').val(ui.item.contact_person);
        $('#email').val(ui.item.email);
        $('#mobile1').val(ui.item.mobile1);
        $('#mobile2').val(ui.item.mobile2);
        $('#residence_no').val(ui.item.residence_no);
        $('#office_no').val(ui.item.office_no);
        $('#bank_name').val(ui.item.bank_name);
        $('#bank_branch').val(ui.item.bank_branch);
        $('#ifsc_code').val(ui.item.ifsc_code);
        $('#bank_account_no').val(ui.item.bank_account_no);
        $('#pan').val(ui.item.pan);
        $('#gst_type_id').val(ui.item.gst_type_id);
        $('#gstin').val(ui.item.gstin);
    }
});
$("#party_name").autocomplete("option", "appendTo", ".eventInsForm");

$(function () {
    $("#date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
    $("#bill_date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});

    var t = $('#customers_table').DataTable({
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