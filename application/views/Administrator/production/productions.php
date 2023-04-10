<style>
    .form-group {
        margin-right: 15px;
    }

    .v-select {
        width: 200px;
        height: 30px;
    }

    .v-select .dropdown-toggle {
        height: 29px;
        border-radius: 0;
    }

    .v-select input[type=search] {
        margin: 0;
    }

    input[type="date"] {
        border-radius: 0 !important;
        height: 29px;
        margin-top: 2px;
    }
</style>
<div id="prod">
    <div class="row" style="padding: 15px;border-bottom: 1px solid #ccc;">
        <div class="col-sm-12">
            <form class="form-inline" v-on:submit.prevent="getProductions">
                <div class="form-group">
                    <label>Date From</label><br>
                    <input type="date" class="form-control" v-model="dateFrom">
                </div>
                <div class="form-group">
                    <label>Date To</label><br>
                    <input type="date" class="form-control" v-model="dateTo">
                </div>
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-info btn-xs">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row" style="padding: 15px;display:none;" v-bind:style="{display: productions.length > 0 ? '' : 'none'}">
        <div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
        <div class="col-sm-12">
            <div class="table-responsive" id="reportContent">
                <table class="table table-bordered record-table">
                    <thead>
                        <tr>
                            <th>Production Id</th>
                            <th>Date</th>
                            <th>Incharge</th>
                            <th>Shift</th>
                            <th>Total Cost</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="production in productions">
                            <tr>
                                <td>{{ production.production_sl }}</td>
                                <td>{{ production.date }}</td>
                                <td>{{ production.incharge_name }}</td>
                                <td>{{ production.shift }}</td>
                                <td style="text-align:right;">{{ production.total_cost }}</td>
                                <td style="text-align:left;">{{ production.products[0].name }}</td>
                                <td style="text-align:right;">{{ production.products[0].quantity }}</td>
                                <td>
                                    <a href="" v-bind:href="`/production_invoice/${production.production_id}`" target="_blank"><i class="fa fa-file-text"></i></a>
                                    <?php if($this->session->userdata('accountType') != 'u'){?>
                                    <a href="" v-bind:href="`/production/edit/${production.production_id}`"><i class="fa fa-pencil-square"></i></a>
                                    <a href="" v-on:click.prevent="deleteProduction(production.production_id)"><i class="fa fa-trash"></i></a>
                                    <?php }?>
                                </td>
                            </tr>
                            <tr v-for="(product, sl) in production.products.slice(1)">
                                <td colspan="5" v-bind:rowspan="production.products.length - 1" v-if="sl == 0"></td>
                                <td style="text-align:left;">{{ product.name }}</td>
                                <td style="text-align:right;">{{ product.quantity }}</td>
                                <td></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align: right">Total</td>
                            <td style="text-align:right;">{{ productions.reduce((p, c) => { return p + parseFloat(c.total_cost)}, 0).toFixed(2) }}</td>
                            <td colspan="2"></td>
                            <td></td>
                        </tr>
                    </tfoot>
                    
                </table>
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
        el: '#prod',
        data() {
            return {
                dateFrom: moment().format('YYYY-MM-DD'),
                dateTo: moment().format('YYYY-MM-DD'),
                productions: []
            }
        },
        created() {
            this.getProductions();
        },
        methods: {
            getProductions(){
                let options = {
                    dateFrom: this.dateFrom,
                    dateTo: this.dateTo
                }
                axios.post('get_production_record', options)
                    .then(res=>{
                        this.productions = res.data.filter((obj) => {return obj.products.length > 0});
                    })
            },
            deleteProduction(producton_id){
                let deleteConfirm = confirm('Are you sure?');
                if(deleteConfirm == false){
                    return;
                }

                axios.post('/delete_production', {productionId: producton_id}).then(res => {
                    let r = res.data;
                    alert(r.message);
                    if(r.success){
                        this.getProductions();
                    }
                })
            },
            async print(){
				let dateText = '';
				if(this.dateFrom != '' && this.dateTo != ''){
					dateText = `Statemenet from <strong>${this.dateFrom}</strong> to <strong>${this.dateTo}</strong>`;
				}

				let reportContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12 text-center">
								<h3>Production Record</h3>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 text-right">
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

				reportWindow.document.body.innerHTML += reportContent;

				let rows = reportWindow.document.querySelectorAll('.record-table tr');
                rows.forEach(row => {
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