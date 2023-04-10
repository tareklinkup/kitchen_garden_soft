<?php $i=1; foreach($getData as $row){ ?>
<tr>
	<td><?= $i++; ?></td>
	<td><?= $row->date; ?></td>
	<td><?= $row->head_name; ?></td>
	<td><?= $row->amount; ?></td>
	<td><?= $row->remarks; ?></td>
	<td class="actions">
		<div class="hidden-sm hidden-xs action-buttons">
			<a class="green fancybox fancybox.ajax" href="<?php echo base_url() ?>BillEntry/edit/<?= $row->id; ?>" >
				<i class="ace-icon fa fa-pencil bigger-130"></i>
			</a>

			<a class="red" href="#" onclick="deleted(<?= $row->id; ?>)">
				<i class="ace-icon fa fa-trash-o bigger-130"></i>
			</a>
		</div>
	</td>
</tr>

<?php } ?>