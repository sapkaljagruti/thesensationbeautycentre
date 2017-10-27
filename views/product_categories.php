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
                <a class="btn btn-app" href="#add_edit_modal" data-toggle="modal">
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
                    <table id="product_categories_table" class="table table-bordered table-hover" role="grid" aria-describedby="product_categories_table_info">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th data-orderable="false" width="20px">
                                    <input type="checkbox" class="select-all">
                                </th>                                
                                <th>Name</th>
                                <th data-orderable="false" width="300px">Actions</th>
                            </tr>
                        </thead>
                        <?php
                        if (isset($product_categories)) {
                            if (count($product_categories) > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    foreach ($product_categories as $product_category) {
                                        ?>
                                        <tr id="tr_<?php echo $product_category['id']; ?>">
                                            <td><?php echo $product_category['id']; ?></td>
                                            <td><input type="checkbox" name="select_product_categories[]" data-id="<?php echo $product_category['id']; ?>"></td>
                                            <td><?php echo ucwords($product_category['name']); ?></td>
                                            <td>
                                                <a href="" class="view btn btn-default" data-id="<?php echo $product_category['id']; ?>"><i class="fa fa-fw fa-eye"></i> View</a>
                                                <a href="" class="edit btn btn-default" data-id="<?php echo $product_category['id']; ?>"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a>
                                                <a href="" class="delete btn btn-default" data-id="<?php echo $product_category['id']; ?>"><i class="fa fa-fw fa-trash"></i> Delete</a>
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

<div class="modal fade" id="add_edit_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add/Edit Product Category</h4>
            </div>
            <div class="add_edit_modal_body">
                <form class="form-horizontal" id="add_edit_form">
                    <input type="hidden" class="form-control" id="save_type" value="add">
                    <input type="hidden" class="form-control" id="id" value="">
                    <input type="hidden" class="form-control" id="last_removed_parent_id" value="">
                    <input type="hidden" class="form-control" id="last_removed_parent_name" value="">
                    <div class="form-group" id="name_div">
                        <label for="name" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="name" placeholder="Category Name">
                            <span class="help-block" id="name_help_block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parent_id" class="col-sm-3 control-label">Under Group</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="parent_id">
                                <option value='0'>Select under group</option>
                                <?php
                                if (isset($product_categories)) {
                                    if (count($product_categories) > 0) {
                                        foreach ($product_categories as $product_category) {
                                            ?>
                                            <option value="<?php echo $product_category['id']; ?>"><?php echo ucwords($product_category['name']); ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                            </select>
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

<div class="modal fade" id="view_modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Product Category Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4">Name :</label>
                        <div class="col-sm-8" id="view_name"></div>
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