<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['logout'] = 'Login/logout';  

$route['Administrator'] = 'Administrator/Page';
$route['module/(:any)'] = 'Administrator/Page/module/$1';
$route['brachAccess/(:any)'] = 'Administrator/Login/brach_access/$1';
$route['getBrachAccess'] = 'Administrator/Login/branch_access_main_admin';

$route['get_categories'] = 'Administrator/Page/getCategories'; 
$route['category'] = 'Administrator/Page/add_category'; 
$route['insertcategory'] = 'Administrator/Page/insert_category';
$route['catdelete'] = 'Administrator/page/catdelete';

// Expense Head=============
$route['ExpenseHead'] 				= 'Administrator/BillController/Eindex';
$route['expenseHeadFancyBox'] 		= 'Administrator/BillController/expenseHeadFancyBox';
$route['expenseHeadAll'] 			= 'Administrator/BillController/expenseHeadAll';
$route['ExpenseHead/store'] 		= 'Administrator/BillController/Estore';
$route['ExpenseHead/edit/(:any)'] 	= 'Administrator/BillController/Eedit/$1';
$route['ExpenseHead/update/(:any)'] = 'Administrator/BillController/Eupdate/$1';
$route['ExpenseHead/delete/(:any)'] = 'Administrator/BillController/Edelete/$1';


// Bill=============
$route['BillEntry'] 				= 'Administrator/BillController/index';
$route['BillEntry/store'] 			= 'Administrator/BillController/store';
$route['BillEntry/edit/(:any)'] 	= 'Administrator/BillController/edit/$1';
$route['BillEntry/update/(:any)'] 	= 'Administrator/BillController/update/$1';
$route['BillEntry/delete/(:any)'] 	= 'Administrator/BillController/delete/$1';
$route['BillEntry/search'] 			= 'Administrator/BillController/search';


// Assets Info===========
$route['AssetsEntry'] 				= 'Administrator/Assets';
$route['insertassets'] 				= 'Administrator/Assets/insert_Assets';
$route['assetsEdit/(:any)'] 		= 'Administrator/Assets/Assets_edit/$1';
$route['assetsUpdate/(:any)'] 		= 'Administrator/Assets/Update_Assets/$1';
$route['assetsDelete/(:any)'] 		= 'Administrator/Assets/Assets_delete/$1';
$route['get_assets_cost'] 			= 'Administrator/Assets/getAssetsCost';
$route['assets_report']				= 'Administrator/Assets/assetsReport';
$route['get_group_assets']			= 'Administrator/Assets/getGroupAssets';
$route['get_assets_report']			= 'Administrator/Assets/getAssetsReport';



$route['unit'] = 'Administrator/Page/unit';
$route['insertunit'] = 'Administrator/Page/insert_unit';
$route['unitedit/(:any)'] = 'Administrator/Page/unitedit/$1';
$route['unitupdate'] = 'Administrator/Page/unitupdate';
$route['unitdelete'] = 'Administrator/Page/unitdelete';
$route['get_units'] = 'Administrator/Page/getUnits';

$route['color'] = 'Administrator/Page/add_color';
$route['insertcolor'] = 'Administrator/Page/insert_color';
$route['colordelete'] = 'Administrator/Page/colordelete';
$route['coloredit/(:any)'] = 'Administrator/Page/coloredit/$1';
$route['colorupdate'] = 'Administrator/Page/colorupdate';

$route['area'] = 'Administrator/Page/area';
$route['insertarea'] = 'Administrator/Page/insert_area';
$route['areadelete'] = 'Administrator/Page/areadelete';
$route['areaedit/(:any)'] = 'Administrator/Page/areaedit/$1';
$route['areaupdate'] = 'Administrator/Page/areaupdate';
$route['get_districts'] = 'Administrator/Page/getDistricts';

$route['upazila'] = 'Administrator/Page/upazila';
$route['insertupazila'] = 'Administrator/Page/insert_upazila';
$route['upaziladelete'] = 'Administrator/Page/upaziladelete';
// $route['areaupdate'] = 'Administrator/Page/areaupdate';
// $route['get_districts'] = 'Administrator/Page/getDistricts';

$route['product'] = 'Administrator/Products';
$route['add_product'] = 'Administrator/Products/addProduct';
$route['productEdit'] = 'Administrator/Products/product_edit';
$route['update_product'] = 'Administrator/Products/updateProduct';
$route['delete_product'] = 'Administrator/Products/deleteProduct';
$route['active_product'] = 'Administrator/Products/activeProduct';
$route['viewAllProduct'] = 'Administrator/Products/view_all_product';
$route['selectCategory_by_brand/(:any)'] = 'Administrator/page/selectCategory_by_brand/$1';
$route['productlist'] = 'Administrator/Reports/productlist';
$route['currentStock'] = 'Administrator/Products/current_stock';
$route['searchStock'] = 'Administrator/Products/search_stock';
$route['material_list'] = 'Administrator/Reports/materialList';
$route['currentStockPrint'] = 'Administrator/Reports/current_stock';
$route['stockAvailable'] = 'Administrator/Products/stockAvailable';
$route['stockAvailablePrint'] = 'Administrator/Reports/stockAvailable';
$route['productName']	=	'Administrator/Products/product_name';
$route['get_products']	=	'Administrator/Products/getProducts';
$route['get_product_stock']	=	'Administrator/Products/getProductStock';
$route['get_current_stock']	=	'Administrator/Products/getCurrentStock';
$route['get_total_stock']	=	'Administrator/Products/getTotalStock';
$route['product_ledger']	=	'Administrator/Products/productLedger';
$route['get_product_ledger']	=	'Administrator/Products/getProductLedger';
$route['reorder_list']	=	'Administrator/Reports/reOrderList';

