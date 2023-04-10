<div id="quotationInvoice">
	<a href="/quotation" title="" class="buttonAshiqe">Back To Quotation</a>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<quotation-invoice v-bind:quotation_id="quotationId"></quotation-invoice>
		</div>
	</div>
</div>

<script src="<?php echo base_url();?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/axios.min.js"></script>
<script src="<?php echo base_url();?>assets/js/vue/components/quotationInvoice.js"></script>
<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script>
	new Vue({
		el: '#quotationInvoice',
		components: {
			quotationInvoice
		},
		data(){
			return {
				quotationId: parseInt('<?php echo $quotationId;?>')
			}
		}
	})
</script>

