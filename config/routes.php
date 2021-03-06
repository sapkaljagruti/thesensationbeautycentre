<?php

// just a list of the controllers we have and their actions
// we consider those "allowed" values
$controllers = array(
    'Error' => ['index'],
    'Home' => ['index'],
//    'Manager' => ['getManagers', 'addManager', 'getManager', 'updateManager', 'deleteManager', 'getManagersForAutoComp'],
//    'Branch' => ['getBranches', 'getBranch', 'checkManager', 'addBranch'],
    'Brand' => ['getBrands', 'addBrand', 'getBrand', 'updateBrand', 'deleteBrand', 'checkNameExist'],
    'Customer' => ['getCustomers', 'getCustomer', 'addCustomer', 'updateCustomer', 'deleteCutomer'],
    'Staff' => ['getstaffmembers', 'addstaff', 'getstaffmember', 'updatestaff', 'deletestaff'],
    'Accountgroup' => ['getall', 'get', 'add', 'getParentName', 'update', 'deleteacgroup', 'checkNameExist', 'getById', 'findSalesLedgerByTerm', 'findPurchaseLedgerByTerm'],
    'Productcategory' => ['getcategories', 'addcategory', 'getcategory', 'updatecategory', 'deletecategory', 'checkNameExist'],
    'Product' => ['getproducts', 'getproduct', 'addproduct', 'updateproduct', 'deleteproduct', 'findProductByTerm', 'checkProductNameExist', 'checkQty', 'checkQtyForPurhase', 'checkQtyForSales'],
    'Party' => ['getall', 'add', 'update', 'get', 'delete', 'getPartyNameByTerm', 'getById', 'checkPartyNameExist'],
    'Purchase' => ['getbills', 'checkInovieExist', 'add', 'findLedgerByTerm', 'checkLedgerNameExist', 'delete', 'update', 'printBill', 'filterBillForReturn', 'getFromInvoiceNo'],
    'Purchasereturn' => ['getbills', 'add', 'checkInovieExist'],
    'Sale' => ['getbills', 'checkInovieExist', 'add', 'findLedgerByTerm', 'checkLedgerNameExist', 'delete', 'printBill', 'filterBillForReturn', 'getFromInvoiceNo'],
    'Salesreturn' => ['getbills', 'add', 'checkInovieExist'],
    'Creditnotes' => ['getall', 'add', 'checkCreditNoteExist'],
    'Debitnotes' => ['getall', 'add', 'checkDebitNoteExist'],
    'Contra' => ['getall', 'add', 'checkDebitNoteExist'],
    'Journal' => ['getall', 'add', 'getAllAccounts', 'checkLedgerNameExist'],
    'Companysetting' => ['get'],
    'Profile' => ['update', 'changePassword'],
    'Users' => ['getUsers', 'getUser', 'addUsers', 'updateUsers', 'deleteUsers'],
    'Reports' => ['getStockReports', 'getPLReports', 'getCustomPLReports', 'getprofitlossreports'],
);

// check that the requested controller and action are both allowed
// if someone tries to access something else he will be redirected to the error action of the pages controller
if (array_key_exists($controller, $controllers)) {

    if (in_array($action, $controllers[$controller])) {
//        require the file that matches the controller name
        require_once APP_DIR . '/controllers/' . $controller . 'Controller.php';

//        create a new instance of the needed controller
        switch ($controller) {
            case 'Error':
                $controller = new ErrorController();
                break;
            case 'Home':
                $controller = new HomeController();
                break;
//            case 'Manager':
//                $controller = new ManagerController();
//                break;
//            case 'Branch':
//                $controller = new BranchController();
//                break;
            case 'Brand':
                $controller = new BrandController();
                break;
            case 'Customer':
                $controller = new CustomerController();
                break;
            case 'Staff':
                $controller = new StaffController();
                break;
            case 'Accountgroup':
                $controller = new AccountgroupController();
                break;
//            case 'Account':
//                $controller = new AccountController();
//                break;
            case 'Productcategory':
                $controller = new ProductcategoryController();
                break;
            case 'Product':
                $controller = new ProductController();
                break;
            case 'Party':
                $controller = new PartyController();
                break;
            case 'Purchase':
                $controller = new PurchaseController();
                break;
            case 'Purchasereturn':
                $controller = new PurchaseReturnController();
                break;
            case 'Sale':
                $controller = new SaleController();
                break;
            case 'Salesreturn':
                $controller = new SalesReturnController();
                break;
            case 'Creditnotes':
                $controller = new CreditNotesController();
                break;
            case 'Debitnotes':
                $controller = new DebitNotesController();
                break;
            case 'Contra':
                $controller = new ContraController();
                break;
            case 'Journal':
                $controller = new JournalController();
                break;
            case 'Companysetting':
                $controller = new CompanysettingController();
                break;
            case 'Profile':
                $controller = new ProfileController();
                break;
            case 'Users':
                $controller = new UsersController();
                break;
            case 'Reports':
                $controller = new ReportsController();
                break;
        }

//        call the action
        $controller->$action();
    } else {
        require_once APP_DIR . '/controllers/ErrorController.php';
        $controller = new ErrorController();
        $action = 'index';
        $controller->$action();
    }
} else {
    require_once APP_DIR . '/controllers/ErrorController.php';
    $controller = new ErrorController();
    $action = 'index';
    $controller->$action();
}
?>