<?php 
$query0 =$this->db->query("SELECT * FROM tbl_purchasemaster ORDER BY PurchaseMaster_SlNo DESC LIMIT 1");
$row = $query0->row();

@$invoice = $row->PurchaseMaster_InvoiceNo;
$previousinvoice = substr($invoice, 3, 11);
if (!empty($invoice)) {
   if ($previousinvoice<10) {
         $purchInvoice = 'CP-00'.($previousinvoice+1);
    }
    elseif ($previousinvoice<100) {
        $purchInvoice = 'CP-0'.($previousinvoice+1);
    }
    else{
         $purchInvoice = 'CP-'.($previousinvoice+1);
    }
}
else{
     $purchInvoice = 'CP-001';
}

?>
<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
<div class="row">
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right" for="age"> Invoice no </label>
			<div class="col-sm-2">
				<input type="text" id="purchInvoice" name="purchInvoice" value="<?php echo $purchInvoice; ?>" class="form-control" readonly />
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-2 control-label no-padding-right" for="PurchaseFor"> Purchase For  </label>
			<div class="col-sm-3">
			<?php 
			/* $query = $this->db->query("select * from tbl_patient where patient_type='N'");
			$row = $query->row();*/
			
			/* $querys = $this->db->query("select * from tbl_patient where patient_type!='N'");
			$rows = $querys->result();  */
			//echo "<pre>";print_r($this->session);exit;
			?> 
			
			<select class="chosen-select form-control" name="PurchaseFor" id="PurchaseFor">
				<option value="<?php echo $this->session->userdata('BRANCHid'); ?>"><?php echo $this->session->userdata('Brunch_name'); ?></option>
				<?php //foreach($rows as $patient){ ?>
				<!--<option value="<?php //echo $patient->patient_id; ?>"><?php //echo $patient->patient_name; ?> - <?php //echo $patient->phone; ?></option>-->
				<?php //} ?>
			</select>
			
			
		</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right" for="Purchase_date"> Date </label>
			<div class="col-sm-3">
				<input class="form-control date-picker" id="Purchase_date" name="Purchase_date" type="text" class="form-control" value="<?php echo date('Y-m-d'); ?>" name="pdate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;padding: 4px 6px 4px !important;width: 230px;float:left;" />
				<span class="input-group-addon" style="border-radius: 0px 5px 5px 0px !important;padding: 4px 6px 4px !important;">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
</div>
</div>


<div class="col-xs-9 col-md-9 col-lg-9">
<div class="widget-box">
	<div class="widget-header">
		<h4 class="widget-title">Supplier & Product Information</h4>
		<div class="widget-toolbar">
			<a href="#" data-action="collapse">
				<i class="ace-icon fa fa-chevron-up"></i>
			</a>

			<a href="#" data-action="close">
				<i class="ace-icon fa fa-times"></i>
			</a>
		</div>
	</div>

	<div class="widget-body">
		<div class="widget-main">

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="SupplierID"> Supplier ID  </label>
						<div class="col-sm-8">
						<?php 
						$query1 = $this->db->query("SELECT * FROM tbl_supplier where Supplier_Type = 'G'");
						$row1 = $query1->row();
						
						$query2 = $this->db->query("SELECT * FROM tbl_supplier where Supplier_brinchid='".$this->brunch."' AND status='a' order by Supplier_Name asc");
						$row2 = $query2->result(); 
						//echo "<pre>";print_r($rows);exit;
						?> 
						<select class="chosen-select form-control" name="SupplierID" id="SupplierID" data-placeholder="Choose Supplier..." onchange="Supplier()">
							<option value="">  </option>
							<option value="<?php if($query1->num_rows()>0){ echo $row1->Supplier_SlNo; } ?>"> <?php if($query1->num_rows()>0){ echo $row1 ->Supplier_Name; } ?> </option>
							<?php foreach($row2 as $supplier){ ?>
							<option value="<?php echo $supplier->Supplier_SlNo; ?>"><?php echo $supplier->Supplier_Name; ?> - <?php echo $supplier->Supplier_Mobile; ?></option>
							<?php } ?>
						</select>
					</div>
					</div>
					
					<span id="SupplierResult">
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
					</span>
				</div>
				
				<div class="col-sm-6">
				
					<!--<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="patient_id"> Product  </label>
						<div class="col-sm-8">
						<?php 
						$BRANCHid = $this->session->userdata('BRANCHid');
						$querys = $this->db->query("SELECT  * FROM tbl_product where Product_branchid='$BRANCHid' AND status='a' order by Product_Name asc");
						$rows = $querys->result();
						//echo "<pre>";print_r($rows);exit;
						?> 
						<select class="chosen-select form-control" name="ProID" id="ProID" data-placeholder="Choose a Product..." onchange="Products()">
							<option value="">  </option>
							<?php foreach($rows as $product){ ?>
							<option value="<?php echo $product->Product_SlNo; ?>"><?php echo $product->Product_Name; ?> - <?php echo $product->body_number; ?></option>
							<?php } ?>
						</select>
					</div>
					</div>-->
					
					<form method="post" name="form_data" id="form_data" enctype="multipart/form-data">
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right" for="productName"> Choose Excel File</label>
						<div class="col-sm-8">
							<input type="file" id="excel_file" name="excel_file" class="form-control" accept=".xls, .xlsx" style="height:35px;" />
						</div>
					</div>
					
					
					<span id="ProductsResult">
					
					<!---<div class="form-group">
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
					<label class="col-sm-4 control-label no-padding-right" for="ProductRATE"> Body Rate </label>
					<div class="col-sm-3">
						<input type="text" id="ProductRATE" name="ProductRATE" value="" class="form-control" placeholder="Body Rate" readonly />
					</div>
					
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
				</div>-->
				</span>
					
					<div class="form-group">
						<label class="col-sm-4 control-label no-padding-right">  </label>
						<div class="col-sm-8">
							<button class="btn btn-default pull-right" id="cartButton" type="button">Process</button>
						</div>
					</div>
					</form>
				</div>
				
			</div>
		</div>
	</div>
