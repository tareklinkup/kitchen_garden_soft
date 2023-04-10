<?php
$brunch=$this->session->userdata('Branch_ID');
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

<br/>
<table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:800;">
        <tr>
		<td style="width:150px;">
			 <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $row['Company_Logo_org']; ?>" alt="Logo" style="width:130px;float:right;">
		</td>
		
          <td style="float:left;width:650px;">
            <div class="headline">
				<div style="text-align:center" >
					<strong style="font-size:18px"><?php echo $row['Company_Name']; ?></strong><br>
					<?php echo $row['Repot_Heading']; ?><br>
				</div>
			</div>
          </td>
        </tr>
</table>
<?php 
//echo "<pre>";print_r($category);exit;
if($show==1){ ?>
<table class="zebra" cellspacing="0" cellpadding="0" border="1" id="" style="width:800;">
     <thead>
		<tr  style="background:#fff;">
			<th style="width:100%;text-align:center;color:#000;font-size:16px;letter-spacing:2px;height:30px;" colspan="8">Branch Stock</th>
		</tr>

         <tr style="background:#f4f4f4;height:35px;">
             <th style="width:10%;color:#000;">SL No</th>
             <th style="width:10%;color:#000;">Product Code</th>
             <th style="width:15%;color:#000;">Category</th>
             <th style="width:20%;color:#000;">Product Name</th>                                                         
             <th style="width:10%;color:#000;">Brand</th>   
             <th style="width:10%;color:#000;">Color</th>                                                                                                                              
             <th style="width:10%;color:#000;">Current Stock</th>                                                               
             <th style="width:10%;color:#000;">Unit</th>                                                               
        </tr>
      </thead>
	<tbody>
<?php 
$i=1;
	foreach($product as $product)
	{ 	$stock = "";
		$curentstock = "";
		$returnQty = "";
		$damageQty = "";
		
			$proid = $product->Product_SlNo;
			$sql = mysql_query("SELECT * FROM tbl_purchasedetails WHERE Purchasedetails_store='$Branch_ID' AND  Product_IDNo = '$proid'");
            while($orw = mysql_fetch_array($sql)){
                $stock = $stock + $orw['PurchaseDetails_TotalQuantity'];
            } 

            $sqll = mysql_query("SELECT * FROM tbl_saleinventory WHERE SaleInventory_Store='$Branch_ID' AND  sellProduct_IdNo = '$proid'");
            $rox = mysql_fetch_array($sqll);
            
            $curentstock = $stock - $rox['SaleInventory_TotalQuantity'];
            $curentstock = $curentstock + $rox['SaleInventory_returnqty'];
			
            $sqlss = mysql_query("SELECT * FROM tbl_purchaseinventory WHERE PurchaseInventory_Store = '$Branch_ID' AND  purchProduct_IDNo = '$proid'");
            $roxx = mysql_fetch_array($sqlss);
            $returnQty = $roxx['PurchaseInventory_returnqty'];
            $damageQty = $roxx['PurchaseInventory_DamageQuantity'];
            $curentstock = $curentstock-$returnQty+$damageQty;
            //$curentstock = $curentstock-$damageQty;
            //$curentstock = $curentstock.",";
			
			  if(isset($curentstock)){
			 $curentstock = trim($curentstock,",");
			 //$packagprice = trim($packagprice, ",");
			 $list = array($curentstock);
			 $bulbstock = min($list); 
			 } 
			 ?>
			<tr>
                <td style="text-align:center;height:25px;"><?php echo $i++; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->Product_Code; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->ProductCategory_Name; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->Product_Name; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->brand_name; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->color_name; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $curentstock; ?></td>
				<td style="text-align:center;height:25px;"><?php echo $product->Unit_Name; ?></td>
            </tr>
			 <?php
		}
 ?>
	</tbody>  
</table> 
<?php }elseif($show == 0){ 
//echo "<pre>"; print_r($productCat);exit;
?>
<br/>
<table class="zebra" cellspacing="0" cellpadding="0" border="1" id="" style="width:800px;">
     <thead>
	 <tr  style="background:#fff;">
        <th style="width:100%;text-align:center;color:#000;font-size:16px;letter-spacing:2px;height:30px;" colspan="8">Branch Stock</th>
	 </tr>
	 
         <tr style="background:#f4f4f4;height:35px;">
             <th style="width:10%;color:#000;">SL No</th>
             <th style="width:10%;color:#000;">Product Code</th>
             <th style="width:15%;color:#000;">Category</th>
             <th style="width:20%;color:#000;">Product Name</th>                                                         
             <th style="width:10%;color:#000;">Brand</th>   
             <th style="width:10%;color:#000;">Color</th>                                                                                                                              
             <th style="width:10%;color:#000;">Current Stock</th>                                                               
             <th style="width:10%;color:#000;">Unit</th>                                                               
        </tr>
      </thead>
	<tbody>
<?php //echo "<pre>";print_r($product);
$i=1;
	foreach($category as $vcategory)
	{ 	
		foreach($productCat as $v){
			foreach($v as $product){
				if($vcategory->ProductCategory_SlNo == $product->ProductCategory_ID){
			$stock = "";
			$curentstock = "";
			$returnQty = "";
			$damageQty = "";
		//echo $product->ProductCategory_ID.'='.$vcategory->ProductCategory_SlNo.'<br>';
			$proid = $product->Product_SlNo;
			$sql = mysql_query("SELECT * FROM tbl_purchasedetails WHERE Purchasedetails_store='$Branch_ID' AND  Product_IDNo = '$proid'");
            while($orw = mysql_fetch_array($sql)){
                $stock = $stock + $orw['PurchaseDetails_TotalQuantity'];
            } 

            $sqll = mysql_query("SELECT * FROM tbl_saleinventory WHERE SaleInventory_Store='$Branch_ID' AND  sellProduct_IdNo = '$proid'");
            $rox = mysql_fetch_array($sqll);
            
            $curentstock = $stock - $rox['SaleInventory_TotalQuantity'];
            $curentstock = $curentstock + $rox['SaleInventory_returnqty'];
			
            $sqlss = mysql_query("SELECT * FROM tbl_purchaseinventory WHERE PurchaseInventory_Store = '$Branch_ID' AND  purchProduct_IDNo = '$proid'");
            $roxx = mysql_fetch_array($sqlss);
            $returnQty = $roxx['PurchaseInventory_returnqty'];
            $damageQty = $roxx['PurchaseInventory_DamageQuantity'];
            $curentstock = $curentstock-$returnQty+$damageQty;
            //$curentstock = $curentstock-$damageQty;
            //$curentstock = $curentstock.",";
			
			  if(isset($curentstock)){
			 $curentstock = trim($curentstock,",");
			 //$packagprice = trim($packagprice, ",");
			 $list = array($curentstock);
			 $bulbstock = min($list); 
			 } 		
?>
			<tr>
                <td style="text-align:center;height:25px;"><?php echo $i++; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->Product_Code; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->ProductCategory_Name; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->Product_Name; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->brand_name; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $product->color_name; ?></td>
                <td style="text-align:center;height:25px;"><?php echo $curentstock; ?></td>
				<td style="text-align:center;height:25px;"><?php echo $product->Unit_Name; ?></td>
            </tr>
<?php 
				}
			}
		}	
	}
	
}

$this->session->unset_userdata('Branch_ID');
$this->session->unset_userdata('Branch_category');
?>
	</tbody>  
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

