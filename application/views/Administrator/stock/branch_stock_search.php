<?php 
//echo "<pre>";print_r($category);exit;
if($show==1){ ?>
<br/>
<table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:100%;border-collapse:collapse;">
     <thead>
        <tr  style="background:#fff;">
        <th style="width:100%;text-align:center;color:#000;font-size:16px;letter-spacing:2px;" colspan="7">Branch Stock</th>
	 </tr>
	 
         <tr style="background:#f4f4f4;">
              <th style="width:10%;color:#000;">SL. No</th>
             <th style="width:15%;color:#000;">Category</th>
             <th style="width:20%;color:#000;">Product Name</th>                                                         
             <th style="width:15%;color:#000;">Brand</th>   
             <th style="width:15%;color:#000;">Color</th>                                                                                                                              
             <th style="width:10%;color:#000;">Current Stock</th>                                                               
             <th style="width:10%;color:#000;">Unit</th>                                                               
        </tr>
      </thead>
	<tbody>
<?php 
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
                <td><?php echo $product->Product_Code; ?></td>
                <td><?php echo $product->ProductCategory_Name; ?></td>
                <td><?php echo $product->Product_Name; ?></td>
                <td><?php echo $product->brand_name; ?></td>
                <td><?php echo $product->color_name; ?></td>
                <td><?php echo $curentstock; ?></td>
				<td><?php echo $product->Unit_Name; ?></td>
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
<table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:100%;border-collapse:collapse;">
     <thead>
	 <tr  style="background:#fff;">
        <th style="width:100%;text-align:center;color:#000;font-size:16px;letter-spacing:2px;" colspan="7">Branch Stock</th>
	 </tr>
	 
         <tr style="background:#f4f4f4;">
             <th style="width:10%;color:#000;">SL. No</th>
             <th style="width:15%;color:#000;">Category</th>
             <th style="width:20%;color:#000;">Product Name</th>                                                         
             <th style="width:15%;color:#000;">Brand</th>   
             <th style="width:15%;color:#000;">Color</th>                                                                                                                              
             <th style="width:10%;color:#000;">Current Stock</th>                                                               
             <th style="width:10%;color:#000;">Unit</th>                                                               
        </tr>
      </thead>
	<tbody>
<?php //echo "<pre>";print_r($product);
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
                <td><?php echo $product->Product_Code; ?></td>
                <td><?php echo $product->ProductCategory_Name; ?></td>
                <td><?php echo $product->Product_Name; ?></td>
                <td><?php echo $product->brand_name; ?></td>
                <td><?php echo $product->color_name; ?></td>
                <td><?php echo $curentstock; ?></td>
				<td><?php echo $product->Unit_Name; ?></td>
            </tr>
<?php 
				}
			}
		}	
	}
	
}

?>
	</tbody>  
</table> 
