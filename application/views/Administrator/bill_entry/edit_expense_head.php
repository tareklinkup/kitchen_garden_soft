
<div class="col-xs-12" style="margin:50px 0px; width: 450px;">
	<!-- PAGE CONTENT BEGINS -->
	<div class="form-horizontal">
		
		<form method="post" id="Form">
			<input type="hidden" id="idd" value="<?=$edit->id?>">

			<div class="form-group">
				<label class="col-sm-4 control-label" for=""> Expense Head </label>
				<label class="col-sm-1 control-label">:</label>
				<div class="col-sm-6">
					<input type="text" id="head_name" required name="head_name"  placeholder="Expense Head Name" value="<?=$edit->head_name?>" class="form-control" />
				</div>
			</div>

			
			<div class="form-group">
				<label class="col-sm-5 control-label no-padding-right" for="form-field-1"></label>
				<label class="col-sm-1 control-label no-padding-right"></label>
				<div class="col-sm-3">
			    <button type="button" class="btn btn-sm btn-success" onclick="updateExpenseHead()" name="btnSubmit">
					Update
					<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
				</div>
			</div>	
		</form>
		
	</div>
</div>

<script type="text/javascript">
    function updateExpenseHead(){
    	var id = $("#idd").val();
        $.ajax({
            type: "POST",
            url: "<?= base_url();?>ExpenseHead/update/"+id,
            data: $("#Form").serialize(),
            dataType: "JSON",
            success:function(data){   
				if(data.successMsg){
					alert(data.successMsg);
	            }
	            if(data.errorMsg){
					alert(data.errorMsg);
				}
				$(".chosen-select").chosen();
	                setTimeout(function() {$.fancybox.close(); location.reload();}, 1000);
	        }
        });
    	
    }
</script>
