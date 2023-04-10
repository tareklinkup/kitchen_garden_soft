<link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
<div class="content_scroll" style="padding:40px 20px 25px 160px">

<?php if($invoive=="invoice") { ?>

	    <table class="border" cellspacing="0" cellpadding="0" width="70%">
        
         <tr bgcolor="#89B03E">
            <th style="text-align:center;">Invoice No.</th>
            <th style="text-align:center;">Date</th>
            <th style="text-align:center;">Customer Name</th>
            <th style="text-align:center;">Total</th>
            <th style="text-align:center;"></th>
        </tr>
        <?php
		//echo "<pre>";print_r($record);exit;
        foreach($record as $record){ 
        ?>
        <tr align="center">
            <td><?php echo $record['SaleMaster_InvoiceNo'] ?></td>
            <td><?php echo $record['SaleMaster_SaleDate'] ?></td>
            <td><?php echo $record['customer_name'] ?></td>
            <td><?php echo $record['SaleMaster_TotalSaleAmount'] ?></td>
            <td><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>Administrator/quotation/quotationPrint/<?php echo $record['SaleMaster_SlNo']; ?>', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><img src="<?php echo base_url(); ?>images/printer.png" alt=""> Print</a></td>

        </tr>
        <?php } ?>
    </table>
<?php
}else{
?>

    <table class="border" cellspacing="0" cellpadding="0" width="70%">
        <tr bgcolor="#89B03E">
            <th style="text-align:center;">Invoice No.</th>
            <th style="text-align:center;">Date</th>
            <th style="text-align:center;">Customer Name</th>
            <th style="text-align:center;">Total</th>
            <th style="text-align:center;"></th>
        </tr>
        <?php
		//echo "<pre>";print_r($record);exit;
        foreach($record as $record){ 
        ?>
        <tr align="center">
            <td><?php echo $record['SaleMaster_InvoiceNo'] ?></td>
            <td><?php echo $record['SaleMaster_SaleDate'] ?></td>
            <td><?php echo $record['customer_name'] ?></td>
            <td><?php echo $record['SaleMaster_Description'] ?></td>
            <td><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>Administrator/quotation/quotationPrint/<?php echo $record['SaleMaster_SlNo'];?>', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><img src="<?php echo base_url(); ?>images/printer.png" alt=""> Print</a></td>

        </tr>
        <?php } ?>
       
    </table>
<?php } ?>

</div>