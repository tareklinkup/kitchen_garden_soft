<style>
	.v-select {
		margin-bottom: 5px;
	}

	.v-select.open .dropdown-toggle {
		border-bottom: 1px solid #ccc;
	}

	.v-select .dropdown-toggle {
		padding: 0px;
		height: 25px;
	}

	.v-select input[type=search],
	.v-select input[type=search]:focus {
		margin: 0px;
	}

	.v-select .vs__selected-options {
		overflow: hidden;
		flex-wrap: nowrap;
	}

	.v-select .selected-tag {
		margin: 2px 0px;
		white-space: nowrap;
		position: absolute;
		left: 0px;
	}

	.v-select .vs__actions {
		margin-top: -5px;
	}

	.v-select .dropdown-menu {
		width: auto;
		overflow-y: auto;
	}

	#employeeSalary label {
		font-size: 13px;
	}

	#employeeSalary select {
		border-radius: 3px;
	}

	#employeeSalary .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#employeeSalary .add-button:hover {
		background-color: #41add6;
		color: white;
	}
</style>
<div id="employeeSalary">
	<form @submit.prevent="savePayment">
		<div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom: 15px;">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Employee</label>
					<div class="col-md-7">
						<select class="form-control" v-bind:style="{display: employees.length > 0 ? 'none' : ''}"></select>
						<v-select v-bind:options="employees" label="display_name" v-model="selectedEmployee" @input="getPayableSalary" style="display:none;" v-bind:style="{display: employees.length > 0 ? '' : 'none'}"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/employee" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>
				<div class="form-group" v-if="selectedEmployee != null" style="display:none;" v-bind:style="{display: selectedEmployee == null ? 'none' : ''}">
					<label class="control-label col-md-4">Salary</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="selectedEmployee.salary_range" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">Month</label>
					<div class="col-md-7">
						<select class="form-control" v-bind:style="{display: months.length > 0 ? 'none' : ''}"></select>
						<v-select v-bind:options="months" label="month_name" v-model="selectedMonth" @input="getPayableSalary" style="display:none;" v-bind:style="{display: months.length > 0 ? '' : 'none'}"></v-select>
					</div>
					<div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/month" target="_blank" class="add-button"><i class="fa fa-plus"></i></a></div>
				</div>
				<div class="form-group" style="display:none;" v-bind:style="{display: payment.employee_payment_id == null ? '' : 'none'}">
					<label class="control-label col-md-4">Payable Amount</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="payable_amount" disabled>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Date</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="payment.payment_date">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">Payment Amount</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="payment.payment_amount">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-4">Deduction Amount</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="payment.deduction_amount">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-7 col-md-offset-4 text-right">
						<input type="submit" value="Save" class="btn btn-success btn-sm">
						<input type="button" value="Cancel" class="btn btn-danger btn-sm" @click="resetForm">
					</div>
				</div>
			</div>
		</div>
	</form>

	<div class="row">
		<div class="col-sm-12 form-inline">
			<div class="form-group">
				<label for="filter" class="sr-only">Filter</label>
				<input type="text" class="form-control" v-model="filter" placeholder="Filter">
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive">
				<datatable :columns="columns" :data="payments" :filter-by="filter">
					<template scope="{ row }">
						<tr>
							<td>{{ row.payment_date }}</td>
							<td>{{ row.Employee_ID }}</td>
							<td>{{ row.Employee_Name }}</td>
							<td>{{ row.month_name }}</td>
							<td>{{ row.payment_amount }}</td>
							<td>{{ row.deduction_amount }}</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editPayment(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deletePayment(row.employee_payment_id)">
										<i class="fa fa-trash"></i>
									</button>
								<?php } ?>
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#employeeSalary',
		data() {
			return {
				payment: {
					employee_payment_id: null,
					Employee_SlNo: null,
					payment_date: moment().format('YYYY-MM-DD'),
					month_id: null,
					payment_amount: '',
					deduction_amount: ''
				},
				payments: [],
				employees: [],
				selectedEmployee: null,
				months: [],
				selectedMonth: null,
				payable_amount: 0.00,

				columns: [
                    { label: 'Date', field: 'payment_date', align: 'center', filterable: false },
                    { label: 'Employee Id', field: 'Employee_ID', align: 'center' },
                    { label: 'Employee Name', field: 'Employee_Name', align: 'center' },
                    { label: 'Month', field: 'month_name', align: 'center' },
                    { label: 'Payment Amount', field: 'payment_amount', align: 'center' },
                    { label: 'Deducted Amount', field: 'deduction_amount', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
			}
		},
		created() {
			this.getEmployees();
			this.getMonths();
			this.getPayments();
		},
		methods: {
			getEmployees() {
				axios.get('/get_employees').then(res => {
					this.employees = res.data;
				})
			},
			getMonths() {
				axios.get('/get_months').then(res => {
					this.months = res.data;
				})
			},
			getPayableSalary() {
				if (this.selectedEmployee == null || this.selectedMonth == null) {
					return;
				}

				let data = {
					monthId: this.selectedMonth.month_id,
					employeeId: this.selectedEmployee.Employee_SlNo
				}

				axios.post('/get_payable_salary', data).then(res => {
					this.payable_amount = res.data;
				})
			},
			getPayments() {
				axios.get('/get_employee_payments').then(res => {
					this.payments = res.data;
				})
			},
			savePayment() {
				if(this.selectedEmployee == null){
					alert('Select employee');
					return;
				}

				if(this.selectedMonth == null){
					alert('Select month');
					return;
				}

				this.payment.Employee_SlNo = this.selectedEmployee.Employee_SlNo;
				this.payment.month_id = this.selectedMonth.month_id;

				let url = '/add_employee_payment';
				if(this.payment.employee_payment_id != null){
					url = '/update_employee_payment';
				}

				axios.post(url, this.payment)
				.then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.resetForm();
						this.getPayments();
					}
				})
				.catch(error => alert(error.response.statusText))
			},
			editPayment(payment){
				let keys = Object.keys(this.payment);
				keys.forEach(key => this.payment[key] = payment[key]);

				this.selectedEmployee = {
					Employee_SlNo: payment.Employee_SlNo,
					Employee_Name: payment.Employee_Name,
					display_name: `${payment.Employee_Name} - ${payment.Employee_ID}`,
					salary_range: payment.salary_range
				}

				this.selectedMonth = {
					month_id: payment.month_id,
					month_name: payment.month_name
				}
			},
			deletePayment(paymentId){
				let confirmation = confirm('Are you sure?');
				if(confirmation == false){
					return;
				}
				axios.post('/delete_employee_payment', {paymentId: paymentId})
				.then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getPayments();
					}
				})
			},
			resetForm(){
				this.payment = {
					employee_payment_id: null,
					Employee_SlNo: null,
					payment_date: moment().format('YYYY-MM-DD'),
					month_id: null,
					payment_amount: '',
					deduction_amount: ''
				}

				this.payable_amount = 0.00;
				this.selectedEmployee = null;
				this.selectedMonth = null;
			}
		}
	})
</script>