$route['totalStock'] = 'Administrator/Products/total_stock';
$route['totalStockPrint'] = 'Administrator/Reports/total_stock';


$route['GenerateBarcode/(:any)'] = 'BarcodeController/barcode_create/$1';


$route['supplier'] = 'Administrator/Supplier';
$route['add_supplier'] = 'Administrator/Supplier/addSupplier';
$route['supplieredit'] = 'Administrator/Supplier/supplier_edit/';
$route['update_supplier'] = 'Administrator/Supplier/updateSupplier';
$route['supplierList'] = 'Administrator/Reports/supplierList';
$route['delete_supplier'] = 'Administrator/Supplier/deleteSupplier';

$route['customer'] = 'Administrator/Customer';
$route['add_customer'] = 'Administrator/Customer/addCustomer';
$route['customeredit/(:any)'] = 'Administrator/Customer/customeredit/$1';
$route['update_customer'] = 'Administrator/Customer/updateCustomer';
$route['customerlist'] = 'Administrator/Customer/customerlist';
$route['delete_customer'] = 'Administrator/Customer/deleteCustomer';
$route['get_customers'] = 'Administrator/Customer/getCustomers';
$route['get_customer_due'] = 'Administrator/Customer/getCustomerDue';
$route['get_customer_ledger'] = 'Administrator/Customer/getCustomerLedger';
$route['get_customer_payments'] = 'Administrator/Customer/getCustomerPayments';
$route['add_customer_payment'] = 'Administrator/Customer/addCustomerPayment';
$route['update_customer_payment'] = 'Administrator/Customer/updateCustomerPayment';
$route['delete_customer_payment'] = 'Administrator/Customer/deleteCustomerPayment';

$route['customerPaymentPage'] = 'Administrator/Customer/customerPaymentPage';
$route['customer_payment_history'] = 'Administrator/Customer/customerPaymentHistory';


$route['get_purchases'] = 'Administrator/Purchase/getPurchases';
$route['get_purchasedetails'] = 'Administrator/Purchase/getPurchaseDetails';
$route['get_purchasedetails_for_return'] = 'Administrator/Purchase/getPurchaseDetailsForReturn';
$route['add_purchase_return'] = 'Administrator/Purchase/addPurchaseReturn';
$route['update_purchase_return'] = 'Administrator/Purchase/updatePurchaseReturn';
$route['get_purchase_return_details'] = 'Administrator/Purchase/getPurchaseReturnDetails';
$route['purchase'] = 'Administrator/Purchase/order';
$route['purchase/(:any)'] = 'Administrator/Purchase/purchaseEdit/$1';
$route['purchaseExcel'] = 'Administrator/Purchase/purchaseExcel';
$route['excelFileFormate'] = 'Administrator/Purchase/excelFileFormate';
$route['createProductSheet'] = 'Administrator/Purchase/createProductSheet';
$route['productSheetCart'] = 'Administrator/Addcart/productSheetCart';
$route['ajaxCartRemoveProductSheet'] = 'Administrator/Addcart/ajax_cart_remove_productSheet';
$route['SelectSupplier'] = 'Administrator/Purchase/Selectsuplier';
$route['SelectCat'] = 'Administrator/Purchase/SelectCat';
$route['SelectPruduct'] = 'Administrator/Purchase/SelectPruduct';
$route['purchase_invoice_print/(:any)'] = 'Administrator/Purchase/purchaseInvoicePrint/$1';
$route['purchaseTOcart'] = 'Administrator/Addcart/purchaseTOcart';
$route['purchase_update_TOcart'] = 'Administrator/Addcart/purchase_update_TOcart';
$route['purchaseExcelTOcart'] = 'Administrator/Addcart/purchaseExcelTOcart';
$route['ajaxCartRemove'] = 'Administrator/Addcart/ajax_cart_remove/';
$route['ajax_purchase_update_CartRemove'] = 'Administrator/Addcart/ajax_purchase_update_CartRemove/';
$route['add_purchase'] = 'Administrator/Purchase/addPurchase';
$route['update_purchase'] = 'Administrator/Purchase/updatePurchase';
$route['purchaseInvoice'] = 'Administrator/Purchase/purchase_bill';
$route['purchaseInvoiceSearch'] = 'Administrator/Purchase/purchase_invoice_search';
$route['PurchaseInvoicePrint'] = 'Administrator/Reports/Purchase_invoice';
$route['purchaseRecord'] = 'Administrator/Purchase/purchase_record';
$route['get_purchase_record'] = 'Administrator/Purchase/getPurchaseRecord';
$route['delete_purchase'] = 'Administrator/Purchase/deletePurchase';
$route['selectSupplierForReport'] = 'Administrator/Purchase/select_supplier';
$route['selectProductReport'] = 'Administrator/Purchase/select_product';
$route['searchPurchaseRecord'] = 'Administrator/Purchase/search_purchase_record';
$route['purchaseRecordPrint'] = 'Administrator/Reports/search_purchase_record';
$route['supplierDue'] = 'Administrator/Supplier/supplier_due';
$route['supplierPayment'] = 'Administrator/Supplier/supplierPaymentPage';
$route['supplierDuePrint'] = 'Administrator/Reports/search_supplier_due';
$route['searchSupplierDue'] = 'Administrator/Supplier/search_supplier_due';
$route['supplierPaymentReport'] = 'Administrator/Supplier/supplier_payment_report';
$route['searchSupplierPayments'] = 'Administrator/Supplier/search_supplier_payments';
$route['get_suppliers'] = 'Administrator/Supplier/getSuppliers';
$route['get_supplier_due'] = 'Administrator/Supplier/getSupplierDue';
$route['get_supplier_ledger'] = 'Administrator/Supplier/getSupplierLedger';
$route['get_supplier_payments'] = 'Administrator/Supplier/getSupplierPayments';
$route['add_supplier_payment'] = 'Administrator/Supplier/addSupplierPayment';
$route['update_supplier_payment'] = 'Administrator/Supplier/updateSupplierPayment';
$route['delete_supplier_payment'] = 'Administrator/Supplier/deleteSupplierPayment';
$route['supplierPaymentPrint'] = 'Administrator/Reports/supplier_payment_print';

