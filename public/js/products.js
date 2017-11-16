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
    var taxability = $('#taxability').val();
    if (taxability != 'taxable') {
        $('#integrated_tax').attr('disabled', 'disabled');
        $('#cgst').attr('disabled', 'disabled');
        $('#sgst').attr('disabled', 'disabled');
    } else {
        $('#integrated_tax').removeAttr('disabled');
        $('#cgst').removeAttr('disabled');
        $('#sgst').removeAttr('disabled');
    }
});

$(document).on('change', '#taxability', function (e) {
    var taxability = $(this).val();
    if (taxability != 'taxable') {
        $('#integrated_tax').val('0.00');
        $('#integrated_tax').attr('disabled', 'disabled');

        $('#cgst').val('0.00');
        $('#cgst').attr('disabled', 'disabled');

        $('#sgst').val('0.00');
        $('#sgst').attr('disabled', 'disabled');
    } else {
        $('#integrated_tax').val('');
        $('#integrated_tax').removeAttr('disabled');
        $('#cgst').val('');
        $('#cgst').removeAttr('disabled');
        $('#sgst').val('');
        $('#sgst').removeAttr('disabled');
    }
});

//$(document).on('change', '#calculation_type', function (e) {
//    var calculation_type = $(this).val();
//    if (calculation_type == 'on_item_rate') {
//        $('#item_rates_div').fadeIn();
//        $('.upto:last').focus();
//    } else if (calculation_type == 'on_value') {
//        $('#item_rates_div').fadeOut();
//    }
//});
//
//$(document).on('change', '.tax_type', function (e) {
//    var tax_type = $(this).val();
//    if (tax_type != 'taxable') {
//        $(this).parent().siblings().find('.integrated_tax').val('0');
//        $(this).parent().siblings().find('.integrated_tax').attr('disabled', 'disabled');
//
//        $(this).parent().siblings().find('.cess').val('0');
//        $(this).parent().siblings().find('.cess').attr('disabled', 'disabled');
//    } else {
//        $(this).parent().siblings().find('.integrated_tax').removeAttr('disabled');
//        $(this).parent().siblings().find('.integrated_tax').focus();
//        $(this).parent().siblings().find('.cess').removeAttr('disabled');
//    }
//});
//
//$(document).on('focusout', '.greater_than', function () {
//    var cur_elem = $(this);
//    var cur_elem_val = cur_elem.val();
//
//    if ($.trim(cur_elem_val) == '') {
//        $(this).focus();
//    } else if ($.trim(cur_elem_val) != '') {
//        var elem_class = $('.greater_than');
//        var prev_elem = elem_class.eq(elem_class.index(cur_elem) - 1);
//        var prev_upto_val = prev_elem.parent().siblings().find('.upto').val();
//        if (parseInt(cur_elem_val) < parseInt(prev_upto_val)) {
//            cur_elem.val('');
//            cur_elem.focus();
//        }
//
//        var next_upto_val = $(this).parent().siblings().find('.upto').val();
//        if ($.trim(next_upto_val) != '') {
//            if (parseInt(next_upto_val) < parseInt(cur_elem_val)) {
//                cur_elem.val('');
//                cur_elem.focus();
//            }
//        }
//    }
//});
//
//$(document).on('focusout', '.upto', function () {
//    var upto_val = $(this).val();
//    if ($.trim(upto_val) == '') {
//        $(this).focus();
//
//        $(this).parent().siblings().find('.integrated_tax').val('');
//        $(this).parent().siblings().find('.cess').val('');
//    } else if ($.trim(upto_val) != '') {
//        var greater_than_val = $(this).parent().siblings().find('.greater_than').val();
//        if (parseInt(upto_val) < parseInt(greater_than_val)) {
//            $(this).val('');
//            $(this).focus();
//        } else {
//            $(this).parent().siblings().find('.integrated_tax').focus();
//        }
//    }
//});
//
//
//$(document).on('focusout', '.integrated_tax', function () {
//    var integrated_tax = $(this).val();
//    if ($.trim(integrated_tax) == '') {
//        $(this).focus();
//    }
//});
//
//$(document).on('focusout', '.cess', function () {
//    var cess = $(this).val();
//    if ($.trim(cess) == '') {
//        $(this).focus();
//    } else if ($.trim(cess) != '') {
//        var new_tr = '<tr><td><input type="text" class="form-control greater_than" id="" name="greater_than[]" value="" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off"/></td><td><input type="text" class="form-control upto" id="" name="upto[]" value=" " onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off"/></td><td><select class="form-control tax_type" id="" name="tax_type[]"><option value="exempt">Exempt</option><option value="nil_rated">Nil Rated</option><option value="taxable" selected="selected">Taxable</option></select></td><td><div class="input-group"><input type="text" class="form-control integrated_tax" id="" name="integrated_tax_on_item_rate[]" value="" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off"/><span class="input-group-addon">%</span></div></td><td><input type="text" class="form-control" id="" name="" value="Based On Value" readonly="readonly"/></td><td><div class="input-group"><input type="text" class="form-control cess" id="" name="cess_on_item_rate[]" value="" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off"/><span class="input-group-addon">%</span></div></td></tr>';
//        $('#item_rates_table tr:last').after(new_tr);
//        $('.greater_than:last').focus();
//    }
//});
//
//
//$(document).on('focus', '.integrated_tax', function () {
//    var tax_type = $(this).closest('td').siblings().find('.tax_type').val();
//    if (tax_type != 'taxable') {
//        $(this).val('0');
//        $(this).attr('disabled', 'disabled');
//
//        $(this).parent().parent().siblings().find('.cess').val('0');
//        $(this).parent().parent().siblings().find('.cess').attr('disabled', 'disabled');
//    }
//});
//
//$(document).on('focus', '.cess', function () {
//    var tax_type = $(this).closest('td').siblings().find('.tax_type').val();
//    if (tax_type != 'taxable') {
//        $(this).val('0');
//        $(this).attr('disabled', 'disabled');
//
//        $(this).parent().parent().siblings().find('.integrated_tax').val('0');
//        $(this).parent().parent().siblings().find('.integrated_tax').attr('disabled', 'disabled');
//    }
//});

