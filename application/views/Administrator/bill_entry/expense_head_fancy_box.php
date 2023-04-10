
<div style="margin-top: 50px; height: 200px; max-width: 600px; padding: 0">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<form id="ex" method="POST">
			<div class="form-horizontal">
				<div class="col-sm-12">
					<div class="form-group">
						<label class="col-sm-4 control-label" for=""> Expense Head </label>
						<div class="col-sm-8">
							<input type="text" id="head_name" required name="head_name"  placeholder="Expense Head Name" class="form-control" />
						</div>
					</div>
				

					<div class="form-group">
						<label class="col-sm-4 control-label" for=""> </label>

						<div class="col-sm-8">
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




<script type="text/javascript">

    function InsertExpenseHead(){
        // var isvalid = validationCheck();
        var head_name = $("#head_name").val();

        if (head_name != '') {
	        $.ajax({
	            type: "POST",
	            url: "<?= base_url();?>ExpenseHead/store",
	            data: $("#ex").serialize(),
	            dataType: "JSON",
	            success:function(data){
                    $("#head_name").val('');
                    if(data.successMsg) {
                        alert(data.successMsg);
                        getExpanceHeads();
                    }else{
                        alert(data.errorMsg);
                    }
	            }
	        });
	    } else{
            alert("Please Fill The Input Feild");
        }
    }



</script>