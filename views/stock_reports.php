<link rel="stylesheet" href="public/plugins/datatables/dataTables.bootstrap.css">
<style>
    .table-responsive { overflow-x: initial; }
</style>

<div class="alert alert-dismissible" style="display: none;">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4></h4><p></p>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">Filter</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">

                <form method="post" id="filter_form">

                    <div class="row">
                        <div class="form-group col-md-2 pull-left">
                            <select class="form-control" id="product_category_id" name="product_category_id">
                                <option value="">Select Product Category</option>
                                <?php
                                if (isset($product_categories)) {
                                    if (!empty($product_categories)) {
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
                        <div class="form-group col-md-2 pull-left">
                            <div class="radio">
                                <label>
                                    <input type="radio" id="top_selling_prodcuts" value="selling" name="top">
                                    Top Selling Products
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-3 pull-left">
                            <div class="radio">
                                <label>
                                    <input type="radio" id="top_purchased_prodcuts" value="purchased" name="top">
                                    Top Purchased Products
                                </label>
                            </div>
                        </div>
                        <div class="form-group col-md-3 pull-left">
                            <div class="radio">
                                <label>
                                    <input type="radio" id="none" value="none" name="top" checked="checked">
                                    None
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-2 pull-left">
                            <button type="button" class="btn btn-block btn-primary" id="filter">Filter</button>
                        </div>
                        <div class="form-group col-md-2 pull-left">
                            <button type="reset" class="btn btn-block btn-default" id="reset_filter">Reset</button>
                        </div>
                    </div>
                </form>

                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <!-- /.box -->
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Product Stock Reports</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="products_table" class="table table-bordered table-hover" role="grid" aria-describedby="products_table_info">
                        <thead>
                            <tr>
                                <th>Id</th>                                
                                <th>Product Name</th>
                                <th>Stock In Hand - 1</th>
                                <th>Stock In Hand - 2</th>
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
                                            <td><?php echo ucwords($product['name']); ?></td>
                                            <td><?php echo $product['qty1']; ?></td>
                                            <td><?php echo $product['qty2']; ?></td>
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