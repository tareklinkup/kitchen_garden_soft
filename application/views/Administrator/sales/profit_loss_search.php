<div class="" style="height:500px;overflow:auto;">
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
		if($searchtype == 'Product'){ ?>
		<table class="border" cellspacing="0" cellpadding="0" width="80%">
        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>profitLossPrint', 'newwindow', 'width=850, height=700,scrollbars=yes'); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a></h4>
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
			if($ProductID == 'All'){
				$Psql = $this->db->query("select tbl_product.*, tbl_purchaseinventory.*, tbl_saleinventory.* FROM tbl_product left join tbl_purchaseinventory on tbl_purchaseinventory.purchProduct_IDNo=tbl_product.Product_SlNo left join tbl_saleinventory on tbl_saleinventory.sellProduct_IdNo=tbl_product.Product_SlNo where tbl_product.Product_branchid='$BRANCHid' AND tbl_product.status='a' order by tbl_product.Product_Name ASC");
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
			<?php
			}else{
				?>
			<table class="border" cellspacing="0" cellpadding="0" width="90%">
				<h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>profitLossPrint', 'newwindow', 'width=850, height=700,scrollbars=yes'); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i>Print</a></h4>
				<thead>
					<tr>
						<td colspan="9" valign="bottom" style="height:30px;text-align:center;border-bottom:0px;"><strong style="font-size:20px;letter-spacing:2px;">Profit and Loss</strong></td>
					</tr>
					
					<tr>
						<td colspan="9" style="text-align:right;border-top:0px;"><strong>From:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $startdate; ?> &nbsp;&nbsp;&nbsp;&nbsp; To:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $enddate; ?> </strong>&nbsp;&nbsp;&nbsp;&nbsp;</td>
					</tr>
					
					 <tr style="background:#ccc;" height="30">
						<th style="width:7%;text-align:center;">Invoice</th>
						<th style="width:8%;text-align:center;">Sale Date</th>
						<th style="width:10%;text-align:center;">Product ID</th>
						<th style="width:23%;text-align:center;">Product</th>
						<th style="width:7%;text-align:center;">Sale Qty</th>         
						<th style="width:10%;text-align:center;">Purchase Rate</th>         
						<th style="width:15%;text-align:center;">Purchase Total</th>         
						<th style="width:10%;text-align:center;">Sale Amount</th>         
						<th style="width:10%;text-align:center;">Profit/Loss</th>         
					</tr>
				</thead>
				<?php $Gtsale=0;  $Gtpur=0; $Gtpl =0;
				$invoicesql = $this->db->query("select `SaleMaster_SlNo`,`SaleMaster_InvoiceNo`,`SaleMaster_SaleDate` from tbl_salesmaster where SaleMaster_branchid='$BRANCHid' AND SaleMaster_SaleDate between '$startdate' AND '$enddate'");	
				$invoice = $invoicesql->result();
				foreach($invoice as $invoice){
				$SaleMaster_SlNo = $invoice->SaleMaster_SlNo;
				$i = 0;
				?>
				<tbody>
				<?php 
				$pdsql = $this->db->query("select tbl_product.*, tbl_saledetails.* FROM tbl_product left join tbl_saledetails on tbl_saledetails.Product_IDNo=tbl_product.Product_SlNo where tbl_saledetails.SaleMaster_IDNo='$SaleMaster_SlNo'");
				$result = $pdsql->result();
				//echo "<pre>";print_r($result);exit;
					$tpur = 0;$pl=0;
					$tsale = 0;  $tpl =0; 
					$totalPurchase = 0;
					$totalSale = 0;
					foreach($result as $result){
						$i++;
						$totalPurchase =  $result->Product_Purchase_Rate*$result->SaleDetails_TotalQuantity;
						$totalSale = $result->SaleDetails_Rate*$result->SaleDetails_TotalQuantity;
						$tpur = $tpur + $totalPurchase;
						$tsale = $tsale + $totalSale;
						$pl = $totalSale-$totalPurchase;
						$tpl += $pl;
						?>
						<tr align="center">
							<td style=""><?php if($i==1){ echo $invoice->SaleMaster_InvoiceNo; } ?></td>
							<td style=""><?php if($i==1){ echo $invoice->SaleMaster_SaleDate; } ?></td>
							<td style=""><?php echo $result->Product_Code; ?></td>
							<td style=""><?php echo $result->Product_Name; ?></td>
							<td style=""><?php echo $result->SaleDetails_TotalQuantity; ?></td>
							<td style=""><?php echo $result->Product_Purchase_Rate; ?></td>
							<td style=""><?php echo $totalPurchase; ?></td>
							<td style=""><?php echo $totalSale; ?></td>
							<td style=""><?php echo $pl; ?></td>
						</tr>
						<?php
					}
					$Gtpl += $tpl; $Gtpur += $tpur; $Gtsale += $tsale;
				?>
					<tr align="center" style="background:#E5E5E5;color:#000;">
						<td colspan="6" style="text-align:right;"><strong>Total </strong></td>
						<td style=""><strong> <?php echo round($tpur,2); ?></strong></td>
						<td style=""><strong> <?php echo round($tsale,2); ?> </strong></td>
						<td style=""><strong> <?php echo number_format($tpl,2); ?> </strong></td>
					</tr>  
				<?php				
				}
				?>      

				<tr align="center" style="background:#c3ece3; color:#000;">
						<td colspan="6" style="text-align:right;"><strong>Sub-Total </strong></td>
						<td style=""><strong> <?php if(isset($Gtpur)) echo number_format($Gtpur,2); ?></strong></td>
						<td style=""><strong> <?php if(isset($Gtsale)) echo number_format($Gtsale,2); ?> </strong></td>
						<td style=""><strong> <?php if(isset($Gtpl)) echo number_format($Gtpl,2); ?> </strong></td>
					</tr>                                                            
        </tbody>
    </table>
		<?php
		}
		?>
</div>