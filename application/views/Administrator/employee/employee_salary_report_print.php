<?php
$brunch=$this->session->userdata('BRANCHid');
$months = $this->session->userdata("month");
$querymonth = $this->db->query("select * from tbl_month where month_id='$months'");
$monthname = $querymonth->row();
?>
<!DOCTYPE html>
<html>
<head>
<title> </title>
<meta charset='utf-8'>
    <link href="<?php echo base_url()?>assets/css/prints.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
</head>
<style type="text/css" media="print">
.hide{display:none}

</style>
<script type="text/javascript">
window.onload = async () => {
		await new Promise(resolve => setTimeout(resolve, 1000));
		window.print();
		window.close();
	}
</script>
<body style="background:none;">

      <table width="800px" >
         <tr>
		<td style="width:150px;">
			 <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100%;height:70px;float:right;">
		</td>
		
          <td style="float:left;width:650px;">
            <div class="headline">
				<div style="text-align:center" >
					<strong style="font-size:18px"><?php echo $branch_info->Company_Name; ?></strong>
					<br/>
				<?php echo $branch_info->Repot_Heading; ?><br/>
				</div>
			</div>
          </td>
        </tr>
		
		<tr>
			<td colspan="2"> 
				
			</td>
		</tr>
		
        <tr>
          <td style="float:right" colspan="2">
            <table width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td width="250px" style="text-align:right;"><strong></td>
              </tr>
          </table>
          </td>
        </tr>
		
        <tr>

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
                    <th style="width:15%;text-align:center;">Status</th>
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
                        <td style="width: 15%;"> <?= ($due == 0)?  "Paid" : '';?> </td>
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

        </tr>





<div class="provied">
  <span style="float:left;font-size:11px;">Software Provied By Link-Up Technology</span>
</div>
</body>
</html>
