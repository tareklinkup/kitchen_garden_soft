<div id="productionInvoice">
    <div class="row" style="display:none;" v-bind:style="{display: production.production_id == undefined ? 'none' : ''}">
        <div class="col-md-12" style="margin-bottom: 10px;">
			<a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
		</div>
        <div class="col-md-12">
            <div id="invoiceContent">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="heading">Production Invoice</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <table class="info-table">
                            <tr><td>Invoice</td><td>&nbsp;:&nbsp;</td><td>{{ production.production_sl }}</td></tr>
                            <tr><td>Date</td><td>&nbsp;:&nbsp;</td><td>{{ production.date }}</td></tr>
                        </table>
                    </div>
                    <div class="col-xs-4 col-xs-offset-2">
                        <table class="info-table">
                            <tr><td>Shift</td><td>&nbsp;:&nbsp;</td><td>{{ production.shift }}</td></tr>
                            <tr><td>Incharge</td><td>&nbsp;:&nbsp;</td><td>{{ production.incharge_name }}</td></tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="line"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <table class="details-table">
                            <tr>
                                <td colspan="4" style="text-align:center;font-weight:bold;font-size:15px;">Materials</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Material</td>
                                <td style="text-align:center;">Quantity</td>
                                <td style="text-align:center;">Price</td>
                                <td style="text-align:center;">Total</td>
                            </tr>
                            <tr v-for="material in productionMaterials">
                                <td style="text-align:left;">{{ material.name }}</td>
                                <td style="text-align:right;">{{ material.quantity }} {{ material.unit_name }}</td>
                                <td style="text-align:right;">{{ material.purchase_rate }}</td>
                                <td style="text-align:right;">{{ material.total }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-xs-6">
                        <table class="details-table">
                            <tr>
                                <td colspan="4" style="text-align:center;font-weight:bold;font-size:15px;">Products</td>
                            </tr>
                            <tr>
                                <td style="text-align:center;">Product</td>
                                <td style="text-align:center;">Quantity</td>
                                <td style="text-align:center;">Price</td>
                                <td style="text-align:center;">Total</td>
                            </tr>
                            <tr v-for="product in productionProducts">
                                <td style="text-align:left;">{{ product.name }}</td>
                                <td style="text-align:right;">{{ product.quantity }} {{ product.unit_name }}</td>
                                <td style="text-align:right;">{{ product.price }}</td>
                                <td style="text-align:right;">{{ product.total }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="line"></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-7">
                        <br>
                        <strong>Note: </strong>
                        {{ production.note }}
                    </div>
                    <div class="col-xs-5">
                        <table class="info-table">
                            <tr><td>Material Cost</td><td>&nbsp;:&nbsp;</td><td style="text-align:right;">{{ production.material_cost }}</td></tr>
                            <tr><td>Labour Cost</td><td>&nbsp;:&nbsp;</td><td style="text-align:right;">{{ production.labour_cost }}</td></tr>
                            <tr><td>Other Cost</td><td>&nbsp;:&nbsp;</td><td style="text-align:right;">{{ production.other_cost }}</td></tr>
                            <tr><td colspan="3" style="border-bottom: 1px solid #ccc;"></td></tr>
                            <tr><td>Total Cost</td><td>&nbsp;:&nbsp;</td><td style="text-align:right;">{{ production.total_cost }}</td></tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>

<script>
    new Vue({
        el: '#productionInvoice',
        data(){
            return {
                productionId: parseInt('<?php echo $productionId;?>'),
                production: {},
                productionMaterials: [],
                productionProducts: [],
                style: null
            }
        },
        created(){
            this.setStyle();
            this.getProduction();
            this.getProductionMaterials();
            this.getProductionProducts();
        },
        methods: {
            setStyle(){
                this.style = document.createElement('style');
                this.style.innerHTML = `
                    .heading {
                        padding: 5px;
                        font-weight: bold;
                        font-size: 16px;
                        text-align: center;
                        border-top: 1px dotted #454545;
                        border-bottom: 1px dotted #454545;
                    }
                    .info-table, .details-table {
                        margin:10px 0!important;
                        width: 100%;
                    }
                    .info-table tr td:first-child {
                        font-weight: bold;
                    }
                    .line {
                        border-bottom: 1px dotted #454545;
                    }
                    .details-table td {
                        border: 1px solid #a0a0a0;
                        padding: 3px 8px;
                    }
                `;
                document.head.appendChild(this.style);
            },
            getProduction(){
                axios.post('/get_productions', {production_id: this.productionId}).then(res => {
                    if(res.data.length == 0){
                        return;
                    }
                    this.production = res.data[0];
                })
            },
            getProductionMaterials(){
                axios.post('/get_production_details', {production_id: this.productionId}).then(res => {
                    this.productionMaterials = res.data;
                })
            },
            getProductionProducts(){
                axios.post('/get_production_products', {production_id: this.productionId}).then(res => {
                    this.productionProducts = res.data;
                })
            },
            async print(){
				let invoiceContent = `
					<div class="container">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#invoiceContent').innerHTML}
							</div>
						</div>
					</div>
				`;

				var reportWindow = window.open('', 'PRINT', `height=${screen.height}, width=${screen.width}`);
				reportWindow.document.write(`
					<?php $this->load->view('Administrator/reports/reportHeader.php');?>
				`);

				let invoiceStyle = reportWindow.document.createElement('style');
                invoiceStyle.innerHTML = this.style.innerHTML;
                reportWindow.document.head.appendChild(invoiceStyle);

				reportWindow.document.body.innerHTML += invoiceContent;

				reportWindow.focus();
				await new Promise(resolve => setTimeout(resolve, 1000));
				reportWindow.print();
				reportWindow.close();
			}
        }
    })
</script>
