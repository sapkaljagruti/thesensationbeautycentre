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
                <a class="btn btn-app" href="?controller=purchase&action=add">
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
                    <table id="purchase_vouchers_table" class="table table-bordered table-hover" role="grid" aria-describedby="purchase_vouchers_table_info">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th data-orderable="false" width="20px">
                                    <input type="checkbox" class="select-all">
                                </th>                                
                                <th>Party A/C</th>
                                <th>Purchase Ledger</th>
                                <th>invoice No</th>
                                <th data-orderable="false" width="300px">Actions</th>
                            </tr>
                        </thead>
                        <?php
                        if (isset($purchase_vouchers)) {
                            ?>
                            <tbody>
                                <?php
                                foreach ($purchase_vouchers as $purchase_voucher) {
                                    ?>
                                    <tr id="tr_<?php echo $purchase_voucher['id']; ?>">
                                        <td><?php echo $purchase_voucher['id']; ?></td>
                                        <td><input type="checkbox" name="select_purchase_vouchers[]" data-id="<?php echo $purchase_voucher['id']; ?>"></td>
                                        <td><?php echo $purchase_voucher['party_ac_name']; ?></td>
                                        <td><?php echo $purchase_voucher['purchase_ledger_name']; ?></td>
                                        <td><?php echo $purchase_voucher['invoice_no']; ?></td>
                                        <td>
                                            <a href="?controller=party&action=get&id=<?php echo $purchase_voucher['id']; ?>" class="btn btn-default"><i class="fa fa-fw fa-eye"></i> View</a>
                                            <a href="?controller=party&action=update&id=<?php echo $purchase_voucher['id']; ?>" class="btn btn-default"><i class="fa fa-fw fa-pencil-square-o"></i> Edit</a>
                                            <a href="" class="delete btn btn-default" data-id="<?php echo $purchase_voucher['id']; ?>"><i class="fa fa-fw fa-trash"></i> Delete</a>
                                            <span id="span_<?php echo $purchase_voucher['id']; ?>">
                                                <?php
                                                if ($purchase_voucher['is_deleted'] == '1') {
                                                    ?>
                                                    <font color="red"><i class="fa fa-exclamation-triangle"></i> Cancelled</font>
                                                    <?php
                                                }
                                                ?>
                                            </span>
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