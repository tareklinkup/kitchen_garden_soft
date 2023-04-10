<?php
$branchID = $this->session->userdata('BRANCHid');
$PamentID = $this->session->userdata('PamentID');
$SCP = mysql_query("SELECT tbl_customer_payment.*, tbl_customer.* FROM tbl_customer_payment LEFT JOIN tbl_customer ON tbl_customer.Customer_SlNo = tbl_customer_payment.CPayment_customerID WHERE tbl_customer_payment.CPayment_id = '$PamentID'");
$CPROW = mysql_fetch_array($SCP);
$CUSID = $CPROW['CPayment_customerID'];
$paid = $CPROW['CPayment_amount'];
?>

<link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
<div class="content_scroll" style="padding:120px 20px 25px 160px">
<a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>Administrator/reports/customer_advance_payment', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><img src="<?php echo base_url(); ?>images/printer.png" alt=""> Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a href="<?php echo base_url();?>Administrator/customer/customer_due" title="" class="buttonAshiqe">Go Back</a>


    <table  cellspacing="0" cellpadding="0" width="70%">
        <tr>
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Customer Payment Invoice</h2></td>
        </tr>
        <tr>
            <td colspan="2"><hr><hr></td>
            <td colspan="2"><br></td>
        </tr>
    </table>
    
    <table class="border" cellspacing="0" cellpadding="0" width="70%">
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

</div>