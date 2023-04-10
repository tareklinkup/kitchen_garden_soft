<?php
$brunch=$this->session->userdata('BRANCHid');
$query=$this->db->query("SELECT * FROM tbl_company WHERE company_BrunchId='$brunch'");

$row=$query->row();

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
    <!-- ************************************************************************************************** -->
<?php if($row->print_type == 3) { ?>

      <table width="270" >
       <tr>
		<td width="0%"></td>
		
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
            <td style="border:0px;text-align:right;" colspan="4">Sub Total</td>
			<td style="border:0px;text-align:right;">:</td>
            <td style="border:0px;text-align:right;"><?php $totalamount =$totalamount+$Ptotalamount; echo number_format($totalamount,2); ?></td>
        </tr>
		
          <tr>
                  <?php 						
                        $vat = $selse->SaleMaster_TaxAmount;
                        $vat = ($totalamount * $vat) / 100;

                        $all = $totalamount
                            - $selse->SaleMaster_TotalDiscountAmount
                            + $selse->SaleMaster_Freight
                            + $vat - $selse->SaleMaster_RewordDiscount;

                        $CurrenDue = $all - $selse->SaleMaster_PaidAmount;
              ?>
                <!-- Previous Due Customer End-->

            <td style="border:0px;text-align:right;" colspan="4">Vat </td>
			<td style="border:0px;text-align:right;">:</td>
            <td style="border:0px;text-align:right;"><?php echo number_format($vat,2); ?></td>
        </tr>
		

        <tr>
           <td style="border:0px;text-align:right;" colspan="4">Discount </td>
			<td style="border:0px;text-align:right;">:</td>
            <td style="border:0px;text-align:right;"><?php $discount = $selse->SaleMaster_TotalDiscountAmount;echo number_format($discount,2) ?></td>
        </tr>
        <tr>
            
            <td style="border:0px;text-align:right;" colspan="4">Round Off</td>
			<td style="border:0px;text-align:right;">:</td>
            <td style="border:0px;text-align:right;"><?php $RewordDiscount = $selse->SaleMaster_RewordDiscount;echo number_format($RewordDiscount,2) ?></td>
        </tr>
                 <tr>
                    <td colspan="6" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
                   
                </tr>
                <tr>
                    <td style="border:0px;text-align:right;" colspan="4" >Total </td>
					<td style="border:0px;text-align:right;">:</td>
                    <td style="border:0px;text-align:right;"><?php $grandtotal = $all ; echo number_format($grandtotal,2)?></td>
                </tr>
                <tr>
                    <td style="border:0px;text-align:right;" colspan="4">Paid</td>
					<td style="border:0px;text-align:right;">:</td>
                    <td style="border:0px;text-align:right;"><?php $paid = $selse->SaleMaster_PaidAmount; echo number_format($paid,2);?></td>
                </tr>
                <tr>
                    <td colspan="6" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
                   
                </tr>
                <tr>
                    <td style="border:0px;text-align:right;" colspan="4">Due</td>
					<td style="border:0px;text-align:right;">:</td>
                    <td style="border:0px;text-align:right;"><?php echo number_format($grandtotal-$paid,2); ?></td>
                </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td colspan="3">
            <p><strong>Total (in word): </strong>
            <?= $this->mt->convertNumberToWord($grandtotal);?>
            </p><br>
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

			</td>
			</tr>
			
    </table>
		<!-----------------    Print Type -- A4/2      ------------>
        <!-- ********************************************************************************************** -->

<?php }elseif($row->print_type == 2){ ?>

<div style="float: left;">
<div style="width: 480px; height: 107px; margin: auto; margin-left:-0px; ">
    <div style="width:20%; float: left; ">
        <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:80px;" />
    </div>
    <div style="width:80%; text-align: left; float: left;">
        <strong style="font-size:22px;">
         <?php echo $branch_info->Company_Name; ?>
        </strong><br/>
            <?php echo $branch_info->Repot_Heading; ?><br/>
    </div>
    <div style=" clear: both;"></div>
    <div style="border-bottom: 3px solid #000; width: 100%; margin-bottom: 2px; float: left;"></div>
    <div style="border-bottom: 1px solid #000; width: 100%; float: left; margin-bottom: 10px; "></div>
</div>
 
    <table  cellspacing="0" cellpadding="0" width="480">
        <tr>
             <td colspan="2" style="background:#ddd; padding: 3px 0;" " align="center"><strong style="font-size:16px;">Sales Invoice</strong></td>
        </tr>
        <tr>
            <td>
                <table width="130%" style="margin: 10px 0; ">
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
    </table>
    
    <table class="border" cellspacing="0" cellpadding="0" width="480">
        <tr>
			<th style="text-align:center; width: 10%;">SI No.</th>
            <!-- <th style="text-align:center;">Category</th> -->
            <th style="text-align:left; width: 38%;">Product Name</th>
			<th style="text-align:center;">Brand</th>
			<!--<th style="text-align:center;">Body Rate</th>-->
			<th style="text-align:center;">Unit</th>
			<th style="text-align:center;">Qty/ <br> PCS</th>
			<th style="text-align:center;">Dis</th>
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
              <td style="text-align: left;"><?php echo $rows->Product_Name; ?></td>
			  <td><?php echo $rows->brand_name; ?></td>
			  <!--<td><?php //echo $rows->body_rate; ?></td>-->
			  <td><?php echo $rows->SaleDetails_Rate; ?></td>
			  <td><?php echo $rows->SaleDetails_TotalQuantity; ?> </td>
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
            <td colspan="3" style="border:0px"></td>
            <td colspan="3" style="border:0px"><strong>Sub Total :</strong> </td>
            <td colspan="" style="border:0px;text-align: right;"><?php $totalamount =$totalamount+$Ptotalamount; echo number_format($totalamount,2); ?></td>
        </tr>
		
          <tr>
            <td style="border:0px"><strong>Previous Due</strong></td>
            <td  style="border:0px;color:red; text-align: right;">
                <?php
                $prevDue = $selse->SaleMaster_Previous_Due;
                $CurrenDue = $selse->SaleMaster_DueAmount;
                $totalDue = $CurrenDue + $prevDue;
                echo number_format($prevDue,2);

                $vat = $selse->SaleMaster_TaxAmount;
                $vat = ($totalamount * $vat) / 100;
                $all = $totalamount
                    - $selse->SaleMaster_TotalDiscountAmount
                    + $selse->SaleMaster_Freight
                    + $vat - $selse->SaleMaster_RewordDiscount;
                ?>
                <!-- Previous Due Customer End -->
            </td>
            <td colspan="1" style="border:0px"></td>
            <td  colspan="3" style="border:0px"><strong>Vat :</strong> </td>
            <td style="border:0px;text-align: right;"><?php echo number_format($vat,2) ?></td>
        </tr>
		
        <tr>
			<td style="border:0px"><strong>Current Due</strong></td>
            <td style="border:0px;color:red; text-align: right;"><?= $CurrenDue?number_format((float)$CurrenDue,2):'0.00';?></td>
            <td colspan="1" style="border:0px"></td>
            <td colspan="3" style="border:0px"><strong>Discount :</strong> </td>
            <td style="border:0px;text-align: right;"><?php $discount = round($selse->SaleMaster_TotalDiscountAmount) ;echo number_format($discount,2) ?></td>
        </tr>
        <tr>

            <td  style="border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;">
            <strong>Total Due</strong> </td>
            <td style="color:red;border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ; text-align: right">
                <?= number_format($totalDue,2);  ?></td>
            <td colspan="1" style="border:0px"></td>
            <td  colspan="3" style="border:0px"><strong>Round Off :</strong> </td>
            <td style="border:0px;text-align: right;">
                <?php $RewordDiscount = $selse->SaleMaster_RewordDiscount;echo number_format($RewordDiscount,2) ?>
            </td>
        </tr>
		 <tr>
		  
			 <td colspan="3" style="border:0px"></td>
			<td colspan="4" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
		   
		</tr>
		<tr>
			<td colspan="3" style="border:0px"></td>
			<td colspan="3"  style="border:0px"><strong>Total :</strong> </td>
			<td style="border:0px;text-align: right;"><strong><?php $grandtotal = $all; echo number_format($grandtotal,2)?></strong></td>
		</tr>
		<tr>
			<td colspan="3" style="border:0px"></td>
			<td colspan="3" style="border:0px"><strong>Paid :</strong> </td>
			<td style="border:0px;text-align: right;"><?php $paid = $selse->SaleMaster_PaidAmount; echo number_format($paid,2);?></td>
		</tr>
		<tr>
			<td colspan="3" style="border:0px"></td>
			<td colspan="4" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
		   
		</tr>
		<tr>
			<td colspan="3" style="border:0px"></td>
			<td colspan="3"  style="border:0px"><strong>Due :</strong> </td>
			<td style="border:0px;text-align: right;"><?php echo number_format($grandtotal-$paid,2); ?></td>
		</tr>
		
    </table>
    <p style="border-bottom: 1px solid #ddd;"><strong>Total (in word): </strong>
        <?= $this->mt->convertNumberToWord($grandtotal); ?>
    </p><br>
    
    <p><strong>Notes: </strong> <?php echo $selse->SaleMaster_Description; ?></p>
    <div style="width: 480px; height: auto;  position: absolute; bottom: 50px; margin-bottom: 5px; ">
        <div style="width:30%; float: left;">
            <p style="border-top: 2px solid #000; text-align: center;"> <span>Received By</span></p>
        </div>
        <div style="width:30%; float: right;">
            <p style=" border-top: 2px solid #000; text-align: center;"> <span>Authorized Signature</span></p>
        </div>
        <div style=" clear: both;"></div>
        <div style="width:60%; float: left;">
            <p style="text-transform: uppercase; font-size: 11px;">** Thank You For Your Business **</p>
        </div>
        <div style=" clear: both;"></div>
        <div style="width: 100%; border-bottom: 1px dotted #000;  "></div>
        <div style=" clear: both;"></div>
        <div style="width:60%; float: left;">
            <p style="font-size: 11px;"> Print Date: <?= date('d/m/Y h:i:s A');?> Printed By: <?= $this->session->userdata('FullName');?></p>
        </div>
        <div style="width:40%; float: left;">
            <p style="text-align: right"> Powered By: Link-Up Technology</p>
        </div>
    </div>
</div>

	
	







	<!-----------------    Print Type -- A4      ------------>
	<!-- ************************************************************************************************** -->
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
			<th style="text-align:center; width: 11%;">SI No.</th>
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
                <?php
                $prevDue = $selse->SaleMaster_Previous_Due;
                $CurrenDue = $selse->SaleMaster_DueAmount;
                $totalDue = $CurrenDue + $prevDue;
                echo number_format($prevDue,2);

                $vat = $selse->SaleMaster_TaxAmount;
                $vat = ($totalamount * $vat) / 100;
                $all = $totalamount
                    - $selse->SaleMaster_TotalDiscountAmount
                    + $selse->SaleMaster_Freight
                    + $vat - $selse->SaleMaster_RewordDiscount;
                ?>
                <!-- Previous Due Customer End -->
            </td>
            <td colspan="2" style="border:0px"></td>
            <td style="border:0px">Vat : </td>
            <td style="border:0px; text-align: right;"><?php echo $vat ?></td>
        </tr>

        <tr>
            <td style="border:0px">Current Due</td>
            <td style="border:0px;color:red;"><?= $CurrenDue ? number_format((float)$CurrenDue,2):'0.00' ?></td>
            <td colspan="2" style="border:0px"></td>
            <td style="border:0px">Discount : </td>
            <td style="border:0px;text-align: right;"><?php $discount = $selse->SaleMaster_TotalDiscountAmount;echo number_format($discount,2) ?></td>
        </tr>
        <tr>
            <td style="border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;">Total Due </td>
            <td style="color:red;border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;">
            <?=  number_format($totalDue,2); ?></td>
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
            <td style="border:0px;text-align: right;"><strong><?php $grandtotal = $all; echo number_format($grandtotal,2)?></strong></td>
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
            <p style="border-bottom: 1px solid #ddd;"><strong>Total (in word): </strong>
            <?= $this->mt->convertNumberToWord($grandtotal); ?>
            </p><br>
    <p><strong>Notes: </strong> <?php echo $selse->SaleMaster_Description; ?></p>
	</td>
</tr>
    </table>
    <div style="width: 90%; height: auto; padding: 0px 43px; position: absolute; bottom: 50px; ">
        <div style="width:23%; float: left;">
            <p style="border-top: 2px solid #000; text-align: center;"> <span>Received By</span></p>
        </div>
        <div style="width:23%; float: right;">
            <p style=" border-top: 2px solid #000; text-align: center;"> <span>Authorized Signature</span></p>
        </div>
        <div style=" clear: both;"></div>
        <div style="width:50%; float: left;">
            <p style="text-transform: uppercase;">** Thank You For Your Business **</p>
        </div>
        <div style=" clear: both;"></div>
        <div style="width: 100%; border-bottom: 1px dotted #000;  "></div>
        <div style=" clear: both;"></div>
        <div style="width:50%; float: left;">
            <p> Print Date: <?= date('d/m/Y h:i:s A');?> Printed By: <?= $this->session->userdata('FullName');?></p>
        </div>
        <div style="width:50%; float: left;">
            <p style="text-align: right"> Powered By: Link-Up Technology</p>
        </div>
    </div>
<?php } ?>

</body>
</html>

