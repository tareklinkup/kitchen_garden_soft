<script>
	function printContent(el){
		var restorepage = document.body.innerHTML;
		var printcontent = document.getElementById(el).innerHTML;
		document.body.innerHTML = printcontent;
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

<script>
	$(document).ready(function(){
		$("#key").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#myTable tbody tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});
</script>


<div class="content_scroll" >
	<h4><a style="cursor:pointer; float: left;" onclick="printContent('printPage')"> <i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a></h4>

	<div style="width: 200px; float: right;" >
		<form method="post" id="SearchForm">
			<input type="text" name="key" id="key" placeholder="Search here" class="form-control" style="border:2px solid #089;">
			<input type="hidden" name="page"  value="<?= $Store ?>">
			<input type="hidden" name="Product"  value="<?= $Product ?>">
			<input type="hidden" name="Category"  value="<?= $Category ?>">
			<input type="hidden" name="Supplier"  value="<?= $Supplier ?>">
			<input type="hidden" name="Brand"  value="<?= $brand ?>">
		</form>
	</div>



	<div id="printPage" style="width: 100%;">

		<table id="myTable" class="display table table-bordered table-striped table-hover" style="margin-bottom: 5px;">
			<thead style="background:#ccc;">
			<tr>
				<td colspan="12" align="center"><h2>
						<?php if($Store == 'Current'): ?>
							Current Stock
						<?php elseif($Store == 'Total'): ?>
							Total Stock
						<?php elseif($Store == 'Category'): ?>
							Category Wise Stock
						<?php elseif($Store == 'Product'): ?>
							Product Wise Stock
						<?php elseif($Store == 'Supplier'): ?>
							Supplier Wise Stock
						<?php elseif($Store == 'Brand'): ?>
							Brand Wise Stock
						<?php endif; ?>
					</h2></td>
			</tr>
			<tr>
				<th style="width: 10%;">Product ID</th>
				<th style="width: 10%;">Product Name</th>
				<th style="width: 10%;">Category</th>
				<th style="width: 10%;">Brand</th>
				<?php if($Store != 'Current'): ?>
					<th style="width: 10%;">Purchase Qty</th>
					<th style="width: 10%;">Purchase Returned Qty</th>
					<th style="width: 10%;">Damage Qty</th>
					<th style="width: 10%;">Sold_Qty</th>
					<th style="width: 10%;">Sale Returned Qty</th>
					<th style="width: 10%; display: none;">Transfer Qty</th>
					<th style="width: 10%; display: none;">Received Qty</th>
				<?php endif; ?>
				<th style="width: 10%;">Current Qty</th>
				<th style="width: 10%;">Stock Value</th>
			</tr>

			</thead>
			<tbody>
			<?php
			$totalqty = 0;$sellTOTALqty = 0; $subtotal = 0;
			$SaleInventory_DamageQuantity=0; $pur_inv_qnt=0;
			$SaleInventory_ReturnQuantity=0; $pur_rutn_qnt=0;
			$total_stock_value = 0;
			//$record = mysql_fetch_row($sql);
			//echo "<pre>";print_r($record);exit;
			foreach($sql as $record){
//				print_r($record);
				$PID = $record->purchProduct_IDNo;

				$transferQuantity=0;
				$transferQuantity2=0;

				$tsql = $this->db->query("SELECT * FROM sr_transferdetails WHERE Product_IDNo = '$PID' AND Brunch_to = '$branchID' AND fld_status = 'a'")->result();

				foreach($tsql as $trows){
					$transferQuantity =  $transferQuantity+$trows->TransferDetails_TotalQuantity;
				}

				$tsql2 =$this->db->query("SELECT * FROM sr_transferdetails WHERE Product_IDNo = '$PID' AND Brunch_from = '$branchID' AND fld_status = 'a'")->result();
				foreach($tsql2 as $trows2){
					$transferQuantity2 =  $transferQuantity2+$trows2->TransferDetails_TotalQuantity;
				}

				//Purchase inventory total quantity
				$pur_inv = $this->db->where('purchProduct_IDNo',$PID)->where('PurchaseInventory_brunchid',$branchID)->get('tbl_purchaseinventory')->row();
				if(isset($pur_inv->PurchaseInventory_TotalQuantity)):
					$pur_inv_qnt=$pur_inv->PurchaseInventory_TotalQuantity;
				else: $pur_inv_qnt=0; endif;

				if(isset($pur_inv->PurchaseInventory_ReturnQuantity)):
					$pur_rutn_qnt=$pur_inv->PurchaseInventory_ReturnQuantity;
				else: $pur_rutn_qnt=0; endif;

				if(isset($pur_inv->PurchaseInventory_DamageQuantity)):
					$pur_dam_qnt=$pur_inv->PurchaseInventory_DamageQuantity;
				else: $pur_dam_qnt=0; endif;

				$totalqty = $pur_inv_qnt - $pur_rutn_qnt;
				$totalqty = $totalqty-$pur_dam_qnt;
				$totalqty = ($totalqty + $transferQuantity)-$transferQuantity2;



				// Sell qty
				$or = $this->db->query("SELECT * FROM tbl_saleinventory WHERE sellProduct_IdNo = '$PID' AND SaleInventory_brunchid = '$branchID'")->row();

				//while($or = mysql_fetch_array($sqq)){
				// if($or->SaleInventory_packname == ""){
				if(isset($or->SaleInventory_TotalQuantity)):
					$sellTOTALqty = $or->SaleInventory_TotalQuantity;
				else:
					$sellTOTALqty = 0;
				endif;

				if(isset($or->SaleInventory_DamageQuantity)):
					$SaleInventory_DamageQuantity = $or->SaleInventory_DamageQuantity;
				else:
					$SaleInventory_DamageQuantity = 0;
				endif;

				if(isset($or->SaleInventory_ReturnQuantity)):
					$SaleInventory_ReturnQuantity = $or->SaleInventory_ReturnQuantity;
				else:
					$SaleInventory_ReturnQuantity = 0;
				endif;
				//}

				$sellTOTALqty = $sellTOTALqty - $SaleInventory_DamageQuantity;
				$totalqty = $totalqty - $sellTOTALqty;
				$totalqty = $totalqty + $SaleInventory_ReturnQuantity;

				$uName = "";
//				echo $totalqty; exit();

				if($totalqty != 0){
					$rate = $totalqty*$record->PurchaseDetails_Rate;
					$subtotal = $subtotal+$rate;
					if($record->PurchaseDetails_Unit != "" && $record->PurchaseDetails_Unit > 0):
						$unit = $this->db->where('Unit_SlNo',$record->PurchaseDetails_Unit)->get('tbl_unit')->row();
						$uName = $unit->Unit_Name;
					endif;
					?>
					<tr style="text-align:center;">

						<td style="width: 10%;"><?php echo $record->Product_Code ?></td>
						<td style="width: 10%;"><?php echo $record->Product_Name ?></td>
						<td style="width: 10%;">
							<?php
							$cat = $this->db->where('ProductCategory_SlNo',$record->ProductCategory_ID)->get('tbl_productcategory')->row();
							if(isset($cat->ProductCategory_Name)):  echo $cat->ProductCategory_Name; endif; ?>
						</td>
						<td style="width: 10%;">
							<?php
							$brand = $this->db->where('brand_SiNo',$record->brand)->get('tbl_brand')->row();
							if(isset($brand->brand_name)):  echo $brand->brand_name; endif; ?>
						</td>
						<?php if($Store != 'Current'): ?>
							<td style="width: 10%;">
								<?php if(isset($record->PurchaseInventory_TotalQuantity)) :echo $record->PurchaseInventory_TotalQuantity; else: echo "0"; endif; ?>
								&nbsp;<?php if($record->PurchaseDetails_Unit==""){echo "pcs";} else{echo $uName; }?>
							</td>

							<td style="width: 10%;"><?php if(isset($record->PurchaseInventory_ReturnQuantity)): echo $record->PurchaseInventory_ReturnQuantity; else: echo "0"; endif; ?>
								&nbsp;<?php if($record->PurchaseDetails_Unit==""){echo "pcs";} else{echo $uName; }?>
									
							</td>
							<td style="width: 10%;"><?php if(isset($or->SaleInventory_DamageQuantity)): echo $or->SaleInventory_DamageQuantity;  else: echo "0"; endif; ?>
								&nbsp;<?php if($record->PurchaseDetails_Unit==""){echo "pcs";} else{echo $uName; }?>
							</td>
							<td style="width: 10%;"><?php if(isset($or->SaleInventory_TotalQuantity)): echo $or->SaleInventory_TotalQuantity;   else: echo "0"; endif; ?>
								&nbsp;<?php if($record->PurchaseDetails_Unit==""){echo "pcs";} else{echo $uName; }?>
							</td>
							<td style="width: 10%;"><?php if(isset($or->SaleInventory_ReturnQuantity)): echo $or->SaleInventory_ReturnQuantity;  else: echo "0"; endif; ?>
								&nbsp;<?php if($record->PurchaseDetails_Unit==""){echo "pcs";} else{echo $uName; }?>
							</td>
							<td style="width: 10%; display: none;"><?php if(isset($transferQuantity2)): echo $transferQuantity2;  else: echo "0"; endif; ?>
								&nbsp;<?php if($record->PurchaseDetails_Unit==""){echo "pcs";} else{echo $uName; }?>
							</td>
							<td style="width: 10%; display: none;"><?php if(isset($transferQuantity)): echo $transferQuantity;  else: echo "0"; endif; ?>
								&nbsp;<?php if($record->PurchaseDetails_Unit==""){echo "pcs";} else{echo $uName; }?>
							</td>
							
						<?php endif; ?>


						<?php
						if($record->Product_ReOrederLevel > $totalqty){
							?>
							<td style="background-color:red;"><?php echo $totalqty; ?></td>
							<?php
						}else{
							?>
							<td style="width: 10%;"><?php echo $totalqty; ?>&nbsp;<?php if($record->PurchaseDetails_Unit==""){echo "pcs";} else{echo  $uName; }?></td>
							<?php
						}
						?>
						<?php $total_stock_value += ($totalqty*$record->PurchaseDetails_Rate); ?>
						<td style="width: 10%; text-align: right;"><?php echo number_format($totalqty*$record->PurchaseDetails_Rate, 2)?></td>
					</tr>
				<?php } } //} ?>
				<tr>
					<td style="text-align: right; font-size: 14px; font-weight: bold;" colspan="<?php echo ($Store != 'Current')? '10':'5'; ?>">Total Stock Value: </td>
					<td style="text-align: right; font-size: 14px; font-weight: bold;" ><?php echo number_format($total_stock_value, 2) ?></td>
				</tr>
			</tbody>

		</table>
	</div>
</div>

