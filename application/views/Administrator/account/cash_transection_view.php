<div class="form-horizontal" style="height:300px;">
	<div class="col-sm-12 text-center" style="border-bottom:1px #ccc solid;margin-bottom:10px;">
		<h3> Transaction Information </h3>
	</div>
	
	<div class="col-sm-6">
	
		<div class="form-group">
			<label class="col-sm-5 control-label" for="Transaction_id"> Transaction  ID </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->Tr_Id; ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-5 control-label" for="Transaction_id"> Transaction  Type </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->Tr_Type; ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-5 control-label" for="Transaction_id"> Account ID </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->Acc_Code; ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-5 control-label" for="Transaction_id"> Account Name </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->Acc_Name; ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-5 control-label" for="Transaction_id"> Date </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->Tr_date; ?>
			</div>
		</div>
	</div>
		
	<div class="col-sm-6">
	
		<div class="form-group">
			<label class="col-sm-5 control-label" for="ChequeNumber"> Bank Name </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->Bank_name; ?>
			</div>
		</div>
		
		<div class="form-group" style="display:none;">
			<label class="col-sm-5 control-label" for="ChequeNumber"> Cheque Number </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->ChequeNumber; ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-5 control-label" for="ChequeNumber"> In Amount </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->In_Amount; ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-5 control-label" for="ChequeNumber"> Out Amount </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->Out_Amount; ?>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-5 control-label" for="ChequeNumber"> Description </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<?php echo $selected->Tr_Description; ?>
			</div>
		</div>
		
	</div>
</div>