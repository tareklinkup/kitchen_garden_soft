<?php
$BRANCHid=$this->session->userdata('BRANCHid');
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

<br/>
<br/>
<!--<table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:95;">
        <tr>
          <td align="left" width="150"><img src="<?php //echo base_url();?>uploads/company_profile_thum/<?php //echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;margin-left:30px;" /></td>
          <td align="center" width="650">
				<p style=""><strong style="font-size:18px;"><?php //echo $branch_info->Company_Name; ?></strong><br/>
				<?php //echo $branch_info->Repot_Heading; ?><br/></p>
          </td>
        </tr>
</table>
<table class="zebra" cellspacing="0" cellpadding="0" border="0" style="width:700;">
	<tr>
	  <td></td><br/><hr>
	</tr>
</table>-->

    <table class="border" cellspacing="0" cellpadding="0" width="95%">
        <tr>
            <td colspan="8" style="height:30px;text-align:center;"><strong>Total Stock</strong></td>
        </tr>
        <tr style="background:#ccc;">
            <th style="text-align:center;">SL NO.</th>
            <th style="text-align:center;">Product Name</th>
            <th style="text-align:center;">Purchase Qty</th>
            <th style="text-align:center;">P.Return Qty</th>
            <th style="text-align:center;">Damaged Qty</th>
            <th style="text-align:center;">Sold Qty</th>
            <th style="text-align:center;">S.Return Qty</th>
            <th style="text-align:center;">Current Qty</th>
        </tr>

        <?php 
        $totalqty = 0;$sellTOTALqty = 0; $subtotal = 0;
		$SaleInventory_DamageQuantity=0;
        $SaleInventory_ReturnQuantity=0;
		
		$BRANCHid=$this->session->userdata('BRANCHid');
        $Csql = $this->db->query("SELECT * FROM tbl_productcategory where category_branchid = '$BRANCHid' order by ProductCategory_Name asc");
        $brand = $Csql->result();
        $i=1;
       foreach($brand as $brand){
           $bid = $brand->ProductCategory_SlNo;
                ?>
                <tr style="text-align:center;background:#f4f4f4;">
                    <td colspan="8"><strong style="text-transform:uppercase;"><?php echo $brand->ProductCategory_Name; ?></strong></td>
                </tr>
            <?php 
			$current = 0;
			$Psql = $this->db->query("select tbl_product.*, tbl_purchaseinventory.*, tbl_saleinventory.* FROM tbl_product left join tbl_purchaseinventory on tbl_purchaseinventory.purchProduct_IDNo=tbl_product.Product_SlNo left join tbl_saleinventory on tbl_saleinventory.sellProduct_IdNo=tbl_product.Product_SlNo where tbl_product.brand='$bid'");
			$product = $Psql->result();
			
			foreach($product as $product)
			{
				$current = $product->PurchaseInventory_TotalQuantity - ($product->PurchaseInventory_ReturnQuantity+$product->PurchaseInventory_DamageQuantity+$product->SaleInventory_TotalQuantity) + $product->SaleInventory_ReturnQuantity;
				?>
				<tr style="text-align:center;">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $product->Product_Name; ?></td>
                    <td><?php echo $product->PurchaseInventory_TotalQuantity; ?></td>
                    <td><?php echo $product->PurchaseInventory_ReturnQuantity; ?></td>
                    <td><?php echo $product->PurchaseInventory_DamageQuantity; ?></td>
                    <td><?php echo $product->SaleInventory_TotalQuantity; ?></td>
                    <td><?php echo $product->SaleInventory_ReturnQuantity; ?></td>
                    <td><?php echo $current; ?></td>
                </tr>
				<?php
				$current = 0;
			}
		} 
		?>
    </table>