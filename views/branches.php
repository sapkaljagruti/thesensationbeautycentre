<link rel="stylesheet" href="public/plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="public/plugins/jQueryUI/jquery-ui.css">
<style>
    .table-responsive { overflow-x: initial; }
    .ui-autocomplete-input {
        border: none;
        /*width: 300px;*/
        margin-bottom: 5px;
        padding-top: 2px;
        border: 1px solid #DDD !important;
        padding-top: 0px !important;
        z-index: 1511;
        position: relative;
    }
    .ui-menu .ui-menu-item a {
        font-size: 12px;
    }
    .ui-autocomplete {
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1510 !important;
        float: left;
        display: none;
        min-width: 160px;
        width: 160px;
        padding: 4px 0;
        margin: 2px 0 0 0;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 2px;
        -moz-border-radius: 2px;
        border-radius: 2px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }
    .ui-menu-item > a.ui-corner-all {
        display: block;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
        text-decoration: none;
    }
    .ui-state-hover, .ui-state-active {
        color: #ffffff;
        text-decoration: none;
        background-color: #0088cc;
        border-radius: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        background-image: none;
    }
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
                    <table id="branches_table" class="table table-bordered table-hover" role="grid" aria-describedby="branches_table_info">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th data-orderable="false" width="20px">
                                    <input type="checkbox" class="select-all">
                                </th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>City</th>
                                <th>Manager Name</th>
                                <th>Email ID</th>
                                <th data-orderable="false" width="300px">Actions</th>
                            </tr>
                        </thead>
                        <?php
                        if (isset($rows)) {
                            ?>
                            <tbody>
                                <?php
                                foreach ($rows as $branch) {
                                    ?>
                                    <tr id="tr_<?php echo $branch['id']; ?>">
                                        <td><?php echo $branch['id']; ?></td>
                                        <td><input type="checkbox" name="select_branches[]" data-id="<?php echo $branch['id']; ?>"></td>
                                        <td><?php echo ucwords($branch['name']); ?></td>
                                        <td><?php echo $branch['code']; ?></td>
                                        <td><?php echo ucwords($branch['city']); ?></td>
                                        <td><?php echo ucwords($branch['manager']); ?></td>
                                        <td><?php echo $branch['email']; ?></td>
                                        <td>
                                            <a href="" class="view btn btn-default" data-id="<?php echo $branch['id']; ?>"><i class="fa fa-fw fa-eye"></i> View</a> <a href="" class="edit btn btn-default" data-id="<?php echo $branch['id']; ?>"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a>
                                            <a href="" class="delete btn btn-default" data-id="<?php echo $branch['id']; ?>"><i class="fa fa-fw fa-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                            <?php
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
                <h4 class="modal-title">Branch Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4">Branch Name: </label>
                        <div class="col-sm-8" id="view_name"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Branch Code: </label>
                        <div class="col-sm-8" id="view_code"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Branch Address: </label>
                        <div class="col-sm-8" id="view_address"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">City: </label>
                        <div class="col-sm-8" id="view_city"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">State: </label>
                        <div class="col-sm-8" id="view_state"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Pincode: </label>
                        <div class="col-sm-8" id="view_pincode"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Phone 1: </label>
                        <div class="col-sm-8" id="view_phone_num1"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Phone 2: </label>
                        <div class="col-sm-8" id="view_phone_num2"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Mobile 1: </label>
                        <div class="col-sm-8" id="view_mobile1"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Mobile 2: </label>
                        <div class="col-sm-8" id="view_mobile2"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Manager: </label>
                        <div class="col-sm-8" id="view_manager"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Email ID: </label>
                        <div class="col-sm-8" id="view_email"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Active?: </label>
                        <div class="col-sm-8" id="view_is_active"></div>
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
                <h4 class="modal-title">Add/Edit Branch</h4>
            </div>
            <div class="add_edit_modal_body">
                <form class="form-horizontal" id="add_edit_form">
                    <input type="hidden" class="form-control" id="save_type" value="add">
                    <input type="hidden" class="form-control" id="id" value="">
                    <input type="hidden" class="form-control" id="manager_id" value="">
                    <div class="form-group" id="name_div">
                        <label for="name" class="col-sm-3 control-label">Branch Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" placeholder="Branch Name">
                            <span class="help-block" id="name_help_block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="code" class="col-sm-3 control-label">Branch Code</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="code" placeholder="Branch Code">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-3 control-label">Address</label>
                        <div class="col-sm-8">
                            <textarea id="address" class="form-control" rows="3" placeholder="Address"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="city" class="col-sm-3 control-label">City</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="city" placeholder="City">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="state" class="col-sm-3 control-label">State</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="state" placeholder="State">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pincode" class="col-sm-3 control-label">Pincode</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pincode" placeholder="Pincode">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone1" class="col-sm-3 control-label">Phone No 1</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="phone1" placeholder="Branch Phone No 1" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone2" class="col-sm-3 control-label">Phone No 2</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="phone2" placeholder="Branch Phone No 2" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile1" class="col-sm-3 control-label">Mobile 1</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mobile1" placeholder="Branch Mobile 1" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile2" class="col-sm-3 control-label">Mobile 2</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="mobile2" placeholder="Branch Mobile 2" maxlength="10" minlength="10" onkeypress="return allowOnlyNumber(event)" oncopy="return false;" onpaste="return false;" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="manager_id" class="col-sm-3 control-label">Select Or Add Manager</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="manager" placeholder="Type A Manager Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="email" placeholder="Branch Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Is Active?</label>
                        <div class="col-sm-8">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" id="is_active" value="1" checked="checked">
                                    Active
                                </label>
                            </div>
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