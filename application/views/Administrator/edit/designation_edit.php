
	<div class="form-horizontal">
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Designation Name  </label>
			<label class="col-sm-1 control-label no-padding-right">:</label>
			<div class="col-sm-8">
				<input type="text" id="Designation" name="Designation" placeholder="Designation Name" value="<?php echo $selected->Designation_Name; ?>" class="col-xs-10 col-sm-4" />
				<span id="msg"></span>
				<?php echo form_error('Designation'); ?>
                <input name="id" type="hidden" id="id" value="<?php echo $selected->Designation_SlNo; ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
			<label class="col-sm-1 control-label no-padding-right"></label>
			<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-success" onclick="update()" name="btnSubmit">
						Update
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
			</div>
		</div>
		
</div>