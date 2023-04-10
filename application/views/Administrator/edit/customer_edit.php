<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<div class="form-horizontal">
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Customer_id"> Customer  ID </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" name="Customer_id" id="Customer_id" value="<?php echo $selected->Customer_Code; ?>" class="form-control" readonly />
				<input name="Customer_id" type="hidden" id="Customer_id" value="<?php echo $selected->Customer_Code; ?>" />
                <input name="id" type="hidden" id="id" value="<?php echo $selected->Customer_SlNo; ?>" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label" for="cus_name"> Customer Name </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="cus_name" name="cus_name" value="<?php echo $selected->Customer_Name; ?>" placeholder="Customer name .." class="form-control" />
				 <div id="cus_name_" class="col-sm-12"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label" for="cus_name"> Owner Name </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="owner_name" name="owner_name" value="<?php echo $selected->owner_name; ?>" placeholder="Owner name .." class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="pro_Name">Address</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="address" name="address" placeholder="Customer Address .." class="form-control" value="<?php echo $selected->Customer_Address; ?>" />
				<div id="address_" class="col-sm-12"></div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-4 control-label" for="form-field-1"> Area</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select class="chosen-select form-control" name="area" id="area" data-placeholder="Choose a Area...">
					<option value="<?php echo $selected->area_ID; ?>"> <?php echo $selected->District_Name; ?> </option>
					<?php
					$resultarea = $this->db->where('status','a')->order_by('District_Name','asc')->get('tbl_district')->result();

					foreach($resultarea as $resultarea){ ?>
						<option value="<?php echo $resultarea->District_SlNo; ?>"><?php echo $resultarea->District_Name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		<div class="form-group" style="display: none;">
			<label class="col-sm-4 control-label" for="form-field-1"> Phone </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="phone" name="phone" value="<?php echo $selected->Customer_Phone; ?>" placeholder="Enter phone Number" class="form-control" />
			</div>
		</div>
	</div>
		
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> Mobile </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="mobile" name="mobile" value="<?php echo $selected->Customer_Mobile; ?>"  placeholder="Enter mobile" class="form-control" />
				 <div id="mobile_" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group"  style="display: none;">
			<label class="col-sm-4 control-label" for="email"> E-mail </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="email" name="email" value="<?php echo $selected->Customer_Email; ?>" placeholder="Enter E-mail" class="form-control" />
				
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="office_phone"> Office Phone </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="office_phone" name="office_phone" value="<?php echo $selected->Customer_OfficePhone; ?>"  placeholder="Enter office phone" class="form-control" />
			</div>
		</div> 
			
		<div class="form-group">
			<label class="col-sm-4 control-label" for="previous_due"> Previous Due </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="previous_due" name="previous_due" value="<?php echo $selected->previous_due; ?>"  placeholder="Previous due" class="form-control" />
			</div>
		</div>
			
		<div class="form-group">
			<label class="col-sm-4 control-label" for="credit"> Credit Limit </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="credit" name="credit" value="<?php echo $selected->Customer_Credit_Limit; ?>"  placeholder="Credit Limit" class="form-control" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label" for="customerType"> Customer Type </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="radio" name="customerType" value="retail" <?php echo $selected->Customer_Type == 'retail' ? 'checked' : '';?>> Retail
				<input type="radio" name="customerType" value="wholesale" <?php echo $selected->Customer_Type == 'wholesale' ? 'checked' : '';?>> Wholesale
				<div id="typeMessage"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> </label>
			<label class="col-sm-1 control-label"></label>
			<div class="col-sm-6">
				<button type="button" onclick="update()" name="btnSubmit" title="update" class="btn btn-sm btn-info pull-left">
						Update
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</div>
</div>	
</div>

</div>
