<style>
    #party_pan, #party_gstin {
        text-transform: uppercase;
    }
</style>
<?php
if (isset($errors)) {
    ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        <ul>
            <?php
            foreach ($errors as $error) {
                echo "<li>" . $error . "</li>";
            }
            ?>
        </ul>
    </div>
    <?php
}
?>

<link rel="stylesheet" href="public/plugins/jQueryUI/jquery-ui.css">
<style>
    .loadinggif 
    {
        background:
            url('public/images/loader.gif')
            no-repeat
            right center;
    }
</style>
<style>
    .table-responsive { overflow-x: initial; }
</style>
<!-- form start -->
<form class="form-horizontal" method="post">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title"><b>Journal No: <?php echo $journal_no; ?></b></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="form-group">
                        <?php
                        $today = date('d-m-Y');
                        ?>
                        <label for="date" class="col-sm-2 control-label" id="date_label">Date</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="date" name="date" placeholder="Date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : $today; ?>" required="required">
                            <span id="date_help_block" class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="narration" class="col-sm-2 control-label">Narration</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" placeholder="Narration" id="narration" name="narration"><?php echo isset($_POST['narration']) ? $_POST['narration'] : ''; ?></textarea>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div id="overlay_invoice" class="overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Particulars</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-1 control-label"></label>
                            <div class="col-sm-1">
                                <select class="form-control" id="entry_type" name="entry_type">
                                    <option value="dr" id="dr_val">Dr</option>
                                    <option value="cr" id="cr_val" disabled="disabled">Cr</option>
                                </select>
                            </div>
                            <input type="hidden" id="ledger_id" name="ledger_id" value="">
                            <label for="ledger_name" class="col-sm-2 control-label" id="ledger_name_label"> Account</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="ledger_name" name="ledger_name" placeholder="Account" value="<?php echo isset($_POST['ledger_name']) ? $_POST['ledger_name'] : ''; ?>" onkeypress="return enterKeyEvent(event)">
                                <span id="ledger_name_help_block" class="help-block"></span>
                            </div>
                            <label for="amount" class="col-sm-2 control-label" id="amount_label">Amount</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control decimal" id="amount" name="amount" placeholder="Amount" value="" onkeypress="return allowOnlyNumberWithDecimal(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                                <span id="amount_help_block" class="help-block"></span>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-block btn-info" id="proceed_particular"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="particulars_table_div">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="particulars_table" class="table table-bordered table-hover" role="grid" aria-describedby="particulars_table_info">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Account</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
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
                                        </tr>
                                        <tr>
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
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th style="text-align:right">Total:</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div id="overlay_product" class="overlay" style="display: none;">
                    <i class="fa fa-refresh fa-spin"></i>
                </div>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <textarea style="display: none;" name="entry_data" id="entry_data"></textarea>
            <a type="button" class="btn btn-danger" href="?controller=journal&action=getall">
                <i class="fa fa-fw fa-arrow-circle-left"></i> Cancel
            </a>
            <button type="submit" id="save" class="btn btn-success pull-right">
                <i class="fa fa-credit-card"></i> Save
            </button>
        </div>
    </div>
</form>