<?php
$brunch=$this->session->userdata('BRANCHid');
$query=mysql_query("SELECT * FROM tbl_company WHERE company_BrunchId='$brunch'");
$row=mysql_fetch_assoc($query);
?>
<!DOCTYPE html>
<html>
<head>
<title> </title>
<meta charset='utf-8'>
    <link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
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


    <table width="800px" >
        <tr>
          <td>
            <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $row['Company_Logo_org']; ?>" alt="Logo" style="width:100px;margin-bottom:-50px">
            <div class="headline">
            <div style="text-align:center" >
             <strong style="font-size:18px"><?php echo $row['Company_Name']; ?></strong><br>
             <?php echo $row['Repot_Heading']; ?><br>
          
              </div>
          </div>
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
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Customer Payment Invoice</h2></td>
        </tr>
        <tr>
            <td>
            <?php
              $branchID = $this->session->userdata('BRANCHid');
              $PamentID = $this->session->userdata('PamentID');
              $SCP = mysql_query("SELECT tbl_customer_payment.*, tbl_customer.* FROM tbl_customer_payment LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo = tbl_customer_payment.CPayment_customerID WHERE tbl_customer_payment.CPayment_id = '$PamentID'");
              $CPROW = mysql_fetch_array($SCP);
              $CUSID = $CPROW['CPayment_customerID'];
              $paid = $CPROW['CPayment_amount'];
              ?>
            <!-- Page Body -->
              <table class="border" cellspacing="0" cellpadding="0" width="100%">
              <tr>
                 <td style="width:30%"><strong>Date </strong></td>
                 <td style="width:70%"><?php echo $CPROW['CPayment_date']; ?></td>
              </tr>
              <tr>
                 <td style="width:30%"><strong>Customer Name </strong></td>
                 <td style="width:70%"><?php echo $CPROW['Customer_Name']; ?></td>
              </tr>
              <tr>
                 <td style="width:30%"><strong>Customer Phone </strong></td>
                 <td style="width:70%"><?php echo $CPROW['Customer_Phone']; ?></td>
              </tr>
              <tr>
                 <td style="width:30%"><strong>Customer Address </strong></td>
                 <td style="width:70%"><?php echo $CPROW['Customer_Address']; ?></td>
              </tr>
              <tr>
                 <td style="width:30%"><strong>Paid Amount </strong></td>
                 <td style="width:70%"><?php echo number_format($paid, 2); ?></td>
              </tr>
              <tr>
                 <td colspan="2">&nbsp;</td>
              </tr>
              <tr>
                 <td colspan="2"><strong>Paid (In Word) : </strong>
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
                      return implode(' ', $words);
                  }
                  $inword = convertNumberToWord($paid)."Taka Only";
                    echo strtoupper($inword);
                    ?>
                     </td>
                  </tr>
                  
                  

              </table>
              

            </td>
            <!-- Page Body end -->
       
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

