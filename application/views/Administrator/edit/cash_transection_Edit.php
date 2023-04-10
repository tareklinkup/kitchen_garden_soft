<div class="form-horizontal">
	<div class="col-sm-6">
		<div class="form-group" style="">
			<label class="col-sm-4 control-label" for="Transaction_id"> Transaction  ID </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" name="Transaction_id" id="Transaction_id" value="<?php echo $selected->Tr_Id; ?>" class="form-control" readonly />
				<input name="iidd" type="hidden" id="iidd" class="required" value="<?php  echo $selected->Tr_SlNo?>" autofocus="" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="tr_type">Transaction Type</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select name="tr_type" id="tr_type" class="chosen-select form-control" onchange="AutoSelect()">
					<option value=""></option>
					<!--<option value="Cash Receive" <?php if($selected->Tr_Type=="Cash Receive") echo "selected"; ?>>Cash Receive</option>
					<option value="Cash Payment" <?php if($selected->Tr_Type=="Cash Payment") echo "selected"; ?>>Cash Payment</option>-->
					<option value="Deposit To Bank" <?php if($selected->Tr_Type=="Deposit To Bank") echo "selected"; ?>>Deposit To Bank</option>
					<option value="Withdraw Form Bank" <?php if($selected->Tr_Type=="Withdraw Form Bank") echo "selected"; ?>>Withdraw Form Bank</option>
					<option value="Income" <?php if($selected->Tr_Type=="Income") echo "selected"; ?>> Income </option>
					<option value="Out Cash" <?php if($selected->Tr_Type=="Out Cash") echo "selected"; ?>> Out Cash </option>
				</select>
			</div>
		</div>	
		
		<div class="form-group" style="display:none;">
			<label class="col-sm-4 control-label" for="acc_type">Account Type</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select name="acc_type" id="acc_type" class="chosen-select form-control" onchange="AutoSelect()">
					<option value=""></option>
					<option value="Customer" <?php if($selected->Tr_account_Type=="Customer") echo "selected"; ?>>Customer</option>
					<option value="Official" <?php if($selected->Tr_account_Type=="Official") echo "selected"; ?>>Official</option>
					<option value="Supplier" <?php if($selected->Tr_account_Type=="Supplier") echo "selected"; ?>>Supplier</option>
				</select>
			</div>
		</div>	
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="account_id">Account ID</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select name="account_id" id="account_id" class="chosen-select form-control" onchange="AutoSelect()">
					<option></option>
					<?php 
					$sql = $this->db->query("SELECT * FROM tbl_account where status='a' order by Acc_Code asc ");
					$row = $sql->result();
					foreach($row as $row){ ?>
					<option value="<?php echo $row->Acc_SlNo; ?>" <?php if($row->Acc_SlNo==$selected->Acc_SlNo){ ?> selected="selected" <?php } ?>><?php echo $row->Acc_Name; ?> - <?php echo $row->Acc_Code; ?></option>
					<?php } ?>  
				</select>
			</div>
		</div>	
	</div>
		
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="DaTe">Date</label>
			<label class="col-sm-1 control-label">:</label>	
			<div class="col-sm-6">
				<input class="form-control date-picker" name="DaTe" id="DaTe" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px !important;" value="<?php echo $selected->Tr_date; ?>" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Description"> Description </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="Description" name="Description" value="<?php echo $selected->Tr_Description; ?>" class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Bank_id"> Bank Name </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select name="Bank_id" id="Bank_id" class="chosen-select form-control" onchange="AutoSelect()">
					<option value=""></option>
					<?php  	
					$this->db->select('*');$this->db->from('tbl_bank');
					$this->db->where('status','a');$query = $this->db->get();
					$result = $query->result();
					foreach($result as $result){
					 ?>
						<option value="<?php echo $result->Bank_SiNo; ?>" <?php if($result->Bank_SiNo==$selected->Bank_SiNo){ ?> selected="selected" <?php } ?> ><?php echo $result->Bank_name; ?></option>
					<?php } ?> 
				</select>
			</div>
		</div>
		
		<div class="form-group" style="display:none;">
			<label class="col-sm-4 control-label" for="ChequeNumber"> Cheque Number </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="ChequeNumber" name="ChequeNumber" value="<?php echo $selected->ChequeNumber; ?>" class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Amount"> Amount </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="Amount" name="Amount" value="<?php if($selected->Tr_Type=="Cash Payment"){echo $selected->Out_Amount;}if($selected->Tr_Type=="Deposit To Bank"){echo $selected->Out_Amount;} if($selected->Tr_Type=="Cash Receive"){echo $selected->In_Amount;}  if($selected->Tr_Type=="Withdraw Form Bank"){echo $selected->In_Amount;}  if($selected->Tr_Type=="Expense"){echo $selected->Out_Amount;} ?>" class="form-control" />
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> </label>
			<label class="col-sm-1 control-label"></label>
			<div class="col-sm-6">
				<button type="button" onclick="TransactionUpdatesubmit()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
						Update
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</div>
</div>