$route['purchaseReturns'] = 'Administrator/Purchase/returns';
$route['purchaseReturns/(:any)'] = 'Administrator/Purchase/purchaseReturnEdit/$1';
$route['PurchasereturnSearch'] = 'Administrator/Purchase/PurchasereturnSearch';
$route['PurchaseReturnInsert'] = 'Administrator/Purchase/PurchaseReturnInsert';
$route['returnsList'] = 'Administrator/Purchase/returns_list';
$route['purchaseReturnRecord'] = 'Administrator/Purchase/purchase_return_record';
$route['purchaseReturnlist'] = 'Administrator/Reports/purchase_returnlist';
$route['get_purchase_returns'] = 'Administrator/Purchase/getPurchaseReturns';
$route['purchase_return_invoice/(:any)'] = 'Administrator/Purchase/purchaseReturnInvoice/$1';
$route['delete_purchase_return'] = 'Administrator/Purchase/deletePurchaseReturn';
$route['purchase_return_details'] = 'Administrator/Purchase/purchaseReturnDetails';
$route['check_purchase_return/(:any)'] = 'Administrator/Purchase/checkPurchaseReturn/$1';

$route['damageEntry'] = 'Administrator/Purchase/damage_entry';
$route['add_damage'] = 'Administrator/Purchase/addDamage';
$route['update_damage'] = 'Administrator/Purchase/updateDamage';
$route['delete_damage'] = 'Administrator/Purchase/deleteDamage';
$route['get_damages'] = 'Administrator/Purchase/getDamages';
$route['damageList'] = 'Administrator/Purchase/damage_product_list';
$route['SelectDamageProduct'] = 'Administrator/Purchase/damage_select_product';

$route['sales/(:any)'] = 'Administrator/Sales/index/$1';
$route['sales/(:any)/(:any)'] = 'Administrator/Sales/salesEdit/$1/$2';
$route['salesinvoice'] = 'Administrator/Sales/sales_invoice';
$route['cheque/entry_from'] = 'Administrator/Check/view_check_entry_from';
$route['sale_cheque_store'] = 'Administrator/Check/sale_cheque_store';
$route['salesInvoicePrint'] = 'Administrator/Reports/sales_invoice';
$route['selectCustomer'] = 'Administrator/Sales/selectCustomer';
$route['SelectCatWiseSaleProduct'] = 'Administrator/Sales/SelectCatWiseSaleProduct';
$route['SelectProducts'] = 'Administrator/Sales/SelectProducts';
$route['SalesTOcart'] = 'Administrator/Addcart/SalesTOcart';
$route['Sales_update_TOcart'] = 'Administrator/Addcart/Sales_update_TOcart';
$route['productRemove'] = 'Administrator/Addcart/ajax_salsecart_remove/';
$route['productRemoveUpdate'] = 'Administrator/Addcart/ajax_update_salsecart_remove/';
$route['salesOrder'] = 'Administrator/Sales/sales_order';
$route['salesOrderUpdate'] = 'Administrator/Sales/sales_order_update';
$route['productDelete'] = 'Administrator/Sales/product_delete';
$route['productSalesSearch'] = 'Administrator/Sales/product_sales_search';
$route['salesInvoiceSearch'] = 'Administrator/Sales/sales_invoice_search';
$route['searchSalesRecord'] = 'Administrator/Sales/search_sales_record'; 
$route['customerName'] = 'Administrator/Sales/select_customerName';
$route['InvCustomerName'] = 'Administrator/Sales/select_InvCustomerName';
$route['add_sales'] = 'Administrator/Sales/addSales';
$route['get_sales'] = 'Administrator/Sales/getSales';
$route['get_sales_record'] = 'Administrator/Sales/getSalesRecord';
$route['get_saledetails'] = 'Administrator/Sales/getSaleDetails';
$route['update_sales'] = 'Administrator/Sales/updateSales';
$route['delete_sales'] = 'Administrator/Sales/deleteSales';
$route['get_saledetails_for_return'] = 'Administrator/Sales/getSaleDetailsForReturn';
$route['add_sales_return'] = 'Administrator/Sales/addSalesReturn';
$route['update_sales_return'] = 'Administrator/Sales/updateSalesReturn';
$route['delete_sale_return'] = 'Administrator/Sales/deleteSaleReturn';
$route['get_sale_returns'] = 'Administrator/Sales/getSaleReturns';
$route['get_sale_return_details'] = 'Administrator/Sales/getSaleReturnDetails';
$route['sale_return_invoice/(:any)'] = 'Administrator/Sales/saleReturnInvoice/$1';
$route['sale_return_details'] = 'Administrator/Sales/saleReturnDetails';
$route['check_sale_return/(:any)'] = 'Administrator/Sales/checkSaleReturn/$1';

