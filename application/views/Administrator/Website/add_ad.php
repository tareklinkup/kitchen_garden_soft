<style>
	#ads label{
		font-size:13px;
	}
	#ads select{
		border-radius: 3px;
	}
	#ads .add-button{
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display:block;
		text-align: center;
		color: white;
	}
	#ads .add-button:hover{
		background-color: #41add6;
		color: white;
	}
	#ads input[type="file"] {
		display: none;
	}
	#ads .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}
	#ads .custom-file-upload:hover{
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
<div id="ads">
		<form @submit.prevent="savead">
		<div class="row center" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-8">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Title:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="ad.title">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Offer Link:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="ad.offer_link">
					</div>
				</div>

                <div class="form-group clearfix">
					<label class="control-label col-md-4">Position:</label>
					<div class="col-md-7">
						<select class="form-control" v-model="ad.position">
                            <option value="" selected>Select Position</option>
                            <option value="after_product">After Product</option>
                            <!-- <option value="after_slider2">After Slider 2</option>
                            <option value="after_slider3">After Slider 3</option> -->
                        </select>
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
					<datatable :columns="columns" :data="ads" :filter-by="filter" style="margin-bottom: 5px;">
						<template scope="{ row }">
							<tr>
                                <td>{{ row.id }}</td>
                                <td>{{ row.position }}</td>
								<td>{{ row.title }}</td>
								<td>{{ row.offer_link }}</td>
                                <td><button v-if="row.status == 'a'" type="button" class="button" @click="statusChange(row.id)">
                                        Published
                                    </button>
                                    <button v-if="row.status == 'd'" type="button" class="button" @click="statusChange(row.id)">
                                        UnPublished
                                    </button>
                                </td>
								<td>
									<?php if($this->session->userdata('accountType') != 'u'){?>
									<button type="button" class="button edit" @click="editad(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deletead(row.id)">
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
		el: '#ads',
		data(){
			return {
				ad: {
					id:0,
                    title:'',
                    offer_link: '',
                    image:'',
                    position:'',
				},
				ads: [],
				imageUrl: '',
				selectedFile: null,				
				columns: [
                    { label: 'SL', field: 'id', align: 'center', filterable: false },
                    { label: 'Position', field: 'position', align: 'center' },
                    { label: 'Title', field: 'title', align: 'center' },
                    { label: 'Offer Link', field: 'offer_link', align: 'center' },
                    { label: 'Status', field: 'status', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
			}
		},
		created(){
			this.getads();
		},
		methods: {
			getads(){
				axios.get('/get_ads_list').then(res => {
					this.ads = res.data;
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

                if(this.ad.title == ''){
                    alert("Please Enter Title");
                    return;
                }

                if(this.ad.position == ''){
                    alert("Please Select Position");
                    return;
                }

                if(this.ad.id == 0){
                    if(this.selectedFile == null){
                    alert("Please Add Image");
                    return;
                    }
                }
                
				let url = '/add_ads';
				if(this.ad.id != 0){
					url = '/update_ad';
				}
                
				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.ad));

				axios.post(url, fd, {
					onUploadProgress: upe => {
						let progress = Math.round(upe.loaded / upe.total * 100);
					}
				}).then(res=>{
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.resetForm();
						this.getads();
					}
				})
			},
			editad(ad){
				let keys = Object.keys(this.ad);
				keys.forEach(key => {
					this.ad[key] = ad[key];
				})

				if(ad.image == null || ad.image == ''){
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/adss/'+ad.image;
				}
			},
            statusChange(adId){
                let confirms = confirm('Are you sure?');
                if(confirms == false){
                    return;
                }
                axios.post('/status_ads', {adId: adId}).then(res => {
					let r = res.data;
                    console.log(res.data);
					alert(r.message);
					if(r.success){
                        this.getads();
					}
				})
            },
			deletead(adId){
				let deleteConfirm = confirm('Are you sure?');
				if(deleteConfirm == false){
					return;
				}
				axios.post('/delete_ads', {adId: adId}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getads();
					}
				})
			},
			resetForm(){
				this.imageUrl = '';
				this.selectedFile = null;
                this.ad.title = '';
                this.ad.offer_link = '';
                this.ad.position = '';
			}
		}
	})
</script>