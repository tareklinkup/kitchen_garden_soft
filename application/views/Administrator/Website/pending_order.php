<div id="orders">
    <div class="row">
        <div class="col-sm-12 form-inline">
        <br>
        <div class="form-group">
            <label for="filter" class="sr-only">Filter</label>
            <input type="text" class="form-control" v-model="filter" placeholder="Filter">
        </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="orders" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.SaleMaster_InvoiceNo }}</td>
                            <td>{{ row.SaleMaster_SaleDate }}</td>
                            <td>{{ row.Customer_Code }}</td>						
							<td>{{ row.Customer_Name }}</td>
                            <td>{{ row.Customer_Mobile }}</td>
                            <td>{{ row.cus_message??row.Customer_message }}</td>
							<td>{{ row.SaleMaster_TotalSaleAmount }}</td>
							<td><button type="button" class="button" @click="updateStatus(row.SaleMaster_SlNo)">
								On Processing</button></td>
							<td>
                            <a href="" title="Sale Invoice" v-bind:href="`/sale_invoice_print/${row.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file"></i></a>
								<a href="" title="Chalan" v-bind:href="`/chalan/${row.SaleMaster_SlNo}`" target="_blank"><i class="fa fa-file-o"></i></a>
								<?php if($this->session->userdata('accountType') != 'u'){?>
								<a href="javascript:" title="Edit Sale" @click="checkReturnAndEdit(row)"><i class="fa fa-edit"></i></a>
								<a href="" title="Delete Sale" @click.prevent="deleteSale(row.SaleMaster_SlNo)"><i class="fa fa-trash"></i></a>
								<?php }?>
							</td>
                        </tr>
                    </template>
                </datatable>
                <datatable-pager v-model="page" type="abbreviated" :per-page="per_page"></datatable-pager>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>
<script>
new Vue({
    el: '#orders',
    data() {
        return {
            product: {
                Product_SlNo: '',
            },
            orders: [],
            columns: [
                { label: 'Invoice No', field: 'SaleMaster_InvoiceNo', align: 'center' },
                { label: 'Date', field: 'SaleMaster_SaleDate', align: 'center' },
                { label: 'Customer Code', field: 'Customer_Code', align: 'center' },
                { label: 'Customer Name', field: 'Customer_Name', align: 'center' },
                { label: 'Customer Mobile', field: 'Customer_Mobile', align: 'center' },
                { label: 'Message', field: 'cus_message', align: 'center' },                
                { label: 'Price', field: 'SaleMaster_TotalSaleAmount', align: 'center' },
                { label: 'Status', field: 'Status', align: 'center',filterable: false },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
        }
    },
    created() {
        this.getOrders();
    },
    methods: {
        checkReturnAndEdit(sale){
				axios.get('/check_sale_return/' + sale.SaleMaster_InvoiceNo).then(res=>{
					if(res.data.found){
						alert('Unable to edit. Sale return found!');
					}else{
						if(sale.is_service == 'true'){
							location.replace('/sales/service/'+sale.SaleMaster_SlNo);
						}else{
							location.replace('/sales/product/'+sale.SaleMaster_SlNo);
						}
					}
				})
		},
        deleteSale(saleId){
				let deleteConf = confirm('Are you sure?');
				if(deleteConf == false){
					return;
				}
				axios.post(location.origin+'/delete_sales', {saleId: saleId})
				.then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.getSalesRecord();
					}
				})
				.catch(error => {
					if(error.response){
						alert(`${error.response.status}, ${error.response.statusText}`);
					}
				})
		},
        getOrders() {
            axios.post('/get_orders',{status: 'p'}).then(res => {
                this.orders = res.data;
            })
        },
        fetchOrder() {
            let url = '/fetch_order';
            axios.post(url, this.order).then(res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    this.clearForm();
                    this.getOrders();
                }
            })

        },
        updateStatus(orderId) {
            let deleteConfirm = confirm('Are you sure?');
            if (deleteConfirm == false) {
                return;
            }
            axios.post('/update_order', {
                orderId: orderId, status: 'on'
            }).then(res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    this.getOrders();
                }
            })
        }

    }
})
</script>