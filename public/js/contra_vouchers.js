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

function isValidDate(str) {
    var m = str.match(/^(\d{1,2})-(\d{1,2})-(\d{4})$/);
    return (m) ? new Date(m[3], m[2] - 1, m[1]) : null;
}

$(document).on('change', '.select-all', function (e) {
    var status = this.checked;
    $('input[name="select_contra_vouchers[]"]').each(function () {
        this.checked = status;
    });
    $('#delete_selected').attr('disabled', !(status));
});

$(document).on('change', 'input[name="select_contra_vouchers[]"]', function (e) {
    if (this.checked == false) {
        $(".select-all")[0].checked = false;
    }

    if ($('input[name="select_contra_vouchers[]"]:checked').length > 0) {
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
                    var table = $('#contra_vouchers_table').DataTable();
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
        $('input[name="select_contra_vouchers[]"]:checked').each(function () {
            data_to_delete.push($(this).attr('data-id'));
        });
        $('#loader').show();
        $.ajax({
            url: '?controller=customer&action=deleteCutomer',
            type: "POST",
            data: {'id': data_to_delete},
            dataType: "json",
            success: function (response) {
                var table = $('#contra_vouchers_table').DataTable();
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

    $("#date").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
    $('#delete_selected').attr('disabled', true);

    var t = $('#contra_vouchers_table').DataTable({
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

$(document).on('change', '#ledger_name', function () {
    var ledger_id = $(this).val();
    if ($('#tr_' + ledger_id).length) {
        $(this).val('');
    }
});

$(document).on('click', '#proceed_particular', function () {
    var proceed = 1;

    var total_debit_amount = $('#total_debit_amount').val();
    var total_credit_amount = $('#total_credit_amount').val();

    if (total_debit_amount != '0' && total_credit_amount != '0') {
        if (total_debit_amount == total_credit_amount) {
            proceed = 0;
        }
    }

    var ledger_id = $('#ledger_name').val();
    var ledger_name = $('#ledger_name').find('option:selected').text();

    if ($('#amount').val() == '') {
        $('#amount').css('border-color', '#dd4b39');
        $('#amount_label').css('color', '#dd4b39');
        $('#amount_help_block').html('<font color="#dd4b39">Please Enter Amount</font>');
        proceed = 0;
    } else {
        var amount = parseFloat($('#amount').val());
        $('#amount').css('border-color', 'rgb(210, 214, 222)');
        $('#amount_label').css('color', 'black');
        $('#amount_help_block').html('');
    }

    var entry_type = $('#entry_type').val();

    if (ledger_id == '') {
        $('#ledger_name').css('border-color', '#dd4b39');
        $('#ledger_name_label').css('color', '#dd4b39');
        $('#ledger_name_help_block').html('<font color="#dd4b39">Please select account</font>');
        proceed = 0;
    } else {
        $('#ledger_name').css('border-color', 'rgb(210, 214, 222)');
        $('#ledger_name_label').css('color', 'black');
        $('#ledger_name_help_block').html('');
    }

    if (amount == '') {
        $('#amount').css('border-color', '#dd4b39');
        $('#amount_label').css('color', '#dd4b39');
        $('#amount_help_block').html('<font color="#dd4b39">Please Enter Amount</font>');
        proceed = 0;
    } else {
        var new_total_debit_amount = parseFloat(total_debit_amount) + parseFloat(amount);
        if (total_credit_amount != '0') {
            if (new_total_debit_amount > total_credit_amount) {
                proceed = 0;
                $('#amount').css('border-color', '#dd4b39');
                $('#amount_label').css('color', '#dd4b39');
                $('#amount_help_block').html('<font color="#dd4b39">Total debit amount is increasing.</font>');
            } else {
                $('#amount').css('border-color', 'rgb(210, 214, 222)');
                $('#amount_label').css('color', 'black');
                $('#amount_help_block').html('');
            }
        }
    }

    if (proceed != 0) {
        var table = $('#particulars_table').DataTable();

        var cr_td_val = '';
        var dr_td_val = '';

        if (entry_type == 'cr') {
            cr_td_val = amount;
        } else if (entry_type == 'dr') {
            dr_td_val = amount;
        }

        var rowNode = table.row.add([ledger_id, ledger_name, dr_td_val, cr_td_val]).draw().node();

        $(rowNode).attr('id', 'tr_' + ledger_id);
        $(rowNode).attr('data-type', entry_type);
        $(rowNode).attr('data-id', ledger_id);
        $(rowNode).attr('data-amount', amount);
        $(rowNode).attr('class', 'particulars');

        $('#ledger_name').val('');
        $('#amount').val('');
        $('#cr_val').attr('disabled', 'disabled');
        $('#dr_val').removeAttr('disabled');
        $('#entry_type').val('dr');

        if (total_debit_amount != '0' && total_credit_amount != '0') {
            if (total_debit_amount == total_credit_amount) {
                $('#proceed_particular').attr('disabled', 'disabled');
            }
        }
    }
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
            debit_total = api
                    .column(2)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            credit_total = api
                    .column(3)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

            // Update footer
            $(api.column(2).footer()).html(
                    ' <input type="hidden" id="total_debit_amount" name="total_debit_amount" value="' + debit_total + '">' + debit_total
                    );

            $(api.column(3).footer()).html(
                    ' <input type="hidden" id="total_credit_amount" name="total_credit_amount" value="' + credit_total + '">' + credit_total
                    );
        }
    });
});

$(document).on('submit', 'form', function () {
    var proceed = 1;
    var entry_data = [];

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
        var total_debit_amount = $('#total_debit_amount').val();
        var total_credit_amount = $('#total_credit_amount').val();

        if (total_debit_amount != '0' && total_credit_amount != '0') {
            if (total_debit_amount != total_credit_amount) {
                $('#ledger_name').css('border-color', '#dd4b39');
                $('#ledger_name_label').css('color', '#dd4b39');
                $('#ledger_name_help_block').html('<font color="#dd4b39">Missing one entry.</font>');
                proceed = 0;
            } else {
                $('#ledger_name').css('border-color', 'rgb(210, 214, 222)');
                $('#ledger_name_label').css('color', 'black');
                $('#ledger_name_help_block').html('');

                $('.particulars').each(function () {
                    var data_type = $(this).attr('data-type');
                    var data_id = $(this).attr('data-id');
                    var data_amount = $(this).attr('data-amount');
                    entry_data.push(data_type + '_' + data_id + '_' + data_amount);
                });
                $('#entry_data').val(entry_data);
            }
        }
    }

    if (proceed != 0) {
        return true;
    } else {
        return false;
    }
});
