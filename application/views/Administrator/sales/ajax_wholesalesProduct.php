<?php  
$procode = $Product['Product_Code'];
$sqq = mysql_query("SELECT tbl_package_create.*, tbl_package.* FROM tbl_package_create left join tbl_package on tbl_package.package_ProCode = tbl_package_create.create_pacageID WHERE tbl_package_create.create_pacageID = '$procode' group by tbl_package_create.create_ID");
        $packagname = ""; 
        $packagprice = ""; 
        $pacName ="";
        $pacNamex = "";
        $sqpx = mysql_query("SELECT * FROM tbl_package_create WHERE create_proCode = '$procode'");
        while($royx = mysql_fetch_array($sqpx)){ 
             $pacNamex = $royx['create_pacageID'];?>
            <input type="hidden" name="packPrice[]" id="packaPrices" value="<?php echo $royx['create_sell_price']; ?>">
        <?php }
        $sqp = mysql_query("SELECT * FROM tbl_package WHERE package_ProCode = '$pacNamex'");
        $roy = mysql_fetch_array($sqp);
        $pacName = $roy['package_name'];
        $j="";
        $sqpy = mysql_query("SELECT * FROM tbl_package_create WHERE create_pacageID = '$procode'");
        while($roy = mysql_fetch_array($sqpy)){ $j++;?>
          
          <input type="hidden" name="itemname[]" id="itemname<?php echo $j?>" value="<?php echo $roy['create_item']; ?>">
        <?php }

    while($rom = mysql_fetch_array($sqq)){
       $pcode = $rom['create_proCode'];
        $packagname = $rom['package_name'];
        $pacageID = $rom['create_pacageID'];
        
        if(!empty($packagname)){    
            $ssq = mysql_query("SELECT * FROM tbl_product WHERE Product_Code = '$pcode'");
           while($rxx = mysql_fetch_array($ssq)){
            $proid = $rxx['Product_SlNo'];
            //=============================================
            $sql = mysql_query("SELECT * FROM tbl_purchasedetails WHERE Product_IDNo = '$proid'");
            $stock = "";
            while($orw = mysql_fetch_array($sql)){
                $stock = $stock+ $orw['Pack_qty'];
            } 
            $sqll = mysql_query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '$proid'");
            $rox = mysql_fetch_array($sqll);
            
            $curentstock = $stock - $rox['SaleInventory_qty'];
            $curentstock = $curentstock+ $rox['SaleInventory_returnqty'];

            $sqlss = mysql_query("SELECT * FROM tbl_purchaseinventory WHERE purchProduct_IDNo = '$proid'");
            $roxx = mysql_fetch_array($sqlss);
            $returnQty = $roxx['PurchaseInventory_returnqty'];
            $damageQty = $roxx['PurchaseInventory_DamageQuantity'];
            $curentstock = $curentstock+$returnQty;
            $curentstock = $curentstock-$damageQty;
             $curentstock = $curentstock.",";
           }
        }
      

    }
    if(isset($curentstock)){
        $curentstock = trim($curentstock,",");
 $packagprice = trim($packagprice, ",");
 $list = array($curentstock);
$bulbstock = min($list); 
    }
    
?>
<input type="hidden" id="packagecode" value="<?php echo $procode; ?>">
<input type="hidden" id="packagename" value="<?php echo $packagname; ?>">
<input type="hidden" id="packaNaMe" value="<?php if(isset($pacName)) echo $pacName; ?>">

<table>
    <tr>
        <td style="width:100px">Name</td>
        <td style="width:200px">
            <div class="full clearfix">
                <input type="text" id="proName" class="inputclass" value="<?php echo $Product['Product_Name'] ?>">
            </div>
        </td>
    </tr>
    <tr>
        <td>Quantity</td>
        <td style="width:200px">
            <div class="full clearfix">
                <input type="number" id="proQTY" name="proQTY" autofocus onkeyup="keyUPAmount()" class="inputclass" value="" placeholder="0">
            </div>
        </td>
    </tr>
    <tr>
        <td>Rate</td>
        <td style="width:200px">
            <div class="full clearfix">
                <input type="number" id="ProRATe" onkeyup="keyupamount2()" class="inputclass" value="<?php echo $Product['Product_WholesaleRate'] ?>">
                <input type="hidden" id="ProPurchaseRATe" value="<?php echo $Product['Product_Purchase_Rate'] ?>">
            </div>
        </td>
    </tr>
    <tr>
        <td>Amount</td>
        <td style="width:200px">
            <div class="full clearfix">
                <input type="number" id="ProductAmont" class="inputclass" value="" readonly="">
            </div>
        </td>
    </tr>
</table>


<?php 
$branchID = $this->session->userdata("BRANCHid"); 
$pid = $Product['Product_SlNo'];
$sql = mysql_query("SELECT * FROM tbl_purchasedetails WHERE Product_IDNo = '$pid' AND PurchaseDetails_branchID = '$branchID'");
$stock = "";
while($orw = mysql_fetch_array($sql)){
    $stock = $stock+ $orw['PurchaseDetails_TotalQuantity'];
} 
$sqll = mysql_query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '$pid' AND SaleInventory_brunchid = '$branchID'");
$rox = mysql_fetch_array($sqll);
$curentstock = $stock - $rox['SaleInventory_TotalQuantity'];
$curentstock += $rox['SaleInventory_ReturnQuantity'];
$sqlss = mysql_query("SELECT * FROM tbl_purchaseinventory WHERE purchProduct_IDNo = '$pid' AND PurchaseInventory_brunchid = '$branchID'");
$roxx = mysql_fetch_array($sqlss);
$returnQty = $roxx['PurchaseInventory_ReturnQuantity'];
$damageQty = $roxx['PurchaseInventory_DamageQuantity'];
$curentstock = $curentstock-$returnQty;
$curentstock = $curentstock-$damageQty;
?>
<center>
<?php if(!empty($packagname)){ ?>
    <input type="hidden" id="STock" value="<?php echo $bulbstock; ?>">
    <?php }else {?>
    <input type="hidden" id="STock" value="<?php if(isset($curentstock)) {echo $curentstock;} ?>">
    <?php } ?>
    <input type="hidden" id="unitPro" value="<?php echo $Product['Unit_Name']; ?>">  
</center>


