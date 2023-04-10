<?php  
if ($cart = $this->cart->contents()): ?>
	<table class="table table-bordered" cellspacing="0" cellpadding="0" style="color:#000;margin-bottom: 10px;">
        <thead>
        <tr>
            <th >SL NO</th>
            <th >Category</th>
            <th >Product Name</th>
            <th >Qty</th>
            <th >Rate</th>
            <th >Discount</th>
            <th >Total Amount</th>
            <th >Action</th>
        </tr>
        </thead>
		<tbody>  
			<?php
			$grand_total = 0;
			$count = "";
			$i = 0;
			foreach ($cart as $item):
				$i++;
			    $saleDetail_si_no='';
				$count=$item['qty'];
				if(isset($item['SaleDetails_SlNo'])){
                    $saleDetail_si_no = $item['SaleDetails_SlNo'];
                }
				echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
				echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
				echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
				echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
				echo form_hidden('cart[' . $item['id'] . '][saleIn]', $item['saleIn']);
				echo form_hidden('cart[' . $item['id'] . '][purchaserate]', $item['purchaserate']);
				echo form_hidden('cart[' . $item['id'] . '][discount_amount]', $item['discount_amount']);
				echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
				echo form_hidden('cart[' . $item['id'] . '][SaleMaster_PaidAmount]', $item['SaleMaster_PaidAmount']);
				echo form_hidden('cart[' . $item['id'] . '][unit]', $item['unit']);

				echo form_hidden('cart[' . $item['id'] . '][SaleDetails_SlNo]', $saleDetail_si_no);
				echo form_hidden('SaleDetails_SlNo', $saleDetail_si_no);


				$pro = $this->db->where('Product_SlNo',$item['id'])->get('tbl_product')->row();
				$category = $this->db->where('ProductCategory_SlNo',$pro->ProductCategory_ID)->get('tbl_productcategory')->row();
				?> 
				<tr>
					<td style=""><?php echo $i; ?> </td>

					<td style=""><?php if(isset($category->ProductCategory_Name)): echo $category->ProductCategory_Name; endif; ?></td>
					<td style=""><?php echo $item['name']; ?></td>
					<td style="">
						<?php echo $item['qty']; ?><?php if(!empty($item['packagename'])){ ?><input type="hidden" name="sqty[]" id="sqty<?php echo $i;?>" value="<?php echo $item['qty']; ?>">
						<input type="hidden" name="sNaMe[]" id="sNaMe<?php echo $i;?>" value="<?php echo $item['name']; ?>">
						<?php } ?>
						<input type="hidden" name="allqty[]" id="allqty<?php echo $i;?>" value="<?php echo $item['qty']; ?>">
						<input type="hidden" name="allname[]" id="allname<?php echo $i;?>" value="<?php echo $item['name']; ?>">
					</td>
					<td style=""><?php echo $item['price']; ?></td>
					<td style=""><?php echo $item['discount_amount']; ?></td>

					<td style="">
						<?php $sub_total = $item['subtotal'] - $item['discount_amount'];  $grand_total = $grand_total + $sub_total; ?> <?php echo number_format($sub_total, 2) ?>
						<input type="hidden" id="PriCe_<?php echo $item['rowid'];?>" value="<?php echo $item['subtotal']; ?>">
					</td>

					<td style="">
						<span style="cursor:pointer" onclick="cartRemove(a='<?php echo $item['rowid'];?>')">
							<input type="hidden" id="rowid<?php echo $item['rowid'];?>" value="<?php echo $item['rowid'];?>">
							<i class="fa fa-times" aria-hidden="true" style="color:red;font-size:17px;"></i>
						</span>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<input type="hidden" id="ckqty" value="<?php echo $count; ?>">
<?php endif; ?>


<tr>
	<td colspan="7">
		<table class="table table-bordered" cellspacing="0" cellpadding="0" style="color:#000;margin-bottom: 5px;">
			<tr>
				<td width="40%" >Notes</td>
				<td width="60%">Total</td>
			</tr>

			<tr>
				<td width="40%" >
					<textarea name="SelesNotes" id="SelesNotes" rows="2" style="width:100%"></textarea>
				</td>
				<td width="60%">
					<span style="color:red"><?php if(isset($grand_total)) {echo $grand_total;}else{echo 0;} ?></span>
					<span>tk</span>
				</td>
			</tr>

			<tr>
				<td colspan="2" >
				</td>
			</tr>
		</table>
	</td>
</tr>
