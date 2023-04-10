<?php
if($customer){
$type=$customer->Customer_Type;
if ($type!='G') {   
?>
<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="supName"> Name </label>
	<div class="col-sm-8">
		<input type="text" id="CusName" name="CusName" value="<?php echo $customer->Customer_Name; ?>" class="form-control" readonly />
		<input type="hidden" id="prevDue" name="prevDue" value="<?php echo $due; ?>" />
		<!--<input type="hidden" id="CusName" class="inputclass"  value="<?php //echo $customer->Customer_Name; ?>">-->
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="Mobile"> Mobile No </label>
	<div class="col-sm-8">
		<input type="text" id="CusMobile" name="CusMobile" value="<?php echo $customer->Customer_Mobile; ?>" class="form-control" readonly />
		<!--<input type="hidden" id="CusMobile" class="inputclass" value="<?php //echo $customer->Customer_Mobile; ?>">-->
	</div>
</div>

<div class="form-group" style="display: none;">
	<label class="col-sm-4 control-label no-padding-right" for="Mobile"> E-mail </label>
	<div class="col-sm-8">
		<input type="text" id="email" name="email" value="<?php echo $customer->Customer_Email; ?>" placeholder="E-mail" class="form-control" readonly />
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="supaddress"> Address </label>
	<div class="col-sm-8">
		<textarea id="CusAddress" name="CusAddress" class="form-control" readonly ><?php echo $customer->Customer_Address; ?></textarea>
		<!--<input type="hidden" id="CusAddress" value="<?php //echo $customer->Customer_Address; ?>">-->
	</div>
</div>


<input type="hidden" name="craditlimits" id="craditlimits" value="<?php echo $customer->Customer_Credit_Limit; ?>">

<?php
}else{
?>
<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="supName"> Name </label>
	<div class="col-sm-8">
		<input type="text" id="CusName" name="CusName" value="General Customer" class="form-control" />
		<input type="hidden" id="CType" class="inputclass" value="<?php echo $customer->Customer_Type; ?>">
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="Mobile"> Mobile No </label>
	<div class="col-sm-8">
		<input type="text" id="CusMobile" name="CusMobile" placeholder="Mobile No" class="form-control" />
	</div>
</div>

<div class="form-group" style="display: none;">
	<label class="col-sm-4 control-label no-padding-right" for="Mobile"> E-mail </label>
	<div class="col-sm-8">
		<input type="text" id="email" name="email" placeholder="E-mail" class="form-control" />
	</div>
</div>

<div class="form-group">
	<label class="col-sm-4 control-label no-padding-right" for="supaddress"> Address </label>
	<div class="col-sm-8">
		<textarea id="CusAddress" name="CusAddress" placeholder="Address" class="form-control" ></textarea>
	</div>
</div>

<?php
}

}else{
	?>
						<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="supName"> Name </label>
						<div class="col-sm-8">
							<input type="text" id="CusName" name="CusName" placeholder="Customer Name" class="form-control" readonly />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="Mobile"> Mobile No </label>
						<div class="col-sm-8">
							<input type="text" id="CusMobile" name="CusMobile" placeholder="Mobile No" class="form-control" readonly />
						</div>
					</div>
					
					<div class="form-group" style="display: none;">
						<label class="col-sm-4 control-label no-padding-right" for="Mobile"> E-mail </label>
						<div class="col-sm-8">
							<input type="text" id="email" name="email" placeholder="E-mail" class="form-control" readonly />
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="supaddress"> Address </label>
						<div class="col-sm-8">
							<textarea id="CusAddress" name="CusAddress" placeholder="Address" class="form-control" readonly ></textarea>
						</div>
					</div>
	<?php
}
?>