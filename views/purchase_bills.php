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
        <a class="btn btn-app" href="?controller=purchasebill&action=add">
            <i class="fa fa-plus"></i> New
        </a>
    </div>
    <div class="col-md-2 pull-left">
        <button class="btn btn-app" id="delete_selected">
            <i class="fa fa-trash-o"></i> Delete Selected
        </button>
    </div>
</div>