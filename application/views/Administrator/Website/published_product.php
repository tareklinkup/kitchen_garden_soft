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
<div id="publisheds">
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-8">
            <form class="form-horizontal" @submit.prevent="addpublished">

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right">Published Category</label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
						<v-select v-bind:options="categories" label="name" v-model="selectedCategory" placeholder="Select Category"></v-select>
                    </div>
				</div>

                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"> Product </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
						<v-select v-bind:options="products" label="display_text" v-model="selectedProduct" placeholder="Select Product"></v-select>
                    </div>
				</div>

                <div class="form-group"  style="display:none" >
                    <label class="col-sm-6 control-label no-padding-right">Start Date </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="date" placeholder="Date" class="form-control" v-model="published.start_date"/>
                    </div>
				</div>

                <div class="form-group" style="display:none">
                    <label class="col-sm-6 control-label no-padding-right">End Date </label>
                    <label class="col-sm-1 control-label no-padding-right">:</label>
                    <div class="col-sm-5">
                        <input type="date" placeholder="Date" class="form-control" v-model="published.end_date"/>
                    </div>
				</div>
				
                <div class="form-group">
                    <label class="col-sm-6 control-label no-padding-right"></label>
                    <label class="col-sm-1 control-label no-padding-right"></label>
                    <div class="col-sm-5">
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
                <datatable :columns="columns" :data="publisheds" :filter-by="filter">
                    <template scope="{ row }">
                        <tr>
                            <td>{{ row.id }}</td>
                            <td>{{ row.name }}</td>
                            <td>{{ row.product_name }}</td>
                            <!--<td>{{ row.start_date }}</td>-->
                            <!--<td>{{ row.end_date }}</td>-->
                            <td><button v-if="row.status == 1" type="button" class="button" @click="statusPublished(row.id)">
                                   Published
                                </button>
                                <button v-if="row.status == 0" type="button" class="button" @click="statusPublished(row.id)">
                                   UnPublished
                                </button>
                            </td>
                            <td>
                                <?php if($this->session->userdata('accountType') != 'u'){?>
                                <button type="button" class="button edit" @click="editpublished(row)">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" class="button" @click="deletePublished(row.id)">
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
        el: '#publisheds',
        data(){
            return {
                published: {
                    id:"",
                    published_category_id: '',
                    product_id:'',
                    start_date: moment().format('YYYY-MM-DD'),
                    end_date: '',
                },
				products: [],
				selectedProduct: null,
                selectedCategory:{
                    id: '',
                    name: 'Select Category'
                },
                publisheds: [],
                categories:[],
				columns: [
                    { label: 'Id', field: 'id', align: 'center', filterable: false },
                    { label: 'Published Category Name', field: 'product_name', align: 'center' },
                    { label: 'Product Name', field: 'name', align: 'center' },
                    { label: 'Status', field: 'status', align: 'center',},
                    { label: 'Action', align: 'center', filterable: false }
                ],
                page: 1,
                per_page: 10,
                filter: ''
            }
        },
        created(){
            this.getProducts();
            this.getPublisheds();
            this.getPublishedCategory();
        },
        methods: {
            getProducts(){
                axios.post('/get_products', {isService: 'false',isWebsite: 'true'}).then(res => {
                    this.products = res.data;
                })
            },
            getPublisheds(){
                axios.get('/get_publisheds').then(res => {
                    this.publisheds = res.data;
                })
            },
            getPublishedCategory(){
                axios.get('/get_published_category').then(res => {
                    this.categories = res.data;
                })
            },
			addpublished(){
				
                if(this.selectedCategory.id == ''){
                    alert('Select Category');
					return;
                }
                else{                  
                    this.published.published_category_id = this.selectedCategory.id;
                }

                if(this.selectedProduct == null){
					alert('Select product');
					return;
				}
                else{
                    this.published.product_id = this.selectedProduct.Product_SlNo ;
                }

                // if(this.selectedCategory.id == 1){
                //     if(this.published.start_date == ''){
                //         alert('Enter Start Date');
				// 	    return;
                //     }                  
                //     if(this.published.end_date == ''){
                //         alert('Enter End Date');
				// 	    return;
                //     }
                //     if(this.published.start_date > this.published.end_date ){
                //     alert('Please Enter Start Date Less then End Date ');
                //     return;
                //     }
                // }

                let url = '/add_published';
                if(this.published.id != 0){
                    url = '/update_published'
                }
				axios.post(url, this.published).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
						this.resetForm();
                        this.getPublisheds();
					}
				})
			},

            editpublished(published){
                console.log(published);
                this.selectedProduct = {
                    Product_SlNo: published.id,
                    display_text: published.product_name
                }
                this.selectedCategory = {
                    id: published.published_category_id,
                    name: published.name
                }
                this.published.id = published.id;
                this.published.start_date = published.start_date;
                this.published.end_date = published.end_date;
            },
            deletePublished(publishedId){
                let deleteConfirm = confirm('Are you sure?');
                if(deleteConfirm == false){
                    return;
                }
                axios.post('/delete_published', {publishedId: publishedId}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
                        this.getPublisheds();
					}
				})
            },  
            statusPublished(publishedId){
                let publishConfirm = confirm('Are you sure?');
                if(publishConfirm == false){
                    return;
                }
                axios.post('/status_published', {publishedId: publishedId}).then(res => {
					let r = res.data;
					alert(r.message);
					if(r.success){
                        this.getPublisheds();
					}
				})
            },           
			resetForm(){
				this.selectedProduct = null;
			}
        }
    })
</script>
