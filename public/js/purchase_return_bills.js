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
    $('input[name="select_purchase_return_vouchers[]"]').each(function () {
        this.checked = status;
    });
    $('#delete_selected').attr('disabled', !(status));
});

$(document).on('change', 'input[name="select_purchase_return_vouchers[]"]', function (e) {
    if (this.checked == false) {
        $(".select-all")[0].checked = false;
    }

    if ($('input[name="select_purchase_return_vouchers[]"]:checked').length > 0) {
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
        $('input[name="select_purchase_return_vouchers[]"]:checked').each(function () {
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
            url: '?controller=purchasereturn&action=checkInovieExist',
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

$(document).on('click', '#proceed_purchase_bill', function () {
    var proceed = 1;

    var party_id = $('#party_id').val();
    var purchase_invoice_no = $.trim($('#purchase_invoice_no').val());
    var purchase_invoice_date_range = $.trim($('#purchase_invoice_date_range').val());

    if (party_id == '') {
        $('#party_id').css('border-color', '#dd4b39');
        $('#party_id_label').css('color', '#dd4b39');
        $('#party_id_help_block').html('<font color="#dd4b39">Please select party.</font>');
        proceed = 0;
    } else {
        $('#party_id').css('border-color', 'rgb(210, 214, 222)');
        $('#party_id_label').css('color', 'black');
        $('#party_id_help_block').html('');
    }

    if (purchase_invoice_no == '' && purchase_invoice_date_range == '') {
        $('#purchase_bill_error').html('<font color="#dd4b39">Please enter invoice no or invoice date range.</font>');
        $('#purchase_bill_error_div').show();
        proceed = 0;
    } else {
        $('#purchase_bill_error').html('');
        $('#purchase_bill_error_div').hide();
    }

    if (proceed != 0) {
        $('.overlay').show();
        $.ajax({
            url: '?controller=purchase&action=filterBillForReturn',
            data: {
                'party_id': party_id,
                'purchase_invoice_no': purchase_invoice_no,
                'purchase_invoice_date_range': purchase_invoice_date_range
            },
            type: 'post',
            dataType: "json",
            success: function (response) {
                if (response.length) {
                    $('#purchase_bill_error').html('');
                    $('#purchase_bill_error_div').hide();

                    $('#p_invoice_no').html('<option value="">Select Invoice No</option>');
                    $('#product_id').html('<option value="">Select Product</option>');
                    $('#purchase_voucher_id').val('');

                    $.each(response, function (item, obj) {
                        $('#p_invoice_no').append($("<option></option>").attr("value", obj.invoice_no).text(obj.invoice_no));
                    });
                } else {
                    $('#purchase_bill_error').html('<font color="#dd4b39">No data found.</font>');
                    $('#purchase_bill_error_div').show();

                    $('#p_invoice_no').html('<option value="">Select Invoice No</option>');
                    $('#product_id').html('<option value="">Select Product</option>');
                    $('#qty').val('');
                    $('#purchase_qty').val('');
                    $('#purchase_voucher_id').val('');
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

$(document).on('change', '#p_invoice_no', function () {
    var p_invoice_no = $(this).val();
    if (p_invoice_no != '') {
        $('.overlay').show();
        $.ajax({
            url: '?controller=purchase&action=getFromInvoiceNo',
            data: {
                'invoice_no': p_invoice_no
            },
            type: 'post',
            dataType: "json",
            success: function (response) {
                if (response.length) {
                    $('#product_id').html('<option value="">Select Product</option>');
                    $.each(response, function (item, obj) {
                        $('#purchase_voucher_id').val(obj.id);
                        var products_data = obj.products_data;
                        var products_data_arr = products_data.split(',');
                        for (var i in products_data_arr) {
                            var product_arr = products_data_arr[i].split('_');

                            var product_id = product_arr[0];
                            var target_account_id = product_arr[1];
                            var product_name = product_arr[2];
                            var hsn_code = product_arr[3];
                            var mrp = product_arr[4];
                            var qty = product_arr[5];
                            var final_updated_qty = product_arr[6];
                            var price = product_arr[7];
                            var discount_percentage = product_arr[8];
                            var discount_rs = product_arr[9];
                            var cgst_percentage = product_arr[10];
                            var cgst_rs = product_arr[11];
                            var sgst_percentage = product_arr[12];
                            var sgst_rs = product_arr[13];
                            var igst_percentage = product_arr[14];
                            var igst_rs = product_arr[15];
                            var total_amount = product_arr[16];

                            if (target_account_id == '1') {
                                var target_account_name = 'Asha';
                            } else if (target_account_id == '2') {
                                var target_account_name = "Lakhan";
                            }

                            $('#product_id').append(
                                    $("<option></option>")
                                    .attr("value", product_id)
                                    .attr("data-product_name", product_name)
                                    .attr("data-target_account_id", target_account_id)
                                    .attr("data-hsn_code", hsn_code)
                                    .attr("data-mrp", mrp)
                                    .attr("data-qty", qty)
                                    .attr("data-final_updated_qty", final_updated_qty)
                                    .attr("data-price", price)
                                    .attr("data-discount_percentage", discount_percentage)
                                    .attr("data-discount_rs", discount_rs)
                                    .attr("data-cgst_percentage", cgst_percentage)
                                    .attr("data-cgst_rs", cgst_rs)
                                    .attr("data-sgst_percentage", sgst_percentage)
                                    .attr("data-sgst_rs", sgst_rs)
                                    .attr("data-igst_percentage", igst_percentage)
                                    .attr("data-igst_rs", igst_rs)
                                    .attr("data-total_amount", total_amount)
                                    .attr("data-target_account_name", target_account_name)
                                    .text(product_name)
                                    );

                            $('#qty').val('');
                            $('#purchase_qty').val('');
                        }
                    });
                } else {
                    $('#product_id').html('<option value="">Select Product</option>');
                    $('#qty').val('');
                    $('#purchase_qty').val('');
                    $('#purchase_voucher_id').val('');
                }
            },
            error: function (xhr, status, error) {
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('.overlay').hide();
            }
        });
    } else {
        $('#product_id').html('<option value="">Select Product</option>');
        $('#qty').val('');
        $('#purchase_qty').val('');
        $('#purchase_voucher_id').val('');
    }
});

$(document).on('change', '#product_id', function () {
    var product_id = $(this).val();
    if (product_id != '') {
        var selected_product = $('#product_id option:selected');
        $('#qty').val(selected_product.attr('data-qty'));
        $('#purchase_qty').val(selected_product.attr('data-qty'));
    } else {
        $('#qty').val('');
        $('#purchase_qty').val('');
    }
});

$(document).on('click', '#proceed_product', function () {
    var proceed = 1;

    var product_id = $('#product_id').val();
    var quantity = $('#qty').val();
    var purchase_qty = $('#purchase_qty').val();

    if (product_id == '') {
        $('#product_id').css('border-color', '#dd4b39');
        $('#product_id_help_block').html('<font color="#dd4b39">Please select product</font>');
        proceed = 0;
    } else {
        $('#product_id').css('border-color', 'rgb(210, 214, 222)');
        $('#product_id_help_block').html('');
    }

    if (quantity == '') {
        $('#qty').css('border-color', '#dd4b39');
        $('#qty_help_block').html('<font color="#dd4b39">Please Enter Quantity</font>');
        proceed = 0;
    } else {
        quantity = parseInt(quantity);
        purchase_qty = parseInt(purchase_qty);

        if (quantity == '') {
            $('#qty').css('border-color', '#dd4b39');
            $('#qty_help_block').html('<font color="#dd4b39">Please Enter Quantity</font>');
            proceed = 0;
        } else {
            if (quantity > purchase_qty) {
                $('#qty').css('border-color', '#dd4b39');
                $('#qty_help_block').html('<font color="#dd4b39">Quantity should be less than quantity you purchased.</font>');
                proceed = 0;
            } else {
                $('#qty').css('border-color', 'rgb(210, 214, 222)');
                $('#qty_help_block').html('');
            }
        }
    }

    if (proceed != 0) {
        var selected_product = $('#product_id option:selected');

        var target_account_id = selected_product.attr('data-target_account_id');
        var target_account = selected_product.attr('data-target_account_name');
        var product_name = selected_product.attr('data-product_name');
        var hsn_code = selected_product.attr('data-hsn_code');
        var mrp = selected_product.attr('data-mrp');
        var price = parseFloat(selected_product.attr('data-price'));
        var discount_percentage = selected_product.attr('data-discount_percentage');
        var discount_rs = selected_product.attr('data-discount_rs');
        var cgst_percentage = selected_product.attr('data-cgst_percentage');
        var cgst_rs = selected_product.attr('data-cgst_rs');
        var sgst_percentage = selected_product.attr('data-sgst_percentage');
        var sgst_rs = selected_product.attr('data-sgst_rs');
        var igst_percentage = selected_product.attr('data-igst_percentage');
        var igst_rs = selected_product.attr('data-igst_rs');

        var amount = quantity * price;

        var total_amount = amount - parseFloat(discount_rs) + parseFloat(cgst_rs) + parseFloat(sgst_rs) + parseFloat(igst_rs);

        $('#overlay_product').show();
        $.ajax({
            url: '?controller=product&action=checkQtyForSales',
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
                    $('#product_id').css('border-color', '#dd4b39');
                    $('#product_id_help_block').html('<font color="#dd4b39">Product Already Added</font>');
                } else {
                    var table = $('#products_table').DataTable();

                    var rowNode = table.row.add([product_id, target_account, product_name + '</br>' + '<font color="red">' + finalQty + ' Nos in stock.', hsn_code, mrp, quantity, price, discount_percentage, discount_rs, cgst_percentage, cgst_rs, sgst_percentage, sgst_rs, igst_percentage, igst_rs, total_amount, '<a href="" class="delete_product" data-id="' + product_id + '"> <i class="fa fa-fw fa-trash"></i></a>']).draw().node();
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
                    $('#qty').val('');
                    $('#purchase_qty').val('');
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

    if (!($('.products').length)) {
        $('#product_id').css('border-color', '#dd4b39');
        $('#product_id_help_block').html('<font color="#dd4b39">Please Select Product</font>');
        proceed = 0;
    } else {
        $('#product_id').css('border-color', 'rgb(210, 214, 222)');
        $('#product_id_help_block').html('');

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

    $("#date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
    $("#invoice_date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
//    Date range picker
    $('#purchase_invoice_date_range').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        startDate: '01/04/2017',
        endDate: '31/03/2018'
    });
    $('#delete_selected').attr('disabled', true);

    var t = $('#purchase_return_vouchers_table').DataTable({
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