$route['sale_invoice_print/(:any)'] = 'Administrator/Sales/saleInvoicePrint/$1';
$route['craditlimit'] = 'Administrator/Sales/craditlimit/';
$route['salesrecord'] = 'Administrator/Sales/sales_record';   
$route['search_sales_record'] = 'Administrator/Reports/search_sales_record';
$route['search_invoice_sales_record'] = 'Administrator/Reports/search_invoice_sales_record';
$route['sales_record_print/(:any)'] = 'Administrator/Reports/sales_record_print/$1';
$route['customerwiseSales'] = 'Administrator/Sales/customerwise_sales';
$route['customerSalesSearch'] = 'Administrator/Sales/customer_sales_search';
$route['customerwiseSalesPrint'] = 'Administrator/Reports/customerwise_sales';
$route['productwiseSales'] = 'Administrator/Sales/productwise_sales';
$route['productwiseSalesPrint'] = 'Administrator/Reports/productwise_sales';
$route['customerPaymentReport'] = 'Administrator/Customer/customer_payment_report';
$route['customerPaymentReportPrint'] = 'Administrator/Reports/customer_payment_print';
$route['invoiceProductDetails'] = 'Administrator/Sales/invoice_product_list';
$route['invoiceProductList'] = 'Administrator/Sales/invoice_product_list_search';
$route['invoiceProductPrint'] = 'Administrator/Reports/branchwise_invoice_product_list';
$route['chalan/(:any)'] = 'Administrator/Sales/chalan/$1';



//Quotation================
$route['quotation'] 		= 'Administrator/Quotation';
$route['quotation/(:any)'] 		= 'Administrator/Quotation/editQuotation/$1';
$route['add_quotation']  = 'Administrator/Quotation/addQuotation';
$route['update_quotation']  = 'Administrator/Quotation/updateQuotation';
$route['delete_quotation']  = 'Administrator/Quotation/deleteQuotation';
$route['quotation_record']  = 'Administrator/Quotation/quotationRecord';
$route['get_quotations']  = 'Administrator/Quotation/getQuotations';
$route['quotationReport']   = 'Administrator/Quotation/quotation_report';
$route['quotation_invoice/(:any)']   = 'Administrator/Quotation/quotationInvoice/$1';
$route['quotation_invoice_report']= 'Administrator/Quotation/quotationInvoiceReport';
$route['DeleteQuotationInvoice']= 'Administrator/Quotation/delete_quotation_invoice';




$route['salesReturn'] = 'Administrator/Sales/salesreturn';
$route['salesReturn/(:any)'] = 'Administrator/Sales/salesReturnEdit/$1';
$route['salesreturnSearch'] = 'Administrator/Sales/salesreturnSearch';
$route['SalesReturnInsert'] = 'Administrator/Sales/SalesReturnInsert';
$route['returnList'] = 'Administrator/Sales/return_list';
$route['salesReturnRecord'] = 'Administrator/Sales/sales_return_record';
$route['salesreturnlist'] = 'Administrator/Reports/salesreturnlist';

$route['profitLoss'] = 'Administrator/Sales/profitLoss';
$route['profitLossSearch'] = 'Administrator/Sales/profitLossSearch';
$route['get_profit_loss'] = 'Administrator/Sales/getProfitLoss';
$route['profitLossPrint'] = 'Administrator/Reports/profitLossPrint';
 
$route['customerDue'] = 'Administrator/Customer/customer_due'; 
$route['searchCustomerDue'] = 'Administrator/Customer/search_customer_due';
$route['cusDuePrint/(:any)'] = 'Administrator/Reports/cusDuePrint/$1';
$route['searchCustomerPayments'] = 'Administrator/Customer/search_customer_payments';
$route['paymentAndReport/(:any)'] = 'Administrator/Customer/paymentAndReport/$1';
$route['customerDuePaymentPrint'] = 'Administrator/Reports/customer_due_payment';

$route['user'] = 'Administrator/User_management';
$route['get_users'] = 'Administrator/User_management/getUsers';
$route['get_all_users'] = 'Administrator/User_management/getAllUsers';
$route['userInsert'] = 'Administrator/User_management/user_Insert';
$route['userUpdate'] = 'Administrator/User_management/userupdate';
$route['userEdit/(:any)'] = 'Administrator/User_management/edit/$1';
$route['userDeactive/(:any)'] = 'Administrator/User_management/userDeactive/$1';
$route['userActive/(:any)'] = 'Administrator/User_management/userActive/$1';
$route['access/(:any)'] = 'Administrator/User_management/user_access/$1';
$route['get_user_access'] = 'Administrator/User_management/getUserAccess';
$route['profile'] = 'Administrator/User_management/profile';
$route['password_change'] = 'Administrator/User_management/password_change';
$route['define_access/(:any)'] = 'Administrator/User_management/define_access/$1';
$route['add_user_access'] = 'Administrator/User_management/addUserAccess';
$route['upload_user_image'] = 'Administrator/User_management/uploadUserImage';
$route['user_activity'] = 'Administrator/User_management/userActivity';
$route['get_user_activity'] = 'Administrator/User_management/getUserActivity';
$route['delete_user_activity'] = 'Administrator/User_management/deleteUserActivity';