</div>


<div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
	<div class="table-responsive">
	<table class="table table-bordered" cellspacing="0" cellpadding="0" style="color:#000;margin-bottom: 5px;">
        <thead>
            <tr class="">
                <th style="width:7%;color:#000;">SL. NO</th>
                <th style="width:12%;color:#000;">Group</th>
                <th style="width:13%;color:#000;">Body Number</th>
                <th style="width:20%;color:#000;">Product Name</th>
                <th style="width:10%;color:#000;">Body Rate</th>
				<th style="width:8%;color:#000;">Pur. Rate</th>
				<th style="width:7%;color:#000;">Qty</th>
                <th style="width:15%;color:#000;">Total Amount</th>
                <th style="width:18%;color:#000;">Action</th>                                                      
            </tr>
        </thead>
   </table> 
					
	<span id="ShowcarTProduct">
	 
	 </span>
	 
	 </div>
</div>


</div>


<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
<div class="widget-box">
	<div class="widget-header">
		<h4 class="widget-title">Amount Details</h4>
		<div class="widget-toolbar">
			<a href="#" data-action="collapse">
				<i class="ace-icon fa fa-chevron-up"></i>
			</a>

			<a href="#" data-action="close">
				<i class="ace-icon fa fa-times"></i>
			</a>
		</div>
	</div>

	<div class="widget-body">
		<div class="widget-main">
			<div class="row">
				<div class="col-sm-12">
					<div class="table-responsive">
						<table class="" cellspacing="0" cellpadding="0" style="color:#000;margin-bottom: 0px;">
							
							<tr>
								<td>
								<div class="form-group">
									<label class="col-sm-12 control-label no-padding-right" for="subTotalDisabled">Sub Total</label>
									<div class="col-sm-12">
										<input type="number" id="subTotalDisabled" name="subTotalDisabled" value="0" class="form-control" readonly />
										<input type="hidden" id="subTotal"  class="inputclass" value="0">
									</div>
								 </div>
								</td>
							</tr>
							
							<tr>
								<td>
								<div class="form-group">
									<label class="col-sm-12 control-label no-padding-right" for="subTotalDisabled"> Vat </label>
									<div class="col-sm-12">
										<input type="number" id="vatPersent" onkeyup="vatonkeyup()" name="vatPersent" value="0" class="" style="width:50px;height:25px;" />
										<span style="width:20px;"> % </span>
										<input type="number" id="purchVat" readonly="" name="purchVat" value="0" class="" style="width:140px;height:25px;" />
									</div>
								 </div>
								</td>
							</tr>
							
							<tr>
								<td>
								<div class="form-group">
									<label class="col-sm-12 control-label no-padding-right" for="subTotalDisabled">Round Off</label>
									<div class="col-sm-12">
										<input type="number" id="purchFreight" onkeyup="Freightonkeyup()" name="purchFreight" value="0" class="form-control" />
									</div>
								 </div>
								</td>
							</tr>
							
							<tr>
								<td>
								<div class="form-group">
									<label class="col-sm-12 control-label no-padding-right" for="subTotalDisabled">Discount</label>
									<div class="col-sm-12">
										<input type="number" id="purchDiscount" onkeyup="Discountonkeyup()" name="purchDiscount" value="0" class="form-control" />
									</div>
								 </div>
								</td>
							</tr>
							
							<tr>
								<td>
								<div class="form-group">
									<label class="col-sm-12 control-label no-padding-right" for="subTotalDisabled">Total</label>
									<div class="col-sm-12">
										<input type="number" id="purchTotaldisabled" value="0" class="form-control" readonly />
										<input type="hidden" id="purchTotal" value="" class="inputclass">
									</div>
								 </div>
								</td>
							</tr>
							
							<tr>
								<td>
								<div class="form-group">
									<label class="col-sm-12 control-label no-padding-right" for="subTotalDisabled">Paid</label>
									<div class="col-sm-12">
										<input type="number" id="PurchPaid" value="0" onkeyup="PaidAmount()" class="form-control" />
									</div>
								 </div>
								</td>
							</tr>
							
							<tr>
								<td>
								<div class="form-group">
									<label class="col-sm-12 control-label no-padding-right" for="subTotalDisabled">Due</label>
									<div class="col-sm-12">
										<input type="number" id="purchaseDue2" name="purchaseDue2" value="0" class="form-control" readonly />
										<input type="hidden" id="purchaseDue"  class="inputclass" value="0">
									</div>
								 </div>
								</td>
							</tr>
							
							<tr>
								<td>
								<div class="form-group">
									<div class="col-sm-4">
										<input type="button" class="btn btn-success" onclick="ProductPurchase()" value="Purchase" style="background:#000;color:#fff;">
									</div>
									<div class="col-sm-4">
										<input type="button" class="btn btn-info" onclick="window.location = '<?php echo base_url();?>purchase'" value="New Purchase" style="background:#000;color:#fff;">
									</div>
								 </div>
								</td>
							</tr>
							
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>


