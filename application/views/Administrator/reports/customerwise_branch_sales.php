<?php
$brunch=$this->session->userdata('BRANCHid');
$query=mysql_query("SELECT * FROM tbl_company WHERE company_BrunchId='$brunch'");
$row=mysql_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
<title> </title>
<meta charset='utf-8'>
    <link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
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
          <td>
            <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $row['Company_Logo_org']; ?>" alt="Logo" style="width:100px;margin-bottom:-50px">
            <div class="headline">
            <div style="text-align:center" >
             <strong style="font-size:18px"><?php echo $row['Company_Name']; ?></strong><br>
            <?php echo $row['Repot_Heading']; ?><br>
            
           <?php
             $BranchID = $this->session->userdata('BranchID');
             $customerID = $this->session->userdata('customerID');
             $startdate = $this->session->userdata('startdate');
             $enddate = $this->session->userdata('enddate');
             $sc = mysql_query("SELECT * FROM tbl_customer WHERE Customer_SlNo = '$customerID'");
             $crow = mysql_fetch_array($sc);
             $SB = mysql_query("SELECT * FROM tbl_brunch WHERE brunch_id = '$BranchID'");
             $BROW = mysql_fetch_array($SB);
             ?>
           <h3 style="text-align:center;margin-top:10px">Customer Name : <?php echo $crow['Customer_Name']; ?> <br>
           Branch Name : <?php echo $BROW['Brunch_name']; ?>
           </h3>
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
            <td> 
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
                      $sql = mysql_query("SELECT * FROM tbl_salesmaster WHERE SalseCustomer_IDNo = '$customerID'  AND SaleMaster_branchid = '$BranchID' AND SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate'");
                  while($row = mysql_fetch_array($sql)){ ?>
                      <tr>
                          <td style="width:20%"><?php echo $row['SaleMaster_SaleDate'] ?></td>
                          <td style="width:20%"><?php echo $row['SaleMaster_InvoiceNo'] ?></td>
                          <td style="width:20%;text-align:right;"><?php echo number_format($row['SaleMaster_SubTotalAmount'], 2); ?></td>
                          <td style="width:20%;text-align:right;"><?php echo number_format($row['SaleMaster_PaidAmount'], 2); ?></td>
                          <td style="width:20%;text-align:right;"><?php echo number_format($row['SaleMaster_DueAmount'], 2); ?></td>
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

