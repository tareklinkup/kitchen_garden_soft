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

#products label {
    font-size: 13px;
}

#products select {
    border-radius: 3px;
}

#products .add-button {
    padding: 2.5px;
    width: 28px;
    background-color: #298db4;
    display: block;
    text-align: center;
    color: white;
}

#products .add-button:hover {
    background-color: #41add6;
    color: white;
}

#products .custom-file-upload {
    border: 1px solid #ccc;
    display: inline-block;
    padding: 5px 12px;
    cursor: pointer;
    margin-top: 5px;
    background-color: #298db4;
    border: none;
    color: white;
}

#products .custom-file-upload:hover {
    background-color: #41add6;
}

#productImage {
    height: 100%;
}
</style>
<div id="products">
    <form @submit.prevent="saveProduct">
        <div class="row" style="margin-top: 10px">
            <div class="col-md-6">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Product Id:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_Code" readonly>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Category:</label>
                    <div class="col-md-7">
                        <select class="form-control" v-if="categories.length == 0"></select>
                        <v-select v-bind:options="categories" v-model="selectedCategory" label="ProductCategory_Name"
                            v-if="categories.length > 0"></v-select>
                    </div>
                    <div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/category" target="_blank"
                            class="add-button"><i class="fa fa-plus"></i></a></div>
                </div>

                <!-- <div class="form-group clearfix">
                    <label class="control-label col-md-4">Brand:</label>
                    <div class="col-md-7">
                        <select class="form-control" v-if="brands.length == 0"></select>
                        <v-select v-bind:options="brands" v-model="selectedBrand" label="brand_name"
                            v-if="brands.length > 0"></v-select>
                    </div>
                    <div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/brand" target="_blank"
                            class="add-button"><i class="fa fa-plus"></i></a></div>
                </div> -->

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Product Name:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_Name" required>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Unit:</label>
                    <div class="col-md-7">
                        <select class="form-control" v-if="units.length == 0"></select>
                        <v-select v-bind:options="units" v-model="selectedUnit" label="Unit_Name"
                            v-if="units.length > 0"></v-select>
                    </div>
                    <div class="col-md-1" style="padding:0;margin-left: -15px;"><a href="/unit" target="_blank"
                            class="add-button"><i class="fa fa-plus"></i></a></div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">VAT:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.vat">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Re-order level:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_ReOrederLevel" required>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Purchase Rate:</label>
                    <div class="col-md-7">
                        <input type="text" id="purchase_rate" class="form-control"
                            v-model="product.Product_Purchase_Rate" required
                            v-bind:disabled="product.is_service ? true : false">
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Sales Rate:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_SellingPrice" required>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4">Wholesale Rate:</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="product.Product_WholesaleRate" required>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <label class="control-label col-md-4" for="service">Is Service:</label>
                    <div class="col-md-7">
                        <input type="checkbox" v-model="product.is_service" @change="changeIsService" id="service">
                    </div>
                </div>

                <div class="form-group clearfix">
                    <label class="control-label col-md-4" for="website">Is Website:</label>
                    <div class="col-md-7">
                        <input type="checkbox" v-model="product.is_website" id="website">
                    </div>
                </div>

                <!-- <div class="form-group clearfix">
					<label class="control-label col-md-4">Others Image</label>
					<div class="col-md-7">
						<input type="file" v-model="selectedFileMultiple" multiple="multiple" class="form-control">
					</div>
				</div> -->
            </div>
        </div>


        <div class="col-md-6" style="margin-top:5px">
            <div class="row">
                <label class="control-label col-md-12">Description :</label><br>
                <div class="col-md-12">
                    <template>
                        <div>
                            <mc-wysiwyg v-model="product.description" :height="225"></mc-wysiwyg>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <label class="control-label col-md-4" for="website">Image:</label>
            <div class="col-md-7">
                <div class="form-group clearfix float-right">
                    <div style="width: 100px;height:100px;border: 1px solid #ccc;overflow:hidden;">
                        <img id="productImage" v-if="imageUrl == '' || imageUrl == null" src="/assets/no_image.gif">
                        <img id="productImage" v-if="imageUrl != '' && imageUrl != null" v-bind:src="imageUrl">
                    </div>
                    <div style="text-align:center;">
                        <label class="custom-file-upload">
                            <input type="file" @change="previewImage" style="display:none" />
                            Select Image
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group clearfix">
                <div class="col-md-4">

                </div>
                <div class="col-md-7">
                    <input type="submit" class="btn btn-success btn-sm float-right" value="Save">
                </div>
            </div>

        </div>
    </form>
   
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
                <datatable :columns="columns" :data="products" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.Product_SlNo }}</td>
                            <td>{{ row.Product_Name }}</td>
                            <td>{{ row.ProductCategory_Name }}</td>
							<td>{{ row.Product_Purchase_Rate }}</td>
							<td>{{ row.Product_SellingPrice }}</td>
							<td>{{ row.Product_WholesaleRate }}</td>
							<td>{{ row.vat }}</td>
							<td>{{ row.is_service }}</td>
							<td>{{ row.Unit_Name }}</td>
							<td>
								<?php if($this->session->userdata('accountType') != 'u'){?>
								<button type="button" class="button edit" @click="editProduct(row)">
									<i class="fa fa-pencil"></i>
								</button>
								<button type="button" class="button" @click="deleteProduct(row.Product_SlNo, row.image)">
									<i class="fa fa-trash"></i>
								</button>
								<?php }?>
								<a class="button"  v-bind:href="`/Administrator/Products/barcodeGenerate/${row.Product_SlNo}`">
									<i class="fa fa-barcode"></i>
								</a>
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
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://unpkg.com/@mycure/vue-wysiwyg/dist/mc-wysiwyg.js"></script>

