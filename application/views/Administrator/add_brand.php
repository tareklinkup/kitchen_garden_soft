<style>
	#brands label{
		font-size:13px;
	}
	#brands select{
		border-radius: 3px;
	}
	#brands .add-button{
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display:block;
		text-align: center;
		color: white;
	}
	#brands .add-button:hover{
		background-color: #41add6;
		color: white;
	}
	#brands input[type="file"] {
		display: none;
	}
	#brands .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#brands .custom-file-upload:hover{
		background-color: #41add6;
	}

	#adImage{
		height: 100%;
	}
    .center{
        display:flex;
        justify-content:center;
    }
</style>
<div id="brands">
		<form @submit.prevent="savead">
		<div class="row center" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-8">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Name:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="brand.brand_name">
					</div>
				</div>

				<div class="form-group clearfix">
                    <label class="control-label col-md-4" for="is_website">Is Website:</label>
                    <div class="col-md-7">
                        <input type="checkbox" v-model="brand.is_website" id="is_website">
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
						<img id="adImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
                        <img id="adImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
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
					<datatable :columns="columns" :data="brands" :filter-by="filter" style="margin-bottom: 5px;">
						<template scope="{ row }">
							<tr>
                                <td>{{ row.brand_SiNo }}</td>
                                <td>{{ row.brand_name }}</td>
                                <td><button v-if="row.is_website == 1 " type="button" class="button" @click="isWebsiteChange(row.brand_SiNo)">
                                        Published
                                    </button>
                                    <button v-if="row.is_website == 0 " type="button" class="button" @click="isWebsiteChange(row.brand_SiNo)">
                                        UnPublished
                                    </button>
                                </td>
								<td>
									<?php if($this->session->userdata('accountType') != 'u'){?>
									<button type="button" class="button edit" @click="editBrand(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deletead(row.brand_SiNo, row.image)">
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
		el: '#brands',
		data(){
			return {
				brand: {
					brand_SiNo :0,
                    brand_name:'',
                    image:'',
                    is_website:true,
				},
				brands: [],
				imageUrl: '',
				selectedFile: null,				
				columns: [
                    { label: 'SL', field: 'brand_SiNo ', align: 'center', filterable: false },
                    { label: 'Name', field: 'brand_name', align: 'center' },
                    { label: 'is_website', field: 'is_website', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
			}
		},
		created(){
			this.getbrands();
		},
		methods: {
			getbrands(){
				axios.get('/get_brands').then(res => {
					this.brands = res.data;
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
			savead(){

                if(this.brand.brand_name == ''){
                    alert("Please Enter Title");
                    return;
                }
                
				let url = '/insertbrand';
				if(this.brand.brand_SiNo != 0){
					url = '/editbrand';
				}
                
				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.brand));

				axios.post(url, fd, {
					onUploadProgress: upe => {
						let progress = Math.round(upe.loaded / upe.total * 100);
					}
				}).then(res=>{
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.resetForm();
						this.getbrands();
					}
				})
			},
			editBrand(brand){
				let keys = Object.keys(this.brand);
				keys.forEach(key => {
					this.brand[key] = brand[key];
				})
				this.brand.is_website = brand.is_website == 1 ? true : false;
				if(brand.image == null || brand.image == ''){
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/brands/'+brand.image;
				}
			},
            isWebsiteChange(brandId){
                let confirms = confirm('Are you sure?');
                if(confirms == false){
                    return;
                }
                axios.post('/is_website_brands', {brandId: brandId}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
                        this.getbrands();
					}
				})
            },
			deletead(brandId, image){
				let deleteConfirm = confirm('Are you sure?');
				if(deleteConfirm == false){
					return;
				}
				axios.post('/branddelete', {brandId: brandId, image: image}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getbrands();
					}
				})
			},
			resetForm(){
				this.imageUrl = '';
				this.selectedFile = null;
                this.brand.brand_SiNo = '';
                this.brand.brand_name = '';
				this.brand.is_website = true ;
			}
		}
	})
</script>