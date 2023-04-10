<?php $i=1; if(isset($topSells)&&$topSells ): foreach($topSells as $sale):?>
	<tr>
		<td><?= $i++ ?></td>
		<td><?= $sale->Product_Code?></td>
		<td><?= $sale->Product_Name; ?></td>
		<td><?= $sale->qty; ?></td>
		<td><?= number_format($sale->Product_Purchase_Rate,2); ?></td>
		<td><?= number_format($sale->Product_SellingPrice,2); ?></td>
	</tr>
<?php endforeach; endif; ?>
