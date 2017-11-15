<style>
    #pan, #gstin {
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

<?php
if (isset($account_groups)) {
    foreach ($account_groups as $account_group) {
        ?>
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Account Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove" id="close_detail_btn"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>Party Name</b></td>
                                            <td><?php echo $account_group['name']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>Under Group</b></td>
                                            <td><?php echo $account_group['parent']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>Opening Balance</b></td>
                                            <td><?php echo $account_group['opening_balance']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Mailing Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove" id="close_detail_btn"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>Contact Person</b></td>
                                            <td><?php echo $account_group['contact_person']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Area</b></td>
                                            <td><?php echo $account_group['area']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Pincode</b></td>
                                            <td><?php echo $account_group['pincode']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Mobile 1</b></td>
                                            <td><?php echo $account_group['mobile1']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>Email</b></td>
                                            <td><?php echo $account_group['email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>City</b></td>
                                            <td><?php echo $account_group['city']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>State</b></td>
                                            <td><?php echo $account_group['state']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Mobile 2</b></td>
                                            <td><?php echo $account_group['mobile2']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Bank Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove" id="close_detail_btn"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>Bank Name</b></td>
                                            <td><?php echo $account_group['bank_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>IFSC Code</b></td>
                                            <td><?php echo $account_group['ifsc_code']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>Bank Branch</b></td>
                                            <td><?php echo $account_group['bank_branch']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Bank A/C No</b></td>
                                            <td><?php echo $account_group['bank_account_no']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tax Registration Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="remove" id="close_detail_btn"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>PAN</b></td>
                                            <td><?php echo $account_group['pan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>GST Type</b></td>
                                            <td><?php echo $account_group['gst_type']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>GSTIN</b></td>
                                            <td><?php echo $account_group['gstin']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

        <?php
    }
}
?>