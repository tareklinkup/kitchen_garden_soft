<style>
    .v-select {
        margin-bottom: 5px;
    }

    .v-select .form-control {
        height: 17px;
    }

    .button{
        width: 25px;
        height: 25px;
        border: none;
        color:white;
    }
    .edit{
        background-color:#7bb1e0;
    }
    .active{
        background-color: rgb(252, 89, 89);
    }
</style>

<div id="materials">
    <div class="row">
        <div class="col-sm-12">
            <form id="materialForm" class="form-horizontal" v-on:submit.prevent="saveMaterial">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Material Id</label>
                        <label class="control-label col-sm-1"> : </label>
                        <div class="col-sm-6">
                            <input type="text" name="code" id="code" v-model="material.code"
                                class="form-control" placeholder="Material Id" disabled="disabled">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Category</label>
                        <label class="control-label col-sm-1"> : </label>
                        <div class="col-sm-6">
                            <v-select label="ProductCategory_Name" v-bind:options="categories"
                                v-model="selectedCategory" placeholder="Select Category"></v-select>
                        </div>
                        <div class="col-sm-1" style="padding: 0;">
                            <a href="/category" title="Add New Category" class="btn btn-xs btn-danger"
                                style="height: 25px; border: 0; width: 27px; margin-left: -10px;margin-top:2px;"
                                target="_blank"><i class="fa fa-plus" aria-hidden="true"
                                    style="margin-top: 5px;"></i></a>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Name</label>
                        <label class="control-label col-sm-1"> : </label>
                        <div class="col-sm-6">
                            <input type="text" name="name" id="name" v-model="material.name" class="form-control"
                                placeholder="Material Name" required>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Re-Order Level</label>
                        <label class="control-label col-sm-1"> : </label>
                        <div class="col-sm-6">
                            <input type="text" name="reorder_level" id="reorder_level" v-model="material.reorder_level"
                                class="form-control" placeholder="Re-Order Level">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Purchase Rate</label>
                        <label class="control-label col-sm-1"> : </label>
                        <div class="col-sm-6">
                            <input type="text" name="purchase_rate" id="purchase_rate" v-model="material.purchase_rate"
                                class="form-control" placeholder="Purchase Rate" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Unit</label>
                        <label class="control-label col-sm-1"> : </label>
                        <div class="col-sm-6">
                            <v-select label="Unit_Name" v-bind:options="units" v-model="selectedUnit"
                                placeholder="Select Unit"></v-select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-top: 15px;">
                        <div class="col-sm-offset-5 col-sm-6">
                            <button type="submit" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
                                <span v-if="material.material_id == 0">Save</span>  
                                <span v-if="material.material_id != 0">Update</span>  
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-12">
            <h4>Material List</h4>
        </div>
        <div class="col-sm-12 form-inline">
            <div class="form-group">
                <label for="filter" class="sr-only">Filter</label>
                <input type="text" class="form-control" v-model="filter" placeholder="Filter">
            </div>
        </div>
        <div class="col-sm-12">
            <div class="table-responsive">
                <datatable :columns="columns" :data="materials" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.code }}</td>
                            <td>{{ row.name }}</td>
                            <td>{{ row.category_name }}</td>
                            <td>{{ row.reorder_level }}</td>
                            <td>{{ row.purchase_rate }}</td>
                            <td>{{ row.unit_name }}</td>
                            <td>{{ row.status_text }}</td>
                            <td>
                                <?php if($this->session->userdata('accountType') != 'u'){?>
                                <button class="button edit" @click="editMaterial(row)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button class="button" v-bind:class="{active: row.status == 1}" @click="changeStatus(row)">
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
<script src="<?php echo base_url();?>assets/js/vue/vuejs-datatable.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>

<script>
    Vue.component('v-select', VueSelect.VueSelect);
    new Vue({
        el: '#materials',
        data() {
            return {
                columns: [
                    { label: 'Material Id', field: 'code', align: 'center', filterable: false },
                    { label: 'Material Name', field: 'name' },
                    { label: 'Category', field: 'category_name' },
                    { label: 'Reorder Level', field: 'reorder_level' },
                    { label: 'Purchase Rate', field: 'purchase_rate' },
                    { label: 'Unit', field: 'unit_name' },
                    { label: 'Status', field: 'status_text' },
                    { label: 'Action', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: '',
                material: {
                    material_id: 0,
                    code: '<?php echo $materialCode;?>',
                    name: '',
                    category_id: '',
                    reorder_level: '',
                    purchase_rate: '',
                    unit_id: ''
                },
                materials: [],
                units: [],
                categories: [],
                selectedUnit: null,
                selectedCategory: null
            }
        },
        created() {
            this.getUnits();
            this.getCategories();
            this.getMaterials();
        },
        methods: {
            getUnits() {
                axios.get('/get_units')
                    .then(res => {
                        this.units = res.data;
                    })
            },
            getCategories() {
                axios.get('/get_categories')
                    .then(res => {
                        this.categories = res.data;
                    })
            },
            getMaterials() {
                axios.get('/get_materials')
                    .then(res => {
                        this.materials = res.data;
                    })
            },
            saveMaterial() {
                if(this.selectedCategory == null){
                    alert('select a category');
                    return;
                }

                if(this.selectedUnit == null){
                    alert('select a unit');
                    return;
                }


                this.material.unit_id = this.selectedUnit.Unit_SlNo;
                this.material.category_id = this.selectedCategory.ProductCategory_SlNo;

                let url = '/add_material';
                if (this.material.material_id != 0) {
                    url = '/update_material';
                }

                axios.post(url, this.material)
                    .then(res => {
                        let r = res.data;
                        alert(r.message);
                        if (r.success) {
                            location.reload();
                            //this.getMaterials();
                            //this.resetForm();
                        }
                    })
            },
            editMaterial(material){
                this.material.material_id = material.material_id;
                this.material.code = material.code;
                this.material.name = material.name;
                this.material.category_id = material.category_id;
                this.material.reorder_level = material.reorder_level;
                this.material.purchase_rate = material.purchase_rate;
                this.material.unit_id = material.unit_id;

                this.selectedCategory = { ProductCategory_SlNo: material.category_id, ProductCategory_Name: material.category_name };
                this.selectedUnit = { Unit_SlNo: material.unit_id, Unit_Name: material.unit_name };
            },
            changeStatus(material){
                axios.post('/change_material_status', material)
                    .then(res=>{
                        let r = res.data;
                        alert(r.message);
                        if(r.success){
                            this.getMaterials();
                        }
                    })
            },
            resetForm() {
                this.material = {
                    material_id: 0,
                    code: '',
                    name: '',
                    category_id: '',
                    reorder_level: '',
                    purchase_rate: '',
                    unit_id: ''
                },
                this.selectedUnit = null;
                this.selectedCategory = null;
            }
        }
    })
</script>