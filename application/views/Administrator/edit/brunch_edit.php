
<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="Brunchname"> Branch Name </label>
		<label class="col-sm-1 control-label no-padding-right">:</label>
		<div class="col-sm-3">
			<input type="text" id="Brunchname" name="Brunchname" value="<?php echo $selected->Brunch_name; ?>" class="form-control" />
			<span id="msg"></span>
			<input name="iidd" type="hidden" id="iidd" value="<?php echo $selected->brunch_id; ?>"/>
			<span style="color:red;font-size:15px;">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="brunchtitle"> Branch Title </label>
		<label class="col-sm-1 control-label no-padding-right">:</label>
		<div class="col-sm-3">
			<input type="text" id="brunchtitle" name="brunchtitle" value="<?php echo $selected->Brunch_address; ?>" class="form-control" />
			<span id="msg"></span>
			<span style="color:red;font-size:15px;">
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="brunchaddress"> Branch Address </label>
		<label class="col-sm-1 control-label no-padding-right">:</label>
		<div class="col-sm-3">
			<textarea name="brunchaddress" id="brunchaddress" class="form-control"><?php echo $selected->Brunch_address; ?></textarea>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
		<label class="col-sm-1 control-label no-padding-right"></label>
		<div class="col-sm-8">
				<button type="button" class="btn btn-sm btn-success" onclick="UPdatesubmit()" name="btnSubmit">
					Update
					<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
		</div>
	</div>
</div>