$(function () {
    $('#delete_selected').attr('disabled', true);
});

$(document).on('change', '.select-all', function (e) {
    var status = this.checked;
    $('input[name="select_products[]"]').each(function () {
        this.checked = status;
    });
    $('#delete_selected').attr('disabled', !(status));
});

$(document).on('change', 'input[name="select_products[]"]', function (e) {
    if (this.checked == false) {
        $(".select-all")[0].checked = false;
    }

    if ($('input[name="select_products[]"]:checked').length > 0) {
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
        url: '?controller=product&action=getproduct',
        type: "POST",
        data: {'id': data_id},
        dataType: "json",
        success: function (response) {
            $.each(response, function (item, obj) {
                for (var key in obj) {
                    if (key != 'id' && key != 'product_category_id' && key != 'brand_id' && key != 'created_at' && key != 'updated_at') {
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
            url: '?controller=product&action=deleteproduct',
            type: "POST",
            data: {'id': data_to_delete},
            success: function (response) {
                if ($.trim(response) == 'deleted') {
                    var table = $('#products_table').DataTable();
                    table.row($('#tr_' + data_to_delete)).remove().draw(false);
                    showSuccess('Product was removed.', 10000);
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
        $('input[name="select_products[]"]:checked').each(function () {
            data_to_delete.push($(this).attr('data-id'));
        });
        $('#loader').show();
        $.ajax({
            url: '?controller=product&action=deleteproduct',
            type: "POST",
            data: {'id': data_to_delete},
            dataType: "json",
            success: function (response) {
                var table = $('#products_table').DataTable();
                for (var j in response) {
                    table.row($('#tr_' + response[j])).remove().draw(false);
                }
                if (data_to_delete.length == response.length) {
                    showSuccess('Selected products were removed.', 10000);
                    $('#delete_selected').attr('disabled', true);
                } else {
//                    showError('You cannot delete some groups.', 10000);
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
    var name = $.trim($('#name').val());

    var save_type = $.trim($('#save_type').val());

    var id = '';
    if (save_type == 'add') {
        id = '';
    } else if (save_type == 'edit') {
        id = $.trim($('#id').val());
    }

    if ($.trim(name) == '') {
        $('#valid_name').val('0');
        $('#name').css('border-color', '#dd4b39');
        $('#name_label').css('color', '#dd4b39');
        $('#name_help_block').html('<font color="#dd4b39">Please enter Product Name</font>');
    } else {
        $('.overlay').show();
        $.ajax({
            url: '?controller=product&action=checkProductNameExist',
            data: {
                'product_name': name,
                'id': id
            },
            type: 'post',
            success: function (response) {
                response = $.trim(response);
                if (response == '1') {
                    $('#valid_name').val('0');
                    $('#name').css('border-color', '#dd4b39');
                    $('#name_label').css('color', '#dd4b39');
                    $('#name_help_block').html('<font color="#dd4b39">This name already exists.</font>');
                } else {
                    $('#valid_name').val('1');
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

$(document).on('submit', '#product_form', function () {
    var proceed = 1;
    var valid_name = $('#valid_name').val();

    if (valid_name == '0') {
        proceed = 0;
    }

    if (proceed != 0) {
        return true;
    } else {
        return false;
    }
});

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