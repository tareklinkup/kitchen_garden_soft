<?php   $serial ="A1000";
		$sql = $this->db->query("SELECT * FROM tbl_account ORDER BY `Acc_SlNo` DESC LIMIT 1");
		$row = $sql->row();
		
			if(@$row->Acc_Code!=null){
				$serial = explode("A",$row->Acc_Code);
				@$serial=$serial[1]; 
				$autoserial= $serial+1;
				$generateCode = "A".$autoserial;
			}else{
				$generateCode = $serial;
			}
			//echo "<pre>";print_r($row);
			//exit;
	?>
<div style="width: 500px; ">
	<div style="width: 80%; height: 200px; margin: auto;margin-top: 30px;">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="account_id"> Account ID </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" name="account_id2" id="account_id2"  value="<?php echo $generateCode; ?>" class="form-control" readonly />
			</div>
		</div>

		<div class="form-group" style="display: none;">
			<label class="col-sm-4 control-label" for="tr_type">Transaction Type</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select name="tr_type" id="tr_type" class="chosen-select" onchange="AutoSelect()">
					<option value=""></option>
					<!--<option value="Cash Receive">Cash Receive</option>
					<option value="Cash Payment">Cash Payment</option>-->
					<option value="Deposit To Bank">Deposit To Bank</option>
					<option value="Withdraw Form Bank">Withdraw Form Bank</option>
					<option value="In Cash">In Cash</option>
					<option value="Out Cash">Out Cash</option>
				</select>
			</div>
		</div>	
		
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="accountName">Account Name</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="accountName" name="accountName" value="<?php echo set_value('accountName'); ?>" placeholder="Account name .." class="form-control" />
				 <div id="pro_Name_" class="col-sm-12"></div>
			</div>
		</div>	

		<div class="form-group">
			<label class="col-sm-4 control-label" for="form-field-1"> Account Type </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input name="accoun" type="text" id="accoun" value="Official" class="form-control" readonly />
				 <input name="accounttype" type="hidden" id="accounttype" value="Official" class="txt" />
				 <div id="Re_Order_" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Description"> Description </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="Description" name="Description" value="" class="form-control" />
				 <div id="sell_rate_" class="col-sm-12"></div>
			</div>
		</div>


		<div class="form-group" >
			<label class="col-sm-4 control-label" for=""> </label>
			<label class="col-sm-1 control-label"></label>
			<div class="col-sm-6">
				<button type="button" onclick="submit()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
						Save
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
    function submit(){
        var account_id= $("#account_id2").val();
        var accountName= $("#accountName").val();
        if(accountName==""){
            $("#accountName").css("border-color","red");
            return false;
        }
        var tr_type= $("#tr_type").val();
        var accounttype= $("#accounttype").val();
        var Description= $("#Description").val();

        var inputdata = 'account_id='+account_id+'&accountName='+accountName+'&accounttype='+accounttype+'&Description='+Description+'&tr_type='+tr_type;
        var urldata = "<?php echo base_url();?>accountInsert";
        //alert(inputdata);
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
				location.reload();
				
            }
        });
    }
</script>
