<?php

  $type = $this->session->userdata('type');
$brunch=$this->session->userdata('BRANCHid');
$query=mysql_query("SELECT * FROM tbl_company WHERE company_BrunchId='$brunch'");
//$query=mysql_query("SELECT * FROM tbl_company");
$row=mysql_fetch_assoc($query);
//echo "<pre>";print_r($row);exit;
?>
<link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
<div class="content_scroll" style="padding:120px 20px 25px 160px">
<a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>Administrator/quotation/quotationPrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><img src="<?php echo base_url(); ?>images/printer.png" alt=""> Print</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;


<?php if($type == 'q'){ ?>
    <a href="<?php echo base_url();?>Administrator/quotation/index/q" title="" class="buttonAshiqe">Back To Quatation</a>
<?php }else{
?>
    <a href="<?php echo base_url();?>Administrator/quotation/index/m" title="" class="buttonAshiqe">Back To Memo</a>
<?php } ?>

<?php 
  $sql = mysql_query("SELECT tbl_quotation_master.*, tbl_quotation_master.AddBy as served, tbl_quotaion_customer.* FROM tbl_quotation_master left join tbl_quotaion_customer on tbl_quotaion_customer.quotation_customer_id = tbl_quotation_master.SalseCustomer_IDNo where tbl_quotation_master.SaleMaster_SlNo = '$SalesID'");
  $selse = mysql_fetch_array($sql);
  $totalQuotation = $selse['SaleMaster_TotalSaleAmount'];
?>

<table  cellspacing="0" cellpadding="0" width="700">
		<tr>
			<td width="150">
				 <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $row['Company_Logo_org']; ?>" alt="Logo" style="width:100px;">
			</td>
			
			  <td width="550">
						<strong style="font-size:18px"><?php echo $row['Company_Name']; ?></strong><br>
						<?php echo $row['Repot_Heading']; ?><br>
			  </td>
        </tr>
		<?php if($type == 'q'){ ?>
				<tr>
					<td colspan="2" style="background:#ddd;" align="center"><h2> Quatation Invoice </h2></td>
				</tr>
		<?php }else{
			?>
				<tr>
					<td colspan="2" style="background:#ddd;" align="center"><h2> Memo Invoice </h2></td>
				</tr>
		<?php } ?>
        <tr>
            <td>
                <table width="350">
					 <tr>
                          <td>Customer Name</td>
						  <td>:</td>
						  <td><?php echo $selse['customer_name']; ?></td>
					  </tr> 
					  
					  <tr>
                          <td>Contact no</td>
						  <td>:</td>
						  <td><?php echo $selse['contact_number']; ?></td>
					  </tr> 
					  
					  <tr>
                          <td>Address</td>
						  <td>:</td>
						  <td><?php echo $selse['customer_address']; ?></td>
					  </tr> 
                </table>
            </td>
            <td>
                <table width="350">
                    <tr>
                        <td><strong>Memo By </strong></td>
                        <td>:</td>
                        <td><?php echo $selse['served']; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Invoice no </strong></td>
                        <td>:</td>
                        <td><?php echo $selse['SaleMaster_InvoiceNo']; ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Memo Date </strong></td>
                        <td>:</td>
                        <td><?php echo $selse['SaleMaster_SaleDate']; ?></td>
                    </tr> 
                     
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr><hr></td>
            <td colspan="2"><br></td>
        </tr>
    </table>
    
        <table class="border" cellspacing="0" cellpadding="0" width="700">
        <tr>
           <th>SI No.</th>
           <th>Product Name</th>
		   <th>Color</th>
		   <th>Brand</th>
		   <th>Catagory</th>
		   <th>Size</th>           
           <th>Quantity</th>
           <th>Rate</th>
           <th>Amount</th>
        </tr>
        <?php $i = "";
        $totalamount = "";
        $packageName ="";
        $Ptotalamount = "";
        // $ssql = mysql_query("SELECT tbl_saledetails.*, tbl_product.*,tbl_productcategory.*,tbl_color.*,tbl_brand.*  FROM tbl_saledetails left join tbl_product on tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo LEFT JOIN tbl_productcategory ON tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand where tbl_saledetails.SaleMaster_IDNo = '$SalesID'");

         $ssql = mysql_query("SELECT tbl_quotation_details.*, tbl_product.*,tbl_productcategory.*,tbl_color.*,tbl_brand.*  FROM tbl_quotation_details left join tbl_product on tbl_product.Product_SlNo = tbl_quotation_details.Product_IDNo LEFT JOIN tbl_productcategory ON tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand where tbl_quotation_details.SaleMaster_IDNo = '$SalesID'");


        while($rows = mysql_fetch_array($ssql)){ 
           
            $packageName = $rows['packageName'];
            if($packageName==""){
            $amount = $rows['SaleDetails_Rate']*$rows['SaleDetails_TotalQuantity'] ;
            $totalamount = $totalamount+$amount;
            $i++;
        ?>
        <tr>
            <td><?php echo $i; ?></td>
            <td><?php echo $rows['Product_Name'] ?></td>
            <td><?php echo $rows['color_name'] ?></td>
            <td><?php echo $rows['brand_name'] ?></td>
            <td><?php echo $rows['ProductCategory_Name'] ?></td>
            <td><?php echo $rows['size'] ?></td>
            <td><?php echo $rows['SaleDetails_TotalQuantity'] ?> <?php echo $rows['SaleDetails_unit'] ?></td>
            <td><?php echo $rows['SaleDetails_Rate'] ?></td>
            <td><?php echo $amount; ?></td>
        </tr>
        <?php } }
            $ssqls = mysql_query("SELECT tbl_saledetails.*, tbl_product.*  FROM tbl_saledetails left join tbl_product on tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo where tbl_saledetails.SaleMaster_IDNo = '$SalesID' group by tbl_saledetails.packageName");
            while($rows = mysql_fetch_array($ssqls)){ $i++;
                if($rows['packageName']!=""){
                $Pamount = $rows['packSellPrice']*$rows['SeleDetails_qty'] ;
                $Ptotalamount = $Ptotalamount+$Pamount;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $rows['packageName'] ?></td>
                <td><?php echo $rows['SeleDetails_qty'] ?> <?php echo $rows['SaleDetails_unit'] ?></td>
                <td><?php echo $rows['packSellPrice'] ?></td>
                <td><?php echo $Pamount; ?></td>
            </tr>
        <?php } }?>

