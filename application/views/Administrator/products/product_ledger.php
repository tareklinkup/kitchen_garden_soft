<style>
	.v-select{
		margin-bottom: 5px;
	}
	.v-select .dropdown-toggle{
		padding: 0px;
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
</style>
<div class="row" id="productLedger">
	<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
		<form v-on:submit.prevent="getProductLedger">
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> Product </label>
				<div class="col-sm-2">
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text"></v-select>
				</div>
			</div>
	
			<div class="form-group">
				<label class="col-sm-1 control-label no-padding-right"> Date from </label>
				<div class="col-sm-2">
					<input type="date" class="form-control" v-model="dateFrom">
				</div>
				<label class="col-sm-1 control-label no-padding-right text-center" style="width:30px"> to </label>
				<div class="col-sm-2">
					<input type="date" class="form-control" v-model="dateTo">
				</div>
			</div>
	
			<div class="form-group">
				<div class="col-sm-1">
					<input type="submit" class="btn btn-primary" value="Show" style="margin-top:0px;border:0px;height:28px;">
				</div>
			</div>
		</form>
	</div>

	<div class="col-sm-12" style="display:none;" v-bind:style="{display: showTable ? '' : 'none'}">
		<a href="" style="margin: 7px 0;display:block;width:50px;" v-on:click.prevent="print">
			<i class="fa fa-print"></i> Print
		</a>
		<div class="table-responsive" id="reportTable">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th style="text-align:center">Date</th>
						<th style="text-align:center">Description</th>
						<th style="text-align:center">Rate</th>
						<th style="text-align:center">In Quantity</th>
						<th style="text-align:center">Out Quantity</th>
						<th style="text-align:center">Stock</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td style="text-align:left;">Previous Stock</td>
						<td colspan="3"></td>
						<td style="text-align:right;">{{ parseFloat(previousStock).toFixed(2) }}</td>
					</tr>
					<tr v-for="row in ledger">
						<td>{{ row.date }}</td>
						<td style="text-align:left;">{{ row.description }}</td>
						<td style="text-align:right;">{{ parseFloat(row.rate).toFixed(2) }}</td>
						<td style="text-align:right;">{{ parseFloat(row.in_quantity).toFixed(2) }}</td>
						<td style="text-align:right;">{{ parseFloat(row.out_quantity).toFixed(2) }}</td>
						<td style="text-align:right;">{{ parseFloat(row.stock).toFixed(2) }}</td>
					</tr>
				</tbody>
				<tbody v-if="ledger.length == 0">
					<tr>
						<td colspan="6">No records found</td>
					</tr>
				</tbody>
			</table>
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
		el: '#productLedger',
		data(){
			return {
				products: [],
				selectedProduct: null,
				dateFrom: null,
				dateTo: null,
				ledger: [],
                previousStock: 0,
                showTable: false
			}
		},
		created(){
			let today = moment().format('YYYY-MM-DD');
			this.dateTo = today;
			this.dateFrom = moment().format('YYYY-MM-DD');
			this.getProducts();
		},
		methods:{
			getProducts(){
				axios.get('/get_products').then(res => {
					this.products = res.data;
				})
			},
			getProductLedger(){
				if(this.selectedProduct == null){
					alert('Select product');
					return;
				}
				let data = {
					dateFrom: this.dateFrom,
					dateTo: this.dateTo,
					productId: this.selectedProduct.Product_SlNo
				}

                this.showTable = false;

				axios.post('/get_product_ledger', data).then(res => {
					this.ledger = res.data.ledger;
					this.previousStock = res.data.previousStock;
					this.showTable = true;
				})
			},
			async print(){
				let reportContent = `
					<div class="container">
						<h4 style="text-align:center">Product Ledger</h4 style="text-align:center">
						<div class="row">
							<div class="col-xs-6" style="font-size:12px;">
								<strong>Product Code: </strong> ${this.selectedProduct.Product_Code}<br>
								<strong>Product Name: </strong> ${this.selectedProduct.Product_Name}
							</div>
							<div class="col-xs-6 text-right">
								<strong>Statement from</strong> ${this.dateFrom} <strong>to</strong> ${this.dateTo}
							</div>
						</div>
					</div>
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportTable').innerHTML}
							</div>
						</div>
					</div>
				`;

				var mywindow = window.open('', 'PRINT', `width=${screen.width}, height=${screen.height}`);
				mywindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

				mywindow.document.body.innerHTML += reportContent;

				mywindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				mywindow.print();
				mywindow.close();
			}
		}
	})
</script>