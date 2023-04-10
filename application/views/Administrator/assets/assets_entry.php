<div class="row">
	<div class="col-xs-6" id="EditForm">
		<!-- PAGE CONTENT BEGINS -->
	<div class="panel panel-default">
		<div class="panel-heading">Asset Entry</div>
		<div class="form-horizontal" style="padding: 10px;">
					
			<form method="POST" id="assetsForm" action="#">
				<input type="hidden" name="buy_or_sale" value="buy">
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="assetsname"> Assets Name: </label>
					<div class="col-sm-8">
						<input type="text" id="assetsname" required name="assetsname" placeholder="Assets Name" class="form-control" />
						<span id="error"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="supplier_name"> Supplier Name: </label>
					<div class="col-sm-8">
						<input type="text" id="supplier_name" required name="supplier_name" placeholder="Supplier Name" class="form-control" />
						<span id="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="rate"> Rate: </label>
					<div class="col-sm-8">
						<input type="number" id="rate" required name="rate" placeholder="Rate" class="form-control" onblur="TotalAmount()" />
						<span id="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="qty"> Quantity: </label>
					<div class="col-sm-8">
						<input type="number" id="qty" required name="qty" placeholder="Quantity" onblur="TotalAmount()" class="form-control" />
						<span id="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="amount"> Amount: </label>
					<div class="col-sm-8">
						<input type="number" id="amount" readonly name="amount" placeholder="Amount" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="note"> Note: </label>
					<div class="col-sm-8">
						<textarea class="form-control" name="note" id="note" placeholder="Note"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-8">
					    <button type="button" class="btn btn-sm btn-success" onclick="submitAssets()" name="btnSubmit">
							Submit
							<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
						</button>
					</div>
				</div>
			</form>
				
		</div>
	</div>
	</div>

	<div class="col-xs-6" id="EditForm1">
		<!-- PAGE CONTENT BEGINS -->
	<div class="panel panel-default">
		<div class="panel-heading">Asset Sale</div>
		<div class="form-horizontal" style="padding: 10px;">
					
			<form method="POST" id="assetsSaleForm" action="#">
				<input type="hidden" name="buy_or_sale" value="sale">
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="assetsname"> Assets Name: </label>
					<div class="col-sm-8">
						<input type="text" id="s_assetsname" required name="assetsname" placeholder="Assets Name" class="form-control" />
						<span id="error"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="customer_name"> Customer Name: </label>
					<div class="col-sm-8">
						<input type="text" id="customer_name" required name="supplier_name" placeholder="Customer Name" class="form-control" />
						<span id="error"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="unit_valuation"> Valuation: </label>
					<div class="col-sm-3">
						<input type="number" id="unit_valuation" required name="unit_valuation" placeholder="Unit Valuation" class="form-control" onblur="TotalValuationAmount()"/>
						<span id="error"></span>
					</div>
					<label class="col-sm-2 control-label no-padding-right" for="valuation"> Total: </label>
					<div class="col-sm-3">
						<input type="number" id="valuation" required name="valuation" placeholder="Total Valuation" class="form-control" readonly="" />
						<span id="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="rate"> S. Rate: </label>
					<div class="col-sm-3">
						<input type="number" id="s_rate" required name="rate" placeholder="Rate" class="form-control" onblur="TotalSaleAmount()"/>
						<span id="error"></span>
					</div>
					<label class="col-sm-2 control-label no-padding-right" for="qty"> Qty: </label>
					<div class="col-sm-3">
						<input type="number" id="s_qty" required name="qty" placeholder="Quantity" onblur="TotalSaleAmount()" class="form-control" />
						<span id="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="amount"> Amount: </label>
					<div class="col-sm-8">
						<input type="number" id="s_amount" readonly name="amount" placeholder="Amount" class="form-control" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="note"> Note: </label>
					<div class="col-sm-8">
						<textarea class="form-control" name="note" id="s_note" placeholder="Note"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-8">
					    <button type="button" class="btn btn-sm btn-success" onclick="submitAssetsSale()" name="btnSubmit">
							Submit
							<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
						</button>
					</div>
				</div>
			</form>
				
		</div>
	</div>
	</div>
</div>


			
<div class="row">
	<div class="col-xs-12">

		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		<div class="table-header">
			Assets Information
		</div>

		<!-- div.table-responsive -->

		<!-- div.dataTables_borderWrap -->
			<table id="dynamic-table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>SL No</th>
						<th>Date</th>
						<th>Assets Name</th>
						<th>Supplier/Customer</th>
						<th>Valuation</th>
						<th>Rate</th>
						<th>Quantity</th>
						<th>Amount</th>
						<th>Note</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php 
						if(isset($assets) && $assets){
					$i=1; foreach($assets as $row){ ?>
					<tr style="background: <?php echo $row->buy_or_sale == 'sale' ? 'orange' : '' ?>">
						<td><?php echo $i++; ?></td>
						<td><?php echo $row->as_date; ?></td>
						<td><?php echo $row->as_name; ?></td>
						<td><?php echo $row->as_sp_name; ?></td>
						<td><?php echo $row->valuation; ?></td>
						<td><?php echo $row->as_rate; ?></td>
						<td><?php echo $row->as_qty; ?></td>
						<td><?php echo $row->as_amount; ?></td>
						<td><?php echo $row->as_note; ?></td>
						<td>
							<?php if($this->session->userdata('accountType') != 'u'){?>
							<div class="hidden-sm hidden-xs action-buttons">
								<a class="green" href="#" onclick="Edit_assets(<?php echo $row->as_id; ?>, '<?php echo $row->buy_or_sale; ?>')"  title="Edit">
									<i class="ace-icon fa fa-pencil bigger-130"></i>
								</a>

								<a class="red" href="#" onclick="deleteAssets(<?php echo $row->as_id; ?>)">
									<i class="ace-icon fa fa-trash-o bigger-130"></i>
								</a>
							</div>
							<?php }?>
						</td>

					</tr>
					
				<?php } }?>
				</tbody>
			</table>
	</div>
