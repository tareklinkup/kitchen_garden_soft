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
	#suppliers label{
		font-size:13px;
	}
	#suppliers select{
		border-radius: 3px;
	}
	#suppliers .add-button{
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display:block;
		text-align: center;
		color: white;
	}
	#suppliers .add-button:hover{
		background-color: #41add6;
		color: white;
	}
	#suppliers input[type="file"] {
		display: none;
	}
	#suppliers .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#suppliers .custom-file-upload:hover{
		background-color: #41add6;
	}

	#supplierImage{
		height: 100%;
	}
</style>
<div id="suppliers">
		<form @submit.prevent="saveSupplier">
		<div class="row" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-5">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Supplier Id:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="supplier.Supplier_Code" required readonly>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Supplier Name:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="supplier.Supplier_Name" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Owner Name:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="supplier.contact_person">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Address:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="supplier.Supplier_Address">
					</div>
				</div>
			</div>	

			<div class="col-md-5">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Mobile:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="supplier.Supplier_Mobile" required>
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Email:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="supplier.Supplier_Email">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Previous Due:</label>
					<div class="col-md-7">
						<input type="number" class="form-control" v-model="supplier.previous_due" required>
					</div>
				</div>
				
				<div class="form-group clearfix">
					<div class="col-md-7 col-md-offset-4">
						<input type="submit" class="btn btn-success btn-sm" value="Save">
					</div>
				</div>
			</div>	
			<div class="col-md-2 text-center;">
				<div class="form-group clearfix">
					<div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
						<img id="supplierImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
                        <img id="supplierImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
					</div>
					<div style="text-align:center;">
						<label class="custom-file-upload">
							<input type="file" @change="previewImage"/>
							Select Image
						</label>
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
					<datatable :columns="columns" :data="suppliers" :filter-by="filter" style="margin-bottom: 5px;">
						<template scope="{ row }">
							<tr>
								<td>{{ row.Supplier_Code }}</td>
								<td>{{ row.Supplier_Name }}</td>
								<td>{{ row.contact_person }}</td>
								<td>{{ row.Supplier_Address }}</td>
								<td>{{ row.Supplier_Mobile }}</td>
								<td>
									<?php if($this->session->userdata('accountType') != 'u'){?>
									<button type="button" class="button edit" @click="editSupplier(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteSupplier(row.Supplier_SlNo)">
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
		el: '#suppliers',
		data(){
			return {
				supplier: {
					Supplier_SlNo: 0,
					Supplier_Code: '<?php echo $supplierCode;?>',
					Supplier_Name: '',
					Supplier_Mobile: '',
					Supplier_Email: '',
					Supplier_Address: '',
					contact_person: '',
					previous_due: 0.00
				},
				suppliers: [],
				imageUrl: '',
				selectedFile: null,
				
				columns: [
                    { label: 'Supplier Id', field: 'Supplier_Code', align: 'center', filterable: false },
                    { label: 'Supplier Name', field: 'Supplier_Name', align: 'center' },
                    { label: 'Contact Person', field: 'contact_person', align: 'center' },
                    { label: 'Address', field: 'Supplier_Address', align: 'center' },
                    { label: 'Contact Number', field: 'Supplier_Mobile', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
			}
		},
		created(){
			this.getSuppliers();
		},
		methods: {
			getSuppliers(){
				axios.get('/get_suppliers').then(res => {
					this.suppliers = res.data;
				})
			},
			previewImage(){
				if(event.target.files.length > 0){
					this.selectedFile = event.target.files[0];
					this.imageUrl = URL.createObjectURL(this.selectedFile);
				} else {
					this.selectedFile = null;
					this.imageUrl = null;
				}
			},
			saveSupplier(){
				let url = '/add_supplier';
				if(this.supplier.Supplier_SlNo != 0){
					url = '/update_supplier';
				}

				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.supplier));

				axios.post(url, fd, {
					onUploadProgress: upe => {
						let progress = Math.round(upe.loaded / upe.total * 100);
						console.log(progress);
					}
				}).then(res=>{
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.resetForm();
						this.supplier.Supplier_Code = r.supplierCode;
						this.getSuppliers();
					}
				})
			},
			editSupplier(supplier){
				let keys = Object.keys(this.supplier);
				keys.forEach(key => {
					this.supplier[key] = supplier[key];
				})

				if(supplier.image_name == null || supplier.image_name == ''){
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/suppliers/'+supplier.image_name;
				}
			},
			deleteSupplier(supplierId){
				let deleteConfirm = confirm('Are you sure?');
				if(deleteConfirm == false){
					return;
				}
				axios.post('/delete_supplier', {supplierId: supplierId}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getSuppliers();
					}
				})
			},
			resetForm(){
				let keys = Object.keys(this.supplier);
				keys.forEach(key => {
					if(typeof(this.supplier[key]) == 'string'){
						this.supplier[key] = '';
					} else if(typeof(this.supplier[key]) == 'number'){
						this.supplier[key] = 0;
					}
				})
				this.imageUrl = '';
				this.selectedFile = null;
			}
		}
	})
</script>