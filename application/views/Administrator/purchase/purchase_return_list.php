
<div class="content_scroll" style="">
<table  class="border" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;border-collapse:collapse;">
	<tr>
		<th>Product</th>
		<th>Total Qty</th>
		<th>Total Amount</th>
		<th>Already Retuned Qty</th>
		<th>Already Retuned Amount</th>
		<th>Retuned Qty</th>
		<th>Retuned Amount</th>
	</tr>
	<?php  
	$sql = $this->db->query("SELECT tbl_purchasedetails.*, tbl_product.*,tbl_purchasemaster.*,tbl_purchasereturn.*, tbl_purchasereturn.PurchaseMaster_InvoiceNo as invoice FROM tbl_purchasedetails left join tbl_product on tbl_product.Product_SlNo=tbl_purchasedetails.Product_IDNo left join tbl_purchasemaster on tbl_purchasemaster.PurchaseMaster_SlNo=tbl_purchasedetails.PurchaseMaster_IDNo left join tbl_purchasereturn on tbl_purchasereturn.PurchaseMaster_InvoiceNo = tbl_purchasemaster.PurchaseMaster_InvoiceNo WHERE tbl_purchasemaster.PurchaseMaster_InvoiceNo = '$proinv'");
	$rox = $sql->result();
		foreach($rox as $rox){ 
			$PackName = $rox->PackName;
			$treteun ='';
			$tamount ='';
			if($PackName==""){
			$sprid = $rox->Product_SlNo;
			$sprternid = $rox->PurchaseReturn_SlNo;
			
		$sql22 = $this->db->query("SELECT * FROM tbl_purchasereturndetails WHERE PurchaseReturnDetailsProduct_SlNo = '$sprid' AND PurchaseReturn_SlNo='$sprternid'");
		$rox22 = $sql22->result();
		foreach($rox22 as $rox22){
			$treteun = $rox22->PurchaseReturnDetails_ReturnQuantity+$treteun;
			$tamount = $rox22->PurchaseReturnDetails_ReturnAmount+$tamount;
		}?>

	 <tr class='wrapper'>
	 	<input type="hidden" name="packname[]" value="<?php echo $PackName ?>">
	 	<input type="hidden" name="productsName[]" value="<?php echo $rox->Product_Name; ?>">
	 	<input type="hidden" name="productsCodes[]" value="">
	 	<input type="hidden" name="productsID[]" value="<?php echo $rox->Product_SlNo;?>">
	 	<input type="hidden" name="PurchaseFrom[]" value="<?php echo $rox->PurchaseMaster_PurchaseFor;?>">
		<td><?php echo $rox->Product_Name;?></td>
		<td><?php echo $PDQTY=$rox->PurchaseDetails_TotalQuantity;?>
		</td>
		<td><?php echo $rox->PurchaseDetails_Rate*$rox->PurchaseDetails_TotalQuantity;?>
			<input type="hidden" id="PurchaseRate<?php echo $rox->PurchaseDetails_SlNo;?>" value="<?php echo $rox->PurchaseDetails_Rate;?>">
		</td>
		<td><input type="text" id="treteun<?php echo $rox->PurchaseDetails_SlNo;?>" readonly="" value="<?php echo $treteun;?>"></td>
		<td><input type="text" id="totalamount<?php echo $rox->PurchaseDetails_SlNo;?>" readonly="" value="<?php echo $tamount;?>"></td>
		<td><input type="text" name="returnqty[]" id="reqty<?php echo $rox->PurchaseDetails_SlNo;?>" onkeyup="qtycheckReturn(<?php echo $rox->PurchaseDetails_SlNo;?>)" value="0"></td>
		<td><input type="text" name="returnamount[]" id="amount<?php echo $rox->PurchaseDetails_SlNo;?>" value="0" onkeyup="amountcheckReturn(<?php echo $rox->PurchaseDetails_SlNo;?>)"></td>
		<input type="hidden" name="invoice" value="<?php echo $proinv; ?>">
		<input type="hidden" name="productID[]" value="<?php echo $rox->Product_SlNo; ?>">
		<input type="hidden" name="Supplier_No" value="<?php echo $rox->Supplier_SlNo; ?>">
		<input type="hidden" 
		id="qtyy<?php echo $rox->PurchaseDetails_SlNo;?>" value="<?php echo $rox->PurchaseDetails_TotalQuantity; ?>">
		<input type="hidden" id="alredyamount<?php echo $rox->PurchaseDetails_SlNo;?>" value="<?php echo $rox->PurchaseDetails_Rate*$rox->PurchaseDetails_TotalQuantity; ?>">
		
	</tr> 
	 
	<?php } } 
	$sql = $this->db->query("SELECT tbl_purchasedetails.*, tbl_product.*,tbl_purchasemaster.*,tbl_purchasereturn.*, tbl_purchasereturn.PurchaseMaster_InvoiceNo as invoice FROM tbl_purchasedetails left join tbl_product on tbl_product.Product_SlNo=tbl_purchasedetails.Product_IDNo left join tbl_purchasemaster on tbl_purchasemaster.PurchaseMaster_SlNo=tbl_purchasedetails.PurchaseMaster_IDNo left join tbl_purchasereturn on tbl_purchasereturn.PurchaseMaster_InvoiceNo = tbl_purchasemaster.PurchaseMaster_InvoiceNo WHERE tbl_purchasemaster.PurchaseMaster_InvoiceNo = '$proinv' group by tbl_purchasedetails.PackName");
		$rox = $sql->result();
		foreach($rox as $rox){ 
			$PackName = $rox->PackName;
			$treteun ='';
			$tamount ='';
			if($PackName !=""){
			$sprid = $rox->Product_SlNo;
			$sprternid = $rox->PurchaseReturn_SlNo;
			
		$sql22 = $this->db->query("SELECT * FROM tbl_purchasereturndetails WHERE PurchaseReturnDetailsProduct_SlNo = '$sprid' AND PurchaseReturn_SlNo='$sprternid'");
		$rox22 = $sql22->result();
		foreach($rox22 as $rox22){
			$treteun = $rox22->PurchaseReturnDetails_pacQty+$treteun;
			$tamount = $rox22->PurchaseReturnDetails_ReturnAmount+$tamount ;
		}
		$sqlx = $this->db->query("SELECT * FROM tbl_package WHERE package_name ='$PackName'");
		$rom = $sqlx->row();
		$sqn = $this->db->query("SELECT * FROM tbl_product WHERE Product_Code = '".$rom['package_ProCode']."'");
		$ron = $sqn->row();
		 
		?>
	<tr class='wrapper'>

		<input type="hidden" name="packname[]" value="<?php echo $PackName ?>">
		<input type="hidden" name="productsName[]" value="<?php echo $rox->PackName; ?>">
		<input type="hidden" name="productsCodes[]" value="<?php echo $rom->package_ProCode; ?>">
		<td><?php echo $rox->PackName;?></td>
		<td><?php echo $rox->Pack_qty;?></td>
		<td><?php echo $rox->PackPice*$rox->Pack_qty;?></td>
		<td><input type="text" id="treteun<?php echo $rox->PurchaseDetails_SlNo;?>" readonly="" value="<?php echo $treteun;?>"></td>
		<td><input type="text" id="totalamount<?php echo $rox->PurchaseDetails_SlNo;?>" readonly="" value="<?php echo $tamount;?>"></td>
		<td><input type="text" name="returnqty[]" id="reqty<?php echo $rox->PurchaseDetails_SlNo; ?>" onkeyup="qtycheckReturn(<?php echo $rox->PurchaseDetails_SlNo; ?>)" value="0"></td>
		<td><input type="text" name="returnamount[]" id="amount<?php echo $rox->PurchaseDetails_SlNo; ?>" value="0" onkeyup="amountcheckReturn(<?php echo $rox->PurchaseDetails_SlNo; ?>)"></td>
		<input type="hidden" name="invoice" value="<?php echo $proinv; ?>">
		<input type="hidden" name="productID[]" value="<?php echo $ron->Product_SlNo; ?>">
		<input type="hidden" name="Supplier_No" value="<?php echo $rox->Supplier_SlNo; ?>">
		<input type="hidden" id="qtyy<?php echo $rox->PurchaseDetails_SlNo; ?>" value="<?php echo $rox->Pack_qty; ?>">
		<input type="hidden" id="alredyamount<?php echo $rox->PurchaseDetails_SlNo; ?>" value="<?php echo $rox->PackPice*$rox->Pack_qty; ?>">
		
	</tr> 
	<?php } } ?>

	<tr>
		<td colspan="3" align="right"><strong>Notes</strong></td> 
		<td colspan="2"> <textarea name="Notes" id="Notes" style="width:100%;height:40px "></textarea></td> 
		<td colspan="2"> <input type="button" class="btn btn-primary" onclick="SubmitReturn()" value="Save" style="width:200px;"> </td> 
	</tr>
