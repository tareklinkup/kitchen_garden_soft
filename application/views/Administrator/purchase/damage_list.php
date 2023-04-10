<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
		<div class="form-group" style="margin-top:10px;">
			<label class="col-sm-1 col-sm-offset-2 control-label no-padding-right" for="searchtype"> Search Type </label>
			<div class="col-sm-3">
				<select class="chosen-select form-control" name="prod_id" id="prod_id" data-placeholder="Choose a Product...">
					<option value="">  </option>
					<option value="All"> All </option>
					<?php foreach($products as $product){ ?>
					<option value="<?php echo $product->Product_SlNo; ?>"><?php echo $product->Product_Name; ?> - <?php echo $product->Product_Code; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

	<div class="form-group">
		<div class="col-sm-1">
			<input type="button" class="btn btn-primary" onclick="searchforRecord()" value="Show Report" style="margin-top:0px;border:0px;height:28px;">
		</div>
	</div>
</div>

<div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:15px;">
	<span id="result">
	
	</span>

</div>
</div>

<script type="text/javascript">
    function searchforRecord(){
        var prod_id = $("#prod_id").val();
		if(prod_id == ''){
			alert('Select product');
			return false;
		}
        var inputdata = 'prod_id='+prod_id;
        var urldata = "<?php echo base_url();?>SelectDamageProduct";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#result").html(data);
            }
        });
    }
</script>
