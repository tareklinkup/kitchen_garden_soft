<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<div class="form-horizontal">

			<form onsubmit="FormSubmit(event)">
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category Name </label>
					<label class="col-sm-1 control-label no-padding-right">:</label>
					<div class="col-sm-8">
						<input type="text" id="catname" name="catname" placeholder="Category Name" value="<?php echo $selected->ProductCategory_Name; ?>" class="col-xs-10 col-sm-4" />
						<input name="id" id="id" type="hidden" value="<?php echo $selected->ProductCategory_SlNo; ?>" />
						<span id="msg"></span>
						<span style="color:red;font-size:15px;">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="description">Description </label>
					<label class="col-sm-1 control-label no-padding-right">:</label>
					<div class="col-sm-8">
						<textarea class="col-xs-10 col-sm-4" name="catdescrip" id="catdescrip"><?php echo $selected->ProductCategory_Description; ?></textarea>
					</div>
				</div>

				<div class="form-group" style="margin-top: 10px;">
					<input type="hidden" name="old" value="<?php echo $selected->image; ?>">
					<label class="col-sm-3 control-label no-padding-right" for="image"> Image </label>
					<label class="col-sm-1 control-label no-padding-right">:</label>
					<div class="col-sm-3">
						<input type="file" style="width: 95%;" class="form-control" id="image" name="image" onchange="checkPhoto(this)">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right"></label>
					<label class="col-sm-1 control-label no-padding-right">:</label>
					<div class="col-sm-3">
						<img class="image" src="<?php echo base_url() . "uploads/productcategory/" . $selected->image; ?>" style="width: 75px;height:75px;">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<label class="col-sm-1 control-label no-padding-right"></label>
					<div class="col-sm-8">
						<button type="submit" class="btn btn-sm btn-success" name="btnSubmit">
							Submit
							<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
						</button>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>



<div class="row">
	<div class="col-xs-12">
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		<div class="table-header">
			Category Information
		</div>

		<!-- div.table-responsive -->

		<!-- div.dataTables_borderWrap -->
		<div id="saveResult">
			<table id="dynamic-table" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th class="center" style="display:none;">
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</th>
						<th>SL No</th>
						<th>Category Name</th>
						<th class="hidden-480">Description</th>

						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php
					$BRANCHid = $this->session->userdata('BRANCHid');
					$query = $this->db->query("SELECT * FROM tbl_productcategory where status='a' AND category_branchid = '$BRANCHid' order by ProductCategory_Name asc");
					$row = $query->result();
					//while($row as $row){ 
					?>
					<?php $i = 1;
					foreach ($row as $row) { ?>
						<tr>
							<td class="center" style="display:none;">
								<label class="pos-rel">
									<input type="checkbox" class="ace" />
									<span class="lbl"></span>
								</label>
							</td>

							<td><?php echo $i++; ?></td>
							<td><a href="#"><?php echo $row->ProductCategory_Name; ?></a></td>
							<td class="hidden-480"><?php echo $row->ProductCategory_Description; ?></td>
							<td>
								<div class="hidden-sm hidden-xs action-buttons">
									<a class="blue" href="#">
										<i class="ace-icon fa fa-search-plus bigger-130"></i>
									</a>

									<a class="green" href="<?php echo base_url() ?>Administrator/page/catedit/<?php echo $row->ProductCategory_SlNo; ?>" title="Eidt" onclick="return confirm('Are you sure you want to Edit this item?');">
										<i class="ace-icon fa fa-pencil bigger-130"></i>
									</a>

									<a class="red" href="#" onclick="deleted(<?php echo $row->ProductCategory_SlNo; ?>)">
										<i class="ace-icon fa fa-trash-o bigger-130"></i>
									</a>
								</div>
							</td>
						</tr>

					<?php } ?>
				</tbody>
			</table>
		</div>
		<!-- PAGE CONTENT ENDS -->
	</div><!-- /.col -->
</div><!-- /.row -->

<script type="text/javascript">
	function checkPhoto(target) {
		let img = new Image()
		img.src = window.URL.createObjectURL(target.files[0])

		if (target.files[0].type.indexOf("image") == -1) {
			alert("File not supported");
			document.querySelector('img.image').src = ""
			target.value = ""
			return false;
		}
		img.onload = () => {
			if (img.width > 200 && img.height > 200) {
				alert("Image ratio must not be greater than 200 X 200");
				document.querySelector('img.image').src = ""
				target.value = ""
				return false;
			} else {
				document.querySelector('img.image').src = window.URL.createObjectURL(target.files[0])
			}
		}
	}

	function FormSubmit(event) {
		event.preventDefault()

		var catname = $("#catname").val();
		if (catname == "") {
			$("#msg").html("Required Filed").css("color", "red");
			return false;
		}
		var formdata = new FormData(event.target)
		var urldata = "<?php echo base_url(); ?>Administrator/page/catupdate";
		$.ajax({
			type: "POST",
			url: urldata,
			data: formdata,
			contentType: false,
			processData: false,
			success: function(data) {
				alert("Update Success");
				window.location = '/category';
			}
		});
	}
</script>
<script type="text/javascript">
	function deleted(id) {
		var deletedd = id;
		var inputdata = 'deleted=' + deletedd;
		//alert(inputdata);
		var urldata = "<?php echo base_url(); ?>Administrator/page/catdelete";
		$.ajax({
			type: "POST",
			url: urldata,
			data: inputdata,
			success: function(data) {
				//$("#saveResult").html(data);
				alert("data");
				window.location.href = '<?php echo base_url(); ?>category';
			}
		});
	}
</script>