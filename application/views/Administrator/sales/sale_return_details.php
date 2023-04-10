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
			<form class="form-inline" id="searchForm" @submit.prevent="getSaleReturnDetails">
				<div class="form-group">
					<label>Customer</label>
					<v-select v-bind:options="customers" v-model="selectedCustomer" label="display_name"></v-select>
				</div>

				<div class="form-group">
					<label>Product</label>
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text"></v-select>
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateFrom">
				</div>

				<div class="form-group">
					<input type="date" class="form-control" v-model="dateTo">
				</div>

				<div class="form-group" style="margin-top: -5px;">
					<input type="submit" value="Search">
				</div>
			</form>
		</div>
	</div>

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: returnDetails.length > 0 ? '' : 'none'}">
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
							<th>Product</th>
							<th>Returned Quantity</th>
							<th>Returned Amount</th>
							<th>Note</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="details in returnDetails">
							<td>{{ details.SaleMaster_InvoiceNo }}</td>
							<td>{{ details.SaleReturn_ReturnDate }}</td>
							<td>{{ details.Customer_Code }}  {{ details.Customer_Name }}</td>
							<td>{{ details.Product_Code }} {{ details.Product_Name }}</td>
							<td style="text-align:right;">{{ details.SaleReturnDetails_ReturnQuantity }}</td>
							<td style="text-align:right;">{{ details.SaleReturnDetails_ReturnAmount }}</td>
							<td>{{ details.SaleReturn_Description }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right;">Total</td>
							<td style="text-align:right;">{{ returnDetails.reduce((prev, curr) => { return prev + parseFloat(curr.SaleReturnDetails_ReturnAmount)}, 0) }}</td>
							<td></td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#saleReturnList',
		data(){
			return {
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				customers: [],
				selectedCustomer: null,
				products: [],
				selectedProduct: null,
				returnDetails: []
			}
		},
		created(){
			this.getProducts();
			this.getCustomers();
		},
		methods: {
			getProducts(){
				axios.get('/get_products').then(res => {
					this.products = res.data;
				})
			},
			getCustomers(){
				axios.get('/get_customers').then(res => {
					this.customers = res.data;
				})
			},
			getSaleReturnDetails(){
				let filter = {
					customerId: this.selectedCustomer == null || this.selectedCustomer.Customer_SlNo == '' ? '' : this.selectedCustomer.Customer_SlNo,
					productId: this.selectedProduct == null || this.selectedProduct.Product_SlNo == '' ? '' : this.selectedProduct.Product_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_sale_return_details', filter)
				.then(res => {
					this.returnDetails = res.data;
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
			async print(){
				let dateText = '';
				if(this.dateFrom != '' && this.dateTo != ''){
					dateText = `Statemenet from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
				}

				let customerText = '';
				if(this.selectedCustomer != null && this.selectedCustomer.Customer_SlNo != ''){
					customerText = `<strong>Customer: </strong> ${this.selectedCustomer.Customer_Name}<br>`;
				}

				let productText = '';
				if(this.selectedProduct != null && this.selectedProduct.Product_SlNo != ''){
					productText = `<strong>Product: </strong> ${this.selectedProduct.Product_Name}`;
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
								${customerText} ${productText}
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

				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}
	})
</script>