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

<br/>
<br/>
<table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:800;">
        <tr>
          <td align="left" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;margin-left:30px;" /></td>
          <td align="center" width="650">
				<p style=""><strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
				<?php echo $branch_info->Repot_Heading; ?><br/></p>
          </td>
        </tr>
</table>
<table class="zebra" cellspacing="0" cellpadding="0" border="0" style="width:700;">
	<tr>
	  <td></td><br/><hr>
	</tr>
</table>

    <table class="border" cellspacing="0" cellpadding="0" width="80%">
        <tr>
            <td colspan="8" align="center"><h2> Stock Available </h2></td>
        </tr>
        <tr style="background:#ccc;">
            <th style="text-align:center;">SL. NO</th>
            <th style="text-align:center;">Product Name</th>
            <!-- <th style="text-align:center;">Brand Name</th> -->
            <th style="text-align:center;">Purchase Rate</th>
        </tr>
        <?php 
        $totalqty = 0;$sellTOTALqty = 0; $subtotal = 0;
		$SaleInventory_DamageQuantity=0;
        $SaleInventory_ReturnQuantity=0;
		$currentQuantity=0;
		$lessQuantity=0;
		$i=1;
        foreach($record as $record){
			    $sellTOTALqty = 0;
                $PID = $record->purchProduct_IDNo;
                $brandid = $record->brand;
                // Sell qty
                $sqq = $this->db->query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '$PID' AND SaleInventory_brunchid = '$branchID'");
                $or = $sqq->row();
				if($sqq->num_rows() > 0){
					$sellTOTALqty = $or->SaleInventory_TotalQuantity;
					$SaleInventory_ReturnQuantity = $or->SaleInventory_ReturnQuantity;
				}
				
				$lessQuantity = $record->PurchaseInventory_ReturnQuantity+$record->PurchaseInventory_DamageQuantity+$sellTOTALqty;
				 
				$currentQuantity =  $record->PurchaseInventory_TotalQuantity - $lessQuantity;
				
				$brandsql = $this->db->query("SELECT `brand_name` FROM tbl_brand WHERE brand_SiNo = '$brandid'"); 
				$brandrow = $brandsql->row();
                ?>
                <tr style="text-align:center;">
                    <td><?php echo $i++; ?></td>
                    <td><?php echo $record->Product_Name; ?></td>
                    <!-- <td><?php echo $brandrow->brand_name; ?></td> -->
                    <td><?php echo $record->Product_Purchase_Rate; ?></td>
        <?php }  ?>
       
    </table>