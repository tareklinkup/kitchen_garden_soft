<div class="content_scroll" style="">
<a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>PurchaseInvoicePrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i>  Print</a>

<?php 

?>
    <table  cellspacing="0" cellpadding="0" width="70%">
        <tr>
            <td colspan="2" style="background:#ddd;height:30px;" align="center">Purchase Invoice</td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td><strong>Supplier ID </strong></td>
                        <td>:</td>
                        <td><?php echo $purchase->Supplier_Code; ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Supplier Name </strong></td>
                        <td>:</td>
                        <td><?php echo $purchase->Supplier_Name; ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Customer Address </strong></td>
                        <td>:</td>
                        <td><?php echo $purchase->Supplier_Address; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Contact no </strong></td>
                        <td>:</td>
                        <td><?php echo $purchase->Supplier_Mobile; ?></td>
                    </tr>              
                </table>
            </td>
			
            <td>
                <table width="100%">
                    <tr>
                        <td><strong>Invoice no </strong></td>
                        <td>:</td>
                        <td><?php echo $purchase->PurchaseMaster_InvoiceNo; ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Sales Date </strong></td>
                        <td>:</td>
                        <td><?php echo $purchase->PurchaseMaster_OrderDate; ?></td>
                    </tr> 
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr><hr></td>
            <td colspan="2"><br></td>
        </tr>
    </table>
    <style type="text/css">
	th{text-align:center;}
    </style>
    <table class="border" cellspacing="0" cellpadding="0" width="70%">
        <tr>
           <th style="width: 15%;">SI No.</th>
           <th>Product Name</th>
		   <!-- <th>Brand</th> -->
		   <!-- <th>Category</th> -->
		   <!-- <th>Size</th> -->
           <th style="width: 10%;">Quantity</th>
           <th>Rate</th>
           <th>Amount</th>
        </tr>
        <?php $i = ""; //exit;
        $totalamount = "";
        $Ptotalamount = "";

		foreach($products as $rowss){
            $i++;
            $amount = $rowss->PurchaseDetails_Rate*$rowss->PurchaseDetails_TotalQuantity;
            $totalamount = $totalamount+$amount;
        ?>
        <tr align="center">
            <td><?php echo $i; ?></td>
            <td><?php echo $rowss->Product_Name; ?></td>
            <!-- <td><?php echo $rowss->brand_name; ?></td> -->
            <!-- <td><?php echo $rowss->ProductCategory_Name; ?></td> -->
            <!-- <td><?php echo $rowss->size; ?></td> -->
            <td><?php echo $rowss->PurchaseDetails_TotalQuantity; ?>
            <td><?php echo $rowss->PurchaseDetails_Rate; ?></td>
            <td><?php echo $amount; ?></td>
        </tr>
        <?php } ?>
        <tr align="right">
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px"><strong>Sub Total :</strong> </td>
            <td style="border:0px"><?php $totalamount = $Ptotalamount+$totalamount; echo number_format($totalamount,2); ?></td>
        </tr>
        <tr align="right">
            <td  style="border:0px"><strong>Previous Due</strong></td>
            <td  style="border:0px;color:red;">
                <!-- Previous Due Customer -->
                <?php $SupllierID = $purchase->Supplier_SlNo;
                   
                   $prevDue = $this->mt->getSupplierDueById($SupllierID);
                    $vat = $purchase->PurchaseMaster_Tax;  $vat = ($totalamount*$vat)/100;
                    $all = $totalamount
                            -$purchase->PurchaseMaster_DiscountAmount
                            +$purchase->PurchaseMaster_Freight
                            +$vat; 
                    
                    $CurrenDue = $all-$purchase->PurchaseMaster_PaidAmount;
                    
                    echo number_format($prevDue-$CurrenDue,2);
                ?>
                <!-- Previous Due Customer End -->
            </td>
            <td style="border:0px"></td>
            <td style="border:0px"><strong>Vat :</strong> </td>
            <td style="border:0px"><?php echo number_format($vat,2) ?></td>
        </tr>
        <tr align="right">
            <td style="border:0px"><strong>Current Due</strong></td>
            <td style="border:0px;color:red;"><?php if($CurrenDue==''){echo '0';} echo number_format($CurrenDue,2); ?></td>
            <td style="border:0px"></td>
            <td style="border:0px"><strong>Frieght :</strong> </td>
            <td style="border:0px"><?php $Frieght = $purchase->PurchaseMaster_Freight; echo number_format($Frieght,2) ?></td>
        </tr>
        <tr align="right">
            <td style="border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;">
            <strong>Totul Due</strong> </td>
            <td style="color:red;border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;">
            <?php if($prevDue==''){echo '0';} echo number_format($prevDue,2); ?></td>
            <td style="border:0px"></td>
            <td style="border:0px"><strong>Discount :</strong> </td>
            <td style="border:0px"><?php $discount = $purchase->PurchaseMaster_DiscountAmount;echo number_format($discount,2) ?></td>
        </tr>
         <tr align="right">
            <td colspan="3" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
           
        </tr>
        <tr align="right">
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px"><strong>Total :</strong> </td>
            <td style="border:0px"><strong><?php $grandtotal = $all; echo number_format($grandtotal,2)?></strong></td>
        </tr>
        <tr align="right">
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px"><strong>Paid :</strong> </td>
            <td style="border:0px"><?php $paid = $purchase->PurchaseMaster_PaidAmount; echo number_format($paid,2);?></td>
        </tr>
        <tr align="right">
            <td colspan="3" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
           
        </tr>
        <tr align="right">
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px"><strong>Due :</strong> </td>
            <td style="border:0px"><?php echo number_format($grandtotal-$paid,2); ?></td>
        </tr>
    </table>
    <p><strong>Total (in word): </strong>
         <?=$this->mt->convertNumberToWord($grandtotal);?>
    </p><br>
    <h4>Notes: <?php echo $purchase->PurchaseMaster_Description; ?></h4>

</div>
