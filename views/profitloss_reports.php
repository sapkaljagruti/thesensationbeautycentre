<?php
require_once 'libraries/CommonFunctions.php';
$commonfunobj = new CommonFunctions();
?>
<link rel="stylesheet" href="public/plugins/jQueryUI/jquery-ui.css">
<!-- daterange picker -->
<link rel="stylesheet" href="public/plugins/daterangepicker/daterangepicker.css">
<style>
    .loadinggif 
    {
        background:
            url('public/images/loader.gif')
            no-repeat
            right center;
    }

    .table-responsive { overflow-x: initial; }
</style>

<div class="alert alert-dismissible" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4></h4><p></p>
</div>

<div class="row" style="padding: 10px 0;">
    <div class="col-md-3 pull-left">
        <div class="input-group" id="from_date_div">
            <input type="text" class="form-control" id="from_date" name="from_date" placeholder="Enter From Date" oncopy="return false;" onpaste="return false;" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" autocomplete="off" value="" maxlength="20">
            <div class="input-group-addon" id="from_date_addon">
                <i class="fa fa-calendar" id="from_date_cal"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 pull-left">
        <div class="input-group" id="to_date_div">
            <input type="text" class="form-control" id="to_date" name="to_date" placeholder="Enter To Date" oncopy="return false;" onpaste="return false;" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask="" autocomplete="off" value="" maxlength="20">
            <div class="input-group-addon" id="to_date_addon">
                <i class="fa fa-calendar" id="to_date_cal"></i>
            </div>
        </div>
    </div>
    <div class="col-md-2 pull-left">
        <button type="button" class="btn btn-block btn-primary" id="delete_selected">Proceed</button>
    </div>
</div>

