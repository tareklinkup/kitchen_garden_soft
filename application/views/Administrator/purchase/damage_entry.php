<style>
    .v-select{
		margin-bottom: 5px;
	}
	.v-select.open .dropdown-toggle{
		border-bottom: 1px solid #ccc;
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
</style>
<div id="damages">
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-12">
            <form class="form-horizontal" @submit.prevent="addDamage">
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Code </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="text" placeholder="Code" class="form-control" v-model="damage.Damage_InvoiceNo" required readonly/>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Date </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="date" placeholder="Date" class="form-control" v-model="damage.Damage_Date" required/>
                    </div>
				</div>
				
                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Product </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
						<v-select v-bind:options="products" label="display_text" v-model="selectedProduct" placeholder="Select Product"></v-select>
                    </div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Damage Quantity </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="number" placeholder="Quantity" class="form-control" v-model="damage.DamageDetails_DamageQuantity" required/>
                    </div>
				</div>

				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Damage Amount </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <input type="number" placeholder="Amount" class="form-control" v-model="damage.damage_amount" required/>
                    </div>
				</div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"> Description </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" placeholder="Description" v-model="damage.Damage_Description" required></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right"></label>
                    <label class="col-sm-1 control-label no-padding-right"></label>
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-sm btn-success">
                            Submit
                            <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="damages" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.Damage_InvoiceNo }}</td>
                            <td>{{ row.Damage_Date }}</td>
                            <td>{{ row.Product_Code }}</td>
                            <td>{{ row.Product_Name }}</td>
                            <td>{{ row.DamageDetails_DamageQuantity }}</td>
                            <td>{{ row.damage_amount }}</td>
                            <td>{{ row.Damage_Description }}</td>
                            <td>
                                <?php if($this->session->userdata('accountType') != 'u'){?>
                                <button type="button" class="button edit" @click="editDamage(row)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="button" @click="deleteDamage(row.Damage_SlNo)">
                                    <i class="fa fa-trash"></i>
                                </button>
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
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script>
	Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#damages',
        data(){
            return {
                damage: {
                    Damage_SlNo: 0,
                    Damage_InvoiceNo: '<?php echo $damageCode;?>',
                    Damage_Date: moment().format('YYYY-MM-DD'),
                    Damage_Description: '',
					Product_SlNo: '',
					DamageDetails_DamageQuantity: '',
					damage_amount: ''
                },
				products: [],
				selectedProduct: null,
                damages: [],

				columns: [
                    { label: 'Code', field: 'Damage_InvoiceNo', align: 'center', filterable: false },
                    { label: 'Date', field: 'Damage_Date', align: 'center' },
                    { label: 'Product Code', field: 'Product_Code', align: 'center' },
                    { label: 'Product Name', field: 'Product_Name', align: 'center' },
                    { label: 'Quantity', field: 'DamageDetails_DamageQuantity', align: 'center' },
                    { label: 'Damage Amount', field: 'damage_amount', align: 'center' },
                    { label: 'Description', field: 'Damage_Description', align: 'center' },
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
            }
        },
        created(){
            this.getProducts();
            this.getDamages();
        },
        methods: {
            getProducts(){
                axios.get('/get_products').then(res => {
                    this.products = res.data;
                })
            },
			addDamage(){
				if(this.selectedProduct == null){
					alert('Select product');
					return;
				}

				this.damage.Product_SlNo = this.selectedProduct.Product_SlNo;

                let url = '/add_damage';
                if(this.damage.Damage_SlNo != 0){
                    url = '/update_damage'
                }
				axios.post(url, this.damage).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.resetForm();
						this.damage.Damage_InvoiceNo = r.newCode;
                        this.getDamages();
					}
				})
			},

            editDamage(damage){
                let keys = Object.keys(this.damage);
                keys.forEach(key => this.damage[key] = damage[key]);

                this.selectedProduct = {
                    Product_SlNo: damage.Product_SlNo,
                    display_text: `${damage.Product_Name} - ${damage.Product_Code}`
                }
            },

            deleteDamage(damageId){
                let deleteConfirm = confirm('Are you sure?');
                if(deleteConfirm == false){
                    return;
                }
                axios.post('/delete_damage', {damageId: damageId}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
                        this.getDamages();
					}
				})
            },

            getDamages(){
                axios.get('/get_damages').then(res => {
                    this.damages = res.data;
                })
            },

			resetForm(){
				this.damage.Damage_SlNo = '';
				this.damage.Damage_Description = '';
				this.damage.Product_SlNo = '';
				this.damage.DamageDetails_DamageQuantity = '';
				this.damage.damage_amount = '';
				this.selectedProduct = null;
			}
        }
    })
</script>
