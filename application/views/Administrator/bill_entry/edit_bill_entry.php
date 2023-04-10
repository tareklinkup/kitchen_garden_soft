
<div class="col-xs-12" style="margin:50px 0px; width: 450px;">
	<!-- PAGE CONTENT BEGINS -->
	<div class="form-horizontal">
		
		<form method="post" id="Form">
			<input type="hidden" id="idd" value="<?=$edit->id?>">
			
			<div class="form-group">
				<label class="col-sm-4 control-label" for="Customer_id"> Date </label>
				<label class="col-sm-1 control-label">:</label>
				<div class="col-sm-6">
					<input type="text" name="date" id="date" class="form-control date-picker" value="<?=$edit->date; ?>"/>
				</div>
			</div>

			
			<div class="form-group">
				<label class="col-sm-4 control-label" for="cus_name"> Expense Head</label>
				<label class="col-sm-1 control-label">:</label>
				<div class="col-sm-6">
					<select name="exp_head" id="exp_head" required class="chosen-select form-control" style="height: 35px;">
						<?php $eHead = $this->Bill_model->editExpenseHead($edit->exp_head); ?>
						<option value="<?= $edit->exp_head ?>"><?=isset($eHead->head_name )?$eHead->head_name :''?></option>
						<?php foreach($ExpHead as $head): ?>
							<option value="<?= $head->id ?>"> <?= $head->head_name; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for=""> Amount </label>
				<label class="col-sm-1 control-label">:</label>
				<div class="col-sm-6">
					<input type="text" id="amount" required name="amount"  placeholder="Enter Amount" value="<?=$edit->amount?>" class="form-control" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-4 control-label" for=""> Remarks </label>
				<label class="col-sm-1 control-label">:</label>
				<div class="col-sm-6">
					<textarea placeholder="Enter Remarks" name="remarks" class="form-control"><?=$edit->remarks?></textarea>
				</div>
			</div>
	
		
			<div class="form-group">
				<label class="col-sm-5 control-label no-padding-right" for="form-field-1"></label>
				<label class="col-sm-1 control-label no-padding-right"></label>
				<div class="col-sm-3">
			    <button type="button" class="btn btn-sm btn-success" onclick="updateBill()" name="btnSubmit">
					Update
					<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
				</div>
			</div>	
		</form>
			
	</div>
</div>

<script type="text/javascript">
    function updateBill(){
    	var id = $("#idd").val();
        $.ajax({
            type: "POST",
            url: "<?= base_url();?>BillEntry/update/"+id,
            data: $("#Form").serialize(),
            dataType: "JSON",
            success:function(data){   
				if(data.successMsg){
					alert(data.successMsg);
	            }
	            if(data.errorMsg){
					alert(data.errorMsg);
				}
				$(".chosen-select").chosen();
	                setTimeout(function() {$.fancybox.close(); location.reload();}, 1000);
	        }
        });
    	
    }
</script>