<!-- /.row -->
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <?php
                                $total_sales_amount_arr = explode('.', $commonfunobj->moneyFormatIndia($total_sales_amount));
                                $total_sales_amount_1 = $total_sales_amount_arr[0];
                                $total_sales_amount_2 = $total_sales_amount_arr[1];
                                $total_sales_amount = rtrim($total_sales_amount_1, ',') . '.' . rtrim($total_sales_amount_2, ',');

                                $total_purchase_amount_arr = explode('.', $commonfunobj->moneyFormatIndia($total_purchase_amount));
                                $total_purchase_amount_1 = $total_purchase_amount_arr[0];
                                $total_purchase_amount_2 = $total_purchase_amount_arr[1];
                                $total_purchase_amount = rtrim($total_purchase_amount_1, ',') . '.' . rtrim($total_purchase_amount_2, ',');

                                $equal_amount_arr = explode('.', $commonfunobj->moneyFormatIndia($equal_amount));
                                $equal_amount_1 = $equal_amount_arr[0];
                                $equal_amount_2 = $equal_amount_arr[1];
                                $equal_amount = rtrim($equal_amount_1, ',') . '.' . rtrim($equal_amount_2, ',');

                                $total_direct_expenses_arr = explode('.', $commonfunobj->moneyFormatIndia($total_direct_expenses));
                                $total_direct_expenses_1 = $total_direct_expenses_arr[0];
                                $total_direct_expenses_2 = $total_direct_expenses_arr[1];
                                $total_direct_expenses = rtrim($total_direct_expenses_1, ',') . '.' . rtrim($total_direct_expenses_2, ',');

                                $profit_loss_amt_arr = explode('.', $commonfunobj->moneyFormatIndia($profit_loss_amt));
                                $profit_loss_amt_1 = $profit_loss_amt_arr[0];
                                $profit_loss_amt_2 = $profit_loss_amt_arr[1];
                                $profit_loss_amt = rtrim($profit_loss_amt_1, ',') . '.' . rtrim($profit_loss_amt_2, ',');

                                $total_indirect_expenses_arr = explode('.', $commonfunobj->moneyFormatIndia($total_indirect_expenses));
                                $total_indirect_expenses_1 = $total_indirect_expenses_arr[0];
                                $total_indirect_expenses_2 = $total_indirect_expenses_arr[1];
                                $total_indirect_expenses = rtrim($total_indirect_expenses_1, ',') . '.' . rtrim($total_indirect_expenses_2, ',');

                                $total_indirect_incomes_arr = explode('.', $commonfunobj->moneyFormatIndia($total_indirect_incomes));
                                $total_indirect_incomes_1 = $total_indirect_incomes_arr[0];
                                $total_indirect_incomes_2 = $total_indirect_incomes_arr[1];
                                $total_indirect_incomes = rtrim($total_indirect_incomes_1, ',') . '.' . rtrim($total_indirect_incomes_2, ',');

                                $new_profit_loss_amt_arr = explode('.', $commonfunobj->moneyFormatIndia($new_profit_loss_amt));
                                $new_profit_loss_amt_1 = $new_profit_loss_amt_arr[0];
                                $new_profit_loss_amt_2 = $new_profit_loss_amt_arr[1];
                                $new_profit_loss_amt = rtrim($new_profit_loss_amt_1, ',') . '.' . rtrim($new_profit_loss_amt_2, ',');

                                $new_equal_amount_arr = explode('.', $commonfunobj->moneyFormatIndia($new_equal_amount));
                                $new_equal_amount_1 = $new_equal_amount_arr[0];
                                $new_equal_amount_2 = $new_equal_amount_arr[1];
                                $new_equal_amount = rtrim($new_equal_amount_1, ',') . '.' . rtrim($new_equal_amount_2, ',');
                                ?>
                                <th style="font-size: 16px;">Particular <span class="pull-right" style="font-weight: 100;"><?php echo $start_date_to_print; ?> To <?php echo $end_date_to_print; ?></span></th>
                                <th style="font-size: 16px;">Particular <span class="pull-right" style="font-weight: 100;"><?php echo $start_date_to_print; ?> To <?php echo $end_date_to_print; ?></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <b>Purchase Accounts <span class="pull-right"><?php echo $total_purchase_amount; ?></span></b>
                                </td>
                                <td>
                                    <b>Sales Accounts <span class="pull-right"><?php echo $total_sales_amount; ?></span></b>
                                    <!--<p><i>Local Sales</i> <span style="font-weight: 100; margin-left: 50%;"><i>1,52,220.90</i></span></p>-->
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Direct Expenses<span class="pull-right"><?php echo $total_direct_expenses; ?></span></b>
                                </td>
                                <td>
                                    <b>Direct Incomes<span class="pull-right"><?php echo $total_direct_incomes; ?></span></b>
                                </td>
                            </tr>
                            <?php
                            if ($profit_loss == ' Profit') {
                                ?>
                                <tr>
                                    <td>
                                        <b>Gross Profit c/o<span class="pull-right"><?php echo $profit_loss_amt; ?></span></b>
                                    </td>
                                    <td></td>
                                </tr>
                                <?php
                            } else if ($profit_loss == ' Loss') {
                                ?>
                                <tr>
                                    <td></td>
                                    <td>
                                        <b>Gross Loss c/o<span class="pull-right"><?php echo $profit_loss_amt; ?></span></b>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><b>Total<span class="pull-right"><?php echo $equal_amount; ?></span></b></td>
                                <td><b>Total<span class="pull-right"><?php echo $equal_amount; ?></span></b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Indirect Expenses<span class="pull-right"><?php echo $total_indirect_expenses; ?></span></b>
                                </td>
                                <td>
                                    <b>Indirect Incomes<span class="pull-right"><?php echo $total_indirect_incomes; ?></span></b>
                                </td>
                            </tr>
                            <?php
                            if ($profit_loss == ' Profit') {
                                ?>
                                <tr>
                                    <td></td>
                                    <td><b>Gross Profit b/f<span class="pull-right"><?php echo $profit_loss_amt; ?></span></b></td>
                                </tr>
                                <?php
                            } else if ($profit_loss == ' Loss') {
                                ?>
                                <tr>
                                    <td><b>Gross Loss b/f<span class="pull-right"><?php echo $profit_loss_amt; ?></span></b></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <?php
                            if ($net_profit_loss == ' Profit') {
                                ?>
                                <tr>
                                    <td>
                                        <b>Net Profit<span class="pull-right"><?php echo $new_profit_loss_amt; ?></span></b>
                                    </td>
                                    <td></td>
                                </tr>
                                <?php
                            } else if ($net_profit_loss == ' Loss') {
                                ?>
                                <tr>
                                    <td></td>
                                    <td>
                                        <b>Net Loss<span class="pull-right"><?php echo $new_profit_loss_amt; ?></span></b>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px;">
                                    <b>Total <span class="pull-right"><?php echo $new_equal_amount; ?></span></b>
                                </td>
                                <td style="font-size: 16px;">
                                    <b>Total <span class="pull-right"><?php echo $new_equal_amount; ?></span></b>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
</div>