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
<div id="salesRecord">
	<div class="row" style="border-bottom: 1px solid #ccc;padding: 3px 0;">
		<div class="col-md-12">
			<form class="form-inline" id="searchForm" @submit.prevent="getSearchResult">
				
				<div class="form-group" style="display:none;" v-bind:style="{display: users.length > 0 ? '' : 'none'}">
					<label>User</label>
					<v-select v-bind:options="users" v-model="selectedUser" label="FullName" placeholder="Select User"></v-select>
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

	<div class="row" style="margin-top:15px;display:none;" v-bind:style="{display: results.length > 0 ? '' : 'none'}">
		<div class="col-md-12" style="margin-bottom: 10px;">
			<div>
				<input type="checkbox" v-model="mark_all" style="margin-left: 15px;" @change="markAll"> Mark All
				<div style="display: inline-block; float: right;">
					<a class="btn btn-xs btn-info" href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
					<a class="btn btn-xs btn-danger" href="" @click.prevent="markDelete"><i class="fa fa-trash"></i> Delete</a>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="table-responsive" id="reportContent">
				<table class="record-table">
					<thead>
						<tr>
							<th></th>
							<th>Sl</th>
							<th>User Name</th>
							<th>User Type</th>
							<th>Login Time</th>
							<th>Logout Time</th>
							<th>IP</th>
							<th>Branch</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr v-for="(result, sl) in results">
							<td><input type="checkbox" v-model="result.action" style="margin-left: 15px;"></td>
							<td>{{ sl + 1 }}</td>
							<td>{{ result.User_Name }}</td>
							<td>{{ result.UserType }}</td>
							<td style="color:green">{{ result.login_time | formatDateTime }}</td>
							<td style="color:red">{{ result.logout_time | formatDateTime }}</td>
							<td>{{ result.ip_address }}</td>
							<td>{{ result.Brunch_name }}</td>
							<td style="text-align:center;">
								<a href="" title="Delete Record" @click.prevent="deleteRecord(result.id)"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/lodash.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
	new Vue({
		el: '#salesRecord',
		data(){
			return {
				dateFrom: moment().format('YYYY-MM-DD'),
				dateTo: moment().format('YYYY-MM-DD'),
				users: [],
				selectedUser: null,
				results: [],
				mark_all : false,
			}
		},
		filters: {
	        formatDateTime(dt) {
	            return dt == '' || dt == null ? '' : moment(dt).format('DD-MM-YYYY h:mm:ss a');
	        }
	    },
		created(){
			this.getUsers();
		},
		methods: {
			markAll(){
				if (this.mark_all) {
					this.results.map( (item) => {
						item.action = true;
						return item;
					})
				}else{
					this.results.map( (item) => {
						item.action = false;
						return item;
					})
				}
			},
			markDelete(){
				let mark_arr = [];

				this.results.forEach(item => {
					if (item.action) {
						mark_arr.push(item.id);
					}
				})
				if (mark_arr.length == 0) {
					alert('Please mark atleast one item');
					return;
				}

				let deleteConf = confirm('Are you sure?');
				if(deleteConf == false){
					return;
				}

				axios.post('delete_user_activity', {mark_arr}).then( res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getSearchResult();
					}
				})

			},
			getUsers(){
				axios.get('/get_all_users').then(res => {
					this.users = res.data;
				})
			},
			getSearchResult(){
				let filter = {
					dateFrom 	: this.dateFrom,
					dateTo 		: this.dateTo,
					user_id 	: this.selectedUser == null ? null : this.selectedUser.User_SlNo
				}

				axios.post('/get_user_activity', filter).then( res => {
					this.results = res.data;
					this.results.map( (item) => {
						item.action = false;
						return item;
					})
					$('input[type="checkbox"]').prop('checked', false);
				});
			},
			deleteRecord(id){
				let deleteConf = confirm('Are you sure?');
				if(deleteConf == false){
					return;
				}
				axios.post('/delete_user_activity', {id})
				.then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getSearchResult();
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
				if(this.selectedUser != null && this.selectedUser.FullName != ''){
					userText = `<strong>User: </strong> ${this.selectedUser.FullName}`;
				}

				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>User Activity</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-6">
								${userText}
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
					row.firstChild.remove();
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