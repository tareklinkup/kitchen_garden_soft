
<div class="table-responsive" style="">
<a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>salesInvoicePrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"> <i class="fa fa-print" style="font-size:20px;color:green"></i>Print</a>

	<table  cellspacing="0" cellpadding="0" width="70%">
        <tr>
            <td colspan="2" style="background:#ddd;" align="center"><strong style="font-size:16px;">Sales Invoice</strong></td>
        </tr>
        <tr>
            <td>
                <table width="100%"> 
                    <tr>
                        <td><strong>Customer ID </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->Customer_Code; ?></td>
                    </tr> 
                    <tr>
                        <td width="35%"><strong>Customer Name </strong></td>
                        <td>:</td>
                        <td><?php 
                        $Type=$selse->Customer_Type;
                        if ($Type=='G') {
                            echo $selse->G_Name; 
                        }else{
                            echo $selse->Customer_Name;
                        }
                        ?>
                            
                        </td>
                    </tr> 
                    <tr>
                        <td><strong>Customer Address </strong></td>
                        <td>:</td>
                        <td><?php 
                        if ($Type=='G') {
                            echo $selse->G_Address;
                        }else{
                            echo $selse->Customer_Address; 
                        }
                        ?>
                            
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Contact no </strong></td>
                        <td>:</td>
                        <td><?php 
                         
                        if ($Type=='G') {
                            echo $selse->G_Mobile;                            
                        }else{
                            echo $selse->Customer_Mobile; 
                        }
                        ?></td>
                    </tr>              
                </table>
            </td>
            <td>
                <table width="100%">
                    <tr>
                        <td><strong>Sale By </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->served; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Invoice no </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->SaleMaster_InvoiceNo; ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Sales Date </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->SaleMaster_SaleDate; ?></td>
                    </tr>
					<tr>
						<td><strong>Payment Type</strong></td>
						<td>:</td>
						<td><?php echo $selse->payment_type; ?></td>
					</tr>
				</table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
    </table>
    
    <table class="border" cellspacing="0" cellpadding="0" style="width: 70%;">
        <tr>
           <th style="text-align:center;">SI No.</th>
           <!-- <th style="text-align:center;">Category</th> -->
           <th style="text-align:center;">Product Name</th>
           <th style="text-align:center;">Unit Price</th>
           <th style="text-align:center;">Quantity</th>
           <!-- <th style="text-align:center;">Unit</th> -->
           <th style="text-align:center;">Discount</th>
           <th style="text-align:center;">Amount</th>
        </tr>
        <?php $i = "";
        $totalamount = "";
        $packageName ="";
        $Ptotalamount = "";
        $ssql = $this->db->query("SELECT tbl_saledetails.*, tbl_product.*,tbl_productcategory.*,tbl_color.*,tbl_brand.*  FROM tbl_saledetails left join tbl_product on tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo LEFT JOIN tbl_productcategory ON tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand where tbl_saledetails.SaleMaster_IDNo = '$SalesID'");
			$rows = $ssql->result();
			foreach($rows as $rows){ 
            $packageName = $rows->packageName;
            if($packageName==""){
				$amount = ($rows->SaleDetails_Rate*$rows->SaleDetails_TotalQuantity) - $rows->Discount_amount;
				$totalamount = $totalamount+$amount;
            $i++;
        ?>
        <tr align="center">
            <td><?php echo $i; ?></td>
            <!-- <td><?php //echo $rows->ProductCategory_Name; ?></td> -->
            <td><?php echo $rows->Product_Name; ?></td>
            <td><?php echo $rows->SaleDetails_Rate; ?></td>
            <td><?php echo $rows->SaleDetails_TotalQuantity .' '.$rows->SaleDetails_unit; ?> </td>
            <!-- <td> <?php //echo $rows->SaleDetails_unit; ?></td> -->
            <td> <?php echo $rows->Discount_amount; ?></td>
            <td><?php echo $amount; ?></td>
        </tr>
        <?php } }
            $ssqls = $this->db->query("SELECT tbl_saledetails.*, tbl_product.*  FROM tbl_saledetails left join tbl_product on tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo where tbl_saledetails.SaleMaster_IDNo = '$SalesID' group by tbl_saledetails.packageName");
            $rows = $ssqls->result();
			foreach($rows as $rows){ $i++;
                if($rows->packageName!=""){
                $Pamount = $rows->packSellPrice*$rows->SeleDetails_qty;
                $Ptotalamount = $Ptotalamount+$Pamount;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $rows->packageName; ?></td>
                <td><?php echo $rows->SeleDetails_qty; ?> <?php echo $rows->SaleDetails_unit; ?></td>
                <td><?php echo $rows->packSellPrice; ?></td>
                <td><?php echo $Pamount; ?></td>
            </tr>
        <?php } }?>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td style="border:0px">Sub Total : </td>
            <td style="border:0px"><?php $totalamount =$totalamount+$Ptotalamount; echo number_format($totalamount,2); ?></td>
        </tr>
        
        <tr>
            <td  style="border:0px">Previous Due</td>
            <td  style="border:0px;color:red;">
                <!-- Previous Due Customer -->
                <?php
                $prevDue = $selse->SaleMaster_Previous_Due;
                $CurrenDue = $selse->SaleMaster_DueAmount;
                $totalDue = $CurrenDue + $prevDue;
                echo number_format($prevDue,2);

                $vat = $selse->SaleMaster_TaxAmount;
                $vat = ($totalamount * $vat) / 100;
                $all = $totalamount
                    - $selse->SaleMaster_TotalDiscountAmount
                    + $selse->SaleMaster_Freight
                    + $vat - $selse->SaleMaster_RewordDiscount;
                ?>
                <!-- Previous Due Customer End -->
            </td>
            <td colspan="2" style="border:0px"></td>
            <td style="border:0px">Vat : </td>
            <td style="border:0px"><?= number_format($vat,2) ?></td>
        </tr>

        <tr>
            <td style="border:0px">Current Due</td>
            <td style="border:0px;color:red;"><?= $CurrenDue ? number_format((float) $CurrenDue,2):'0.00' ?></td>
            <td colspan="2" style="border:0px"></td>
            <td style="border:0px">Discount : </td>
            <td style="border:0px"><?php $discount = $selse->SaleMaster_TotalDiscountAmount;echo number_format($discount,2) ?></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;">Total Due </td>
            <td style="color:red;border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"><?= number_format($totalDue,2); ?></td>
            <td colspan="2" style="border:0px"></td>
            <td style="border:0px">Round Off : </td>
            <td style="border:0px"><?php $RewordDiscount = $selse->SaleMaster_RewordDiscount;echo number_format($RewordDiscount,2) ?></td>
        </tr>
         <tr>
            <td colspan="4" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
           
        </tr>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td style="border:0px"><strong>Total :</strong> </td>
            <td style="border:0px"><strong><?php $grandtotal = $all; echo number_format($grandtotal,2)?></strong></td>
        </tr>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td style="border:0px"><strong>Paid :</strong> </td>
            <td style="border:0px"><?php $paid = $selse->SaleMaster_PaidAmount; echo number_format($paid,2);?></td>
        </tr>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
           
        </tr>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td style="border:0px"><strong>Due :</strong> </td>
            <td style="border:0px"><?php echo number_format($grandtotal-$paid,2); ?></td>
        </tr>
    </table>
    <p><strong>Total (in word): </strong>
        <?= $this->mt->convertNumberToWord($grandtotal)?></p><br>
    <p><strong>Notes: </strong> <?php echo $selse->SaleMaster_Description; ?></p>
</div>
