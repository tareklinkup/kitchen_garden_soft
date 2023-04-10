<div class="content_scroll">

    <table class="border" cellspacing="0" cellpadding="0" width="80%">
        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>stockAvailablePrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a></h4>
        <tr>
            <td colspan="8" align="center"><h2> Stock Available </h2></td>
        </tr>
        <tr style="background:#ccc;">
            <th style="text-align:center;">SL. NO</th>
            <th style="text-align:center;">Product Name</th>
            <th style="text-align:center;">Purchase Rate</th>
            <!-- <th style="text-align:center;">Brand Name</th> -->
        </tr>
        <?php 
        $totalqty = 0;$sellTOTALqty = 0; $subtotal = 0;
		$SaleInventory_DamageQuantity=0;
        $SaleInventory_ReturnQuantity=0;
		$currentQuantity=0;
		$lessQuantity=0;
		$i=1;
        foreach($record as $record){
			    $sellTOTALqty = 0;
                $PID = $record->purchProduct_IDNo;
                $brandid = $record->brand;
                // Sell qty
                $sqq = $this->db->query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '$PID' AND SaleInventory_brunchid = '$branchID'");
                $or = $sqq->row();
				if($sqq->num_rows() > 0){
					$sellTOTALqty = $or->SaleInventory_TotalQuantity;
					$SaleInventory_ReturnQuantity = $or->SaleInventory_ReturnQuantity;
				}
				
				$lessQuantity = $record->PurchaseInventory_ReturnQuantity+$record->PurchaseInventory_DamageQuantity+$sellTOTALqty;
				 
				$currentQuantity =  $record->PurchaseInventory_TotalQuantity - $lessQuantity;
				
                //$color = $this->db->where()->get('')->row();
                ?>
                <tr style="text-align:center;">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $record->Product_Name; ?></td>
                    <td><?php echo $record->Product_Purchase_Rate; ?></td>
                    <!-- <td><?php echo $brandrow->brand_name; ?></td> -->
                </tr>
        <?php }  ?>
       
    </table>
</div>