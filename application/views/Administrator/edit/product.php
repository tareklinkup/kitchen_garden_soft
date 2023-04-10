<?php
	$BRANCHid=$this->session->userdata('BRANCHid');
	
	$serial ="P0000"; 
	$query = $this->db->query("SELECT * FROM tbl_product order by Product_SlNo desc limit 1");
	$result = $query->row();
    if($result->Product_Code != null){$serial = $result->Product_Code;}
	$serial = explode("P",$serial);
	if($serial[1]>=9){ $serial=$serial['1']; $autoserial= $serial+1; $generateCode = "P".$autoserial; 
	}else{
	$serial=$serial[1]; $autoserial= $serial+1; $generateCode = "P0".$autoserial; 
	}
	
	$brand = $this->db->query("SELECT * FROM tbl_brand where brand_branchid = '$BRANCHid' order by brand_SiNo asc");
	$brandResult = $brand->result();
		
	$categry = $this->db->query("SELECT * FROM tbl_productcategory where category_branchid = '$BRANCHid' order by ProductCategory_Name asc");
	$categryResult = $categry->result();

	$color = $this->db->query("SELECT * FROM `tbl_color`");
	$colorResult = $color->result();
		
	$unit = $this->db->query("SELECT * FROM tbl_unit order by Unit_Name asc");
	$unitResult = $unit->result();
		//echo "<pre>";print_r($selected);exit;
?>
<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<div class="form-horizontal">
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Product_id"> Product ID </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" name="Product_id" id="Product_id" value="<?php echo $selected->Product_Code; ?>" class="form-control" readonly />
				<input name="Product_id" type="hidden" id="Product_id" class="required" value="<?php echo $selected->Product_Code; ?>" />
                <input name="iidd" type="hidden" id="iidd" value="<?php echo $selected->Product_SlNo; ?>" />
			</div>
		</div>


		<div class="form-group" style="display:none;">
			<label class="col-sm-4 control-label" for="brand"> Brand </label>
			<label class="col-sm-1 control-label">:</label> 
			<div class="col-sm-6">
				<select class="chosen-select form-control" name="brand" id="brand" data-placeholder="Choose a Brand...">
					<option value="<?php echo $selected->brand; ?>"> <?php echo $selected->brand_name; ?> </option>
					<?php foreach($brandResult as $brandResult){ ?>
					<option value="<?php echo $brandResult->brand_SiNo; ?>"><?php echo $brandResult->brand_name; ?></option>
					<?php } ?>
				</select>
				 <div id="brand_" class="col-sm-12"></div>
			</div>
			<div class="col-sm-1" style="padding: 0;">
				<a href="<?= base_url('brand')?>" title="Add New Category" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" ><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
			</div>
		</div>
		
		<div class="form-group" style="display:;">  
			<label class="col-sm-4 control-label" for="pCategory"> Category </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select class="chosen-select form-control" name="pCategory" id="pCategory" data-placeholder="Choose a Category...">
					<option value="<?php echo $selected->ProductCategory_ID; ?>"> <?php echo $selected->ProductCategory_Name; ?> </option>
					
					<?php foreach($categryResult as $categryResult){ ?>
					<option value="<?php echo $categryResult->ProductCategory_SlNo; ?>"><?php echo $categryResult->ProductCategory_Name; ?></option>
					<?php } ?>
				</select>
				   <div id="pCategory_" class="col-sm-12"></div>
			</div>
			<div class="col-sm-1" style="padding: 0;">
				<a href="<?= base_url('category')?>" title="Add New Category" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" ><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="pro_Name">Product Name</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="pro_Name" name="pro_Name" value="<?php echo htmlentities($selected->Product_Name); ?>" placeholder="Product name .." class="form-control" />
				 <div id="pro_Name_" class="col-sm-12"></div>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label" for="vat">VAT (%)</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="vat" name="vat" value="<?php echo $selected->vat; ?>" placeholder="VAT" class="form-control" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label">Is Service</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="checkbox" id="isService" onchange="onChangeService()" <?php echo $selected->is_service == 'true' ? 'checked' : '';?> />
			</div>
		</div>


		
		<div class="form-group" style="display:none;">
			<label class="col-sm-4 control-label" for="form-field-1"> Color</label> 
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select class="chosen-select form-control" name="color" id="color" data-placeholder="Choose a Color...">
					<option value="<?php echo $selected->color_SiNo; ?>"> <?php echo $selected->color_name; ?> </option>
					<?php foreach($colorResult as $colorResult){ ?>
					<option value="<?php echo $colorResult->color_SiNo; ?>"><?php echo $colorResult->color_name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

	</div>
	<div class="col-sm-6">
		<div class="form-group" id="reOrderDiv" style="display:<?php echo $selected->is_service == 'true' ? 'none' : '';?>;">
			<label class="col-sm-4 control-label" for="form-field-1"> Re-Order Level </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="Re_Order" name="Re_Order" value="<?php echo $selected->Product_ReOrederLevel; ?>" placeholder="Re-order Level" class="form-control" />
				 <div id="Re_Order_" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group" style="display:;">
			<label class="col-sm-4 control-label" for=""> Purchase Rate </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="Purchase_rate" name="Purchase_rate" value="<?php echo $selected->Product_Purchase_Rate; ?>"  placeholder="Purchase Rate" class="form-control" />
				 <div id="Purchase_rate_" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group" style="display:;">
			<label class="col-sm-4 control-label" for=""> Sell Rate </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="sell_rate" name="sell_rate" value="<?php echo $selected->Product_SellingPrice; ?>" class="form-control" />
				 <div id="sell_rate_" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group" style="display: none;">
			<label class="col-sm-4 control-label" for="minimum_sell_rate"> Minimum Sell Rate </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="minimum_sell_rate" name="minimum_sell_rate" value="<?php echo $selected->Product_MinimumSellingPrice; ?>"  placeholder="Permenent Hospital Name" class="form-control" />
			</div>
		</div>
	
		 <div class="full clearfix">
		 <label class="col-sm-4 control-label" for="wholesell_rate"> Wholesell Rate </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="Wholesales" name="Wholesales" value="<?php echo $selected->Product_WholesaleRate; ?>"  placeholder="Whole sale rate" class="form-control" />
			</div>
		 </div> 
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="product_unit"> Unit </label> 
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select class="chosen-select form-control" name="product_unit" id="product_unit" data-placeholder="Choose a Unit...">
					<option value="<?php echo $selected->Unit_SlNo; ?>"> <?php echo $selected->Unit_Name; ?> </option>
					<?php foreach($unitResult as $unitResult){ ?>
					<option value="<?php echo $unitResult->Unit_SlNo; ?>"><?php echo $unitResult->Unit_Name; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-sm-1" style="padding: 0;">
				<a href="<?= base_url('unit')?>" title="Add New Unit" class="btn btn-xs btn-danger" style="height: 25px; border: 0; width: 27px; margin-left: -10px;" target="_blank" ><i class="fa fa-plus" aria-hidden="true" style="margin-top: 5px;"></i></a>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> </label>
			<label class="col-sm-1 control-label"></label>
			<div class="col-sm-6">
				<button type="button" onclick="update_pro()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
						Update
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</div>
</div>	
</div>

</div>
