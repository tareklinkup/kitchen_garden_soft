<?php   $serial ="T1000";
	$sql = $this->db->query("SELECT * FROM tbl_customer_payment ORDER BY `CPayment_id` DESC LIMIT 1");
		$row = $sql->row();
		
		if(@$row->CPayment_TransactionID!=null){
			$serial = explode("T",$row->CPayment_TransactionID);
			@$serial=$serial[1]; 
			$autoserial= $serial+1;
			$generateCode = "T".$autoserial;
		}else{
			$generateCode = $serial;
		}

	$AllUser = $this->db->get('tbl_customer')->result();
	
?> 

<div class="row" id="showEditPage">
<div class="col-xs-12">
	<form name="PaymentForm" id="PaymentForm" method="POST">
		<!-- PAGE CONTENT BEGINS -->
		<span id="saveResult">
		<div class="form-horizontal">
		<div class="col-sm-6">
			
			<div class="form-group">
				<label class="col-sm-4 control-label" for="tr_type">Transaction Type</label>
				<label class="col-sm-1 control-label">:</label>
				<div class="col-sm-6">

					<input type="hidden" name="tr_id" value="<?php echo $generateCode; ?>">

					<select name="tr_type" id="tr_type" class="chosen-select" >
						<option value=""></option>
						<option value="Cash Receive">Cash Receive</option>
						<option value="Cash Payment">Cash Payment</option>
					</select>
					<span id="msgTR"></span>
				</div>
			</div>	
			
			
			<div class="form-group">
				<label class="col-sm-4 control-label" for="CustID">Account ID</label>
				<label class="col-sm-1 control-label">:</label>
				<div class="col-sm-6">
					<select class="chosen-select form-control" name="CustID" id="CustID" data-placeholder="Choose customer code..." onchange="FatchUser()">
						<option value="">  </option>

						<?php foreach($AllUser as $userCode){ ?>
						<option value="<?php  echo $userCode->Customer_SlNo; ?>">
							<?php echo $userCode->Customer_Name." - ".$userCode->Customer_Code; ?></option>
						<?php } ?>
					</select>
					<span id="msgID"></span>
				</div>
			</div>	


			<div class="form-group">
				<label class="col-sm-4 control-label" for="catname">Customer Name</label>
				<label class="col-sm-1 control-label">:</label>	
				<div class="col-sm-6">
					<input class="form-control" name="catname" id="catname" type="text" placeholder="Customer Name" />
					<span id="msgName"></span>
				</div>
			</div>
		
		</div>
			
		<div class="col-sm-6">
			<div class="form-group">
			<label class="col-sm-4 control-label" for="paymentDate">Date</label>
			<label class="col-sm-1 control-label">:</label>	
				<div class="col-sm-6">
				<input class="form-control date-picker" name="paymentDate" id="paymentDate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px !important;" value="<?php echo date("Y-m-d") ?>" />
				<span id="msgDate"></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-4 control-label" for="Note"> Description </label>
				<label class="col-sm-1 control-label">:</label>
				<div class="col-sm-6">
					<input type="text" id="Note" name="Note" class="form-control" />
					<span id="msgNote"></span>
				</div>
			</div>


			<div class="form-group">
				<label class="col-sm-4 control-label" for="paidAmount"> Amount </label>
				<label class="col-sm-1 control-label">:</label>
				<div class="col-sm-6">
					<input type="text" id="paidAmount" name="paidAmount" value="0" class="form-control" />
					<input type="hidden" name="Paymentby" id="Paymentby" value="By Cash">
					<span id="msgPaid"></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-4 control-label" for=""> </label>
				<label class="col-sm-1 control-label"></label>
				<div class="col-sm-6">
					<button type="button" onclick="Submitdata()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
							Save
							<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
</span>	
</div>

</div>

