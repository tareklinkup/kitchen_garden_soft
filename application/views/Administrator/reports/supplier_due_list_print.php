<?php

?>
<!DOCTYPE html>
<html>
<head>
  <title> </title>
  <meta charset='utf-8'>
  <link href="<?php echo base_url()?>assets/css/prints.css" rel="stylesheet" />
</head>
<style type="text/css" media="print">
.hide{display:none}

</style>
<script type="text/javascript">
  function printpage() {
    document.getElementById('printButton').style.visibility="hidden";
    window.print();
    document.getElementById('printButton').style.visibility="visible";  
  }
</script>
<body style="background:none;">
  <?php //echo $this->session->userdata('BRANCHid').'<pre>'; print_r($records); die(); ?>
  

  <table width="800px" >
    <tr>
      <td align="right" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org; ?>" alt="Logo" style="width:100px;" /></td>
      <td align="center" width="650">
        <strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
        <?php echo $branch_info->Repot_Heading; ?><br/>
      </td>
    </tr>

    <tr>
      <td style="float:right">
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="250px" style="text-align:right;"><strong></td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td colspan="2"><hr><hr></td>
        <td colspan="2"><br></td>
      </tr>
      <tr>
        <td colspan="2" style="background:#ddd;" align="center"><h2 >Supplier Due</h2></td>
      </tr>
      <tr>
        <td colspan="2">
          <!-- Page Body -->
          
          <table class="border" cellspacing="0" cellpadding="0" width="100%">
            <tr>
              <th style="text-align:center;">Supplier ID</th>
            <th style="text-align:center;">Supplier Name</th>
            <th style="text-align:center;">Total</th>
            <th style="text-align:center;">Paid</th>
            <th style="text-align:center;">Due</th>
            <th style="text-align:center;">Prev. Due</th>
            <th style="text-align:center;">Total Due</th>
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
            $prevDueAmount = $this->db->where('Supplier_SlNo',$Suppid)->get('tbl_supplier')->row();
            $prevDue = $prevDueAmount->previous_due;

            $tDue =($payAm + $dueAm) - ($paidAm);

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
          </table>

          <div class="provied">

            <span style="float:left;font-size:11px;">
              <i>"THANK YOU FOR YOUR BUSINESS"</i><br>
            Software Provied By Link-Up Technology</span>
          </div>
          <div class="signature">
            <span style="border-top:1px solid #000;">
              Authorize Signature
            </span>
          </div>
        </body>
        </html>