<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>

<script>
Vue.use(McWysiwyg.default);
Vue.component('v-select', VueSelect.VueSelect);
new Vue({
    el: '#products',
    data() {
        return {
            product: {
                Product_SlNo: '',
                Product_Code: "<?php echo $productCode;?>",
                Product_Name: '',
                ProductCategory_ID: '',
                brand: '',
                description: '',
                Product_ReOrederLevel: '',
                Product_Purchase_Rate: '',
                Product_SellingPrice: '',
                Product_WholesaleRate: 0,
                Unit_ID: '',
                vat: 0,
                image: '',
                is_service: false,
                is_website: true
            },
            products: [],
            categories: [],
            selectedCategory: {
                ProductCategory_SlNo: '',
                ProductCategory_Name: 'Select Category',
            },
            brands: [],
            selectedBrand:{
                brand_SiNo: '',
                brand_name: 'Select Brand',
            },
            units: [],
            selectedUnit: null,
            columns: [{
                    label: 'Product Id',
                    field: 'Product_Code',
                    align: 'center',
                    filterable: false
                },
                {
                    label: 'Product Name',
                    field: 'Product_Name',
                    align: 'center'
                },
                { label: 'Category', field: 'ProductCategory_Name', align: 'center' },
                { label: 'Purchase Price', field: 'Product_Purchase_Rate', align: 'center' },
                { label: 'Sales Price', field: 'Product_SellingPrice', align: 'center' },
                { label: 'Wholesale Price', field: 'Product_WholesaleRate', align: 'center' },
                { label: 'VAT', field: 'vat', align: 'center' },
                { label: 'Is Service', field: 'is_service', align: 'center' },
                { label: 'Unit', field: 'Unit_Name', align: 'center' },
                { label: 'Action', align: 'center', filterable: false }
            ],
            page: 1,
            per_page: 10,
            filter: '',
            imageUrl: '',
            selectedFile: null
        }
    },
    created() {
        this.getCategories();
        this.getBrands();
        this.getUnits();
        this.getProducts();
    },
    methods: {
        changeIsService() {
            if (this.product.is_service) {
                this.product.Product_Purchase_Rate = 0;
            }
        },
        getCategories() {
            axios.get('/get_categories').then(res => {
                this.categories = res.data;
            })
        },
        getBrands() {
            axios.get('/get_brands').then(res => {
                this.brands = res.data;
            })
        },
        getUnits() {
            axios.get('/get_units').then(res => {
                this.units = res.data;
            })
        },
        getProducts() {
            axios.get('/get_products').then(res => {
                this.products = res.data;

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
        saveProduct() {
            if (this.selectedCategory == null) {
                alert('Select category');
                return;
            }
            if (this.selectedUnit == null) {
                alert('Select unit');
                return;
            }

            // if (this.selectedBrand.brand_SiNo == "") {
            //     alert('Select Brand');
            //     return;
            // } else {
            //     this.product.brand = this.selectedBrand.brand_SiNo;
            // }

            this.product.ProductCategory_ID = this.selectedCategory.ProductCategory_SlNo;
            this.product.Unit_ID = this.selectedUnit.Unit_SlNo;

            let url = '/add_product';
            if (this.product.Product_SlNo != 0) {
                url = '/update_product';
            }

            let fd = new FormData();
            fd.append('image', this.selectedFile);
            // fd.append('imageMultiple', this.selectedFileMultiple);
            fd.append('data', JSON.stringify(this.product));
            axios.post(url, fd).then(res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    this.clearForm();
                    this.product.Product_Code = r.productId;
                    this.getCategories();
                    this.getBrands();
                    this.getUnits();
                    this.getProducts();
                }
            })

        },
        editProduct(product) {
            let keys = Object.keys(this.product);
            keys.forEach(key => {
                this.product[key] = product[key];
            })

            this.product.is_service = product.is_service == 'true' ? true : false;
            this.product.is_website = product.is_website == 'true' ? true : false;
            this.selectedCategory = {
                ProductCategory_SlNo: product.ProductCategory_ID,
                ProductCategory_Name: product.ProductCategory_Name
            }

            this.selectedUnit = {
                Unit_SlNo: product.Unit_ID,
                Unit_Name: product.Unit_Name
            }
            this.selectedBrand = {
                brand_SiNo: product.brand,
                brand_name: product.brand_name
            }

            $('#editor').html('');
			$('#editor').html(product.description);
            console.log(product)
            if(product.image == null || product.image == ''){
					this.imageUrl = null;
				} else {
					this.imageUrl = '/uploads/products/'+product.image;
					this.image = '/uploads/products/'+product.image;
				}
        },
        deleteProduct(productId, image) {
            let deleteConfirm = confirm('Are you sure?');
            if (deleteConfirm == false) {
                return;
            }
            axios.post('/delete_product', {
                productId: productId,
                image: image
            }).then(res => {
                let r = res.data;
                alert(r.message);
                if (r.success) {
                    this.getProducts();
                }
            })
        },
        clearForm() {
            let keys = Object.keys(this.product);
            keys.forEach(key => {
                if (typeof(this.product[key]) == "string") {
                    this.product[key] = '';
                } else if (typeof(this.product[key]) == "number") {
                    this.product[key] = 0;
                }
            });

            this.imageUrl = '';
            this.selectedFile = null;
            // this.selectedBrand.brand_SiNo = '';
            // this.selectedBrand.brand_name = '';
            // this.selectedUnit.Unit_SlNo =  '';
            // this.selectedUnit.Unit_Name = '';
            // this.selectedCategory.ProductCategory_SlNo = '';
          
        }
    }
})
</script>