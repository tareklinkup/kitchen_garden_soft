<style>
	.v-select{
		margin-bottom: 5px;
	}
	.v-select.open .dropdown-toggle{
		border-bottom: 1px solid #ccc;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
		height: 25px;
	}
	.v-select input[type=search], .v-select input[type=search]:focus{
		margin: 0px;
	}
	.v-select .vs__selected-options{
		overflow: hidden;
		flex-wrap:nowrap;
	}
	.v-select .selected-tag{
		margin: 2px 0px;
		white-space: nowrap;
		position:absolute;
		left: 0px;
	}
	.v-select .vs__actions{
		margin-top:-5px;
	}
	.v-select .dropdown-menu{
		width: auto;
		overflow-y:auto;
	}
	#cashTransaction label{
		font-size:13px;
	}
	#cashTransaction select{
		border-radius: 3px;
		padding: 0;
	}
	#cashTransaction .add-button{
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display:block;
		text-align: center;
		color: white;
	}
	#cashTransaction .add-button:hover{
		background-color: #41add6;
		color: white;
	}
</style>
<div id="cashTransaction">
	<div class="row" style="border-bottom: 1px solid #ccc;padding-bottom: 15px;margin-bottom: 15px;">
		<div class="col-md-12">
			<form @submit.prevent="addTransaction">
				<div class="row">
					<div class="col-md-5 col-md-offset-1">
						<div class="form-group">
							<label class="col-md-4 control-label">Transaction Id</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7">
								<input type="text" class="form-control" v-model="transaction.Tr_Id" readonly>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Transaction Type</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7">
								<select class="form-control" required v-model="transaction.Tr_Type" @change="onChangeTransactionType">
									<option value=""></option>
									<option value="In Cash">Cash Receive</option>
									<option value="Out Cash">Cash Payment</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Account</label>
							<label class="col-md-1">:</label>
							<div class="col-md-6 col-xs-11">
								<select class="form-control" v-if="accounts.length == 0"></select>
								<v-select v-bind:options="accounts" v-model="selectedAccount" label="Acc_Name" v-if="accounts.length > 0"></v-select>
							</div>
							<div class="col-xs-1" style="padding-left:0;margin-left: -3px;">
								<a href="/account" target="_blank" class="add-button"><i class="fa fa-plus"></i></a>
							</div>
						</div>
					</div>

					<div class="col-md-5">
						<div class="form-group">
							<label class="col-md-4 control-label">Date</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7">
								<input type="date" class="form-control" required v-model="transaction.Tr_date" @change="getTransactions" v-bind:disabled="userType == 'u' ? true : false">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Description</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7">
								<input type="text" class="form-control" v-model="transaction.Tr_Description">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-4 control-label">Amount</label>
							<label class="col-md-1">:</label>
							<div class="col-md-7">
								<input type="number" class="form-control" step="0.01" required v-model="transaction.In_Amount" 
									style="display:none;" 
									v-if="transaction.Tr_Type == 'In Cash'"
									v-bind:style="{display: transaction.Tr_Type == 'In Cash' ? '' : 'none'}"
								>
								<input type="number" class="form-control" step="0.01" required v-model="transaction.Out_Amount" 
									v-if="transaction.Tr_Type == 'Out Cash' || transaction.Tr_Type == ''"
									v-bind:style="{display: transaction.Tr_Type == 'Out Cash' || transaction.Tr_Type == '' ? '' : 'none'}"
								>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-7 col-md-offset-5">
								<input type="submit" class="btn btn-success btn-sm" value="Save">
								<input type="button" class="btn btn-danger btn-sm" value="Cancel" @click="resetForm">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-12 form-inline">
			<div class="form-group">
				<label for="filter" class="sr-only">Filter</label>
				<input type="text" class="form-control" v-model="filter" placeholder="Filter">
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<datatable :columns="columns" :data="transactions" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td>{{ row.Tr_Id }}</td>
							<td>{{ row.Acc_Name }}</td>
							<td>{{ row.Tr_date }}</td>
							<td>{{ row.Tr_Description }}</td>
							<td>{{ row.In_Amount }}</td>
							<td>{{ row.Out_Amount }}</td>
							<td>{{ row.AddBy }}</td>
							<td>
								<?php if($this->session->userdata('accountType') != 'u'){?>
								<button type="button" class="button edit" @click="editTransaction(row)">
									<i class="fa fa-pencil"></i>
								</button>
								<button type="button" class="button" @click="deleteTransaction(row.Tr_SlNo)">
									<i class="fa fa-trash"></i>
								</button>
								<?php }?>
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
			</div>
		</div>
	</div>
	
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#cashTransaction',
		data(){
			return {
				transaction: {
					Tr_SlNo: 0,
					Tr_Id: null,
					Tr_date: moment().format('YYYY-MM-DD'),
					Tr_Type: '',
					Tr_account_Type: '',
					Acc_SlID: null,
					Tr_Description: '',
					In_Amount: '',
					Out_Amount: ''
				},
				transactions: [],
				accounts: [],
				selectedAccount: null,
				userType: '<?php echo $this->session->userdata("accountType");?>',
				
				columns: [
                    { label: 'Transaction Id', field: 'Tr_Id', align: 'center' },
                    { label: 'Account Name', field: 'Acc_Name', align: 'center' },
                    { label: 'Date', field: 'Tr_date', align: 'center' },
                    { label: 'Description', field: 'Tr_Description', align: 'center' },
                    { label: 'Received Amount', field: 'In_Amount', align: 'center' },
                    { label: 'Paid Amount', field: 'Out_Amount', align: 'center' },
                    { label: 'Saved By', field: 'AddBy', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
			}
		},
		created(){
			this.getTransactionCode();
			this.getAccounts();
			this.getTransactions();
		},
		methods:{
			getTransactionCode(){
				axios.get('/get_cash_transaction_code').then(res => {
					this.transaction.Tr_Id = res.data;
				})
			},
			getAccounts(){
				axios.get('/get_accounts').then(res => {
					this.accounts = res.data;
				})
			},
			onChangeTransactionType(){
				this.transaction.In_Amount = '';
				this.transaction.Out_Amount = '';

			},
			getTransactions(){
				let data = {
					dateFrom: this.transaction.Tr_date,
					dateTo: this.transaction.Tr_date
				}

				axios.post('/get_cash_transactions', data).then(res => {
					this.transactions = res.data;
				})
			},
			addTransaction(){
				if(this.selectedAccount == null || this.selectedAccount.Acc_SlNo == undefined){
					alert('Select account');
					return;
				}

				this.transaction.Tr_account_Type = this.selectedAccount.Acc_Type;
				this.transaction.Acc_SlID = this.selectedAccount.Acc_SlNo;

				let url = '/add_cash_transaction';
				if(this.transaction.Tr_SlNo != 0){
					url = '/update_cash_transaction';
				}

				axios.post(url, this.transaction).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.resetForm();
						this.getTransactions();
					}
				})
			},
			editTransaction(transaction){
				let keys = Object.keys(this.transaction);
				keys.forEach(key => {
					this.transaction[key] = transaction[key];
				})

				this.selectedAccount = {
					Acc_SlNo: transaction.Acc_SlID,
					Acc_Type: transaction.Tr_account_Type,
					Acc_Name: transaction.Acc_Name
				}
			},
			deleteTransaction(transactionId){
				axios.post('/delete_cash_transaction', {transactionId: transactionId}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getTransactions();
					}
				})
			},
			resetForm(){
				this.transaction.Tr_SlNo = 0;
				this.transaction.Tr_Id = '';
				this.transaction.Tr_account_Type = '';
				this.transaction.Acc_SlID = '';
				this.transaction.Tr_Description = '';
				this.transaction.In_Amount = '';
				this.transaction.Out_Amount = '';

				this.selectedAccount = null;
				this.getTransactionCode();
			}
		}
	})
</script>