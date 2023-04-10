

<div class="" style="height:500px;overflow:auto;">

    <table class="border" cellspacing="0" cellpadding="0" width="80%">

        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>profitLossPrint/<?php echo $ProductID; ?>', 'newwindow', 'width=850, height=700,scrollbars=yes'); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a></h4>
        <tr>
            <td colspan="10" style="height:30px;text-align:center;"><strong>Profit and Loss</strong></td>
        </tr>
        <tr style="background:#ccc;">
            <th style="text-align:center;">SL NO.</th>
            <th style="text-align:center;">Product Name</th>
            <!--<th style="text-align:center;">Purchase Qty</th>
            <th style="text-align:center;">P.Return Qty</th>
            <th style="text-align:center;">Damaged Qty</th>
            <th style="text-align:center;">Sold Qty</th>
            <th style="text-align:center;">S.Return Qty</th>-->
			<th style="text-align:center;">Sold Qty</th>
            <th style="text-align:center;">Purchase Amount</th>
            <th style="text-align:center;">Sale Amount</th>
			<th style="text-align:center;">Damage Amount</th>
            <th style="text-align:center;">Loss & Profit</th>
            <th style="text-align:center;">Current Qty</th>
            <th style="text-align:center;">Current Amount</th>
        </tr>

        <?php 
        $purchaseAverageRate='';
        $purchaseReturnAmount='';
        $purchaseTotalAmount='';
        $DamagedAmount='';
        $saleTotalAmount='';
        $saleAverageRate='';
        $saleReturnAmount='';
        $LossProfit='';
        $currentAmount='';
		$current = '';
		$saleQuantity = '';
		
		$BRANCHid=$this->session->userdata('BRANCHid');
			
			if($ProductID == 'All'){
				$Psql = $this->db->query("select tbl_product.*, tbl_purchaseinventory.*, tbl_saleinventory.* FROM tbl_product left join tbl_purchaseinventory on tbl_purchaseinventory.purchProduct_IDNo=tbl_product.Product_SlNo left join tbl_saleinventory on tbl_saleinventory.sellProduct_IdNo=tbl_product.Product_SlNo where tbl_product.Product_branchid='$BRANCHid' order by tbl_product.Product_Name ASC");
			}else{
				$Psql = $this->db->query("select tbl_product.*, tbl_purchaseinventory.*, tbl_saleinventory.* FROM tbl_product left join tbl_purchaseinventory on tbl_purchaseinventory.purchProduct_IDNo=tbl_product.Product_SlNo left join tbl_saleinventory on tbl_saleinventory.sellProduct_IdNo=tbl_product.Product_SlNo where tbl_product.Product_SlNo='$ProductID'");	
			}
			$product = $Psql->result();
			$i = 1;
			foreach($product as $product)
			{
				$ProductID = $product->Product_SlNo;
				$current = $product->PurchaseInventory_TotalQuantity - ($product->PurchaseInventory_ReturnQuantity+$product->PurchaseInventory_DamageQuantity+$product->SaleInventory_TotalQuantity) + $product->SaleInventory_ReturnQuantity;
				
				$psql = $this->db->query("SELECT tbl_purchasedetails.*, tbl_product.* FROM tbl_purchasedetails LEFT JOIN tbl_product ON tbl_product.Product_SlNo = tbl_purchasedetails.Product_IDNo WHERE tbl_purchasedetails.Product_IDNo = '$ProductID'");
				$prow = $psql->result();
				//echo "<pre>";print_r($prow);//exit;
				foreach($prow as $prow){
					$purchaseTotalAmount = $purchaseTotalAmount+($prow->PurchaseDetails_Rate*$prow->PurchaseDetails_TotalQuantity); 
				}
				@$purchaseAverageRate = $purchaseTotalAmount/$product->PurchaseInventory_TotalQuantity;
				$purchaseReturnAmount = $purchaseAverageRate*$product->PurchaseInventory_ReturnQuantity;
				$DamagedAmount = $purchaseAverageRate*$product->PurchaseInventory_DamageQuantity;
				
				$ssql = $this->db->query("SELECT tbl_saledetails.*, tbl_product.* FROM tbl_saledetails LEFT JOIN tbl_product ON tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo WHERE tbl_saledetails.Product_IDNo = '$ProductID'");
				$srow = $ssql->result();
				foreach($srow as $srow){
					$saleTotalAmount = $saleTotalAmount + ($srow->SaleDetails_Rate*$srow->SaleDetails_TotalQuantity); 
				}
				@$saleAverageRate = $saleTotalAmount/$product->SaleInventory_TotalQuantity;
				$saleReturnAmount = $saleAverageRate*$product->SaleInventory_ReturnQuantity;
				//$saleTotalAmount = $saleTotalAmount - $saleReturnAmount;
				
				$saleQuantity = $product->SaleInventory_TotalQuantity-$product->SaleInventory_ReturnQuantity;
				$purchaseTotalAmount = $purchaseAverageRate*$saleQuantity;
				$saleTotalAmount = $saleAverageRate*$saleQuantity;
				
				$LossProfit = $saleTotalAmount - ($purchaseTotalAmount+$DamagedAmount);
				$currentAmount = $purchaseAverageRate * $current;
			?>
				<tr style="text-align:center;">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $product->Product_Name; ?></td>
                    
					<!--<td><?php //echo $product->PurchaseInventory_TotalQuantity; ?></td>
                    <td><?php //echo $product->PurchaseInventory_ReturnQuantity; ?></td>
                    <td><?php //echo $product->PurchaseInventory_DamageQuantity; ?></td>
                    <td><?php //echo $product->SaleInventory_TotalQuantity; ?></td>
                    <td><?php //echo $product->SaleInventory_ReturnQuantity; ?></td>-->
					
					
					<td><?php echo $saleQuantity; ?></td>
					<td><?php echo round($purchaseTotalAmount,2); ?></td>
					<td><?php echo round($saleTotalAmount,2); ?></td>
					<td><?php echo round($DamagedAmount,2); ?></td>
					<td><?php echo round($LossProfit,2); ?></td>
                    <td><?php echo $current; ?></td>
                    <td><?php echo round($currentAmount,2); ?></td>
                </tr>
				<?php
				$purchaseAverageRate='';
				$purchaseReturnAmount='';
				$purchaseTotalAmount='';
				$DamagedAmount='';
				$saleTotalAmount='';
				$saleAverageRate='';
				$saleReturnAmount='';
				$LossProfit='';
				$currentAmount='';
				$current = '';
				$saleQuantity = '';
			}
		?>
    </table>
</div>