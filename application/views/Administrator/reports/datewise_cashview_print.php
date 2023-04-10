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
            <?php
              $BranchID = $this->session->userdata('BranchID');
              $CDate = $this->session->userdata('CDate');
              $SB = mysql_query("SELECT * FROM tbl_brunch WHERE brunch_id = '$BranchID'");
              $BROW = mysql_fetch_array($SB);
            ?>
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Datewise Cash View <br>
            Branch Name : <?php echo $BROW['Brunch_name']; ?>
            </h2></td>
        </tr>
        <tr>
            <td>
            <!-- Page Body -->
          
              <table class="border" cellspacing="0" cellpadding="0" width="100%">
                <tr >
                  <th>Account Name</th>
                  <th>In Amount</th>                      
                  <th>Out Amount</th> 
                </tr>
                <?php
                    

                    $sct = mysql_query("SELECT tbl_cashtransaction.*,tbl_account.* FROM tbl_cashtransaction left join tbl_account on tbl_account.Acc_SlNo=tbl_cashtransaction.Acc_SlID WHERE Tr_branchid = '$BranchID' AND Tr_date = '$CDate'");
                    $in="";$out="";
                    while($row = mysql_fetch_array($sct)){
                    $in=$in+$row['In_Amount'];
                    $out=$out+$row['Out_Amount'];
                    ?>
                  <tr>
                      <td><?php echo $row['Acc_Name'] ?></td>
                      <td><?php if($row['In_Amount']==""){echo "0";}else{ echo $row['In_Amount'];} ?></td>
                      <td><?php if($row['Out_Amount']==""){echo "0";}else{ echo $row['Out_Amount'];} ?></td>
                  </tr>
                  <?php } 
                  $sql = mysql_query("SELECT tbl_supplier_payment.*,tbl_supplier.* FROM tbl_supplier_payment left join tbl_supplier on tbl_supplier.Supplier_SlNo=tbl_supplier_payment.SPayment_customerID WHERE tbl_supplier_payment.SPayment_brunchid = '$BranchID' AND tbl_supplier_payment.SPayment_date = CURDATE()");
        while($roof = mysql_fetch_array($sql)){
            $out =$out+$roof['SPayment_amount'];
        ?>
        <tr>

            <td><?php echo $roof['Supplier_Name']; ?></td>
            <td>0</td>
            <td><?php echo $roof['SPayment_amount']; ?></td>
        </tr>
        <?php        
            }
        ?>
         
        <?php  
        $sql = mysql_query("SELECT tbl_customer_payment.*,tbl_customer.* FROM tbl_customer_payment left join tbl_customer on tbl_customer.Customer_SlNo=tbl_customer_payment.CPayment_customerID WHERE tbl_customer_payment.CPayment_brunchid = '$BranchID' AND tbl_customer_payment.CPayment_date = CURDATE()");
        while($roof = mysql_fetch_array($sql)){
            $in =$in+$roof['CPayment_amount'];
        ?>
        <tr>
            <td><?php echo $roof['Customer_Name']; ?></td>
            <td><?php echo $roof['CPayment_amount']; ?></td>
            <td>0</td>
        </tr>
        <?php
        }?>
        <?php 
            $sqlx = mysql_query("SELECT * FROM tbl_salereturn WHERE SaleReturn_brunchId = '$BranchID' AND SaleReturn_ReturnDate = '$CDate'");
            while($rom = mysql_fetch_array($sqlx)){
                $out = $out+$rom['SaleReturn_ReturnAmount'];
        ?>
        <tr>
            <td><?php echo $rom['SaleReturn_Description']; ?></td>
            <td>0</td>
            <td><?php echo $rom['SaleReturn_ReturnAmount']; ?></td>
        </tr>
        <?php
        }?>
        
        <?php 
            $sqlx = mysql_query("SELECT * FROM tbl_purchasereturn WHERE PurchaseReturn_brunchID = '$BranchID' AND PurchaseReturn_ReturnDate = '$CDate'");
            while($rom = mysql_fetch_array($sqlx)){
                $in = $in+$rom['PurchaseReturn_ReturnAmount'];
        ?>
        <tr>
            <td><?php echo $rom['PurchaseReturn_Description']; ?></td>
            <td><?php echo $rom['PurchaseReturn_ReturnAmount']; ?></td>
            <td>0</td>
        </tr>
        <?php
        }?>
        
        <tr>
            <td colspan="1" align="right"><strong>Total</strong></td>
            <td><strong><?php if($in){echo number_format($in, 2);}else{echo '0.00';} ?></strong></td>
            <td><strong><?php if($out){echo number_format($out, 2);}else{echo '0.00';} ?></strong></td>
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

