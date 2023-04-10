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

<br/>
<br/>
<table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:800;">
        <tr>
          <td align="left" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;margin-left:30px;" /></td>
          <td align="center" width="650">
				<p style=""><strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
				<?php echo $branch_info->Repot_Heading; ?><br/></p>
          </td>
        </tr>
</table>
<table class="zebra" cellspacing="0" cellpadding="0" border="0" style="width:700;">
	<tr>
	  <td></td><br/><hr>
	</tr>
</table>

<table class="border" cellspacing="0" cellpadding="0" width="92%">
        <tr>
            <td colspan="8" align="center"><h2>Current Stock</h2></td>
        </tr>
        
        <?php 
        $totalqty = 0;$sellTOTALqty = 0; $subtotal = 0;
        $SaleInventory_DamageQuantity=0; $PID = "";
        $SaleInventory_ReturnQuantity=0;
        $currentQuantity=0;
        $lessQuantity=0;
        $i=1;
            
         if($all == 'All'):
        foreach($brandDistinct as $brd){ 
        ?>
            <tr><td colspan="7" style="border: #fff;"></td></tr>
            <tr style=" background:#C1ECE8; margin-top: 3px; ">
                <td colspan="8" style="height: 30px; font-size: 15px; font-weight: bold; text-align: center; line-height: 30px;">
                    <?php
                    if($brd->ProductCategory_ID > 0):
                        echo $this->db->where('ProductCategory_SlNo',$brd->ProductCategory_ID)->get('tbl_productcategory')->row()->ProductCategory_Name;
                    endif;
                    ?>
                </td>
            </tr>
                <tr style="background:#ccc;">
                <th style="text-align:center;">SL. NO</th>
                <th style="text-align:center;">Product Name</th>
                <!-- <th style="text-align:center;">Brand</th> -->
                <!-- <th style="text-align:center;">Product Name</th> -->
                <th style="text-align:center;">Qty</th>
                <!--<th style="text-align:center;">1 Box</th>--->
                <th style="text-align:center;">Current Pur. Price</th>
                <th style="text-align:center;">Ave. Purchase Price</th>
                <th style="text-align:center;">Total Price</th>
                <th style="text-align:center;">Unit</th>
            </tr>
        <?php

        foreach($recordData as $record){
            $sellTOTALqty = 0;
                $PID = $record->purchProduct_IDNo;
                // Sell qty
                $sqq = $this->db->query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '$PID' AND SaleInventory_brunchid = '$branchID'");
                $or = $sqq->row();
                if($sqq->num_rows() > 0){
                    $sellTOTALqty = $or->SaleInventory_TotalQuantity;
                    //$SaleInventory_DamageQuantity = $or->SaleInventory_DamageQuantity;
                    $SaleInventory_ReturnQuantity = $or->SaleInventory_ReturnQuantity;
                }
                
                $lessQuantity = $record->PurchaseInventory_ReturnQuantity+$record->PurchaseInventory_DamageQuantity+$sellTOTALqty;
                 
                $currentQuantity =  $record->PurchaseInventory_TotalQuantity - $lessQuantity ;
                 
               $totalqty = $currentQuantity + $SaleInventory_ReturnQuantity;
                if($totalqty != 0){
                    //$rate = $totalqty*$record->Product_Purchase_Rate;
                    //$subtotal = $subtotal+$rate;
                    
                    
                    $totalPurchasePrice = 0;
                    $averagePurchasePrice = 0;
                    $pdsql = $this->db->query("SELECT * FROM tbl_purchasedetails WHERE Product_IDNo = '$PID'");
                    $pdrow = $pdsql->result();
                    foreach($pdrow as $pdrow){
                        $productPrice = $pdrow->PurchaseDetails_Rate*$pdrow->PurchaseDetails_TotalQuantity; 
                        $totalPurchasePrice = $totalPurchasePrice+$productPrice;
                    }
                    $averagePurchasePrice = $totalPurchasePrice/$record->PurchaseInventory_TotalQuantity;
                    

                  

                if($brd->ProductCategory_ID == $record->ProductCategory_ID) :
                    $rate = $totalqty*$averagePurchasePrice;
                    $subtotal = $subtotal + $rate;
                ?>

             <?php //endif; ?>
                <tr style="text-align:center;">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $record->Product_Name; ?></td>
                    <?php
                        if($record->Product_ReOrederLevel > $totalqty){
                    ?>
                    <td style="background-color:red;"><?php echo $totalqty; ?></td>
                    <?php
                        }else{
                    ?>
                    <td><?php echo $totalqty; ?></td>
                    <?php
                        }
                    ?>
                    <!--<td><?php //echo $record['one_cartun_equal']; ?></td>-->
                    <td><?php echo $record->Product_Purchase_Rate; ?></td>
                    <td><?php echo number_format($averagePurchasePrice, 2); ?></td>
                    <td><?php echo number_format($rate, 2); ?></td>
                    <td><?php if($record->PurchaseDetails_Unit == ""){echo "pcs";} else{echo $record->PurchaseDetails_Unit; }?></td>
                </tr>
        <?php //else: ?>
        <!-- break -->
        <?php endif; }}} else: ?>


         </tr>
            <tr style="background:#ccc;">
            <th style="text-align:center;">SL. NO</th>
            <th style="text-align:center;">Product Name</th>
            <!-- <th style="text-align:center;">Brand</th> -->
            <th style="text-align:center;">Qty</th>
            <!--<th style="text-align:center;">1 Box</th>--->
            <th style="text-align:center;">Current Pur. Price</th>
            <th style="text-align:center;">Ave. Purchase Price</th>
            <th style="text-align:center;">Total Price</th>
            <th style="text-align:center;">Unit</th>
        </tr>

        <?php
        foreach($recordData as $record){
            $sellTOTALqty = 0;
                $PID = $record->purchProduct_IDNo;
                // Sell qty
                $sqq = $this->db->query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '$PID' AND SaleInventory_brunchid = '$branchID'");
                $or = $sqq->row();
                if($sqq->num_rows() > 0){
                    $sellTOTALqty = $or->SaleInventory_TotalQuantity;
                    //$SaleInventory_DamageQuantity = $or->SaleInventory_DamageQuantity;
                    $SaleInventory_ReturnQuantity = $or->SaleInventory_ReturnQuantity;
                }
                
                $lessQuantity = $record->PurchaseInventory_ReturnQuantity+$record->PurchaseInventory_DamageQuantity+$sellTOTALqty;
                 
                $currentQuantity =  $record->PurchaseInventory_TotalQuantity - $lessQuantity ;
                 
               $totalqty = $currentQuantity + $SaleInventory_ReturnQuantity;
                if($totalqty != 0){
                    //$rate = $totalqty*$record->Product_Purchase_Rate;
                    //$subtotal = $subtotal+$rate;
                    
                    
                    $totalPurchasePrice = 0;
                    $averagePurchasePrice = 0;
                    $pdsql = $this->db->query("SELECT * FROM tbl_purchasedetails WHERE Product_IDNo = '$PID'");
                    $pdrow = $pdsql->result();
                    foreach($pdrow as $pdrow){
                        $productPrice = $pdrow->PurchaseDetails_Rate*$pdrow->PurchaseDetails_TotalQuantity; 
                        $totalPurchasePrice = $totalPurchasePrice+$productPrice;
                    }
                    $averagePurchasePrice = $totalPurchasePrice/$record->PurchaseInventory_TotalQuantity;
                    
                    $rate = $totalqty*$averagePurchasePrice;
                    $subtotal = $subtotal + $rate;

                  
                ?>
                <tr style="text-align:center;">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $record->Product_Name; ?></td>
                    <?php
                        if($record->Product_ReOrederLevel > $totalqty){
                    ?>
                    <td style="background-color:red;"><?php echo $totalqty; ?></td>
                    <?php
                        }else{
                    ?>
                    <td><?php echo $totalqty; ?></td>
                    <?php
                        }
                    ?>
                    <!--<td><?php //echo $record['one_cartun_equal']; ?></td>-->
                    <td><?php echo $record->Product_Purchase_Rate; ?></td>
                    <td><?php echo number_format($averagePurchasePrice, 2); ?></td>
                    <td><?php echo number_format($rate, 2); ?></td>
                    <td><?php if($record->PurchaseDetails_Unit == ""){echo "pcs";} else{echo $record->PurchaseDetails_Unit; }?></td>
                </tr>
        <?php  } } endif; ?>






        <tr style="text-align:center;">
           <!--  <td style="border:0px"></td> -->
            <td style="border:0px"></td>
            <td style="border:0px"></td>
            <td style="border:0px"></td>
            <td style="border:0px"></td>
            <td><strong>Sub Total:</strong> </td>
            <td><strong><?php echo number_format($subtotal, 2); ?> Tk</strong></td>
            <td style="border:0px"></td>
        </tr>
       
    </table>