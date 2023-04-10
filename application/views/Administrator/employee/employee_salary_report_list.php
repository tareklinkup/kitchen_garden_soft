
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
							<th style="width:10%;text-align:center;">Due Amount</th>
<!--							<th style="width:15%;text-align:center;">Status</th>-->
						</tr>
					</thead>
				
				<tbody>
                <?php
                $i=1;
                $total_salary_range = 0;
                $total_payment_amount = 0;
                $total_deduction_amount = 0;
                $total_due_amount = 0;
                $taken = 0;
                $deduct = 0;
                $due = 0;
                foreach ($employee_list as $emp):

                       $obj =  $this->db
                                            ->select_sum('payment_amount')
                                            ->select_sum('deduction_amount')
                                            ->where('month_id',$month)
                                            ->where('Employee_SlNo',$emp->Employee_SlNo)
                                            ->get('tbl_employee_payment')->row();

                    $total_salary_range += $emp->salary_range;

                    if (isset( $obj)){
                        $paid = $obj->payment_amount;
                        $deduct = $obj->deduction_amount;
                        $due = ($emp->salary_range - ($paid + $deduct));

                        $total_payment_amount+= $paid;
                        $total_deduction_amount+=$deduct;
                        $total_due_amount+=$due;
                    }

                    ?>
				<tr <?= ($due == 0)? 'style="background-color: #428BCA; color: #fff;"' : ''?> >
					<td style="width:10%"><?php echo $i++; ?></td>
					<td style="width:10%"><?php echo $emp->Employee_ID; ?></td>
                    <td style="width:15%"><?php echo $emp->Employee_Name; ?></td>
                    <td style="width:15%"><?php echo $emp->Designation_Name; ?></td>
                    <td style="width:10%"><?php echo $emp->salary_range; ?></td>
                    <td style="width:10%"><?= $paid ?></td>
                    <td style="width:10%"><?= $deduct  ?></td>
                    <td style="width:10%"><?= $due  ?></td>
<!--                    <td style="width: 15%;"> --><?//= ($due == 0)?  "Paid" : '';?><!-- </td>-->
				</tr>
                <?php

                endforeach; ?>

				<tr style="height:35px;background:#ccc;font-size:16px;">
					<td colspan="4" style="text-align:right;">Total : </td>
                    <td><?php echo $total_salary_range; ?></td>
                    <td><?php echo $total_payment_amount; ?></td>
                    <td ><?php echo $total_deduction_amount; ?></td>
                    <td ><?php echo $total_due_amount; ?></td>
                    <td></td>
				</tr>
				 </tbody>
        </table>



