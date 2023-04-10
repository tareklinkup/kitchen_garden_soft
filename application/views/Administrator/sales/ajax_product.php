<?php
	$stockQuery = $this->db->query("select * from tbl_currentinventory where product_id = '$product->Product_SlNo'");
	$stockCount = $stockQuery->num_rows();
	$stock = 0;
	if($stockCount == 0){
		$stock = 0;
	} else {
		$stockRow = $stockQuery->row();
		$stock = ($stockRow->purchase_quantity + $stockRow->transfer_quantity + $stockRow->sales_return_quantity) - ($stockRow->sales_quantity + $stockRow->purchase_return_quantity + $stockRow->damage_quantity);
	}

?>
<input type="hidden" id="STock" value="<?php echo $stock;?>">
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="productName"> P. Name </label>
	<div class="col-sm-9">
		<input type="text" id="proName" value="<?php echo $product->Product_Name; ?>" name="proName" class="form-control" />
	</div>
</div>

<div class="form-group" style="display:none;">
	<label class="col-sm-3 control-label no-padding-right" for="proBrand"> Brand </label>
	<div class="col-sm-9">
		<input type="text" id="proBrand" name="proBrand" value="<?php $product->brand_name; ?>" class="form-control" />
	</div>
</div>

<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="proQTY"> Quantity </label>
	<div class="col-sm-3">
		<input type="number" id="proQTY" name="proQTY" onkeyup="discount_amount()" autofocus placeholder="Qty" class="form-control" />
	</div>
	<label class="col-sm-3 control-label no-padding-right" for="ProRATe"> Sales Rate </label>
	<!-- onkeyup="SaleInAmount2()" -->
	<div class="col-sm-3">
		<input type="text" id="salePrice" name="salePrice" onkeyup="discount_amount()"  value="<?php echo $product->Product_SellingPrice;?>"  placeholder="Rate" class="form-control" />
	</div>
</div>

<div class="form-group" style="display:none;">
	<label class="col-sm-3 control-label no-padding-right" for="pro_discount"> Discount</label>
	<div class="col-sm-9">
		<span>(%)</span>
		<input type="text" id="pro_discount" name="pro_discount" onkeyup="discount_amount()"  placeholder="Discount" class="form-control"  style="display: inline-block; width: 90%" />
		<input type="hidden" id="discount_amount" />
	</div>
</div>
<div class="form-group">
	<label class="col-sm-3 control-label no-padding-right" for="ProductAmont"> Amount </label>
	<div class="col-sm-9">
		<input type="text" id="ProductAmont" name="ProductAmont" class="form-control" readonly />
	</div>
</div>