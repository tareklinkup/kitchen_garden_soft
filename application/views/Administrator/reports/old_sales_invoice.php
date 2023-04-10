<?php
$brunch=$this->session->userdata('BRANCHid');
$query=$this->db->query("SELECT * FROM tbl_company WHERE company_BrunchId='$brunch'");
//$query=mysql_query("SELECT * FROM tbl_company");
$row=$query->row();
//echo "<pre>";print_r($row);exit;
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


	<!-----------------    Print Type -- POS      ------------>
<?php if($row->print_type == 3) { ?>

      <table width="270" >
       <tr>
		<td width="0%">
			 <!--<img src="<?php //echo base_url();?>uploads/company_profile_thum/<?php //echo $row->Company_Logo_org; ?>" alt="Logo" style="width:80%;float:right;">-->
		</td>
		
          <td width="100%">
            <div class="">
				<div style="text-align:center;" >
					<strong style="font-size:18px"><?php echo $row->Company_Name; ?></strong><br>
					<?php echo $row->Repot_Heading; ?><br>
				</div>
			</div>
          </td>
        </tr>

        <tr>
            <td colspan="2" style="background:#ddd;" align="center"><strong style="font-size:16px;">Sales Invoice</strong></td>
        </tr>
		
        <tr>
            <td colspan="2">
            <!-- Page Body -->
           <?php 
            /* $sql = mysql_query("SELECT tbl_salesmaster.*, tbl_salesmaster.AddBy as served, tbl_customer.*,genaral_customer_info.* FROM tbl_salesmaster left join tbl_customer on tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo LEFT JOIN genaral_customer_info ON genaral_customer_info.G_Sale_Mastar_SiNO=tbl_salesmaster.SaleMaster_SlNo where tbl_salesmaster.SaleMaster_SlNo = '$SalesID'");
            $selse = mysql_fetch_array($sql); */ ?>
              <table  cellspacing="0" cellpadding="0" width="100%">
                <tr>
                  <td>
                    <table width="100%">
					  <tr>
                          <td>Customer ID</td>
						  <td>:</td>
						  <td><?php echo $selse->Customer_Code; ?></td>
					  </tr> 
					  
					  <tr>
                         <td>Customer Name</td>
						  <td>:</td>
						    <td><?php 
                        $Type=$selse->Customer_Type;
                        if ($Type=='G') {
                            echo $selse->G_Name; 
                        }else{
                            echo $selse->Customer_Name;
                        }
                        
                        ?>
                        </td>
					  </tr> 
					  
					  <tr>
                          <td>Contact no</td>
						  <td>:</td>
						   <td><?php 
                         
                        if ($Type=='G') {
                            echo $selse->G_Mobile;                            
                        }else{
                            echo $selse->Customer_Mobile; 
                        }
                        ?></td>
					  </tr> 
					  
					  <tr>
                           <td>Sale By</td>
						  <td>:</td>
						   <td><?php echo $selse->served; ?></td>
					  </tr> 
					  
					  <tr>
                           <td>Invoice no</td>
						 
						  <td>:</td>
						  <td><?php echo $selse->SaleMaster_InvoiceNo; ?></td>
					  </tr> 
					  
					  <tr>
                           <td>Sales Date</td>
						   <td>:</td>
						  <td><?php echo $selse->SaleMaster_SaleDate; ?></td>
					  </tr>
						<tr>
							<td>Payment Type</td>
							<td>:</td>
							<td><?php echo $selse->payment_type; ?></td>
						</tr>

					</table>
                  </td>
				  
                  <td>
                   
                </td>
            
            <!-- Page Body end -->
        </tr>
		
		
        <tr>
          <td colspan="2">
            <table class="border" cellspacing="0" cellpadding="0" width="100%">
                <tr align="center">
					<td>SL</td>
					<td>Product Name</td>
					<!-- <td>Category</td> -->
					<td>Qty</td>
					<td>Rate</td>
					<td>Discount</td>
					<td>Total</td>
                </tr>
				
                <?php $i = "";
				$totalamount = "";
				$packageName ="";
				$Ptotalamount = "";
				$ssql = $this->db->query("SELECT tbl_saledetails.*, tbl_product.*,tbl_productcategory.*,tbl_color.*,tbl_brand.*  FROM tbl_saledetails left join tbl_product on tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo LEFT JOIN tbl_productcategory ON tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand where tbl_saledetails.SaleMaster_IDNo = '$SalesID'");
				$rows = $ssql->result();
				foreach($rows as $rows){ 
			   
				$packageName = $rows->packageName;
				if($packageName==""){
					$amount = ($rows->SaleDetails_Rate*$rows->SaleDetails_TotalQuantity) - $rows->Discount_amount;
					$totalamount = $totalamount+$amount;
				$i++;
        ?>
		
        <tr align="center">
            <td><?php echo $i; ?></td>
            <td><?php echo $rows->Product_Name; ?></td>
           <!--  <td><?php echo $rows->ProductCategory_Name; ?></td> -->
            <td><?php echo $rows->SaleDetails_TotalQuantity; ?> <?php echo $rows->SaleDetails_unit; ?></td>
            <td><?php echo $rows->SaleDetails_Rate; ?></td>
			<td><?php echo $rows->Discount_amount; ?></td>
            <td  style="text-align: right;"><?php echo number_format($amount,2); ?></td>
        </tr>
		
        <?php 
			} 
		}
           $ssql = $this->db->query("SELECT tbl_saledetails.*, tbl_product.*,tbl_productcategory.*,tbl_color.*,tbl_brand.*  FROM tbl_saledetails left join tbl_product on tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo LEFT JOIN tbl_productcategory ON tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand where tbl_saledetails.SaleMaster_IDNo = '$SalesID'");
			$rows = $ssql->result();
			foreach($rows as $rows){ 
            $packageName = $rows->packageName; $i++;
                if($rows->packageName!=""){
                $Pamount = $rows->packSellPrice*$rows->SeleDetails_qty;
                $Ptotalamount = $Ptotalamount+$Pamount;
            ?>
            <tr>
                <td align="center"><?php echo $i; ?></td>
                <td><?php echo $rows->packageName; ?></td>
                <td align="center"><?php echo $rows->SeleDetails_qty; ?> <?php echo $rows->SaleDetails_unit; ?></td>
                <td align="center"><?php echo $rows->packSellPrice; ?></td>
                <td><?php echo $Pamount; ?></td>
            </tr>
        <?php } }?>
        <tr>
            <td style="border:0px;text-align:right;" colspan="3">Sub Total</td>
			<td style="border:0px;text-align:right;">:</td>
            <td style="border:0px;text-align:right;"><?php $totalamount =$totalamount+$Ptotalamount; echo number_format($totalamount,2); ?></td>
        </tr>
		
          <tr>
            <!--<td  style="border:0px"><strong>Previous Due</strong></td>
            <td style="border:0px;color:red;">-->
                <!-- Previous Due Customer -->
                <?php $cusotomerID = $selse->Customer_SlNo; 
                    $Customerpaid='';
                    $Customerpurchase='';
                    $sql = $this->db->query("SELECT * FROM tbl_customer_payment WHERE CPayment_customerID = '".$cusotomerID."'");
                    $row = $sql->result();
					//echo "<pre>";print_r($row);exit;
					foreach($row as $row){
                        $Customerpaid = $Customerpaid+$row->CPayment_amount;    
                    }
					
                    $sqls = $this->db->query("SELECT * FROM tbl_salesmaster WHERE SalseCustomer_IDNo = '".$cusotomerID."'");
                    $rows = $sqls->result();
					foreach($rows as $rows){
                        $Customerpurchase = $Customerpurchase +$rows->SaleMaster_SubTotalAmount; 
                    }
                    $vat = $selse->SaleMaster_TaxAmount;  $vat = ($totalamount*$vat)/100;
                    $all = $totalamount-$selse->SaleMaster_TotalDiscountAmount+ $selse->SaleMaster_Freight+$vat-$selse->SaleMaster_RewordDiscount;  $CurrenDue = $all-$selse->SaleMaster_PaidAmount;
                     $previousdue= $Customerpurchase-$Customerpaid;
                     $previousdue = $previousdue-$CurrenDue;
                    //if($previousdue==''){echo'0';}echo $previousdue;
                ?>
                <!-- Previous Due Customer End 
            </td>-->
            <td style="border:0px;text-align:right;" colspan="3">Vat </td>
			<td style="border:0px;text-align:right;">:</td>
            <td style="border:0px;text-align:right;"><?php echo number_format($vat,2); ?></td>
        </tr>
		
        <!--<tr>
            <td style="border:0px"><strong>Current Due</strong></td>
            <td style="border:0px;color:red;"><?php //if($CurrenDue==''){echo '0';} echo $CurrenDue ?></td>
            <td style="border:0px;text-align:right;" colspan="2">Frieght</td>
			<td style="border:0px;text-align:right;">:</td>
            <td style="border:0px;text-align:right;"><?php $Frieght = $selse->SaleMaster_Freight; echo number_format($Frieght,2) ?></td>
        </tr>-->
        <tr>
            <!--<td style="border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"><strong>Totul Due</strong> </td>
            <td style="color:red;border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"><?php //if($previousdue+$CurrenDue==''){echo '0';} echo $previousdue+$CurrenDue; ?></td>-->
            <td style="border:0px;text-align:right;" colspan="3">Discount </td>
			<td style="border:0px;text-align:right;">:</td>
            <td style="border:0px;text-align:right;"><?php $discount = $selse->SaleMaster_TotalDiscountAmount;echo number_format($discount,2) ?></td>
        </tr>
        <tr>
            
            <!--<td style="border:0px"></td>
            <td style="border:0px"></td>-->
            <td style="border:0px;text-align:right;" colspan="3">Round Off</td>
			<td style="border:0px;text-align:right;">:</td>
            <td style="border:0px;text-align:right;"><?php $RewordDiscount = $selse->SaleMaster_RewordDiscount;echo number_format($RewordDiscount,2) ?></td>
        </tr>
                 <tr>
                    <td colspan="5" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
                   
                </tr>
                <tr>
                    <td style="border:0px;text-align:right;" colspan="3" >Total </td>
					<td style="border:0px;text-align:right;">:</td>
                    <td style="border:0px;text-align:right;"><?php $grandtotal = $totalamount-$discount+ $Frieght+$vat-$RewordDiscount; echo number_format($grandtotal,2)?></td>
                </tr>
                <tr>
                    <td style="border:0px;text-align:right;" colspan="3">Paid</td>
					<td style="border:0px;text-align:right;">:</td>
                    <td style="border:0px;text-align:right;"><?php $paid = $selse->SaleMaster_PaidAmount; echo number_format($paid,2);?></td>
                </tr>
                <tr>
                    <td colspan="5" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
                   
                </tr>
                <tr>
                    <td style="border:0px;text-align:right;" colspan="3">Due</td>
					<td style="border:0px;text-align:right;">:</td>
                    <td style="border:0px;text-align:right;"><?php echo number_format($grandtotal-$paid,2); ?></td>
                </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <p><strong>Total (in word): </strong><?php

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
          </td>
        </tr>

		</table>
		</td>
        </tr>
		
		<tr>
          <td colspan="2">
			 <h4>Notes: <?php  echo $selse->SaleMaster_Description; ?></h4>
		  </td>
		</tr>
		
			<tr>
			 <td width="100%" colspan="2">
			<div class="">
				<span style="border-top:1px solid #000;float:right;">
					Authorize Signature
				</span>
			</div>
		  </td>
		</tr>
		<tr>
          <td width="100%" colspan="2">
			<!--<div class="">
				<span style="font-size:11px;float:left;">
				<i>"THANK YOU FOR YOUR BUSINESS"</i><br>
				Software Provied By Link-Up Technology</span>
			</div>-->
			</td>
			</tr>
			
    </table>
		<!-----------------    Print Type -- A4/2      ------------>
<?php }elseif($row->print_type == 2){ ?>
<div style="float: left;">
<div style="width: 380px; height: 107px; margin: auto; margin-left:-0px; ">
    <div style="width:20%; float: left; ">
        <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:80px;" />
    </div>
    <div style="width:80%; text-align: center; float: left;">
        <strong style="font-size:16px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
            <?php echo $branch_info->Repot_Heading; ?><br/>
    </div>
</div>
 
<table  cellspacing="0" cellpadding="0" width="480">
        <tr>
             <td colspan="2" style="background:#ddd;" align="center"><strong style="font-size:16px;">Sales Invoice</strong></td>
        </tr>
        <tr>
            <td>
                <table width="130%">
                    <tr>
                        <td><strong>Customer ID </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->Customer_Code; ?></td>
                    </tr> 
                    <tr>
                        <td width="35%"><strong> Name </strong></td>
                        <td>:</td>
                        <td><?php 
                        $Type=$selse->Customer_Type;
                        if ($Type=='G') {
                            echo $selse->G_Name; 
                        }else{
                            echo $selse->Customer_Name;
                        }
                        ?>
                            
                        </td>
                    </tr> 
                    <tr>
                        <td><strong> Address </strong></td>
                        <td>:</td>
                        <td><?php 
                        if ($Type=='G') {
                            echo $selse->G_Address;
                        }else{
                            echo $selse->Customer_Address; 
                        }
                        ?>
                            
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Contact no </strong></td>
                        <td>:</td>
                        <td><?php 
                         
                        if ($Type=='G') {
                            echo $selse->G_Mobile;                            
                        }else{
                            echo $selse->Customer_Mobile; 
                        }
                        ?></td>
                    </tr>              
                </table>
            </td>
            <td>
                <table width="70%">
                    <tr>
                        <td><strong>Sale By </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->served; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Invoice no </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->SaleMaster_InvoiceNo; ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Sales Date </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->SaleMaster_SaleDate; ?></td>
                    </tr>
					<tr>
						<td><strong>Payment Type</strong></td>
						<td>:</td>
						<td><?php echo $selse->payment_type; ?></td>
					</tr>
                     
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr><hr></td>
            <td colspan="2"><br></td>
        </tr>
    </table>
    
    <table class="border" cellspacing="0" cellpadding="0" width="480">
        <tr>
			<th style="text-align:center;">SI No.</th>
            <!-- <th style="text-align:center;">Category</th> -->
            <th style="text-align:center;">Product Name</th>
			<th style="text-align:center;">Brand</th>
			<!--<th style="text-align:center;">Body Rate</th>-->
			<th style="text-align:center;">Unit Price</th>
			<th style="text-align:center;">Quantity</th>
			<th style="text-align:center;">Discount</th>
			<th style="text-align:center;">Amount</th>
        </tr>
        <?php $i = "";
        $totalamount = "";
        $packageName ="";
        $Ptotalamount = "";
        $ssql = $this->db->query("SELECT tbl_saledetails.*, tbl_product.*,tbl_productcategory.*,tbl_color.*,tbl_brand.*  FROM tbl_saledetails left join tbl_product on tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo LEFT JOIN tbl_productcategory ON tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand where tbl_saledetails.SaleMaster_IDNo = '$SalesID'");
			$rows = $ssql->result();
			foreach($rows as $rows){ 
           
            $packageName = $rows->packageName;
            if($packageName==""){
				$amount = ($rows->SaleDetails_Rate*$rows->SaleDetails_TotalQuantity) - $rows->Discount_amount;
				$totalamount = $totalamount+$amount;
            $i++;
        ?>
          <tr>
			  <td><?php echo $i; ?></td>
              <!-- <td><?php //echo $rows->ProductCategory_Name; ?></td> -->
              <td><?php echo $rows->Product_Name; ?></td>
			  <td><?php echo $rows->brand_name; ?></td>
			  <!--<td><?php //echo $rows->body_rate; ?></td>-->
			  <td><?php echo $rows->SaleDetails_Rate; ?></td>
			  <td><?php echo $rows->SaleDetails_TotalQuantity; ?> <?php echo $rows->SaleDetails_unit; ?></td>
			  <td><?php echo $rows->Discount_amount; ?></td>
			  <td><?php echo number_format($amount , 2); ?></td>
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
                <td><?php echo $Pamount; ?></td>
            </tr>
        <?php } }?>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td colspan="2" style="border:0px"><strong>Sub Total :</strong> </td>
            <td colspan="" style="border:0px;text-align: right;"><?php $totalamount =$totalamount+$Ptotalamount; echo number_format($totalamount,2); ?></td>
        </tr>
		
          <tr>
            <td  colspan="2" style="border:0px"><strong>Previous Due</strong></td>
            <td  style="border:0px;color:red;">
                <!-- Previous Due Customer -->
                <?php $cusotomerID = $selse->Customer_SlNo; 
                    $Customerpaid='';
                    $Customerpurchase='';
                    $sql = $this->db->query("SELECT * FROM tbl_customer_payment WHERE CPayment_customerID = '".$cusotomerID."'");
                    $row = $sql->result();
				   foreach($row as $row){
                        $Customerpaid = $Customerpaid+$row->CPayment_amount;    
                    }
                    $sqls = $this->db->query("SELECT * FROM tbl_salesmaster WHERE SalseCustomer_IDNo = '".$cusotomerID."'");
					$rows = $sqls->result();
				   foreach($rows as $rows){
                        $Customerpurchase = $Customerpurchase +$rows->SaleMaster_SubTotalAmount; 
                    }
                    $vat = $selse->SaleMaster_TaxAmount;  $vat = ($totalamount*$vat)/100;
                    $all = $totalamount-$selse->SaleMaster_TotalDiscountAmount+ $selse->SaleMaster_Freight+$vat-$selse->SaleMaster_RewordDiscount;  $CurrenDue = $all-$selse->SaleMaster_PaidAmount;
                     $previousdue= $Customerpurchase-$Customerpaid;
                     $previousdue = $previousdue-$CurrenDue;
                    if($previousdue=='' || $previousdue < 0 ){echo'0';}else{ echo number_format(round($previousdue), 2);};
                ?>
                <!-- Previous Due Customer End -->
            </td>
            <td colspan="1" style="border:0px"></td>
            <td  colspan="2" style="border:0px"><strong>Vat :</strong> </td>
            <td style="border:0px;text-align: right;"><?php echo $vat ?></td>
        </tr>
		
        <tr>
			<td colspan="2" style="border:0px"><strong>Current Due</strong></td>
            <td style="border:0px;color:red;"><?php if($CurrenDue==''){echo '0';} else{echo number_format(round($CurrenDue), 2);} ?></td>
            <td colspan="1" style="border:0px"></td>
            <td colspan="2" style="border:0px"><strong>Discount :</strong> </td>
            <td style="border:0px;text-align: right;"><?php $discount = round($selse->SaleMaster_TotalDiscountAmount) ;echo number_format($discount,2) ?></td>
        </tr>
        <tr>
            <td colspan="2" style="border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"><strong>Totul Due</strong> </td>
            <td style="color:red;border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"><?php if($previousdue+$CurrenDue==''){echo '0';}else{echo $previousdue+$CurrenDue;}  ?></td>
            <td colspan="1" style="border:0px"></td>
            <td  colspan="2" style="border:0px"><strong>Round Off :</strong> </td>
            <td style="border:0px;text-align: right;"><?php $RewordDiscount = $selse->SaleMaster_RewordDiscount;echo number_format($RewordDiscount,2) ?></td>
        </tr>
		 <tr>
		  
			 <td colspan="4" style="border:0px"></td>
			<td colspan="3" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
		   
		</tr>
		<tr>
			<td colspan="4" style="border:0px"></td>
			<td colspan="2"  style="border:0px"><strong>Total :</strong> </td>
			<td style="border:0px;text-align: right;"><strong><?php $grandtotal = $totalamount-$discount+$vat-$RewordDiscount; echo number_format($grandtotal,2)?></strong></td>
		</tr>
		<tr>
			<td colspan="4" style="border:0px"></td>
			<td colspan="2" style="border:0px"><strong>Paid :</strong> </td>
			<td style="border:0px;text-align: right;"><?php $paid = $selse->SaleMaster_PaidAmount; echo number_format($paid,2);?></td>
		</tr>
		<tr>
			<td colspan="4" style="border:0px"></td>
			<td colspan="3" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
		   
		</tr>
		<tr>
			<td colspan="4" style="border:0px"></td>
			<td colspan="2"  style="border:0px"><strong>Due :</strong> </td>
			<td style="border:0px;text-align: right;"><?php echo number_format($grandtotal-$paid,2); ?></td>
		</tr>
		
    </table>
    <p><strong>Total (in word): </strong><?php
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
    <p><strong>Notes: </strong> <?php echo $selse->SaleMaster_Description; ?></p>
</div>

	
	
	<!-----------------    Print Type -- A4      ------------>
	
<?php }elseif($row->print_type == 1){ ?>

    <div style="width: 100%; height: auto; padding: 0px 43px; ">
        <div style="width:12%; float: left;">
            <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;" />
        </div>
        <div style="width:88%; text-align: left; float: left; ">
            <strong style="font-size:26px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
                <?php echo $branch_info->Repot_Heading; ?><br/>
        </div>
        <div style=" clear: both;"></div>
        <div style="border-bottom: 3px solid #000; width: 90%; margin-bottom: 2px; float: left;"></div>
        <div style="border-bottom: 1px solid #000; width: 90%; float: left; margin-bottom: 10px; "></div>
    </div>


	<table  cellspacing="0" cellpadding="0" width="90%">
        <tr>
            <td colspan="2" style="background:#ddd; padding: 5px 0;" align="center"><strong style="font-size:18px;">Sales Invoice</strong></td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="margin: 10px 0; ">
                    <tr>
                        <td><strong>Customer ID </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->Customer_Code; ?></td> 
                    </tr> 
                    <tr>
                        <td width="35%"><strong>Customer Name </strong></td>
                        <td>:</td>
                        <td><?php 
                        $Type=$selse->Customer_Type;
                        if ($Type=='G') {
                            echo $selse->G_Name; 
                        }else{
                            echo $selse->Customer_Name;
                        }
                        ?>
                            
                        </td>
                    </tr> 
                    <tr>
                        <td><strong>Customer Address </strong></td>
                        <td>:</td>
                        <td><?php 
                        if ($Type=='G') {
                            echo $selse->G_Address;
                        }else{
                            echo $selse->Customer_Address; 
                        }
                        ?>
                            
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Contact no </strong></td>
                        <td>:</td>
                        <td><?php 
                         
                        if ($Type=='G') {
                            echo $selse->G_Mobile;                            
                        }else{
                            echo $selse->Customer_Mobile; 
                        }
                        ?></td>
                    </tr>              
                </table>
            </td>
            <td>
                <table width="100%">
                    <tr>
                        <td><strong>Invoice no </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->SaleMaster_InvoiceNo; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Payment Type</strong></td>
                        <td>:</td>
                        <td><?php echo $selse->payment_type; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Sales Date </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->SaleMaster_SaleDate; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Sale By </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->served; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr></td>
        </tr>
    </table>
    
    <table class="border" cellspacing="0" cellpadding="0" width="90%">
        <tr>
			<th style="text-align:center; width: 5%;">SI No.</th>
			<!-- <th style="text-align:center;">Category</th> -->
			<th style="text-align:left; width: 40%;">Product Name</th>
			<!--<th style="text-align:center;">Body Rate</th>-->
			<th style="text-align:center;">Unit Price</th>
			<th style="text-align:center;">Quantity</th>
			<!-- <th style="text-align:center;">Unit</th> -->
			<th style="text-align:center;">Discount</th>
			<th style="text-align:center;">Amount</th>
        </tr>
        <?php $i = "";
        $totalamount = "";
        $packageName ="";
        $Ptotalamount = "";
        $ssql = $this->db->query("SELECT tbl_saledetails.*, tbl_product.*,tbl_productcategory.*,tbl_color.*,tbl_brand.*  FROM tbl_saledetails left join tbl_product on tbl_product.Product_SlNo = tbl_saledetails.Product_IDNo LEFT JOIN tbl_productcategory ON tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand where tbl_saledetails.SaleMaster_IDNo = '$SalesID'");
			$rows = $ssql->result();
			foreach($rows as $rows){ 
            $packageName = $rows->packageName;
            if($packageName==""){
				$amount = ($rows->SaleDetails_Rate*$rows->SaleDetails_TotalQuantity) - $rows->Discount_amount;
				$totalamount = $totalamount+$amount;
            $i++;
        ?>
		<tr align="center">
			<td><?php echo $i; ?></td>
			<!-- <td><?php //echo $rows->ProductCategory_Name; ?></td> -->
			<td style="text-align: left"><?php echo $rows->Product_Name; ?></td>
			<!--<td><?php //echo $rows->body_rate; ?></td>-->
			<td><?php echo $rows->SaleDetails_Rate; ?></td>
			<td><?php echo $rows->SaleDetails_TotalQuantity.' '.$rows->SaleDetails_unit; ?></td>
			<!-- <td> <?php //echo $rows->SaleDetails_unit; ?></td> -->
			<td> <?php echo $rows->Discount_amount; ?></td>
			<td><?php echo number_format($amount, 2); ?></td>
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
                <td><?php echo $Pamount; ?></td>
            </tr>
        <?php } }?>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td style="border:0px">Sub Total : </td>
            <td style="border:0px;text-align: right;"><?php $totalamount =$totalamount+$Ptotalamount; echo number_format($totalamount,2); ?></td>
        </tr>
        
        <tr>
            <td  style="border:0px">Previous Due</td>
            <td  style="border:0px;color:red;">
                <!-- Previous Due Customer -->
                <?php $cusotomerID = $selse->Customer_SlNo; 
                    $Customerpaid='';
                    $Customerpurchase='';
                   // ====================
                    $salesMaster = $this->db->where('SalseCustomer_IDNo', $cusotomerID)->select_sum('SaleMaster_DueAmount')->get('tbl_salesmaster')->row();
                    $dueAm =  $salesMaster->SaleMaster_DueAmount;
                    // ====================
                    $payAmount = $this->db->where('CPayment_customerID',$cusotomerID)->where('CPayment_TransactionType','CP')->select_sum('CPayment_amount')->get('tbl_customer_payment')->row();
                    $payAm = $payAmount->CPayment_amount;
                    // ====================
                    $paidAmount = $this->db->where('CPayment_customerID',$cusotomerID)->where('CPayment_TransactionType','CR')->select_sum('CPayment_amount')->get('tbl_customer_payment')->row();
                    $paidAm = $paidAmount->CPayment_amount;
                    // ====================
                    $prevDueAmount = $this->db->where('Customer_SlNo',$cusotomerID)->get('tbl_customer')->row();
                    $prevDue = $prevDueAmount->previous_due;


                    $sqls = $this->db->query("SELECT * FROM tbl_salesmaster WHERE SalseCustomer_IDNo = '".$cusotomerID."'");
                    $rows = $sqls->result();
                    foreach($rows as $rows){
                        $Customerpurchase = $Customerpurchase +$rows->SaleMaster_SubTotalAmount; 
                    }
                    //echo $Customerpaid."<br>";
                    //echo $Customerpurchase;
                    $vat = $selse->SaleMaster_TaxAmount;  
                    $vat = ($totalamount*$vat)/100;
                    $all = $totalamount-$selse->SaleMaster_TotalDiscountAmount+ $selse->SaleMaster_Freight+$vat-$selse->SaleMaster_RewordDiscount;  
                    $CurrenDue = $all-$selse->SaleMaster_PaidAmount;
                    $previousdue= $Customerpurchase-$Customerpaid;
                    $previousdue = $previousdue-$CurrenDue;
                    

                    $tDue =($payAm + $dueAm) - $paidAm;
                    if($tDue+$prevDue): echo number_format($prevDue+$tDue-$CurrenDue,2); else: echo 0; endif;
                ?>
                <!-- Previous Due Customer End -->
            </td>
            <td colspan="2" style="border:0px"></td>
            <td style="border:0px">Vat : </td>
            <td style="border:0px; text-align: right;"><?php echo $vat ?></td>
        </tr>

        <tr>
            <td style="border:0px">Current Due</td>
            <td style="border:0px;color:red;"><?php if($CurrenDue==''){echo '0';} echo number_format($CurrenDue,2) ?></td>
            <td colspan="2" style="border:0px"></td>
            <td style="border:0px">Discount : </td>
            <td style="border:0px;text-align: right;"><?php $discount = $selse->SaleMaster_TotalDiscountAmount;echo number_format($discount,2) ?></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;">Totul Due </td>
            <td style="color:red;border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"><?php if($tDue+$prevDue==''){echo '0';} echo number_format($tDue+$prevDue,2); ?></td>
            <td colspan="2" style="border:0px"></td>
            <td style="border:0px">Round Off : </td>
            <td style="border:0px;text-align: right;"><?php $RewordDiscount = $selse->SaleMaster_RewordDiscount;echo number_format($RewordDiscount,2) ?></td>
        </tr>
         <tr>
            <td colspan="4" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
           
        </tr>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td style="border:0px"><strong>Total :</strong> </td>
            <td style="border:0px;text-align: right;"><strong><?php $grandtotal = $totalamount-$discount+$vat-$RewordDiscount; echo number_format($grandtotal,2)?></strong></td>
        </tr>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td style="border:0px"><strong>Paid :</strong> </td>
            <td style="border:0px;text-align: right;"><?php $paid = $selse->SaleMaster_PaidAmount; echo number_format($paid,2);?></td>
        </tr>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
           
        </tr>
        <tr>
            <td colspan="4" style="border:0px"></td>
            <td style="border:0px"><strong>Due :</strong> </td>
            <td style="border:0px;text-align: right;"><?php echo number_format($grandtotal-$paid,2); ?></td>
        </tr>
         <tr style="border: 0px;">
        <td colspan="8" style="border:0px">
    <p><strong>Total (in word): </strong><?php
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
    <p><strong>Notes: </strong> <?php echo $selse->SaleMaster_Description; ?></p>
	</td>
</tr>
    </table>
<?php } ?>

</body>
</html>

