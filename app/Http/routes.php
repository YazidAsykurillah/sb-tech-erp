<?php

//Redis test experiment
Route::get('redis-test', function () {
    event(new App\Events\MyEventNameHere());
    return "event fired";
});

Route::get('redis-result', function(){
	return view('redis-result');
});
//ENDRedis test experiment



Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');


Route::group(['middleware' => 'auth'], function () {
	
	//Bank Account
	Route::post('deleteBankAccount', 'BankAccountController@destroy');
	Route::resource('bank-account', 'BankAccountController');

	//Customer
	Route::post('deleteCustomer', 'CustomerController@destroy');
	Route::get('customer/dataTables', 'CustomerController@dataTables');
	Route::resource('customer', 'CustomerController');

	//Vendor
	Route::post('deleteVendor', 'TheVendorController@destroy');
	Route::get('the-vendor/dataTables', 'TheVendorController@dataTables');
	Route::resource('the-vendor', 'TheVendorController');


	//User
	Route::get('user/print_salary', 'UserController@print_salary');
	Route::get('user/time-report/show', 'UserController@show_time_report');
	Route::post('user/time-report/store', 'UserController@store_time_report');
	Route::get('user/time-report/create', 'UserController@create_time_report');
	Route::post('user/unlock_create_internal_request', 'UserController@unlock_create_internal_request');
	Route::post('deleteUser', 'UserController@destroy');
	Route::post('resetPassword', 'UserController@resetPassword');
	Route::get('user/getLeavesDataTable', 'UserController@getLeavesDataTable');
	Route::get('user/dataTables', 'UserController@dataTables');
	Route::get('user/select2Office', 'UserController@select2Office');
	Route::get('user/select2Site', 'UserController@select2Site');
	Route::resource('user', 'UserController');

	//Purchase Order Customer
	Route::get('purchase-order-customer/file', 'PurchaseOrderCustomerController@downloadFile');
	Route::post('deletePOCustomer', 'PurchaseOrderCustomerController@destroy');
	Route::get('purchase-order-customer/dataTables', 'PurchaseOrderCustomerController@dataTables');
	Route::resource('purchase-order-customer', 'PurchaseOrderCustomerController');


	//Quotation Customer
	Route::get('quotation-customer/file/delete', 'QuotationCustomerController@deleteFile');
	Route::get('quotation-customer/file', 'QuotationCustomerController@downloadFile');
	Route::post('quotation-customer/file/upload', 'QuotationCustomerController@uploadFile');
	Route::post('quotation-customer/getCustomerFromQuotationOrderCustomer', 'QuotationCustomerController@getCustomerFromQuotationOrderCustomer');
	Route::post('setSubmittedQuotationCustomer', 'QuotationCustomerController@setSubmittedQuotationCustomer');
	Route::post('deleteQuotationCustomer', 'QuotationCustomerController@destroy');
	Route::get('quotation-customer/dataTables', 'QuotationCustomerController@dataTables');
	Route::resource('quotation-customer', 'QuotationCustomerController');

	//Quotation Vendor
	Route::post('deleteQuotationVendor', 'QuotationVendorController@destroy');
	Route::post('quotation-vendor/saveFromPurchaseRequest', 'QuotationVendorController@saveFromPurchaseRequest');
	Route::get('quotation-vendor/dataTables', 'QuotationVendorController@dataTables');
	Route::resource('quotation-vendor', 'QuotationVendorController');

	//Project
	Route::post('project/complete', 'ProjectController@complete');
	Route::post('project/getSalesFromPurchaseOrderCustomer', 'ProjectController@getSalesFromPurchaseOrderCustomer');
	Route::post('deleteProject', 'ProjectController@destroy');
	Route::get('project/select2ForDeliveryOrder', 'ProjectController@select2ForDeliveryOrder');
	Route::get('project/dataTables', 'ProjectController@dataTables');
	Route::resource('project', 'ProjectController');


	//Purchase Request
	Route::post('purchase-request/approve', 'PurchaseRequestController@approve');
	Route::post('updateItemPurchaseRequestIsReceived', 'PurchaseRequestController@updateItemPurchaseRequestIsReceived');
	Route::get('getPurchaseRequestItems', 'PurchaseRequestController@getPurchaseRequestItems');
	Route::post('changePurchaseRequestStatus', 'PurchaseRequestController@changeStatus');
	Route::post('deletePurchaseRequest', 'PurchaseRequestController@destroy');
	Route::get('purchase-request/select2Items', 'PurchaseRequestController@select2Items');
	Route::get('purchase-request/dataTables', 'PurchaseRequestController@dataTables');
	Route::resource('purchase-request', 'PurchaseRequestController');


	//Invoice Customer
	Route::get('invoice-customer/dataTables', 'InvoiceCustomerController@dataTables');
	Route::get('invoice-customer/file', 'InvoiceCustomerController@downloadFile');
	Route::get('invoice-customer/{id}/print_pdf', 'InvoiceCustomerController@print_pdf');
	Route::get('invoice-customer/in_week_overdue', 'InvoiceCustomerController@in_week_overdue');
	Route::get('invoice-customer/over_last_week_overdue', 'InvoiceCustomerController@over_last_week_overdue');
	Route::post('setPaidInvoiceCustomer', 'InvoiceCustomerController@setPaidInvoiceCustomer');
	Route::post('deleteInvoiceCustomer', 'InvoiceCustomerController@destroy');
	Route::resource('invoice-customer', 'InvoiceCustomerController');


	//Invoice Vendor
	Route::post('changeInvoiceVendorStatus', 'InvoiceVendorController@changeInvoiceVendorStatus');
	Route::get('invoice-vendor/in_week_overdue', 'InvoiceVendorController@in_week_overdue');
	Route::post('deleteInvoiceVendor', 'InvoiceVendorController@destroy');
	Route::get('invoice-vendor/create-from-pov', 'InvoiceVendorController@createFromPOV');
	Route::get('invoice-vendor/dataTables', 'InvoiceVendorController@dataTables');
	Route::resource('invoice-vendor', 'InvoiceVendorController');

	//Purchase Order Vendor
	Route::post('purchase-order-vendor/getItems', 'PurchaseOrderVendorController@getItems');
	Route::get('purchase-order-vendor/{id}/print_pdf', 'PurchaseOrderVendorController@print_pdf');
	Route::post('purchase-order-vendor/change-status', 'PurchaseOrderVendorController@changeStatus');
	Route::post('deletePOVendor', 'PurchaseOrderVendorController@destroy');
	Route::get('purchase-order-vendor/dataTables', 'PurchaseOrderVendorController@dataTables');
	Route::resource('purchase-order-vendor', 'PurchaseOrderVendorController');

	//Internal Request
	Route::post('internal-request/approveMultiple', 'InternalRequestController@approveMultiple');
	Route::post('changeInternalRequestStatus', 'InternalRequestController@changeInternalRequestStatus');
	Route::post('deleteInternalRequest', 'InternalRequestController@destroy');
	Route::get('internal-request/approved', 'InternalRequestController@getApprovedIR');
	Route::get('internal-request/checked', 'InternalRequestController@getCheckedIR');
	Route::get('internal-request/pending', 'InternalRequestController@getPendingIR');
	Route::get('internal-request/dataTables', 'InternalRequestController@dataTables');
	Route::resource('internal-request', 'InternalRequestController');


	//Petty Cash
	//Route::resource('petty-cash', 'PettyCashController');


	//Settlement
	Route::post('changeSettlementStatus', 'SettlementController@changeSettlementStatus');
	Route::post('deleteSettlement', 'SettlementController@destroy');
	Route::post('settlement/approveMultiple', 'SettlementController@approveMultiple');
	Route::get('settlement/pending', 'SettlementController@getPendingSettlement');
	Route::get('settlement/checked', 'SettlementController@getCheckedSettlement');
	Route::get('settlement/approved', 'SettlementController@getApprovedSettlement');
	Route::get('settlement/dataTables', 'SettlementController@dataTables');
	Route::resource('settlement', 'SettlementController');


	//Cashbond
	Route::post('cashbond/setPaymentStatusPaid', 'CashbondController@setPaymentStatusPaid');
	Route::post('changeCashbondStatus', 'CashbondController@changeStatus');
	Route::post('deleteCashbond', 'CashbondController@destroy');
	Route::post('cash-bond/cut-from-salary', 'CashbondController@cutFromSalary');
	Route::get('cash-bond/pending', 'CashbondController@getPendingCashbond');
	Route::get('cash-bond/checked', 'CashbondController@getCheckedCashbond');
	Route::get('cash-bond/approved', 'CashbondController@getApprovedCashbond');
	Route::get('cash-bond/dataTables', 'CashbondController@dataTables');
	Route::resource('cash-bond', 'CashbondController');

	//Cashbond Site
	Route::post('cash-bond-site/delete', 'CashbondSiteController@destroy');
	Route::resource('cash-bond-site', 'CashbondSiteController');


	//Cash
	Route::post('deleteCash', 'CashController@destroy');
	Route::resource('cash', 'CashController');


	//Transaction
	Route::post('/transaction/registerAccountingExpense', 'TransactionController@registerAccountingExpense');
	Route::post('/transaction/storeSiteSettelement', 'TransactionController@storeSiteSettlement');
	Route::post('updateTransactionDate', 'TransactionController@updateTransactionDate');
	Route::post('deleteTransaction', 'TransactionController@deleteTransaction');
	Route::post('/transaction/getBankAdministrationData', 'TransactionController@getBankAdministrationData');
	Route::post('/transaction/getInvoiceVendorData', 'TransactionController@getInvoiceVendorData');
	Route::post('/transaction/getInvoiceCustomerData', 'TransactionController@getInvoiceCustomerData');
	Route::post('/transaction/getCashbondData', 'TransactionController@getCashbondData');
	Route::post('/transaction/getSettlementData', 'TransactionController@getSettlementData');
	Route::post('/transaction/getInternalRequestData', 'TransactionController@getInternalRequestData');
	Route::get('/transaction/selectBankAdministration', 'TransactionController@selectBankAdministration');
	Route::get('/transaction/selectInvoiceCustomer', 'TransactionController@selectInvoiceCustomer');
	Route::get('/transaction/selectInvoiceVendor', 'TransactionController@selectInvoiceVendor');
	Route::get('/transaction/selectCashbond', 'TransactionController@selectCashbond');
	Route::get('/transaction/selectSettlement', 'TransactionController@selectSettlement');
	Route::get('/transaction/selectInternalRequest', 'TransactionController@selectInternalRequest');
	Route::post('/transaction/importExcel', 'TransactionController@importExcel');
	Route::get('/transaction/exportExcel', 'TransactionController@exportExcel');
	Route::resource('transaction', 'TransactionController');


	//Bank Administration
	Route::post('deleteBankAdministration', 'BankAdministrationController@destroy');
	Route::resource('bank-administration', 'BankAdministrationController');


	//Period
	Route::post('deletePeriod', 'PeriodController@destroy');
	Route::get('period/select2', 'PeriodController@select2');
	Route::resource('period', 'PeriodController');

	//Time Report
	Route::resource('time-report', 'TimeReportController');

	//Master Data
	Route::get('master-data/estimated-cost-margin-limit', 'ConfigurationController@getEstimatedCostMargin');
	Route::post('master-data/estimated-cost-margin-limit', 'ConfigurationController@postEstimatedCostMargin');

	Route::get('master-data/accounting-expense', 'AccountingExpenseController@index');

	Route::get('master-data/category/create', 'CategoryController@create');
	Route::resource('master-data/category', 'CategoryController');

	Route::post('deleteSubCategory', 'SubCategoryController@destroy');
	Route::resource('master-data/sub-category', 'SubCategoryController');

	Route::resource('finance-statistic', 'FinanceStatisticController');

	//Asset Category
	Route::get('master-data/asset-category/create', 'AssetCategoryController@create');
	Route::get('master-data/asset-category', 'AssetCategoryController@index');
	Route::get('master-data/asset-category/dataTables','AssetCategoryController@dataTables');
	Route::resource('master-data/asset-category','AssetCategoryController');

	//Asset
	Route::get('master-data/asset/create','AssetController@create');
	Route::get('master-data/asset','AssetController@index');
	Route::get('master-data/asset/dataTables','AssetController@dataTables');
	Route::resource('asset','AssetController');

	//Role
	Route::post('update-role-permission', 'RoleController@updateRolePermission');
	Route::resource('role', 'RoleController');

	//Permission
	Route::resource('permission', 'PermissionController');

	//Accounting expense
	Route::resource('accounting-expense', 'AccountingExpenseController');

	//Transfer Task
		//Payroll
		Route::post('transfer-task/payroll/transfer', 'TransferTaskController@transferPayroll');
		Route::get('transfer-task/payroll', 'TransferTaskController@payroll');

		//cashbond
		Route::post('transfer-task/cashbond/transfer', 'TransferTaskController@transferCashbond');
		Route::post('transfer-task/cashbond/approve', 'TransferTaskController@approveCashbond');
		Route::get('transfer-task/cashbond', 'TransferTaskController@cashbond');

		//Settlement
		Route::post('transfer-task/settlement/transferMultiple', 'TransferTaskController@transferSettlementMultiple');
		Route::post('transfer-task/settlement/transfer', 'TransferTaskController@transferSettlement');
		Route::post('transfer-task/settlement/approve', 'TransferTaskController@approveSettlement');
		Route::post('transfer-task/settlement/approveMultiple', 'TransferTaskController@approveSettlementMultiple');
		Route::get('transfer-task/settlement', 'TransferTaskController@settlement');

		//Invoice vendor
		Route::post('transfer-task/invoice-vendor/transfer', 'TransferTaskController@transferInvoiceVendor');
		Route::post('transfer-task/invoice-vendor/transferMultiple', 'TransferTaskController@transferInvoiceVendorMultiple');
		Route::post('transfer-task/invoice-vendor/approve', 'TransferTaskController@approveInvoiceVendor');
		Route::post('transfer-task/invoice-vendor/approveMultiple', 'TransferTaskController@approveInvoiceVendorMultiple');
		Route::get('transfer-task/invoice-vendor', 'TransferTaskController@invoice_vendor');

		//Internal request
		Route::post('transfer-task/internal-request/transfer', 'TransferTaskController@transferInternalRequest');
		Route::post('transfer-task/internal-request/transferMultiple', 'TransferTaskController@transferInternalRequestMultiple');
		Route::post('transfer-task/internal-request/approvePindahBuku', 'TransferTaskController@approveInternalRequestPindahBuku');
		Route::post('transfer-task/internal-request/approve', 'TransferTaskController@approveInternalRequest');
		Route::post('transfer-task/internal-request/approveMultiple', 'TransferTaskController@approveInternalRequestMultiple');
		Route::get('transfer-task/internal-request', 'TransferTaskController@internal_request');

	//Invoice customer TAx
	Route::post('payInvoiceCustomerTaxApproval', 'InvoiceCustomerTaxController@payInvoiceCustomerTaxApproval');
	Route::post('payInvoiceCustomerTax', 'InvoiceCustomerTaxController@payInvoiceCustomerTax');
	Route::get('invoice-customer-tax/dataTables', 'InvoiceCustomerTaxController@dataTables');
	Route::resource('invoice-customer-tax', 'InvoiceCustomerTaxController');


	Route::get('templates/download', 'TemplatesController@download');
	Route::get('templates', 'TemplatesController@index');

	//Invoice Vendor TAX
	Route::post('payInvoiceVendorTaxApproval', 'InvoiceVendorTaxController@payInvoiceVendorTaxApproval');
	Route::post('payInvoiceVendorTax', 'InvoiceVendorTaxController@payInvoiceVendorTax');
	Route::get('invoice-vendor-tax/dataTables', 'InvoiceVendorTaxController@dataTables');
	Route::resource('invoice-vendor-tax', 'InvoiceVendorTaxController');

	//Comparation invoice TAX
	Route::get('comparation-invoice-tax', 'ComparationController@invoiceTax');

	//Datatables
	Route::controller('datatables', 'DatatablesController',[
		'getPermissions'=>'datatables.getPermissions',
		'getRoles'=>'datatables.getRoles',
		'getBankAccounts'=>'datatables.getBankAccounts',
		'getCustomers'=>'datatables.getCustomers',
		'getVendors'=>'datatables.getVendors',
		'getUsers'=>'datatables.getUsers',
		'getPOCustomers'=>'datatables.getPOCustomers',
		'getPurchaseRequests'=>'datatables.getPurchaseRequests',
		//get all the invoice customers
		'getInvoiceCustomers'=>'datatables.getInvoiceCustomers',
		//get the invoice customer that will be overdued within a week from now
		'getInvoiceCustomersInWeekOverDue'=>'datatables.getInvoiceCustomersInWeekOverDue',
		//get the invoice customer that already overdued over the last week
		'getInvoiceCustomersOverLastWeekOverDue'=>'datatables.getInvoiceCustomersOverLastWeekOverDue',
		//get all the invoice vendors
		'getInvoiceVendors'=>'datatables.getInvoiceVendors',
		//get all invoice vendor that will be overdued within this week from now
		'getInvoiceVendorsInWeekOverdue'=>'datatables.getInvoiceVendorsInWeekOverdue',
		'getPOVendors'=>'datatables.getPOVendors',
		'getInternalRequests'=>'datatables.getInternalRequests',
		'getPendingInternalRequests'=>'datatables.getPendingInternalRequests',
		'getCheckedInternalRequests'=>'datatables.getCheckedInternalRequests',
		'getApprovedInternalRequests'=>'datatables.getApprovedInternalRequests',
		'getPettyCashes'=>'datatables.getPettyCashes',
		'getCategories'=>'datatables.getCategories',
		'getQuotationCustomers'=>'datatables.getQuotationCustomers',
		'getQuotationVendors'=>'datatables.getQuotationVendors',
		'getSettlements'=>'datatables.getSettlements',
		'getPendingSettlements'=>'datatables.getPendingSettlements',
		'getCheckedSettlements'=>'datatables.getCheckedSettlements',
		'getApprovedSettlements'=>'datatables.getApprovedSettlements',
		'getCashbonds'=>'datatables.getCashbonds',
		'getPendingCashbonds'=>'datatables.getPendingCashbonds',
		'getCheckedCashbonds'=>'datatables.getCheckedCashbonds',
		'getApprovedCashbonds'=>'datatables.getApprovedCashbonds',
		'getCashes'=>'datatables.getCashes',
		'getTransactions'=>'datatables.getTransactions',
		'getBankAdministrations'=>'datatables.getBankAdministrations',
		'getPeriods'=>'datatables.getPeriods',
		'getUserTimePeriods'=>'datatables.getUserTimePeriods',
		//get transfer task internal request lists
		'getTransferTaskInternalRequests'=>'datatables.getTransferTaskInternalRequests',
		//get transfer task invoice vendor lists
		'getTransferTaskInvoiceVendors'=>'datatables.getTransferTaskInvoiceVendors',
		//get transfer task settlement lists
		'getTransferTaskSettlement'=>'datatables.getTransferTaskSettlement',
		//get transfer task Cashbond lists
		'getTransferTaskCashbond'=>'datatables.getTransferTaskCashbond',
		//get Transfer Task Payroll list
		'getTransferTaskPayroll'=>'datatables.getTransferTaskPayroll',

		//Tax List Groups
		'getInvoiceCustomerTaxes'=>'datatables.getInvoiceCustomerTaxes',
		'getInvoiceCustomerTaxesFromTaxComparation'=>'datatables.getInvoiceCustomerTaxesFromTaxComparation',
		'getInvoiceVendorTaxes'=>'datatables.getInvoiceVendorTaxes',
		'getInvoiceVendorTaxesFromTaxComparation'=>'datatables.getInvoiceVendorTaxesFromTaxComparation',
		'getInvoiceTaxComparation'=>'datatables.getInvoiceTaxComparation',
		//Cashbond sites
		'getCashbondSites'=>'datatables.getCashbondSites',
		
		//Cashflow
		'getCashFlow'=>'datatables.getCashFlow',

		//Cashflow
		'getAccountingExpense'=>'datatables.getAccountingExpense',
	]);

	//Select2
		//Select2 Purchase Order Vendor Group
		Route::get('select2PurchaseOrderVendor', 'Select2Controller@select2PurchaseOrderVendor');
		Route::get('select2PurchaseOrderVendorForInvoiceVendor', 'Select2Controller@select2PurchaseOrderVendorForInvoiceVendor');

		//Select2 Project group
		Route::get('select2ProjectForInvoiceVendor', 'Select2Controller@select2ProjectForInvoiceVendor');
		Route::get('select2ProjectForPurchaseRequest', 'Select2Controller@select2ProjectForPurchaseRequest');
		Route::get('select2Project', 'Select2Controller@select2Project');

		//Select2 Purchase Order Vendor Group
		Route::get('select2PurchaseOrderCustomerForProject', 'Select2Controller@select2PurchaseOrderCustomerForProject');

		//Select2 Quotation Customer group
		Route::get('select2QuotationCustomerForPOCustomer', 'Select2Controller@select2QuotationCustomerForPOCustomer');

		//Select2 Quotation Vendor group
		Route::get('select2QuotationVendorForPurchaseRequest', 'Select2Controller@select2QuotationVendorForPurchaseRequest');
		Route::get('select2QuotationVendorForPOvendor', 'Select2Controller@select2QuotationVendorForPOvendor');

		//Select2 Purchase Request group
		Route::get('select2PurchaseRequestToCopyItems', 'Select2Controller@select2PurchaseRequestToCopyItems');
		Route::get('select2PurchaseRequestForPOVendor', 'Select2Controller@select2PurchaseRequestForPOVendor');
		Route::get('select2PurchaseRequest', 'Select2Controller@select2PurchaseRequest');

		//Select2 Vendor group
		Route::get('select2Vendor', 'Select2Controller@select2Vendor');

		//Select2 Customer group
		Route::get('select2Customer', 'Select2Controller@select2Customer');

		//Select2 User group
		Route::get('select2User', 'Select2Controller@select2User');

		//Select2 Cash group
		Route::get('select2Cash', 'Select2Controller@select2Cash');

		//Select2 Bank Account group
		Route::get('select2BankAccount', 'Select2Controller@select2BankAccount');

		//Select2 Cashbond Group
		Route::get('select2UserForCashbond', 'Select2Controller@select2UserForCashbond');

		//Select2 CashbondSite Group
		Route::get('select2UserForCashbondSite', 'Select2Controller@select2UserForCashbondSite');

		Route::get('select2AssetCategory', 'Select2Controller@select2AssetCategory');

	Route::resource('select2', 'Select2Controller');


	Route::post('my-profile/updatePassword', 'ProfileController@updatePassword');
	Route::get('my-profile/edit', 'ProfileController@edit');
	Route::resource('my-profile', 'ProfileController');


	//Exporter
	Route::post('exporter/cash_transaction', 'ExporterController@exportCashTransaction');

	//ETS
	Route::post('ets/liveEdit','EtsController@liveEdit');
	Route::post('ets/importMyEts','EtsController@importMyEts');
	Route::get('ets/myEtsDataTables','EtsController@myEtsDataTables');
	Route::get('ets/my-ets','EtsController@myEts');
	Route::post('ets/update_has_incentive_weekday', 'EtsController@updateHasIncentiveWeekDay');
	Route::post('ets/update_has_incentive_weekend', 'EtsController@updateHasIncentiveWeekEnd');
	Route::post('ets/importFromPayroll', 'EtsController@importFromPayroll');
	Route::post('ets/importForOfficeUser', 'EtsController@importForOfficeUser');
	Route::post('ets/import', 'EtsController@import');
	Route::post('ets/site/import', 'EtsController@importEtsSite');
	Route::post('ets/office/import', 'EtsController@importEtsOffice');
	Route::get('ets/office', 'EtsController@indexETSOffice');
	Route::get('ets/office/dataTables', 'EtsController@getETSOfficedataTables');
	Route::get('ets/site', 'EtsController@indexETSSite');
	Route::get('ets/site/dataTables', 'EtsController@getETSSitedataTables');
	Route::resource('ets', 'EtsController');


	//Cashflow
	Route::resource('cash-flow', 'CashFlowController');

	//Payroll
	Route::post('payroll/setStatusApprove', 'PayrollController@setStatusApprove');
	Route::post('payroll/setStatusCheck', 'PayrollController@setStatusCheck');
	Route::post('deletePayroll', 'PayrollController@deletePayroll');
	Route::post('payroll/update_thp_amount', 'PayrollController@update_thp_amount');
	Route::get('payroll/dataTables', 'PayrollController@dataTables');
	Route::resource('payroll', 'PayrollController');

	//AllowanceItem
	Route::post('allowance-item/update-multiplier', 'AllowanceItemController@updateMultiplier');
	Route::post('allowance-item/update-amount', 'AllowanceItemController@updateAmount');
	Route::resource('allowance-item', 'AllowanceItemController');


	//Medical Allowance
	Route::post('medical-allowance/update-multiplier', 'MedicalAllowanceController@updateMultiplier');
	Route::post('medical-allowance/update-amount', 'MedicalAllowanceController@updateAmount');
	Route::resource('medical-allowance', 'MedicalAllowanceController');


	//Delivery Order
	Route::post('deleteDeliveryOrder', 'DeliveryOrderController@destroy');
	Route::get('delivery-order/{id}/print_pdf', 'DeliveryOrderController@print_pdf');
	Route::get('delivery-order/dataTables', 'DeliveryOrderController@dataTables');
	Route::resource('delivery-order', 'DeliveryOrderController');

	//Product
	Route::post('product/import-excel', 'ProductController@importExcel');
	Route::get('product/dataTables', 'ProductController@dataTables');
	Route::resource('product', 'ProductController');


	//Cashbond Installment
	Route::post('cashbond-installment/changeSchedule', 'CashbondInstallmentController@changeSchedule');
	Route::resource('cashbond-installment', 'CashbondInstallmentController');
	
	//Workshop Allowance
	Route::post('workshop-allowance/update-amount', 'WorkshopAllowanceController@updateAmount');
	Route::post('workshop-allowance/update-multiplier', 'WorkshopAllowanceController@updateMultiplier');

	//Extra Payroll Payment
	Route::post('extra-payroll-payment/delete', 'ExtraPayrollPaymentController@delete');
	Route::post('extra-payroll-payment/save', 'ExtraPayrollPaymentController@save');
	Route::resource('extra-payroll-payment', 'ExtraPayrollPaymentController');
	//Report
	//PPN
	Route::get('report/data-ppn', 'ReportController@getDataPpn');
	Route::get('report/ppn', 'ReportController@ppn');
	//Project
	Route::get('report/data-project', 'ReportController@getDataProject');
	Route::get('report/project', 'ReportController@project');

	//Leave
	Route::resource('leave', 'LeaveController');

	//REST APIs
	//Preparing rest, for now it's still not used
	Route::get('api/invoice-customer', 'Api\InvoiceCustomerController@index');
	
});
