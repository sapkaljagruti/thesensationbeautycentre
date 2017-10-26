<link rel="stylesheet" href="public/plugins/datatables/dataTables.bootstrap.css">
<style>
    .table-responsive { overflow-x: initial; }
</style>

<div class="alert alert-dismissible" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4></h4><p></p>
</div>

<div class="row">
    <div class="col-md-2 pull-left">
        <a class="btn btn-app" href="#add_edit_modal" data-toggle="modal">
            <i class="fa fa-plus"></i> New
        </a>
    </div>
    <div class="col-md-2 pull-left">
        <button class="btn btn-app" id="delete_selected">
            <i class="fa fa-trash-o"></i> Delete Selected
        </button>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <!-- /.box -->
        <div class="box box-primary">
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="managers_table" class="table table-bordered table-hover" role="grid" aria-describedby="managers_table_info">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th data-orderable="false" width="20px">
                                    <input type="checkbox" class="select-all">
                                </th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile1</th>
                                <th>Mobile2</th>
                                <th data-orderable="false" width="300px">Actions</th>
                            </tr>
                        </thead>
                        <?php
                        if (isset($managers)) {
                            if ($managers->num_rows > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    while ($manager = $managers->fetch_assoc()) {
                                        if (!empty($manager['mobile_nums'])) {
                                            $mobiles = explode(',', $manager['mobile_nums']);
                                            $mobile1 = $mobiles[0];
                                            $mobile2 = $mobiles[1];
                                        } else {
                                            $mobile1 = '';
                                            $mobile2 = '';
                                        }
                                        ?>
                                        <tr id="tr_<?php echo $manager['id']; ?>">
                                            <td><?php echo $manager['id']; ?></td>
                                            <td><input type="checkbox" name="select_managers[]" data-id="<?php echo $manager['id']; ?>"></td>
                                            <td><?php echo ucwords($manager['name']); ?></td>
                                            <td><?php echo $manager['email']; ?></td>
                                            <td><?php echo $mobile1; ?></td>
                                            <td><?php echo $mobile2; ?></td>
                                            <td>
                                                <a href="" class="view btn btn-default" data-id="<?php echo $manager['id']; ?>"><i class="fa fa-fw fa-eye"></i> View</a> <a href="" class="edit btn btn-default" data-id="<?php echo $manager['id']; ?>"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a>
                                                <a href="" class="delete btn btn-default" data-id="<?php echo $manager['id']; ?>"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
                <h4 class="modal-title">Manager Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4">Manager Name :</label>
                        <div class="col-sm-8" id="view_name"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Manager Email :</label>
                        <div class="col-sm-8" id="view_email"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Mobile1 :</label>
                        <div class="col-sm-8" id="view_mobile1"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Mobile2 :</label>
                        <div class="col-sm-8" id="view_mobile2"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add_edit_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add/Edit Manager</h4>
            </div>
            <div class="add_edit_modal_body">
                <form class="form-horizontal" id="add_edit_form">
                    <input type="hidden" class="form-control" id="save_type" value="add">
                    <input type="hidden" class="form-control" id="id" value="">
                    <div class="form-group" id="name_div">
                        <label for="name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" placeholder="Manager Name">
                            <span class="help-block" id="name_help_block"></span>
                        </div>
                    </div>
                    <div class="form-group" id="email_div">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email" placeholder="Manager Email">
                            <span class="help-block" id="email_help_block"></span>
                        </div>
                    </div>
                    <div class="form-group" id="mobile1_div">
                        <label for="mobile1" class="col-sm-3 control-label">Mobile 1</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mobile1" placeholder="Manager Mobile 1" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                            <span class="help-block" id="mobile1_help_block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile2" class="col-sm-3 control-label">Mobile 2</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mobile2" placeholder="Manager Mobile 2" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="save">Save</button>
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