<div class="row">
<div class="col-xs-12">
<form class="form-horizontal" method="post" id="saleryform" action="">
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="employee_id"> Employee Name</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select name="employee_id" id="employee_id" class="chosen-select form-control" onchange="Employee()" data-placeholder="Select Employee" required >
					<option value=""></option>
					<?php 
					$BRANCHid = $this->session->userdata("BRANCHid");
					$sql = $this->db->query("SELECT * FROM tbl_employee where Employee_brinchid='$BRANCHid' and Status='a' order by Employee_Name asc");
					$employee = $sql->result(); 
					foreach($employee as $employee){ ?>
					<option value="<?php echo $employee->Employee_SlNo; ?>" <?php if($selected->Employee_SlNo==$employee->Employee_SlNo){ ?>  selected="selected" <?php } ?>><?php echo $employee->Employee_Name; ?> (<?php echo $employee->Employee_ID; ?>)</option>
					<?php } ?>
				</select>  
				 <div id="brand_" class="col-sm-12"></div>
			</div>
		</div>
		
		<span id="EmployeeResult">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Product_id"> Salary Range </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" name="salary_range" id="salary_range"value="<?php echo $selected->salary_range; ?>" class="form-control" readonly />
				<input name="employee_payment_id" type="hidden" id="designation" value="<?php echo $selected->employee_payment_id; ?>" />
			</div>
		</div>
		</span>

		<div class="form-group">
			<label class="col-sm-4 control-label" for="pro_Name">Month</label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select name="mounth" id="mounth" class="chosen-select form-control" data-placeholder="Select Month" required>
				   <option value=""></option>
				   <?php $msql = $this->db->query("SELECT * FROM tbl_month order by month_id desc");
						$mrow = $msql->result();
				   foreach($mrow as $mrow){ ?>
				   <option value="<?php echo $mrow->month_id; ?>"<?php if($selected->month_id==$mrow->month_id){ ?>  selected="selected" <?php } ?>><?php echo $mrow->month_name; ?></option>
				   <?php } ?>
			   </select> 
			</div>
		</div>
	</div>

	<div class="col-sm-6">

		<div class="form-group">
		<label class="col-sm-4 control-label" for="date">Date</label>
		<label class="col-sm-1 control-label">:</label>	
			<div class="col-sm-6">
			<input class="form-control date-picker" name="date" id="date" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px !important;" value="<?php echo $selected->payment_date; ?>" />
			</div>
		</div>
			
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> Payment </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="payment" name="payment" value="<?php echo $selected->payment_amount; ?>" placeholder="Purchase Rate" class="form-control" />
				 <div id="Purchase_rate_" class="col-sm-12"></div>
			</div> 
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> Deduction </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="deduction" name="deduction" value="<?php echo $selected->deduction_amount; ?>"  placeholder="Purchase Rate" class="form-control" />
				 <div id="Purchase_rate_" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> </label>
			<label class="col-sm-1 control-label"></label>
			<div class="col-sm-6">
				<button type="button" onclick="submitdata()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
						Update
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</div>
	</form>	
</div>


	<div class="col-xs-12">
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		
		<div class="table-header">
			Product Information
		</div>
	</div>
		
		<div class="col-xs-12">
				<!-- div.table-responsive -->

				<!-- div.dataTables_borderWrap -->  
				<span id="saveResult">
				<div class="table-responsive">
					<table id="dynamic-table" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>

								<th>Date</th>
								<th>ID</th>
								<th>Employee Name</th>
								<th class="hidden-480">Month</th>

								<th>Payment Amount</th>
								<!--<th class="hidden-480">Purchase Rate</th>
								<th class="hidden-480">Sell Rate</th>--->

								<th>Deduction Amount</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>
						<?php 
						$i=1; 
						$BRANCHid = $this->session->userdata("BRANCHid");
						$sql = $this->db->query("SELECT tbl_employee.*,tbl_employee_payment.*,tbl_month.* FROM tbl_employee left join tbl_employee_payment on tbl_employee_payment.Employee_SlNo=tbl_employee.Employee_SlNo left join tbl_month on tbl_employee_payment.month_id=tbl_month.month_id where tbl_employee_payment.paymentBranch_id='$BRANCHid' AND tbl_employee.Status='a' order by tbl_employee_payment.employee_payment_id desc limit 50");
						$row = $sql->result();
						foreach($row as $row){
						?>
							<tr>
								<td>
									<a href="#"><?php echo $row->payment_date; ?></a>
								</td>
								<td class="hidden-480"><?php echo $row->Employee_ID; ?></td>
								<td><?php echo $row->Employee_Name; ?></td>
								<td class="hidden-480">
									<span class="label label-sm label-info arrowed arrowed-righ">
									<?php echo $row->month_name; ?>
									</span>
								</td>
								<td><?php echo $row->payment_amount; ?></td>
								<td><?php echo $row->deduction_amount; ?></td>
								<td>
									<div class="hidden-sm hidden-xs action-buttons">
										<a class="blue" href="<?php echo base_url(); ?>editEmployeeSalary/<?php echo $row->employee_payment_id;; ?>" onclick="return confirm('Are you sure you want to Edit this item?');">
											<i class="ace-icon fa fa-pencil bigger-130"></i>
										</a>

										<a class="green" href="" onclick="deleted(<?php echo $row->employee_payment_id; ?>)">
											<i class="ace-icon fa fa-trash bigger-130 text-danger"></i>
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
					</span>

	</div><!-- /.col -->
</div><!-- /.row -->

<script type="text/javascript">
     function Employee()   {
        var employee_id = $("#employee_id").val();
        var inputdata = 'employee_id='+employee_id;
        var urldata = "<?php echo base_url();?>Administrator/employee/selectEmployee";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#EmployeeResult").html(data);
            }
        });
    }

	function submitdata() {
        var urldata = "<?php echo base_url();?>UpdateemployeePayment";
        $.ajax({
            type: "POST",
            url: urldata,
            data: $('#saleryform').serialize(),
            success:function(data){
                //$("#EmployeeResult").html(data);
				//$('input#date',this).datepicker();
				alert(data);
				location.reload();
            }
        });
    }
	
	    function deleted(id){
        var deletedd= id;
        var inputdata = 'deleted='+deletedd;
        var x=confirm("Confirm To Delete ?");
        var urldata = "<?php echo base_url();?>paymentDelete";
        if (x) {
            $.ajax({
                type: "POST",
                url: urldata,
                data: inputdata,
                success:function(data){
                    //$("#saveResult").html(data);
                    alert("Delete Success");
					window.location.href='<?php echo base_url(); ?>Administrator/employee/employeesalarypayment';
                }
            });
        };
    }
</script>