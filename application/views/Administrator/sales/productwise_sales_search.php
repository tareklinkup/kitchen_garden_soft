<a style="cursor:pointer;" onclick="window.open('<?php echo base_url();?>Administrator/reports/productwise_sales', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a>
<div class="row_section clearfix" style="margin-top:20px;padding-bottom:0px;">

    <table class="border" cellspacing="0" cellpadding="0" border="0" id="" style="width:100%;">
        <thead>
            <tr class="header">
                <th style="width:20%;text-align:center;">Date</th>
                <th style="width:20%;text-align:center;">Product Name</th>
                <th style="width:15%;text-align:center;">Invoice</th>
                <th style="width:15%;text-align:center;">Quantity</th>
                <th style="width:15%;text-align:center;">Sale Rate</th>         
                <th style="width:15%;text-align:center;">Total</th>         
            </tr>
        </thead>
    </table>                    
</div>
<div class="row_section clearfix" style="height:500px;overflow:auto;">
    <table class="border" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;">
        <tbody>
        <?php 
		$userBrunch = $this->session->userdata('BRANCHid');
		if($ProductID=='All'){
			 $sql = $this->db->query("SELECT tbl_saledetails.*, tbl_salesmaster.*, tbl_product.* FROM tbl_saledetails LEFT JOIN tbl_salesmaster ON tbl_salesmaster.SaleMaster_SlNo = tbl_saledetails.SaleMaster_IDNo LEFT JOIN tbl_product ON tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo WHERE tbl_salesmaster.SaleMaster_branchid = '$userBrunch' AND tbl_salesmaster.SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate' ORDER BY tbl_salesmaster.SaleMaster_SaleDate DESC");
		}else{
			 $sql = $this->db->query("SELECT tbl_saledetails.*, tbl_salesmaster.*, tbl_product.* FROM tbl_saledetails LEFT JOIN tbl_salesmaster ON tbl_salesmaster.SaleMaster_SlNo = tbl_saledetails.SaleMaster_IDNo LEFT JOIN tbl_product ON tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo WHERE tbl_salesmaster.SaleMaster_branchid = '$userBrunch' AND tbl_saledetails.Product_IDNo = '$ProductID' AND tbl_salesmaster.SaleMaster_SaleDate BETWEEN '$startdate' AND '$enddate' ORDER BY tbl_salesmaster.SaleMaster_SaleDate DESC");
		}
		$row = $sql->result();
        foreach($row as $row){ ?>
            <tr align="center" style="height:30px;">
                <td style="width:20%;"><?php echo $row->SaleMaster_SaleDate; ?></td>
                <td style="width:20%;"><?php echo $row->Product_Name; ?></td>
                <td style="width:15%;"><?php echo $row->SaleMaster_InvoiceNo; ?></td>
                <td style="width:15%;"><?php echo $row->SaleDetails_TotalQuantity; ?></td>
                <td style="width:15%;"><?php echo number_format($row->SaleDetails_Rate, 2); ?></td>
                <td style="width:15%;"><?php $t =  number_format($row->SaleDetails_Rate, 2); echo $t*$row->SaleDetails_TotalQuantity; ?></td>
            </tr>  
        <?php } ?>                                                                   
        </tbody>
    </table>

</div> 