<script type="text/javascript">
    function Supplier()   {
        var sid = $("#SupplierID").val();
        var inputdata = 'sid='+sid;
        var urldata = "<?php echo base_url();?>SelectSupplier";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#SupplierResult").html(data);
            }
        });
    }
    function Catagory(){
        var ProCat = $("#ProCat").val();
        var inputdata = 'ProCat='+ProCat;
        var urldata = "<?php echo base_url();?>SelectCat";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ProductResult").html(data);
                
            }
        });
    }
    function Products()   {
        var ProID = $("#ProID").val();
        var inputdata = 'ProID='+ProID;
        var urldata = "<?php echo base_url();?>SelectPruduct";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ProductsResult").html(data);
               // $('input[name=PurchaseQTY]').focus();
            }
        });
    }
		 
    function calculatePurchaseRate(){
        var PurchaseQTY = $("#PurchaseQTY").val();
        var cost = $("#cost").val();
        var bodyRate = $("#bodyRate").val();
		var perPrRate = parseFloat(cost) + parseFloat(bodyRate);
        var Amount = parseFloat(perPrRate) * parseFloat(PurchaseQTY);
        $("#PurchaseRate").val(perPrRate);
        $("#totalAmount").val(Amount);
    }
		 
    function QuantityUpdate(){
        var PurchaseQTY = $("#PurchaseQTY").val();
        var PurchaseRate = $("#PurchaseRate").val();
        var cost = $("#cost").val();
		if(cost != null){
			 var Amount = parseFloat(PurchaseRate) * parseFloat(PurchaseQTY);
		}else{
			alert('Plz enter cost');
			return false;
		}
        var bodyRate = $("#bodyRate").val();
        $("#totalAmount").val(Amount);
    }
	
    //function AddToPurchaseCart()   {
		
	$(document).on('click','#cartButton',function(){
		debugger
		var formData = new FormData();
		formData.append("excel_file", document.getElementById("excel_file").files[0]);
		
          var excel_file = $("#excel_file").val();
        if(excel_file == ""){
            alert("Sorry ......! you must select excel file");
            return false;
        }  
        $.ajax({
            url : "<?php echo base_url();?>purchaseExcelTOcart",
			type: "POST",
			enctype: "multipart/form-data",
			// dataType: 'json',
			data: formData,
			cache: false,
			processData: false,
			contentType: false,
			success:function(data){
				//alert(data);
				$("#excel_file").val('');
                $("#ShowcarTProduct").html(data);
				var TotalAmount = $("#grand_total").val();
				//var TotalAmount = parseFloat(TotalPrice)+parseFloat(subToTal);
				$("#subTotalDisabled").val(TotalAmount);
				$("#purchTotaldisabled").val(TotalAmount);
				$("#PurchPaid").val(TotalAmount);
				$("#subTotal").val(TotalAmount);
				$("#purchTotal").val(TotalAmount);
            },
        });

    });
	
	
    function cartRemove(aid)   {
        var rowid = $("#rowid"+aid).val();
        var RemoveID = $("#PriCe_"+aid).val();

        var inputdata = 'rowid='+rowid;
        var urldata = "<?php echo base_url();?>ajaxCartRemove";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ShowcarTProduct").html(data);
				
				var TotalAmount = $("#grand_total").val();
				$("#subTotalDisabled").val(TotalAmount);
				$("#purchTotaldisabled").val(TotalAmount);
				$("#PurchPaid").val(TotalAmount);
				$("#subTotal").val(TotalAmount);
            }
        });

    }
	
    function vatonkeyup(){
        var subtotal = $("#subTotal").val();
        var vatPersent = $("#vatPersent").val();
        var vattotal = parseFloat(subtotal) * parseFloat(vatPersent);
        var grtotal = parseFloat(vattotal) / 100;
        $('#purchVat').val(grtotal);
        //
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subtotal)+ parseFloat(purchVat)+ parseFloat(purchFreight)-parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
    }
    function Freightonkeyup(){
        var subtotal = $("#subTotal").val();
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subtotal)+ parseFloat(purchVat)+ parseFloat(purchFreight)-parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);

    }
    function Discountonkeyup(){
        var subtotal = $("#subTotal").val();
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subtotal)+ parseFloat(purchVat)+ parseFloat(purchFreight)-parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
    }
    function PaidAmount(){
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
       
    }
	 
