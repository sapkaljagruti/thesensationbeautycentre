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
                <a class="btn btn-app" href="?controller=users&action=addUsers">
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
                    <table id="users_table" class="table table-bordered table-hover" role="grid" aria-describedby="users_table_info">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th data-orderable="false" width="20px">
                                    <input type="checkbox" class="select-all">
                                </th>                                
                                <th>First Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th data-orderable="false" width="300px">Actions</th>
                            </tr>
                        </thead>
                        <?php
                        if (isset($users)) {
                            if ($users->num_rows > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    while ($user = $users->fetch_assoc()) {
                                        ?>
                                        <tr id="tr_<?php echo $user['id']; ?>">
                                            <td><?php echo $user['id']; ?></td>
                                            <td><input type="checkbox" name="select_users[]" data-id="<?php echo $user['id']; ?>"></td>
                                            <td><?php echo ucwords($user['fname']); ?></td>
                                            <td><?php echo $user['email']; ?></td>
                                            <td><?php echo $user['mobile']; ?></td>
                                            
                                            <td>
                                                <a href="" class="view btn btn-default" data-id="<?php echo $user['id']; ?>"><i class="fa fa-fw fa-eye"></i> View</a>
                                                <a href="?controller=users&action=updateUsers&id=<?php echo $user['id']; ?>" class="btn btn-default"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a>
                                                <a href="" class="delete btn btn-default" data-id="<?php echo $user['id']; ?>"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
                <h4 class="modal-title">User Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4">First Name :</label>
                        <div class="col-sm-8" id="view_fname"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">last Name :</label>
                        <div class="col-sm-8" id="view_lname"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Email :</label>
                        <div class="col-sm-8" id="view_email"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Mobile :</label>
                        <div class="col-sm-8" id="view_mobile"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Username :</label>
                        <div class="col-sm-8" id="view_username"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Password :</label>
                        <div class="col-sm-8" id="view_password"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Can_View :</label>
                        <div class="col-sm-8" id="view_can_view"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Can_Add :</label>
                        <div class="col-sm-8" id="view_can_add"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Can_Update :</label>
                        <div class="col-sm-8" id="view_can_update"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Can_Delete :</label>
                        <div class="col-sm-8" id="view_can_delete"></div>
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