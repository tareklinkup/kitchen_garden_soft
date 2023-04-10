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
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Branch Stock <br>
            <?php
              $BranchID = $this->session->userdata("BranchID");
              $SB = mysql_query("SELECT * FROM tbl_brunch WHERE brunch_id = '$BranchID'");
            $BROW = mysql_fetch_array($SB);
            echo 'Branch Name : ' . $BROW['Brunch_name'];
            ?>
            </h2></td>
        </tr>
        <tr>
            <td>
            <!-- Page Body -->
          
              <table class="border" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <th>Product Name</th>
                  <th>Qty</th>
                  <th>Purchase Price</th>
                  <th>Total Price</th>
                  <th>Unit</th>
                </tr>
              <?php 
              $totalqty = 0;$sellTOTALqty = 0; $subtotal = 0;
              $Store = $this->session->userdata("Store");
              $sql = mysql_query("SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_purchasedetails.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo = tbl_purchaseinventory.purchProduct_IDNo left join tbl_purchasedetails on tbl_purchasedetails.Product_IDNo = tbl_product.Product_SlNo WHERE tbl_purchaseinventory.PurchaseInventory_Store='$Store' AND  tbl_purchaseinventory.PurchaseInventory_brunchid = '$BranchID' group by tbl_purchasedetails.Product_IDNo");
              while($record = mysql_fetch_array($sql)){
            
                $totalqty = $record['PurchaseInventory_TotalQuantity'] -$record['PurchaseInventory_ReturnQuantity'];
                $totalqty = $totalqty-$record['PurchaseInventory_DamageQuantity'];
                
                $PID = $record['purchProduct_IDNo'];
                // Sell qty
                $sqq = mysql_query("SELECT * FROM tbl_saleinventory WHERE SaleInventory_Store='$Store' AND  sellProduct_IdNo = '$PID' AND SaleInventory_brunchid = '$BranchID'");
                $or = mysql_fetch_array($sqq);
                if($or['SaleInventory_packname'] ==""){
                $sellTOTALqty = $or['SaleInventory_TotalQuantity'];
               
                $sellTOTALqty = $sellTOTALqty-$or['SaleInventory_DamageQuantity'];
                $totalqty = $totalqty -$sellTOTALqty+$or['SaleInventory_ReturnQuantity'];
                if($totalqty !="0"){
                    $rate = $totalqty*$record['PurchaseDetails_Rate'];
                    $subtotal = $subtotal+$rate;
                ?>
                <tr>
                    <td><?php echo $record['Product_Name'] ?></td>
                    <?php
                        if($record['Product_ReOrederLevel'] > $totalqty){
                    ?>
                    <td style="background-color:red;"><?php echo $totalqty; ?></td>
                    <?php
                        }else{
                    ?>
                    <td><?php echo $totalqty; ?></td>
                    <?php
                        }
                    ?>
                    <td><?php echo $record['PurchaseDetails_Rate']; ?></td>
                    <td><?php echo $rate ?></td>
                    <td><?php if($record['PurchaseDetails_Unit']==""){echo "pcs";} else{echo $record['PurchaseDetails_Unit']; }?></td>
                </tr>
        <?php } } }?>
                <tr>
                    <td style="border:0px"></td>
                    <td style="border:0px"></td>
                    <td><strong>Sub Total:</strong> </td>
                    <td><strong><?php echo $subtotal ?> Tk</strong></td>
                    <td style="border:0px"></td>
                </tr>
              </table>
            </td>
            <!-- Page Body end -->
       
    </table>
    </td>
  </tr>
  
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

