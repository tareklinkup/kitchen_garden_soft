<style>
	#balanceSheet .buttons {
		margin-top: -5px;
	}

	.balancesheet-table{
		width: 100%;
		border-collapse: collapse;
	}

	.balancesheet-table thead{
		text-align: center;
	}

	.balancesheet-table tfoot{
		font-weight: bold;
		background-color: #eaf3fd;
	}

	.balancesheet-table td, .balancesheet-table th{
		border: 1px solid #ccc;
		padding: 5px;
	}
</style>
<div id="balanceSheet">
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

	<div style="display:none;" v-bind:style="{display: showReport ? '' : 'none'}">
		<div class="row" style="margin-top:15px;">
			<div class="col-xs-12">
				<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
			</div>
		</div>

		<div id="printContent">
			<div class="row" style="margin-top:15px;">
				<div class="col-xs-6">
					<table class="balancesheet-table">
						<thead>
							<tr>
								<td colspan="2">
									<h3>Cash In</h3>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Total Sales</td>
								<td style="text-align:right;">{{ totalSales | decimal }}</td>
							</tr>
							<tr>
								<td>Customer Payment Received</td>
								<td style="text-align:right;">{{ totalReceivedFromCustomers | decimal }}</td>
							</tr>
							<tr>
								<td>Cash Received</td>
								<td style="text-align:right;">{{ totalCashReceived | decimal }}</td>
							</tr>
							<tr>
								<td>Withdraw from Bank</td>
								<td style="text-align:right;">{{ totalBankWithdraw | decimal }}</td>
							</tr>
							
							<tr>
								<td>Loan Received</td>
								<td style="text-align:right;">{{ totalLoanReceived | decimal }}</td>
							</tr>
							
							<tr>
								<td>Invest Received</td>
								<td style="text-align:right;">{{ totalInvestReceived | decimal }}</td>
							</tr>
							<tr>
								<td>Supplier Payment Received</td>
								<td style="text-align:right;">{{ totalReceivedFromSuppliers | decimal }}</td>
							</tr>
							<tr>
								<td>Assets Sales</td>
								<td style="text-align:right;">{{ totalAssetsSales | decimal }}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td style="text-align:right;">Total Cash In</td>
								<td style="text-align:right;">{{ totalCashIn | decimal }}</td>
							</tr>
						</tfoot>
					</table>
				</div>

				<div class="col-xs-6">
					<table class="balancesheet-table">
						<thead>
							<tr>
								<td colspan="2">
									<h3>Cash Out</h3>
								</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Total Purchase</td>
								<td style="text-align:right;">{{ totalPurchase | decimal }}</td>
							</tr>
							<tr>
								<td>Supplier Payment Paid</td>
								<td style="text-align:right;">{{ totalPaidToSuppliers | decimal }}</td>
							</tr>
							<tr>
								<td>Cash Paid</td>
								<td style="text-align:right;">{{ totalCashPaid | decimal }}</td>
							</tr>
							<tr>
								<td>Deposit to Bank</td>
								<td style="text-align:right;">{{ totalBankDeposit | decimal }}</td>
							</tr>
							
							<tr>
								<td>Loan Payment</td>
								<td style="text-align:right;">{{ totalLoanPayment | decimal }}</td>
							</tr>
							
							<tr>
								<td>Invest Payment</td>
								<td style="text-align:right;">{{ totalInvestPayment | decimal }}</td>
							</tr>
							<tr>
								<td>Employee Payment</td>
								<td style="text-align:right;">{{ totalEmployeePayments | decimal }}</td>
							</tr>
							<tr>
								<td>Customer Payment Paid</td>
								<td style="text-align:right;">{{ totalPaidToCustomers | decimal }}</td>
							</tr>
							<tr>
								<td>Assets Cost</td>
								<td style="text-align:right;">{{ totalAssetsCost | decimal }}</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td style="text-align:right;">Total Cash Out</td>
								<td style="text-align:right;">{{ totalCashOut | decimal }}</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
			<div class="row" style="margin-top: 15px;">
				<div class="col-xs-12">
					<div style="padding:5px;background-color:#e27a07;text-align:center;color:white;">
						<h4>Cash Balance: {{ cashBalance | decimal }}</h4>
					</div>
				</div>
			</div>

		</div>
	</div>

	<div style="display:none;" v-bind:style="{display: showReport == false ? '' : 'none'}">
		<div class="row">
			<div class="col-md-12 text-center">
				<img src="/assets/loader.gif" alt="">
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	new Vue({
		el: '#balanceSheet',
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
				loanInitial: 0.00,
				totalAssetsCost: 0.00,
				totalAssetsSales: 0.00,
				loanPayments: [],
				investReceives: [],
				investPayments: [],
				employeePayments: [],
				showReport: null
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
				return (this.loanReceives.reduce((prev, curr) => {
					return prev + parseFloat(curr.amount)
				}, 0) + this.loanInitial).toFixed(2);
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
			totalCashIn() {
				return parseFloat(this.totalSales) +
					parseFloat(this.totalReceivedFromCustomers) +
					parseFloat(this.totalReceivedFromSuppliers) +
					parseFloat(this.totalCashReceived) +
					parseFloat(this.totalLoanReceived) +
					parseFloat(this.totalInvestReceived) +
					parseFloat(this.totalAssetsSales) +
					parseFloat(this.totalBankWithdraw);
			},
			totalCashOut() {
				return parseFloat(this.totalPurchase) +
					parseFloat(this.totalPaidToCustomers) +
					parseFloat(this.totalPaidToSuppliers) +
					parseFloat(this.totalCashPaid) +
					parseFloat(this.totalBankDeposit) +
					parseFloat(this.totalLoanPayment) +
					parseFloat(this.totalInvestPayment) +
					parseFloat(this.totalAssetsCost) +
					parseFloat(this.totalEmployeePayments);
			},
			cashBalance() {
				return parseFloat(this.totalCashIn) - parseFloat(this.totalCashOut);
			}
		},
		methods: {
			async getStatements() {
				this.showReport = false;
				await this.getSales();
				await this.getPurchases();
				await this.getReceivedFromCustomers();
				await this.getPaidToCustomers();
				await this.getPaidToSuppliers();
				await this.getReceivedFromSuppliers();
				await this.getCashReceived();
				await this.getCashPaid();
				await this.getBankDeposits();
				await this.getBankWithdraws();
				await this.getLoanReceives();
				await this.getLoanPayments();
				await this.getInvestReceives();
				await this.getInvestPayments();
				await this.getEmployeePayments();
				await this.getAssetsCost();
				await this.getAssetsSales();
				this.showReport = true;
			},

			async getSales() {
				await axios.post('/get_sales', this.filter)
					.then(res => {
						this.sales = res.data.sales;
					})
			},

			async getPurchases() {
				await axios.post('/get_purchases', this.filter)
					.then(res => {
						this.purchases = res.data.purchases;
					})
			},

			async getReceivedFromCustomers() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					paymentType: 'received'
				}
				await axios.post('/get_customer_payments', filter)
					.then(res => {
						this.receivedFromCustomers = res.data.filter(p => p.CPayment_Paymentby != 'bank');
					})
			},

			async getPaidToCustomers() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					paymentType: 'paid'
				}
				await axios.post('/get_customer_payments', filter)
					.then(res => {
						this.paidToCustomers = res.data.filter(p => p.CPayment_Paymentby != 'bank');
					})
			},

			async getPaidToSuppliers() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					paymentType: 'paid'
				}
				await axios.post('/get_supplier_payments', filter)
					.then(res => {
						this.paidToSuppliers = res.data.filter(p => p.SPayment_Paymentby != 'bank');
					})
			},

			async getReceivedFromSuppliers() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					paymentType: 'received'
				}
				await axios.post('/get_supplier_payments', filter)
					.then(res => {
						this.receivedFromSuppliers = res.data.filter(p => p.SPayment_Paymentby != 'bank');
					})
			},

			async getCashReceived() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'received'
				}
				await axios.post('/get_cash_transactions', filter)
					.then(res => {
						this.cashReceived = res.data;
					})
			},

			async getCashPaid() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'paid'
				}
				await axios.post('/get_cash_transactions', filter)
					.then(res => {
						this.cashPaid = res.data;
					})
			},

			async getBankDeposits() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'deposit'
				}
				await axios.post('/get_bank_transactions', filter)
					.then(res => {
						this.bankDeposits = res.data;
					})
			},

			async getBankWithdraws() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'withdraw'
				}
				await axios.post('/get_bank_transactions', filter)
					.then(res => {
						this.bankWithdraws = res.data;
					})
			},

			async getLoanReceives() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'Receive'
				}
				await axios.post('/get_loan_transactions', filter).then(res => {
					this.loanReceives = res.data;
				})
				
				await axios.post('/get_loan_initial_balance', this.filter).then(res => {
					this.loanInitial = res.data.balance;
				})
			},
			
			async getLoanPayments() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'Payment'
				}
				await axios.post('/get_loan_transactions', filter).then(res => {
					this.loanPayments = res.data;
				})
			},
			
			async getInvestReceives() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'Receive'
				}
				await axios.post('/get_investment_transactions', filter).then(res => {
					this.investReceives = res.data;
				})
			},
			
			async getInvestPayments() {
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					transactionType: 'Payment'
				}
				await axios.post('/get_investment_transactions', filter).then(res => {
					this.investPayments = res.data;
				})
			},

			async getEmployeePayments(){
				await axios.post('/get_payments', this.filter)
				.then(res => { 
					this.employeePayments = res.data;
				})
			},
			
			async getAssetsCost(){
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					buy_or_sale: 'buy'
				}

				await axios.post('/get_assets_cost', filter)
				.then(res => { 
					this.totalAssetsCost = res.data.cost ?? 0;
				})
			},

			async getAssetsSales(){
				let filter = {
					dateFrom: this.filter.dateFrom,
					dateTo: this.filter.dateTo,
					buy_or_sale: 'sale'
				}

				await axios.post('/get_assets_cost', filter)
				.then(res => { 
					this.totalAssetsSales = res.data.cost ?? 0;
				})
			},

			async print() {
				let printContent = `
					<div class="container">
						<h4 style="text-align:center">Balance In Out</h4 style="text-align:center">
						<div class="row">
							<div class="col-xs-12 text-center">
								Statement from <strong>${this.filter.dateFrom}</strong> to <strong>${this.filter.dateTo}</strong> 
							</div>
						</div>
					</div>
					<div class="container">
						${document.querySelector('#printContent').innerHTML}
					</div>
				`;

				var printWindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				printWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php'); ?>
				`);

				printWindow.document.body.innerHTML += printContent;
				printWindow.document.head.innerHTML += `
					<style>
						.balancesheet-table{
							width: 100%;
							border-collapse: collapse;
						}

						.balancesheet-table thead{
							text-align: center;
						}

						.balancesheet-table tfoot{
							font-weight: bold;
							background-color: #eaf3fd;
						}

						.balancesheet-table td, .balancesheet-table th{
							border: 1px solid #ccc;
							padding: 5px;
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