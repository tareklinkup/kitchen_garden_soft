<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
	<div class="form-group" style="margin-top:10px;">
		<label class="col-sm-1 control-label no-padding-right" for="customerID"> Search Type </label>
		<div class="col-sm-3">
			 <select name="" id="customerID" data-placeholder="Choose a Customer..." class="chosen-select" style="width:200px">
				<option value="All"> All </option>
				<?php 
				$userBrunch = $this->session->userdata('BRANCHid');
				$sql = $this->db->query("SELECT * FROM tbl_customer WHERE Customer_brunchid = '$userBrunch' ORDER BY Customer_Name ASC");
				$row = $sql->result();
				foreach($row as $row){ ?>
				<option value="<?php echo $row->Customer_SlNo; ?>"><?php echo $row->Customer_Name.' '. $row->Customer_Mobile; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>

		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right" for="Sales_startdate"> From Date </label>
		</div>
	
		<div class="col-sm-2">
			<div class="input-group">
				<input class="form-control date-picker" id="Sales_startdate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>" />
				<span class="input-group-addon"style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right" for="Sales_enddate"> To Date </label>
		</div>
	
		<div class="col-sm-2">
			<div class="input-group">
				<input class="form-control date-picker" id="Sales_enddate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>" />
				<span class="input-group-addon"style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
	
	<div class="form-group">
		<div class="col-sm-2">
			<input type="button" class="btn btn-primary form-control" onclick="Customerdata()" value="Show Report" style="margin-top:0px;border:0px;height:28px;width:100%;">
		</div>
	</div>
</div>

<div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:15px;">
	<span id="result">
	
	</span>
</div>
</div>

<script type="text/javascript">
    function Customerdata(){
        //var BranchID = $("#BranchID").val();
        var customerID = $("#customerID").val();
            if(customerID == ''){
                alert("Select Customer");
                return false;
            }
        var startdate = $("#Sales_startdate").val();
        var enddate = $("#Sales_enddate").val();
        //var inputData = 'BranchID='+BranchID+'&customerID='+customerID+'&startdate='+startdate+'&enddate='+enddate;
        var inputData = 'customerID='+customerID+'&startdate='+startdate+'&enddate='+enddate;
        var urldata = "<?php echo base_url();?>invoiceProductList";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputData,
            success:function(data){
                $("#result").html(data);
            }
        });
    }
</script>