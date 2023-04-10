<span id="Search_Results_Duepayment">
<link href="<?php echo base_url()?>assets/css/prints.css" rel="stylesheet" />
<div class="content_scroll" style="">

    <table class="border" cellspacing="0" cellpadding="0" width="80%">

        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>supplierDuePrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"> <i class="fa fa-print" style="font-size:24px;color:green"></i> Print</a></h4>
        <tr bgcolor="#438eb9" style="">
          
            <th style="text-align:center;color:#fff;">Supplier ID</th>
            <th style="text-align:center;color:#fff;">Supplier Name</th>
            <th style="text-align:center;color:#fff;">Total</th>
            <th style="text-align:center;color:#fff;">Paid</th>
            <th style="text-align:center;color:#fff;">Due</th>
            <th style="text-align:center;color:#fff;">Prev. Due</th>
            <th style="text-align:center;color:#fff;">Total Due</th>
            <!-- <th style="text-align:center;color:#fff;">Payment</th> -->
        </tr>
        <?php 
        $totalpurchase = "";
        $Totalpaid = "";
        $due = "";
        foreach($records as $record){ 
            $Suppid = $record->Supplier_SlNo;

            // ====================
            $purchaseMaster2 = $this->db->where('Supplier_SlNo', $Suppid)->select_sum('PurchaseMaster_SubTotalAmount')->get('tbl_purchasemaster')->row();
            $SubAm =  $purchaseMaster2->PurchaseMaster_SubTotalAmount;


            // ====================
            $purchaseMaster = $this->db->where('Supplier_SlNo', $Suppid)->select_sum('PurchaseMaster_DueAmount')->get('tbl_purchasemaster')->row();
            $dueAm =  $purchaseMaster->PurchaseMaster_DueAmount;
            
            // ====================
            $purchasePaid = $this->db->where('SPayment_customerID',$Suppid)->where('SPayment_TransactionType',null)->select_sum('SPayment_amount')->get('tbl_supplier_payment')->row();
            $purchasePaidAm = $purchasePaid->SPayment_amount;

            // ====================
            $paidAmount = $this->db->where('SPayment_customerID',$Suppid)->where('SPayment_TransactionType','CR')->select_sum('SPayment_amount')->get('tbl_supplier_payment')->row();
            $paidAm = $paidAmount->SPayment_amount;

            // ====================
            $payAmount = $this->db->where('SPayment_customerID',$Suppid)->where('SPayment_TransactionType','CP')->select_sum('SPayment_amount')->get('tbl_supplier_payment')->row();
            $payAm = $payAmount->SPayment_amount;
            
            // ====================
            $x = $this->db->where('SPayment_customerID',$Suppid)->where('SPayment_TransactionType','RP')->select_sum('SPayment_amount')->get('tbl_supplier_payment')->row();
            $xx = $x->SPayment_amount;

             // ====================
            $prevDueAmount = $this->db->where('Supplier_SlNo',$Suppid)->get('tbl_supplier')->row();
            $prevDue = $prevDueAmount->previous_due;

            $tDue =($payAm + $dueAm) - ($paidAm+$xx);

            if($tDue): $dueAmont = $tDue; else: $dueAmont = 0; endif;
            if($paidAm+$purchasePaidAm): $paidAmont = $paidAm + $purchasePaidAm; else: $paidAmont = 0; endif;

            if($dueAmont+$prevDue > 0):
        ?>
            <tr align="center">
                <td><?php echo $record->Supplier_Code; ?></td>
                <td><?php echo $record->Supplier_Name; ?></td> 
                <td><?php echo number_format($SubAm,2); ?></td>
                <td><?php echo number_format($paidAmont,2); ?></td>
                <td><?php echo number_format($dueAmont,2); ?></td>
                <td><?php if(isset($prevDue)): echo number_format($prevDue,2); endif; ?></td>
                <td><?php echo number_format($dueAmont+$prevDue,2); ?></td>
            </tr>

        <?php endif; } ?>
       
    </table>

</div>
</span>