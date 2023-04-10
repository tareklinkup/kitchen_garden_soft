<?php  if ($cart = $this->cart->contents()){ ?>
<table class="table table-bordered" cellspacing="0" cellpadding="0" style="color:#000;margin-bottom: 10px;">
	<tbody>
	<?php
		$i = 1;
		foreach ($cart as $item){
			echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
			echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
			echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
			echo form_hidden('cart[' . $item['id'] . '][bodynumber]', $item['bodynumber']);
			echo form_hidden('cart[' . $item['id'] . '][bodyrate]', $item['bodyrate']);
			echo form_hidden('cart[' . $item['id'] . '][group]', $item['group']);
			echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
			echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
			echo form_hidden('cart[' . $item['id'] . '][image]', $item['image']); 
	?> 
		<tr>
			<td style="width:7%;"><strong style="color:#438EB9;font-size:14px;"><?php echo $i++; ?></strong></td>
			<td style="width:7%;"></td>
			<td style="width:7%;"></td>
			<td style="width:7%;"><?php echo $item['group']; ?></td>
			<td style="width:11%;"><?php echo $item['bodynumber']; ?></td>
			<td style="width:12%;"><?php echo $item['name']; ?></td>
			<td style="width:7%;"></td>
			<td style="width:7%;"></td>
			<td style="width:7%;"></td>
			<td style="width:7%;"><?php echo $item['bodyrate']; ?></td>
			<td style="width:7%;"><?php //echo $item['qty']; ?></td>
			<td style="width:7%;"><?php //echo $item['qty']; ?></td>
			
			<td style="">
				<span style="cursor:pointer" onclick="cartRemove(a='<?php echo $item['rowid'];?>')">
				<input type="hidden" id="rowid<?php echo $item['rowid'];?>" value="<?php echo $item['rowid'];?>">
				<i class="fa fa-times" aria-hidden="true" style="color:red;font-size:17px;"></i></span>
			</td>
		</tr>
		<?php } ?>
	</tbody>    
</table> 
<?php } ?>
