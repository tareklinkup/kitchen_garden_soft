<?php 
$totalpurchase = "";
$Totalpaid = "";
$due="";
foreach($record as $record){ 
	$supid = $record->Supplier_SlNo;
    $paid = "";
    $sql = $this->db->query("SELECT * FROM tbl_supplier_payment WHERE SPayment_customerID = '".$supid."'");
    $row = $sql->result();
	foreach($row as $row){
        $paid = $paid+$row->SPayment_amount;    
    } 
    $purch = "";
    $sqls = $this->db->query("SELECT * FROM tbl_purchasemaster WHERE Supplier_SlNo = '".$supid."'");
    $rows = $sqls->result();
	foreach($rows as $rows){
        $purch = $purch+$rows->PurchaseMaster_SubTotalAmount;    
    }

    $totalpurchase = $totalpurchase +$purch; 
    $Totalpaid = $Totalpaid +$paid;
 
  $CName=$record->Supplier_Name;
  $Cid = $record->Supplier_Code;
  $sid = $record->Supplier_SlNo;
  $inv = $record->PurchaseMaster_InvoiceNo;

} $due = $totalpurchase-$Totalpaid; ?>


<div class="col-sm-12" style="width:500px;">
	<div class="col-sm-12 text-center" style="border-bottom:2px #ccc solid;margin-bottom:10px;"> 
	<h4> Supplier Due Payment </h4>
	<span id="success"> </span>
	</div>
	
	<div class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-4 control-label no-padding-right" for="paymentDate"> Payment Date </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input class="form-control date-picker" id="paymentDate" name="paymentDate" type="text" value="<?php echo date('Y-m-d'); ?>" name="pdate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;padding: 4px 6px 4px !important;width: 210px;float:left;" />
				<span class="input-group-addon" style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px !important;float:left;">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="invoice"> Invoice No </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="invoice" name="invoice" value="<?php if(isset($inv))echo $inv; ?>" class="form-control" />
				<span style="color:red;font-size:15px;">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="SuppID__"> Supplier Code </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="SuppID__" name="SuppID__" value="<?php if(isset($Cid))echo $Cid; ?>" class="form-control" />
				<input type="hidden" id="SuppID" value="<?php if(isset($sid))echo $sid; ?>" >
			</div>
		</div>   
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> Supplier Name </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="catname" name="catname" value="<?php if(isset($CName))echo $CName; ?>" class="form-control" readonly />
				<span id="msg"></span>
				<span style="color:red;font-size:15px;">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="totaldue"> Total Due </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="totaldue" name="totaldue" value="<?php if(isset($due)) echo $due;?>" class="form-control" readonly />
				<span id="msg"></span>
				<span style="color:red;font-size:15px;">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="paidAmount"> Paid Amount </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="paidAmount" onkeyup="remainddue()" selected class="form-control" />
				<input type="hidden" id="Paymentby" value="By Cash">
				<span style="color:red;font-size:15px;">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> Remainded Due </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="remainddue" placeholder="Remainded Due" readonly class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="">Note </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<textarea id="Note" class="form-control"></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
			<label class="col-sm-1 control-label no-padding-right"></label>
			<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-success" onclick="Submitdata()" name="btnSubmit">
						Payment
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
			</div>
		</div>
		
</div>
</div>

<script type="text/javascript">
	function Submitdata(){
		var paymentDate = $('#paymentDate').val();
		var invoice = $('#invoice').val();
		var SuppID = $('#SuppID').val();
		
		var regex = /^[0-9]+$/;
		var paidAmount = $('#paidAmount').val();
		if(paidAmount=="0"){
			$("#paidAmount").css('border-color','red');
            return false;
		}else{
			if(!regex.test(paidAmount)){
	            $("#paidAmount").css('border-color','red');
	            return false;
	        }else{
	            $("#paidAmount").css('border-color','gray');
	        }
		}
        var Paymentby = $('#Paymentby').val();
        if(Paymentby==""){
            $("#Paymentby").css('border-color','red');
            return false;
        }else{
            $("#Paymentby").css('border-color','gray');
        }
        var Note = $("#Note").val();
        if(Note==""){
            $("#Note").css('border-color','red');
            return false;
        }else{
            $("#Note").css('border-color','gray');
        }
		var succes = "";
		if(succes == ""){
			var inputdata = 'Paymentby='+Paymentby+'&paymentDate='+paymentDate+'&invoice='+invoice+'&SuppID='+SuppID+'&paidAmount='+paidAmount+'&Note='+Note;
			//alert(inputdata);
			var urldata = "<?php echo base_url();?>Administrator/supplier/supplier_PaymentAmount/";
			$.ajax({
				type: "POST",
				url: urldata,
				data: inputdata,
				success:function(data){
					$('#success').html('Payment Success').css("color","green");
					$('#Supplier_Results_Duepayment').html(data);
					setTimeout(function() {$.fancybox.close()}, 2000);
				}
			});
		}
	}
	function remainddue(){
		var totaldue = $("#totaldue").val();
		var paidAmount = $("#paidAmount").val();
		var Remainded = parseFloat(totaldue) - parseFloat(paidAmount);
		$("#remainddue").val(Remainded);
	}
</script>