<style type="text/css">
th{text-align:center;}
</style>
<div class="content_scroll" style="">
    <table class="border" cellspacing="0" cellpadding="0" width="100%">
        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>purchaseRecordPrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a></h4>
        <tr bgcolor="#89B03E">
            <th>Invoice No.</th>
            <th>Date</th>
            <th>Supplier ID</th>
            <th>Supplier Name</th>
            <th>Discount</th>
            <th>Total</th>
            <th>Paid</th>
            <th>Due</th>
            <th>Action</th>
            <th>Notes</th>
        </tr>
        <?php $totalpurchase = "";
        $Totalpaid = "";
        foreach($record as $record){ 
            $totalpurchase = $totalpurchase +$record->PurchaseMaster_SubTotalAmount; 
            $Totalpaid = $Totalpaid +$record->PurchaseMaster_PaidAmount;

            ?>
        <tr align="center">
            <td><?php echo $record->PurchaseMaster_InvoiceNo; ?></td>
            <td><?php echo $record->PurchaseMaster_OrderDate; ?></td>
            <td><?php echo $record->Supplier_Code; ?></td>
            <td><?php echo $record->Supplier_Name; ?></td>
            <td><?php echo $record->PurchaseMaster_DiscountAmount; ?></td>
            <td><?php echo $record->PurchaseMaster_SubTotalAmount; ?></td>
            <td><?php echo $record->PurchaseMaster_PaidAmount; ?></td>
            <td><?php echo $record->PurchaseMaster_DueAmount; ?></td>
			<td align="center">
                <a href="<?php echo base_url(); ?>purchase/<?php echo $record->PurchaseMaster_SlNo; ?>" title="Update" style="color:green;"><span class="fa fa-2x fa-pencil"></span></a>
                <a onclick="if(!confirm('Are You Sure To Delete This Sales Record??')){ return false;}" href="<?php echo base_url(); ?>Administrator/Purchase/deletePurchaseRecord/<?php echo $record->PurchaseMaster_SlNo; ?>" title="Delete" style="color:green;"><span class="fa fa-2x fa-times"></span></a>
            </td>
            <td><?php echo $record->PurchaseMaster_Description; ?></td>
        </tr>
        <?php } ?>
       
    </table>
    <br>
    <br>
    <table  cellspacing="0" cellpadding="0" width="70%">
        <tr>
            <td ><strong>Total Purchase </strong><input type="text" disabled="" value="<?php echo $totalpurchase; ?>"></td>
            <td> <strong>Total Paid </strong> <input type="text" disabled="" value="<?php echo $Totalpaid; ?>"></td>
            <td><strong>Total Due </strong> <input type="text" disabled="" value="<?php echo $totalpurchase - $Totalpaid; ?>"></td>
            <td></td>
        </tr>
    </table>

</div>