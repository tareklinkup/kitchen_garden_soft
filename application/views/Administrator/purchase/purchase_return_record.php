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
<div id="purchaseReturnList">
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getPurchaseReturns">
				<div class="form-group">
					<label>Supplier</label>
					<v-select v-bind:options="suppliers" v-model="selectedSupplier" label="display_name"></v-select>
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
							<th>Supplier</th>
							<th>Note</th>
							<th>Returned Amount</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="pr in returns">
							<td>{{ pr.PurchaseMaster_InvoiceNo }}</td>
							<td>{{ pr.PurchaseReturn_ReturnDate }}</td>
							<td>{{ pr.Supplier_Code }}  {{ pr.Supplier_Name }}</td>
							<td>{{ pr.PurchaseReturn_Description }}</td>
							<td style="text-align:right;">{{ pr.PurchaseReturn_ReturnAmount | decimal }}</td>
							<td style="text-align:center;">
								<a href="" title="Return Invoice" v-bind:href="`/purchase_return_invoice/${pr.PurchaseReturn_SlNo}`" target="_blank"><i class="fa fa-file"></i></a>
								<?php if($this->session->userdata('accountType') != 'u'){?>
								<a href="" title="Edit" v-bind:href="`purchaseReturns/${pr.PurchaseReturn_SlNo}`"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Return" @click.prevent="deletePurchaseReturn(pr.PurchaseReturn_SlNo)"><i class="fa fa-trash"></i></a>
								<?php }?>
							</td>
						</tr>
						<tr style="font-weight:bold;">
							<td colspan="4" style="text-align:right;">Total</td>
							<td style="text-align:right;">{{ returns.reduce((prev, curr) => { return prev + parseFloat(curr.PurchaseReturn_ReturnAmount)}, 0) | decimal }}</td>
							<td></td>
						</tr>
					</tbody>
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
		el: '#purchaseReturnList',

		filters: {
			decimal(value) {
				return parseFloat(value).toFixed(2) ?? '0.00';
			}
		},

		data(){
			return {
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				suppliers: [],
				selectedSupplier: null,
				returns: []
			}
		},
		created(){
			this.getSuppliers();
			this.getPurchaseReturns();
		},
		methods: {
			getSuppliers(){
				axios.get('/get_suppliers').then(res => {
					this.suppliers = res.data;
				})
			},
			getPurchaseReturns(){
				let filter = {
					supplierId: this.selectedSupplier == null || this.selectedSupplier.Supplier_SlNo == '' ? '' : this.selectedSupplier.Supplier_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_purchase_returns', filter)
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

			deletePurchaseReturn(id) {
				let conf = confirm('Are you sure?');
				if(conf == false) {
					return;
				}
				axios.post('/delete_purchase_return', { id })
				.then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success) {
						this.getPurchaseReturns();
					}
				})
			},

			async print(){
				let dateText = '';
				if(this.dateFrom != '' && this.dateTo != ''){
					dateText = `Statemenet from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
				}

				let supplierText = '';
				if(this.selectedSupplier != null && this.selectedSupplier.Supplier_SlNo != ''){
					supplierText = `<strong>Supplier: </strong> ${this.selectedSupplier.Supplier_Name}<br>`;
				}

				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Purchase Return Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${supplierText}
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