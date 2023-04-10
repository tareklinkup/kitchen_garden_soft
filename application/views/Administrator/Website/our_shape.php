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

	#shapes label {
		font-size: 13px;
	}

	#shapes select {
		border-radius: 3px;
	}

	#shapes .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#shapes .add-button:hover {
		background-color: #41add6;
		color: white;
	}

	#shapes input[type="file"] {
		display: none;
	}

	#shapes .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}

	#shapes .custom-file-upload:hover {
		background-color: #41add6;
	}

	#shapeImage {
		height: 100%;
	}

	.center {
		display: flex;
		justify-content: center;
	}
</style>
<div id="shapes">
	<form @submit.prevent="saveshape">
		<div class="row center" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-8">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Name:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="shape.name">
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Designation:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="shape.designation">
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Facebook Link:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="shape.facebook">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Twitter Link:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="shape.twitter">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Instagram Link:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="shape.instagram">
					</div>
				</div>

				<div class="form-group clearfix">
					<label class="control-label col-md-4">Linkedin Link:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="shape.linkedin">
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
						<img id="shapeImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
						<img id="shapeImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
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
				<datatable :columns="columns" :data="shapes" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td>{{ row.id }}</td>
							<td>{{ row.name }}</td>
							<td>{{ row.designation }}</td>
							<td>
								<img v-bind:src="`/uploads/shape/${row.image}`" alt="" style="height:30px;width:30px">
							</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editshape(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteshape(row.id)">
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
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#shapes',
		data() {
			return {
				shape: {
					id: 0,
					name: '',
					designation: '',
					facebook: '',
					twitter: '',
					instagram: '',
					linkedin: '',
					image: ''
				},
				shapes: [],
				imageUrl: '',
				selectedFile: null,
				columns: [{
						label: 'SL',
						field: 'id',
						align: 'center',
						filterable: false
					},
					{
						label: 'Name',
						field: 'name',
						align: 'center'
					},
					{
						label: 'Designation',
						field: 'designation',
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
			this.getshapes();
		},
		methods: {
			getshapes() {
				axios.get(window.location.origin + '/get_shape').then(res => {
					this.shapes = res.data;
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
			saveshape() {

				if (this.shape.name == '') {
					alert("Please Enter Name")
					return
				}

				if (this.shape.name.length > 50) {
					alert("Please Enter Name Within 50 characters")
					return
				}

				if (this.shape.designation.length > 50) {
					alert("Please Enter Designation Within 50 characters")
					return
				}

				if (this.shape.id == 0) {
					if (this.selectedFile == null) {
						alert("Please Add Image")
						return
					}
				}

				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.shape));

				if (this.shape.id != 0) {
					let url = window.location.origin + '/update_shapes';
					axios.post(url, fd, {
						onUploadProgress: upe => {
							let progress = Math.round(upe.loaded / upe.total * 100);
						}
					}).then(res => {
						let r = res.data;
						alert(r.message)
						if (r.success) {
							this.resetForm();
							this.getshapes();
						}
					})
				} else {
					let url = window.location.origin + '/add_shapes';
					axios.post(url, fd, {
						onUploadProgress: upe => {
							let progress = Math.round(upe.loaded / upe.total * 100);
						}
					}).then(res => {
						let r = res.data;
						alert(r.message)
						if (r.success) {
							this.resetForm();
							this.getshapes();
						}
					})
				}
			},
			editshape(shape) {
				let keys = Object.keys(this.shape);
				keys.forEach(key => {
					this.shape[key] = shape[key];
				})

				if (shape.image == null || shape.image == '') {
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/shape/' + shape.image;
				}
			},
			deleteshape(shapeId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_shape', {
					shapeId: shapeId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getshapes();
					}
				})
			},
			resetForm() {
				this.shape.name = '';
				this.shape.designation = '';
				this.shape.facebook = '';
				this.shape.twitter = '';
				this.shape.instagram = '';
				this.shape.linkedin = '';
				this.imageUrl = '';
				this.selectedFile = null;
				this.shape.title = '';
				this.shape.offer_link = '';
			}
		}
	})
</script>