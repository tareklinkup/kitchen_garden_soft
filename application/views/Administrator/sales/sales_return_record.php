<style>
    .v-select{
		margin-top:-2.5px;
        float: right;
        min-width: 180px;
        margin-left: 5px;
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
	#searchForm select{
		padding:0;
		border-radius: 4px;
	}
	#searchForm .form-group{
		margin-right: 5px;
	}
	#searchForm *{
		font-size: 13px;
	}
	.record-table{
		width: 100%;
		border-collapse: collapse;
	}
	.record-table thead{
		background-color: #0097df;
		color:white;
	}
	.record-table th, .record-table td{
		padding: 3px;
		border: 1px solid #454545;
	}
    .record-table th{
        text-align: center;
    }
</style>
<div id="saleReturnList">
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getReturns">
				<div class="form-group">
					<label>Customer</label>
					<v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name"></v-select>
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="fromDate">
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="toDate">
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: returns.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				<table class="record-table">
					<thead>
						<tr>
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Customer</th>
							<th>Note</th>
							<th>Returned Amount</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="saleReturn in returns">
							<td>{{ saleReturn.SaleMaster_InvoiceNo }}</td>
							<td>{{ saleReturn.SaleReturn_ReturnDate }}</td>
							<td>{{ saleReturn.Customer_Code }}  {{ saleReturn.Customer_Name }}</td>
							<td>{{ saleReturn.SaleReturn_Description }}</td>
							<td style="text-align:right;">{{ saleReturn.SaleReturn_ReturnAmount }}</td>
							<td style="text-align:center;">
								<a href="" title="Return Invoice" v-bind:href="`/sale_return_invoice/${saleReturn.SaleReturn_SlNo}`" target="_blank"><i class="fa fa-file"></i></a>
								<?php if($this->session->userdata('accountType') != 'u'){?>
								<a href="" title="Edit" v-bind:href="`salesReturn/${saleReturn.SaleReturn_SlNo}`"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Return" @click.prevent="deleteReturn(saleReturn.SaleReturn_SlNo)"><i class="fa fa-trash"></i></a>
								<?php }?>
							</td>
						</tr>
						<tr style="font-weight:bold;">
							<td colspan="4" style="text-align:right;">Total</td>
							<td style="text-align:right;">{{ returns.reduce((prev, curr) => { return prev + parseFloat(curr.SaleReturn_ReturnAmount)}, 0) }}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#saleReturnList',
		data(){
			return {
				fromDate: moment().format('YYYY-MM-DD'),
				toDate: moment().format('YYYY-MM-DD'),
				customers: [],
				selectedCustomer: null,
				returns: []
			}
		},
		created(){
			this.getCustomers();
		},
		methods: {
			getCustomers(){
				axios.get('/get_customers').then(res => {
					this.customers = res.data;
				})
			},
			getReturns(){
				let filter = {
					customerId: this.selectedCustomer == null || this.selectedCustomer.Customer_SlNo == '' ? '' : this.selectedCustomer.Customer_SlNo,
					fromDate: this.fromDate,
					toDate: this.toDate
				}

				axios.post('/get_sale_returns', filter)
				.then(res => {
					this.returns = res.data.returns;
					if(res.data.length == 0){
						alert('No records found');
					}
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},
			deleteReturn(id) {
				console.log(id);
				let conf = confirm('Are you sure?');
				if(conf == false) {
					return;
				}
				axios.post('/delete_sale_return', { id })
				.then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success) {
						this.getReturns();
					}
				})
			},
			async print(){
				let dateText = '';
				if(this.fromDate != '' && this.toDate != ''){
					dateText = `Statemenet from <strong>${this.fromDate}</strong> to <strong>${this.toDate}</strong>`;
				}

				let customerText = '';
				if(this.selectedCustomer != null && this.selectedCustomer.Customer_SlNo != ''){
					customerText = `<strong>Customer: </strong> ${this.selectedCustomer.Customer_Name}<br>`;
				}

				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Sale Return Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${customerText}
							</div>
							<div class="col-xs-6 text-right">
								${dateText}
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
				reportWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

				reportWindow.document.head.innerHTML += `
					<style>
						.record-table{
							width: 100%;
							border-collapse: collapse;
						}
						.record-table thead{
							background-color: #0097df;
							color:white;
						}
						.record-table th, .record-table td{
							padding: 3px;
							border: 1px solid #454545;
						}
						.record-table th{
							text-align: center;
						}
					</style>
				`;
				reportWindow.document.body.innerHTML += reportContent;

				let rows = reportWindow.document.querySelectorAll('.record-table tr');
				rows.forEach(row => {
					row.lastChild.remove();
				})

				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}
	})
</script>