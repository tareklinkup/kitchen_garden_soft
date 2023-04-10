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
<div id="purchaseRecord">
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
				<div class="form-group">
					<label>Search Type</label>
					<select class="form-control" v-model="searchType" @change="onChangeSearchType">
						<option value="">All</option>
						<option value="supplier">By Supplier</option>
						<option value="category">By Category</option>
						<option value="quantity">By Quantity</option>
						<option value="user">By User</option>
					</select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'supplier' && suppliers.length > 0 ? '' : 'none'}">
					<label>Supplier</label>
					<v-select v-bind:options="suppliers" v-model="selectedSupplier" label="display_name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'quantity' && products.length > 0 ? '' : 'none'}">
					<label>Product</label>
					<v-select v-bind:options="products" v-model="selectedProduct" label="display_text"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'category' && categories.length > 0 ? '' : 'none'}">
					<label>Category</label>
					<v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name"></v-select>
				</div>

				<div class="form-group" style="display:none;" v-bind:style="{display: searchType == 'user' && users.length > 0 ? '' : 'none'}">
					<label>User</label>
					<v-select v-bind:options="users" v-model="selectedUser" label="FullName"></v-select>
				</div>

				<div class="form-group" v-bind:style="{display: searchTypesForRecord.includes(searchType) ? '' : 'none'}">
					<label>Record Type</label>
					<select class="form-control" v-model="recordType" @change="purchases = []">
						<option value="without_details">Without Details</option>
						<option value="with_details">With Details</option>
					</select>
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

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: purchases.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				<table 
					class="record-table" 
					v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'with_details'" 
					style="display:none" 
					v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'with_details' ? '' : 'none'}"
					>
					<thead>
						<tr>
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Supplier Name</th>
							<th>Product Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Total</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<template v-for="purchase in purchases">
							<tr>
								<td>{{ purchase.PurchaseMaster_InvoiceNo }}</td>
								<td>{{ purchase.PurchaseMaster_OrderDate }}</td>
								<td>{{ purchase.Supplier_Name }}</td>
								<td>{{ purchase.purchaseDetails[0].Product_Name }}</td>
								<td style="text-align:right;">{{ purchase.purchaseDetails[0].PurchaseDetails_Rate }}</td>
								<td style="text-align:center;">{{ purchase.purchaseDetails[0].PurchaseDetails_TotalQuantity }}</td>
								<td style="text-align:right;">{{ purchase.purchaseDetails[0].PurchaseDetails_TotalAmount }}</td>
								<td style="text-align:center;">
									<a href="" title="Purchase Invoice" v-bind:href="`/purchase_invoice_print/${purchase.PurchaseMaster_SlNo}`" target="_blank"><i class="fa fa-file-text"></i></a>
									<?php if($this->session->userdata('accountType') != 'u'){?>
									<a href="" title="Edit Purchase" v-bind:href="`/purchase/${purchase.PurchaseMaster_SlNo}`"><i class="fa fa-edit"></i></a>
									<a href="" title="Delete Purchase" @click.prevent="deletePurchase(purchase.PurchaseMaster_SlNo)"><i class="fa fa-trash"></i></a>
									<?php }?>
								</td>
							</tr>
							<tr v-for="(product, sl) in purchase.purchaseDetails.slice(1)">
								<td colspan="3" v-bind:rowspan="purchase.purchaseDetails.length - 1" v-if="sl == 0"></td>
								<td>{{ product.Product_Name }}</td>
								<td style="text-align:right;">{{ product.PurchaseDetails_Rate }}</td>
								<td style="text-align:center;">{{ product.PurchaseDetails_TotalQuantity }}</td>
								<td style="text-align:right;">{{ product.PurchaseDetails_TotalAmount }}</td>
								<td></td>
							</tr>
							<tr style="font-weight:bold;">
								<td colspan="5" style="font-weight:normal;"><strong>Note: </strong>{{ purchase.PurchaseMaster_Description }}</td>
								<td style="text-align:center;">Total Quantity<br>{{ purchase.purchaseDetails.reduce((prev, curr) => {return prev + parseFloat(curr.PurchaseDetails_TotalQuantity)}, 0) }}</td>
								<td style="text-align:right;">
									Total: {{ purchase.PurchaseMaster_TotalAmount }}<br>
									Paid: {{ purchase.PurchaseMaster_PaidAmount }}<br>
									Due: {{ purchase.PurchaseMaster_DueAmount }}
								</td>
								<td></td>
							</tr>
						</template>
					</tbody>
				</table>

				<table 
					class="record-table" 
					v-if="(searchTypesForRecord.includes(searchType)) && recordType == 'without_details'" 
					style="display:none" 
					v-bind:style="{display: (searchTypesForRecord.includes(searchType)) && recordType == 'without_details' ? '' : 'none'}"
					>
					<thead>
						<tr>
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Supplier Name</th>
							<th>Sub Total</th>
							<th>VAT</th>
							<th>Discount</th>
							<th>Transport Cost</th>
							<th>Total</th>
							<th>Paid</th>
							<th>Due</th>
							<th>Note</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="purchase in purchases">
							<td>{{ purchase.PurchaseMaster_InvoiceNo }}</td>
							<td>{{ purchase.PurchaseMaster_OrderDate }}</td>
							<td>{{ purchase.Supplier_Name }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseMaster_SubTotalAmount }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseMaster_Tax }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseMaster_DiscountAmount }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseMaster_Freight }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseMaster_TotalAmount }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseMaster_PaidAmount }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseMaster_DueAmount }}</td>
							<td style="text-align:left;">{{ purchase.PurchaseMaster_Description }}</td>
							<td style="text-align:center;">
								<a href="" title="Purchase Invoice" v-bind:href="`/purchase_invoice_print/${purchase.PurchaseMaster_SlNo}`" target="_blank"><i class="fa fa-file-text"></i></a>
								<?php if($this->session->userdata('accountType') != 'u'){?>
								<a href="" title="Edit Purchase" v-bind:href="`/purchase/${purchase.PurchaseMaster_SlNo}`"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Purchase" @click.prevent="deletePurchase(purchase.PurchaseMaster_SlNo)"><i class="fa fa-trash"></i></a>
								<?php }?>
							</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="3" style="text-align:right;">Total</td>
							<td style="text-align:right;">{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.PurchaseMaster_SubTotalAmount)}, 0) }}</td>
							<td style="text-align:right;">{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.PurchaseMaster_Tax)}, 0) }}</td>
							<td style="text-align:right;">{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.PurchaseMaster_DiscountAmount)}, 0) }}</td>
							<td style="text-align:right;">{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.PurchaseMaster_Freight)}, 0) }}</td>
							<td style="text-align:right;">{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.PurchaseMaster_TotalAmount)}, 0) }}</td>
							<td style="text-align:right;">{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.PurchaseMaster_PaidAmount)}, 0) }}</td>
							<td style="text-align:right;">{{ purchases.reduce((prev, curr)=>{return prev + parseFloat(curr.PurchaseMaster_DueAmount)}, 0) }}</td>
							<td></td>
							<td></td>
						</tr>
					</tfoot>
				</table>

				<table 
					class="record-table" 
					v-if="searchTypesForDetails.includes(searchType)"  
					style="display:none;" 
					v-bind:style="{display: searchTypesForDetails.includes(searchType) ? '' : 'none'}"
					>
					<thead>
						<tr>
							<th>Invoice No.</th>
							<th>Date</th>
							<th>Supplier Name</th>
							<th>Product Name</th>
							<th>Purchases Rate</th>
							<th>Quantity</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="purchase in purchases">
							<td>{{ purchase.PurchaseMaster_InvoiceNo }}</td>
							<td>{{ purchase.PurchaseMaster_OrderDate }}</td>
							<td>{{ purchase.Supplier_Name }}</td>
							<td>{{ purchase.Product_Name }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseDetails_Rate }}</td>
							<td style="text-align:right;">{{ purchase.PurchaseDetails_TotalQuantity }}</td>
						</tr>
					</tbody>
					<tfoot>
						<tr style="font-weight:bold;">
							<td colspan="5" style="text-align:right;">Total Quantity</td>
							<td style="text-align:right;">{{ purchases.reduce((prev, curr) => { return prev + parseFloat(curr.PurchaseDetails_TotalQuantity)}, 0) }}</td>
						</tr>
					</tfoot>
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
		el: '#purchaseRecord',
		data(){
			return {
				searchType: '',
				recordType: 'without_details',
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				suppliers: [],
				selectedSupplier: null,
				products: [],
				selectedProduct: null,
				users: [],
				selectedUser: null,
				categories: [],
				selectedCategory: null,
				purchases: [],
				searchTypesForRecord: ['', 'user', 'supplier'],
				searchTypesForDetails: ['quantity', 'category']
			}
		},
		methods: {
			onChangeSearchType(){
				this.purchases = [];
				if(this.searchType == 'quantity'){
					this.getProducts();
				} 
				else if(this.searchType == 'user'){
					this.getUsers();
				}
				else if(this.searchType == 'category'){
					this.getCategories();
				}
				else if(this.searchType == 'supplier'){
					this.getSuppliers();
				}
			},
			getProducts(){
				axios.get('/get_products').then(res => {
					this.products = res.data;
				})
			},
			getSuppliers(){
				axios.get('/get_suppliers').then(res => {
					this.suppliers = res.data;
				})
			},
			getUsers(){
				axios.get('/get_users').then(res => {
					this.users = res.data;
				})
			},
			getCategories(){
				axios.get('/get_categories').then(res => {
					this.categories = res.data;
				})
			},
			getSearchResult(){
				if(this.searchType != 'user'){
					this.selectedUser = null;
				}

				if(this.searchType != 'quantity'){
					this.selectedProduct = null;
				}

				if(this.searchType != 'category'){
					this.selectedCategory = null;
				}

				if(this.searchType != 'supplier'){
					this.selectedSupplier = null;
				}

				if(this.searchTypesForRecord.includes(this.searchType)) {
					this.getPurchaseRecord();
				} else {
					this.getPurchaseDetails();
				}
			},
			getPurchaseRecord(){
				let filter = {
					userFullName: this.selectedUser == null || this.selectedUser.FullName == '' ? '' : this.selectedUser.FullName,
					supplierId: this.selectedSupplier == null ? '' : this.selectedSupplier.Supplier_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				let url = '/get_purchases';
				if(this.recordType == 'with_details'){
					url = '/get_purchase_record';
				}

				axios.post(url, filter)
				.then(res => {
					if(this.recordType == 'with_details'){
						this.purchases = res.data;
					} else {
						this.purchases = res.data.purchases;
					}
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},
			getPurchaseDetails(){
				let filter = {
					categoryId: this.selectedCategory == null || this.selectedCategory.ProductCategory_SlNo == '' ? '' : this.selectedCategory.ProductCategory_SlNo,
					productId: this.selectedProduct == null || this.selectedProduct.Product_SlNo == '' ? '' : this.selectedProduct.Product_SlNo,
					dateFrom: this.dateFrom,
					dateTo: this.dateTo
				}

				axios.post('/get_purchasedetails', filter)
				.then(res => {
					this.purchases = res.data;
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
			},
			deletePurchase(purchaseId){
				let deleteConf = confirm('Are you sure?');
				if(deleteConf == false){
					return;
				}
				axios.post('/delete_purchase', {purchaseId: purchaseId})
				.then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getPurchaseRecord();
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
					dateText = `Statement from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
				}

				let userText = '';
				if(this.selectedUser != null && this.selectedUser.FullName != '' && this.searchType == 'user'){
					userText = `<strong>Sold by: </strong> ${this.selectedUser.FullName}`;
				}

				let supplierText = '';
				if(this.selectedSupplier != null && this.selectedSupplier.Supplier_SlNo != '' && this.searchType == 'quantity'){
					supplierText = `<strong>Supplier: </strong> ${this.selectedSupplier.Supplier_Name}<br>`;
				}

				let productText = '';
				if(this.selectedProduct != null && this.selectedProduct.Product_SlNo != '' && this.searchType == 'quantity'){
					productText = `<strong>Product: </strong> ${this.selectedProduct.Product_Name}`;
				}

				let categoryText = '';
				if(this.selectedCategory != null && this.selectedCategory.ProductCategory_SlNo != '' && this.searchType == 'category'){
					categoryText = `<strong>Category: </strong> ${this.selectedCategory.ProductCategory_Name}`;
				}


				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Purchase Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${userText} ${supplierText} ${productText} ${categoryText}
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

				if(this.searchType == '' || this.searchType == 'user'){
					let rows = reportWindow.document.querySelectorAll('.record-table tr');
					rows.forEach(row => {
						row.lastChild.remove();
					})
				}


				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
		}
	})
</script>