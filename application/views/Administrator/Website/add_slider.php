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
	#banners label{
		font-size:13px;
	}
	#banners select{
		border-radius: 3px;
	}
	#banners .add-button{
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display:block;
		text-align: center;
		color: white;
	}
	#banners .add-button:hover{
		background-color: #41add6;
		color: white;
	}
	#banners input[type="file"] {
		display: none;
	}
	#banners .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#banners .custom-file-upload:hover{
		background-color: #41add6;
	}

	#sliderImage{
		height: 100%;
	}
    .center{
        display:flex;
        justify-content:center;
    }
</style>
<div id="banners">
		<form @submit.prevent="saveslider">
		<div class="row center" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-8">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Title:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="slider.title">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Offer Link:</label>
					<div class="col-md-7">
						<input type="link" class="form-control" v-model="slider.offer_link">
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
						<img id="sliderImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
                        <img id="sliderImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
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
					<datatable :columns="columns" :data="banners" :filter-by="filter" style="margin-bottom: 5px;">
						<template scope="{ row }">
							<tr>
                                <td>{{ row.id }}</td>
								<td>{{ row.title }}</td>
								<td>{{ row.offer_link }}</td>
								<td><img v-bind:src="`/uploads/banners/${row.image}`" alt="" style="height:30px;width:30px"></td>
								<td>
									<?php if($this->session->userdata('accountType') != 'u'){?>
									<button type="button" class="button edit" @click="editslider(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteslider(row.id)">
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
		el: '#banners',
		data(){
			return {
				slider: {
					id:0,
                    title:'',
                    offer_link: '',
                    image:''
				},
				banners: [],
				imageUrl: '',
				selectedFile: null,				
				columns: [
                    { label: 'SL', field: 'id', align: 'center', filterable: false },
                    { label: 'Title', field: 'title', align: 'center' },
                    { label: 'Offer Link', field: 'offer_link', align: 'center' },
					{ label: 'Image', field: 'image', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
			}
		},
		created(){
			this.getbanners();
		},
		methods: {
			getbanners(){
				axios.get('/get_banners').then(res => {
					this.banners = res.data;
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
			saveslider(){

                if(this.slider.title == ''){
                    alert("Please Enter Title")
                }

                if(this.slider.id == 0){
                    if(this.selectedFile == null){
                    alert("Please Add Image")
                    }
                }
                
				let url = '/add_banners';
				if(this.slider.id != 0){
					url = '/update_slider';
				}

				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.slider));

				axios.post(url, fd, {
					onUploadProgress: upe => {
						let progress = Math.round(upe.loaded / upe.total * 100);
					}
				}).then(res=>{
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.resetForm();
						this.getbanners();
					}
				})
			},
			editslider(slider){
				let keys = Object.keys(this.slider);
				keys.forEach(key => {
					this.slider[key] = slider[key];
				})

				if(slider.image == null || slider.image == ''){
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/banners/'+slider.image;
				}
			},
			deleteslider(bannerId){
				let deleteConfirm = confirm('Are you sure?');
				if(deleteConfirm == false){
					return;
				}
				axios.post('/delete_banner', {bannerId: bannerId}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getbanners();
					}
				})
			},
			resetForm(){
				this.imageUrl = '';
				this.selectedFile = null;
                this.slider.title = '';
                this.slider.offer_link = '';
			}
		}
	})
</script>