<?php
	$userBrunch = $this->session->userdata('BRANCHid');
	$ProductID = $this->session->userdata('ProductID');
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
          <td align="right" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;" /></td>
          <td align="left" width="650">
            <div class="">
				<div style="text-align:center;" >
				<strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br>
				<?php echo $branch_info->Repot_Heading; ?><br>
              </div>
			</div>
		  </td>
        </tr>
		
		<tr>
          <td align="center" width="" colspan="2">
         <?php
			if($ProductID != 'All'){
			 $sc = $this->db->query("SELECT * FROM tbl_product WHERE Product_SlNo = '$ProductID'");
             $crow = $sc->row();
			// echo "<pre>";print_r($crow);exit;
             ?>
           <h3 style="text-align:center;margin-top:10px">Product Name : <?php echo $crow->Product_Name; ?> (<?php echo $crow->Product_Code; ?>)</h3>
			<?php } ?>
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
            <td colspan="2"> 
                <table class="border" cellspacing="0" cellpadding="0" width="100%">
                   <thead>
						<tr class="header">
							<th style="width:20%;text-align:center;">Product Name</th>
							<th style="width:20%;text-align:center;">Date</th>
							<th style="width:15%;text-align:center;">Invoice</th>
							<th style="width:15%;text-align:center;">Quantity</th>
							<th style="width:15%;text-align:center;">Sale Rate</th>         
							<th style="width:15%;text-align:center;">Total</th>         
						</tr>
					</thead>
                    <tbody>
                    <?php 
						if($ProductID=='All'){
							 $sql = $this->db->query("SELECT tbl_saledetails.*, tbl_salesmaster.*, tbl_product.* FROM tbl_saledetails LEFT JOIN tbl_salesmaster ON tbl_salesmaster.SaleMaster_SlNo = tbl_saledetails.SaleMaster_IDNo LEFT JOIN tbl_product ON tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo WHERE tbl_salesmaster.SaleMaster_branchid = '$userBrunch' and tbl_saledetails.Status = 'a' and tbl_salesmaster.Status = 'a' AND tbl_salesmaster.SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate' ORDER BY tbl_salesmaster.SaleMaster_SaleDate DESC");
						}else{
							 $sql = $this->db->query("SELECT tbl_saledetails.*, tbl_salesmaster.*, tbl_product.* FROM tbl_saledetails LEFT JOIN tbl_salesmaster ON tbl_salesmaster.SaleMaster_SlNo = tbl_saledetails.SaleMaster_IDNo LEFT JOIN tbl_product ON tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo WHERE tbl_salesmaster.SaleMaster_branchid = '$userBrunch' and tbl_saledetails.Status = 'a' and tbl_salesmaster.Status = 'a' AND tbl_saledetails.Product_IDNo = '$ProductID' AND tbl_salesmaster.SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate' ORDER BY tbl_salesmaster.SaleMaster_SaleDate DESC");
						}
						$row = $sql->result();
						foreach($row as $row){ ?>
							<tr align="center" style="height:30px;">
								<td style="width:20%;"><?php echo $row->Product_Name; ?></td>
								<td style="width:20%;"><?php echo $row->SaleMaster_SaleDate; ?></td>
								<td style="width:15%;"><?php echo $row->SaleMaster_InvoiceNo; ?></td>
								<td style="width:15%;"><?php echo $row->SaleDetails_TotalQuantity; ?></td>
								<td style="width:15%;"><?php echo number_format($row->SaleDetails_Rate, 2); ?></td>
								<td style="width:15%;"><?php $t =  number_format($row->SaleDetails_Rate, 2); echo $t*$row->SaleDetails_TotalQuantity; ?></td>
							</tr>  
						<?php } ?>                                                                   
                    </tbody>
                </table>
            </td>
        </tr>
       
    </table></td>
  </tr>
  
</table>

<div class="provied">
  <span style="float:left;font-size:11px;">Software Provied By Link-Up Technology</span>
</div>
</body>
</html>

