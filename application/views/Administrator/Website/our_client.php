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

	#clients label {
		font-size: 13px;
	}

	#clients select {
		border-radius: 3px;
	}

	#clients .add-button {
		padding: 2.5px;
		width: 28px;
		background-color: #298db4;
		display: block;
		text-align: center;
		color: white;
	}

	#clients .add-button:hover {
		background-color: #41add6;
		color: white;
	}

	#clients input[type="file"] {
		display: none;
	}

	#clients .custom-file-upload {
		border: 1px solid #ccc;
		display: inline-block;
		padding: 5px 12px;
		cursor: pointer;
		margin-top: 5px;
		background-color: #298db4;
		border: none;
		color: white;
	}

	#clients .custom-file-upload:hover {
		background-color: #41add6;
	}

	#clientImage {
		height: 100%;
	}

	.center {
		display: flex;
		justify-content: center;
	}
</style>
<div id="clients">
	<form @submit.prevent="saveClient">
		<div class="row center" style="margin-top: 10px;margin-bottom:15px;border-bottom: 1px solid #ccc;padding-bottom:15px;">
			<div class="col-md-8">
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Name:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="client.name">
					</div>
				</div>
				<div class="form-group clearfix">
					<label class="control-label col-md-4">Website Link:</label>
					<div class="col-md-7">
						<input type="text" class="form-control" v-model="client.website_link">
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
					<span class="text-danger">(200 x 200)</span>
					<div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
						<img id="clientImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
						<img id="clientImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
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
				<datatable :columns="columns" :data="clients" :filter-by="filter" style="margin-bottom: 5px;">
					<template scope="{ row }">
						<tr>
							<td>{{ row.id }}</td>
							<td>{{ row.name }}</td>
							<td>{{ row.website_link }}</td>
							<td>
								<img v-bind:src="`/uploads/client/${row.image}`" alt="" style="height:30px;width:30px">
							</td>
							<td>
								<?php if ($this->session->userdata('accountType') != 'u') { ?>
									<button type="button" class="button edit" @click="editclient(row)">
										<i class="fa fa-pencil"></i>
									</button>
									<button type="button" class="button" @click="deleteclient(row.id)">
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
		el: '#clients',
		data() {
			return {
				client: {
					id: 0,
					name: '',
					website_link: '',
					image: ''
				},
				clients: [],
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
						label: 'Website Link',
						field: 'website_link',
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
			this.getClients();
		},
		methods: {
			getClients() {
				axios.get(window.location.origin + '/get_client').then(res => {
					this.clients = res.data;
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
			saveClient() {

				if (this.client.name == '') {
					alert("Please Enter Name")
					return
				}

				if (this.client.id == 0) {
					if (this.selectedFile == null) {
						alert("Please Add Image")
						return
					}
				}

				let fd = new FormData();
				fd.append('image', this.selectedFile);
				fd.append('data', JSON.stringify(this.client));

				if (this.client.id != 0) {
					let url = window.location.origin + '/update_clients';
					axios.post(url, fd, {
						onUploadProgress: upe => {
							let progress = Math.round(upe.loaded / upe.total * 100);
						}
					}).then(res => {
						let r = res.data;
						alert(r.message)
						if (r.success) {
							this.resetForm();
							this.getClients();
						}
					})
				} else {
					let url = window.location.origin + '/add_clients';
					axios.post(url, fd, {
						onUploadProgress: upe => {
							let progress = Math.round(upe.loaded / upe.total * 100);
						}
					}).then(res => {
						let r = res.data;
						alert(r.message)
						if (r.success) {
							this.resetForm();
							this.getClients();
						}
					})
				}
			},
			editclient(client) {
				let keys = Object.keys(this.client);
				keys.forEach(key => {
					this.client[key] = client[key];
				})

				if (client.image == null || client.image == '') {
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/client/' + client.image;
				}
			},
			deleteclient(clientId) {
				let deleteConfirm = confirm('Are you sure?');
				if (deleteConfirm == false) {
					return;
				}
				axios.post('/delete_client', {
					clientId: clientId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getClients();
					}
				})
			},
			resetForm() {
				this.client.id = '';
				this.client.name = '';
				this.client.website_link = '';
				this.imageUrl = '';
				this.selectedFile = null;
			}
		}
	})
</script>