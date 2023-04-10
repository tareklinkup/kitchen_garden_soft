<?php
/* $brunch=$this->session->userdata('BRANCHid');
$query=mysql_query("SELECT * FROM tbl_company WHERE company_BrunchId='$brunch'");
$row=mysql_fetch_assoc($query); */
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
          <td align="right" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;" /></td>
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
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Sales Record</h2></td>
        </tr>
        <tr>
            <td colspan="2">
            <!-- Page Body -->
          
              <table class="border" cellspacing="0" cellpadding="0" width="100%">
                <tr>
					<th style="text-align: center;">Invoice No</th>
					<th style="text-align: center;">Date</th>
					<th style="text-align: center;">Customer Name</th>
					<th style="text-align: center;">Description</th>
					<th style="text-align: center;">Quantity</th>
					<th colspan="2" style="text-align: right;">Total Amount</th>
				</tr>
   <?php 
		//echo "<pre>";print_r($record);exit;
        $i = 0;
        $totalSales = 0;
        $TotalQty = 0;
        $totalcommision = 0;
        $totalpaid = 0;
        if(isset($records) && $records){
        foreach($records as $record){
            //var_dump($record);
            $i++;
	    $k=0;
            $Qty = 0;
            $totalSales = $totalSales +$record->SaleMaster_SubTotalAmount; 
            $totalpaid = $totalpaid + $record->SaleMaster_PaidAmount;
            $sales = $record->SaleMaster_SubTotalAmount;
            $SMID = $record->SaleMaster_SlNo;

            $SSD = $this->db->query("SELECT tbl_product.Product_Name,tbl_product.one_cartun_equal,tbl_saledetails.* FROM tbl_saledetails Left Join tbl_product ON tbl_product.Product_SlNo=tbl_saledetails.Product_IDNo WHERE tbl_saledetails.SaleMaster_IDNo = '$SMID'");
            $SDROW = $SSD->result();
			foreach ($SDROW as $SDROW) {
				$k++;
				$boxsize=$SDROW->one_cartun_equal;
            if($SDROW->SaleDetails_TotalQuantity>$boxsize){
                $getbox= $SDROW->SaleDetails_TotalQuantity/$boxsize;
                $boxnum=floor($getbox);
                $getpcs=$SDROW->SaleDetails_TotalQuantity%$boxsize;
                $tbox=$boxnum." Box ".$getpcs." Pcs";
              }
            else{
                 $tbox="0 Box ".$SDROW->SaleDetails_TotalQuantity." Pcs";
                 }
				
				if($k==1){?>
                 <tr>
                    <td align="center"><?php echo $record->SaleMaster_InvoiceNo; ?></td>
                    <td><?php echo $record->SaleMaster_SaleDate; ?></td>
                    <td><?php echo $record->Customer_Name;  ?></td>
                    <td align="center"><?php echo $SDROW->Product_Name; ?></td>
                    <td style="text-align: center;"><?php echo $SDROW->SaleDetails_TotalQuantity; ?></td>
                    
                    <td style="text-align: right;" colspan="2"><?php echo $SDROW->SaleDetails_TotalQuantity*$SDROW->SaleDetails_Rate; ?></td>
                </tr>
               <?php }
			   else{ ?>
               <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center"><?php echo $SDROW->Product_Name; ?></td>
                    <td style="text-align: center;"><?php echo $SDROW->SaleDetails_TotalQuantity; ?></td>
                    
                    <td style="text-align: right;" colspan="2"><?php echo $SDROW->SaleDetails_TotalQuantity*$SDROW->SaleDetails_Rate; ?></td>
                </tr>
			   <?php } 
			   $Qty += $SDROW->SaleDetails_TotalQuantity;
               $TotalQty += $SDROW->SaleDetails_TotalQuantity;
            }
        ?>
			<tr>
				<td style="text-align: right;" colspan="4"></td>
			   
				<td style="text-align: center;"><strong> Total Quantity: <?php echo $Qty; ?></strong></td>
				<td style="text-align: center;"><strong>Total Paid: <?php echo $record->SaleMaster_PaidAmount; ?> <br/>Total Due: <?php echo number_format($record->SaleMaster_DueAmount, 2); ?></strong></td>
				<td style="text-align: right;" colspan="2"><strong>Total: <?php echo number_format($record->SaleMaster_SubTotalAmount, 2); ?></strong></td>
            </tr>
        <?php } } ?>
    </table>
	
<div class="provied">
  
  <span style="float:left;font-size:11px;">
<i>"THANK YOU FOR YOUR BUSINESS"</i><br>
  Software Provied By Link-Up Technology</span>
</div>
<div class="signature">
<span style="border-top:1px solid #000;">
  Authorize Signature
</span>
</div>
</body>
</html>

