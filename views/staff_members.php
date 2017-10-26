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
                <a class="btn btn-app" href="?controller=staff&action=addstaff">
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
                    <table id="staff_members_table" class="table table-bordered table-hover" role="grid" aria-describedby="staff_members_table_info">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th data-orderable="false" width="20px">
                                    <input type="checkbox" class="select-all">
                                </th>                                
                                <th>Staff Code</th>
                                <th>Name</th>
                                <th>Designation</th>
                                <th>Mobile 1</th>
                                <th>Mobile 2</th>
                                <th data-orderable="false" width="300px">Actions</th>
                            </tr>
                        </thead>
                        <?php
                        if ($staff_members) {
                            if ($staff_members->num_rows > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    while ($staff_member = $staff_members->fetch_assoc()) {
                                        ?>
                                        <tr id="tr_<?php echo $staff_member['id']; ?>">
                                            <td><?php echo $staff_member['id']; ?></td>
                                            <td><input type="checkbox" name="select_staff_members[]" data-id="<?php echo $staff_member['id']; ?>"></td>
                                            <td><?php echo $staff_member['staff_code']; ?></td>
                                            <td><?php echo ucwords($staff_member['name']); ?></td>
                                            <td><?php echo ucwords($staff_member['designation']); ?></td>
                                            <td><?php echo $staff_member['mobile1']; ?></td>
                                            <td><?php echo $staff_member['mobile2']; ?></td>
                                            <td>
                                                <a href="" class="view btn btn-default" data-id="<?php echo $staff_member['id']; ?>"><i class="fa fa-fw fa-eye"></i> View</a>
                                                <a href="?controller=staff&action=updatestaff&id=<?php echo $staff_member['id']; ?>" class="btn btn-default"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a>
                                                <a href="" class="delete btn btn-default" data-id="<?php echo $staff_member['id']; ?>"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
                <h4 class="modal-title">Staff Member Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4">Staff Code :</label>
                        <div class="col-sm-8" id="view_staff_code"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Name :</label>
                        <div class="col-sm-8" id="view_name"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Designation :</label>
                        <div class="col-sm-8" id="view_designation"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Gender :</label>
                        <div class="col-sm-8" id="view_gender"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Address :</label>
                        <div class="col-sm-8" id="view_address"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Permanent Address :</label>
                        <div class="col-sm-8" id="view_permanent_address"></div>
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
                    <div class="form-group">
                        <label class="col-sm-4">Insurance Type :</label>
                        <div class="col-sm-8" id="view_insurance_type"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Insurance Name :</label>
                        <div class="col-sm-8" id="view_insurance_name"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Insurance Amount :</label>
                        <div class="col-sm-8" id="view_insurance_amount"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Insurance From :</label>
                        <div class="col-sm-8" id="view_insurance_from"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Insurance To :</label>
                        <div class="col-sm-8" id="view_insurance_to"></div>
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