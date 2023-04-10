<style>
	#cashStatement .buttons {
		margin-top: -5px;
	}
	.account-section{
        display: flex;
        border: none;
        border-radius: 5px;
        overflow:hidden;
        margin-bottom: 20px;
    }

    .account-section h3{
        margin: 10px 0;
        padding: 0;
    }

	.account-section h4{
		margin: 0;
		margin-top: 3px;
	}

    .account-section .col1{
        background-color: #82a253;
        color: white;
        flex: 1;
		text-align: center;
		padding: 10px;
    }
    .account-section .col2{
        background-color: #edf3e2;
        flex: 2;
        padding: 10px;
        align-items: center; 
        text-align:center;
    }

</style>
<div id="cashStatement">
	<div class="row" style="border-bottom: 1px solid #ccc;">
		<div class="col-md-12">
			<form action="" class="form-inline" @submit.prevent="getStatements">
				<div class="form-group">
					<label for="">Date from</label>
					<input type="date" class="form-control" v-model="filter.dateFrom">
				</div>

				<div class="form-group">
					<label for="">to</label>
					<input type="date" class="form-control" v-model="filter.dateTo">
				</div>

				<div class="form-group buttons">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12" style="padding-top:15px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
	</div>

	<div id="printContent">
		<div class="row" style="margin-top: 15px;">
			<div class="col-md-4">
				<div class="account-section">
					<div class="col1">
						<i class="fa fa-sign-in fa-2x"></i><br>
						<h4>Cash In</h4>
					</div>
					<div class="col2">
						<h3 v-if="totalCashIn == 0"><?php echo $this->session->userdata('Currency_Name');?> 0.00</h3>
						<h3 style="display:none;" v-bind:style="{display: totalCashIn > 0 ? '' : 'none'}"><?php echo $this->session->userdata('Currency_Name');?> {{ totalCashIn | decimal }}</h3>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="account-section">
					<div class="col1">
						<i class="fa fa-sign-out fa-2x"></i><br>
						<h4>Cash Out</h4>
					</div>
					<div class="col2">
						<h3 v-if="totalCashOut == 0"><?php echo $this->session->userdata('Currency_Name');?> 0.00</h3>
						<h3 style="display:none;" v-bind:style="{display: totalCashOut > 0 ? '' : 'none'}"><?php echo $this->session->userdata('Currency_Name');?> {{ totalCashOut | decimal }}</h3>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="account-section">
					<div class="col1">
						<i class="fa fa-money fa-2x"></i><br>
						<h4>Balance</h4>
					</div>
					<div class="col2">
						<h3 v-if="cashBalance == 0"><?php echo $this->session->userdata('Currency_Name');?> 0.00</h3>
						<h3 style="display:none;" v-bind:style="{display: cashBalance == 0 ? 'none' : ''}"><?php echo $this->session->userdata('Currency_Name');?> {{ cashBalance | decimal }}</h3>
					</div>
				</div>
			</div>
		</div>

		<div class="row" style="padding-top:10px;">
			<div class="col-md-6">
				<!-- Sales -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Sales</th>
						</tr>
						<tr>
							<th>Invoice</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Received</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: sales.length > 0 ? '' : 'none'}">
						<tr v-for="sale in sales">
							<td>{{ sale.SaleMaster_InvoiceNo }}</td>
							<td>{{ sale.SaleMaster_SaleDate }}</td>
							<td>{{ sale.Customer_Name }}</td>
							<td style="text-align:right;">{{ sale.SaleMaster_PaidAmount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right;">Total</td>
							<td style="text-align:right;">
								<span v-if="sales.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: sales.length > 0 ? '' : 'none'}">{{ totalSales | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>

				<!-- Received from Customers -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Received from Customers</th>
						</tr>
						<tr>
							<th>Invoice</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Received</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: receivedFromCustomers.length > 0 ? '' : 'none'}">
						<tr v-for="payment in receivedFromCustomers">
							<td>{{ payment.CPayment_invoice }}</td>
							<td>{{ payment.CPayment_date }}</td>
							<td>{{ payment.Customer_Name }}</td>
							<td style="text-align:right;">{{ payment.CPayment_amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right;">Total</td>
							<td style="text-align:right;">
								<span v-if="receivedFromCustomers.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: receivedFromCustomers.length > 0 ? '' : 'none'}">{{ totalReceivedFromCustomers | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>

				<!-- Received from Suppliers -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Received from Suppliers</th>
						</tr>
						<tr>
							<th>Invoice</th>
							<th>Date</th>
							<th>Supplier</th>
							<th>Received</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: receivedFromSuppliers.length > 0 ? '' : 'none'}">
						<tr v-for="payment in receivedFromSuppliers">
							<td>{{ payment.SPayment_invoice }}</td>
							<td>{{ payment.SPayment_date }}</td>
							<td>{{ payment.Supplier_Name }}</td>
							<td style="text-align:right;">{{ payment.SPayment_amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="receivedFromSuppliers.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: receivedFromSuppliers.length > 0 ? '' : 'none'}">{{ totalReceivedFromSuppliers | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>

				<!-- Cash Received -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Cash Received</th>
						</tr>
						<tr>
							<th>Transaction Id</th>
							<th>Date</th>
							<th>Account Name</th>
							<th>Received</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cashReceived.length > 0 ? '' : 'none'}">
						<tr v-for="transaction in cashReceived">
							<td>{{ transaction.Tr_Id }}</td>
							<td>{{ transaction.Tr_date }}</td>
							<td>{{ transaction.Acc_Name }}</td>
							<td style="text-align:right;">{{ transaction.In_Amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="cashReceived.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: cashReceived.length > 0 ? '' : 'none'}">{{ totalCashReceived | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>

				<!-- Bank Withdraws -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="6">Bank Withdraws</th>
						</tr>
						<tr>
							<th>Sl</th>
							<th>Account Name</th>
							<th>Account Number</th>
							<th>Bank Name</th>
							<th>Date</th>
							<th>Withdraw</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: bankWithdraws.length > 0 ? '' : 'none'}">
						<tr v-for="transaction in bankWithdraws">
							<td>{{ transaction.transaction_id }}</td>
							<td>{{ transaction.account_name }}</td>
							<td>{{ transaction.account_number }}</td>
							<td>{{ transaction.bank_name }}</td>
							<td>{{ transaction.transaction_date }}</td>
							<td style="text-align:right;">{{ transaction.amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="bankWithdraws.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: bankWithdraws.length > 0 ? '' : 'none'}">{{ totalBankWithdraw | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>
				
				<!-- Initial Loan -->
				<table class="table table-bordered table-condensed" style="display: none;" v-bind:style="{display: loanInitials.length > 0 ? '' : 'none'}">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="6">Initial Loan</th>
						</tr>
						<tr>
							<th>Sl</th>
							<th>Account Name</th>
							<th>Account Number</th>
							<th>Bank Name</th>
							<th>Date</th>
							<th>Balance</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: loanInitials.length > 0 ? '' : 'none'}">
						<tr v-for="transaction in loanInitials">
							<td>{{ transaction.account_id }}</td>
							<td>{{ transaction.account_name }}</td>
							<td>{{ transaction.account_number }}</td>
							<td>{{ transaction.bank_name }}</td>
							<td>{{ transaction.save_date }}</td>
							<td style="text-align:right;">{{ transaction.initial_balance | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="loanInitials.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: loanInitials.length > 0 ? '' : 'none'}">{{ totalInitialLoan | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>
				
				<!-- Loan Received -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="6">Loan Received</th>
						</tr>
						<tr>
							<th>Sl</th>
							<th>Account Name</th>
							<th>Account Number</th>
							<th>Bank Name</th>
							<th>Date</th>
							<th>Received</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: loanReceives.length > 0 ? '' : 'none'}">
						<tr v-for="transaction in loanReceives">
							<td>{{ transaction.transaction_id }}</td>
							<td>{{ transaction.account_name }}</td>
							<td>{{ transaction.account_number }}</td>
							<td>{{ transaction.bank_name }}</td>
							<td>{{ transaction.transaction_date }}</td>
							<td style="text-align:right;">{{ transaction.amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="loanReceives.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: loanReceives.length > 0 ? '' : 'none'}">{{ totalLoanReceived | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>
				
				<!-- Invest Received -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="5">Invest Received</th>
						</tr>
						<tr>
							<th>Sl</th>
							<th>Account Code</th>
							<th>Account Name</th>
							<th>Date</th>
							<th>Received</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: investReceives.length > 0 ? '' : 'none'}">
						<tr v-for="transaction in investReceives">
							<td>{{ transaction.transaction_id }}</td>
							<td>{{ transaction.Acc_Code }}</td>
							<td>{{ transaction.Acc_Name }}</td>
							<td>{{ transaction.transaction_date }}</td>
							<td style="text-align:right;">{{ transaction.amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="4" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="investReceives.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: investReceives.length > 0 ? '' : 'none'}">{{ totalInvestReceived | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>
				<!-- Assets Sale -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Assets Sale</th>
						</tr>
						<tr>
							<th>Sl</th>
							<th>Assets Name</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: assetsSales.length > 0 ? '' : 'none'}">
						<tr v-for="payment in assetsSales">
							<td>{{ payment.as_id }}</td>
							<td>{{ payment.as_name }}</td>
							<td>{{ payment.as_amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="2" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="assetsSales.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: assetsSales.length > 0 ? '' : 'none'}">{{ totalAssetsSales | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-md-6">
				<!-- Purchase -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Purchases</th>
						</tr>
						<tr>
							<th>Invoice</th>
							<th>Date</th>
							<th>Supplier</th>
							<th>Paid</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: purchases.length > 0 ? '' : 'none'}">
						<tr v-for="purchase in purchases">
							<td>{{ purchase.PurchaseMaster_InvoiceNo }}</td>
							<td>{{ purchase.PurchaseMaster_OrderDate }}</td>
							<td>{{ purchase.Supplier_Name }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseMaster_PaidAmount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right;">Total</td>
							<td style="text-align:right;">
								<span v-if="purchases.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: purchases.length > 0 ? '' : 'none'}">{{ totalPurchase | decimal }}</span>
							</td>
						</tr>
					</tfoot>

				</table>

				<!-- Paid to Suppliers -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Paid to Suppliers</th>
						</tr>
						<tr>
							<th>Invoice</th>
							<th>Date</th>
							<th>Supplier</th>
							<th>Paid</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: paidToSuppliers.length > 0 ? '' : 'none'}">
						<tr v-for="payment in paidToSuppliers">
							<td>{{ payment.SPayment_invoice }}</td>
							<td>{{ payment.SPayment_date }}</td>
							<td>{{ payment.Supplier_Name }}</td>
							<td style="text-align:right;">{{ payment.SPayment_amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right;">Total</td>
							<td style="text-align:right;">
								<span v-if="paidToSuppliers.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: paidToSuppliers.length > 0 ? '' : 'none'}">{{ totalPaidToSuppliers | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>

				<!-- Paid to Customers -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Paid to Customers</th>
						</tr>
						<tr>
							<th>Invoice</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Paid</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: paidToCustomers.length > 0 ? '' : 'none'}">
						<tr v-for="payment in paidToCustomers">
							<td>{{ payment.CPayment_invoice }}</td>
							<td>{{ payment.CPayment_date }}</td>
							<td>{{ payment.Customer_Name }}</td>
							<td style="text-align:right;">{{ payment.CPayment_amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right;">Total</td>
							<td style="text-align:right;">
								<span v-if="paidToCustomers.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: paidToCustomers.length > 0 ? '' : 'none'}">{{ totalPaidToCustomers | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>

				<!-- Cash Paid -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Cash Paid</th>
						</tr>
						<tr>
							<th>Transaction Id</th>
							<th>Date</th>
							<th>Account Name</th>
							<th>Paid</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: cashPaid.length > 0 ? '' : 'none'}">
						<tr v-for="transaction in cashPaid">
							<td>{{ transaction.Tr_Id }}</td>
							<td>{{ transaction.Tr_date }}</td>
							<td>{{ transaction.Acc_Name }}</td>
							<td style="text-align:right;">{{ transaction.Out_Amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="cashPaid.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: cashPaid.length > 0 ? '' : 'none'}">{{ totalCashPaid | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>

				<!-- Bank Deposits -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="6">Bank Deposits</th>
						</tr>
						<tr>
							<th>Sl</th>
							<th>Account Name</th>
							<th>Account Number</th>
							<th>Bank Name</th>
							<th>Date</th>
							<th>Deposit</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: bankDeposits.length > 0 ? '' : 'none'}">
						<tr v-for="transaction in bankDeposits">
							<td>{{ transaction.transaction_id }}</td>
							<td>{{ transaction.account_name }}</td>
							<td>{{ transaction.account_number }}</td>
							<td>{{ transaction.bank_name }}</td>
							<td>{{ transaction.transaction_date }}</td>
							<td style="text-align:right;">{{ transaction.amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="bankDeposits.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: bankDeposits.length > 0 ? '' : 'none'}">{{ totalBankDeposit | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>
				
				<!-- Loan Payment -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="6">Loan Payment</th>
						</tr>
						<tr>
							<th>Sl</th>
							<th>Account Name</th>
							<th>Account Number</th>
							<th>Bank Name</th>
							<th>Date</th>
							<th>Payment</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: loanPayments.length > 0 ? '' : 'none'}">
						<tr v-for="transaction in loanPayments">
							<td>{{ transaction.transaction_id }}</td>
							<td>{{ transaction.account_name }}</td>
							<td>{{ transaction.account_number }}</td>
							<td>{{ transaction.bank_name }}</td>
							<td>{{ transaction.transaction_date }}</td>
							<td style="text-align:right;">{{ transaction.amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="loanPayments.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: loanPayments.length > 0 ? '' : 'none'}">{{ totalLoanPayment | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>

				<!-- Invest Payment -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="5">Invest Payment</th>
						</tr>
						<tr>
							<th>Sl</th>
							<th>Account Code</th>
							<th>Account Name</th>
							<th>Date</th>
							<th>Payment</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: investPayments.length > 0 ? '' : 'none'}">
						<tr v-for="transaction in investPayments">
							<td>{{ transaction.transaction_id }}</td>
							<td>{{ transaction.Acc_Code }}</td>
							<td>{{ transaction.Acc_Name }}</td>
							<td>{{ transaction.transaction_date }}</td>
							<td style="text-align:right;">{{ transaction.amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="4" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="investPayments.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: investPayments.length > 0 ? '' : 'none'}">{{ totalInvestPayment | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>

				<!-- Employee Payments -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="5">Employee Payments</th>
						</tr>
						<tr>
							<th>Employee Id</th>
							<th>Employee Name</th>
							<th>Date</th>
							<th>Month</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: employeePayments.length > 0 ? '' : 'none'}">
						<template v-for="payment in employeePayments">
							<tr v-for="detail in payment.details" v-if="detail.payment != 0">
								<td>{{ detail.Employee_ID }}</td>
								<td>{{ detail.Employee_Name }}</td>
								<td>{{ payment.payment_date }}</td>
								<td>{{ payment.month_name }}</td>
								<td style="text-align:right;">{{ detail.payment | decimal }}</td>
							</tr>
						</template>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="4" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="employeePayments.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: employeePayments.length > 0 ? '' : 'none'}">{{ totalEmployeePayments | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>
				
				<!-- Assets Cost -->
				<table class="table table-bordered table-condensed">
					<thead>
						<tr style="background: #dee4dc;">
							<th colspan="4">Assets Cost</th>
						</tr>
						<tr>
							<th>Sl</th>
							<th>Assets Name</th>
							<th>Supplier</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody style="display:none;" v-bind:style="{display: assetsCosts.length > 0 ? '' : 'none'}">
						<tr v-for="payment in assetsCosts">
							<td>{{ payment.as_id }}</td>
							<td>{{ payment.as_name }}</td>
							<td>{{ payment.as_sp_name }}</td>
							<td>{{ payment.as_amount | decimal }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right">Total</td>
							<td style="text-align:right;">
								<span v-if="assetsCosts.length == 0">0.00</span>
								<span style="display:none;" v-bind:style="{display: assetsCosts.length > 0 ? '' : 'none'}">{{ totalAssetsCost | decimal }}</span>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	new Vue({
		el: '#cashStatement',
		data() {
			return {
				filter: {
					dateFrom: moment().format('YYYY-MM-DD'),
					dateTo: moment().format('YYYY-MM-DD')
				},
				sales: [],
				purchases: [],
				receivedFromCustomers: [],
				paidToCustomers: [],
				receivedFromSuppliers: [],
				paidToSuppliers: [],
				cashReceived: [],
				cashPaid: [],
				bankDeposits: [],
				bankWithdraws: [],
				loanReceives: [],
				loanPayments: [],
				investReceives: [],
				investPayments: [],
				loanInitials: [],
				assetsCosts: [],
				assetsSales: [],
				employeePayments: []
			}
		},
		filters: {
			decimal(value) {
				return value == null ? 0.00 : parseFloat(value).toFixed(2);
			}
		},
		computed: {
			totalSales() {
				return this.sales.reduce((prev, curr) => {
					return prev + parseFloat(curr.SaleMaster_PaidAmount)
				}, 0).toFixed(2);
			},
			totalPurchase() {
				return this.purchases.reduce((prev, curr) => {
					return prev + parseFloat(curr.PurchaseMaster_PaidAmount)
				}, 0).toFixed(2);
			},
			totalReceivedFromCustomers() {
				return this.receivedFromCustomers.reduce((prev, curr) => {
					return prev + parseFloat(curr.CPayment_amount)
				}, 0).toFixed(2);
			},
			totalPaidToCustomers() {
				return this.paidToCustomers.reduce((prev, curr) => {
					return prev + parseFloat(curr.CPayment_amount)
				}, 0).toFixed(2);
			},
			totalReceivedFromSuppliers() {
				return this.receivedFromSuppliers.reduce((prev, curr) => {
					return prev + parseFloat(curr.SPayment_amount)
				}, 0).toFixed(2);
			},
			totalPaidToSuppliers() {
				return this.paidToSuppliers.reduce((prev, curr) => {
					return prev + parseFloat(curr.SPayment_amount)
				}, 0).toFixed(2);
			},
			totalCashReceived() {
				return this.cashReceived.reduce((prev, curr) => {
					return prev + parseFloat(curr.In_Amount)
				}, 0).toFixed(2);
			},
			totalCashPaid() {
				return this.cashPaid.reduce((prev, curr) => {
					return prev + parseFloat(curr.Out_Amount)
				}, 0).toFixed(2);
			},
			totalBankDeposit() {
				return this.bankDeposits.reduce((prev, curr) => {
					return prev + parseFloat(curr.amount)
				}, 0).toFixed(2);
			},
			totalBankWithdraw() {
				return this.bankWithdraws.reduce((prev, curr) => {
					return prev + parseFloat(curr.amount)
				}, 0).toFixed(2);
			},
			
			totalLoanReceived() {
				return this.loanReceives.reduce((prev, curr) => {
					return prev + parseFloat(curr.amount)
				}, 0).toFixed(2);
			},
			
			totalLoanPayment() {
				return this.loanPayments.reduce((prev, curr) => {
					return prev + parseFloat(curr.amount)
				}, 0).toFixed(2);
			},
			
			totalInvestReceived() {
				return this.investReceives.reduce((prev, curr) => {
					return prev + parseFloat(curr.amount)
				}, 0).toFixed(2);
			},
			totalInvestPayment() {
				return this.investPayments.reduce((prev, curr) => {
					return prev + parseFloat(curr.amount)
				}, 0).toFixed(2);
			},
			totalEmployeePayments(){
				return this.employeePayments.reduce((prev, curr) => {
					return prev + parseFloat(curr.total_payment_amount)
				}, 0).toFixed(2);
			},
			totalAssetsCost(){
				return this.assetsCosts.reduce((prev, curr) => {
					return prev + parseFloat(curr.as_amount)
				}, 0).toFixed(2);
			},
			totalAssetsSales(){
				return this.assetsSales.reduce((prev, curr) => {
					return prev + parseFloat(curr.as_amount)
				}, 0).toFixed(2);
			},
			totalInitialLoan(){
				return this.loanInitials.reduce((prev, curr) => {
					return prev + parseFloat(curr.initial_balance)
				}, 0).toFixed(2);
			},
			totalCashIn(){
				return parseFloat(this.totalSales) + 
					parseFloat(this.totalReceivedFromCustomers) + 
					parseFloat(this.totalReceivedFromSuppliers) + 
					parseFloat(this.totalCashReceived) + 
					parseFloat(this.totalLoanReceived) + 
					parseFloat(this.totalInvestReceived) + 
					parseFloat(this.totalInitialLoan) + 
					parseFloat(this.totalAssetsSales) + 
					parseFloat(this.totalBankWithdraw);
			},
			totalCashOut(){
				return parseFloat(this.totalPurchase) +
					parseFloat(this.totalPaidToCustomers) +
					parseFloat(this.totalPaidToSuppliers) +
					parseFloat(this.totalCashPaid) +
					parseFloat(this.totalLoanPayment) +
					parseFloat(this.totalInvestPayment) +
					parseFloat(this.totalBankDeposit) +
					parseFloat(this.totalAssetsCost) +
					parseFloat(this.totalEmployeePayments);
			},
			cashBalance(){
				return parseFloat(this.totalCashIn) -  parseFloat(this.totalCashOut);
			}			
		},
		created(){
			this.getStatements();
		},
		methods: {
			getStatements() {
				this.getSales();
				this.getPurchases();
				this.getReceivedFromCustomers();
				this.getPaidToCustomers();
				this.getPaidToSuppliers();
				this.getReceivedFromSuppliers();
				this.getCashReceived();
				this.getCashPaid();
				this.getBankDeposits();
				this.getBankWithdraws();
				this.getLoanReceived();
				this.getLoanPayments();
				this.getInvestReceived();
				this.getInvestPayments();
				this.getEmployeePayments();
				this.getAssetsCost();
				this.getAssetsSales();
			},

			getSales() {
				axios.post('/get_sales', this.filter)
					.then(res => {
						this.sales = res.data.sales;
					})
			},

			getPurchases() {
				axios.post('/get_purchases', this.filter)
					.then(res => {
						this.purchases = res.data.purchases;
					})
			},

			getReceivedFromCustomers() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					paymentType: 'received'
				}
				axios.post('/get_customer_payments', filter)
					.then(res => {
						this.receivedFromCustomers = res.data.filter(p => p.CPayment_Paymentby != 'bank');
					})
			},

			getPaidToCustomers() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					paymentType: 'paid'
				}
				axios.post('/get_customer_payments', filter)
					.then(res => {
						this.paidToCustomers = res.data.filter(p => p.CPayment_Paymentby != 'bank');
					})
			},

			getPaidToSuppliers() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					paymentType: 'paid'
				}
				axios.post('/get_supplier_payments', filter)
					.then(res => {
						this.paidToSuppliers = res.data.filter(p => p.SPayment_Paymentby != 'bank');
					})
			},

			getReceivedFromSuppliers() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					paymentType: 'received'
				}
				axios.post('/get_supplier_payments', filter)
					.then(res => {
						this.receivedFromSuppliers = res.data.filter(p => p.SPayment_Paymentby != 'bank');
					})
			},

			getCashReceived() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'received'
				}
				axios.post('/get_cash_transactions', filter)
					.then(res => {
						this.cashReceived = res.data;
					})
			},

			getCashPaid() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'paid'
				}
				axios.post('/get_cash_transactions', filter)
					.then(res => {
						this.cashPaid = res.data;
					})
			},

			getBankDeposits() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'deposit'
				}
				axios.post('/get_bank_transactions', filter)
					.then(res => {
						this.bankDeposits = res.data;
					})
			},

			getBankWithdraws() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'withdraw'
				}
				axios.post('/get_bank_transactions', filter)
					.then(res => {
						this.bankWithdraws = res.data;
					})
			},
			
			async getLoanReceived() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'Receive'
				}
				await axios.post('/get_loan_transactions', filter)
					.then(res => {
						this.loanReceives = res.data;
					})

				await axios.post('/get_loan_initial_balance', this.filter).then(res => {
					this.loanInitials = res.data.accounts;
				})
			},
			getAssetsCost(){
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					buy_or_sale: 'buy'
				}

				axios.post('/get_assets_cost', filter)
				.then(res => { 
					this.assetsCosts = res.data.assets;
				})
			},
			getAssetsSales(){
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					buy_or_sale: 'sale'
				}

				axios.post('/get_assets_cost', filter)
				.then(res => { 
					this.assetsSales = res.data.assets;
				})
			},
			getLoanPayments() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'Payment'
				}
				axios.post('/get_loan_transactions', filter)
					.then(res => {
						this.loanPayments = res.data;
					})
			},
			
			getInvestReceived() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'Receive'
				}
				axios.post('/get_investment_transactions', filter)
					.then(res => {
						this.investReceives = res.data;
					})
			},

			getInvestPayments() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'Payment'
				}
				axios.post('/get_investment_transactions', filter)
					.then(res => {
						this.investPayments = res.data;
					})
			},

			getEmployeePayments(){
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					details : true
				}
				axios.post('/get_payments', filter)
				.then(res => { 
					this.employeePayments = res.data;
				})
			},

			async print(){
				let printContent = `
					<div class="container">
						<h4 style="text-align:center">Cash Statements</h4 style="text-align:center">
						<div class="row">
							<div class="col-xs-12 text-center">
								<strong>Statement from</strong> ${this.filter.dateFrom} <strong>to</strong> ${this.filter.dateTo}
							</div>
						</div>
					</div>
					<div class="container">
						${document.querySelector('#printContent').innerHTML}
					</div>
				`;

				var printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				printWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

				printWindow.document.body.innerHTML += printContent;
				printWindow.document.head.innerHTML += `
					<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
					<style>
						th{
							text-align: center;
						}
						.account-section{
							display: flex;
							border: none;
							border-radius: 5px;
							overflow:hidden;
							margin-bottom: 20px;
						}

						.account-section h3{
							margin: 10px 0;
							padding: 0;
						}

						.account-section h4{
							margin: 0;
							margin-top: 3px;
						}

						.account-section .col1{
							background-color: #82a253;
							color: white;
							flex: 1;
							text-align: center;
							padding: 10px;
						}
						.account-section .col2{
							background-color: #edf3e2;
							flex: 2;
							padding: 10px;
							align-items: center; 
							text-align:center;
						}
					</style>
				`;

				printWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				printWindow.print();
				printWindow.close();
			}
		}
	})
</script>