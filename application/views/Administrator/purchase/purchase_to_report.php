<div id="purchaseInvoice">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<purchase-invoice v-bind:purchase_id="purchaseId"></purchase-invoice>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/components/purchaseInvoice.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script>
	new Vue({
		el: '#purchaseInvoice',
		components: {
			purchaseInvoice
		},
		data(){
			return {
				purchaseId: parseInt('<?php echo $purchaseId;?>')
			}
		}
	})
</script>

