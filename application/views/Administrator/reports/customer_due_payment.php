<?php
$brunch=$this->session->userdata('BRANCHid');
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
window.onload = async () => {
    await new Promise(resolve => setTimeout(resolve, 1000));
    window.print();
    window.close();
}
</script>
<body style="background:none;">

    <table width="800px" style="border-bottom: 2px solid #000; margin-bottom: 10px;" >
        <tr>
            <td align="right" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;" /></td>
            <td align="left" width="650">
                <div class="">
                    <div style="text-align:center;" >
                        <strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br>
                            <?php echo $branch_info->Repot_Heading; ?><br>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <?php
        $branchID = $this->session->userdata('BRANCHid');
        $PamentID = $this->session->userdata('PamentID');
        $SCP = $this->db->query("SELECT tbl_customer_payment.*, tbl_customer.* FROM tbl_customer_payment LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo = tbl_customer_payment.CPayment_customerID WHERE tbl_customer_payment.CPayment_id = '$PamentID'");
        $CPROW = $SCP->row();
        $CUSID = $CPROW->CPayment_customerID;
        $paid = $CPROW->CPayment_amount;
        $type = $CPROW->CPayment_TransactionType;


        $Custid = $CPROW->CPayment_customerID;

      // ====================
        $salesMaster = $this->db->where('SalseCustomer_IDNo', $Custid)->select_sum('SaleMaster_DueAmount')->get('tbl_salesmaster')->row();
        $dueAm =  $salesMaster->SaleMaster_DueAmount;

      // ====================
        $salesPaid = $this->db->where('CPayment_customerID',$Custid)->where('CPayment_TransactionType','')->select_sum('CPayment_amount')->get('tbl_customer_payment')->row();
        $salesPaidAm = $salesPaid->CPayment_amount;

      // ====================
        $paidAmount = $this->db->where('CPayment_customerID',$Custid)->where('CPayment_TransactionType','CR')->select_sum('CPayment_amount')->get('tbl_customer_payment')->row();
        $paidAm = $paidAmount->CPayment_amount;

      // ====================
        $payAmount = $this->db->where('CPayment_customerID',$Custid)->where('CPayment_TransactionType','CP')->select_sum('CPayment_amount')->get('tbl_customer_payment')->row();
        $payAm = $payAmount->CPayment_amount;

      // ====================
        $prevDueAmount = $this->db->where('Customer_SlNo',$Custid)->get('tbl_customer')->row();
        $prevDue = $prevDueAmount->previous_due;

        $due =($payAm + $dueAm + $prevDue) - ($salesPaidAm + $paidAm);
        
        if($due): $prevdueAmont = $due; else: $prevdueAmont = 0.00; endif;


        if($type == 'CR'):
            $prevdueAmont  = $prevdueAmont + $paid; 
        elseif($type == 'CP'):
            $prevdueAmont  = $prevdueAmont - $paid; 
        endif;

        if($type == 'CR'):
            $totalDue = $prevdueAmont - $paid; 
        elseif($type == 'CP'):
            $totalDue = $prevdueAmont + $paid; 
        endif;
    ?>
    <div class="row" style="width: 94%; margin-bottom: 20px; padding: 0 15px;">
        <h6 style="background:#ddd; text-align: center; font-size: 18px; font-weight: 900; padding: 5px; color: #bd4700;">Customer Payment Invoice</h6>
    </div>
    <div class="row" style="width: 92%; margin-bottom: 20px; padding: 0 40px;">
        <table style="width: 100%;">
            <tr>
                <td style="font-size: 13px; font-weight: 600; ">TR. Date: <?php echo $CPROW->CPayment_date; ?> </td>
                <td style="font-size: 13px; font-weight: 600; text-align: right;"> TR. Id: <?php echo $CPROW->CPayment_invoice; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 13px; font-weight: 600; ">Name : <?php echo $CPROW->Customer_Name; ?></td>
            </tr>
            <tr>
                <td colspan="2" style="font-size: 13px; font-weight: 600; ">Phone No. : <?php echo $CPROW->Customer_Mobile; ?></td>
            </tr>
        </table>
    </div>
    <table class="border" cellspacing="0" cellpadding="0" width="800px">
        <thead>
            <tr>
                <th style="font-size: 14px; font-weight: 700;">Sl No</th>
                <th style="font-size: 14px; font-weight: 700;">Description</th>
                <th style="font-size: 14px; font-weight: 700;">Recieved</th>
                <th style="font-size: 14px; font-weight: 700;">Payment</th>
            </tr>
        </thead>
        <tbody>
            <tr>
               <td style="text-align: center;">01</td>
               <td ><?php echo $CPROW->CPayment_notes; ?></td>
               <td style="text-align: center;"><?php if($type == 'CR'): echo number_format($CPROW->CPayment_amount, 2); else: echo '00.00'; endif; ?></td>
               <td style="text-align: center;" ><?php if($type == 'CP'): echo number_format($CPROW->CPayment_amount, 2); else: echo '00.00'; endif; ?></td>
            </tr>
            <tr>
                <th colspan="2" style="font-size: 14px; font-weight: 700; text-align: right;">Total:</th>
                <th style="font-size: 13px; font-weight: 700;"><?php if($type == 'CR'): echo number_format($CPROW->CPayment_amount, 2); else: echo '00.00'; endif; ?></th>
                <th style="font-size: 13px; font-weight: 700;"><?php if($type == 'CP'): echo number_format($CPROW->CPayment_amount, 2); else: echo '00.00'; endif; ?></th>
            </tr>
        </tbody>
    </table>
    <div class="row" style="width: 94%; margin-bottom: 20px; padding: 0 15px;">
        <h6 style=" font-size: 12px; font-weight: 600; padding: 5px;">Paid (In Word): <?php echo convertNumberToWord($CPROW->CPayment_amount);?></h6>
    </div>
    <div class="row" style="width: 94%; margin-bottom: 20px; padding: 0 10px;">
        <table style="width: 20%; float: left;">
            <tr>
                <td  style="font-size: 13px; font-weight: 600; ">Previous Due : </td>
                <td  style="font-size: 13px; font-weight: 600; text-align: right; "> <?php echo number_format($prevdueAmont, 2); ?></td>
            </tr>
            <tr>
                <td  style="font-size: 13px; font-weight: 600; border-bottom: 2px solid #000; ">Paid Amount : </td>
                <td  style="font-size: 13px; font-weight: 600; border-bottom: 2px solid #000; text-align: right; "><?php echo number_format($CPROW->CPayment_amount, 2); ?></td>
            </tr>
            <tr>
                <td style="font-size: 13px; font-weight: 600; ">Current Due : </td>
                <td style="font-size: 13px; font-weight: 600; text-align: right; "><?php echo number_format($totalDue, 2); ?></td>
            </tr>
        </table>
    </div>
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

<?php 

  function convertNumberToWord($num = false){
      $num = str_replace(array(',', ' '), '' , trim($num));
      if(! $num) {
          return false;
      }
      $num = (int) $num;
      $words = array();
      $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
          'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
      );
      $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
      $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
          'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
          'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
      );
      $num_length = strlen($num);
      $levels = (int) (($num_length + 2) / 3);
      $max_length = $levels * 3;
      $num = substr('00' . $num, -$max_length);
      $num_levels = str_split($num, 3);
      for ($i = 0; $i < count($num_levels); $i++) {
          $levels--;
          $hundreds = (int) ($num_levels[$i] / 100);
          $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '');
          $tens = (int) ($num_levels[$i] % 100);
          $singles = '';
          if ( $tens < 20 ) {
              $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
          } else {
              $tens = (int)($tens / 10);
              $tens = ' ' . $list2[$tens] . ' ';
              $singles = (int) ($num_levels[$i] % 10);
              $singles = ' ' . $list1[$singles] . ' ';
          }
          $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
      } //end for loop
      $commas = count($words);
      if ($commas > 1) {
          $commas = $commas - 1;
      }
      $inword = implode(' ', $words) ."Taka Only";
    return strtoupper($inword);
  }
  
?>
