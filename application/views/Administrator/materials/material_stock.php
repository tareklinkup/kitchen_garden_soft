<div class="row">
    <div class="col-sm-12"><h2 class="text-center">Material Stock</h2></div>
</div>
<div class="row" id="materialStock">
    <div class="col-sm-12">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sl.</th>
                        <th>Material Name</th>
                        <th>Category</th>
                        <th>Total Purchased</th>
                        <th>Used in Production</th>
                        <th>Damaged</th>
                        <th>Current Stock</th>
                    </tr>
                </thead>
                <tbody style="display:none;" v-bind:style="{display:stock.length > 0 ? '' : 'none'}">
                    <tr v-for="(material, sl) in stock">
                        <td>{{ sl+1 }}</td>
                        <td>{{ material.name }}</td>
                        <td>{{ material.category_name }}</td>
                        <td>{{ material.purchased_quantity }} {{ material.unit_name}}</td>
                        <td>{{ material.production_quantity }} {{ material.unit_name}}</td>
                        <td>{{ material.damage_quantity }} {{ material.unit_name}}</td>
                        <td>{{ material.stock_quantity }} {{ material.unit_name}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script>
    new Vue({
        el: '#materialStock',
        data(){
            return {
                stock: []
            }
        },
        created(){
            this.getMaterialStock();
        },
        methods: {
            getMaterialStock(){
                axios.get('/get_material_stock')
                    .then(res=>{
                        this.stock = res.data;
                    })
            }
        }
    })
</script>