$route['brunch'] = 'Administrator/Page/brunch';
$route['add_branch'] = 'Administrator/Page/addBranch';
$route['update_branch'] = 'Administrator/Page/updateBranch';
$route['brunchEdit'] = 'Administrator/Page/brunch_edit';
$route['brunchUpdate'] = 'Administrator/Page/brunch_update';
$route['brunchDelete'] = 'Administrator/Page/brunch_delete';
$route['get_branches'] = 'Administrator/Page/getBranches';
$route['get_current_branch'] = 'Administrator/Page/getCurrentBranch';
$route['change_branch_status'] = 'Administrator/Page/changeBranchStatus';

$route['companyProfile'] = 'Administrator/Page/company_profile';
$route['company_profile_Update'] = 'Administrator/Page/company_profile_Update';
$route['company_profile_insert'] = 'Administrator/Page/company_profile_insert';
$route['get_company_profile'] = 'Administrator/Page/getCompanyProfile';

$route['employee'] = 'Administrator/employee';
$route['get_employees'] = 'Administrator/Employee/getEmployees';
$route['employeeInsert'] = 'Administrator/Employee/employee_insert/';
$route['emplists/(:any)'] = 'Administrator/Employee/emplists/$1';
$route['employeeEdit/(:any)'] = 'Administrator/Employee/employee_edit/$1';
$route['employeeUpdate'] = 'Administrator/Employee/employee_Update';
$route['employeeDelete'] = 'Administrator/Employee/employee_Delete';
$route['employeeActive'] = 'Administrator/Employee/active';
// $route['salarypayment'] = 'Administrator/Employee/employeesalarypayment';
// $route['add_employee_payment'] = 'Administrator/Employee/addEmployeePayment';
// $route['update_employee_payment'] = 'Administrator/Employee/updateEmployeePayment';
// $route['delete_employee_payment'] = 'Administrator/Employee/deleteEmployeePayment';
// $route['editEmployeeSalary/(:any)'] = 'Administrator/Employee/edit_employee_salary/$1';
// $route['employeesalaryreport'] = 'Administrator/Employee/employeesalaryreport';
// $route['get_employee_payments'] = 'Administrator/Employee/getEmployeePayments';
// $route['get_salary_summary'] = 'Administrator/Employee/getSalarySummary';
// $route['get_payable_salary'] = 'Administrator/Employee/getPayableSalary';

//salary Payment
$route['salary_payment']                = 'Administrator/Employee/employeePayment';
$route['check_payment_month']           = 'Administrator/Employee/checkPaymentMonth';
$route['get_payments']                  = 'Administrator/Employee/getPayments';
$route['get_salary_details']            = 'Administrator/Employee/getSalaryDetails';
$route['add_salary_payment']            = 'Administrator/Employee/saveSalaryPayment';
$route['update_salary_payment']         = 'Administrator/Employee/updateSalaryPayment';
$route['salary_payment_report']         = 'Administrator/Employee/employeePaymentReport';
$route['delete_payment']                = 'Administrator/Employee/deletePayment';

$route['designation'] = 'Administrator/Employee/designation/';
$route['insertDesignation'] = 'Administrator/Employee/insert_designation';
$route['designationedit/(:any)'] = 'Administrator/Employee/designationedit/$1';
$route['designationUpdate'] = 'Administrator/Employee/designationupdate/';
$route['designationdelete'] = 'Administrator/Employee/designationdelete';

$route['depertment'] = 'Administrator/Employee/depertment';
$route['insertDepertment'] = 'Administrator/Employee/insert_depertment';
$route['depertmentdelete'] = 'Administrator/Employee/depertmentdelete/';
$route['depertmentedit/(:any)'] = 'Administrator/Employee/depertmentedit/$1';
$route['depertmentupdate'] = 'Administrator/Employee/depertmentupdate';

$route['month'] = 'Administrator/Employee/month';
$route['insertMonth'] = 'Administrator/Employee/insert_month';
$route['editMonth/(:any)'] = 'Administrator/Employee/editMonth/$1';
$route['updateMonth'] = 'Administrator/Employee/updateMonth';
$route['get_months'] = 'Administrator/Employee/getMonths';
$route['get_shifts'] = 'Administrator/Employee/getShifts';

$route['get_cash_transactions'] = 'Administrator/Account/getCashTransactions';
$route['cashTransaction'] = 'Administrator/Account/cash_transaction';
$route['get_cash_transaction_code'] = 'Administrator/Account/getCashTransactionCode';
$route['add_cash_transaction'] = 'Administrator/Account/addCashTransaction';
$route['update_cash_transaction'] = 'Administrator/Account/updateCashTransaction';
$route['delete_cash_transaction'] = 'Administrator/Account/deleteCashTransaction';
$route['transactionEdit'] = 'Administrator/Account/cash_transaction_edit';
$route['viewTransaction/(:any)'] = 'Administrator/Account/viewTransaction/$1';

$route['account'] = 'Administrator/Account';
$route['add_account'] = 'Administrator/Account/addAccount';
$route['accountEdit'] = 'Administrator/Account/account_edit';
$route['update_account'] = 'Administrator/Account/updateAccount';
$route['delete_account'] = 'Administrator/Account/deleteAccount';
$route['get_accounts'] = 'Administrator/Account/getAccounts';
$route['get_cash_and_bank_balance'] = 'Administrator/Account/getCashAndBankBalance';
 
