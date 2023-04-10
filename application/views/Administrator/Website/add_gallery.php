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

	#images label {
		font-size: 13px;
	}

	#images select {
		border-radius: 3px;
	}

	#images .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#images .add-button:hover {
		background-color: #41add6;
		color: white;
	}

	#images input[type="file"] {
		display: none;
	}

	#images .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}

	#images .custom-file-upload:hover {
		background-color: #41add6;
	}

	#galleryImage {
		height: 100%;
	}

	.center {
		display: flex;
		justify-content: center;
	}
</style>
<div id="images">
	<form @submit.prevent="savegallery">
		<div class="row center" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-8">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Title:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="gallery.title">
					</div>
				</div>

				<!-- <div class="form-group clearfix">
					<label class="control-label col-md-4">Description:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="gallery.offer_link">
					</div>
				</div> -->

				<div class="form-group clearfix">
					<div class="col-md-7 col-md-offset-4">
						<input type="submit" class="btn btn-success btn-sm" value="Save">
					</div>
				</div>
			</div>
			<div class="col-md-2 text-center;">
				<div class="form-group clearfix">
					<div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
						<img id="galleryImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
						<img id="galleryImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
					</div>
					<div style="text-align:center;">
						<label class="custom-file-upload">
							<input type="file" @change="previewImage" />
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
				<datatable :columns="columns" :data="images" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td>{{ row.id }}</td>
							<td>{{ row.title }}</td>
							<td>
								<img v-bind:src="`/uploads/imageGallery/${row.image}`" alt="" style="height:30px;width:30px">
							</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editgallery(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deletegallery(row.id)">
										<i class="fa fa-trash"></i>
									</button>
								<?php } ?>
							</td>
						</tr>
					</template>
				</datatable>
				<datatable-pager v-model="page" type="abbreviated" :per-page="per_page" style="margin-bottom: 50px;"></datatable-pager>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#images',
		data() {
			return {
				gallery: {
					id: 0,
					title: '',
					image: ''
				},
				images: [],
				imageUrl: '',
				selectedFile: null,
				columns: [{
						label: 'SL',
						field: 'id',
						align: 'center',
						filterable: false
					},
					{
						label: 'Title',
						field: 'title',
						align: 'center'
					},
					{
						label: 'Image',
						field: 'image',
						align: 'center'
					},
					{
						label: 'Action',
						align: 'center',
						filterable: false
					}
				],
				page: 1,
				per_page: 10,
				filter: ''
			}
		},
		created() {
			this.getimages();
		},
		methods: {
			getimages() {
				axios.get(location.origin+'/get_image_gallery').then(res => {
					this.images = res.data;
				})	
			},
			previewImage() {
				if (event.target.files.length > 0) {
					this.selectedFile = event.target.files[0];
					this.imageUrl = URL.createObjectURL(this.selectedFile);
				} else {
					this.selectedFile = null;
					this.imageUrl = null;
				}
			},
			savegallery() {

				if (this.gallery.title == '') {
					alert("Please Enter Title")
					return
				}

				if (this.gallery.id == 0) {
					if (this.selectedFile == null) {
						alert("Please Add Image")
						return
					}
				}

				let url;
				if (this.gallery.id != 0) {
					url = location.origin + '/update_image_gallery/';
				} else {
					url = location.origin + '/add_image_gallery/';
				}

				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.gallery));


				axios.post(url, fd, {
					onUploadProgress: upe => {
						let progress = Math.round(upe.loaded / upe.total * 100);
					}
				}).then(res => {
					let r = res.data;
					console.log(r.message);
					if (r.success) {
						this.resetForm();
						this.getimages();
					}
				})

			},
			editgallery(gallery) {
				let keys = Object.keys(this.gallery);
				keys.forEach(key => {
					this.gallery[key] = gallery[key];
				})

				if (gallery.image == null || gallery.image == '') {
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/imageGallery/' + gallery.image;
				}
			},
			deletegallery(galleryId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_image_gallery', {
					galleryId: galleryId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getimages();
					}
				})
			},
			resetForm() {
				this.imageUrl = '';
				this.selectedFile = null;
				this.gallery.title = '';
				this.gallery.offer_link = '';
			}
		}
	})
</script>