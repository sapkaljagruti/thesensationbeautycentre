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

$(document).on('keypress', '.decimal', function (evt) {
    var ele_val = $(this).val();
    var decimal_index = ele_val.indexOf('.');
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (decimal_index != '-1' && charCode == 46) {
        return false;
    }
});

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

function isValidDate(str) {
    var m = str.match(/^(\d{1,2})-(\d{1,2})-(\d{4})$/);
    return (m) ? new Date(m[3], m[2] - 1, m[1]) : null;
}

$(document).on('change', '.select-all', function (e) {
    var status = this.checked;
    $('input[name="select_purchase_vouchers[]"]').each(function () {
        this.checked = status;
    });
    $('#delete_selected').attr('disabled', !(status));
});

$(document).on('change', 'input[name="select_purchase_vouchers[]"]', function (e) {
    if (this.checked == false) {
        $(".select-all")[0].checked = false;
    }

    if ($('input[name="select_purchase_vouchers[]"]:checked').length > 0) {
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
            url: '?controller=purchase&action=delete',
            type: "POST",
            data: {'id': data_to_delete},
            success: function (response) {
                if ($.trim(response) == 'deleted') {
                    $('#span_' + data_to_delete).html('<font color="red"><i class="fa fa-exclamation-triangle"></i> Cancelled</font>');
                    showSuccess('Voucher is cancelled.', 10000);
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
        $('input[name="select_purchase_vouchers[]"]:checked').each(function () {
            data_to_delete.push($(this).attr('data-id'));
        });
        $('#loader').show();
        $.ajax({
            url: '?controller=purchase&action=delete',
            type: "POST",
            data: {'id': data_to_delete},
            dataType: "json",
            success: function (response) {
                for (var j in response) {
                    $('#span_' + response[j]).html('<font color="red"><i class="fa fa-exclamation-triangle"></i> Cancelled</font>');
                }
                if (data_to_delete.length == response.length) {
                    showSuccess('Selected vouchers were cancelled.', 10000);
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

$(document).on('change', '#purchase_type_id', function () {
    var purchase_type = $(this).val();

    if (purchase_type == '1') { //Interstate Purchase
        $('#cgst').attr('disabled', 'disabled');
        $('#sgst').attr('disabled', 'disabled');
        $('#igst').removeAttr('disabled');

        $('#cgst').val('');
        $('#sgst').val('');
        $('#igst').val('');
    } else if (purchase_type == '2') { //Local Purchase        
        $('#igst').attr('disabled', 'disabled');
        $('#cgst').removeAttr('disabled');
        $('#sgst').removeAttr('disabled');

        $('#cgst').val('');
        $('#sgst').val('');
        $('#igst').val('');
    }

    if ($("tr[id^='tr_']").length) {
        var table = $('#products_table').DataTable();
        table.row($("tr[id^='tr_']")).remove().draw(false);
    }
});

$('#product_name').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '?controller=product&action=findProductByTerm',
            type: "POST",
            dataType: "json",
            data: {
                term: request.term
            },
            success: function (data) {
                if (data.length == 0) {
                    $('#product_id').val('');
                }
                response($.map(data, function (item) {
                    return {
                        label: item.name,
                        value: item.name,
                        id: item.id,
                        qty1: item.qty1,
                        qty2: item.qty2,
                        hsn_code: item.hsn_code,
                    }
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        $('#product_id').val(ui.item.id);
        $('#qty1').val(ui.item.qty1);
        $('#qty2').val(ui.item.qty2);
        $('#hsn_code').val(ui.item.hsn_code);
    }
});
$("#product_name").autocomplete("option", "appendTo", ".eventInsForm");

$(document).on('keyup', '#product_name', function () {
    if ($(this).val() == '') {
        $('#product_id').val('');
    } else {
        var product_name = $.trim($(this).val());
        $('#overlay_product').show();
        $.ajax({
            url: '?controller=product&action=checkProductNameExist',
            data: {
                'product_name': product_name,
            },
            type: 'post',
            success: function (response) {
                if (response == '1') {

                } else {
                    $(this).val('');
                    $('#product_id').val('');
                }
            },
            error: function (xhr, status, error) {
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('#overlay_product').hide();
            }
        });
    }
});

function productEnterKeyEvent(e) {
    if (e.keyCode == 13) {
        var product_id = $.trim($('#product_id').val());
        if (product_id == '') {
            $('#product_name').val('');
            $('#product_qty').val('');
            $('#price').val('');
            $('#discount_rate').val('');
            $('#discount_price').val('');
            $('#cgst').val('');
            $('#sgst').val('');
            $('#igst').val('');
        }
    }
}

$(document).on('focusout', '#product_name', function (e) {
    var product_id = $.trim($('#product_id').val());
    if (product_id == '') {
        $('#product_name').val('');
        $('#product_qty').val('');
        $('#price').val('');
        $('#discount_rate').val('');
        $('#discount_price').val('');
        $('#cgst').val('');
        $('#sgst').val('');
        $('#igst').val('');
    }
});

$(document).on('focus', '#discount_rate', function () {
    $('#discount_percentage').prop('checked', true);
    $('#discount_price').val('');
});

$(document).on('focus', '#discount_price', function () {
    $('#discount_rs').prop('checked', true);
    $('#discount_rate').val('');
});

$(document).on('click', '#proceed_product', function () {
    var proceed = 1;

    var product_name = $('#product_name').val();
    var product_id = $('#product_id').val();
    var mrp = $('#mrp').val();
    var quantity = $('#product_qty').val();
    var price = $('#price').val();

    if (product_name == '') {
        $('#product_name').css('border-color', '#dd4b39');
        $('#product_name_help_block').html('<font color="#dd4b39">Please Enter Product</font>');
        proceed = 0;
    } else {
        if (product_id == '') {
            $('#product_name').css('border-color', '#dd4b39');
            $('#product_name_help_block').html('<font color="#dd4b39">Product Not Found</font>');
            proceed = 0;
        } else {
            $('#product_name').css('border-color', 'rgb(210, 214, 222)');
            $('#product_name_help_block').html('');
        }
    }

    if (mrp == '') {
        $('#mrp').css('border-color', '#dd4b39');
        $('#mrp_help_block').html('<font color="#dd4b39">Please Enter MRP</font>');
        proceed = 0;
    } else {
        mrp = parseFloat(mrp);
        if (mrp == '') {
            $('#mrp').css('border-color', '#dd4b39');
            $('#mrp_help_block').html('<font color="#dd4b39">Please Enter MRP</font>');
            proceed = 0;
        } else {
            $('#mrp').css('border-color', 'rgb(210, 214, 222)');
            $('#mrp_help_block').html('');
        }
    }

    if (quantity == '') {
        $('#product_qty').css('border-color', '#dd4b39');
        $('#product_qty_addon').css('border-color', '#dd4b39');
        $('#product_qty_help_block').html('<font color="#dd4b39">Please Enter Quantity</font>');
        proceed = 0;
    } else {
        quantity = parseInt(quantity);
        if (quantity == '') {
            $('#product_qty').css('border-color', '#dd4b39');
            $('#product_qty_addon').css('border-color', '#dd4b39');
            $('#product_qty_help_block').html('<font color="#dd4b39">Please Enter Quantity</font>');
            proceed = 0;
        } else {
            $('#product_qty').css('border-color', 'rgb(210, 214, 222)');
            $('#product_qty_addon').css('border-color', 'rgb(210, 214, 222)');
            $('#product_qty_help_block').html('');
        }
    }

    if (price == '') {
        $('#price').css('border-color', '#dd4b39');
        $('#price_help_block').html('<font color="#dd4b39">Please Enter Price</font>');
        proceed = 0;
    } else {
        price = parseFloat(price);
        if (price == '') {
            $('#price').css('border-color', '#dd4b39');
            $('#price_help_block').html('<font color="#dd4b39">Please Enter Price</font>');
            proceed = 0;
        } else {
            $('#price').css('border-color', 'rgb(210, 214, 222)');
            $('#price_help_block').html('');
        }
    }

    if (proceed != 0) {
        var target_account_id = $('#target_account_id').val();
        var target_account = $('#target_account_id option:selected').text();
        var hsn_code = $('#hsn_code').val();
        var discount_percentage = $('#discount_rate').val();
        var discount_rs = $('#discount_price').val();

        if ($.trim(hsn_code) == '') {
            hsn_code = '-';
        }

        if ($.trim(discount_rs) == '') {
            discount_rs = '0.00';
        }

        var amount = quantity * price;

        if ($.trim(discount_percentage) != '') {
            discount_rs = (amount * parseFloat(discount_percentage)) / 100;
        } else {
            discount_percentage = '0.00';
        }

        var cgst_percentage = $('#cgst').val();
        if ($.trim(cgst_percentage) != '') {
            var cgst_rs = (amount * parseFloat(cgst_percentage)) / 100;
        } else {
            cgst_percentage = '0.00';
            var cgst_rs = '0.00';
        }


        var sgst_percentage = $('#sgst').val();
        if ($.trim(sgst_percentage) != '') {
            var sgst_rs = (amount * parseFloat(sgst_percentage)) / 100;
        } else {
            sgst_percentage = '0.00';
            var sgst_rs = '0.00';
        }

        var igst_percentage = $('#igst').val();
        if ($.trim(igst_percentage) != '') {
            var igst_rs = (amount * parseFloat(igst_percentage)) / 100;
        } else {
            igst_percentage = '0.00';
            var igst_rs = '0.00';
        }

        var total_amount = amount - parseFloat(discount_rs) + parseFloat(cgst_rs) + parseFloat(sgst_rs) + parseFloat(igst_rs);

        $('#overlay_product').show();
        $.ajax({
            url: '?controller=product&action=checkQtyForPurhase',
            data: {
                'product_id': product_id,
                'target_account_id': target_account_id,
                'quantity': quantity
            },
            type: 'post',
            success: function (finalQty) {
                finalQty = $.trim(finalQty);

                discount_rs = parseFloat(Math.round(discount_rs * 100) / 100).toFixed(2);
                cgst_rs = parseFloat(Math.round(cgst_rs * 100) / 100).toFixed(2);
                sgst_rs = parseFloat(Math.round(sgst_rs * 100) / 100).toFixed(2);
                igst_rs = parseFloat(Math.round(igst_rs * 100) / 100).toFixed(2);
                total_amount = parseFloat(Math.round(total_amount * 100) / 100).toFixed(2);

                if ($('#tr_' + product_id).length) {
                    $('#product_name').css('border-color', '#dd4b39');
                    $('#product_name_help_block').html('<font color="#dd4b39">Product Already Added</font>');
                } else {
                    var table = $('#products_table').DataTable();

                    var rowNode = table.row.add([product_id, target_account, product_name + '</br>' + '<font color="green">' + finalQty + ' Nos in stock.', hsn_code, mrp, quantity, price, discount_percentage, discount_rs, cgst_percentage, cgst_rs, sgst_percentage, sgst_rs, igst_percentage, igst_rs, total_amount, '<a href="" class="delete_product" data-id="' + product_id + '"> <i class="fa fa-fw fa-trash"></i></a>']).draw().node();
                    $(rowNode).attr('id', 'tr_' + product_id);
                    $(rowNode).attr('data-id', product_id);
                    $(rowNode).attr('data-tid', target_account_id);
                    $(rowNode).attr('data-name', product_name);
                    $(rowNode).attr('data-hcode', hsn_code);
                    $(rowNode).attr('data-mrp', mrp);
                    $(rowNode).attr('data-qty', quantity);
                    $(rowNode).attr('data-finalQty', finalQty);
                    $(rowNode).attr('data-price', price);
                    $(rowNode).attr('data-dper', discount_percentage);
                    $(rowNode).attr('data-drs', discount_rs);
                    $(rowNode).attr('data-cgstper', cgst_percentage);
                    $(rowNode).attr('data-cgstrs', cgst_rs);
                    $(rowNode).attr('data-sgstper', sgst_percentage);
                    $(rowNode).attr('data-sgstrs', sgst_rs);
                    $(rowNode).attr('data-igstper', igst_percentage);
                    $(rowNode).attr('data-igstrs', igst_rs);
                    $(rowNode).attr('data-total', total_amount);

                    $(rowNode).attr('class', 'products');

                    $('#products_table_div').fadeIn();

                    $('#product_id').val('');
                    $('#product_name').val('');
                    $('#mrp').val('');
                    $('#product_qty').val('');
                    $('#price').val('');
                    $('#discount_rate').val('');
                    $('#discount_price').val('');
                    $('#cgst').val('');
                    $('#sgst').val('');
                    $('#igst').val('');
                }
            },
            error: function (xhr, status, error) {
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('#overlay_product').hide();
            }
        });
    }
});

$(document).on('click', '.delete_product', function (e) {
    e.preventDefault();

    var data_id = $(this).attr('data-id');

    var table = $('#products_table').DataTable();
    table.row($('#tr_' + data_id)).remove().draw(false);
});

$(function () {

    $("#date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
    $("#invoice_date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
    $('#delete_selected').attr('disabled', true);

    var t = $('#purchase_vouchers_table').DataTable({
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

$(document).on('focusout', '#invoice_no', function () {
    var save_type = $.trim($('#save_type').val());
    var invoice_no = $('#invoice_no').val();

    var id = '';
    if (save_type == 'add') {
        id = '';
    } else if (save_type == 'edit') {
        id = $.trim($('#id').val());
    }

    if ($.trim(invoice_no) == '') {
        $('#valid_invoice_no').val('0');
        $('#invoice_no').css('border-color', '#dd4b39');
        $('#invoice_no_label').css('color', '#dd4b39');
        $('#invoice_no_help_block').html('<font color="#dd4b39">Please enter invoice no.</font>');
    } else {
        $('#overlay_invoice').show();
        $('#overlay_product').show();
        $('#overlay_party').show();
        $.ajax({
            url: '?controller=purchase&action=checkInovieExist',
            data: {
                'id': id,
                'invoice_no': invoice_no
            },
            type: 'post',
            success: function (response) {
                response = $.trim(response);
                if (response == '1') {
                    $('#invoice_no').css('border-color', '#dd4b39');
                    $('#invoice_no_label').css('color', '#dd4b39');
                    $('#invoice_no_help_block').html('<font color="#dd4b39">This invoice already exists.</font>');
                    $('#valid_invoice_no').val('0');
                } else {
                    $('#invoice_no').css('border-color', 'rgb(210, 214, 222)');
                    $('#invoice_no_label').css('color', 'black');
                    $('#invoice_no_help_block').html('');
                    $('#valid_invoice_no').val('1');
                }
            },
            error: function (xhr, status, error) {
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('#overlay_invoice').hide();
                $('#overlay_product').hide();
                $('#overlay_party').hide();
            }
        });
    }
});

$(document).on('change', '#party_id', function () {
    var party_id = $(this).val();
    if ($.trim(party_id) != '') {
        $('#overlay_party').show();
        $.ajax({
            url: '?controller=accountgroup&action=getById',
            data: {
                'id': party_id,
            },
            type: 'post',
            dataType: "json",
            success: function (response) {
                $.each(response, function (item, obj) {
                    for (var key in obj) {
                        $('#party_name').val(obj.name);
                        $('#is_valid_party_name').val('1');
                        $('#party_parent_id').val(obj.parent_id);
                        $('#opening_balance').val(obj.opening_balance);
                        $('#contact_person').val(obj.contact_person);
                        $('#email').val(obj.email);
                        $('#area').val(obj.area);
                        $('#city').val(obj.city);
                        $('#pincode').val(obj.pincode);
                        $('#mobile1').val(obj.mobile1);
                        $('#mobile2').val(obj.mobile2);
                        $('#party_bank_name').val(obj.bank_name);
                        $('#party_bank_branch').val(obj.bank_branch);
                        $('#party_ifsc_code').val(obj.ifsc_code);
                        $('#party_bank_account_no').val(obj.bank_account_no);
                        $('#party_pan').val(obj.pan);
                        $('#party_gst_state_code_id').val(obj.gst_state_code_id);
                        $('#party_gst_type_id').val(obj.gst_type_id);
                        $('#party_gstin').val(obj.gstin);

                        if (obj.parent_name == '') {
                            $('#group_parent').html('');
                        } else {
                            $('#group_parent').html('<font color="blue"><i>' + obj.parent_name + '</i></font>');
                        }

                        $('#party_name').attr('disabled', 'disabled');
                        $('#party_parent_id').attr('disabled', 'disabled');
                        $('#opening_balance').attr('disabled', 'disabled');
                        $('#contact_person').attr('disabled', 'disabled');
                        $('#email').attr('disabled', 'disabled');
                        $('#area').attr('disabled', 'disabled');
                        $('#city').attr('disabled', 'disabled');
                        $('#pincode').attr('disabled', 'disabled');
                        $('#mobile1').attr('disabled', 'disabled');
                        $('#mobile2').attr('disabled', 'disabled');
                        $('#party_bank_name').attr('disabled', 'disabled');
                        $('#party_bank_branch').attr('disabled', 'disabled');
                        $('#party_ifsc_code').attr('disabled', 'disabled');
                        $('#party_bank_account_no').attr('disabled', 'disabled');
                        $('#party_pan').attr('disabled', 'disabled');
                        $('#party_gst_state_code_id').attr('disabled', 'disabled');
                        $('#party_gst_type_id').attr('disabled', 'disabled');
                        $('#party_gstin').attr('disabled', 'disabled');
                    }
                });
            },
            error: function (xhr, status, error) {
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('#overlay_party').hide();
            }
        });
    } else {
        $('#party_name').val('');
        $('#is_valid_party_name').val('0');
        $('#party_parent_id').val('44');
        $('#group_parent').html('<font color="blue"><i>(Current Liabilities)</i></font>');
        $('#opening_balance').val('');
        $('#contact_person').val('');
        $('#email').val('');
        $('#area').val('');
        $('#city').val('');
        $('#pincode').val('');
        $('#mobile1').val('');
        $('#mobile2').val('');
        $('#party_bank_name').val('');
        $('#party_bank_branch').val('');
        $('#party_ifsc_code').val('');
        $('#party_bank_account_no').val('');
        $('#party_pan').val('');
        $('#party_gst_state_code_id').val('0');
        $('#party_gst_type_id').val('3');
        $('#party_gstin').val('');

        $('#party_name').removeAttr('disabled');
        $('#party_parent_id').removeAttr('disabled');
        $('#opening_balance').removeAttr('disabled');
        $('#contact_person').removeAttr('disabled');
        $('#email').removeAttr('disabled');
        $('#area').removeAttr('disabled');
        $('#city').removeAttr('disabled');
        $('#pincode').removeAttr('disabled');
        $('#mobile1').removeAttr('disabled');
        $('#mobile2').removeAttr('disabled');
        $('#party_bank_name').removeAttr('disabled');
        $('#party_bank_branch').removeAttr('disabled');
        $('#party_ifsc_code').removeAttr('disabled');
        $('#party_bank_account_no').removeAttr('disabled');
        $('#party_pan').removeAttr('disabled');
        $('#party_gst_state_code_id').removeAttr('disabled');
        $('#party_gst_type_id').removeAttr('disabled');
        $('#party_gstin').removeAttr('disabled');
    }
});

$(document).on('focusout', '#party_name', function () {
    var name = $('#party_name').val();
    var save_type = $.trim($('#save_type').val());

    var id = '';
    if (save_type == 'add') {
        id = '';
    } else if (save_type == 'edit') {
        id = $.trim($('#party_id').val());
    }

    if ($.trim(name) == '') {
        $('#is_valid_party_name').val('0');
        $('#party_name').css('border-color', '#dd4b39');
        $('#party_name_label').css('color', '#dd4b39');
        $('#party_name_help_block').html('<font color="#dd4b39">Please enter party name</font>');
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
                    $('#is_valid_party_name').val('0');
                    $('#party_name').css('border-color', '#dd4b39');
                    $('#party_name_label').css('color', '#dd4b39');
                    $('#party_name_help_block').html('<font color="#dd4b39">This name already exists.</font>');
                } else {
                    $('#is_valid_party_name').val('1');
                    $('#party_name').css('border-color', 'rgb(210, 214, 222)');
                    $('#party_name_label').css('color', 'black');
                    $('#party_name_help_block').html('');
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

$(document).on('change', '#party_parent_id', function () {
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
    var parent_id = $('option:selected', '#party_parent_id').attr('data-parent-id');
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
    var product_details = [];

    var valid_invoice_no = $('#valid_invoice_no').val();

    if (valid_invoice_no == '0') {
        proceed = 0;
    }

    var is_valid_date = isValidDate($('#date').val());
    if (!(is_valid_date)) {
        $('#date_label').css('color', '#dd4b39');
        $('#date').css('border-color', '#dd4b39');
        $('#date_help_block').html('<font color="#dd4b39">Please enter valid date</font>');
        proceed = 0;
    } else {
        $('#date_label').css('color', 'black');
        $('#date').css('border-color', 'rgb(210, 214, 222)');
        $('#date_help_block').html('');
    }

    var is_valid_invoice_date = isValidDate($('#invoice_date').val());
    if (!(is_valid_invoice_date)) {
        $('#invoice_date_label').css('color', '#dd4b39');
        $('#invoice_date').css('border-color', '#dd4b39');
        $('#invoice_date_help_block').html('<font color="#dd4b39">Please enter valid invoice date</font>');
        proceed = 0;
    } else {
        $('#invoice_date_label').css('color', 'black');
        $('#invoice_date').css('border-color', 'rgb(210, 214, 222)');
        $('#invoice_date_help_block').html('');
    }

    var is_valid_party_name = $('#is_valid_party_name').val();

    if (is_valid_party_name == '0') {
        proceed = 0;
    }

    var panVal = $('#party_pan').val();
    if ($.trim(panVal) != '') {
        var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
        if (!(regpan.test(panVal))) {
            $('#pan_label').css('color', '#dd4b39');
            $('#party_pan').css('border-color', '#dd4b39');
            $('#pan_help_block').html('<font color="#dd4b39">Please enter valid PAN</font>');
            proceed = 0;
        } else {
            $('#pan_label').css('color', 'black');
            $('#party_pan').css('border-color', 'rgb(210, 214, 222)');
            $('#pan_help_block').html('');
        }
    } else {
        $('#pan_label').css('color', 'black');
        $('#party_pan').css('border-color', 'rgb(210, 214, 222)');
        $('#pan_help_block').html('');
    }

    var gstin = $('#party_gstin').val();
    if ($.trim(gstin) != '') {

        var gst_state_code_id = $('#party_gst_state_code_id').val();
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
            $('#party_gstin').css('border-color', '#dd4b39');
            $('#gstin_help_block').html('<font color="#dd4b39">Invalid GSTIN</font>');
            proceed = 0;
        } else {
            $('#gstin_label').css('color', 'black');
            $('#party_gstin').css('border-color', 'rgb(210, 214, 222)');
            $('#gstin_help_block').html('');
        }
    }

//    if (!($("tr[id^='tr_']").length)) {
    if (!($('.products').length)) {
        $('#product_name').css('border-color', '#dd4b39');
        $('#product_name_help_block').html('<font color="#dd4b39">Please Enter Product</font>');
        proceed = 0;
    } else {
        $('#product_name').css('border-color', 'rgb(210, 214, 222)');
        $('#product_name_help_block').html('');

        $('.products').each(function () {
            var data_id = $(this).attr('data-id');
            var data_tid = $(this).attr('data-tid');
            var data_name = $(this).attr('data-name');
            var data_hcode = $(this).attr('data-hcode');
            var data_mrp = $(this).attr('data-mrp');
            var data_qty = $(this).attr('data-qty');
            var data_finalQty = $(this).attr('data-finalQty');
            var data_price = $(this).attr('data-price');
            var data_dper = $(this).attr('data-dper');
            var data_drs = $(this).attr('data-drs');
            var data_cgstper = $(this).attr('data-cgstper');
            var data_cgstrs = $(this).attr('data-cgstrs');
            var data_sgstper = $(this).attr('data-sgstper');
            var data_sgstrs = $(this).attr('data-sgstrs');
            var data_igstper = $(this).attr('data-igstper');
            var data_igstrs = $(this).attr('data-igstrs');
            var data_total = $(this).attr('data-total');


            product_details.push(data_id + '_' + data_tid + '_' + data_name + '_' + data_hcode + '_' + data_mrp + '_' + data_qty + '_' + data_finalQty + '_' + data_price + '_' + data_dper + '_' + data_drs + '_' + data_cgstper + '_' + data_cgstrs + '_' + data_sgstper + '_' + data_sgstrs + '_' + data_igstper + '_' + data_igstrs + '_' + data_total);
        });
        $('#products_data').val(product_details);
    }

    if (proceed != 0) {
        return true;
    } else {
        return false;
    }
});

$(function () {
    var t1 = $('#products_table').DataTable({
        "paging": false,
        "bInfo": false,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "searching": false,
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
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
            };

            // Total over all pages
            var total_mrp = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_qty = api
                    .column(5)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            var total_rate_per_unit = api
                    .column(6)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_discount_percentage = api
                    .column(7)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_discount_rs = api
                    .column(8)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_cgst_percentage = api
                    .column(9)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_cgst_rs = api
                    .column(10)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_sgst_percentage = api
                    .column(11)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_sgst_rs = api
                    .column(12)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_igst_percentage = api
                    .column(13)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_igst_rs = api
                    .column(14)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            var total_price = api
                    .column(15)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            total_price = parseFloat(Math.round(total_price * 100) / 100).toFixed(2);

            // Total over this page
            var pageTotal = api
                    .column(4, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            // Update footer
            $(api.column(4).footer()).html('<input type="hidden" id="total_mrp" name="total_mrp" value="' + total_mrp + '">' + total_mrp);
            $(api.column(5).footer()).html('<input type="hidden" id="total_qty" name="total_qty" value="' + total_qty + '">' + total_qty);
            $(api.column(6).footer()).html('<input type="hidden" id="total_rate_per_unit" name="total_rate_per_unit" value="' + total_rate_per_unit + '">' + total_rate_per_unit);
            $(api.column(7).footer()).html('<input type="hidden" id="total_discount_percentage" name="total_discount_percentage" value="' + total_discount_percentage + '">' + total_discount_percentage);
            $(api.column(8).footer()).html('<input type="hidden" id="total_discount_rs" name="total_discount_rs" value="' + total_discount_rs + '">' + total_discount_rs);
            $(api.column(9).footer()).html('<input type="hidden" id="total_cgst_percentage" name="total_cgst_percentage" value="' + total_cgst_percentage + '">' + total_cgst_percentage);
            $(api.column(10).footer()).html('<input type="hidden" id="total_cgst_rs" name="total_cgst_rs" value="' + total_cgst_rs + '">' + total_cgst_rs);
            $(api.column(11).footer()).html('<input type="hidden" id="total_sgst_percentage" name="total_sgst_percentage" value="' + total_sgst_percentage + '">' + total_sgst_percentage);
            $(api.column(12).footer()).html('<input type="hidden" id="total_sgst_rs" name="total_sgst_rs" value="' + total_sgst_rs + '">' + total_sgst_rs);
            $(api.column(13).footer()).html('<input type="hidden" id="total_igst_percentage" name="total_igst_percentage" value="' + total_igst_percentage + '">' + total_igst_percentage);
            $(api.column(14).footer()).html('<input type="hidden" id="total_igst_rs" name="total_igst_rs" value="' + total_igst_rs + '">' + total_igst_rs);
            $(api.column(15).footer()).html('<input type="hidden" id="total_bill_amount" name="total_bill_amount" value="' + total_price + '">' + total_price);
        }
    });
});