<div class="row">
	<div class="col-xs-12">
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		
		<div class="table-header">
			Transaction Information
		</div>
	</div>
	
	<div class="col-xs-12">
	<!-- div.table-responsive -->

	<!-- div.dataTables_borderWrap -->  
	<div class="table-responsive">
		<table id="dynamic-table" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					
					<th>Tr. ID</th>
					<th>Date</th>
					<th>Account ID</th>
					<!--<th>Name</th>-->
					<th>Tr. Type</th>
					<th> Amount</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
			<?php 
			$i=1;			
			foreach($paymentHis as $payData){
			?>
				<tr>
					
					<td>
						<a href="#"><?php echo $payData->CPayment_TransactionID; ?></a>
					</td>
					
					<td><?php echo $payData->CPayment_date; ?></td>
					<td>
						<?php
						foreach ($AllUser as $value) {
							if($value->Customer_SlNo == $payData->CPayment_customerID ):

						 		echo $value->Customer_Code;
							endif;
						} ?>
						
					</td>
					<td><?php echo $payData->CPayment_TransactionType; ?></td>
					
					<td><?php echo $payData->CPayment_amount; ?></td>
					<td class="hidden-480"><?php echo $payData->CPayment_notes; ?></td>
					<td>
						<div class="hidden-sm hidden-xs action-buttons">
						<!-- 	<a class="blue fancybox fancybox.ajax" href="<?php echo base_url(); ?>viewTransaction/<?php echo $payData->CPayment_id; ?>" >
								<i class="ace-icon fa fa-th bigger-130"></i>
							</a> -->
							
							<a class="green" style="cursor:pointer;" onclick="Edit_payment(<?php echo $payData->CPayment_id; ?>)" >
								<i class="ace-icon fa fa-pencil bigger-130"></i>
							</a>
							<a class="red" href="" onclick="deleted(<?php echo $payData->CPayment_id; ?>)">

								<i class="ace-icon fa fa-trash bigger-130"></i>
							</a>
						</div>
					</td>
					
				</tr>
				
			<?php 
				}
			?>
				</tbody>
			</table>
		</div>
	</div><!-- /.col -->
</div><!-- /.row -->





<script type="text/javascript">
	function FatchUser(){
        var userid = $( "#CustID" ).val();

         $('#catname').val("");
        $.ajax({
             url : "<?php echo base_url(); ?>Administrator/Customer/fatch_customer_name/"+userid,
             type: "POST",
             // data: {userid : userid},
             dataType: "JSON",
             success: function(data)
             {
                 $('#catname').val(data.Customer_Name);
             }
         });
     }



     function Submitdata(){
		var tr_type = $('#tr_type').val();
		var paymentDate = $('#paymentDate').val();
		var catname = $('#catname').val();
		var CustID = $('#CustID').val();
		var paidAmount = $('#paidAmount').val();
        var Note = $("#Note").val();
        var Paymentby = $('#Paymentby').val();

		if(tr_type==""){
			$("#msgTR").html('Required this field').css("color","red");
            return false;
        }else{
            $('#msgTR').html('');
        }
		if(CustID==""){
			$("#msgID").html('Required this field').css("color","red");
            return false;
        }else{
            $('#msgID').html('');
        }
        if(Note==""){
            $("#msgNote").html('Required this field').css("color","red");
            return false;
        }else{
            $('#msgNote').html('');
        }
		if(paidAmount=="0"){
			$("#msgPaid").html('Required this field').css("color","red");
            return false;
        }else{
            $('#msgPaid').html('');
        }
        if(paymentDate==""){
            $("#msgDate").html('Required this field').css("color","red");
            return false;
        }else{
            $('#msgDate').html('');
        }
		var succes = "";
		if(succes == ""){;
			var urldata = "<?php echo base_url();?>Administrator/Customer/custome_PaymentAmount/";
			$.ajax({
				type: "POST",
				url: urldata,
				data: $('#PaymentForm').serialize(),
				success:function(data){
					if(data){
						setTimeout(function() {$.fancybox.close()}, 100);
						if(confirm('Show Report')){
							window.location.href='<?php echo base_url();?>paymentAndReport';
						}else{
							$('#success').html('Payment Success').css("color","green");
							$('#PaymentForm')[0].reset();
							location.reload();
						}
					}else{
						alert("Payment failed!");
					}
					
				}
			});
		}
	}


    function Edit_payment(id){
        var edit= id;
        var urldata = "<?php echo base_url();?>Administrator/Customer/paymentEdit/"+edit;
        $.ajax({
            type: "POST",
            url: urldata,
            //data: {id:edit},
            success:function(data){
                $("#showEditPage").html(data);
				
				$('#DaTe').datepicker({
				   autoclose: true,
				   todayHighlight: true
				})
				
				$('.chosen-select').chosen(); 
            }
        });
    }
</script>
<script type="text/javascript">
    function deleted(id){
        var deletedd= id;
        //alert(inputdata);
		if(confirm("Are You Sure Want to delete This?")){
        var urldata = "<?php echo base_url();?>Administrator/Customer/paymentDelete/"+deletedd;
        $.ajax({
            type: "POST",
            url: urldata,
            success:function(data){
                alert("Delete Success");
            }
        });
		}
    }
</script>
