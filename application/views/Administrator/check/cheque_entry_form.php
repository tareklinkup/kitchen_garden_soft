
<div class="widget-box">
	<div class="widget-header">
		<h4 class="widget-title">Add New Cheque Information</h4>
	</div>
	<div class="widget-body">
		<div class="widget-main">
			<form id="check_form" >
				<div class="row">
					<div class="col-sm-6">

						<div class="form-group">
							<label class="col-sm-5 control-label no-padding-left" for="bank_name">Bank Name:<span class="text-bold text-danger">*</span> </label>
							<div class="col-sm-7">
								<input type="text" id="bank_name"  name="bank_name" required placeholder="Bank Name" class="form-control"  />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-5 control-label no-padding-left" for="branch_name">Branch Name:<span class="text-bold text-danger">*</span> </label>
							<div class="col-sm-7">
								<input type="text" id="branch_name"  name="branch_name" required placeholder="Branch Name" class="form-control"  />
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-5 control-label no-padding-left" for="check_no">Cheque No:<span class="text-bold text-danger">*</span> </label>
							<div class="col-sm-7">
								<input type="text" id="check_no"  name="check_no" required placeholder="Cheque No" class="form-control"  />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-5 control-label no-padding-left" for="check_amount">Cheque Amount:<span class="text-bold text-danger">*</span> </label>
							<div class="col-sm-7">
								<input type="text" id="check_amount"  name="check_amount" required placeholder="Cheque Amount" class="form-control"  />
							</div>
						</div>

					</div>

					<div class="col-sm-6">
						<div class="form-group">
							<label class="col-sm-5 control-label no-padding-left" for="date"> Date:<span class="text-bold text-danger">*</span> </label>
							<div class="col-sm-7">
								<input class="form-control date-picker" required id="date" name="date" type="text" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-5 control-label no-padding-left" for="check_date">Cheque Date:<span class="text-bold text-danger">*</span> </label>
							<div class="col-sm-7">
								<input class="form-control date-picker" required id="check_date" name="check_date" type="text" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-5 control-label no-padding-left" for="remid_date">Reminder Date:<span class="text-bold text-danger">*</span> </label>
							<div class="col-sm-7">
								<input class="form-control date-picker" required id="remid_date" name="remid_date" type="text" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-5 control-label no-padding-left" for="sub_date">Submit Date:<span class="text-bold text-danger">*</span> </label>
							<div class="col-sm-7">
								<input class="form-control date-picker" required id="sub_date" name="sub_date" type="text" value="<?php echo date('Y-m-d'); ?>"  data-date-format="yyyy-mm-dd" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-5 control-label no-padding-left" for="note">Description: </label>
							<div class="col-sm-7">
								<input type="text" id="note" name="note" class="form-control"  placeholder="Description" />
							</div>
						</div>

						<div class="form-group" style="margin-top: 10px;">
							<label class="col-sm-4 control-label no-padding-left" for="ord_budget_range"> </label>
							<div class="col-sm-8">
								<button type="submit" id="check_submit" style="height: 27px; padding-top: 0px; float: right; " class="btn btn-primary cus_submit">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$( document ).ready(function() {
		$('.date-picker').datepicker({
			autoclose: true,
			todayHighlight: true
		})
	});
</script>

<script>
	$(document).ready(function(){
		$('#check_submit').click(function(e){
			e.preventDefault();
			var isvalid = true;
			$('#check_form :input[required], select[required]').each(function (){
				var id = this.id;
				if (this.value.trim() === '') {
					$(this).css('border','1px solid red');
					$('#'+id+'_chosen >a').css('border','1px solid red');
					isvalid = false;
				}else{
					$(this).css('border','1px solid #ccc');
					$('#'+id+'_chosen >a').css('border','1px solid #ccc');
				}
			});

			if(isvalid){
				$.ajax({
					url:'<?= base_url()?>sale_cheque_store',
					type:'POST',
					dataType:'json',
					data:$('#check_form').serialize(),
					success:function(data){
						if(data == 1){

							alert('Cheque Store');
							$.fancybox.close();
						}else{
							alert('Cheque Not Store');
						}
					},error:function(error){
						console.log(error);
						alert('Cheque Not Store');
					}
				});
			}
		});
	})
</script>