</div>
					

<script type="text/javascript">
	function TotalAmount()
	{
		var qty  = $('#qty').val();
		var rate = $('#rate').val();

		var amount = parseInt(qty) * parseInt(rate);
		$('#amount').val(amount);

	}

    function submitAssets(){

    	var isvalid = true;
        $('#assetsForm :input[required]').each(function () {
            var id = this.id; 
            $('#error' + id).remove(); //this code use in, required text no repeat
            if (this.value.trim() === '') {

                 $('#' + id).next('span').after("<span id='error" + id + "' class='errorTag' style='color:red; font-size:12px; font-weight:bold;'> &nbsp; Required this field ! </span>");
                isvalid = false; 
            }
        });
        if (isvalid) {
	        var urldata = "<?php echo base_url();?>insertassets";
	        $.ajax({
	            type: "POST",
	            url: urldata,
	            data: $('#assetsForm').serialize(),
	            success:function(data){
	                alert("Save Success");
					location.reload();
	            }
	        });
	    }
    }
</script>

<script type="text/javascript">
	function TotalSaleAmount()
	{
		var qty  = $('#s_qty').val();
		var rate = $('#s_rate').val();
		var valuation = $('#unit_valuation').val();

		var amount = parseInt(qty) * parseInt(rate);
		var total_valuation = parseInt(qty) * parseInt(valuation);

		$('#s_amount').val(amount);
		$('#valuation').val(total_valuation);

	}

	function TotalValuationAmount()
	{
		var qty  = $('#s_qty').val();
		var rate = $('#unit_valuation').val();

		var amount = parseInt(qty) * parseInt(rate);
		$('#valuation').val(amount);

	}

    function submitAssetsSale(){

    	var isvalid = true;
        $('#assetsSaleForm :input[required]').each(function () {
            var id = this.id; 
            $('#error' + id).remove(); //this code use in, required text no repeat
            if (this.value.trim() === '') {

                 $('#' + id).next('span').after("<span id='error" + id + "' class='errorTag' style='color:red; font-size:12px; font-weight:bold;'> &nbsp; Required this field ! </span>");
                isvalid = false; 
            }
        });
        if (isvalid) {
	        var urldata = "<?php echo base_url();?>insertassets";
	        $.ajax({
	            type: "POST",
	            url: urldata,
	            data: $('#assetsSaleForm').serialize(),
	            success:function(data){
	                alert("Save Success");
					location.reload();
	            }
	        });
	    }
    }
</script>
<script type="text/javascript">
    function Edit_assets(id, $b_o_s){
        var urldata = "<?php echo base_url();?>assetsEdit/"+id;
        $.ajax({
            type: "POST",
            url: urldata,
            data: {id:id},
            success:function(data){
            	if ($b_o_s == 'buy') {
            		$("#EditForm").html(data);
            		$('#EditForm1').find("input[type=text], input[type=number], textarea").val("");
            	}else{
            		$("#EditForm1").html(data);
            		$('#EditForm').find("input[type=text], input[type=number], textarea").val("");
            	}
                
            }
        });
    }
</script>
<script type="text/javascript">
    function UpdateAssets(id){
        var urldata = "<?php echo base_url();?>assetsUpdate/"+id;
        $.ajax({
            type: "POST",
            url: urldata,
            data: $('#assetsFormUpdate').serialize(),
            success:function(data){
				alert("Update Success");
				location.reload();
            }
        });
    }
</script>

<script type="text/javascript">
    function updateAssetsSale(id){
        var urldata = "<?php echo base_url();?>assetsUpdate/"+id;
        $.ajax({
            type: "POST",
            url: urldata,
            data: $('#assetsSaleFormUpdate').serialize(),
            success:function(data){
				alert("Update Success");
				location.reload();
            }
        });
    }
</script>
<script type="text/javascript">
    function deleteAssets(id){
		if(confirm("Are You Sure Want to delete This?")){
	        var urldata = "<?php echo base_url();?>assetsDelete/"+id;
	        $.ajax({
	            type: "POST",
	            url: urldata,
	            data: {id:id},
	            success:function(data){
	                alert("Delete Success");
					location.reload();
	            }
	        });
		}
    }
</script>
