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
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Cash View</h2></td>
        </tr>
        <tr>
            <td>
            <!-- Page Body -->
          
              <table class="border" cellspacing="0" cellpadding="0" width="100%">
                <tr >
                  <th>Account Name</th>
                  <th>Description</th>
                  <th>In Amount</th>                      
                  <th>Out Amount</th> 
                </tr>
                <?php
        $in="";$out="";
        foreach($record as $row){ 
            $in=$in+$row['In_Amount'];
            $out=$out+$row['Out_Amount'];
            ?>
        <tr>
            <td><?php echo $row['Acc_Name'] ?></td>
            <td><?php echo $row['Tr_Description'] ?></td>
            <td><?php if($row['In_Amount']==""){echo "0";}else{ echo $row['In_Amount'];} ?></td>
            <td><?php if($row['Out_Amount']==""){echo "0";}else{ echo $row['Out_Amount'];} ?></td>
        </tr>
        <?php } 
        $expence_startdate = $this->session->userdata('expence_startdate');
        $expence_enddate = $this->session->userdata('expence_enddate');
        $purchase = "";
        $sql = mysql_query("SELECT * FROM tbl_purchasemaster ");
        while($roof = mysql_fetch_array($sql)){
            $purchase =$purchase+$roof['PurchaseMaster_PaidAmount'];
        
        }?>
         <tr>
            <td>Purchase</td>
            <td>Purducts</td>
            <td>0</td>
            <td><?php echo $purchase; ?></td>
        </tr>
        <?php  
        $expence_startdate = $this->session->userdata('expence_startdate');
        $expence_enddate = $this->session->userdata('expence_enddate');
        $sell = "";
        $sql = mysql_query("SELECT * FROM tbl_salesmaster");
        while($roof = mysql_fetch_array($sql)){
            $sell =$sell+$roof['SaleMaster_PaidAmount'];
        
        }?>
        <tr>
            <td>Sales</td>
            <td>Purducts</td>
            <td><?php echo $sell; ?></td>
            <td>0</td>
        </tr>
        <?php $totalreturn = "";
            $sqlx = mysql_query("SELECT * FROM tbl_salereturn");
            while($rom = mysql_fetch_array($sqlx)){
                $totalreturn = $totalreturn+$rom['SaleReturn_ReturnAmount'];
        }?>
        <tr>
            <td>Sales Return</td>
            <td>Purducts</td>
            <td>0</td>
            <td><?php echo $totalreturn; ?></td>
        </tr>
        <?php $totalreturnP = "";
            $sqlx = mysql_query("SELECT * FROM tbl_purchasereturn ");
            while($rom = mysql_fetch_array($sqlx)){
                $totalreturnP = $totalreturnP+$rom['PurchaseReturn_ReturnAmount'];
        }?>
        <tr>
            <td>Pruchase Return</td>
            <td>Purducts</td>
            <td><?php echo $totalreturnP; ?></td>
            <td>0</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><strong>Total</strong></td>
            <td><strong><?php echo $sell+$in+$totalreturnP; ?></strong></td>
            <td><strong><?php echo $purchase+$out+$totalreturn; ?></strong></td>
        </tr>
              </table>
            </td>
            <!-- Page Body end -->
       
    </table></td>
  </tr>
  
</table>

<div class="provied">
  
  <span style="float:left;font-size:11px;">
<i>"THANK YOU FOR YOUR BUSINESS"</i><br>
  Software Provied By Link-Up Technology</span>
</div>

</body>
</html>

