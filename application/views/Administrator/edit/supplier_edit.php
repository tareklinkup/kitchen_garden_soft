<?php  
	$area = $this->db->query("SELECT * FROM tbl_country order by CountryName asc");
	$resultarea = $area->result();
?>
<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<div class="form-horizontal">
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Product_id"> Supplier  ID </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" name="supplier_id" id="supplier_id" value="<?php echo $selected->Supplier_Code; ?>" class="form-control" readonly />
				<input name="supplier_id" type="hidden" id="supplier_id" value="<?php echo $selected->Supplier_Code;?>"/>
                <input name="id" type="hidden" id="id"  value="<?php echo $selected->Supplier_SlNo; ?>"/>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label" for="brand"> Supplier Name </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="sl_name" name="sl_name" value="<?php echo $selected->Supplier_Name; ?>" placeholder="Supplier name .." class="form-control" />
				 <div id="sl_name_" class="col-sm-12"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label" for="brand"> Contact Person </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="contact_person" name="contact_person" value="<?php echo $selected->contact_person; ?>" placeholder="Contact Person ..." class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="pro_Name">Address</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<textarea id="address" name="address" placeholder="Supplier Address .." class="form-control" ><?php echo $selected->Supplier_Address; ?></textarea>
			</div>
		</div>
		<!---<div class="full clearfix">
                            <span>District</span>
                            <div class="left">
                            <div id="Search_Resultsss">
                                <select name="district" id="district" required>
                                    <option value=""></option>
                                    <?php $sql = mysql_query("SELECT * FROM tbl_district order by District_Name asc ");
                                    while($row = mysql_fetch_array($sql)){ ?>
                                    <option value="<?php echo $row['District_SlNo'] ?>"><?php echo $row['District_Name'] ?></option>
                                    <?php } ?>
                                </select>  
                            </div>     
                            <span id="district_"></span>                                   
                            </div>
                            <div class="rightElement">
                                <a class="btn-add fancybox fancybox.ajax" href="<?php echo base_url();?>Administrator/supplier/supplier_district">
                                    <input type="button" name="add_cat" value="+"  class="button" style="padding: 4px 7px;font-size: 14px;"/>                                
                                </a> 
                            </div>
                        </div>-->
		
		<div class="form-group" style="display:none;">
			<label class="col-sm-4 control-label" for="form-field-1"> Area</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select class="chosen-select form-control" name="country" id="country" data-placeholder="Choose a Area...">
					<option value="<?php echo $selected->Country_SlNo; ?>"> <?php echo $selected->CountryName; ?> </option>
					<?php foreach($resultarea as $resultarea){ ?>
					<option value="<?php echo $resultarea->Country_SlNo; ?>"><?php echo $resultarea->CountryName; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		
		<div class="form-group" style="display:none;">
			<label class="col-sm-4 control-label" for="form-field-1"> Phone </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="phone" name="phone" value="<?php echo $selected->Supplier_Phone; ?>" placeholder="Enter phone Number" class="form-control" />
			</div>
		</div>
	</div>
		
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> Mobile </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="mobile" name="mobile" value="<?php echo $selected->Supplier_Mobile; ?>"  placeholder="Enter mobile" class="form-control" />
				 <div id="mobile_" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> Email </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="email" name="email" value="<?php echo $selected->Supplier_Email; ?>" placeholder="Enter E-mail" class="form-control" />
				 <div id="sell_rate_" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group" style="display:none;">
			<label class="col-sm-4 control-label" for="office_phone"> Office Phone </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="office_phone" name="office_phone" value="<?php echo $selected->Supplier_OfficePhone; ?>"  placeholder="Enter office phone" class="form-control" />
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
			<label class="col-sm-4 control-label" for=""> </label>
			<label class="col-sm-1 control-label"></label>
			<div class="col-sm-6">
				<button type="button" onclick="Update_suppliers()" name="btnSubmit" title="Update" class="btn btn-sm btn-info pull-left">
						Update
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</div>
</div>	
</div>

</div> 