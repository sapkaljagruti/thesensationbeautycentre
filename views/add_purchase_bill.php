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
                    <h3 class="box-title">Purchase Details</h3>
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
                        <label for="date" class="col-sm-2 control-label">Date</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="date" name="date" placeholder="Date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : $today; ?>" required="required">
                        </div>
                        <label for="invoice_no" class="col-sm-2 control-label">Invoice No</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="invoice_no" name="invoice_no" placeholder="Invoice No" value="<?php echo isset($_POST['invoice_no']) ? $_POST['invoice_no'] : ''; ?>" required="required">
                        </div>
                        <label for="bill_date" class="col-sm-2 control-label">Bill Date</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" id="bill_date" name="bill_date" placeholder="Bill Date" value="<?php echo isset($_POST['bill_date']) ? $_POST['bill_date'] : ''; ?>" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="purchase_type_id" class="col-sm-2 control-label">Purchase Type</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="purchase_type_id" name="purchase_type_id">
                                <?php
                                if (isset($purchase_types)) {
                                    $purchase_type_selected = '';
                                    foreach ($purchase_types as $purchase_type) {
                                        if ($purchase_type_id == $purchase_type['id']) {
                                            $purchase_type_selected = ' selected="selected"';
                                        } else {
                                            $purchase_type_selected = '';
                                        }
                                        ?>
                                        <option value="<?php echo $purchase_type['id']; ?>"<?php echo $purchase_type_selected; ?>><?php echo $purchase_type['title']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <!--                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-sm-10 pull-right">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <a href="?controller=purchasebill&action=getbills" type="button" class="btn btn-default">Cancel</a>
                                        </div>
                                    </div>
                                </div>-->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Party Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body party_detail_form">
                    <input type="hidden" id="party_id" name="party_id" value=""/>
                    <div class="form-group">
                        <label for="party_name" class="col-sm-2 control-label">Party Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="party_name" name="party_name" placeholder="Party Name" value="<?php echo isset($_POST['party_name']) ? $_POST['party_name'] : ''; ?>" required="required" onkeypress="return enterKeyEvent(event)">
                        </div>
                        <label for="contact_person" class="col-sm-2 control-label">Contact Person</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="contact_person" name="contact_person" placeholder="Contact Person" value="<?php echo isset($_POST['contact_person']) ? $_POST['contact_person'] : ''; ?>" required="required">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-2 control-label">Address</label>
                        <div class="col-sm-4">
                            <textarea class="form-control" rows="3" placeholder="Address" id="address" name="address"><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea>
                        </div>
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-4">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile1" class="col-sm-2 control-label">Mobile 1</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mobile1" name="mobile1" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile1']) ? $_POST['mobile1'] : ''; ?>">
                        </div>
                        <label for="mobile2" class="col-sm-2 control-label">Mobile 2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="mobile2" name="mobile2" placeholder="Enter Mobile No" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['mobile2']) ? $_POST['mobile2'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="residence_no" class="col-sm-2 control-label">Residence No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="residence_no" name="residence_no" placeholder="Enter Residence No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off" value="<?php echo isset($_POST['residence_no']) ? $_POST['residence_no'] : ''; ?>">
                        </div>
                        <label for="office_no" class="col-sm-2 control-label">Office No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="office_no" name="office_no" placeholder="Enter Office Contact No" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" value="<?php echo isset($_POST['office_no']) ? $_POST['office_no'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank_name" class="col-sm-2 control-label">Bank Name</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" value="<?php echo isset($_POST['bank_name']) ? $_POST['bank_name'] : ''; ?>">
                        </div>
                        <label for="bank_branch" class="col-sm-2 control-label">Bank Branch</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="bank_branch" name="bank_branch" placeholder="Bank Branch" value="<?php echo isset($_POST['bank_branch']) ? $_POST['bank_branch'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ifsc_code" class="col-sm-2 control-label">IFSC Code</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="Bank IFSC Code" value="<?php echo isset($_POST['ifsc_code']) ? $_POST['ifsc_code'] : ''; ?>">
                        </div>
                        <label for="bank_account_no" class="col-sm-2 control-label">Bank A/C No</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="bank_account_no" name="bank_account_no" placeholder="Bank A/C no" value="<?php echo isset($_POST['bank_account_no']) ? $_POST['bank_account_no'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pan" class="col-sm-2 control-label">PAN</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="pan" name="pan" placeholder="PAN" value="<?php echo isset($_POST['pan']) ? $_POST['pan'] : ''; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gst_type_id" class="col-sm-2 control-label">GST Type</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="gst_type_id" name="gst_type_id">
                                <?php
                                if (isset($gst_types)) {
                                    foreach ($gst_types as $gst_type) {
                                        if (isset($_POST['gst_type_id'])) {
                                            $gst_type_id = $_POST['gst_type_id'];
                                        } else {
                                            $gst_type_id = '3';
                                        }
                                        if ($gst_type_id == $gst_type['id']) {
                                            $gst_type_selected = ' selected="selected"';
                                        } else {
                                            $gst_type_selected = '';
                                        }
                                        ?>
                                        <option value="<?php echo $gst_type['id']; ?>"<?php echo $gst_type_selected; ?>><?php echo $gst_type['title']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <label for="gstin" class="col-sm-2 control-label">GSTIN</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="gstin" name="gstin" placeholder="GSTIN" value="<?php echo isset($_POST['gstin']) ? $_POST['gstin'] : ''; ?>">
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- ./col -->
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">Prodcut Details</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="form-group">
                            <input type="hidden" name="product_id" id="product_id">
                            <input type="hidden" name="price" id="price">
                            <label for="name" class="col-sm-2 control-label"> Product</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="product_name" name="product_name" placeholder="Product Name" value="<?php echo isset($_POST['product_name']) ? $_POST['product_name'] : ''; ?>" required="required" onkeypress="return productEnterKeyEvent(event)">
                            </div>
                            <label for="name" class="col-sm-2 control-label">Quantity</label>
                            <div class="col-sm-2">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="product_qty" name="product_qty" placeholder="Quantity" value="<?php echo isset($_POST['product_qty']) ? $_POST['product_qty'] : ''; ?>" required="required">
                                    <span class="input-group-addon">Nos</span>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" class="btn btn-block btn-info" id="proceed_product"><i class="fa fa-plus"></i> Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="products_table_div">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="products_table" class="table table-bordered table-hover" role="grid" aria-describedby="products_table_info">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Rate Per Unit</th>
                                            <th>Price</th>
                                            <th data-orderable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="5" style="text-align:right">CGST:</td>
                                            <td>0.00</td>
                                            <td>0.00</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align:right">Sub Total:</th>
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
                <!--                <div class="box-footer">
                                    <div class="form-group">
                                        <div class="col-sm-10 pull-right">
                                            <button type="submit" class="btn btn-success">Save</button>
                                            <a href="?controller=purchasebill&action=getbills" type="button" class="btn btn-default">Cancel</a>
                                        </div>
                                    </div>
                                </div>-->
            </div>
            <!-- /.box -->
        </div>
    </div>
</form>