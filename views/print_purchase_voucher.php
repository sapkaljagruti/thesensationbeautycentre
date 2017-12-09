<html>
    <head>
        <!-- Bootstrap 3.3.6 -->
        <link href="public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="public/plugins/datatables/dataTables.bootstrap.css">
        <style>
            body{
                font-family: "Arial", Arial, "Helvetica Condensed", Helvetica, sans-serif;
                /*font-weight: normal;*/
                /*font-size: 8px;*/
            }
            p{
                margin-top: 0;
                margin-bottom: 0;
            }
            img{
                width: 60%;
                height: 20%;
            }
            table{
                /*font-family: 'Courier New', monospace;*/
                font-weight: bold;
                font-size: 10px;
            }
        </style>
    </head>
    <body>
        <!--<body onload="window.print()">-->
        <?php
        if (!empty($purchase_voucher_data)) {
            require_once 'libraries/CommonFunctions.php';
            $commonfunobj = new CommonFunctions();
            foreach ($purchase_voucher_data as $purchase_voucher) {
                ?>
            <center>
                <table class="table table-bordered table-hover" role="grid">
                    <tbody>
                        <tr>
                            <td colspan="16" style="text-align: center;"><p style=" font-size: 25px;"><b><?php echo $purchase_voucher['party_name']; ?></b></p><p><b>Area: </b><?php echo $purchase_voucher['area']; ?> <b>City: </b><?php echo $purchase_voucher['city']; ?> <b>Pincode: </b><?php echo $purchase_voucher['pincode']; ?> <b>State: </b><?php echo $purchase_voucher['state']; ?> <b>Code: </b><?php echo $purchase_voucher['party_gst_state_code_id']; ?></p><p><b>Contact Person: </b><?php echo $purchase_voucher['contact_person']; ?> <b>Email: </b><?php echo $purchase_voucher['email']; ?> <b>Mobile1: </b><?php echo $purchase_voucher['mobile1']; ?> <b>Mobile2: </b><?php echo $purchase_voucher['mobile2']; ?> </p><p><b>GSTIN: </b><?php echo $purchase_voucher['party_gstin']; ?><b>PAN: </b><?php echo $purchase_voucher['party_pan']; ?><b>Invoice NO: </b><?php echo $purchase_voucher['invoice_no']; ?></p></td>
                        </tr>
                        <tr>
                            <td colspan="16"><p><b>To: THE SENSATION BEAUTY CENTRE</b></p><p><b>Area: </b>Vapi <b>City: </b> Vapi <b>Pincode: </b>396191 <b>State: </b>Gujarat <b>Code: </b>24</p><p><b>Contact Person: </b>Nilesh Gajjar <b>Email: </b>lakha.vapi@gmail.com <b>Mobile1: </b>7228931701 <b>Mobile2: </b>7228931701 </p><p><b>GSTIN: </b>24AGUPS7737CZW<b> PAN: </b>AGUPS7737C</p></td>
                        </tr>
                        <tr>
                            <td colspan="16" style=" padding: 0 !important;margin: 0 !important;">
                                <table class="table table-bordered table-hover" role="grid" style="table-layout: fixed; margin-top: -2px !important; margin-bottom: -2px !important;" id="products_table">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%;">Sr</th>
                                            <th style="width: 17%;">Item Name</th>
                                            <th style="width: 8%;">HSN Code</th>
                                            <th style="width: 7%;">MRP</th>
                                            <th style="width: 5%;">Qty</th>
                                            <th style="width: 7%;">Rate</th>
                                            <th style="width: 4%;">Disc %</th>
                                            <th style="width: 7%;">Disc Rs</th>
                                            <th style="width: 5%;">CGST %</th>
                                            <th style="width: 7%;">CGST Rs</th>
                                            <th style="width: 4%;">SGST %</th>
                                            <th style="width: 7%;">SGST Rs</th>
                                            <th style="width: 4%;">IGST %</th>
                                            <th style="width: 7%;">IGST Rs</th>
                                            <th style="width: 8%;">AmtRs</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $products_data = $purchase_voucher['products_data'];
                                        $products_data_arr = explode(',', $products_data);
                                        $i = 0;
                                        foreach ($products_data_arr as $product) {
                                            $i++;
                                            $product_arr = explode('_', $product);
                                            $product_id = $product_arr[0];
                                            $target_account_id = $product_arr[1];

                                            if (isset($target_accounts)) {
                                                foreach ($target_accounts as $target_account) {
                                                    if ($target_account_id == $target_account['id']) {
                                                        $target_account_name = $target_account['name'];
                                                    }
                                                }
                                            }

                                            $product_name = $product_arr[2];
                                            $hsn_code = $product_arr[3];
                                            $mrp = $product_arr[4];
                                            $qty = $product_arr[5];
                                            $final_updated_qty = $product_arr[6];
                                            $price = $product_arr[7];
                                            $discount_percentage = $product_arr[8];
                                            $discount_rs = $product_arr[9];
                                            $cgst_percentage = $product_arr[10];
                                            $cgst_rs = $product_arr[11];
                                            $sgst_percentage = $product_arr[12];
                                            $sgst_rs = $product_arr[13];
                                            $igst_percentage = $product_arr[14];
                                            $igst_rs = $product_arr[15];
                                            $total_amount = $product_arr[16];
                                            ?>
                                            <tr style="font-size: 10px;">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $product_name; ?></td>
                                                <td><?php echo $hsn_code; ?></td>
                                                <td><?php echo $mrp; ?></td>
                                                <td><?php echo $qty; ?></td>
                                                <td><?php echo $price; ?></td>
                                                <td><?php echo $discount_percentage; ?></td>
                                                <td><?php echo $discount_rs; ?></td>
                                                <td><?php echo $cgst_percentage; ?></td>
                                                <td><?php echo $cgst_rs; ?></td>
                                                <td><?php echo $sgst_percentage; ?></td>
                                                <td><?php echo $sgst_rs; ?></td>
                                                <td><?php echo $igst_percentage; ?></td>
                                                <td><?php echo $igst_rs; ?></td>
                                                <td><?php echo $total_amount; ?></td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="3" style="text-align:right">Total:</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="16"></td>
                        </tr>
                        <tr>
                            <td colspan="16"></td>
                        </tr>
                        <tr>
                            <td colspan="16"><p><b>Bank Name: </b>Bank Of Baroda</p><p><b>Bank Branch: </b>Vapi </p><p><b>IFSC Code: </b>Vapi001</p><p><b>Bank A/C No: </b>123466879647867</p></td>
                        </tr>
                        <?php
                        $bill_amount = round($purchase_voucher['total_bill_amount']);
                        $bill_amount_in_words = $commonfunobj->getPriceInWords($bill_amount);
                        ?>
                        <tr>
                            <td colspan="16" style="font-size: 12px;"><b>Bill Amount: Rs. <?php echo $bill_amount; ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="16" style="font-size: 12px;"><b>Bill Amount In Words: <?php echo ucwords($bill_amount_in_words) . ' Only'; ?></b></td>
                        </tr>
                        <tr>
                            <td colspan="16">
                                <p><u><b>Terms And Conditions:</b></u></p>
                                <p>1. Payments to be made in advanced by a/c payee's cheques.</p>
                                <p>2. Cheque returns charges Rs. 500.00</p>
                                <p>3. We will charge 24% Interest P.a. after 21 Days.</p>
                                <p>4. Subject To Vapi Jurisdiction.</p>
                                <p><b>Bank Name: </b><?php echo ucwords($purchase_voucher['party_bank_name']); ?></p><p><b>Bank Branch: </b><?php echo $purchase_voucher['party_bank_branch']; ?> </p><p><b>IFSC Code: </b><?php echo $purchase_voucher['party_ifsc_code']; ?></p><p><b>Bank A/C No: </b><?php echo $purchase_voucher['party_bank_account_no']; ?></p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </center>
            <?php
        }
    }
    ?>
    <script src="public/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="public/plugins/jQueryUI/jquery-ui.js"></script>
    <script src="public/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="public/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script>
        $(document).ready(function () {
            var t = $('#products_table').DataTable({
                "paging": false,
                "bInfo": false,
                "lengthChange": true,
                "lengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
                "searching": false,
                "ordering": false,
                "order": [[0, "desc"]],
                "info": true,
                "autoWidth": false,
                "aaSorting": [],
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
                            .column(3)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_qty = api
                            .column(4)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);

                    var total_rate_per_unit = api
                            .column(5)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_discount_percentage = api
                            .column(6)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_discount_rs = api
                            .column(7)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_cgst_percentage = api
                            .column(8)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_cgst_rs = api
                            .column(9)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_sgst_percentage = api
                            .column(10)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_sgst_rs = api
                            .column(11)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_igst_percentage = api
                            .column(12)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_igst_rs = api
                            .column(13)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    var total_price = api
                            .column(14)
                            .data()
                            .reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                    total_price = parseFloat(Math.round(total_price * 100) / 100).toFixed(2);

                    // Update footer
                    $(api.column(3).footer()).html(total_mrp);
                    $(api.column(4).footer()).html(total_qty);
                    $(api.column(5).footer()).html(total_rate_per_unit);
                    $(api.column(6).footer()).html(total_discount_percentage);
                    $(api.column(7).footer()).html(total_discount_rs);
                    $(api.column(8).footer()).html(total_cgst_percentage);
                    $(api.column(9).footer()).html(total_cgst_rs);
                    $(api.column(10).footer()).html(total_sgst_percentage);
                    $(api.column(11).footer()).html(total_sgst_rs);
                    $(api.column(12).footer()).html(total_igst_percentage);
                    $(api.column(13).footer()).html(total_igst_rs);
                    $(api.column(14).footer()).html(total_price);
                }
            });
        });
    </script>
</body>
</html>