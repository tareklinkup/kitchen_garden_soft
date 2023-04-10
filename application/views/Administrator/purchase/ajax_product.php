<?php  
if($Product){
$procode = $Product->Product_Code;
?>

<input type="hidden" id="packagecode" value="<?php echo $procode; ?>">

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="productName"> Product Name </label>
	<div class="col-sm-8">
		<input type="text" id="productName2" name="productName2" value="<?php echo $Product->Product_Name; ?>" class="form-control" readonly />
		<input type="hidden" id="productName" value="<?php echo $Product->Product_Name; ?>" class="inputclass">
		<input type="hidden" id="proCode" value="<?php echo $Product->Product_Code; ?>" name="proCode"/>
		<input type="hidden" id="ProductUnit" value="<?php echo $Product->Unit_Name;?>" class="inputclass">
	</div>
</div>

<div class="form-group" style="display: none;">
	<label class="col-sm-4 control-label no-padding-right" for="productName"> Brand Name </label>
	<div class="col-sm-8">
		<input type="text" id="group" name="group" value="<?php echo $Product->brand_name; ?>" class="form-control" readonly />
	</div>
</div>


<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="bodyRate"> Pur. Rate </label>
	<div class="col-sm-3">
		<input type="text" id="PurchaseRate" name="PurchaseRate" value="<?php echo $Product->Product_Purchase_Rate; ?>" value="" class="form-control" placeholder="Pur. Rate" />

	</div>
	
	<label class="col-sm-2 control-label no-padding-right" for="PurchaseQTY"> Quantity </label>
	<div class="col-sm-3">
		<input type="text" id="PurchaseQTY" name="PurchaseQTY" value="" onkeyUp="QuantityUpdate()" class="form-control" placeholder="Quantity" />
	</div>
</div>

<div class="form-group" style="display: none;">
	<label class="col-sm-4 control-label no-padding-right" for="cost"> Cost </label>
	<div class="col-sm-3">
		<input type="text" id="cost" name="cost" value="" onkeyUp="calculatePurchaseRate()" class="form-control" placeholder="Cost" />
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="totalAmount"> Total Amount </label>
	<div class="col-sm-8">
		<input type="text" id="totalAmount" name="totalAmount" value="0" class="form-control" />
		<!--<input type="hidden" id="ProPurchaseRATe" value="<?php echo $Product->Product_Purchase_Rate; ?>" class="inputclass">-->
	</div>
</div>

<?php }else{
	?>
				<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="productName"> Product Name </label>
						<div class="col-sm-8">
							<input type="text" id="productName" name="productName" placeholder="Product Name" class="form-control" readonly />
						</div>
				</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="productName"> Group Name</label>
						<div class="col-sm-8">
							<input type="text" id="group" name="group" class="form-control" placeholder="Group name" readonly />
						</div>
					</div>
					
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right" for="PurchaseQTY"> Quantity </label>
					<div class="col-sm-3">
						<input type="text" id="PurchaseQTY" name="PurchaseQTY" value="" class="form-control" placeholder="Quantity" readonly />
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="cost"> Cost </label>
					<div class="col-sm-3">
						<input type="text" id="cost" name="cost" value="" class="form-control" placeholder="Cost"readonly />
					</div>
					
					<label class="col-sm-2 control-label no-padding-right" for="PurchaseRate"> P. Rate </label>
					<div class="col-sm-3">
						<input type="text" id="PurchaseRate" name="PurchaseRate" value="" class="form-control" placeholder="Pur. Rate" readonly />
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="totalAmount"> Total Amount </label>
					<div class="col-sm-8">
						<input type="text" id="totalAmount" name="totalAmount" value="0" class="form-control" readonly />
					</div>
				</div>
	<?php
} ?>
