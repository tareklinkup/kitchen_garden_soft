   <?php 
   $BRANCHid = $this->session->userdata("BRANCHid");
   $form = $this->session->userdata('form');
   $to = $this->session->userdata('to');
   if(isset($employee_list)){
	   $i = 1;
	   $month;
	   		$total_payment_amount = 0;
			$total_deduction_amount = 0;
			$total_salary_range = 0;
			$total_netPayment = 0;
			$pdam = 0;
			
			?>
			<table class="table table-bordered" id="" style="text-align:center;width:100%;">
				<thead>
						<tr class="header" style="background:#ccc;">
							<th style="width:10%;text-align:center;">SL NO</th>
							<th style="width:10%;text-align:center;"> ID</th>
							<th style="width:15%;text-align:center;">Name</th>
							<th style="width:15%;text-align:center;">Designation</th> 
							<th style="width:10%;text-align:center;">Salary Range</th> 
							<th style="width:15%;text-align:center;">Already Taken</th> 
							<th style="width:15%;text-align:center;">Deduction Amount</th>                                                                                                            
							<th style="width:10%;text-align:center; display: none">Due Payment</th>
						</tr>
					</thead>
				
				<tbody>
			<?php
		foreach($employee_list as $employee_list)
		{
			$employee_id = $employee_list->Employee_SlNo;
			$this->db->select('tbl_employee.*,tbl_employee_payment.*')->from('tbl_employee');
			$this->db->join('tbl_employee_payment','tbl_employee_payment.Employee_SlNo=tbl_employee.Employee_SlNo','left');
			$this->db->where('tbl_employee_payment.paymentBranch_id',$BRANCHid);
			$this->db->where('tbl_employee_payment.Employee_SlNo',$employee_id);
			$this->db->where("DATE_FORMAT(tbl_employee_payment.date,'%Y-%m-%d') >=",$form);
			$this->db->where("DATE_FORMAT(tbl_employee_payment.date,'%Y-%m-%d') <=",$to);
			$employee_payment = $this->db->order_by('tbl_employee_payment.employee_payment_id','desc')->get()->result();
			
			$payment_amount = 0;
			$deduction_amount = 0;
			$netPayment = 0;

			foreach($employee_payment as $employee_payment){ 
				$payment_amount = $payment_amount+$employee_payment->payment_amount;
				$deduction_amount = $deduction_amount+$employee_payment->deduction_amount;
				}

				$netPayment = $payment_amount + $deduction_amount;
				
				$total_payment_amount = $total_payment_amount + $payment_amount;
				$total_deduction_amount = $total_deduction_amount + $deduction_amount;
				$total_salary_range = $total_salary_range + $employee_list->salary_range;
				$total_netPayment = $total_netPayment + ($payment_amount + $deduction_amount);
				// echo "<pre>";print_r($total_deduction_amount);exit;
			?> 
			
				<tr>
					<td style="width:10%";><?php echo $i++; ?></td>
					<td style="width:10%";><?php echo $employee_list->Employee_ID; ?></td>
                    <td style="width:15%";><?php echo $employee_list->Employee_Name; ?></td>
                    <td style="width:15%";><?php echo $employee_list->Employee_Name; ?></td>
                    <td style="width:10%";><?php echo $employee_list->salary_range; ?></td>
                    <td style="width:15%";><?php echo $payment_amount; ?></td>		
                    <td style="width:15%";><?php echo $deduction_amount; ?></td>
					<td style="width:10%; display: none" ;><?php echo $tt = $employee_list->salary_range - ($payment_amount+$deduction_amount);  $pdam = $pdam + $tt; ?></td>
				</tr>			
		<?php 
		}
		?>
				<tr style="height:35px;background:#ccc;font-size:16px;">
					<td colspan="4" style="text-align:right;">Total : </td>
                    <td><?php echo $total_salary_range; ?></td>		
                    <td><?php echo $total_payment_amount; ?></td>		
                    <td ><?php echo $total_deduction_amount; ?></td>
                    <!-- <td><?php echo $pdam; ?></td>		 -->
				</tr>
				 </tbody>
        </table>
		<?php
	}

	if(isset($employee_payment_details)){
  ?>
        <table class="table table-bordered" id="" style="text-align:center;width:100%;">
			<thead>
				<tr class="header" style="background:#ccc;">
					<th style="width:10%;text-align:center;">Date</th>  
					<th style="width:10%;text-align:center;">ID</th>
					<th style="width:15%;text-align:center;">Name</th>
					<th style="width:15%;text-align:center;">Payment Amount</th> 
					<th style="width:15%;text-align:center;">Deduction Amount</th>                                                                                                                                                                                                             
				</tr>
			</thead>
			<tbody>
            <?php 
			$i=1; 
			$payment_amount = 0;
			$deduction_amount = 0;
			foreach($employee_payment_details as $employee_payment){ 
			$payment_amount = $payment_amount+$employee_payment->payment_amount;
			$deduction_amount = $deduction_amount+$employee_payment->deduction_amount;
			?>
                <tr>
					<td style="width:200px"><?php $date = new DateTime($employee_payment->date); echo date_format($date,'d M Y') ; ?></td>
                    <td style="width:50px"><?php echo $employee_payment->Employee_ID; ?></td>
                    <td style="width:200px"><?php echo $employee_payment->Employee_Name; ?></td>
                    <td style="width:200px"><?php echo $employee_payment->payment_amount; ?></td>
                    <td style="width:200px"><?php echo $employee_payment->deduction_amount; ?></td>
                </tr>  
            <?php } ?> 
				<tr>
					<td colspan="3" style="text-align:right;">Total : </td>
                    <td><?php echo $payment_amount; ?></td>		
                    <td><?php echo $deduction_amount; ?></td>				
				</tr>			
            </tbody>
        </table>
	<?php  } ?>
