<link rel="stylesheet" href="public/plugins/datatables/dataTables.bootstrap.css">
<style>
    .table-responsive { overflow-x: initial; }
</style>

<div class="alert alert-dismissible" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4></h4><p></p>
</div>

<div class="row">
    <div class="col-xs-12">
        <!-- /.box -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <a class="btn btn-app" href="?controller=customer&action=addCustomer">
                    <i class="fa fa-plus"></i> New
                </a>
                <button class="btn btn-app" id="delete_selected">
                    <i class="fa fa-trash-o"></i> Delete Selected
                </button>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="customers_table" class="table table-bordered table-hover" role="grid" aria-describedby="customers_table_info">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th data-orderable="false" width="20px">
                                    <input type="checkbox" class="select-all">
                                </th>                                
                                <th>Name</th>
                                <th>Mobile 1</th>
                                <th>Mobile 2</th>
                                <th>Date Of Birth</th>
                                <th data-orderable="false" width="300px">Actions</th>
                            </tr>
                        </thead>
                        <?php
                        if ($customers) {
                            if ($customers->num_rows > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    while ($customer = $customers->fetch_assoc()) {
                                        ?>
                                        <tr id="tr_<?php echo $customer['id']; ?>">
                                            <td><?php echo $customer['id']; ?></td>
                                            <td><input type="checkbox" name="select_customers[]" data-id="<?php echo $customer['id']; ?>"></td>
                                            <td><?php echo ucwords($customer['name']); ?></td>
                                            <td><?php echo $customer['mobile1']; ?></td>
                                            <td><?php echo $customer['mobile2']; ?></td>
                                            <td>
                                                <?php
                                                if (!empty($customer['dob'])) {
                                                    $dob = date_create($customer['dob']);
                                                    $dob = date_format($dob, 'd M, Y');
                                                } else {
                                                    $dob = '';
                                                }
                                                echo $dob;
                                                ?>
                                            </td>
                                            <td>
                                                <a href="" class="view btn btn-default" data-id="<?php echo $customer['id']; ?>"><i class="fa fa-fw fa-eye"></i> View</a>
                                                <a href="?controller=customer&action=updateCustomer&id=<?php echo $customer['id']; ?>" class="btn btn-default"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a>
                                                <a href="" class="delete btn btn-default" data-id="<?php echo $customer['id']; ?>"><i class="fa fa-fw fa-trash"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <!-- /.box-body -->
            <div id="loader" class="overlay" style="display: none;">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>

<div class="modal fade" id="view_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Customer Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4">Name :</label>
                        <div class="col-sm-8" id="view_name"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Gender :</label>
                        <div class="col-sm-8" id="view_gender"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Area :</label>
                        <div class="col-sm-8" id="view_area"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">City :</label>
                        <div class="col-sm-8" id="view_city"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Pincode :</label>
                        <div class="col-sm-8" id="view_pincode"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Mobile1 :</label>
                        <div class="col-sm-8" id="view_mobile1"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Mobile2 :</label>
                        <div class="col-sm-8" id="view_mobile2"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Residence No :</label>
                        <div class="col-sm-8" id="view_residence_no"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Office No :</label>
                        <div class="col-sm-8" id="view_office_no"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Date Of Birth :</label>
                        <div class="col-sm-8" id="view_dob"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Date Of Anniversary :</label>
                        <div class="col-sm-8" id="view_doa"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Email :</label>
                        <div class="col-sm-8" id="view_email"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm_delete_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this data?</p>
                <input type="hidden" id="data_to_delete" value="">
                <input type="hidden" id="delete_type" value="single">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="delete">Delete</button>
            </div>
        </div>
    </div>
</div>