 <?php
 if($Supplier){
 //echo "<pre>";print_r($Supplier);exit;
$type=$Supplier->Supplier_Type;
if ($type!='G') {
	?>	
<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="age"> Supplier Name </label>
	<div class="col-sm-8">
		<input type="text" id="supName" name="supName" value="<?php echo $Supplier->Supplier_Name; ?>" class="form-control" readonly />
		<input type="hidden" id="supName" class="inputclass"  value="<?php echo $Supplier->Supplier_Name; ?>">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="age"> Mobile No </label>
	<div class="col-sm-8">
		<input type="text" id="mobile_no" name="mobile_no" value="<?php echo $Supplier->Supplier_Mobile; ?>" class="form-control" readonly />
		<input type="hidden" id="mobile_no" class="inputclass" value="<?php echo $Supplier->Supplier_Mobile; ?>">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="age"> Address </label>
	<div class="col-sm-8">
		<textarea id="supaddress" name="supaddress" class="form-control" readonly ><?php echo $Supplier->Supplier_Address; ?></textarea>
		<input type="hidden" id="supaddress" class="inputclass" value="<?php echo $Supplier->Supplier_Address; ?>">
	</div>
</div>


<input type="hidden" id="prevDue" value="<?= $this->mt->getSupplierDueById($Supplier->Supplier_SlNo); ?>">




	<?php
}else{ 
?>
<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="age"> Supplier Name </label>
	<div class="col-sm-8">
		<input type="text" id="supName" name="supName" placeholder="Supplier Name" value="General Supplier" class="form-control" />
		<input type="hidden" id="SType" class="inputclass" value="<?php echo $Supplier->Supplier_Type; ?>">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="age"> Mobile No </label>
	<div class="col-sm-8">
		<input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile No" class="form-control" />
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="age"> Address </label>
	<div class="col-sm-8">
		<textarea id="supaddress" name="supaddress" placeholder="Address" class="form-control"></textarea>
	</div>
</div>
<?php 
}

 }else{
	 ?>
	 <div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="supName"> Supplier Name </label>
						<div class="col-sm-8">
							<input type="text" id="supName" name="supName" placeholder="Supplier Name" class="form-control" readonly />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="Mobile"> Mobile No </label>
						<div class="col-sm-8">
							<input type="text" id="mobile_no" name="mobile_no" placeholder="Mobile No" class="form-control" readonly />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="supaddress"> Address </label>
						<div class="col-sm-8">
							<textarea id="supaddress" name="supaddress" placeholder="Address" class="form-control" readonly ></textarea>
						</div>
					</div>
	 <?php
 }
 ?>