<style>
  .v-select {
    margin-bottom: 5px;
    width: 250px;
  }

  .v-select .dropdown-toggle {
    padding: 0px;
  }

  .v-select input[type=search],
  .v-select input[type=search]:focus {
    margin: 0px;
  }

  .v-select .selected-tag {
    margin: 0px;
  }
</style>

<div id="salesInvoiceReport" class="row">
  <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
    <div class="form-group" style="margin-top:10px;">
      <label class="col-sm-1 col-sm-offset-2 control-label no-padding-right"> Invoice no </label>
      <label class="col-sm-1 control-label no-padding-right"> : </label>
      <div class="col-sm-3">
        <v-select v-bind:options="invoices" label="invoice_text" v-model="selectedInvoice" v-on:input="viewInvoice" placeholder="Select Invoice"></v-select>
      </div>
    </div>

    <div class="form-group">
      <div class="col-sm-2">
        <input type="button" class="btn btn-primary" value="Show Report" v-on:click="viewInvoice" style="margin-top:0px;width:150px;display: none;">
      </div>
    </div>
  </div>
  <div class="col-md-8 col-md-offset-2">
    <br>
    <sales-invoice v-bind:sales_id="selectedInvoice.SaleMaster_SlNo" v-if="showInvoice"></sales-invoice>
  </div>
</div>



<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/vue-select.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/components/salesInvoice.js"></script>

<script>
  Vue.component('v-select', VueSelect.VueSelect);
  new Vue({
    el: '#salesInvoiceReport',
    data() {
      return {
        invoices: [],
        selectedInvoice: null,
        showInvoice: false
      }
    },
    created() {
      this.getSales();
    },
    methods: {
      getSales() {
        axios.get("/get_sales").then(res => {
          this.invoices = res.data.sales;
        })
      },
      async viewInvoice(){
        this.showInvoice = false;
        await new Promise(r => setTimeout(r, 500));
        this.showInvoice = true;
      }
    }
  })
</script>