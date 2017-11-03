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
            url: '?controller=customer&action=deleteCutomer',
            type: "POST",
            data: {'id': data_to_delete},
            success: function (response) {
                if ($.trim(response) == 'deleted') {
                    var table = $('#purchase_vouchers_table').DataTable();
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
        $('input[name="select_purchase_vouchers[]"]:checked').each(function () {
            data_to_delete.push($(this).attr('data-id'));
        });
        $('#loader').show();
        $.ajax({
            url: '?controller=customer&action=deleteCutomer',
            type: "POST",
            data: {'id': data_to_delete},
            dataType: "json",
            success: function (response) {
                var table = $('#purchase_vouchers_table').DataTable();
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


function enterKeyEvent(e) {
    if (e.keyCode == 13) {
        var party_id = $.trim($('#party_id').val());
        if (party_id == '') {
            $('#party_address').val('');
            $('#party_contact_person').val('');
            $('#party_email').val('');
            $('#party_mobile1').val('');
            $('#party_mobile2').val('');
            $('#party_residence_no').val('');
            $('#party_office_no').val('');
            $('#party_bank_name').val('');
            $('#party_bank_branch').val('');
            $('#party_ifsc_code').val('');
            $('#party_bank_account_no').val('');
            $('#party_pan').val('');
            $('#party_gst_type_id').val('');
            $('#party_gstin').val('');
        }
    }
}

$(document).on('focusout', '#party_name', function (e) {
    var party_id = $.trim($('#party_id').val());
    if (party_id == '') {
        $('#party_address').val('');
        $('#party_contact_person').val('');
        $('#party_email').val('');
        $('#party_mobile1').val('');
        $('#party_mobile2').val('');
        $('#party_residence_no').val('');
        $('#party_office_no').val('');
        $('#party_bank_name').val('');
        $('#party_bank_branch').val('');
        $('#party_ifsc_code').val('');
        $('#party_bank_account_no').val('');
        $('#party_pan').val('');
        $('#party_gst_type_id').val('');
        $('#party_gstin').val('');
    }
});

$(document).on('change', '#purchase_type_id', function () {
    var purchase_type = $(this).find('option:selected').text();

    if ($("tr[id^='tr_']").length) {
        var table = $('#products_table').DataTable();

        if (purchase_type == 'Local Purchase') {
            table.cell('#igst_td').data('0.00').draw();

            var old_cgst_val = parseFloat($('#cgst_td').html());
            var old_sgst_val = parseFloat($('#sgst_td').html());

            var new_cgst_val = parseFloat(0.00);
            var new_sgst_val = parseFloat(0.00);

            table.rows($("tr[id^='tr_']")).eq(0).each(function (index) {
                var row = table.row(index);

                var data = row.data(); //fetch data of each row
                var data_price = data[4];

                var rowNode = row.node(); //fetch row node

                var data_cgst_per = $(rowNode).attr('data-cgst');
                var data_cgst = (parseFloat(data_price) * parseFloat(data_cgst_per)) / 100;
                new_cgst_val += parseFloat(data_cgst);

                var data_sgst_per = $(rowNode).attr('data-sgst');
                var data_sgst = (parseFloat(data_price) * parseFloat(data_sgst_per)) / 100;
                new_sgst_val += parseFloat(data_sgst);
            });

            var cgst_td_html = old_cgst_val + parseFloat(new_cgst_val);
            table.cell('#cgst_td').data(cgst_td_html).draw();

            var sgst_td_html = old_sgst_val + parseFloat(new_sgst_val);
            table.cell('#sgst_td').data(sgst_td_html).draw();
        } else if (purchase_type == 'Interstate Purchase') {
            table.cell('#cgst_td').data('0.00').draw();
            table.cell('#sgst_td').data('0.00').draw();

            var old_igst_val = parseFloat($('#igst_td').html());
            var new_igst_val = parseFloat(0.00);

            table.rows($("tr[id^='tr_']")).eq(0).each(function (index) {
                var row = table.row(index);

                var data = row.data(); //fetch data of each row
                var data_price = data[4];

                var rowNode = row.node(); //fetch row node

                var data_igst_per = $(rowNode).attr('data-igst');
                var data_igst = (parseFloat(data_price) * parseFloat(data_igst_per)) / 100;
                new_igst_val += parseFloat(data_igst);
            });

            var igst_td_html = old_igst_val + parseFloat(new_igst_val);
            table.cell('#igst_td').data(igst_td_html).draw();
        }
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
                        gst_state_code_id: item.gst_state_code_id,
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
        $('#party_address').val(ui.item.address);
        $('#party_contact_person').val(ui.item.contact_person);
        $('#party_email').val(ui.item.email);
        $('#party_mobile1').val(ui.item.mobile1);
        $('#party_mobile2').val(ui.item.mobile2);
        $('#party_residence_no').val(ui.item.residence_no);
        $('#party_office_no').val(ui.item.office_no);
        $('#party_bank_name').val(ui.item.bank_name);
        $('#party_bank_branch').val(ui.item.bank_branch);
        $('#party_ifsc_code').val(ui.item.ifsc_code);
        $('#party_bank_account_no').val(ui.item.bank_account_no);
        $('#party_pan').val(ui.item.pan);
        $('#party_gst_state_code_id').val(ui.item.gst_state_code_id);
        $('#party_gst_type_id').val(ui.item.gst_type_id);
        $('#party_gstin').val(ui.item.gstin);
    }
});
$("#party_name").autocomplete("option", "appendTo", ".eventInsForm");

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
                        qty: item.qty,
                        price: item.price,
                        cgst: item.cgst,
                        sgst: item.sgst,
                        integrated_tax: item.integrated_tax
                    }
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        $('#product_id').val(ui.item.id);
        $('#price').val(ui.item.price);
        $('#cgst').val(ui.item.cgst);
        $('#sgst').val(ui.item.sgst);
        $('#igst').val(ui.item.integrated_tax);
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
        $('#cgst').val('');
        $('#sgst').val('');
        $('#igst').val('');
    }
});

$(document).on('click', '#proceed_product', function () {
    var proceed = 1;

    var product_name = $('#product_name').val();
    var product_id = $('#product_id').val();
    var price = $('#price').val();
    var cgst = $('#cgst').val();
    var sgst = $('#sgst').val();
    var igst = $('#igst').val();
    var quantity = $('#product_qty').val();
    var purchase_type = $('#purchase_type_id option:selected').text();

    if (product_name == '') {
        $('#product_name').css('border-color', '#dd4b39');
        $('#product_name_label').css('color', '#dd4b39');
        $('#product_name_help_block').html('<font color="#dd4b39">Please Enter Product</font>');
        proceed = 0;
    } else {
        if (product_id == '') {
            $('#product_name').css('border-color', '#dd4b39');
            $('#product_name_label').css('color', '#dd4b39');
            $('#product_name_help_block').html('<font color="#dd4b39">Product Not Found</font>');
            proceed = 0;
        } else {
            $('#product_name').css('border-color', 'rgb(210, 214, 222)');
            $('#product_name_label').css('color', 'black');
            $('#product_name_help_block').html('');
        }
    }

    if (quantity == '') {
        $('#product_qty').css('border-color', '#dd4b39');
        $('#product_qty_addon').css('border-color', '#dd4b39');
        $('#product_qty_label').css('color', '#dd4b39');
        $('#product_qty_help_block').html('<font color="#dd4b39">Please Enter Quantity</font>');
        proceed = 0;
    } else {
        $('#product_qty').css('border-color', 'rgb(210, 214, 222)');
        $('#product_qty_addon').css('border-color', 'rgb(210, 214, 222)');
        $('#product_qty_label').css('color', 'black');
        $('#product_qty_help_block').html('');
    }

    if (proceed != 0) {

        if ($('#tr_' + product_id).length) {
            var old_qty_unit = $('#tr_' + product_id + ' td:nth-child(2)').text().split(' ');
            var old_qty = parseInt(old_qty_unit[0]);

            var new_quantity = parseInt($('#product_qty').val());

            quantity = parseInt(new_quantity) + parseInt(old_qty);
        } else {
            quantity = parseInt($('#product_qty').val());
        }

        $('#overlay_product').show();
        $.ajax({
            url: '?controller=product&action=checkQtyForPurhase',
            data: {
                'product_id': product_id,
                'quantity': quantity,
            },
            type: 'post',
            success: function (finalQty) {
                finalQty = $.trim(finalQty);
                var data_price = quantity * price;

                var table = $('#products_table').DataTable();

                if (purchase_type == 'Local Purchase') {
                    var old_cgst_val = parseFloat($('#cgst_td').html());
                    var new_cgst_val = (parseFloat(data_price) * parseFloat(cgst)) / 100;
                    var cgst_td_html = old_cgst_val + parseFloat(new_cgst_val);
                    table.cell('#cgst_td').data(cgst_td_html).draw();

                    var old_sgst_val = parseFloat($('#sgst_td').html());
                    var new_sgst_val = (parseFloat(data_price) * parseFloat(sgst)) / 100;
                    var sgst_td_html = old_sgst_val + parseFloat(new_sgst_val);
                    table.cell('#sgst_td').data(sgst_td_html).draw();

                    table.cell('#igst_td').data('0.00').draw();
                } else if (purchase_type == 'Interstate Purchase') {
                    var old_igst_val = parseFloat($('#igst_td').html());
                    var new_igst_val = (parseFloat(data_price) * parseFloat(igst)) / 100;
                    var igst_td_html = old_igst_val + parseFloat(new_igst_val);
                    table.cell('#igst_td').data(igst_td_html).draw();

                    table.cell('#cgst_td').data('0.00').draw();
                    table.cell('#sgst_td').data('0.00').draw();
                }

                if ($('#tr_' + product_id).length) {
                    var table = $('#products_table').DataTable();
                    table.cell('#tr_' + product_id, ':eq(1)').data(product_name + '</br>' + '<font color="green">' + finalQty + ' in stock.').draw();
                    table.cell('#tr_' + product_id, ':eq(2)').data(quantity + ' Nos').draw();
                    table.cell('#tr_' + product_id, ':eq(4)').data(data_price).draw();
                    $('#tr_' + product_id).attr('data-finalqty', finalQty);
                } else {
                    var table = $('#products_table').DataTable();

                    var rowNode = table.row.add([product_id, product_name + '</br>' + '<font color="green">' + finalQty + ' in stock.', quantity + ' Nos', price, data_price, '<a href="" class="delete_product" data-id="' + product_id + '"> <i class="fa fa-fw fa-trash"></i></a>']).draw().node();
                    $(rowNode).attr('id', 'tr_' + product_id);
                    $(rowNode).attr('data-id', product_id);
                    $(rowNode).attr('data-cgst', cgst);
                    $(rowNode).attr('data-sgst', sgst);
                    $(rowNode).attr('data-igst', igst);
                    $(rowNode).attr('data-name', product_name);
                    $(rowNode).attr('data-finalqty', finalQty);
                    $(rowNode).attr('class', 'products');
                }
                $('#products_table_div').fadeIn();

                $('#product_name').val('');
                $('#product_qty').val('');
                $('#product_id').val('');
                $('#cgst').val('');
                $('#sgst').val('');
                $('#igst').val('');
                $('#price').val('');
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

    var purchase_type = $('#purchase_type_id option:selected').text();

    if (purchase_type == 'Local Purchase') {
        table.cell('#igst_td').data('0.00').draw();

        var old_cgst_val = parseFloat('0.00');
        var old_sgst_val = parseFloat('0.00');

        var new_cgst_val = parseFloat(0.00);
        var new_sgst_val = parseFloat(0.00);

        table.rows($("tr[id^='tr_']")).eq(0).each(function (index) {
            var row = table.row(index);

            var data = row.data(); //fetch data of each row
            var data_price = data[4];

            var rowNode = row.node(); //fetch row node

            var data_cgst_per = $(rowNode).attr('data-cgst');
            var data_cgst = (parseFloat(data_price) * parseFloat(data_cgst_per)) / 100;
            new_cgst_val += parseFloat(data_cgst);

            var data_sgst_per = $(rowNode).attr('data-sgst');
            var data_sgst = (parseFloat(data_price) * parseFloat(data_sgst_per)) / 100;
            new_sgst_val += parseFloat(data_sgst);
        });

        var cgst_td_html = old_cgst_val + parseFloat(new_cgst_val);
        table.cell('#cgst_td').data(cgst_td_html).draw();

        var sgst_td_html = old_sgst_val + parseFloat(new_sgst_val);
        table.cell('#sgst_td').data(sgst_td_html).draw();
    } else if (purchase_type == 'Interstate Purchase') {
        table.cell('#cgst_td').data('0.00').draw();
        table.cell('#sgst_td').data('0.00').draw();

        var old_igst_val = parseFloat('0.00');
        var new_igst_val = parseFloat(0.00);

        table.rows($("tr[id^='tr_']")).eq(0).each(function (index) {
            var row = table.row(index);

            var data = row.data(); //fetch data of each row
            var data_price = data[4];

            var rowNode = row.node(); //fetch row node

            var data_igst_per = $(rowNode).attr('data-igst');
            var data_igst = (parseFloat(data_price) * parseFloat(data_igst_per)) / 100;
            new_igst_val += parseFloat(data_igst);
        });

        var igst_td_html = old_igst_val + parseFloat(new_igst_val);
        table.cell('#igst_td').data(igst_td_html).draw();
    }
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
    var target_account = $('#target_account').val();
    var invoice_no = $('#invoice_no').val();

    if ($.trim(invoice_no) == '') {
        $('#valid_invoice_no').val('0');
        $('#invoice_no').css('border-color', '#dd4b39');
        $('#invoice_no_label').css('color', '#dd4b39');
        $('#invoice_no_help_block').html('<font color="#dd4b39">This invoice already exists.</font>');
    } else {
        $('#overlay_invoice').show();
        $('#overlay_product').show();
        $('#overlay_party').show();
        $.ajax({
            url: '?controller=purchase&action=checkInovieExist',
            data: {
                'target_account': target_account,
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
        $('#product_name_label').css('color', '#dd4b39');
        $('#product_name_help_block').html('<font color="#dd4b39">Please Enter Product</font>');
        proceed = 0;
    } else {
        $('#product_name').css('border-color', 'rgb(210, 214, 222)');
        $('#product_name_label').css('color', 'black');
        $('#product_name_help_block').html('');

        $('.products').each(function () {
            var data_id = $(this).attr('data-id');
            var data_name = $(this).attr('data-name');
            var tr_id = $(this).attr('id');
            var qty = $('#' + tr_id + ' td:nth-child(2)').text();
            var data_price = $('#' + tr_id + ' td:nth-child(4)').text();
            var data_cgst = $(this).attr('data-cgst');
            var data_sgst = $(this).attr('data-sgst');
            var data_igst = $(this).attr('data-igst');
            var data_finalqty = $(this).attr('data-finalqty');
            product_details.push(data_id + '_' + data_name + '_' + qty + '_' + data_price + '_' + data_cgst + '_' + data_sgst + '_' + data_igst + '_' + data_finalqty);
        });
        $('#products_data').val(product_details);
        $('#total_cgst').val($('#cgst_td').html());
        $('#total_sgst').val($('#sgst_td').html());
        $('#total_igst').val($('#igst_td').html());
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
            total = api
                    .column(4)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            $('#total_amount').val(total);
            $('#total_amount_span').html(total);

            // Total over this page
            pageTotal = api
                    .column(4, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            // Update footer
            $(api.column(4).footer()).html(
                    'Rs. ' + pageTotal + ' ( Rs. <input type="hidden" id="total_amount" name="total_amount" value="' + total + '">' + total + ' total)'
                    );
        }
    });
});