<link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
<div class="content_scroll" style="padding:120px 20px 25px 160px">

    <table class="border" cellspacing="0" cellpadding="0" width="80%">

        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>Administrator/reports/daily_cashview_print', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><img src="<?php echo base_url(); ?>images/printer.png" alt=""> Print</a></h4>
        <tr bgcolor="#ccc">
            <th>Account Name</th>
            <th>In Amount</th>                      
            <th>Out Amount</th> 
        </tr>
        <?php
        $userBranch = $this->session->userdata('BRANCHid');
        $in=0;$out=0;
        foreach($record as $row){ 
            $in=$in+$row['In_Amount'];
            $out=$out+$row['Out_Amount'];
            ?>
        <tr>
            <td><?php echo $row['Acc_Name'] ?></td>
            <td><?php if($row['In_Amount']==""){echo "0";}else{ echo $row['In_Amount'];} ?></td>
            <td><?php if($row['Out_Amount']==""){echo "0";}else{ echo $row['Out_Amount'];} ?></td>
        </tr>
        <?php } 


        $sql = mysql_query("SELECT tbl_supplier_payment.*,tbl_supplier.* FROM tbl_supplier_payment LEFT JOIN tbl_supplier ON tbl_supplier.Supplier_SlNo=tbl_supplier_payment.SPayment_customerID WHERE tbl_supplier_payment.SPayment_brunchid = '$userBranch' AND tbl_supplier_payment.SPayment_date = CURDATE()");
        while($roof = mysql_fetch_array($sql)){
            $out =$out+$roof['SPayment_amount'];
        ?>
        <tr>

            <td><?php echo $roof['Supplier_Name']; ?></td>
            <td>0</td>
            <td><?php echo $roof['SPayment_amount']; ?></td>
        </tr>
        <?php        
            }
        ?>
         
        <?php  
        $sql = mysql_query("SELECT tbl_customer_payment.*,tbl_customer.* FROM tbl_customer_payment LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo=tbl_customer_payment.CPayment_customerID WHERE tbl_customer_payment.CPayment_brunchid = '$userBranch' AND tbl_customer_payment.CPayment_date = CURDATE()");
        while($roof = mysql_fetch_array($sql)){
            $in =$in+$roof['CPayment_amount'];
        ?>
        <tr>
            <td><?php echo $roof['Customer_Name']; ?></td>
            <td><?php echo $roof['CPayment_amount']; ?></td>
            <td>0</td>
        </tr>
        <?php
        }?>
        <?php 
            $sqlx = mysql_query("SELECT * FROM tbl_salereturn WHERE SaleReturn_brunchId = '$userBranch' AND SaleReturn_ReturnDate = CURDATE()");
            while($rom = mysql_fetch_array($sqlx)){
                $out = $out+$rom['SaleReturn_ReturnAmount'];
        ?>
        <tr>
            <td><?php echo $rom['SaleReturn_Description']; ?></td>
            <td>0</td>
            <td><?php echo $rom['SaleReturn_ReturnAmount']; ?></td>
        </tr>
        <?php
        }?>
        
        <?php 
            $sqlx = mysql_query("SELECT * FROM tbl_purchasereturn WHERE PurchaseReturn_brunchID = '$userBranch' AND PurchaseReturn_ReturnDate = CURDATE()");
            while($rom = mysql_fetch_array($sqlx)){
                $in = $in+$rom['PurchaseReturn_ReturnAmount'];
        ?>
        <tr>
            <td><?php echo $rom['PurchaseReturn_Description']; ?></td>
            <td><?php echo $rom['PurchaseReturn_ReturnAmount']; ?></td>
            <td>0</td>
        </tr>
        <?php
        }?>
        
        <tr>
            <td colspan="1" align="right"><strong>Total</strong></td>
            <td><strong><?php echo number_format($in, 2); ?></strong></td>
            <td><strong><?php echo number_format($out, 2); ?></strong></td>
        </tr>
        
    </table>

</div>
