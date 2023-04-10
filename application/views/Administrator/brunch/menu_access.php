<div class="content_scroll">
<?php $bid = $this->session->userdata['bid'];
$sql = mysql_query("SELECT tbl_menuaccess.*, tbl_brunch.* FROM tbl_menuaccess left join tbl_brunch on tbl_brunch.brunch_id = tbl_menuaccess.branch_id WHERE tbl_menuaccess.branch_id = '$bid'");
$row = mysql_fetch_array($sql); ?>
    <div style="background:#ddd;width:100%;height:30px;margin-bottom:5px;" align="center"><span style="line-height:30px;font-size:16px;"><?php echo $row['Brunch_name'] ?> Branch</span></div>
    <form action="<?php echo base_url() ?>Administrator/branch/menu_access_Insert" method="post">
    <input type="hidden" name="brid" value="<?php echo $bid; ?>">
	
        <div class="tabContent" style="width:25%;float:left; border: 1px solid #ddd;height:445px;">
            <ul id="brunch_menu">
                <li><INPUT TYPE="CHECKBOX" <?php if($row['Accounts']==1)echo "checked";?> value="<?php echo $row['Accounts'];?>" id="Accounts" NAME="Accounts">Accounts
                    <ul id="brunch_menu">
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Cash_Transaction']==1)echo "checked";?> value="<?php echo $row['Cash_Transaction'];?>" id="CashTransaction" NAME="CashTransaction">Cash Transaction</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Account']==1)echo "checked";?> value="<?php echo $row['Add_Account'];?>" id="AddAccount" NAME="AddAccount">Add Account</li>
                    </ul>
                </li>

                <li><INPUT TYPE="CHECKBOX" <?php if($row['Current_Stock']==1)echo "checked";?> value="<?php echo $row['Current_Stock'];?>" id="CurrentStock" NAME="CurrentStock">Current Stock</li>
                <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Supplier']==1)echo "checked";?> value="<?php echo $row['Add_Supplier'];?>" id="AddSupplier" NAME="AddSupplier">Add Supplier</li>
                <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Customer']==1)echo "checked";?> value="<?php echo $row['Add_Customer'];?>" id="AddCustomer" NAME="AddCustomer">Add Customer</li>

                <li><INPUT TYPE="CHECKBOX" <?php if($row['Employee']==1)echo "checked";?> value="<?php echo $row['Employee'];?>" id="Employee" NAME="Employee">Employee
                    <ul id="brunch_menu">
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Employee']==1)echo "checked";?> value="<?php echo $row['Add_Employee'];?>" id="AddEmployee" NAME="AddEmployee">Add Employee</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Employee_List']==1)echo "checked";?> value="<?php echo $row['Employee_List'];?>" id="EmployeeList" NAME="EmployeeList">Employee List</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Designation']==1)echo "checked";?> value="<?php echo $row['Add_Designation'];?>" id="AddDesignation" NAME="AddDesignation">Add Designation</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Department']==1)echo "checked";?> value="<?php echo $row['Add_Department'];?>" id="AddDepartment" NAME="AddDepartment">Add Department</li>
                    </ul>
                </li>

                <li><INPUT TYPE="CHECKBOX" <?php if($row['Sales']==1)echo "checked";?> value="<?php echo $row['Sales'];?>" id="Sales" NAME="Sales">Sales
                    <ul id="brunch_menu">
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Product_Sales']==1)echo "checked";?> value="<?php echo $row['Product_Sales'];?>" id="ProductSales" NAME="ProductSales">Product Sales</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Sales_Return']==1)echo "checked";?> value="<?php echo $row['Sales_Return'];?>" id="SaleReturn" NAME="SaleReturn">Sales Return</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Sales_Stock']==1)echo "checked";?> value="<?php echo $row['Sales_Stock'];?>" id="SalesStock" NAME="SalesStock">Sales Stock</li>
                    </ul>
                </li>
            </ul>
        </div>
		
		
		
		<div class="tabContent" style="width:25%;float:left; border: 1px solid #ddd;height:445px;">
            <ul id="brunch_menu">

                <li><INPUT TYPE="CHECKBOX" <?php if($row['Purchase']==1)echo "checked";?> value="<?php echo $row['Purchase'];?>" id="Purchase" NAME="Purchase">Purchase
                <ul id="brunch_menu">
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Purchase_Order']==1)echo "checked";?> value="<?php echo $row['Purchase_Order'];?>" id="PurchaseOrder" NAME="PurchaseOrder">Purchase Order</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Purchase_Return']==1)echo "checked";?> value="<?php echo $row['Purchase_Return'];?>" id="PurchaseReturn" NAME="PurchaseReturn">Purchase Return</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Damage_Entry']==1)echo "checked";?> value="<?php echo $row['Damage_Entry'];?>" id="DamageEntry" NAME="DamageEntry">Damage Entry</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Purchase_Stock']==1)echo "checked";?> value="<?php echo $row['Purchase_Stock'];?>" id="PurchaseStock" NAME="PurchaseStock">Purchase Stock</li>
                </ul>
              </li>

              <li><INPUT TYPE="CHECKBOX" <?php if($row['Settings']==1)echo "checked";?> value="<?php echo $row['Settings'];?>" id="Settings" NAME="Settings">Settings
                <ul id="brunch_menu">
					<li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Brand']==1)echo "checked";?> value="<?php echo $row['Add_Brand'];?>" id="AddBrand" NAME="AddBrand">Add Brand</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Category']==1)echo "checked";?> value="<?php echo $row['Add_Category'];?>" id="AddCategory" NAME="AddCategory">Add Category</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Product']==1)echo "checked";?> value="<?php echo $row['Add_Product'];?>" id="AddProduct" NAME="AddProduct">Add Product</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['User_Profile']==1)echo "checked";?> value="<?php echo $row['User_Profile'];?>" id="UserProfil" NAME="UserProfil">User Profile</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Unit']==1)echo "checked";?> value="<?php echo $row['Add_Unit'];?>" id="AddUnit" NAME="AddUnit">Add Unit</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Branch']==1)echo "checked";?> value="<?php echo $row['Add_Branch'];?>" id="AddBranch" NAME="AddBranch">Add Branch</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_District']==1)echo "checked";?> value="<?php echo $row['Add_District'];?>" id="AddDistrict" NAME="AddDistrict">Add District</li>
                    <li><INPUT TYPE="CHECKBOX" <?php if($row['Add_Country']==1)echo "checked";?> value="<?php echo $row['Add_Country'];?>" id="AddCountry" NAME="AddCountry">Add Country</li>
                </ul>
              </li>

            </ul>
        </div>
        
        <div class="tabContent" style="width:25%;float:left; border: 1px solid #ddd;height:445px;">
        <h3 align="center" style="border-bottom:1px #ccc solid;">Reports</h3>
            <ul id="brunch_menu">

                <li><INPUT TYPE="CHECKBOX" <?php if($row['Balance_Sheet']==1)echo "checked";?> value="<?php echo $row['Balance_Sheet'];?>" id="BalanceSheet" NAME="BalanceSheet">Balance Sheet</li>
                <li><INPUT TYPE="CHECKBOX" <?php if($row['Supplier_List']==1)echo "checked";?> value="<?php echo $row['Supplier_List'];?>" id="SupplierList" NAME="SupplierList">Supplier List</li>
                <li><INPUT TYPE="CHECKBOX" <?php if($row['Customer_List']==1)echo "checked";?> value="<?php echo $row['Customer_List'];?>" id="CustomerList" NAME="CustomerList">Customer List</li>
                
                <li><INPUT TYPE="CHECKBOX" <?php if($row['rpSales']==1)echo "checked";?> value="<?php echo $row['rpSales'];?>" id="RSales" NAME="RSales">Sales
                    <ul id="brunch_menu">
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Sales_Invoice']==1)echo "checked";?> value="<?php echo $row['Sales_Invoice'];?>" id="SalesInvoice" NAME="SalesInvoice">Sales Invoice</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Customer_Due_Report']==1)echo "checked";?> value="<?php echo $row['Customer_Due_Report'];?>" id="CustomerDueReport" NAME="CustomerDueReport">Customer Due Report</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Customer_Payment']==1)echo "checked";?> value="<?php echo $row['Customer_Payment'];?>" id="CustomerPayment" NAME="CustomerPayment">Customer Payment</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Sales_Record']==1)echo "checked";?> value="<?php echo $row['Sales_Record'];?>" id="SalesRecord" NAME="SalesRecord">Sales Record</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Sales_Return_List']==1)echo "checked";?> value="<?php echo $row['Sales_Return_List'];?>" id="SalesReturnList" NAME="SalesReturnList">Sales Return List</li>
                    </ul>
                </li>

                <li><INPUT TYPE="CHECKBOX" <?php if($row['rpPurchase']==1)echo "checked";?> value="<?php echo $row['rpPurchase'];?>" id="RPurchase" NAME="RPurchase">Purchase
                    <ul id="brunch_menu">
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Purchase_Bill']==1)echo "checked";?> value="<?php echo $row['Purchase_Bill'];?>" id="PurchaseBill" NAME="PurchaseBill">Purchase Bill</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Supplier_Due_Report']==1)echo "checked";?> value="<?php echo $row['Supplier_Due_Report'];?>" id="SupplierDueReport" NAME="SupplierDueReport">Supplier Due Report</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Supplier_Payment']==1)echo "checked";?> value="<?php echo $row['Supplier_Payment'];?>" id="SupplierPayment" NAME="SupplierPayment">Supplier Payment </li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Purchase_Record']==1)echo "checked";?> value="<?php echo $row['Purchase_Record'];?>" id="PurchaseRecord" NAME="PurchaseRecord">Purchase Record</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Purchase_Return_List']==1)echo "checked";?> value="<?php echo $row['Purchase_Return_List'];?>" id="PurchaseReturnList" NAME="PurchaseReturnList">Purchase Return List</li>
                    </ul>
                </li>
            </ul>
        </div>
		
		<div class="tabContent" style="width:23%;float:left; border: 1px solid #ddd;height:445px;">
            <ul id="brunch_menu">
			
                <li><INPUT TYPE="CHECKBOX" <?php if($row['rpAccounts']==1)echo "checked";?> value="<?php echo $row['rpAccounts'];?>" id="RAccounts" NAME="RAccounts">Accounts
                    <ul id="brunch_menu">
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Expense_View']==1)echo "checked";?> value="<?php echo $row['Expense_View'];?>" id="ExpenseView" NAME="ExpenseView">Expense View</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['Cash_View']==1)echo "checked";?> value="<?php echo $row['Cash_View'];?>" id="CashsView" NAME="CashsView">Cash View</li>
                    </ul>
                </li>
				
				<li><INPUT TYPE="CHECKBOX" <?php if($row['branch_menu']==1)echo "checked";?> value="<?php echo $row['branch_menu'];?>" id="BranchMenu" NAME="BranchMenu">Branch Menu</li>
				<li><INPUT TYPE="CHECKBOX" <?php if($row['product_transfer']==1)echo "checked";?> value="<?php echo $row['product_transfer'];?>" id="ProductTransfer" NAME="ProductTransfer">Product Transfer
                    <ul id="brunch_menu">
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['product_transfer_entry']==1)echo "checked";?> value="<?php echo $row['product_transfer_entry'];?>" id="TransferEntry" NAME="TransferEntry">Transfer Entry</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['product_transfer_pending']==1)echo "checked";?> value="<?php echo $row['product_transfer_pending'];?>" id="PendingRequest" NAME="PendingRequest">Pending Transfer Request</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['product_transfer_receiving']==1)echo "checked";?> value="<?php echo $row['product_transfer_receiving'];?>" id="ReceiveRequest" NAME="ReceiveRequest">Receive Transfer Request </li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['product_transfer_list']==1)echo "checked";?> value="<?php echo $row['product_transfer_list'];?>" id="TransferList" NAME="TransferList">Transfer List</li>
                        <li><INPUT TYPE="CHECKBOX" <?php if($row['product_receive_list']==1)echo "checked";?> value="<?php echo $row['product_receive_list'];?>" id="ReceiveList" NAME="ReceiveList">Receive List</li>
                    </ul>
                </li>
            </ul>
        </div>
		<div style="text-align:center;">
		 <input type="submit" value="Submit" class="button" style="margin-top:5px;padding:5px;width:200px;">
		</div>
        
    </form>
