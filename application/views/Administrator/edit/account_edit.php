
   	<div class="form-horizontal">
	<div class="col-sm-2"></div>
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="account_id"> Account ID </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" name="account_id" id="account_id"  value="<?php echo $selected->Acc_Code; ?>" class="form-control" readonly />
								<input name="iidd" type="hidden" id="iidd" value="<?php echo $selected->Acc_SlNo; ?>" />
			</div>
		</div>	

		<div class="form-group" style="display: none;">
			<label class="col-sm-4 control-label" for="tr_type">Transaction Type</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select name="tr_type" id="tr_type" class="chosen-select" onchange="AutoSelect()">
					<option><?php echo $selected->Acc_Tr_Type; ?></option>
					<!--<option value="Cash Receive">Cash Receive</option>
					<option value="Cash Payment">Cash Payment</option>-->
					<option value="Deposit To Bank">Deposit To Bank</option>
					<option value="Withdraw Form Bank">Withdraw Form Bank</option>
					<option value="In Cash">In Cash</option>
					<option value="Out Cash">Out Cash</option>
				</select>
			</div>
		</div>	
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="pro_Name">Account Name</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="accountName" name="accountName" value="<?php echo $selected->Acc_Name; ?>" placeholder="Account name .." class="form-control" />
			</div>
		</div>

		<div class="form-group" style="display:none;">
			<label class="col-sm-4 control-label" for="form-field-1"> Account Type </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input name="accounttype" type="text" id="accounttype" value="<?php echo $selected->Acc_Type; ?>" class="form-control" readonly />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Description"> Description </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="Description" name="Description" value="<?php echo $selected->Acc_Description; ?>" class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> </label>
			<label class="col-sm-1 control-label"></label>
			<div class="col-sm-6">
				<button type="button" onclick="Updatesubmit()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
						Update
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</div>
		
</div>