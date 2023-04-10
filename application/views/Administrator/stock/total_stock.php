<div class="" style="height:500px;overflow:auto;">

    <table class="border" cellspacing="0" cellpadding="0" width="80%">

        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>totalStockPrint', 'newwindow', 'width=850, height=700,scrollbars=yes'); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a></h4>
        <tr>
            <td colspan="8" style="height:30px;text-align:center;"><strong>Total Stock</strong></td>
        </tr>
        <tr style="background:#ccc;">
            <th style="text-align:center;">SL NO.</th>
            <th style="text-align:center;">Product Name</th>
            <th style="text-align:center;">Purchase Qty</th>
            <th style="text-align:center;">P.Return Qty</th>
            <th style="text-align:center;">Damaged Qty</th>
            <th style="text-align:center;">Sold Qty</th>
            <th style="text-align:center;">S.Return Qty</th>
            <th style="text-align:center;">Current Qty</th>
        </tr>

        <?php 
        $totalqty = 0;$sellTOTALqty = 0; $subtotal = 0;
		$SaleInventory_DamageQuantity=0;
        $SaleInventory_ReturnQuantity=0;
		
		$BRANCHid=$this->session->userdata('BRANCHid');
	    $Csql = $this->db->query("SELECT * FROM tbl_productcategory where category_branchid = '$BRANCHid' order by ProductCategory_Name asc");
	    $brand = $Csql->result();
		$i=1;
       foreach($brand as $brand){
		   $bid = $brand->ProductCategory_SlNo;
                ?>
                <tr style="text-align:center;background:#f4f4f4;">
                    <td colspan="8"><strong style="text-transform:uppercase;"><?php echo $brand->ProductCategory_Name; ?></strong></td>
                </tr>
			<?php 
			$current = 0;
			$Psql = $this->db->query("select tbl_product.*, tbl_purchaseinventory.*, tbl_saleinventory.* FROM tbl_product left join tbl_purchaseinventory on tbl_purchaseinventory.purchProduct_IDNo=tbl_product.Product_SlNo left join tbl_saleinventory on tbl_saleinventory.sellProduct_IdNo=tbl_product.Product_SlNo where tbl_product.ProductCategory_ID='$bid'");
			$product = $Psql->result();
			
			foreach($product as $product)
			{
				$current = $product->PurchaseInventory_TotalQuantity - ($product->PurchaseInventory_ReturnQuantity+$product->PurchaseInventory_DamageQuantity+$product->SaleInventory_TotalQuantity) + $product->SaleInventory_ReturnQuantity;
				?>
				<tr style="text-align:center;">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $product->Product_Name; ?></td>
                    <td><?php echo $product->PurchaseInventory_TotalQuantity; ?></td>
                    <td><?php echo $product->PurchaseInventory_ReturnQuantity; ?></td>
                    <td><?php echo $product->PurchaseInventory_DamageQuantity; ?></td>
                    <td><?php echo $product->SaleInventory_TotalQuantity; ?></td>
                    <td><?php echo $product->SaleInventory_ReturnQuantity; ?></td>
                    <td><?php echo $current; ?></td>
                </tr>
				<?php
				$current = 0;
			}
		} 
		?>
    </table>
</div>