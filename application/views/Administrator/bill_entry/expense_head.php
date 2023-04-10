
<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<form id="ValidateForm" method="POST">
			<div class="form-horizontal">
				<div class="col-sm-2"></div>
				<div class="col-sm-6">
					<div class="form-group">
						<label class="col-sm-4 control-label" for=""> Expense Head </label>
						<label class="col-sm-1 control-label">:</label>
						<div class="col-sm-6">
							<input type="text" id="head_name" required name="head_name"  placeholder="Expense Head Name" class="form-control" />
						</div>
					</div>
				

					<div class="form-group">
						<label class="col-sm-4 control-label" for=""> </label>
						<label class="col-sm-1 control-label"></label>
						<div class="col-sm-6">
							<button type="button" onclick="InsertExpenseHead()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
									Save
							<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
							</button>
						</div>
					</div>
				</div>
			</div>	
		</form>
	</div>
</div>


	
<div class="row" style="padding-top: 15px; margin-top: 15px; border-top: 2px solid #2ca980;">
	<div class="col-xs-12">
		<div id="printPage">
		<div class="table-header">
			Expense Head Information
		</div>

		<!-- div.table-responsive -->
			<table class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>SL.</th>
						<th>Expense Head Name</th>
						<th class="actions">Action</th>
					</tr>
				</thead>

				<tbody id="showResult">
					<?php $i=1; if(!empty($getData)):
					 foreach($getData as $row): ?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $row->head_name; ?></td>
						<td class="actions">
							<div class="hidden-sm hidden-xs action-buttons">
								<a class="green fancybox fancybox.ajax" href="<?php echo base_url() ?>ExpenseHead/edit/<?= $row->id; ?>">
									<i class="ace-icon fa fa-pencil bigger-130"></i>
								</a>

								<a class="red" href="#" onclick="deleted(<?= $row->id; ?>)">
									<i class="ace-icon fa fa-trash-o bigger-130"></i>
								</a>
							</div>
						</td>
					</tr>
					
					<?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
					

<script type="text/javascript">

    function InsertExpenseHead(){
        var isvalid = validationCheck();
        if (isvalid) {
	        $.ajax({
	            type: "POST",
	            url: "<?= base_url();?>ExpenseHead/store",
	            data: $("#ValidateForm").serialize(),
	            dataType: "JSON",
	            success:function(data){   
					if(data.successMsg){
						alert(data.successMsg);
		            }
		            if(data.errorMsg){
						alert(data.errorMsg);
					}
					location.reload();
	            }
	        });
	    }
    }

    function deleted(id){
        var confirmation = confirm("are you sure you want to delete this ?");
		if(confirmation){
        $.ajax({
            type: "POST",
            url: "<?= base_url();?>ExpenseHead/delete/"+id,
            dataType: "JSON",
            success:function(data){
                if(data.successMsg){
					alert(data.successMsg);
	            }
	            if(data.errorMsg){
					alert(data.errorMsg);
				}
				location.reload();
            }
        });
		};
    }
</script>