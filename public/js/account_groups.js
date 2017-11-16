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

$(function () {
    $('#delete_selected').attr('disabled', true);
});

$(document).on('change', '.select-all', function (e) {
    var status = this.checked;
    $('input[name="select_ac_groups[]"]').each(function () {
        this.checked = status;
    });
    $('#delete_selected').attr('disabled', !(status));
});

$(document).on('change', 'input[name="select_ac_groups[]"]', function (e) {
    if (this.checked == false) {
        $(".select-all")[0].checked = false;
    }

    if ($('input[name="select_ac_groups[]"]:checked').length > 0) {
        $('#delete_selected').prop('disabled', false);
    } else {
        $('#delete_selected').prop('disabled', true);
    }
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
            url: '?controller=accountgroup&action=deleteacgroup',
            type: "POST",
            data: {'id': data_to_delete},
            success: function (response) {
                if ($.trim(response) == 'deleted') {
                    $('#parent_id option[value="' + data_to_delete + '"]').remove();
                    var table = $('#ac_groups_table').DataTable();
                    table.row($('#tr_' + data_to_delete)).remove().draw(false);
                    showSuccess('Group was removed.', 10000);
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
        $('input[name="select_ac_groups[]"]:checked').each(function () {
            data_to_delete.push($(this).attr('data-id'));
        });
        $('#loader').show();
        $.ajax({
            url: '?controller=accountgroup&action=deleteacgroup',
            type: "POST",
            data: {'id': data_to_delete},
            dataType: "json",
            success: function (response) {
                var table = $('#ac_groups_table').DataTable();
                for (var j in response) {
                    $('#parent_id option[value="' + response[j] + '"]').remove();
                    table.row($('#tr_' + response[j])).remove().draw(false);
                }
                if (data_to_delete.length == response.length) {
                    showSuccess('Selected groups were removed.', 10000);
                    $('#delete_selected').attr('disabled', true);
                } else {
                    showError('You cannot delete some groups.', 10000);
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

$(document).on('focusout', '#name', function () {
    var name = $('#name').val();
    var save_type = $.trim($('#save_type').val());

    var id = '';
    if (save_type == 'add') {
        id = '';
    } else if (save_type == 'edit') {
        id = $.trim($('#id').val());
    }

    if ($.trim(name) == '') {
        $('#is_valid_name').val('0');
        $('#name').css('border-color', '#dd4b39');
        $('#name_label').css('color', '#dd4b39');
        $('#name_help_block').html('<font color="#dd4b39">Please enter group name</font>');
    } else {
        $('.overlay').show();
        $.ajax({
            url: '?controller=accountgroup&action=checkNameExist',
            data: {
                'name': name,
                'id': id
            },
            type: 'post',
            success: function (response) {
                response = $.trim(response);
                if (response == '1') {
                    $('#is_valid_name').val('0');
                    $('#name').css('border-color', '#dd4b39');
                    $('#name_label').css('color', '#dd4b39');
                    $('#name_help_block').html('<font color="#dd4b39">This name already exists.</font>');
                } else {
                    $('#is_valid_name').val('1');
                    $('#name').css('border-color', 'rgb(210, 214, 222)');
                    $('#name_label').css('color', 'black');
                    $('#name_help_block').html('');
                }
            },
            error: function (xhr, status, error) {
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('.overlay').hide();
            }
        });
    }
});

$(document).on('change', '#parent_id', function () {
    var parent_id = $('option:selected', this).attr('data-parent-id');
    if (parent_id != '0') {
        $('.overlay').show();
        $.ajax({
            url: '?controller=accountgroup&action=getParentName',
            type: "POST",
            data: {'parent_id': parent_id},
            success: function (response) {
                response = $.trim(response);
                if (response == '0') {
                    $('#group_parent').html('');
                } else {
                    $('#group_parent').html('<font color="blue"><i>' + response + '</i></font>');
                }
            },
            error: function (xhr, status, error) {
                $('#group_parent').html('');
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('.overlay').hide();
            }
        });
    } else {
        $('#group_parent').html('');
    }
});

$(function () {
    var parent_id = $('option:selected', '#parent_id').attr('data-parent-id');
    if (parent_id != '0') {
        $('.overlay').show();
        $.ajax({
            url: '?controller=accountgroup&action=getParentName',
            type: "POST",
            data: {'parent_id': parent_id},
            success: function (response) {
                response = $.trim(response);
                if (response == '0') {
                    $('#group_parent').html('');
                } else {
                    $('#group_parent').html('<font color="blue"><i>' + response + '</i></font>');
                }
            },
            error: function (xhr, status, error) {
                $('#group_parent').html('');
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('.overlay').hide();
            }
        });
    } else {
        $('#group_parent').html('');
    }
});

$(document).on('submit', 'form', function () {
    var proceed = 1;

    var is_valid_name = $('#is_valid_name').val();

    if (is_valid_name == '0') {
        proceed = 0;
    }


    var panVal = $('#pan').val();
    if ($.trim(panVal) != '') {
        var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
        if (!(regpan.test(panVal))) {
            $('#pan_label').css('color', '#dd4b39');
            $('#pan').css('border-color', '#dd4b39');
            $('#pan_help_block').html('<font color="#dd4b39">Please enter valid PAN</font>');
            proceed = 0;
        } else {
            $('#pan_label').css('color', 'black');
            $('#pan').css('border-color', 'rgb(210, 214, 222)');
            $('#pan_help_block').html('');
        }
    } else {
        $('#pan_label').css('color', 'black');
        $('#pan').css('border-color', 'rgb(210, 214, 222)');
        $('#pan_help_block').html('');
    }

    var gstin = $('#gstin').val();
    if ($.trim(gstin) != '') {

        var gst_state_code_id = $('#gst_state_code_id').val();
        var proceed_state = 1;
        var gstin_sate = gstin.substring(0, 2);
        if (gst_state_code_id != gstin_sate) {
            proceed_state = 0;
        }

        var proceed_pan = 1;
        var gstin_pan = gstin.substring(2, 12).toUpperCase();
        if (panVal.toUpperCase() != gstin_pan) {
            proceed_pan = 0;
        }

        var proceed_entity_number = 1;
        var regent = /^[1-9]\d*$/;
        var num_of_entity = gstin.substring(12, 13);
        if (!(regent.test(num_of_entity))) {
            proceed_entity_number = 0;
        }

        var proceed_z = 1;
        var default_z = gstin.substring(13, 14).toUpperCase();
        if (default_z != 'Z') {
            proceed_z = 0;
        }

        var proceed_check_sum = 1;
        var regchecksum = /^[0-9a-zA-Z]+$/;
        var check_sum = gstin.substring(14, 15);
        if (!(regchecksum.test(check_sum))) {
            proceed_check_sum = 0;
        }

        if ($.trim(panVal) == '' || gst_state_code_id == '0' || proceed_state == 0 || proceed_pan == 0 || proceed_entity_number == 0 || proceed_z == 0 || proceed_check_sum == 0) {
            $('#gstin_label').css('color', '#dd4b39');
            $('#gstin').css('border-color', '#dd4b39');
            $('#gstin_help_block').html('<font color="#dd4b39">Invalid GSTIN</font>');
            proceed = 0;
        } else {
            $('#gstin_label').css('color', 'black');
            $('#gstin').css('border-color', 'rgb(210, 214, 222)');
            $('#gstin_help_block').html('');
        }
    }

    if (proceed != 0) {
        return true;
    } else {
        return false;
    }
});

$(function () {
    //    Initialize Select2 Elements
    $(".select2").select2();

    var t = $('#ac_groups_table').DataTable({
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