$route['TransactionReport'] = 'Administrator/Account/all_transaction_report'; 
$route['TransactionReportSearch'] = 'Administrator/Account/transaction_report_search';
$route['transactionReportPrint'] = 'Administrator/Reports/transaction_report_print';
$route['bank_transaction_report'] = 'Administrator/Account/bankTransactionReprot';
$route['deposit'] = 'Administrator/Account/deposit';
$route['depositSearch'] = 'Administrator/Account/deposit_search';
$route['depositPrint'] = 'Administrator/Reports/deposit_print';
$route['withdraw'] = 'Administrator/Account/withdraw';
$route['withdrawSearch'] = 'Administrator/Account/withdraw_search';
$route['withdrawPrint'] = 'Administrator/Reports/withdraw_print';
$route['expense'] = 'Administrator/Account/expense';
$route['expenseSearch'] = 'Administrator/Account/expense_search';
$route['expensePrint'] = 'Administrator/Reports/expense_print';
$route['get_other_income_expense'] = 'Administrator/Account/getOtherIncomeExpense';
$route['income'] = 'Administrator/Account/income';
$route['incomeSearch'] = 'Administrator/Account/income_search';
$route['incomePrint'] = 'Administrator/Reports/income_print';

$route['cashView'] = 'Administrator/Account/cash_view';
$route['cashView'] = 'Administrator/Account/cash_view';
$route['cashSearch'] = 'Administrator/Account/cash_view';
$route['cash_ledger'] = 'Administrator/Account/cashLedger';
$route['get_cash_ledger'] = 'Administrator/Account/getCashLedger';
$route['cashPrint'] = 'Administrator/Reports/cashview_print';
$route['cashStatment'] = 'Administrator/Reports/cashStatment';
$route['cashStatmentList'] = 'Administrator/Reports/cashStatmentList';
$route['cashStatmentListPrint'] = 'Administrator/Reports/cashStatmentListPrint';
$route['day_book'] = 'Administrator/Reports/dayBook';

$route['BalanceSheet'] = 'Administrator/Reports/balanceSheet';
$route['balance_sheet'] = 'Administrator/Reports/balance_sheet';
$route['get_balance_sheet'] = 'Administrator/Reports/getBalanceSheet';
$route['balanceSheetList'] = 'Administrator/Reports/balanceSheetList';
$route['balanceSheetListPrint'] = 'Administrator/Reports/balanceSheetListPrint';


$route['price_list'] = 'Administrator/Reports/price_list';
$route['price_list_report'] = 'Administrator/Reports/price_list_report';
$route['price_listprint'] = 'Administrator/Reports/price_list_print';


$route['bank'] = 'Administrator/Account/add_bank';
$route['insertBank'] = 'Administrator/Account/insert_Bank';
$route['bankEdit/(:any)'] = 'Administrator/Account/Bankedit/$1';
$route['updateBank'] = 'Administrator/Account/Update_Bank';
$route['bankDelete'] = 'Administrator/Account/Bankdelete';

$route['check/pending/list'] 	=	'Administrator/Check/check_pendaing_date_list';
$route['check/reminder/list'] 	=	'Administrator/Check/check_reminder_date_list';
$route['check/dis/list'] 	=	'Administrator/Check/check_dishonor_date_list';
$route['check/paid/list'] 	=	'Administrator/Check/check_paid_date_list';
$route['check/list'] 		=	'Administrator/Check/check_list';
$route['check/paid/submit/(:any)'] 	=	'Administrator/Check/check_paid_submission/$1';
$route['check/dishonor/submit/(:any)'] 	=	'Administrator/Check/check_dishonor_submission/$1';
$route['check/entry'] 			=	'Administrator/Check/check_entry_page';
$route['check/store'] 			=	'Administrator/Check/check_date_store';
$route['check/view/(:any)'] 	=	'Administrator/Check/check_view_page/$1';
$route['check/edit/(:any)'] 	=	'Administrator/Check/check_edit_page/$1';
$route['check/update/(:any)'] 	=	'Administrator/Check/check_update_info/$1';
$route['check/delete/(:any)'] 	=	'Administrator/Check/check_delete_info/$1';

$route['BalanceSheetReportBranch/(:any)'] = 'Administrator/Reports/balance_sheet_report_branch_wise/$1';

$route['business_monitor'] = 'BusinessMonitor/business_monitor_page';
$route['date_to_date_top_sale'] = 'BusinessMonitor/date_to_date_top_sale';
$route['date_to_date_top_paid_cus'] = 'BusinessMonitor/date_to_date_top_paid_cus';

/* $route['addgeneric'] = 'Setting/addgeneric'; */

$route['userName'] = 'Administrator/User_management/all_user_name';

// Transfer
$route['product_transfer'] = 'Administrator/Transfer/productTransfer';
$route['product_transfer/(:any)'] = 'Administrator/Transfer/transferEdit/$1';
$route['add_product_transfer'] = 'Administrator/Transfer/addProductTransfer';
$route['update_product_transfer'] = 'Administrator/Transfer/updateProductTransfer';
$route['delete_transfer'] = 'Administrator/Transfer/deleteTransfer';
$route['transfer_list'] = 'Administrator/Transfer/transferList';
$route['get_transfers'] = 'Administrator/Transfer/getTransfers';
$route['get_transfer_details'] = 'Administrator/Transfer/getTransferDetails';
$route['received_list'] = 'Administrator/Transfer/receivedList';
$route['get_receives'] = 'Administrator/Transfer/getReceives';
$route['transfer_invoice/(:any)'] = 'Administrator/Transfer/transferInvoice/$1';