</div> 
<script language="javascript">
    $(document).ready(function(){
        $("#Accounts").on('click',function(){
            var Accounts = $("#Accounts").is(":checked");
            if(Accounts){
                $("#Accounts").val('1');
            }else{
                $("#Accounts").val('0');
            }
        });
        $("#CashTransaction").on('click',function(){
            var CashTransaction = $("#CashTransaction").is(":checked");
            if(CashTransaction){
                $("#CashTransaction").val('1');
            }else{
                $("#CashTransaction").val('0');
            }
        });
        $("#AddAccount").on('click',function(){
            var AddAccount = $("#AddAccount").is(":checked");
            if(AddAccount){
                $("#AddAccount").val('1');
            }else{
                $("#AddAccount").val('0');
            }
        });
        $("#CurrentStock").on('click',function(){
            var CurrentStock = $("#CurrentStock").is(":checked");
            if(CurrentStock){
                $("#CurrentStock").val('1');
            }else{
                $("#CurrentStock").val('0');
            }
        });
         $("#AddSupplier").on('click',function(){
            var AddSupplier = $("#AddSupplier").is(":checked");
            if(AddSupplier){
                $("#AddSupplier").val('1');
            }else{
                $("#AddSupplier").val('0');
            }
        });
        $("#AddCustomer").on('click',function(){
            var AddCustomer = $("#AddCustomer").is(":checked");
            if(AddCustomer){
                $("#AddCustomer").val('1');
            }else{
                $("#AddCustomer").val('0');
            }
        });
        $("#Employee").on('click',function(){
            var Employee = $("#Employee").is(":checked");
            if(Employee){
                $("#Employee").val('1');
            }else{
                $("#Employee").val('0');
            }
        });
        $("#AddEmployee").on('click',function(){
            var AddEmployee = $("#AddEmployee").is(":checked");
            if(AddEmployee){
                $("#AddEmployee").val('1');
            }else{
                $("#AddEmployee").val('0');
            }
        });
        $("#EmployeeList").on('click',function(){
            var EmployeeList = $("#EmployeeList").is(":checked");
            if(EmployeeList){
                $("#EmployeeList").val('1');
            }else{
                $("#EmployeeList").val('0');
            }
        });
        $("#AddDesignation").on('click',function(){
            var AddDesignation = $("#AddDesignation").is(":checked");
            if(AddDesignation){
                $("#AddDesignation").val('1');
            }else{
                $("#AddDesignation").val('0');
            }
        });
        $("#AddDepartment").on('click',function(){
            var AddDepartment = $("#AddDepartment").is(":checked");
            if(AddDepartment){
                $("#AddDepartment").val('1');
            }else{
                $("#AddDepartment").val('0');
            }
        });
        $("#Sales").on('click',function(){
            var Sales = $("#Sales").is(":checked");
            if(Sales){
                $("#Sales").val('1');
            }else{
                $("#Sales").val('0');
            }
        });
        $("#ProductSales").on('click',function(){
            var ProductSales = $("#ProductSales").is(":checked");
            if(ProductSales){
                $("#ProductSales").val('1');
            }else{
                $("#ProductSales").val('0');
            }
        });
        $("#SaleReturn").on('click',function(){
            var SaleReturn = $("#SaleReturn").is(":checked");
            if(SaleReturn){
                $("#SaleReturn").val('1');
            }else{
                $("#SaleReturn").val('0');
            }
        });
        $("#SalesStock").on('click',function(){
            var SalesStock = $("#SalesStock").is(":checked");
            if(SalesStock){
                $("#SalesStock").val('1');
            }else{
                $("#SalesStock").val('0');
            }
        });
        $("#Purchase").on('click',function(){
            var Purchase = $("#Purchase").is(":checked");
            if(Purchase){
                $("#Purchase").val('1');
            }else{
                $("#Purchase").val('0');
            }
        });
        $("#PurchaseOrder").on('click',function(){
            var PurchaseOrder = $("#PurchaseOrder").is(":checked");
            if(PurchaseOrder){
                $("#PurchaseOrder").val('1');
            }else{
                $("#PurchaseOrder").val('0');
            }
        });
        $("#PurchaseReturn").on('click',function(){
            var PurchaseReturn = $("#PurchaseReturn").is(":checked");
            if(PurchaseReturn){
                $("#PurchaseReturn").val('1');
            }else{
                $("#PurchaseReturn").val('0');
            }
        });
        $("#DamageEntry").on('click',function(){
            var DamageEntry = $("#DamageEntry").is(":checked");
            if(DamageEntry){
                $("#DamageEntry").val('1');
            }else{
                $("#DamageEntry").val('0');
            }
        });
        $("#PurchaseStock").on('click',function(){
            var PurchaseStock = $("#PurchaseStock").is(":checked");
            if(PurchaseStock){
                $("#PurchaseStock").val('1');
            }else{
                $("#PurchaseStock").val('0');
            }
        });
        $("#Settings").on('click',function(){
            var Settings = $("#Settings").is(":checked");
            if(Settings){
                $("#Settings").val('1');
            }else{
                $("#Settings").val('0');
            }
        });
		$("#AddCategory").on('click',function(){
            var AddCategory = $("#AddCategory").is(":checked");
            if(AddCategory){
                $("#AddCategory").val('1');
            }else{
                $("#AddCategory").val('0');
            }
        });
        $("#AddProduct").on('click',function(){
            var AddProduct = $("#AddProduct").is(":checked");
            if(AddProduct){
                $("#AddProduct").val('1');
            }else{
                $("#AddProduct").val('0');
            }
        });
        $("#UserProfil").on('click',function(){
            var UserProfil = $("#UserProfil").is(":checked");
            if(UserProfil){
                $("#UserProfil").val('1');
            }else{
                $("#UserProfil").val('0');
            }
        });
        $("#AddUnit").on('click',function(){
            var AddUnit = $("#AddUnit").is(":checked");
            if(AddUnit){
                $("#AddUnit").val('1');
            }else{
                $("#AddUnit").val('0');
            }
        });
        $("#AddBranch").on('click',function(){
            var AddBranch = $("#AddBranch").is(":checked");
            if(AddBranch){
                $("#AddBranch").val('1');
            }else{
                $("#AddBranch").val('0');
            }
        });
        $("#AddDistrict").on('click',function(){
            var AddDistrict = $("#AddDistrict").is(":checked");
            if(AddDistrict){
                $("#AddDistrict").val('1');
            }else{
                $("#AddDistrict").val('0');
            }
        });
        $("#AddCountry").on('click',function(){
            var AddCountry = $("#AddCountry").is(":checked");
            if(AddCountry){
                $("#AddCountry").val('1');
            }else{
                $("#AddCountry").val('0');
            }
        });
		$("#SupplierList").on('click',function(){
            var SupplierList = $("#SupplierList").is(":checked");
            if(SupplierList){
                $("#SupplierList").val('1');
            }else{
                $("#SupplierList").val('0');
            }
        });
        $("#CustomerList").on('click',function(){
            var CustomerList = $("#CustomerList").is(":checked");
            if(CustomerList){
                $("#CustomerList").val('1');
            }else{
                $("#CustomerList").val('0');
            }
        });
        $("#RSales").on('click',function(){
            var RSales = $("#RSales").is(":checked");
            if(RSales){
                $("#RSales").val('1');
            }else{
                $("#RSales").val('0');
            }
        });
        $("#SalesInvoice").on('click',function(){
            var SalesInvoice = $("#SalesInvoice").is(":checked");
            if(SalesInvoice){
                $("#SalesInvoice").val('1');
            }else{
                $("#SalesInvoice").val('0');
            }
        });
        $("#CustomerDueReport").on('click',function(){
            var CustomerDueReport = $("#CustomerDueReport").is(":checked");
            if(CustomerDueReport){
                $("#CustomerDueReport").val('1');
            }else{
                $("#CustomerDueReport").val('0');
            }
        });
        $("#CustomerPayment").on('click',function(){
            var CustomerPayment = $("#CustomerPayment").is(":checked");
            if(CustomerPayment){
                $("#CustomerPayment").val('1');
            }else{
                $("#CustomerPayment").val('0');
            }
        });
        $("#SalesRecord").on('click',function(){
            var SalesRecord = $("#SalesRecord").is(":checked");
            if(SalesRecord){
                $("#SalesRecord").val('1');
            }else{
                $("#SalesRecord").val('0');
            }
        });
        $("#SalesReturnList").on('click',function(){
            var SalesReturnList = $("#SalesReturnList").is(":checked");
            if(SalesReturnList){
                $("#SalesReturnList").val('1');
            }else{
                $("#SalesReturnList").val('0');
            }
        });
        $("#RPurchase").on('click',function(){
            var RPurchase = $("#RPurchase").is(":checked");
            if(RPurchase){
                $("#RPurchase").val('1');
            }else{
                $("#RPurchase").val('0');
            }
        });
        $("#PurchaseBill").on('click',function(){
            var PurchaseBill = $("#PurchaseBill").is(":checked");
            if(PurchaseBill){
                $("#PurchaseBill").val('1');
            }else{
                $("#PurchaseBill").val('0');
            }
        });
        $("#SupplierDueReport").on('click',function(){
            var SupplierDueReport = $("#SupplierDueReport").is(":checked");
            if(SupplierDueReport){
                $("#SupplierDueReport").val('1');
            }else{
                $("#SupplierDueReport").val('0');
            }
        });
        $("#SupplierPayment").on('click',function(){
            var SupplierPayment = $("#SupplierPayment").is(":checked");
            if(SupplierPayment){
                $("#SupplierPayment").val('1');
            }else{
                $("#SupplierPayment").val('0');
            }
        });
        $("#PurchaseRecord").on('click',function(){
            var PurchaseRecord = $("#PurchaseRecord").is(":checked");
            if(PurchaseRecord){
                $("#PurchaseRecord").val('1');
            }else{
                $("#PurchaseRecord").val('0');
            }
        });
        $("#PurchaseReturnList").on('click',function(){
            var PurchaseReturnList = $("#PurchaseReturnList").is(":checked");
            if(PurchaseReturnList){
                $("#PurchaseReturnList").val('1');
            }else{
                $("#PurchaseReturnList").val('0');
            }
        });
        $("#RAccounts").on('click',function(){
            var RAccounts = $("#RAccounts").is(":checked");
            if(RAccounts){
                $("#RAccounts").val('1');
            }else{
                $("#RAccounts").val('0');
            }
        });
        $("#ExpenseView").on('click',function(){
            var ExpenseView = $("#ExpenseView").is(":checked");
            if(ExpenseView){
                $("#ExpenseView").val('1');
            }else{
                $("#ExpenseView").val('0');
            }
        });
		
        $("#CashsView").on('click',function(){
            var CashsView = $("#CashsView").is(":checked");
            if(CashsView){
                $("#CashsView").val('1');
            }else{
                $("#CashsView").val('0');
            }
        });

		$("#BalanceSheet").on('click',function(){
            var BalanceSheet = $("#BalanceSheet").is(":checked");
            if(BalanceSheet){
                $("#BalanceSheet").val('1');
            }else{
                $("#BalanceSheet").val('0');
            }
        });
		
		$("#AddBrand").on('click',function(){
            var AddBrand = $("#AddBrand").is(":checked");
            if(AddBrand){
                $("#AddBrand").val('1');
            }else{
                $("#AddBrand").val('0');
            }
        });

		$("#BranchMenu").on('click',function(){
            var BranchMenu = $("#BranchMenu").is(":checked");
            if(BranchMenu){
                $("#BranchMenu").val('1');
            }else{
                $("#BranchMenu").val('0');
            }
        });

		$("#ProductTransfer").on('click',function(){
            var ProductTransfer = $("#ProductTransfer").is(":checked");
            if(ProductTransfer){
                $("#ProductTransfer").val('1');
            }else{
                $("#ProductTransfer").val('0');
            }
        });

		$("#TransferEntry").on('click',function(){
            var TransferEntry = $("#TransferEntry").is(":checked");
            if(TransferEntry){
                $("#TransferEntry").val('1');
            }else{
                $("#TransferEntry").val('0');
            }
        });

		$("#PendingRequest").on('click',function(){
            var PendingRequest = $("#PendingRequest").is(":checked");
            if(PendingRequest){
                $("#PendingRequest").val('1');
            }else{
                $("#PendingRequest").val('0');
            }
        });

		$("#ReceiveRequest").on('click',function(){
            var ReceiveRequest = $("#ReceiveRequest").is(":checked");
            if(ReceiveRequest){
                $("#ReceiveRequest").val('1');
            }else{
                $("#ReceiveRequest").val('0');
            }
        });

		$("#TransferList").on('click',function(){
            var TransferList = $("#TransferList").is(":checked");
            if(TransferList){
                $("#TransferList").val('1');
            }else{
                $("#TransferList").val('0');
            }
        });

		$("#ReceiveList").on('click',function(){
            var ReceiveList = $("#ReceiveList").is(":checked");
            if(ReceiveList){
                $("#ReceiveList").val('1');
            }else{
                $("#ReceiveList").val('0');
            }
        });

    });
    
</script>