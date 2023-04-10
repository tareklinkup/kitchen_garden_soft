	<div class="form-horizontal">
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Depertment Name  </label>
			<label class="col-sm-1 control-label no-padding-right">:</label>
			<div class="col-sm-8">
				<input type="text" id="Depertment" name="Depertment" placeholder="Depertment Name" value="<?php echo $selected->Department_Name; ?>" class="col-xs-10 col-sm-4" />
                <input name="id" type="hidden" id="id" value="<?php echo $selected->Department_SlNo; ?>" />
				<span id="msg"></span>
				<?php echo form_error('Depertment'); ?>
				<span style="color:red;font-size:15px;">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
			<label class="col-sm-1 control-label no-padding-right"></label>
			<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-success" onclick="submited()" name="btnSubmit">
						Submit
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
			</div>
		</div>
		
</div>