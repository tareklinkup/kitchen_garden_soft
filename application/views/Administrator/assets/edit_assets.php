<?php if($edit->buy_or_sale == 'buy') { ?>

<div class="panel panel-default">
	<div class="panel-heading">Asset Entry</div>
	<div class="form-horizontal" style="padding: 10px;">
				
		<form method="POST" id="assetsFormUpdate" action="#">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="assetsname"> Assets Name: </label>
				<div class="col-sm-8">
					<input type="text" id="assetsname" required name="assetsname" placeholder="Assets Name" class="form-control" value="<?= $edit->as_name; ?>"/>
					<span id="error"></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="supplier_name"> Supplier Name: </label>
				<div class="col-sm-8">
					<input type="text" id="supplier_name" required name="supplier_name" placeholder="Supplier Name" class="form-control" value="<?= $edit->as_sp_name; ?>"/>
					<span id="error"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="rate"> Rate: </label>
				<div class="col-sm-8">
					<input type="number" id="rate" required name="rate" placeholder="Rate" class="form-control" value="<?= $edit->as_rate; ?>" onblur="TotalAmount()"/>
					<span id="error"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="qty"> Quantity: </label>
				<div class="col-sm-8">
					<input type="number" id="qty" required name="qty" placeholder="Quantity" onblur="TotalAmount()" class="form-control"  value="<?= $edit->as_qty; ?>"/>
					<span id="error"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="amount"> Amount: </label>
				<div class="col-sm-8">
					<input type="number" id="amount" readonly name="amount" placeholder="Amount" class="form-control" value="<?= $edit->as_amount; ?>"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="note"> Note: </label>
				<div class="col-sm-8">
					<textarea class="form-control" name="note" id="note" placeholder="Note"><?= $edit->as_note; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-success" onclick="UpdateAssets(<?= $edit->as_id; ?>)" name="btnSubmit">
						Submit
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
				</div>
			</div>
		</form>	
	</div>
</div>

<?php } else { ?>
<div class="panel panel-default">
	<div class="panel-heading">Asset Sale</div>
	<div class="form-horizontal" style="padding: 10px;">
				
		<form method="POST" id="assetsSaleFormUpdate" action="#">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="assetsname"> Assets Name: </label>
				<div class="col-sm-8">
					<input type="text" id="s_assetsname" required name="assetsname" placeholder="Assets Name" class="form-control" value="<?= $edit->as_name; ?>"/>
					<span id="error"></span>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="customer_name"> Customer Name: </label>
				<div class="col-sm-8">
					<input type="text" id="customer_name" required name="supplier_name" placeholder="Customer Name" class="form-control" value="<?= $edit->as_sp_name; ?>"/>
					<span id="error"></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="unit_valuation"> Valuation: </label>
				<div class="col-sm-3">
					<input type="number" id="unit_valuation" required name="unit_valuation" placeholder="Unit Valuation" class="form-control" value="<?= $edit->unit_valuation; ?>" onblur="TotalValuationAmount()"/>
					<span id="error"></span>
				</div>

				<label class="col-sm-2 control-label no-padding-right" for="valuation"> Total: </label>
				<div class="col-sm-3">
					<input type="number" id="valuation" required name="valuation" placeholder="Total Valuation" class="form-control" value="<?= $edit->valuation; ?>" readonly/>
					<span id="error"></span>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="rate"> Rate: </label>
				<div class="col-sm-3">
					<input type="number" id="rate" required name="rate" placeholder="Rate" class="form-control" value="<?= $edit->as_rate; ?>" onblur="TotalSaleAmount()"/>
					<span id="error"></span>
				</div>
				<label class="col-sm-2 control-label no-padding-right" for="qty"> Quantity: </label>
				<div class="col-sm-3">
					<input type="number" id="s_qty" required name="qty" placeholder="Quantity" onblur="TotalSaleAmount()" class="form-control"  value="<?= $edit->as_qty; ?>"/>
					<span id="error"></span>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="amount"> Amount: </label>
				<div class="col-sm-8">
					<input type="number" id="s_amount" readonly name="amount" placeholder="Amount" class="form-control" value="<?= $edit->as_amount; ?>"/>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="note"> Note: </label>
				<div class="col-sm-8">
					<textarea class="form-control" name="note" id="s_note" placeholder="Note"><?= $edit->as_note; ?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-success" onclick="updateAssetsSale(<?= $edit->as_id; ?>)" name="btnSubmit">
						Submit
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
				</div>
			</div>
		</form>
			
	</div>
</div>
<?php } ?>