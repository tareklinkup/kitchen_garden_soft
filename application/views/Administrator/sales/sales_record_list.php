<?php if ($invoive == "invoice" || $invoive == 'All' || $invoive == 'User') { ?>
    <div class="">
        <table class="border" cellspacing="0" cellpadding="0" width="90%">
            <h4><a style="cursor:pointer"
                   onclick="window.open('<?php echo base_url(); ?>search_sales_record', 'newwindow', `width=${screen.width}, height=${screen.height},scrollbars=yes`); return false;">
                    <i class="fa fa-print" style="font-size:24px;color:green"></i>Print</a></h4>
            <tr bgcolor="#89B03E">
                <th style="text-align: center;">Invoice No</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Customer Name</th>
                <th style="text-align: center;">Product Name</th>
                <th style="text-align: center;">Quantity</th>
                <th colspan="3" style="text-align: right;">Total Amount</th>
                <th colspan="2"  style="text-align: right;">Action</th>

            </tr>
            <?php $i = 0;
            $totalSales = 0;
            $TotalQty = 0;
            $totalcommision = 0;
            $totalpaid = 0;
            $TotalPaid = $TotalDue = $TotalSubTotal = 0;

            if (isset($records) && $records) {
                foreach ($records as $record) {

                    $i++;
                    $k = 0;
                    $Qty = 0;
                    $totalSales = $totalSales + $record->SaleMaster_SubTotalAmount;
                    $totalpaid = $totalpaid + $record->SaleMaster_PaidAmount;
                    $sales = $record->SaleMaster_SubTotalAmount;
                    $SMID = $record->SaleMaster_SlNo;

                    $SSD = $this->db->query("SELECT tbl_product.Product_Name,tbl_product.one_cartun_equal,tbl_saledetails.* FROM tbl_saledetails Left Join tbl_product ON tbl_product.Product_SlNo=tbl_saledetails.Product_IDNo WHERE tbl_saledetails.SaleMaster_IDNo = '$SMID'");
                    $SDROWS = $SSD->result();
                    foreach ($SDROWS as $SDROW) {
                        $k++;
                        $boxsize = $SDROW->one_cartun_equal;
                        if ($SDROW->SaleDetails_TotalQuantity > $boxsize) {
                            $getbox = $SDROW->SaleDetails_TotalQuantity / $boxsize;
                            $boxnum = floor($getbox);
                            $getpcs = $SDROW->SaleDetails_TotalQuantity % $boxsize;
                            $tbox = $boxnum . " Box " . $getpcs . " Pcs";
                        } else {
                            $tbox = "0 Box " . $SDROW->SaleDetails_TotalQuantity . " Pcs";
                        }

                        if ($k == 1) {
                            ?>
                            <tr>
                                <td align="center"><?php echo $record->SaleMaster_InvoiceNo; ?></td>
                                <td><?php echo $record->SaleMaster_SaleDate; ?></td>
                                <td><?php echo $record->Customer_Name; ?></td>
                                <td align="center"><?php echo $SDROW->Product_Name; ?></td>
                                <td style="text-align: center;"><?php echo $SDROW->SaleDetails_TotalQuantity; ?></td>

                                <td style="text-align: right;"
                                    colspan="3"><?php echo ($SDROW->SaleDetails_TotalQuantity * $SDROW->SaleDetails_Rate) - $SDROW->Discount_amount; ?></td>
                                <td colspan="2"></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td align="center"><?php echo $SDROW->Product_Name; ?></td>
                                <td style="text-align: center;"><?php echo $SDROW->SaleDetails_TotalQuantity; ?></td>

                                <td style="text-align: right;"
                                    colspan="3"><?php echo ($SDROW->SaleDetails_TotalQuantity * $SDROW->SaleDetails_Rate) - $SDROW->Discount_amount; ?></td>
                                <td colspan="2"></td>

                            </tr>
                        <?php }
                        $Qty += $SDROW->SaleDetails_TotalQuantity;
                        $TotalQty += $SDROW->SaleDetails_TotalQuantity;
                    } ?>
                    <tr>
                        <td style="text-align: right;" colspan="4"></td>

                        <td style="text-align: center;"><strong> Total Quantity: <?php echo $Qty; ?></strong></td>
                        <td style="text-align: center;"><strong>Total Paid: <?php echo $record->SaleMaster_PaidAmount;
                                $TotalPaid += $record->SaleMaster_PaidAmount; ?> <br/>Total
                                Due: <?php echo number_format($record->SaleMaster_DueAmount, 2);
                                $TotalDue += $record->SaleMaster_DueAmount; ?></strong></td>
                        <td style="text-align: right;" colspan="2">
                            <strong>Total: <?php echo number_format($record->SaleMaster_SubTotalAmount, 2);
                                $TotalSubTotal += $record->SaleMaster_SubTotalAmount; ?></strong></td>

                        <td align="center">
                            <a
                                    href="<?php echo base_url(); ?>sales/<?php echo $record->SaleMaster_SlNo; ?>"
                                    title="Update"
                                    style="color:green;">
                                <span class="fa fa-pencil fa-2x text-success"></span>
                            </a>
                            <a style="cursor:pointer"
                               onclick="window.open('<?php echo base_url(); ?>sales_record_print/<?php echo $record->SaleMaster_SlNo; ?>', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;">
                                <i class="fa fa-print fa-2x text-success"></i>
                            </a>
                        </td>

                        <td>

                            <a
                                    href="<?php echo base_url(); ?>Administrator/sales/deleteSaleRecord/<?php echo $record->SaleMaster_SlNo; ?>"
                                    title="Update"
                                    style="color:green;"
                                    onclick="if(!confirm('Are You Sure To Delete This Sales Record??')){ return false;}"
                            >
                                <span class="fa fa-times   fa-2x text-success"></span>
                            </a>

                        </td>

                    </tr>
                <?php }
            } ?>
            <tr>
                <td style="text-align: right;" colspan="4">Total:</td>

                <td style="text-align: center;"><strong> Total Quantity: <?php echo $TotalQty; ?></strong></td>
                <td style="text-align: center;"><strong>Total Paid: <?php echo number_format($TotalPaid, 2); ?> <br/>Total
                        Due: <?php echo number_format($TotalDue, 2); ?></strong></td>
                <td style="text-align: right;" colspan="2">
                    <strong>Total: <?php echo number_format($TotalSubTotal, 2); ?></strong></td>
            </tr>
        </table>
    </div>
<?php } elseif ($invoive == "Qty") { ?>
    <div class="" style="table-responsive">
        <table class="border" cellspacing="0" cellpadding="0" width="90%">
            <h4><a style="cursor:pointer"
                   onclick="window.open('<?php echo base_url(); ?>search_sales_record', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;">
                    <i class="fa fa-print" style="font-size:24px;color:green"></i>Print</a></h4>
            <tr bgcolor="#89B03E">
                <th style="text-align: center;">Invoice No</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Customer Name</th>
                <th style="text-align: center;">Product Name</th>
                <th style="text-align: center;">Quantity</th>
            </tr>
            <?php
            $qty = 0;
            if (isset($records) && $records) {
                foreach ($records as $record) {
                    $pro = $this->db->where('Product_SlNo', $record->Product_IDNo)->get('tbl_product')->row(); ?>
                    <tr>
                        <td align="center"><?php echo $record->SaleMaster_InvoiceNo; ?></td>
                        <td><?php echo $record->SaleMaster_SaleDate; ?></td>
                        <td><?php echo $record->Customer_Name; ?></td>
                        <td align="center"><?php echo $pro->Product_Name; ?></td>
                        <td style="text-align: center;"><?php echo $record->SaleDetails_TotalQuantity; ?></td>
                    </tr>

                    <?php $qty += $record->SaleDetails_TotalQuantity;
                }
            } ?>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: 800;">Total Sale Qty:</td>
                <td style="text-align:center; font-weight: 800;"><?= $qty; ?></td>
            </tr>
        </table>
    </div>
<?php } else { ?>
    <div class="" style="table-responsive">
        <table class="border" cellspacing="0" cellpadding="0" width="90%">
            <h4><a style="cursor:pointer"
                   onclick="window.open('<?php echo base_url(); ?>search_sales_record', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i
                            class="fa fa-print" style="font-size:24px;color:green"></i> Print</a></h4>
            <tr bgcolor="#89B03E">
                <th style="text-align:center;">Invoice No.</th>
                <th style="text-align:center;">Date</th>
                <th style="text-align:center;">Customer ID</th>
                <th style="text-align:center;">Customer Name</th>
                <th style="text-align:center;">Pro Name</th>
                <th style="text-align:center;">Qty</th>
                <!-- <th style="text-align:center;">Discount</th> -->
                <th style="text-align:center;">Total</th>
                <!-- <th style="text-align:center;">Paid</th>
                <th style="text-align:center;">Due</th> -->
                <th style="text-align:center;">Notes</th>
                <th style="text-align:center;">Action</th>
                <th style="text-align:center;">Print</th>
            </tr>
            <?php $totalpurchase = 0;
            $Totalpaid = 0;
            if (isset($records) && $records) {
                foreach ($records as $record) {
                    $mID = $record->SaleMaster_SlNo;
                    $proCode = $this->db->select('Product_Name, Unit_ID')->where('Product_SlNo', $record->Product_IDNo)->get('tbl_product')->row();
                    $unitName = $this->db->select('Unit_Name')->where('Unit_SlNo', $proCode->Unit_ID)->get('tbl_unit')->row();
                    $totalpurchase = $totalpurchase + $record->SaleMaster_SubTotalAmount;
                    $Totalpaid = $Totalpaid + $record->SaleMaster_PaidAmount;

                    ?>
                    <tr align="center">
                        <td><?php echo $record->SaleMaster_InvoiceNo; ?></td>
                        <td><?php echo $record->SaleMaster_SaleDate; ?></td>
                        <td><?php echo $record->Customer_Code; ?></td>
                        <td><?php echo $record->Customer_Name; ?></td>
                        <td><?php echo $proCode->Product_Name; ?></td>
                        <td><?php echo $record->SaleDetails_TotalQuantity ?><?php echo ($unitName) ? $unitName->Unit_Name : ''; ?></td>
                        <!-- <td><?php echo $record->SaleMaster_TotalDiscountAmount; ?></td> -->
                        <td><?php echo ($record->SaleDetails_Rate * $record->SaleDetails_TotalQuantity) - $record->Discount_amount; ?></td>
                        <!--  <td><?php echo $record->SaleMaster_PaidAmount; ?></td> -->
                        <!-- <td><?php echo $record->SaleMaster_DueAmount; ?></td> -->
                        <td><?php if ($record->SaleMaster_Description != 'undefined'): echo $record->SaleMaster_Description; endif; ?></td>
                        <td align="center"><a
                                    href="<?php echo base_url(); ?>Administrator/sales/sales_update_form/<?php echo $record->SaleMaster_SlNo; ?>"
                                    title="Update" style="color:green;"><span class="fa fa-pencil"></span></a></td>
                        <td><a style="cursor:pointer"
                               onclick="window.open('<?php echo base_url(); ?>sales_record_print/<?php echo $record->SaleMaster_SlNo; ?>', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;">
                                <i class="fa fa-print" style="font-size:24px;color:green"></i></a></td>

                    </tr>
                <?php }
            } ?>

        </table>
        <br> <br>
        <table cellspacing="0" cellpadding="0" width="70%">
            <tr>
                <td><strong>Total Sales </strong><input type="text" disabled="" value="<?php echo $totalpurchase; ?>">
                </td>
                <td><strong>Total Paid </strong> <input type="text" disabled="" value="<?php echo $Totalpaid; ?>"></td>
                <td><strong>Total Due </strong> <input type="text" disabled=""
                                                       value="<?php echo $totalpurchase - $Totalpaid; ?>"></td>
                <td></td>
            </tr>
        </table>
    </div>
<?php } ?>