<div class="content_scroll" style="">

    <table class="border" cellspacing="0" cellpadding="0" width="80%">

        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>cashPrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:24px;color:green"></i> Print</a></h4>
        <tr bgcolor="#ccc">
            <th>Account Name</th>
            <th>Description</th>
            <th>In Amount</th>                      
            <th>Out Amount</th> 
        </tr>
        <?php
        $in="";$out="";
        foreach($record as $row){ 
            $in=$in+$row->In_Amount;
            $out=$out+$row->Out_Amount;
            ?>
        <tr>
            <td><?php echo $row->Acc_Name; ?></td>
            <td><?php echo $row->Tr_Description; ?></td>
            <td><?php if($row->In_Amount==""){echo "0";}else{ echo $row->In_Amount;} ?></td>
            <td><?php if($row->Out_Amount==""){echo "0";}else{ echo $row->Out_Amount;} ?></td>
        </tr>
        <?php } 
        $expence_startdate = $this->session->userdata('expence_startdate');
        $expence_enddate = $this->session->userdata('expence_enddate');
        $purchase = "";
        $pmsql = $this->db->query("SELECT * FROM tbl_purchasemaster");
		$pmroof = $pmsql->result();
        foreach($pmroof as $pmroof){
            $purchase =$purchase+$pmroof->PurchaseMaster_PaidAmount;
        
        }?>
         <tr>
            <td>Purchase</td>
            <td>Purducts</td>
            <td>0</td>
            <td><?php echo $purchase; ?></td>
        </tr>
        <?php  
        $expence_startdate = $this->session->userdata('expence_startdate');
        $expence_enddate = $this->session->userdata('expence_enddate');
        $sell = "";
        $sql = $this->db->query("SELECT * FROM tbl_salesmaster");
		$roof = $sql->result();
        foreach($roof as $roof){
            $sell =$sell+$roof->SaleMaster_PaidAmount;
        
        }?>
        <tr>
            <td>Sales</td>
            <td>Purducts</td>
            <td><?php echo $sell; ?></td>
            <td>0</td>
        </tr>
        <?php $totalreturn = "";
            $sqlx = $this->db->query("SELECT * FROM tbl_salereturn");
			$rom = $sqlx->result();
            foreach($rom as $rom){
                $totalreturn = $totalreturn+$rom->SaleReturn_ReturnAmount;
        }?>
        <tr>
            <td>Sales Return</td>
            <td>Purducts</td>
            <td>0</td>
            <td><?php echo $totalreturn; ?></td>
        </tr>
        <?php $totalreturnP = "";
            $psqlx = $this->db->query("SELECT * FROM tbl_purchasereturn");
			$prow = $psqlx->result();
            foreach($prow as $prow){
                $totalreturnP = $totalreturnP+$prow->PurchaseReturn_ReturnAmount;
        } ?>
        <tr>
            <td>Pruchase Return</td>
            <td>Purducts</td>
            <td><?php echo $totalreturnP; ?></td>
            <td>0</td>
        </tr>
        <tr>
            <td colspan="2" align="right"><strong>Total</strong></td>
            <td><strong><?php echo $sell+$in+$totalreturnP; ?></strong></td>
            <td><strong><?php echo $purchase+$out+$totalreturn; ?></strong></td>
        </tr>
        
    </table>

</div>
