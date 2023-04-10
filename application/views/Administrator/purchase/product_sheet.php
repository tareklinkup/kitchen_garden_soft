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

<div class="col-xs-12 col-md-12 col-lg-12">
<div class="widget-box">
	<div class="widget-header">
		<h4 class="widget-title">Create Product Sheet</h4>
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
				
					<div class="form-group">
						<label class="col-sm-2 control-label no-padding-right" for="patient_id"> Product  </label>
						<div class="col-sm-5">
						<?php 
						$BRANCHid = $this->session->userdata('BRANCHid');
						$querys = $this->db->query("SELECT  * FROM tbl_product where Product_branchid='$BRANCHid' AND status='a' order by Product_Name asc");
						$rows = $querys->result();
						//echo "<pre>";print_r($rows);exit;
						?> 
						<select class="chosen-select form-control" name="body_number" id="body_number" data-placeholder="Choose a Product..." onchange="AddCart()">
							<option value="">  </option>
							<?php foreach($rows as $product){ ?>
							<option value="<?php echo $product->body_number; ?>"><?php echo $product->Product_Name; ?> - <?php echo $product->body_number; ?></option>
							<?php } ?>
						</select>
					</div>
					</div>
					
				<span id="ProductsResult">
					
				</span>
					
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
                <th style="width:7%;color:#000;">Carton No</th>
                <th style="width:7%;color:#000;">Total Wight</th>
				<th style="width:7%;color:#000;">Group</th>
                <th style="width:11%;color:#000;">Body Number</th>
                <th style="width:12%;color:#000;">Product Name</th>
                <th style="width:7%;color:#000;">Gross Wight</th>
                <th style="width:7%;color:#000;">Net Wight</th>
                <th style="width:7%;color:#000;">Quantity</th>
                <th style="width:7%;color:#000;">Body Rate</th>
				<th style="width:7%;color:#000;">Total Wight</th>
                <th style="width:7%;color:#000;">Total Body</th>
                <th style="width:7%;color:#000;">Action</th>                                                      
            </tr>
        </thead>
   </table> 
					
	<span id="ShowcarTProduct">
	 
	 </span>
	 
	 </div>
</div>


</div>

</div>


<script type="text/javascript">

    function AddCart()   {
        var body_number = $("#body_number").val();
        var inputdata = 'body_number='+body_number;
        var urldata = "<?php echo base_url();?>productSheetCart";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ShowcarTProduct").html(data);
                document.getElementById('ProID').value="";
            }
        });
    }

	 function cartRemove(aid)   {
        var rowid = $("#rowid"+aid).val();
        var RemoveID = $("#PriCe_"+aid).val();

        var inputdata = 'rowid='+rowid;
        var urldata = "<?php echo base_url();?>ajaxCartRemoveProductSheet";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ShowcarTProduct").html(data);
            }
        });
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