// Banks
$route['bank_accounts'] = 'Administrator/Account/bankAccounts';
$route['add_bank_account'] = 'Administrator/Account/addBankAccount';
$route['update_bank_account'] = 'Administrator/Account/updateBankAccount';
$route['get_bank_accounts'] = 'Administrator/Account/getBankAccounts';
$route['change_account_status'] = 'Administrator/Account/changeAccountStatus';

// Bank Transactions
$route['bank_transactions'] = 'Administrator/Account/bankTransactions';
$route['add_bank_transaction'] = 'Administrator/Account/addBankTransaction';
$route['update_bank_transaction'] = 'Administrator/Account/updateBankTransaction';
$route['get_bank_transactions'] = 'Administrator/Account/getBankTransactions';
$route['get_all_bank_transactions'] = 'Administrator/Account/getAllBankTransactions';
$route['remove_bank_transaction'] = 'Administrator/Account/removeBankTransaction';
$route['get_bank_balance'] = 'Administrator/Account/getBankBalance';

$route['cash_view'] = 'Administrator/Account/cashView';
$route['bank_ledger'] = 'Administrator/Account/bankLedger';

// Graph
$route['graph'] = 'Administrator/Graph/graph';
$route['get_graph_data'] = 'Administrator/Graph/getGraphData';

// SMS
$route['sms'] = 'Administrator/SMS';
$route['send_sms'] = 'Administrator/SMS/sendSms';
$route['send_bulk_sms'] = 'Administrator/SMS/sendBulkSms';
$route['sms_settings'] = 'Administrator/SMS/smsSettings';
$route['get_sms_settings'] = 'Administrator/SMS/getSmsSettings';
$route['save_sms_settings'] = 'Administrator/SMS/saveSmsSettings';

$route['user_login'] = 'Login/userLogin';
$route['database_backup'] = 'Administrator/Page/databaseBackup';


// Loan
$route['loan_transactions'] = 'Administrator/Loan/loanTransactions';
$route['get_loan_transactions'] = 'Administrator/Loan/getLoanTransactions';
$route['get_loan_initial_balance'] = 'Administrator/Loan/getLoanInitialBalance';
$route['add_loan_transaction'] = 'Administrator/Loan/addLoanTransaction';
$route['update_loan_transaction'] = 'Administrator/Loan/updateLoanTransaction';
$route['remove_loan_transaction'] = 'Administrator/Loan/removeLoanTransaction';
$route['get_loan_balance'] = 'Administrator/Loan/getLoanBalance';
$route['loan_view'] = 'Administrator/Loan/loanView';
$route['loan_transaction_report'] = 'Administrator/Loan/loanTransactionReprot';
$route['get_all_loan_transactions'] = 'Administrator/Loan/getAllLoanTransactions';
$route['loan_ledger'] = 'Administrator/Loan/loanLedger';


//loan account
$route['loan_accounts'] = 'Administrator/Loan/loanAccounts';
$route['add_loan_account'] = 'Administrator/Loan/addLoanAccount';
$route['update_loan_account'] = 'Administrator/Loan/updateLoanAccount';
$route['get_loan_accounts'] = 'Administrator/Loan/getLoanAccounts';
$route['change_loan_account_status'] = 'Administrator/Loan/changeLoanAccountStatus';


//investment
$route['investment_transactions'] = 'Administrator/Invest/investmentTransactions';
$route['get_investment_transactions'] = 'Administrator/Invest/getInvestmentTransactions';
$route['add_investment_transaction'] = 'Administrator/Invest/addInvestmentTransaction';
$route['update_investment_transaction'] = 'Administrator/Invest/updateInvestmentTransaction';
$route['remove_investment_transaction'] = 'Administrator/Invest/removeInvestmentTransaction';
$route['get_investment_balance'] = 'Administrator/Invest/getInvestmentBalance';
$route['investment_view'] = 'Administrator/Invest/investmentView';
$route['investment_transaction_report'] = 'Administrator/Invest/investmentTransactionReprot';
$route['get_all_investment_transactions'] = 'Administrator/Invest/getAllInvestmentTransactions';
$route['investment_ledger'] = 'Administrator/Invest/investmentLedger';


//investment account
$route['investment_account'] = 'Administrator/Invest/investmentAccount';
$route['add_investment_account'] = 'Administrator/Invest/addInvestmentAccount';
$route['update_investment_account'] = 'Administrator/Invest/updateInvestmentAccount';
$route['delete_investment_account'] = 'Administrator/Invest/deleteInvestmentAccount';
$route['get_investment_accounts'] = 'Administrator/Invest/getInvestmentAccounts';

// Website Module
$route['pending_order'] = 'Administrator/Website/pending_order';
$route['processing_order'] = 'Administrator/Website/processing_order';
$route['way_order'] = 'Administrator/Website/way_order';
$route['delivered_order'] = 'Administrator/Website/delivered_order';
$route['get_orders'] = 'Administrator/Website/getOrders';
$route['update_order'] = 'Administrator/Website/updateOrders';

//published category
$route['published_category'] = 'Administrator/Website/published_category';
$route['insert_published_category'] = 'Administrator/Website/insert_published_category';
$route['published_category_delete'] = 'Administrator/Website/published_category_delete';
$route['edit_published_category/(:any)'] = 'Administrator/Website/edit_published_category/$1';

