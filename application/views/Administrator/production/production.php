<style>
    .v-select{
		margin-top:-2.5px;
        float: right;
        min-width: 180px;
        width: 100%;
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
</style>
<div id="production">
    <div class="row">
        <div class="col-xs-12 col-md-5">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Materials</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
    
                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>
    
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-sm-12">
                                <form id="materialForm" v-on:submit.prevent="addToCart">
                                    <div class="form-group clearfix clearfix">
                                        <label class="col-sm-4 control-label">
                                            Material
                                        </label>
                                        <div class="col-sm-8">
                                            <v-select label="display_text" v-bind:options="materials" v-model="selectedMaterial" placeholder="Select Material" v-on:input="setFocus();getMaterialStock()"></v-select>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group clearfix clearfix">
                                        <label class="col-sm-4 control-label">
                                            Quantity <span v-if="selectedMaterial.material_id != ''" style="display:none;" v-bind:style="{display: selectedMaterial.material_id != '' ? '' : 'none'}">({{ selectedMaterial.unit_name }})</span>
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" ref="quantity" required class="form-control" placeholder="Quantity" v-model="selectedMaterial.quantity" @input="calculateMaterialTotal" /> 
                                        </div>
                                        <div class="col-sm-4" v-if="selectedMaterial.material_id != ''" style="padding-top:3px;display:none;" v-bind:style="{display: selectedMaterial.material_id != 'none' ? '' : ''}">
                                            Stock: {{ stock_quantity }}
                                        </div>
                                    </div>
    
    
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label">
                                            Price
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="text" required class="form-control" placeholder="Pur. Rate" v-model="selectedMaterial.purchase_rate" @input="calculateMaterialTotal" />
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" required class="form-control" placeholder="Total" v-model="selectedMaterial.total" disabled />
                                        </div>
                                    </div>
    
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-default pull-right">Add to Cart</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
                <div class="table-responsive">
                    <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                        <thead>
                            <tr>
                                <th style="width:4%;color:#000;">SL</th>
                                <th style="width:20%;color:#000;">Material Name</th>
                                <th style="width:13%;color:#000;">Category</th>
                                <th style="width:5%;color:#000;">Qty</th>
                                <th style="width:5%;color:#000;">Amount</th>
                                <th style="width:10%;color:#000;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="display:none;" v-bind:style="{display: cart.length > 0 ? '' : 'none'}">
                            <tr v-for="(material, sl) in cart">
                                <td>{{ sl + 1}}</td>
                                <td>{{ material.name }}</td>
                                <td>{{ material.category_name }}</td>
                                <td>{{ material.quantity }} {{ material.unit_name }}</td>
                                <td>{{ material.total }}</td>
                                <td><a href="" v-on:click.prevent="removeFromCart(material)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>

        <div class="col-xs-12 col-md-4">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Finish Products</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
    
                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-sm-12">
                                <form id="productForm" v-on:submit.prevent="addToProductCart">
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label">Product</label>
                                        <div class="col-sm-8">
                                            <v-select label="display_text" v-bind:options="products" v-model="selectedProduct" placeholder="Select Product" @input="onChangeProduct"></v-select>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label">Quantity</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" placeholder="Quantity" ref="productQuantity" v-model="selectedProduct.quantity" required @input="calculateProductTotal">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label">Price</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" v-model="selectedProduct.Product_Purchase_Rate" @input="calculateProductTotal">
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" v-model="selectedProduct.total" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <label class="col-sm-4 control-label"></label>
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-default pull-right">Add to Cart</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
                <div class="table-responsive">
                    <table class="table table-bordered" style="color:#000;margin-bottom: 5px;">
                        <thead>
                            <tr>
                                <th style="width:4%;color:#000;">SL</th>
                                <th style="width:20%;color:#000;">Product Name</th>
                                <th style="width:5%;color:#000;">Qty</th>
                                <th style="width:5%;color:#000;">Amount</th>
                                <th style="width:10%;color:#000;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="display:none;" v-bind:style="{display: cartProducts.length > 0 ? '' : 'none'}">
                            <tr v-for="(product, sl) in cartProducts">
                                <td>{{ sl + 1}}</td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.quantity }} {{ product.unit_name }}</td>
                                <td>{{ product.total }}</td>
                                <td><a href="" v-on:click.prevent="removeFromProductCart(product)"><i class="fa fa-trash"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-md-3">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Production</h4>
                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse">
                            <i class="ace-icon fa fa-chevron-up"></i>
                        </a>
    
                        <a href="#" data-action="close">
                            <i class="ace-icon fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <form v-on:submit.prevent="saveProduction">
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Production Id</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" placeholder="Production Id" v-model="production.production_sl">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Date</label>
                                <div class="col-sm-12">
                                    <input type="date" class="form-control" v-model="production.date" required>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Incharge</label>
                                <div class="col-sm-12">
                                    <v-select label="display_name" v-bind:options="employees" v-model="selectedEmployee" placeholder="Select Incharge"></v-select>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Shift</label>
                                <div class="col-sm-12">
                                    <select class="form-control" v-model="production.shift" style="padding:0px 3px;">
                                        <option value="">Select Shift</option>
                                        <option v-for="shift in shifts" v-bind:value="shift.name">{{ shift.name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Labour Cost</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" v-model="production.labour_cost" v-on:input="calculateTotal">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Material Cost</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" v-model="production.material_cost" disabled>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Other Cost</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" v-model="production.other_cost" v-on:input="calculateTotal">
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label"><strong>Total Cost</strong></label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" v-model="production.total_cost" readonly>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <label class="col-sm-12 control-label">Note</label>
                                <div class="col-sm-12">
                                    <textarea class="form-control" placeholder="Note" v-model="production.note"></textarea>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-sm-7 col-sm-offset-5">
                                    <button type="submit" class="btn btn-success pull-right" v-bind:disabled="productionInProgress ? true : false">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        el: '#production',
        data() {
            return {
                production: {
                    production_id: parseInt('<?php echo $production_id;?>'),
                    production_sl: '<?php echo $productionSl;?>',
                    date: '',
                    incharge_id: '',
                    shift: '',
                    note: '',
                    labour_cost: 0.00,
                    material_cost: 0.00,
                    other_cost: 0.00,
                    total_cost: 0.00
                },
                employees: [],
                shifts: [],
                products: [],
                materials: [],
                selectedEmployee: null,
                selectedProduct: {
                    Product_SlNo: 0,
                    Product_Name: '',
                    display_text: 'Select Product',
                    quantity: '',
                    Product_Purchase_Rate: 0.00,
                    total: 0,
                },
                selectedMaterial: {
                    material_id: '',
                    name: 'Select Material',
                    purchase_rate: 0.00,
                    quantity: '',
                    total: 0,
                },
                cart: [],
                stock_quantity: 0,
                cartProducts: [],
                productionInProgress: false
            }
        },
        created() {
            this.getEmployees();
            this.getShifts();
            this.getProducts();
            this.getMaterials();
            this.production.date = moment().format('YYYY-MM-DD');

            if(this.production.production_id != 0){
                this.getProduction();
            }
        },
        methods: {
            getEmployees(){
                axios.get('/get_employees')
                    .then(res=>{
                        this.employees = res.data;
                    })
            },
            getShifts(){
                axios.get('/get_shifts')
                    .then(res=>{
                        this.shifts = res.data;
                    })
            },
            getProducts(){
                axios.get('/get_products')
                    .then(res=>{
                        this.products = res.data;
                    })
            },
            getMaterials(){
                axios.get('/get_materials')
                    .then(res=>{
                        this.materials = res.data;
                    })
            },
            getMaterialStock(){
                if(this.selectedMaterial.material_id == ''){
                    return;
                }
                axios.post('/get_material_stock', {material_id: this.selectedMaterial.material_id})
                    .then(res=>{
                        this.stock_quantity = res.data[0].stock_quantity;
                    })
            },
            calculateMaterialTotal() {
                this.selectedMaterial.total = this.selectedMaterial.quantity * this.selectedMaterial.purchase_rate;
            },
            setFocus(){
                this.$refs.quantity.focus();
            },
            addToCart(){
                let ind = this.cart.findIndex(m => m.material_id == this.selectedMaterial.material_id);
                if(ind > -1){
                    this.cart[ind].quantity = parseFloat(this.cart[ind].quantity) + parseFloat(this.selectedMaterial.quantity);
                } else {
                    this.cart.push(this.selectedMaterial);
                }
                this.clearMaterial();
                this.calculateTotal();
            },
            removeFromCart(material){
                let ind = this.cart.findIndex(m => m.material_id == material.material_id);
                if(ind > -1){
                    this.cart.splice(ind, 1);
                    this.calculateTotal();
                }
                
            },
            clearMaterial(){
                this.selectedMaterial = {
                    material_id: '',
                    name: '',
                    purchase_rate: 0.00,
                    quantity: ''
                }
            },
            onChangeProduct(){
                this.$refs.productQuantity.focus();
            },
            calculateProductTotal() {
                this.selectedProduct.total = this.selectedProduct.quantity * this.selectedProduct.Product_Purchase_Rate;
            },
            addToProductCart(){
                if(this.selectedProduct == null || this.selectedProduct.Product_SlNo == 0){
                    alert('Select product');
                    return;
                }

                let ind = this.cartProducts.findIndex(p => p.product_id == this.selectedProduct.Product_SlNo);
                if(ind > -1){
                    this.cartProducts[ind].quantity = parseFloat(this.cartProducts[ind].quantity) +  parseFloat(this.selectedProduct.quantity);
                } else {
                    let product = {
                        product_id: this.selectedProduct.Product_SlNo,
                        name: this.selectedProduct.Product_Name,
                        category_name: this.selectedProduct.ProductCategory_Name,
                        quantity: this.selectedProduct.quantity,
                        price: this.selectedProduct.Product_Purchase_Rate,
                        total: this.selectedProduct.total,
                    }
                    this.cartProducts.push(product);
                }

                this.clearProduct();
            },
            removeFromProductCart(product){
                let ind = this.cartProducts.findIndex(p => p.product_id == product.product_id);
                if(ind > -1){
                    this.cartProducts.splice(ind, 1);
                }
            },
            clearProduct(){
                this.selectedProduct = {
                    Product_SlNo: 0,
                    Product_Name: '',
                    display_text: 'Select Product',
                    quantity: '',
                    Product_Purchase_Rate: 0.00
                }
            },
            calculateTotal(){
                this.production.material_cost = this.cart.reduce((p, c) => { return +p + +c.total }, 0);
                this.production.total_cost = 
                        parseFloat(this.production.labour_cost) +
                        parseFloat(this.production.material_cost) +
                        parseFloat(this.production.other_cost);
            },
            saveProduction(){
                if(this.selectedEmployee == null){
                    alert('Select production incharge');
                    return;
                }
                if(this.cart.length == 0){
                    alert('Material cart is empty');
                    return;
                }
                if(this.cartProducts.length == 0){
                    alert('Product cart is empty');
                    return;
                }

                this.production.incharge_id = this.selectedEmployee.Employee_SlNo;

                let url = '/add_production';
                if(this.production.production_id != 0){
                    url = '/update_production';
                }

                let data = {
                    production: this.production,
                    materials: this.cart,
                    products: this.cartProducts
                }

                this.productionInProgress = true;
                axios.post(url, data).then(async res=>{
                    let r = res.data;
                    alert(r.message);
                    if(r.success){
                        let conf = confirm('Production success, Do you want to view invoice?');
                        if(conf){
                            window.open('/production_invoice/'+r.productionId, '_blank');
                            await new Promise(r => setTimeout(r, 1000));
                        }
                        window.location = '/production';
                    }
                })
            },
            async getProduction(){
                await axios.post('/get_productions', {production_id: this.production.production_id})
                    .then(res=>{
                        this.production = res.data[0]; 
                        this.selectedEmployee = {
                            Employee_SlNo: this.production.incharge_id,
                            display_name: this.production.incharge_name + ' - ' + this.production.incharge_id,
                        }
                    })
                await axios.post('/get_production_details', {production_id: this.production.production_id})
                    .then(res=>{
                        this.cart = res.data;
                    })

                await axios.post('/get_production_products', {production_id: this.production.production_id})
                    .then(res=>{
                        this.cartProducts = res.data;
                    })
            }
        }
    })
</script>