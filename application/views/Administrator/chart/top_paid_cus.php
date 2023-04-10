
<?php $i=1; if(isset($top_cus_list)&&$top_cus_list ): foreach($top_cus_list as $cus):?>
	<tr>
		<td><?= $i++ ?> </td>
		<td><?= $cus->Customer_Code; ?></td>
		<td><?= $cus->Customer_Name; ?></td>
		<td><?= $cus->Customer_Mobile; ?></td>
		<td><?= $cus->Customer_Address?></td>
		<td><?= number_format($cus->total_amount,2); ?></td>
	</tr>
<?php endforeach; endif; ?>
