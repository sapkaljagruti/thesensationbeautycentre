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

$(function () {
    $('#delete_selected').attr('disabled', true);
});

$(document).on('change', '.select-all', function (e) {
    var status = this.checked;
    $('input[name="select_managers[]"]').each(function () {
        this.checked = status;
    });
    $('#delete_selected').attr('disabled', !(status));
});

$(document).on('change', 'input[name="select_managers[]"]', function (e) {
    if (this.checked == false) {
        $(".select-all")[0].checked = false;
    }

    if ($('input[name="select_managers[]"]:checked').length > 0) {
        $('#delete_selected').prop('disabled', false);
    } else {
        $('#delete_selected').prop('disabled', true);
    }
});

$(document).on('hidden.bs.modal', '#add_edit_modal', function (e) {
    $.each($('input', '#add_edit_form'), function () {
        $(this).val('');
        $(this).next('span').html('');
        $(this).closest('div .form-group').removeClass('has-error');
    });
    $('#save_type').val('add');
});

$(document).on('click', '.view', function (e) {
    e.preventDefault();
    var data_id = $(this).attr('data-id');
    $('#loader').show();
    $.ajax({
        url: '?controller=manager&action=getManager',
        type: "POST",
        data: {'id': data_id},
        dataType: "json",
        success: function (response) {
            $.each(response, function (item, obj) {
                $('#view_name').html(ucwords(obj.name));
                $('#view_email').html(obj.email);
                $('#view_mobile1').html(obj.mobile1);
                $('#view_mobile2').html(obj.mobile2);
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

$(document).on('click', '.edit', function (e) {
    e.preventDefault();
    var data_id = $(this).attr('data-id');
    $('#loader').show();
    $.ajax({
        url: '?controller=manager&action=getManager',
        type: "POST",
        data: {'id': data_id},
        dataType: "json",
        success: function (response) {
            $.each(response, function (item, obj) {
                $('#id').val(data_id);
                $('#name').val(obj.name);
                $('#email').val(obj.email);
                $('#mobile1').val(obj.mobile1);
                $('#mobile2').val(obj.mobile2);
            });
            $('#save_type').val('edit');
            $("#add_edit_modal").modal('show');
        },
        error: function (xhr, status, error) {
            showError('Something went wrong. Please try again later.', 5000);
        },
        complete: function () {
            $('#loader').hide();
        }
    });
});

$(document).on('click', '#save', function () {
    var proceed = 1;

    var name = $('#name').val();
    var email = $('#email').val();
    var mobile1 = $('#mobile1').val();
    var mobile2 = $('#mobile2').val();

    if (name == '') {
        $('#name_help_block').html('Please enter manager name');
        $('#name_div').closest('div .form-group').addClass('has-error');
        proceed = 0;
    } else {
        $('#name_help_block').html('');
        $('#name_div').closest('div .form-group').removeClass('has-error');
    }

    var email_reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (email != '') {
        if (email_reg.test(email) == false) {
            $('#email_help_block').html('Please enter valid email address.');
            $('#email_div').closest('div .form-group').addClass('has-error');
            proceed = 0;
        } else {
            $('#email_help_block').html('');
            $('#email_div').closest('div .form-group').removeClass('has-error');
        }
    } else {
        $('#email_help_block').html('');
        $('#email_div').closest('div .form-group').removeClass('has-error');
    }

    if (mobile1 == '') {
        $('#mobile1_help_block').html('Please enter manager mobile number');
        $('#mobile1_div').closest('div .form-group').addClass('has-error');
        proceed = 0;
    } else {
        $('#mobile1_help_block').html('');
        $('#mobile1_div').closest('div .form-group').removeClass('has-error');
    }

    if (proceed != 0) {
        var save_type = $('#save_type').val();
        if (save_type == 'add') {
            $.ajax({
                url: '?controller=manager&action=addManager',
                type: "POST",
                data: {
                    'name': name,
                    'email': email,
                    'mobile1': mobile1,
                    'mobile2': mobile2,
                },
                success: function (response) {
                    response = $.trim(response);
                    $('#add_edit_modal').modal('hide');
                    if (response != 0) {
                        var table = $('#managers_table').DataTable();

                        var rowNode = table.row.add([response, '<input type="checkbox" name="select_managers[]" data-id="' + response + '">', ucwords(name), email, mobile1, mobile2, '<a href="" class="view btn btn-default" data-id="' + response + '"><i class="fa fa-fw fa-eye"></i> View</a>' + ' <a href="" class="edit btn btn-default" data-id="' + response + '"> <i class="fa fa-fw fa-pencil-square-o"></i> Edit</a> <a href="" class="delete btn btn-default" data-id="' + response + '"> <i class="fa fa-fw fa-trash"></i> Delete</a>']).draw().node(1);

                        $(rowNode).attr('id', 'tr_' + response);
                        showSuccess('New manager was added successfully.', 5000);
                    } else {
                        showError('Something went wrong. Please try again later.', 5000);
                    }
                },
                error: function (xhr, status, error) {
                    $('#add_edit_modal').modal('hide');
                    showError('Something went wrong. Please try again later.', 5000);
                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        } else if (save_type == 'edit') {
            var id = $('#id').val();
            $.ajax({
                url: '?controller=manager&action=updateManager',
                type: "POST",
                data: {
                    'id': id,
                    'name': name,
                    'email': email,
                    'mobile1': mobile1,
                    'mobile2': mobile2,
                },
                success: function (response) {
                    response = $.trim(response);
                    $('#add_edit_modal').modal('hide');
                    if (response != 0) {
                        var table = $('#managers_table').DataTable();
                        table.cell('#tr_' + response, ':eq(2)').data(ucwords(name)).draw();
                        table.cell('#tr_' + response, ':eq(3)').data(email).draw();
                        table.cell('#tr_' + response, ':eq(4)').data(mobile1).draw();
                        table.cell('#tr_' + response, ':eq(5)').data(mobile2).draw();

                        showSuccess('Manager detail was updated successfully.', 5000);
                    } else {
                        showError('Something went wrong. Please try again later.', 5000);
                    }
                },
                error: function (xhr, status, error) {
                    $('#add_edit_modal').modal('hide');
                    showError('Something went wrong. Please try again later.', 5000);
                },
                complete: function () {
                    $('#loader').hide();
                }
            });
        }
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
            url: '?controller=manager&action=deleteManager',
            type: "POST",
            data: {'id': data_to_delete},
            success: function (response) {
                if ($.trim(response) == 'deleted') {
                    var table = $('#managers_table').DataTable();
                    table.row($('#tr_' + data_to_delete)).remove().draw(false);
                    showSuccess('Manager was removed.', 10000);
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
        $('input[name="select_managers[]"]:checked').each(function () {
            data_to_delete.push($(this).attr('data-id'));
        });
        $('#loader').show();
        $.ajax({
            url: '?controller=manager&action=deleteManager',
            type: "POST",
            data: {'id': data_to_delete},
            dataType: "json",
            success: function (response) {
                var table = $('#managers_table').DataTable();
                for (var j in response) {
                    table.row($('#tr_' + response[j])).remove().draw(false);
                }
                if (data_to_delete.length == response.length) {
                    showSuccess('Selected managers were removed.', 10000);
                    $('#delete_selected').attr('disabled', true);
                } else {
                    showError('You cannot delete some managers.', 10000);
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
    var t = $('#managers_table').DataTable({
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