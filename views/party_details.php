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

<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Party Details</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <?php
            if (isset($parties)) {
                foreach ($parties as $party) {
                    ?>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>Party Name</b></td>
                                            <td><?php echo $party['name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Address</b></td>
                                            <td><?php echo $party['address']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Mobile 1</b></td>
                                            <td><?php echo $party['mobile1']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Residence No</b></td>
                                            <td><?php echo $party['residence_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Bank Name</b></td>
                                            <td><?php echo $party['bank_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>IFSC Code</b></td>
                                            <td><?php echo $party['ifsc_code']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>PAN</b></td>
                                            <td><?php echo $party['pan']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>GST Type</b></td>
                                            <td><?php echo $party['gst_type']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Party Brands</b></td>
                                            <td><?php echo $party['brands']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6 table-responsive">
                                <table class="table table-hover table-striped" width="50%">
                                    <tbody>
                                        <tr>
                                            <td><b>Contact Person</b></td>
                                            <td><?php echo $party['contact_person']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Email</b></td>
                                            <td><?php echo $party['email']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Mobile 2</b></td>
                                            <td><?php echo $party['mobile2']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Office No</b></td>
                                            <td><?php echo $party['office_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Bank Branch</b></td>
                                            <td><?php echo $party['bank_branch']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Bank A/C No</b></td>
                                            <td><?php echo $party['bank_account_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>State</b></td>
                                            <td><?php echo $party['state']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>GSTIN</b></td>
                                            <td><?php echo $party['gstin']; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <?php
                }
            }
            ?>
        </div>
        <!-- /.box -->
    </div>
</div>