<a style="cursor:pointer;" onclick="window.open('<?php echo base_url();?>Administrator/reports/customerwise_branch_sales', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><img style="margin-top:10px;" src="<?php echo base_url(); ?>images/printer.png" alt=""> Print</a>
<div class="row_section clearfix" style="margin-top:20px;padding-bottom:0px;">

    <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:100%;">
        <thead>
            <tr class="header">
                <th style="width:20%">Date</th>
                <th style="width:20%">Invoice</th>
                <th style="width:20px">Total Amount</th>
                <th style="width:20px">Paid Amount</th>
                <th style="width:20px">Due Amount</th>         
            </tr>
        </thead>
    </table>                    
</div>
<div class="row_section clearfix" style="height:500px;overflow:auto;">
    <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;">
        <tbody>
        <?php 
            $userBrunch = $this->session->userdata('BRANCHid');
            $sql = mysql_query("SELECT * FROM tbl_salesmaster WHERE SalseCustomer_IDNo = '$customerID'  AND SaleMaster_branchid = '$BranchID' AND SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate'");
        while($row = mysql_fetch_array($sql)){ ?>
            <tr>
                <td style="width:20%"><?php echo $row['SaleMaster_SaleDate'] ?></td>
                <td style="width:20%"><?php echo $row['SaleMaster_InvoiceNo'] ?></td>
                <td style="width:20%;text-align:right;"><?php echo number_format($row['SaleMaster_SubTotalAmount'], 2); ?></td>
                <td style="width:20%;text-align:right;"><?php echo number_format($row['SaleMaster_PaidAmount'], 2); ?></td>
                <td style="width:20%;text-align:right;"><?php echo number_format($row['SaleMaster_DueAmount'], 2); ?></td>
            </tr>  
        <?php } ?>                                                                   
        </tbody>
    </table>

</div> 