<?php if($type == 'q'){ ?>
        

<?php }else{ ?>
        <tr>
            <td colspan="7" style="border:0px"></td>
            <td style="border:0px"><strong>Sub Total :</strong> </td>
            <td style="border:0px"><?php $totalamount =$totalamount+$Ptotalamount; echo number_format($totalamount,2); ?></td>
        </tr>
        <tr>
                <?php 
                    $vat = $selse['SaleMaster_TaxAmount'];  
                    $vat = ($totalamount*$vat)/100;
                ?>
            <td colspan="7" style="border:0px"></td>
            <td style="border:0px"><strong>Vat :</strong> </td>
            <td style="border:0px"><?php echo $vat ?></td>
        </tr>
        <tr>
            <td colspan="7" style="border:0px;"></td>
            <td style="border:0px"><strong><?php echo $selse['SaleMaster_freight_name'] ?> :</strong> </td>
            <td style="border:0px"><?php $Frieght = $selse['SaleMaster_Freight']; echo number_format($Frieght,2) ?></td>
        </tr>
        <tr>
            <td colspan="7" style="border:0px"></td>
            <td style="border:0px"><strong>Discount :</strong> </td>
            <td style="border:0px"><?php $discount = $selse['SaleMaster_TotalDiscountAmount'];echo number_format($discount,2) ?></td>
        </tr>
        <tr>
            <td colspan="5" style="border:0px"></td>
            <td style="border:0px"></td>
            <td style="border:0px"></td>
            <td style="border:0px"><strong>Reword-Discount :</strong> </td>
            <td style="border:0px"><?php $RewordDiscount = $selse['SaleMaster_RewordDiscount'];echo number_format($RewordDiscount,2) ?></td>
        </tr>
         <tr>
            <td colspan="7" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
           
        </tr>
        <tr>
            <td colspan="7" style="border:0px"></td>
            <td style="border:0px"><strong>Total :</strong> </td>
            <td style="border:0px"><strong><?php $grandtotal = $totalamount-$discount+ $Frieght+$vat-$RewordDiscount; echo number_format($grandtotal,2)?></strong></td>
        </tr>
        <tr style="display:none;">
            <td colspan="7" style="border:0px"></td>
            <td style="border:0px"><strong>Paid :</strong> </td>
            <td style="border:0px"><?php $paid = $selse['SaleMaster_PaidAmount']; echo number_format($paid,2);?></td>
        </tr>

        <tr style="display:none;">
            <td colspan="7" style="border:0px"></td>
            <td style="border:0px"><strong>Due :</strong> </td>
            <td style="border:0px"><?php echo number_format($grandtotal-$paid,2); ?></td>
        </tr>
<?php } ?>

    </table>

    <p style="margin-top : 20px;"><strong>Total (in word): </strong><?php
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
        $inword = convertNumberToWord($totalamount)."Taka Only";
        echo strtoupper($inword);
        ?></p><br>
    <p><strong>Notes: </strong> <?php echo $selse['SaleMaster_Description']; ?></p>
	
</div>