//published product
$route['published_product'] = 'Administrator/Website/published_product';
$route['get_publisheds'] = 'Administrator/Website/get_publisheds'; 
$route['get_published_category'] = 'Administrator/Website/get_published_category';
$route['add_published'] = 'Administrator/Website/add_published';
$route['update_published'] = 'Administrator/Website/update_published';
$route['status_published'] = 'Administrator/Website/status_published';
$route['delete_published'] = 'Administrator/Website/delete_published';

//order
$route['order_invoice_print/(:any)'] = 'Administrator/Website/order_invoice_print/$1';
$route['get_orders_record'] = 'Administrator/Website/getOrdersRecord';

//image gallery
$route['imagegallery'] = 'Administrator/Website/imagegallery';
$route['get_image_gallery'] = 'Administrator/Website/get_image_gallery';
$route['add_image_gallery'] = 'Administrator/Website/add_image_gallery';
$route['update_image_gallery'] = 'Administrator/Website/update_image_gallery';
$route['delete_image_gallery'] = 'Administrator/Website/delete_image_gallery';

//ourshape
$route['ourshape'] = 'Administrator/Website/ourshape';
$route['get_shape'] = 'Administrator/Website/get_shape';
$route['add_shapes'] = 'Administrator/Website/add_shapes';
$route['update_shapes'] = 'Administrator/Website/update_shapes';
$route['delete_shape'] = 'Administrator/Website/delete_shape';

//our client
$route['ourclient'] = 'Administrator/Website/ourclient';
$route['get_client'] = 'Administrator/Website/get_client';
$route['add_clients'] = 'Administrator/Website/add_clients';
$route['update_clients'] = 'Administrator/Website/update_clients';
$route['delete_client'] = 'Administrator/Website/delete_client';

//slider
$route['slider'] = 'Administrator/Website/slider';
$route['get_banners'] = 'Administrator/Website/get_banners';
$route['add_banners'] = 'Administrator/Website/add_banners';
$route['update_slider'] = 'Administrator/Website/update_banners';
$route['delete_banner'] = 'Administrator/Website/delete_banner';


//add ad
$route['ad'] = 'Administrator/Website/ad';
$route['get_ads_list'] = 'Administrator/Website/get_ads';
$route['add_ads'] = 'Administrator/Website/add_ads';
$route['update_ad'] = 'Administrator/Website/update_ad';
$route['delete_ads'] = 'Administrator/Website/delete_ads';
$route['status_ads'] = 'Administrator/Website/status_ads';

//brand

$route['get_brands'] = 'Administrator/Page/getBrands';
$route['brand'] = 'Administrator/Page/add_brand';
$route['insertbrand'] = 'Administrator/Page/insert_brand';
$route['editbrand'] = 'Administrator/Page/brandedit';
$route['branddelete'] = 'Administrator/Page/branddelete';
$route['is_website_brands'] = 'Administrator/Page/is_website_brands';

//mother api content
// $route['get_mother_api_content'] = 'Administrator/Page/getMotherApiContent';

//materials
$route['materials'] = 'Administrator/Material/materials';
$route['get_materials'] = 'Administrator/Material/getMaterials';
$route['add_material'] = 'Administrator/Material/addMaterial';
$route['update_material'] = 'Administrator/Material/updateMaterial';
$route['change_material_status'] = 'Administrator/Material/changeMaterialStatus';
$route['material_stock'] = 'Administrator/Material/materialStock';
$route['get_material_stock'] = 'Administrator/Material/getMaterialStock';
$route['material_damage'] = 'Administrator/Material/materialDamage';
$route['add_material_damage'] = 'Administrator/Material/addMaterialDamage';
$route['update_material_damage'] = 'Administrator/Material/updateMaterialDamage';
$route['delete_material_damage'] = 'Administrator/Material/deleteMaterialDamage';
$route['get_material_damage'] = 'Administrator/Material/getMaterialDamage';

//Material Purchase
$route['material_purchase'] = 'Administrator/Purchase/materialPurchase';
$route['material_purchase/(:any)'] = 'Administrator/Purchase/materialPurchase/$1';
$route['add_material_purchase'] = 'Administrator/Purchase/addMaterialPurchase';
$route['update_material_purchase'] = 'Administrator/Purchase/updateMaterialPurchase';
$route['delete_material_purchase'] = 'Administrator/Purchase/deleteMaterialPurchase';
$route['material_purchase_record'] = 'Administrator/Purchase/MaterialPurchaseRecord';
$route['get_material_purchase'] = 'Administrator/Purchase/getMaterialPurchase';
$route['get_material_purchase_details'] = 'Administrator/Purchase/getMaterialPurchaseDetails';
$route['material_purchase_invoice/(:any)'] = 'Administrator/Purchase/materialPurchaseInvoice/$1';

//production
$route['production'] = 'Administrator/Production';
$route['production/edit/(:any)'] = 'Administrator/Production/edit/$1';
$route['add_production'] = 'Administrator/Production/addProduction';
$route['update_production'] = 'Administrator/Production/updateProduction';
$route['delete_production'] = 'Administrator/Production/deleteProduction';
$route['get_productions'] = 'Administrator/Production/getProductions';
$route['get_production_record'] = 'Administrator/Production/getProductionRecord';
$route['get_production_details'] = 'Administrator/Production/getProductionDetails';
$route['get_production_products'] = 'Administrator/Production/getProductionProducts';
$route['productions'] = 'Administrator/Production/productions';
$route['production_invoice/(:any)'] = 'Administrator/Production/productionInvoice/$1';