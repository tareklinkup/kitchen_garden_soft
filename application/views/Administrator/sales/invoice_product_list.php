<a style="cursor:pointer;" onclick="window.open('<?php echo base_url();?>invoiceProductPrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a>
<div class="row_section clearfix" style="margin-top:10px;padding-bottom:0px;height:400px;overflow: scroll;">

    <table class="border" cellspacing="0" cellpadding="0" border="0" id="" style="width:90%;">
        <thead>
            <tr class="header">
                <th style="width:10%;text-align:center;">Date</th>
                <th style="width:15%;text-align:center;">Invoice</th>
                <th style="width:20%;text-align:center;">Customer</th>
                <th style="width:20%;text-align:center;">Product</th>
                <th style="width:15%;text-align:center;">Sales Qty</th>
                <th style="width:20%;text-align:center;">Sales Amount</th>         
            </tr>
        </thead>
        <tbody>
        <?php 
            $subTotal = 0;
            if($customerID == 'All'){
                $sql = $this->db->query("SELECT tbl_salesmaster.*, tbl_customer.* FROM tbl_salesmaster LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo WHERE tbl_salesmaster.SaleMaster_branchid = '$BranchID' and tbl_salesmaster.Status = 'a' AND tbl_salesmaster.SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate'");
			}else{
				$sql = $this->db->query("SELECT tbl_salesmaster.*, tbl_customer.* FROM tbl_salesmaster LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo WHERE tbl_salesmaster.SalseCustomer_IDNo = '$customerID' AND tbl_salesmaster.SaleMaster_branchid = '$BranchID' and tbl_salesmaster.Status = 'a' AND tbl_salesmaster.SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate'");
			}
			$result = $sql->result();
            foreach($result as $row){ 
                $SMID = $row->SaleMaster_SlNo;
                $INVTOTAL = 0;
                $SDQ = $this->db->query("SELECT tbl_saledetails.*, tbl_product.* FROM tbl_saledetails LEFT JOIN tbl_product ON tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo WHERE tbl_saledetails.SaleMaster_IDNo = '$SMID' and tbl_saledetails.Status = 'a'");
                $SDROW = $SDQ->result();
				$i = 0;
                foreach($SDROW as $SDROW) {
                    $i++;
                    $INVTOTAL += ($SDROW->SaleDetails_TotalQuantity*$SDROW->SaleDetails_Rate);
                   
        ?>
                <tr align="center">
                    <td style="width:10%;padding:5px;"><?php if($i == 1){echo $row->SaleMaster_SaleDate;} ?></td>
                    <td style="width:15%;padding:5px;"><?php if($i == 1){echo $row->SaleMaster_InvoiceNo;} ?></td>
                    <td style="width:20%;padding:5px;"><?php if($i == 1){echo $row->Customer_Name;} ?></td>
                    <td style="width:20%;padding:5px;"><?php echo $SDROW->Product_Name; ?></td>
                    <td style="width:15%;padding:5px;"><?php echo $SDROW->SaleDetails_TotalQuantity; ?></td>
                    <td style="width:20%;padding:5px;"><?php echo number_format(($SDROW->SaleDetails_TotalQuantity*$SDROW->SaleDetails_Rate), 2); ?></td>
                </tr>
        <?php
                }
				 $subTotal += $INVTOTAL;
        ?>
            <tr align="center" style="background:#ccc;color:#000;">
                <td style="width:20%;padding:5px;border-right:0px !important;"><strong>Discount : <?php echo $row->SaleMaster_TotalDiscountAmount; ?></strong></td>
                <td style="width:20%;padding:5px;"><strong>Vat : <?php echo $row->SaleMaster_TaxAmount; ?> %</strong></td>
                <td style="width:20%;padding:5px;text-align:center;"><strong>Paid : <?php echo number_format($row->SaleMaster_PaidAmount, 2); ?></strong></td>
                <td style="width:20%;padding:5px;text-align:center;"><strong>Due : <?php echo number_format($row->SaleMaster_DueAmount, 2); ?></strong></td>
                <td style="width:20%;padding:5px;text-align:right;"><strong>Total:</strong></td>
                <td style="width:20%;padding:5px;text-align:right;"><strong><?php echo number_format($INVTOTAL, 2); ?></strong></td>
            </tr>  
        <?php } ?> 

            <tr align="center">
                <td colspan="5" style="width:80%;padding:5px;text-align:right;"><strong> Sub Total</strong></td>
                <td style="width:20%;padding:5px;text-align:right;"><strong><?php echo number_format($subTotal, 2); ?></strong></td>
            </tr>                                                                  
        </tbody>
    </table>

</div> 