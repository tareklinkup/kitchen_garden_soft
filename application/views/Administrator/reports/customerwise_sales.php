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
          <td align="right" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;" /></td>
          <td align="center" width="650">
				<strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
				<?php echo $branch_info->Repot_Heading; ?><br/>
          </td>
        </tr>
		
		<?php
             $userBrunch = $this->session->userdata('BRANCHid');
             $customerID = $this->session->userdata('customerID');
             $startdate = $this->session->userdata('startdate');
             $enddate = $this->session->userdata('enddate');
             $sc = $this->db->query("SELECT * FROM tbl_customer WHERE Customer_SlNo = '$customerID'");
             $crow = $sc->row();
        ?>
		
        <tr>
          <td colspan="2"><h3 style="text-align:center;margin-top:10px;font-size:15px;">Customer Name : <?php echo $crow->Customer_Name; ?></h3></td>
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
                            <th style="width:20%">Date</th>
                            <th style="width:20%">Invoice</th>
                            <th style="width:20px">Total Amount</th>
                            <th style="width:20px">Paid Amount</th>
                            <th style="width:20px">Due Amount</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
                    $sql = $this->db->query("SELECT * FROM tbl_salesmaster WHERE SalseCustomer_IDNo = '$customerID'  AND SaleMaster_branchid = '$userBrunch' and Status = 'a' AND SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate'");
					$row = $sql->result();
					foreach($row as $row){ ?>
					<tr align="center">
						<td style="width:20%;"><?php echo $row->SaleMaster_SaleDate; ?></td>
						<td style="width:20%;"><?php echo $row->SaleMaster_InvoiceNo; ?></td>
						<td style="width:20%;"><?php echo number_format($row->SaleMaster_SubTotalAmount, 2); ?></td>
						<td style="width:20%;"><?php echo number_format($row->SaleMaster_PaidAmount, 2); ?></td>
						<td style="width:20%;"><?php echo number_format($row->SaleMaster_DueAmount, 2); ?></td>
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

