<?php
$brunch=$this->session->userdata('BRANCHid');
?>
<!DOCTYPE html>
<html>
<head>
<title> </title>
<meta charset='utf-8'>
    <link href="<?php echo base_url()?>assets/css/prints.css" rel="stylesheet" />
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
          <td align="right" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org; ?>" alt="Logo" style="width:100px;" /></td>
          <td align="center" width="650">
				<strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
				<?php echo $branch_info->Repot_Heading; ?><br/>
          </td>
        </tr>
        <tr>
          <td style="float:right">
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="250px" style="text-align:right;"><strong></td>
              </tr>
          </table>
          </td>
        </tr>
        <tr>
            <td colspan="2"><hr><hr></td>
            <td colspan="2"><br></td>
        </tr>
        <tr>
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Deposit Report</h2></td>
        </tr>
        <tr>
            <td colspan="2">
            <!-- Page Body -->

    <table class="border" cellspacing="0" cellpadding="0" width="100%">
        <tr bgcolor="#ccc" style="text-align:center;">
            <th style="text-align:center;">Tr. ID</th>
            <th style="text-align:center;">Date</th>
            <th style="text-align:center;">Tr Account</th>
            <th style="text-align:center;">Account Name</th>
            <th style="text-align:center;">Description</th>
            <th style="text-align:center;">In Amount</th>                      
            <!--<th style="text-align:center;">Out Amount</th> -->
        </tr>
			<?php
			$totalin = 0;
			$totalinout = 0;
			foreach($record as $row){
			$totalin = $totalin + $row->In_Amount;
			$totalinout = $totalinout + $row->Out_Amount;
			?>
			<tr align="center">
				<td><?php echo $row->Tr_Id; ?></td>
				<td><?php echo $row->Tr_date; ?></td>
				<td><?php echo $row->Tr_Type; ?></td>
				<td><?php echo $row->Acc_Name; ?></td>
				<td><?php  echo $row->Tr_Description; ?></td>
				<!--<td><?php if($row->In_Amount=="" ||$row->In_Amount=="0" ){echo '0';}else{ echo $row->In_Amount;} ?></td>-->
				<td><?php if($row->Out_Amount=="" ||$row->Out_Amount=="0" ){echo '0';}else{ echo $row->Out_Amount;} ?></td>
			</tr>
			<?php } ?>
		
		   <tr align="center">
				<td colspan="5" align="right">Total : </td>
				<!--<td><?php echo $totalin;?></td>-->
				<td><?php echo $totalinout; ?></td>
			</tr>
		
		</table>
            </td>
            <!-- Page Body end -->
       </tr>
    </table>

<div class="provied">
  
  <span style="float:left;font-size:11px;">
<i>"THANK YOU FOR YOUR BUSINESS"</i><br>
  Software Provied By Link-Up Technology</span>
</div>

</body>
</html>

