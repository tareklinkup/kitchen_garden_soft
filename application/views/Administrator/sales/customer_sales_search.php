<a style="cursor:pointer;" onclick="window.open('<?php echo base_url();?>customerwiseSalesPrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a>
<div class="row_section clearfix" style="margin-top:20px;padding-bottom:0px;">

    <table class="border" cellspacing="0" cellpadding="0" border="0" id="" style="width:100%;">
        <thead>
            <tr class="header">
                <th style="width:20%;text-align:center;">Date</th>
                <th style="width:20%;text-align:center;">Invoice</th>
                <th style="width:20%;text-align:center;">Total Amount</th>
                <th style="width:20%;text-align:center;">Paid Amount</th>
                <th style="width:20%;text-align:center;">Due Amount</th>         
            </tr>
        </thead>
    </table>                    
</div>
<div class="row_section clearfix" style="height:500px;overflow:auto;">
    <table class="border" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;">
        <tbody>
        <?php
        $a = $b = $c = 0;
            $userBrunch = $this->session->userdata('BRANCHid');
            $sql = $this->db->query("SELECT * FROM tbl_salesmaster WHERE SalseCustomer_IDNo = '$customerID'  AND SaleMaster_branchid = '$userBrunch' and Status = 'a' AND SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate'");
			$row = $sql->result();
			foreach($row as $row){ ?>
            <tr align="center">
                <td style="width:20%;"><?php echo $row->SaleMaster_SaleDate; ?></td>
                <td style="width:20%;"><?php echo $row->SaleMaster_InvoiceNo; ?></td>
                <td style="width:20%;"><?php echo number_format($row->SaleMaster_SubTotalAmount, 2); ?></td>
                <td style="width:20%;"><?php echo number_format($row->SaleMaster_PaidAmount, 2); ?></td>
                <td style="width:20%;"><?php echo number_format($row->SaleMaster_DueAmount, 2); ?></td>
            </tr>  
        <?php $a+=$row->SaleMaster_SubTotalAmount; $b+= $row->SaleMaster_PaidAmount; $c+=$row->SaleMaster_DueAmount;  } ?>
            <tr>
                <td colspan="2" style="text-align: center;"> Total: </td>
                <td style="text-align: center;"><?= $a?></td>
                <td style="text-align: center;"><?= $b?></td>
                <td style="text-align: center;"><?= $c?></td>
            </tr>
        </tbody>
    </table>

</div> 