function allowOnlyNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function isValidDate(str) {
    var m = str.match(/^(\d{1,2})-(\d{1,2})-(\d{4})$/);
    return (m) ? new Date(m[3], m[2] - 1, m[1]) : null;
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

$(document).on('submit', 'form', function () {
    var proceed = 1;

    var dob = $('#dob').val();
    if ($.trim(dob) != '') {
        var is_valid_dob = isValidDate(dob);
        if (!(is_valid_dob)) {
            proceed = 0;
            $('#dob').css('border-color', '#dd4b39');
            $('#dob_addon').css('border-color', '#dd4b39');
            $('#dob_cal').css('color', '#dd4b39');
            $('#dob_label').css('color', '#dd4b39');
            $('#dob_help_block').html('<font color="#dd4b39">Please enter valid date of birth.</font>');
        } else {
            $('#dob').css('border-color', 'rgb(210, 214, 222)');
            $('#dob_addon').css('border-color', 'rgb(210, 214, 222)');
            $('#dob_cal').css('color', 'black');
            $('#dob_label').css('color', 'black');
            $('#dob_help_block').html('');
        }
    } else {
        $('#dob').css('border-color', 'rgb(210, 214, 222)');
        $('#dob_addon').css('border-color', 'rgb(210, 214, 222)');
        $('#dob_cal').css('color', 'black');
        $('#dob_label').css('color', 'black');
        $('#dob_help_block').html('');
    }

    var doa = $('#doa').val();
    if ($.trim(doa) != '') {
        var is_valid_doa = isValidDate(doa);
        if (!(is_valid_doa)) {
            proceed = 0;
            $('#doa').css('border-color', '#dd4b39');
            $('#doa_addon').css('border-color', '#dd4b39');
            $('#doa_cal').css('color', '#dd4b39');
            $('#doa_label').css('color', '#dd4b39');
            $('#doa_help_block').html('<font color="#dd4b39">Please enter valid date of anniversary.</font>');
        } else {
            $('#doa').css('border-color', 'rgb(210, 214, 222)');
            $('#doa_addon').css('border-color', 'rgb(210, 214, 222)');
            $('#doa_cal').css('color', 'black');
            $('#doa_label').css('color', 'black');
            $('#doa_help_block').html('');
        }
    } else {
        $('#doa').css('border-color', 'rgb(210, 214, 222)');
        $('#doa_addon').css('border-color', 'rgb(210, 214, 222)');
        $('#doa_cal').css('color', 'black');
        $('#doa_label').css('color', 'black');
        $('#doa_help_block').html('');
    }

    if (proceed != 0) {
        return true;
    } else {
        return false;
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

$(function () {
    $("#membership_from").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
    $("#membership_to").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
    $("#dob").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
    $("#doa").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});

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