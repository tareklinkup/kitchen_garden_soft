<style>
    #userAccess * {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 14px;
    }

    #userAccess h2{
        font-size: 16px;
        font-weight: bold;
        border-top: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        text-transform: uppercase;
        padding: 5px;
    }

    #userAccess ul {
        list-style: none;
        margin-left: 17px;
    }
</style>
<div id="userAccess">
    <div class="row">
        <div class="col-md-12 text-center">
            <div>
                <h2>User Access</h2>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <input type="checkbox" @click="checkAll" id="selectAll"> <strong style="font-size: 16px;">Select All</strong>
        </div>
    </div>
    <div class="row" id="accessRow">
        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="sales" class="group-head" @click="onClickGroupHeads"> <strong>Sales</strong>
                <ul ref="sales">
                    <li><input type="checkbox" class="access" value="sales/product" v-model="access"> Sales Entry</li>
                    <li><input type="checkbox" class="access" value="sales/service" v-model="access"> Service Entry</li>
                    <li><input type="checkbox" class="access" value="salesReturn" v-model="access"> Sale Return</li>
                    <li><input type="checkbox" class="access" value="salesrecord" v-model="access"> Sales Record</li>
                    <li><input type="checkbox" class="access" value="currentStock" v-model="access"> Stock</li>
                    <li><input type="checkbox" class="access" value="quotation" v-model="access"> Quotation Entry</li>
                </ul>
            </div>

            <div class="group">
                <input type="checkbox" id="accounts" class="group-head" @click="onClickGroupHeads"> <strong>Accounts</strong>
                <ul ref="accounts">
                    <li><input type="checkbox" class="access" value="cashTransaction" v-model="access"> Cash Transactions</li>
                    <li><input type="checkbox" class="access" value="bank_transactions" v-model="access"> Bank Transactions</li>
                    <li><input type="checkbox" class="access" value="customerPaymentPage" v-model="access"> Customer Payment</li>
                    <li><input type="checkbox" class="access" value="supplierPayment" v-model="access"> Supplier Payment</li>
                    <li><input type="checkbox" class="access" value="cash_view" v-model="access"> Cash View</li>
                    <li><input type="checkbox" class="access" value="account" v-model="access"> Transaction Accounts</li>
                    <li><input type="checkbox" class="access" value="bank_accounts" v-model="access"> Bank Accounts</li>
                    <li><input type="checkbox" class="access" value="check/entry" v-model="access"> New Cheque Entry</li>
                    <li><input type="checkbox" class="access" value="check/list" v-model="access"> Cheque List</li>
                    <li><input type="checkbox" class="access" value="check/reminder/list" v-model="access"> Reminder Cheque List</li>
                    <li><input type="checkbox" class="access" value="check/pending/list" v-model="access"> Pending Cheque List</li>
                    <li><input type="checkbox" class="access" value="check/dis/list" v-model="access"> Dishonered Cheque List</li>
                    <li><input type="checkbox" class="access" value="check/paid/list" v-model="access"> Paid Cheque List</li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="salesReports" class="group-head" @click="onClickGroupHeads"> <strong>Sales Reports</strong>
                <ul ref="salesReports">
                    <li><input type="checkbox" class="access" value="salesinvoice" v-model="access"> Sales Invoice</li>
                    <li><input type="checkbox" class="access" value="returnList" v-model="access"> Sales Return List</li>
                    <li><input type="checkbox" class="access" value="sale_return_details" v-model="access"> Sales Return Details</li>
                    <li><input type="checkbox" class="access" value="customerDue" v-model="access"> Customer Due List</li>
                    <li><input type="checkbox" class="access" value="customerPaymentReport" v-model="access"> Customer Payment Report</li>
                    <li><input type="checkbox" class="access" value="customer_payment_history" v-model="access"> Customer Payment History</li>
                    <li><input type="checkbox" class="access" value="customerlist" v-model="access"> Customer List</li>
                    <li><input type="checkbox" class="access" value="price_list" v-model="access"> Product Price List</li>
                    <li><input type="checkbox" class="access" value="quotation_invoice_report" v-model="access"> Quotation Invoice</li>
                    <li><input type="checkbox" class="access" value="quotation_record" v-model="access"> Quotation Record</li>
                </ul>
            </div>

            <div class="group">
                <input type="checkbox" id="accountsReports" class="group-head" @click="onClickGroupHeads"> <strong>Accounts Reports</strong>
                <ul ref="accountsReports">
                    <li><input type="checkbox" class="access" value="TransactionReport" v-model="access"> Cash Transaction Report</li>
                    <li><input type="checkbox" class="access" value="bank_transaction_report" v-model="access"> Bank Transaction Report</li>
                    <li><input type="checkbox" class="access" value="cash_ledger" v-model="access"> Cash Ledger</li>
                    <li><input type="checkbox" class="access" value="bank_ledger" v-model="access"> Bank Ledger</li>
                    <li><input type="checkbox" class="access" value="cash_view" v-model="access"> Cash View</li>
                    <li><input type="checkbox" class="access" value="cashStatment" v-model="access"> Cash Statement</li>
                    <li><input type="checkbox" class="access" value="balance_sheet" v-model="access"> Balance Sheet</li>
                    <li><input type="checkbox" class="access" value="BalanceSheet" v-model="access"> Balance In Out</li>
                    <li><input type="checkbox" class="access" value="profitLoss" v-model="access"> Profit/Loss Report</li>
                    <li><input type="checkbox" class="access" value="day_book" v-model="access"> Day Book</li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="purchase" class="group-head" @click="onClickGroupHeads"> <strong>Purchase</strong>
                <ul ref="purchase">
                    <li><input type="checkbox" class="access" value="purchase" v-model="access"> Purchase Entry</li>
                    <li><input type="checkbox" class="access" value="purchaseReturns" v-model="access"> Purchase Return</li>
                    <li><input type="checkbox" class="access" value="purchaseRecord" v-model="access"> Purchase Record</li>
                    <li><input type="checkbox" class="access" value="AssetsEntry" v-model="access"> Assets Entry</li>
                </ul>
            </div>
            <div class="group">
                <input type="checkbox" id="hrPayroll" class="group-head" @click="onClickGroupHeads"> <strong>HR & Payroll</strong>
                <ul ref="hrPayroll">
                    <li><input type="checkbox" class="access" value="salary_payment" v-model="access"> Salary Payment</li>
                    <li><input type="checkbox" class="access" value="employee" v-model="access"> Add Employee</li>
                    <li><input type="checkbox" class="access" value="emplists/all" v-model="access"> All Employee List</li>
                    <li><input type="checkbox" class="access" value="emplists/active" v-model="access"> Active Employee List</li>
                    <li><input type="checkbox" class="access" value="emplists/deactive" v-model="access"> Deactive Employee List</li>
                    <li><input type="checkbox" class="access" value="designation" v-model="access"> Add Designation</li>
                    <li><input type="checkbox" class="access" value="depertment" v-model="access"> Add Department</li>
                    <li><input type="checkbox" class="access" value="month" v-model="access"> Add Month</li>
                    <li><input type="checkbox" class="access" value="salary_payment_report" v-model="access"> Salary Payment Report</li>
                </ul>
            </div>
            
            <div class="group">
                <input type="checkbox" id="loan" class="group-head" @click="onClickGroupHeads"> <strong>Loan</strong>
                <ul ref="loan">
                    <li><input type="checkbox" class="access" value="loan_transactions" v-model="access"> Loan Transection</li>
                    <li><input type="checkbox" class="access" value="loan_view" v-model="access"> Loan View</li>
                    <li><input type="checkbox" class="access" value="loan_transaction_report" v-model="access"> Loan Transaction Report</li>
                    <li><input type="checkbox" class="access" value="loan_ledger" v-model="access"> Loan Ledger</li>
                    <li><input type="checkbox" class="access" value="loan_accounts" v-model="access"> Loan Account</li>
                </ul>
            </div>
            
            <div class="group">
                <input type="checkbox" id="investment" class="group-head" @click="onClickGroupHeads"> <strong>Investment</strong>
                <ul ref="investment">
                    <li><input type="checkbox" class="access" value="investment_transactions" v-model="access"> Investment Transection</li>
                    <li><input type="checkbox" class="access" value="investment_view" v-model="access"> Investment View</li>
                    <li><input type="checkbox" class="access" value="investment_transaction_report" v-model="access"> Investment Transaction Report</li>
                    <li><input type="checkbox" class="access" value="investment_ledger" v-model="access"> Investment Ledger</li>
                    <li><input type="checkbox" class="access" value="investment_accounts" v-model="access"> Investment Account</li>
                </ul>
            </div>
        </div>
        <div class="col-md-3">
            <div class="group">
                <input type="checkbox" id="purchaseReports" class="group-head" @click="onClickGroupHeads"> <strong>Purchase Reports</strong>
                <ul ref="purchaseReports">
                    <li><input type="checkbox" class="access" value="assets_report" v-model="access"> Assets Report</li>
                    <li><input type="checkbox" class="access" value="purchaseInvoice" v-model="access"> Purchase Invoice</li>
                    <li><input type="checkbox" class="access" value="supplierDue" v-model="access"> Supplier Due</li>
                    <li><input type="checkbox" class="access" value="supplierPaymentReport" v-model="access"> Supplier Payment Report</li>
                    <li><input type="checkbox" class="access" value="supplierList" v-model="access"> Supplier List</li>
                    <li><input type="checkbox" class="access" value="returnsList" v-model="access"> Purchase Return List</li>
                    <li><input type="checkbox" class="access" value="purchase_return_details" v-model="access"> Purchase Return Details</li>
                    <li><input type="checkbox" class="access" value="reorder_list" v-model="access"> Re-Order List</li>
                </ul>
            </div>
            <div class="group">
                <input type="checkbox" id="admin" class="group-head" @click="onClickGroupHeads"> <strong>Administrator</strong>
                <ul ref="admin">
                    <li><input type="checkbox" class="access" value="sms" v-model="access"> Send SMS</li>
                    <li><input type="checkbox" class="access" value="product" v-model="access"> Product Entry</li>
                    <li><input type="checkbox" class="access" value="productlist" v-model="access"> Product List</li>
                    <li><input type="checkbox" class="access" value="product_ledger" v-model="access"> Product Ledger</li>
                    <li><input type="checkbox" class="access" value="damageEntry" v-model="access"> Damage Entry</li>
                    <li><input type="checkbox" class="access" value="damageList" v-model="access"> Damage List</li>
                    <li><input type="checkbox" class="access" value="product_transfer" v-model="access"> Product Transfer</li>
                    <li><input type="checkbox" class="access" value="transfer_list" v-model="access"> Transfer List</li>
                    <li><input type="checkbox" class="access" value="received_list" v-model="access"> Received List</li>
                    <li><input type="checkbox" class="access" value="customer" v-model="access"> Customer Entry</li>
                    <li><input type="checkbox" class="access" value="supplier" v-model="access"> Supplier Entry</li>
                    <!-- <li><input type="checkbox" class="access" value="brunch" v-model="access"> Add Branch</li> -->
                    <li><input type="checkbox" class="access" value="category" v-model="access"> Category Entry</li>
                    <li><input type="checkbox" class="access" value="unit" v-model="access"> Unit Entry</li>
                    <li><input type="checkbox" class="access" value="area" v-model="access"> Add Area</li>
                    <li><input type="checkbox" class="access" value="companyProfile" v-model="access"> Company Profile</li>
                    <li><input type="checkbox" class="access" value="user" v-model="access"> Create User</li>
                    <li><input type="checkbox" class="access" value="database_backup" v-model="access"> Database Backup</li>
                    <li><input type="checkbox" class="access" value="graph" v-model="access"> Business Monitor</li>
                </ul>
            </div>
            <div class="group">
                <input type="checkbox" id="website" class="group-head" @click="onClickGroupHeads"> <strong>Website Module</strong>
                <ul ref="website">
                    <li><input type="checkbox" class="access" value="slider" v-model="access">Slider Entry</li>
                    <li><input type="checkbox" class="access" value="pending_order" v-model="access">Pending Order</li>
                    <li><input type="checkbox" class="access" value="processing_order" v-model="access">On Processing Order</li>
                    <li><input type="checkbox" class="access" value="way_order" v-model="access">On The Way Order</li>
                    <li><input type="checkbox" class="access" value="delivered_order" v-model="access">Delevered Order</li>
                    <li><input type="checkbox" class="access" value="ad" v-model="access">Ad Entry </li>
                    <!-- <li><input type="checkbox" class="access" value="published_category" v-model="access">Published Category</li>                   
                    <li><input type="checkbox" class="access" value="published_product" v-model="access">Published Product</li> -->
                    <li><input type="checkbox" class="access" value="ourshape" v-model="access">Our Shape</li>                   
                    <li><input type="checkbox" class="access" value="imagegallery" v-model="access">Photo Gallery</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 text-right">
            <button class="btn btn-success" @click="addUserAccess">Save</button>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
    new Vue({
        el: '#userAccess',
        data() {
            return {
                userId: parseInt('<?php echo $userId;?>'),
                access: []
            }
        },
        mounted() {
            let accessCheckboxes = document.querySelectorAll('.access');
            accessCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('click', () => {
                    this.makeChecked();
                })
            })
        },
        async created(){
            await axios.post('/get_user_access', {userId: this.userId}).then(res => {
                let r = res.data;
                if(r != ''){
                    this.access = JSON.parse(r);
                }
            })
            this.makeChecked();
        },
        methods: {
            makeChecked(){
                groups = document.querySelectorAll('.group');
                groups.forEach(group => {
                    let groupHead = group.querySelector('.group-head');
                    let accessCheckboxes = group.querySelectorAll('ul li input').length;
                    let checkedAccessCheckBoxes = group.querySelectorAll('ul li input:checked').length;
                    if(accessCheckboxes == checkedAccessCheckBoxes){
                        groupHead.checked = true;
                    } else {
                        groupHead.checked = false;
                    }
                })

                let selectAllCheckbox = document.querySelector('#selectAll');
                let totalAccessCheckboxes = document.querySelectorAll('.access').length;
                let totalCheckedAccessCheckBoxes = document.querySelectorAll('.access:checked').length;

                if(totalAccessCheckboxes == totalCheckedAccessCheckBoxes){
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.checked = false;
                }
            },
            async onClickGroupHeads() {
                let groupHead = event.target;
                let ul = groupHead.parentNode.querySelector('ul');
                let accessCheckboxes = ul.querySelectorAll('li input');

                if(groupHead.checked){
                    accessCheckboxes.forEach(checkbox => {
                        this.access.push(checkbox.value);
                    })
                } else {
                    accessCheckboxes.forEach(checkbox => {
                        let ind = this.access.findIndex(a => a == checkbox.value);
                        this.access.splice(ind, 1);
                    })
                }
                this.access = this.access.filter((v, i, a) => a.indexOf(v) === i);
                await new Promise(r => setTimeout(r, 200));
                this.makeChecked();
            },
            async checkAll(){
                if(event.target.checked){
                    let accessCheckboxes = document.querySelectorAll('.access');
                    accessCheckboxes.forEach(checkbox => {
                        this.access.push(checkbox.value)
                    })
                } else {
                    this.access = [];
                }
                this.access = this.access.filter((v, i, a) => a.indexOf(v) === i);
                await new Promise(r => setTimeout(r, 200));
                this.makeChecked();
            },
            addUserAccess(){
                let data = {
                    userId: this.userId,
                    access: this.access
                }
                axios.post('/add_user_access', data).then(res => {
                    let r = res.data;
                    alert(r.message);
                })
            }
        }
    })
</script>