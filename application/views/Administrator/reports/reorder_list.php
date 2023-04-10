<div id="reOrderList">
    <div style="display:none;" v-bind:style="{display: reOrderList.length > 0 ? '' : 'none'}">
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-12">
                <a href="" @click.prevent="print"><i class="fa fa-print"></i> Print</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="reportContent">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Product Id</th>
                            <th>Product Name</th>
                            <th>Category Name</th>
                            <th>Re Order Level</th>
                            <th>Current Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in reOrderList">
                            <td>{{ product.Product_Code }}</td>
                            <td>{{ product.Product_Name }}</td>
                            <td>{{ product.ProductCategory_Name }}</td>
                            <td style="text-align: right;">{{ product.Product_ReOrederLevel }} {{ product.Unit_Name }}</td>
                            <td style="text-align: right;">{{ product.current_quantity }} {{ product.Unit_Name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>

<script>
    new Vue({
        el: '#reOrderList',
        data() {
            return {
                reOrderList: []
            }
        },
        created() {
            this.getProductStock();
        },
        methods: {
            getProductStock() {
                axios.post('/get_current_stock', {
                    stockType: 'low'
                }).then(res => {
                    this.reOrderList = res.data.stock;
                    console.log(this.reOrderList);
                })
            },
            async print(){
				let reportContent = `
					<div class="container">
						<h4 style="text-align:center">Re order list</h4 style="text-align:center">
						<div class="row">
							<div class="col-xs-12">
								${document.querySelector('#reportContent').innerHTML}
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