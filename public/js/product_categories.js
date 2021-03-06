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
    $('input[name="select_product_categories[]"]').each(function () {
        this.checked = status;
    });
    $('#delete_selected').attr('disabled', !(status));
});

$(document).on('change', 'input[name="select_product_categories[]"]', function (e) {
    if (this.checked == false) {
        $(".select-all")[0].checked = false;
    }

    if ($('input[name="select_product_categories[]"]:checked').length > 0) {
        $('#delete_selected').prop('disabled', false);
    } else {
        $('#delete_selected').prop('disabled', true);
    }
});

$(document).on('hidden.bs.modal', '#add_edit_modal', function (e) {
    $('#name').val('');
    $('#name').next('span').html('');
    $('#name').closest('div .form-group').removeClass('has-error');

    var last_removed_parent_id = $('#last_removed_parent_id').val();
    var last_removed_parent_name = $('#last_removed_parent_name').val();

    if (last_removed_parent_id != '') {
        $('#parent_id').append("<option value='" + last_removed_parent_id + "'>" + last_removed_parent_name + "</option>");
    }

    $('#parent_id').val('0');

    $('#last_removed_parent_id').val('');
    $('#last_removed_parent_name').val('');

    $('#save_type').val('add');
});

$(document).on('click', '.view', function (e) {
    e.preventDefault();
    var data_id = $(this).attr('data-id');
    $('#loader').show();
    $.ajax({
        url: '?controller=productcategory&action=getcategory',
        type: "POST",
        data: {'id': data_id},
        dataType: "json",
        success: function (response) {
            $.each(response, function (item, obj) {
                $('#view_name').html(ucwords(obj.name));
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
        url: '?controller=productcategory&action=getcategory',
        type: "POST",
        data: {'id': data_id},
        dataType: "json",
        success: function (response) {
            $.each(response, function (item, obj) {
                $('#last_removed_parent_id').val(data_id);
                $('#last_removed_parent_name').val($('#parent_id option[value="' + data_id + '"]').text());

                $('#parent_id option[value="' + data_id + '"]').remove();

                $('#id').val(data_id);
                $('#name').val(obj.name);
                $('#parent_id').val(obj.parent_id);
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

    var name = $.trim($('#name').val());

    if (name == '') {
        $('#name_help_block').html('Please enter category name');
        $('#name_div').closest('div .form-group').addClass('has-error');
        proceed = 0;
    } else {
        $('#name_help_block').html('');
        $('#name_div').closest('div .form-group').removeClass('has-error');
    }

    if (proceed != 0) {
        var parent_id = $('#parent_id').val();
        var save_type = $('#save_type').val();

        var id = '';
        if (save_type == 'add') {
            id = '';
        } else if (save_type == 'edit') {
            id = $.trim($('#id').val());
        }

        $.ajax({
            url: '?controller=productcategory&action=checkNameExist',
            data: {
                'name': name,
                'id': id
            },
            type: 'post',
            success: function (response) {
                response = $.trim(response);
                if (response == '1') {
                    $('#name_help_block').html('This name already exists');
                    $('#name_div').closest('div .form-group').addClass('has-error');
                } else {
                    $('#name_help_block').html('');
                    $('#name_div').closest('div .form-group').removeClass('has-error');
                    if (save_type == 'add') {
                        $.ajax({
                            url: '?controller=productcategory&action=addcategory',
                            type: "POST",
                            data: {
                                'name': name,
                                'parent_id': parent_id
                            },
                            success: function (response) {
                                response = $.trim(response);
                                $('#add_edit_modal').modal('hide');
                                if (response != 0) {
                                    var table = $('#product_categories_table').DataTable();

                                    var rowNode = table.row.add([response, '<input type="checkbox" name="select_product_categories[]" data-id="' + response + '">', ucwords(name), '<a href="" class="view btn btn-default" data-id="' + response + '"><i class="fa fa-fw fa-eye"></i> View</a>' + ' <a href="" class="edit btn btn-default" data-id="' + response + '"> <i class="fa fa-fw fa-pencil-square-o"></i> Edit</a> <a href="" class="delete btn btn-default" data-id="' + response + '"> <i class="fa fa-fw fa-trash"></i> Delete</a>']).draw().node();

                                    $(rowNode).attr('id', 'tr_' + response);
                                    $('#parent_id').append("<option value='" + response + "'>" + ucwords(name) + "</option>");
                                    showSuccess('New category was added successfully.', 5000);
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
                        $.ajax({
                            url: '?controller=productcategory&action=updatecategory',
                            type: "POST",
                            data: {
                                'id': id,
                                'name': name,
                                'parent_id': parent_id
                            },
                            success: function (response) {
                                response = $.trim(response);
                                $('#add_edit_modal').modal('hide');
                                if (response != 0) {
                                    var table = $('#product_categories_table').DataTable();
                                    table.cell('#tr_' + response, ':eq(2)').data(ucwords(name)).draw();
                                    $('#last_removed_parent_name').val(ucwords(name));
                                    showSuccess('Category detail was updated successfully.', 5000);
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
            },
            error: function (xhr, status, error) {
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
            }
        });
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
            url: '?controller=productcategory&action=deletecategory',
            type: "POST",
            data: {'id': data_to_delete},
            success: function (response) {
                if ($.trim(response) == 'deleted') {
                    $('#parent_id option[value="' + data_to_delete + '"]').remove();
                    var table = $('#product_categories_table').DataTable();
                    table.row($('#tr_' + data_to_delete)).remove().draw(false);
                    showSuccess('Category was removed.', 10000);
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
        $('input[name="select_product_categories[]"]:checked').each(function () {
            data_to_delete.push($(this).attr('data-id'));
        });
        $('#loader').show();
        $.ajax({
            url: '?controller=productcategory&action=deletecategory',
            type: "POST",
            data: {'id': data_to_delete},
            dataType: "json",
            success: function (response) {
                var table = $('#product_categories_table').DataTable();
                for (var j in response) {
                    $('#parent_id option[value="' + response[j] + '"]').remove();
                    table.row($('#tr_' + response[j])).remove().draw(false);
                }
                if (data_to_delete.length == response.length) {
                    showSuccess('Selected categories were removed.', 10000);
                    $('#delete_selected').attr('disabled', true);
                } else {
                    showError('You cannot delete some categories.', 10000);
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
    var t = $('#product_categories_table').DataTable({
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