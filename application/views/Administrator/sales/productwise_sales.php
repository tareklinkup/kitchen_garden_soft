<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;">
	<div class="form-group" style="margin-top:10px;">
		<label class="col-sm-1 control-label no-padding-right" for="customerID"> Search Type </label>
		<div class="col-sm-3">
			  <select name="" id="ProductID" data-placeholder="Choose a Product..." class="chosen-select" style="width:200px">
				<option value="All"> All </option>
				<?php
				if(isset($products) && $products){
				foreach($products as $product){ ?>
				<option value="<?php echo $product->Product_SlNo; ?>"><?php echo $product->Product_Name; ?> - <?php echo $product->Product_Code; ?></option>
				<?php }} ?>
			</select>
		</div>
	</div>

		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right" for="Sales_startdate"> From Date </label>
		</div>
	
		<div class="col-sm-2">
			<div class="input-group">
				<input class="form-control date-picker" id="Sales_startdate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>" />
				<span class="input-group-addon"style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-1 control-label no-padding-right" for="Sales_enddate"> To Date </label>
		</div>
	
		<div class="col-sm-2">
			<div class="input-group">
				<input class="form-control date-picker" id="Sales_enddate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>" />
				<span class="input-group-addon"style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
	
	<div class="form-group">
		<div class="col-sm-2">
			<input type="button" class="btn btn-primary form-control" onclick="Productdata()" value="Show Report" style="margin-top:0px;border:0px;height:28px;width:100%;">
		</div>
	</div>
</div>

<div class="col-xs-12 col-md-12 col-lg-12" style="margin-top:15px;">
	<span id="result">
	
	</span>
</div>
</div>

<script type="text/javascript">
    function Productdata(){
        var ProductID = $("#ProductID").val();
        var startdate = $("#Sales_startdate").val();
        var enddate = $("#Sales_enddate").val();
        var inputData = 'ProductID='+ProductID+'&startdate='+startdate+'&enddate='+enddate;
        var urldata = "<?php echo base_url();?>productSalesSearch";
		$.ajax({
            type: "POST",
            url: urldata,
            data: inputData,
            success:function(data){
                $("#result").html(data);
            }
        });
    }
</script>