</script>

<script type="text/javascript">
    function ProductPurchase(){

        var packagename = $("#packagename").val();
        var purchInvoice = $("#purchInvoice").val();
        var PurchaseFor = $("#PurchaseFor").val();
        if(PurchaseFor == ''){
            alert("Select Purchase For");
            return false;
        }
        var Purchase_date = $("#Purchase_date").val();

        var SupplierID = $("#SupplierID").val();
        if(SupplierID==""){
            //$("#SupplierID").css('border-color','red');
            alert("Select Supplier");
            return false;
        }
        //
        var subTotal = $("#subTotal").val();
        if(subTotal==0){
            return false;
        }
        var vatPersent = $("#vatPersent").val();
        if(vatPersent==""){
            $("#vatPersent").css('border-color','red');
            return false;
        }else{
            $("#vatPersent").css('border-color','gray');
        }
        var purchFreight = $("#purchFreight").val();
        if(purchFreight==""){
            $("#purchFreight").css('border-color','red');
            return false;
        }else{
            $("#purchFreight").css('border-color','gray');
        }
        var purchDiscount = $("#purchDiscount").val();
        if(purchDiscount==""){
            $("#purchDiscount").css('border-color','red');
            return false;
        }else{
            $("#purchDiscount").css('border-color','gray');
        }
        var purchTotal = $("#purchTotal").val();
	
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var Notes = $("#PurchNotes").val();
		
		 var SType = $("#SType").val();
		 var supName = $("#supName").val();
		 var supaddress = $("#supaddress").val();
		 var mobile_no = $("#mobile_no").val();
		
         var inputdata = 'packagename='+packagename+'&purchInvoice='+purchInvoice+'&PurchaseFor='+PurchaseFor+'&Purchase_date='+Purchase_date+'&SupplierID='+SupplierID+'&subTotal='+subTotal+'&vatPersent='+vatPersent+'&purchFreight='+purchFreight+'&purchDiscount='+purchDiscount+'&purchTotal='+purchTotal+'&PurchPaid='+PurchPaid+'&purchaseDue='+purchaseDue+'&SType='+SType+'&supName='+supName+'&supaddress='+supaddress+'&mobile_no='+mobile_no+'&Notes='+Notes;
         var urldata = "<?php echo base_url();?>PurchaseOrder";
		 
         $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                 var err = data;
                if(err){
                    if(confirm('Show Report')){
                        window.location.href='<?php echo base_url();?>purchaseToReport';
                    }else{
                        //$("#AllRefresh").html(data);
                        alert('Purchase Success');
                        location.reload();
                        return false;
                    }
                } 
            }
        });
    }
</script>