</table>
</div>

<script type='text/javascript'>
function SubmitReturn(){
	var inputdata = $('input[name="productsCodes[]"],input[name="productsName[]"],input[name="packname[]"],input[name="returnamount[]"],input[name="returnqty[]"],input[name="productID[]"],input[name="salseQTY[]"],textarea[name="Notes"],input[name="return_date"],input[name="invoice"],input[name="Supplier_No"]').serialize();
	var urldata = "<?php echo base_url();?>PurchaseReturnInsert";
	$.ajax({
	type: "POST",
	  url: urldata,
	  data: inputdata,
	  success:function(data){
	  	alert("Retuned Success");
	  	//$("#PurchaseReturnList").html(data);
	  	location.reload();
	  }
	});
}
function qtycheckReturn(id){
	var returnqtys = $("#reqty"+id).val();
	var qtyy = $("#qtyy"+id).val();
	var treteun = $("#treteun"+id).val();
	var PurchaseRate = $("#PurchaseRate"+id).val();
	var amount = $("#amount"+id).val(returnqtys*PurchaseRate);
	
	
	var inputdata = $('input[name="productsID[]"],input[name="PurchaseFrom[]"]').serialize();
	var urldata = "<?php echo base_url();?>Administrator/purchase/PurchaseSotckChack";
	$.ajax({
	type: "POST",
	  url: urldata,
	  data: inputdata,
	  success:function(data){
	  	if (data==0) {
	  		alert("Stock Not Available");
	  		$("#amount"+id).val(0);
			$("#reqty"+id).val("0");
			return false;
	  	}else if(parseFloat(data) < parseFloat(returnqtys)){
	  		alert("Stock Not Available");
	  		$("#amount"+id).val(0);
			$("#reqty"+id).val("0");
			return false;
	  	 }
	  	}
	});
	if(treteun==""){
		if(parseFloat(qtyy) < parseFloat(returnqtys)){
			alert('Return Qty too Large');
			$("#amount"+id).val(0);
			$("#reqty"+id).val("0");
			return false;
		}
	}else{
		var total = parseFloat(treteun)+parseFloat(returnqtys);
		if(parseFloat(qtyy) < parseFloat(total)){
			alert('Return Qty too Large');
			$("#amount"+id).val(0);
			$("#reqty"+id).val("0");
			return false;
		}
	}
	if(treteun=="0"){
		if(parseFloat(qtyy) < parseFloat(returnqtys)){
			alert('Return Qty too Large');
			$("#amount"+id).val(0);
			$("#reqty"+id).val("0");
			return false;
		}
	}else{
		var total = parseFloat(treteun)+parseFloat(returnqtys);
		if(parseFloat(qtyy) < parseFloat(total)){
			alert('Return Qty too Large');
			$("#amount"+id).val(0);
			$("#reqty"+id).val("0");
			return false;
		}
	}
}
function amountcheckReturn(id){
	var returnqtys = $("#amount"+id).val();
	var alredyamount = $("#alredyamount"+id).val();
	var totalamount = $("#totalamount"+id).val();
	if(totalamount==""){
		if(parseFloat(alredyamount) < parseFloat(returnqtys)){
			alert('Return Amount too Large');
			$("#amount"+id).val("0");
			return false;
		}
	}else{
		var total = parseFloat(totalamount)+parseFloat(returnqtys);
		if(parseFloat(alredyamount) < parseFloat(total)){
			alert('Return Amount too Large');
			$("#amount"+id).val("0");
			return false;
		}
	}
	if(totalamount=="0"){
		if(parseFloat(alredyamount) < parseFloat(returnqtys)){
			alert('Return Amount too Large');
			$("#amount"+id).val("0");
			return false;
		}
	}else{
		var total = parseFloat(totalamount)+parseFloat(returnqtys);
		if(parseFloat(alredyamount) < parseFloat(total)){
			alert('Return Amount too Large');
			$("#amount"+id).val("0");
			return false;
		}
	}
}
    

</script>