<?php
	$BranchID = $this->session->userdata('BranchID');
	$customerID = $this->session->userdata('customerID');
	$startdate = $this->session->userdata('startdate');
	$enddate = $this->session->userdata('enddate');
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
          <td align="right" style="float:left;width:150px;"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;" /></td>
          <td style="width:650px;">
            <div class="">
				<div style="text-align:center;float:left;" >
				<strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br>
				<?php echo $branch_info->Repot_Heading; ?><br>
              </div>
			</div>
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
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Invoice Product Details List<br></h2></td>
        </tr>
        <tr>
            <td colspan="2">
            <!-- Page Body -->
          
              <table class="border" cellspacing="0" cellpadding="0" width="100%">
                <tr >
                  <th style="width:10%">Date</th>
                  <th style="width:15%">Invoice</th>
                  <th style="width:20%">Customer</th>
                  <th style="width:20%">Product</th>
                  <th style="width:15%">Sales Qty</th>
                  <th style="width:20%">Sales Amount</th> 
                </tr>
                <?php 
             $subTotal = 0;
            if($customerID == 'All'){
                $sql = $this->db->query("SELECT tbl_salesmaster.*, tbl_customer.* FROM tbl_salesmaster LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo WHERE tbl_salesmaster.SaleMaster_branchid = '$BranchID' and tbl_salesmaster.Status = 'a' AND tbl_salesmaster.SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate'");
			}else{
				$sql = $this->db->query("SELECT tbl_salesmaster.*, tbl_customer.* FROM tbl_salesmaster LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo WHERE tbl_salesmaster.SalseCustomer_IDNo = '$customerID' AND tbl_salesmaster.SaleMaster_branchid = '$BranchID' and tbl_salesmaster.Status = 'a' AND tbl_salesmaster.SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate'");
			}
			$result = $sql->result();
            foreach($result as $row){ 
                $SMID = $row->SaleMaster_SlNo;
                $INVTOTAL = 0;
                $SDQ = $this->db->query("SELECT tbl_saledetails.*, tbl_product.* FROM tbl_saledetails LEFT JOIN tbl_product ON tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo WHERE tbl_saledetails.SaleMaster_IDNo = '$SMID' and tbl_saledetails.Status = 'a'");
                $SDROW = $SDQ->result();
				$i = 0;
                foreach($SDROW as $SDROW) {
                    $i++;
                    $INVTOTAL += ($SDROW->SaleDetails_TotalQuantity*$SDROW->SaleDetails_Rate);
        ?>
               <tr align="center">
                    <td style="width:10%;padding:5px;"><?php if($i == 1){echo $row->SaleMaster_SaleDate;} ?></td>
                    <td style="width:15%;padding:5px;"><?php if($i == 1){echo $row->SaleMaster_InvoiceNo;} ?></td>
                    <td style="width:20%;padding:5px;"><?php if($i == 1){echo $row->Customer_Name;} ?></td>
                    <td style="width:20%;padding:5px;"><?php echo $SDROW->Product_Name; ?></td>
                    <td style="width:15%;padding:5px;"><?php echo $SDROW->SaleDetails_TotalQuantity; ?></td>
                    <td style="width:20%;padding:5px;"><?php echo number_format(($SDROW->SaleDetails_TotalQuantity*$SDROW->SaleDetails_Rate), 2); ?></td>
                </tr>
        <?php
                }
				
				  $subTotal += $INVTOTAL;
        ?>
            <tr align="center" style="background:#ccc;color:#000;">
                <td style="width:20%;padding:5px;border-right:0px !important;"><strong>Discount : <?php echo $row->SaleMaster_TotalDiscountAmount; ?></strong></td>
                <td style="width:20%;padding:5px;"><strong>Vat : <?php echo $row->SaleMaster_TaxAmount; ?> %</strong></td>
                <td style="width:20%;padding:5px;text-align:center;"><strong>Paid : <?php echo number_format($row->SaleMaster_PaidAmount, 2); ?></strong></td>
                <td style="width:20%;padding:5px;text-align:center;"><strong>Due : <?php echo number_format($row->SaleMaster_DueAmount, 2); ?></strong></td>
                <td style="width:20%;padding:5px;text-align:right;"><strong>Total:</strong></td>
                <td style="width:20%;padding:5px;text-align:right;"><strong><?php echo number_format($INVTOTAL, 2); ?></strong></td>
            </tr>  
        <?php } ?> 

            <tr>
                <td colspan="5" style="width:80%;padding:5px;text-align:right;"><strong> Sub Total</strong></td>
                <td style="width:20%;padding:5px;text-align:right;"><strong><?php echo number_format($subTotal, 2); ?></strong></td>
            </tr>  
              </table>
            </td>
			
			
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
       
  </tr>
  
</table>
</body>
</html>

