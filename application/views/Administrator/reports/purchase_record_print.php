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
          <td align="left" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org; ?>" alt="Logo" style="width:100px;margin-left:30px;" /></td>
          <td align="center" width="650">
				<p style="float:left;"><strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
				<?php echo $branch_info->Repot_Heading; ?><br/></p>
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
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Purchase Record</h2></td>
        </tr>
        <tr>
            <td colspan="2">
            <!-- Page Body -->
          
              <table class="border" cellspacing="0" cellpadding="0" width="100%">
                <tr >
                  <th>Invoice No.</th>
                  <th>Date</th>
                  <th>Supplier ID</th>
                  <th>Supplier Name</th>
                  <th>Discount</th>
                  <th>Total</th>
                  <th>Paid</th>
                  <th>Due</th>
                  <th>Notes</th>
              </tr>
              <?php $totalpurchase = "";
              $Totalpaid = "";
               foreach($record as $record){ 
            $totalpurchase = $totalpurchase +$record->PurchaseMaster_SubTotalAmount; 
            $Totalpaid = $Totalpaid +$record->PurchaseMaster_PaidAmount;

            ?>
			<tr align="center">
				<td><?php echo $record->PurchaseMaster_InvoiceNo; ?></td>
				<td><?php echo $record->PurchaseMaster_OrderDate; ?></td>
				<td><?php echo $record->Supplier_Code; ?></td>
				<td><?php echo $record->Supplier_Name; ?></td>
				<td><?php echo $record->PurchaseMaster_DiscountAmount; ?></td>
				<td><?php echo $record->PurchaseMaster_SubTotalAmount; ?></td>
				<td><?php echo $record->PurchaseMaster_PaidAmount; ?></td>
				<td><?php echo $record->PurchaseMaster_DueAmount; ?></td>
				<td><?php echo $record->PurchaseMaster_Description; ?></td>
			</tr>
        <?php } ?>
              </table>
            </td>
            
            <!-- Page Body end -->
        </tr>
          <tr>
            <td colspan="2"><br></td>
        </tr>
        <tr>
          <td colspan="2">
            <table  cellspacing="0" cellpadding="0" width="80%">
              <tr>
                  <td ><strong>Total Purchase </strong><input type="text" disabled="" value="<?php echo $totalpurchase; ?>"></td>
                  <td> <strong>Total Paid </strong> <input type="text" disabled="" value="<?php echo $Totalpaid; ?>"></td>
                  <td><strong>Total Due </strong> <input type="text" disabled="" value="<?php echo $totalpurchase - $Totalpaid; ?>"></td>
                  <td></td>
              </tr>
            </table>
          </td>
        </tr>
       
       
		<tr height="150">
		 <td align="left" width="50%">
			<span style="font-size:11px;">
			<i>"THANK YOU FOR YOUR BUSINESS"</i><br>
			  Software Provied By Link-Up Technology</span>
		 </td>
		 <td align="right" width="50%">
			<span style="border-top:1px solid #000;">
			  Authorize Signature
			</span>
		 </td>
		</tr>
    </table>
</body>
</html>

