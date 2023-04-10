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
<div class="row" id="cashLedger">
	<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right"> Date from </label>
			<div class="col-sm-2">
				<input type="date" class="form-control" v-model="fromDate">
			</div>
			<label class="col-sm-1 control-label no-padding-right text-center" style="width:30px"> to </label>
			<div class="col-sm-2">
				<input type="date" class="form-control" v-model="toDate">
			</div>
		</div>

		<div class="form-group">
			<div class="col-sm-1">
				<input type="button" class="btn btn-primary" value="Show" v-on:click="getReport" style="margin-top:0px;border:0px;height:28px;">
			</div>
		</div>
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
						<th style="text-align:center">Cash In</th>
						<th style="text-align:center">Cash Out</th>
						<th style="text-align:center">Balance</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td style="text-align:left;">Previous Balance</td>
						<td colspan="2"></td>
						<td style="text-align:right;">{{ parseFloat(previousBalance).toFixed(2) }}</td>
					</tr>
					<tr v-for="row in ledger">
						<td>{{ row.date }}</td>
						<td style="text-align:left;">{{ row.description }}</td>
						<td style="text-align:right;">{{ parseFloat(row.in_amount).toFixed(2) }}</td>
						<td style="text-align:right;">{{ parseFloat(row.out_amount).toFixed(2) }}</td>
						<td style="text-align:right;">{{ parseFloat(row.balance).toFixed(2) }}</td>
					</tr>
				</tbody>
				<tbody v-if="ledger.length == 0">
					<tr>
						<td colspan="5">No records found</td>
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
		el: '#cashLedger',
		data(){
			return {
				fromDate: null,
				toDate: null,
				ledger: [],
				previousBalance: 0.00,
				showTable: false
			}
		},
		created(){
			this.fromDate = moment().format('YYYY-MM-DD');
			this.toDate = moment().format('YYYY-MM-DD');
		},
		methods:{
			getReport(){
				let data = {
					fromDate: this.fromDate,
					toDate: this.toDate,
				}

				axios.post('/get_cash_ledger', data).then(res => {
					this.ledger = res.data.ledger;
					this.previousBalance = res.data.previousBalance;
					this.showTable = true;
				})
			},
			async print(){
				let reportContent = `
					<div class="container">
						<h4 style="text-align:center">Cash Ledger</h4 style="text-align:center">
						<div class="row">
							<div class="col-xs-6 col-xs-offset-6 text-right">
								<strong>Statement from</strong> ${this.fromDate} <strong>to</strong> ${this.toDate}
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