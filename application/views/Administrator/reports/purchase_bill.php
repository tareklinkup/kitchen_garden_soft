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

    <div style="width: 100%; height: auto; padding: 0px 50px; margin-left: 20px;">
        <div style="width:12%; float: left;">
            <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;" />
        </div>
        <div style="width:65%; text-align: center; float: left;">
            <strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
                <?php echo $branch_info->Repot_Heading; ?><br/>
        </div>
    </div>

    <div class="" style="">

<?php 

  $sql = $this->db->query("
    SELECT 
    tbl_purchasemaster.*,
    tbl_purchasemaster.AddBy as served,
    tbl_supplier.Supplier_Code,
    tbl_supplier.Supplier_Name,
    tbl_supplier.Supplier_Mobile,
    tbl_supplier.Supplier_Email,
    tbl_supplier.Supplier_Address
    FROM tbl_purchasemaster 
    left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo 
    where tbl_purchasemaster.PurchaseMaster_SlNo = '$PurchID'
  ");
  $selse = $sql->row();
 //echo "<pre>";print_r($selse);exit;
?>
    <table  cellspacing="0" cellpadding="0" width="100%">
        <tr>
            <td colspan="2" style="background:#ddd;" align="center"><strong style="font-size:16px;">Purchase Invoice</strong></td>
        </tr>
        <tr>
            <td>
                <table width="100%">
                    <tr>
                        <td><strong>Supplier ID </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->Supplier_Code; ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Supplier Name </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->Supplier_Name; ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Supplier Address </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->Supplier_Address; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Contact no </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->Supplier_Mobile; ?></td>
                    </tr>              
                </table>
            </td>
            <td>
                <table width="100%">
                    <tr>
                        <td><strong>Invoice no </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->PurchaseMaster_InvoiceNo; ?></td>
                    </tr> 
                    <tr>
                        <td><strong>Date </strong></td>
                        <td>:</td>
                        <td><?php echo $selse->PurchaseMaster_OrderDate; ?></td>
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
           <th style="text-align:center;">Product Name</th>
		   <th style="text-align:center;">Category</th>
           <th style="text-align:center;">Color</th>
           <th style="text-align:center;">Pur. Rate</th>
           <th style="text-align:center;">Quantity</th>
           <th style="text-align:left;">Amount</th>
        </tr>
        <?php $i = 0;
        $totalamount = "";
        $Ptotalamount = "";
        $ssql = $this->db->query("
            SELECT
            tbl_purchasedetails.*,
            tbl_product.*,
            tbl_productcategory.*,
            tbl_color.*,
            tbl_brand.* 
            FROM tbl_purchasedetails 
            left join tbl_product on tbl_product.Product_SlNo = tbl_purchasedetails.Product_IDNo 
            LEFT JOIN tbl_productcategory ON tbl_productcategory.ProductCategory_SlNo=tbl_product.ProductCategory_ID 
            LEFT JOIN tbl_color ON tbl_color.color_SiNo=tbl_product.color 
            LEFT JOIN tbl_brand ON tbl_brand.brand_SiNo=tbl_product.brand 
            where tbl_purchasedetails.PurchaseMaster_IDNo = '$PurchID'
        ");
        $rows = $ssql->result();
		foreach($rows as $rows){ 
            $i += 1;
        ?>
        <tr class="center">
            <td style="text-align:center;"><?php echo $i; ?></td>
            <td><?php echo $rows->Product_Name; ?></td>
            <td><?php echo $rows->ProductCategory_Name; ?></td>
            <td><?php echo $rows->color_name; ?></td>
            <td><?php echo $rows->PurchaseDetails_Rate; ?></td>
            <td style="text-align: center;"><?php echo $rows->PurchaseDetails_TotalQuantity; ?></td>
            <td style="text-align: right;"><?php echo number_format($rows->PurchaseDetails_TotalAmount,2); ?></td>
        </tr>
        <?php } 
           ?>
        <tr>
			<td  style="border:0px"><strong>Previous Due</strong></td>
            <td  style="border:0px;color:red;text-align:right;"><?php echo number_format($selse->previous_due,2);?></td>
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px"><strong>Sub Total :</strong> </td>
            <td style="border:0px;text-align:right;"><?php echo number_format($selse->PurchaseMaster_SubTotalAmount,2); ?></td>
        </tr>

        <tr>
            <td style="border:0px"><strong>Current Due</strong></td>
            <td style="border:0px;color:red;text-align:right;"><?php echo number_format($selse->PurchaseMaster_DueAmount,2) ?></td>
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px"><strong>Vat :</strong> </td>
            <td style="border:0px;text-align:right;"><?php echo number_format($selse->PurchaseMaster_Tax, 2) ?></td>
        </tr>


		
        <tr>
			<td style="border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;">
            <strong>Totul Due</strong> </td>
            <td style="color:red;border-top: 1px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;text-align:right;">
            <?php echo number_format($selse->previous_due + $selse->PurchaseMaster_DueAmount, 2); ?></td>
            <td colspan="3" style="border:0px"></td>
            <td style="border:0px"><strong>Discount :</strong> </td>
            <td style="border:0px;text-align:right;"><?php echo number_format($selse->PurchaseMaster_DiscountAmount,2) ?></td>
        </tr>
       
        <tr>
            <td colspan="5" style="border:0px"></td>
            <td style="border:0px"><strong>Transport Cost :</strong> </td>
            <td style="border:0px;text-align:right;"><?php echo number_format($selse->PurchaseMaster_Freight,2)?></td>
        </tr>

        <tr>
			<td colspan="5" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
        </tr>
		
        <tr>
            <td colspan="5" style="border:0px"></td>
            <td style="border:0px"><strong>Total :</strong> </td>
            <td style="border:0px;text-align:right;"><strong><?php echo number_format($selse->PurchaseMaster_TotalAmount,2)?></strong></td>
        </tr>
        <tr>
            <td colspan="5" style="border:0px"></td>
            <td style="border:0px"><strong>Paid :</strong> </td>
            <td style="border:0px;text-align:right;"><?php echo number_format($selse->PurchaseMaster_PaidAmount,2);?></td>
        </tr>
        <tr>
            <td colspan="5" style="border:0px"></td>
            <td colspan="2" style="border-top: 2px solid #999;border-left: 0px ;border-right: 0px ;border-bottom: 0px ;"></td>
           
        </tr>
        <tr>
            <td colspan="5" style="border:0px"></td>
            <td style="border:0px"><strong>Due :</strong> </td>
            <td style="border:0px;text-align:right;"><?php echo number_format($selse->PurchaseMaster_DueAmount,2); ?></td>
        </tr>
    </table>
    <p><strong>Total (in word): </strong>
    <?= $this->mt->convertNumberToWord($selse->PurchaseMaster_TotalAmount); ?>
    </p><br>
    <h4>Notes: <?php echo $selse->PurchaseMaster_Description; ?></h4>

</div>
</body>
</html>

