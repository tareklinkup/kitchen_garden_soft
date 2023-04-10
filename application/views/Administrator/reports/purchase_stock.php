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
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Purchase Stock</h2></td>
        </tr>
        <tr>
            <td>
            <!-- Page Body -->
          
              <table class="border" cellspacing="0" cellpadding="0" width="100%">
                <tr >
                  <th>Category</th>
                  <th>ID</th>
                  <th>Product Name</th>
                  <th>Purchase Qty</th>
                  <th>Return Qty</th>
                  <th>Damage Qty</th>
                  <th>Rate</th>
                  <th>Unit</th>
                </tr>
               <?php 
                $sql = mysql_query("SELECT tbl_purchaseinventory.*,tbl_product.*,tbl_unit.*,tbl_productcategory.* FROM tbl_purchaseinventory left join tbl_product on tbl_product.Product_SlNo= tbl_purchaseinventory.purchProduct_IDNo left join tbl_unit on tbl_unit.Unit_SlNo = tbl_product.Unit_ID left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo = tbl_product.ProductCategory_ID");
                while($record = mysql_fetch_array($sql)){
                    if($record['PurchaseInventory_packname']==""){?>
                <tr>
                    <td><?php echo $record['ProductCategory_Name'] ?></td>
                    <td><?php echo $record['Product_Code'] ?></td>
                    <td><?php echo $record['Product_Name'] ?></td>
                    <td><?php echo $record['PurchaseInventory_TotalQuantity'] ?></td>
                    <td><?php echo $record['PurchaseInventory_ReturnQuantity'] ?></td>
                    <td><?php echo $record['PurchaseInventory_DamageQuantity'] ?></td>
                    <td><?php echo $record['Product_Purchase_Rate'] ?></td>
                    <td><?php echo $record['Unit_Name'] ?></td>
                </tr>
                <?php }}?>
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
<div class="signature">
<span style="border-top:1px solid #000;">
  Authorize Signature
</span>
</div>
</body>
</html>

