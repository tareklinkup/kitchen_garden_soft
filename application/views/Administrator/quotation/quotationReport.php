<script>
  function printContent(el){
      var restorepage = document.body.innerHTML;
      var printcontent = document.getElementById(el).innerHTML;
      document.body.innerHTML = printcontent;
      $('.hideInfo').css('display','none');
      $('.hideInfo2').css('display','none');
      window.print();
      location.reload();
      document.body.innerHTML = restorepage;
  }
</script>


<style type="text/css">
  @media  print {
    html, body {
        height: auto;
        font-size: 0px; /* changing to 10pt has no impact */
    }
    #ttable{
        width: 100%;
    }
}
</style>

<html>
    <body>
<div class="table-responsive" style="">
<a style="cursor:pointer" onclick="printContent('printPage')"> <i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a>

<div id="printPage" style="width: 70%;">
  <table  cellspacing="0" cellpadding="0" style="width: 100%;" id="ttable">
        <tr>
            <td colspan="2" style="background:#ddd; border-bottom: 1px solid #ccc; margin-bottom: 15px;" align="center"><strong style="font-size:16px;">Quotation Invoice</strong></td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td width="35%">Customer Name </td>
                        <td>:</td>
                        <td><?php 
                            echo $selse->customer_name;
                        ?>
                            
                        </td>
                    </tr> 
                    <tr>
                        <td>Customer Address </td>
                        <td>:</td>
                        <td><?php 
                            echo $selse->customer_address; 
                        ?>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>Contact no </td>
                        <td>:</td>
                        <td><?php 
                            echo $selse->contact_number; 
                        ?></td>
                    </tr>              
                </table>
            </td>
            <td>
                <table width="100%">
                    <tr class="hideInfo">
                        <td>Memo By </td>
                        <td>:</td>
                        <td><?php echo $selse->served; ?></td>
                    </tr>
                    <tr>
                        <td>Invoice no </td>
                        <td>:</td>
                        <td><?php echo $selse->SaleMaster_InvoiceNo; ?></td>
                    </tr> 
                    <tr class="hideInfo2">
                        <td>Memo Date </td>
                        <td>:</td>
                        <td><?php echo $selse->SaleMaster_SaleDate; ?></td>
                    </tr> 
                     
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
    </table>
    
    <table class="border" cellspacing="0" cellpadding="0" width="100%">
        <tr>
           <th style="text-align:center;">SI No.</th>
           <th style="text-align:center;">Category</th>
           <th style="text-align:center;">Product Name</th>
           <th style="text-align:center;">Unit Price</th>
           <th style="text-align:center;">Quantity</th>
           <th style="text-align:center;">Unit</th>
           <th style="text-align:center;">Amount</th>
        </tr>
        <?php $i = "";
        $totalamount = "";
        $packageName ="";
        $Ptotalamount = "";

      foreach($quo_details as $rows){
            $packageName = $rows->packageName;
            if($packageName==""){
            $amount = $rows->SaleDetails_Rate*$rows->SaleDetails_TotalQuantity;
            $totalamount = $totalamount+$amount;
            $i++;
        ?>
        <tr align="center">
            <td><?php echo $i; ?></td>
            <td><?php echo $rows->ProductCategory_Name; ?></td>
            <td><?php echo $rows->Product_Name; ?></td>
            <td><?php echo $rows->SaleDetails_Rate; ?></td>
            <td><?php echo $rows->SaleDetails_TotalQuantity; ?> </td>
            <td> <?php echo $rows->SaleDetails_unit; ?></td>
            <td><?php echo $amount; ?></td>
        </tr>
        <?php } }
            $ssqls = $this->db->query("SELECT tbl_saledetails.*, tbl_product.*  FROM tbl_saledetails left join tbl_product on tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo where tbl_saledetails.SaleMaster_IDNo = '$SalesID' group by tbl_saledetails.packageName");
            $rows = $ssqls->result();
      foreach($rows as $rows){ $i++;
                if($rows->packageName!=""){
                $Pamount = $rows->packSellPrice*$rows->SeleDetails_qty;
                $Ptotalamount = $Ptotalamount+$Pamount;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $rows->packageName; ?></td>
                <td><?php echo $rows->SeleDetails_qty; ?> <?php echo $rows->SaleDetails_unit; ?></td>
                <td><?php echo $rows->packSellPrice; ?></td>
                <td style="text-align: right;"><?php echo number_format($Pamount,2); ?></td>
            </tr>
        <?php } }?>
       <tr>
            <td colspan="5" style="border:0px"></td>
            <td style="border:0px">Sub Total : </td>
            <td style="border:0px"><?php $totalamount =$totalamount+$Ptotalamount; echo number_format($totalamount,2); ?></td>
        </tr>
        
        <tr>
            <td  style="border:0px;"></td>
            <td  style="border:0px;color:red;"></td>
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px">Vat : </td>
            <td style="border:0px">
                <?php
                    $vat = $selse->SaleMaster_TaxAmount;  
                    $vat = ($totalamount*$vat)/100; 
                    echo $vat 
                ?>
            </td>

        </tr>

        <tr>
            <td style="border:0px;"></td>
            <td style="border:0px;color:red;"></td>
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px">Discount : </td>
            <td style="border:0px"><?php $discount = $selse->SaleMaster_TotalDiscountAmount;echo number_format($discount,2) ?></td>
        </tr>
        <tr>
            <td style="border-left: 0px ;border-right: 0px ;border-bottom: 0px; border-top: 0px solid;"></td>
            <td style="color:red;border:0px; border-top: 0px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px;"></td>
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px">Round Off : </td>
            <td style="border:0px"><?php $RewordDiscount = $selse->SaleMaster_RewordDiscount;echo number_format($RewordDiscount,2) ?></td>
        </tr>
        <tr>
            <td colspan="5" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
           
        </tr>
        <tr>
            <td colspan="5" style="border:0px"></td>
            <td style="border:0px"><strong>Total :</strong> </td>
            <td style="border:0px"><strong><?php $grandtotal = $totalamount-$discount+$vat-$RewordDiscount; echo number_format($grandtotal,2)?></strong></td>
        </tr>
    </table>
    <p>Total (in word): <?php
        function convertNumberToWord($number=false) {
            error_reporting(E_ALL & ~E_NOTICE);
            if(!$number){
                return false;
            }

            $no = round($number);
            $point = round($number - $no, 2) * 100;
            $hundred = null;
            $digits_1 = strlen($no);
            $i = 0;
            $str = array();
            $words = array('0' => '', '1' => 'one', '2' => 'two',
                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                '7' => 'seven', '8' => 'eight', '9' => 'nine',
                '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                '13' => 'thirteen', '14' => 'fourteen',
                '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
                '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                '60' => 'sixty', '70' => 'seventy',
                '80' => 'eighty', '90' => 'ninety');
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
            while ($i < $digits_1) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str [] = ($number < 21) ? $words[$number] .
                        //" " . $digits[$counter] . $plural . " " . $hundred
                        " " . $digits[$counter] . " " . $hundred
                        :
                        $words[floor($number / 10) * 10]
                        . " " . $words[$number % 10] . " "
                        //. $digits[$counter] . $plural . " " . $hundred;
                        . $digits[$counter] . " " . $hundred;
                } else $str[] = null;
            }
            $str = array_reverse($str);
            $result = implode('', $str);
            $points = ($point) ?
                "." . $words[$point / 10] . " " .
                $words[$point = $point % 10] : '';
            return $result;// . "Taka  " . $points . " Paise";
        }
        $inword = convertNumberToWord($grandtotal)."Taka Only";
        echo strtoupper($inword);
        ?></p><br>
    <p>Notes:  <?php echo $selse->SaleMaster_Description; ?></p>
    <!-- <div style="margin-top: 50px;">
    
        <span style="border-top:1px solid #000; float: left; ">
          Customer Signature
        </span>

        <span style="border-top:1px solid #000; float: right;">
          Authorize Signature
        </span>
    </div> -->
    </div>
</div>

</body>
</html>
