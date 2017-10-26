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
                <a class="btn btn-app" href="?controller=product&action=addproduct">
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
                    <table id="products_table" class="table table-bordered table-hover" role="grid" aria-describedby="products_table_info">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th data-orderable="false" width="20px">
                                    <input type="checkbox" class="select-all">
                                </th>                                
                                <th>Product Name</th>
                                <th data-orderable="false" width="300px">Actions</th>
                            </tr>
                        </thead>
                        <?php
                        if (isset($products)) {
                            if (count($products) > 0) {
                                ?>
                                <tbody>
                                    <?php
                                    foreach ($products as $product) {
                                        ?>
                                        <tr id="tr_<?php echo $product['id']; ?>">
                                            <td><?php echo $product['id']; ?></td>
                                            <td><input type="checkbox" name="select_products[]" data-id="<?php echo $product['id']; ?>"></td>
                                            <td><?php echo ucwords($product['name']); ?></td>
                                            <td>
                                                <a href="" class="view btn btn-default" data-id="<?php echo $product['id']; ?>"><i class="fa fa-fw fa-eye"></i> View</a>
                                                <a href="?controller=product&action=updateproduct&id=<?php echo $product['id']; ?>" class="btn btn-default"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a>
                                                <a href="" class="delete btn btn-default" data-id="<?php echo $product['id']; ?>"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
                <h4 class="modal-title">Product Details</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4">Product Category :</label>
                        <div class="col-sm-8" id="view_product_category"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Product Brand :</label>
                        <div class="col-sm-8" id="view_brand"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Product Code :</label>
                        <div class="col-sm-8" id="view_product_code"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Product Name :</label>
                        <div class="col-sm-8" id="view_name"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">HSN Code :</label>
                        <div class="col-sm-8" id="view_hsn_code"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Quantity :</label>
                        <div class="col-sm-8" id="view_qty"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Price :</label>
                        <div class="col-sm-8" id="view_price"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Input Tax :</label>
                        <div class="col-sm-8" id="view_input_tax"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Output Tax :</label>
                        <div class="col-sm-8" id="view_output_tax"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4">Description :</label>
                        <div class="col-sm-8" id="view_description"></div>
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