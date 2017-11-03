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
    $('input[name="select_credit_notes[]"]').each(function () {
        this.checked = status;
    });
    $('#delete_selected').attr('disabled', !(status));
});
$(document).on('change', 'input[name="select_credit_notes[]"]', function (e) {
    if (this.checked == false) {
        $(".select-all")[0].checked = false;
    }

    if ($('input[name="select_credit_notes[]"]:checked').length > 0) {
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
                    var table = $('#credit_notes_table').DataTable();
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
        $('input[name="select_credit_notes[]"]:checked').each(function () {
            data_to_delete.push($(this).attr('data-id'));
        });
        $('#loader').show();
        $.ajax({
            url: '?controller=customer&action=deleteCutomer',
            type: "POST",
            data: {'id': data_to_delete},
            dataType: "json",
            success: function (response) {
                var table = $('#credit_notes_table').DataTable();
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
$(document).on('change', '#party_id', function () {
    var party_id = $(this).val();
    if ($.trim(party_id) != '') {
        $('#overlay_party').show();
        $.ajax({
            url: '?controller=party&action=getById',
            data: {
                'id': party_id,
            },
            type: 'post',
            dataType: "json",
            success: function (response) {
                $.each(response, function (item, obj) {
                    for (var key in obj) {
                        $('#party_contact_person').val(obj.contact_person);
                        $('#party_address').val(obj.address);
                        $('#party_email').val(obj.email);
                        $('#party_mobile1').val(obj.mobile1);
                        $('#party_mobile2').val(obj.mobile2);
                        $('#party_residence_no').val(obj.residence_no);
                        $('#party_office_no').val(obj.office_no);
                        $('#party_bank_name').val(obj.bank_name);
                        $('#party_bank_branch').val(obj.bank_branch);
                        $('#party_ifsc_code').val(obj.ifsc_code);
                        $('#party_bank_account_no').val(obj.bank_account_no);
                        $('#party_pan').val(obj.pan);
                        $('#party_gst_state_code_id').val(obj.gst_state_code_id);
                        $('#party_gst_type_id').val(obj.gst_type_id);
                        $('#party_gstin').val(obj.gstin);
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
        $('#party_contact_person').val('');
        $('#party_address').val('');
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
        $('#party_gst_state_code_id').val('');
        $('#party_gst_type_id').val('');
        $('#party_gstin').val('');
    }
});
$('#ledger_name').autocomplete({
    source: function (request, response) {
        $.ajax({
            url: '?controller=sale&action=findLedgerByTerm',
            type: "POST",
            dataType: "json",
            data: {
                term: request.term,
                party_id: $('#party_id').val()
            },
            success: function (data) {
                if (data.length == 0) {
                    $('#sale_voucher_id').val('');
                    $('#sale_party_id').val('');
                }
                response($.map(data, function (item) {
                    return {
                        label: item.ledger_name + ' - ' + item.invoice_no,
                        value: item.ledger_name,
                        id: item.id,
                        party_id: item.party_id
                    }
                }));
            }
        });
    },
    autoFocus: true,
    minLength: 0,
    select: function (event, ui) {
        $('#sale_voucher_id').val(ui.item.id);
        $('#sale_party_id').val(ui.item.party_id);
    }
});
$("#ledger_name").autocomplete("option", "appendTo", ".eventInsForm");

$(document).on('keyup', '#ledger_name', function () {
    if ($(this).val() == '') {
        $('#sale_voucher_id').val('');
        $('#sale_party_id').val('');
    } else {
        var ledger_name = $.trim($(this).val());
        var party_id = $('#party_id').val();
        $('#overlay_particular').show();
        $.ajax({
            url: '?controller=sale&action=checkLedgerNameExist',
            data: {
                'ledger_name': ledger_name,
                'party_id': party_id,
            },
            type: 'post',
            success: function (response) {
                if (response == '1') {

                } else {
                    $(this).val('');
                    $('#sale_voucher_id').val('');
                    $('#sale_party_id').val('');
                }
            },
            error: function (xhr, status, error) {
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('#overlay_particular').hide();
            }
        });
    }
});
function enterKeyEvent(e) {
    if (e.keyCode == 13) {
        var sale_voucher_id = $.trim($('#sale_voucher_id').val());
        if (sale_voucher_id == '') {
            $('#ledger_name').val('');
            $('#sale_party_id').val('');
            $('#amount').val('');
        }
    }
}

$(document).on('focusout', '#ledger_name', function (e) {
    var sale_voucher_id = $.trim($('#sale_voucher_id').val());
    if (sale_voucher_id == '') {
        $('#ledger_name').val('');
        $('#sale_party_id').val('');
        $('#amount').val('');
    }
});

$(document).on('click', '#proceed_particular', function () {
    var proceed = 1;
    var ledger_name = $('#ledger_name').val();
    var sale_voucher_id = $('#sale_voucher_id').val();
    var amount = $('#amount').val();
    if (ledger_name == '') {
        $('#ledger_name').css('border-color', '#dd4b39');
        $('#ledger_name_label').css('color', '#dd4b39');
        $('#ledger_name_help_block').html('<font color="#dd4b39">Please Enter Particular</font>');
        proceed = 0;
    } else {
        if (sale_voucher_id == '') {
            $('#ledger_name').css('border-color', '#dd4b39');
            $('#ledger_name_label').css('color', '#dd4b39');
            $('#ledger_name_help_block').html('<font color="#dd4b39">Sales Ledger Not Found</font>');
            proceed = 0;
        } else {
            $('#ledger_name').css('border-color', 'rgb(210, 214, 222)');
            $('#ledger_name_label').css('color', 'black');
            $('#ledger_name_help_block').html('');
        }
    }

    if (amount == '') {
        $('#amount').css('border-color', '#dd4b39');
        $('#amount_label').css('color', '#dd4b39');
        $('#amount_help_block').html('<font color="#dd4b39">Please Enter Amount</font>');
        proceed = 0;
    } else {
        $('#amount').css('border-color', 'rgb(210, 214, 222)');
        $('#amount_label').css('color', 'black');
        $('#amount_help_block').html('');
    }

    if (proceed != 0) {

        var new_amount = 0.00;

        if ($('#tr_' + sale_voucher_id).length) {
            var old_amount = $('#tr_' + sale_voucher_id + ' td:nth-child(2)').text();
            new_amount = parseFloat(old_amount) + parseInt(amount);
        } else {
            new_amount = parseInt(amount);
        }

        if ($('#tr_' + sale_voucher_id).length) {
            var table = $('#particulars_table').DataTable();
            table.cell('#tr_' + sale_voucher_id, ':eq(1)').data(ledger_name).draw();
            table.cell('#tr_' + sale_voucher_id, ':eq(2)').data(new_amount).draw();
            $('#tr_' + sale_voucher_id).attr('data-amount', new_amount);
        } else {
            var table = $('#particulars_table').DataTable();
            var rowNode = table.row.add([sale_voucher_id, ledger_name, new_amount, '<a href="" class="delete_particular" data-id="' + sale_voucher_id + '"> <i class="fa fa-fw fa-trash"></i></a>']).draw().node();
            $(rowNode).attr('id', 'tr_' + sale_voucher_id);
            $(rowNode).attr('data-id', sale_voucher_id);
            $(rowNode).attr('data-amount', new_amount);
            $(rowNode).attr('class', 'particulars');
        }

        $('#particulars_table_div').fadeIn();
        $('#ledger_name').val('');
        $('#amount').val('');
        $('#sale_voucher_id').val('');
        $('#sale_party_id').val('');
    }
});

$(document).on('click', '.delete_particular', function (e) {
    e.preventDefault();
    var data_id = $(this).attr('data-id');
    var table = $('#particulars_table').DataTable();
    table.row($('#tr_' + data_id)).remove().draw(false);
    $('#ledger_name').val('');
    $('#amount').val('');
    $('#sale_voucher_id').val('');
    $('#sale_party_id').val('');
});

$(document).on('focusout', '#credit_note_no', function () {
    var credit_note_no = $('#credit_note_no').val();

    if ($.trim(credit_note_no) == '') {
        $('#valid_credit_note_no').val('0');
        $('#credit_note_no').css('border-color', '#dd4b39');
        $('#credit_note_no_label').css('color', '#dd4b39');
        $('#credit_note_no_help_block').html('<font color="#dd4b39">Please enter Credit Note No</font>');
    } else {
        $('#overlay_invoice').show();
        $('#overlay_particular').show();
        $('#overlay_party').show();
        $.ajax({
            url: '?controller=creditnotes&action=checkCreditNoteExist',
            data: {
                'credit_note_no': credit_note_no
            },
            type: 'post',
            success: function (response) {
                response = $.trim(response);
                if (response == '1') {
                    $('#valid_credit_note_no').val('0');
                    $('#credit_note_no').css('border-color', '#dd4b39');
                    $('#credit_note_no_label').css('color', '#dd4b39');
                    $('#credit_note_no_help_block').html('<font color="#dd4b39">This credit note already exists.</font>');
                } else {
                    $('#valid_credit_note_no').val('1');
                    $('#credit_note_no').css('border-color', 'rgb(210, 214, 222)');
                    $('#credit_note_no_label').css('color', 'black');
                    $('#credit_note_no_help_block').html('');
                }
            },
            error: function (xhr, status, error) {
                showError('Something went wrong. Please try again later.', 5000);
            },
            complete: function () {
                $('#overlay_invoice').hide();
                $('#overlay_particular').hide();
                $('#overlay_party').hide();
            }
        });
    }
});

$(document).on('submit', 'form', function () {
    var proceed = 1;
    var sales_invoice_data = [];

    var valid_credit_note_no = $('#valid_credit_note_no').val();

    if (valid_credit_note_no == '0') {
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

    if (!($('.particulars').length)) {
        $('#ledger_name').css('border-color', '#dd4b39');
        $('#ledger_name_label').css('color', '#dd4b39');
        $('#ledger_name_help_block').html('<font color="#dd4b39">Please Enter Particular</font>');
        proceed = 0;
    } else {
        $('#ledger_name').css('border-color', 'rgb(210, 214, 222)');
        $('#ledger_name_label').css('color', 'black');
        $('#ledger_name_help_block').html('');

        $('.particulars').each(function () {
            var data_id = $(this).attr('data-id');
            var data_amount = $(this).attr('data-amount');
            sales_invoice_data.push(data_id + '_' + data_amount);
        });
        $('#sales_invoice_data').val(sales_invoice_data);
    }

    if (proceed != 0) {
        return true;
    } else {
        return false;
    }
});

$(function () {

    $("#date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
    $('#delete_selected').attr('disabled', true);
    var t = $('#credit_notes_table').DataTable({
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
$(function () {
    var t1 = $('#particulars_table').DataTable({
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
                    .column(2)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            // Total over this page
            pageTotal = api
                    .column(2, {page: 'current'})
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            // Update footer
            $(api.column(2).footer()).html(
                    'Rs. ' + pageTotal + ' ( Rs. <input type="hidden" id="total_amount" name="total_amount" value="' + total + '">' + total + ' total)'
                    );
        }
    });
});
