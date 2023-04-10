<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<div class="form-horizontal">
			<form onsubmit="formSubmit(event)">
				<div class="form-group" style="margin: 20px -12px;">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Area Name </label>
					<label class="col-sm-1 control-label no-padding-right">:</label>
					<div class="col-sm-8">
						<input type="text" id="district" name="district" placeholder="Area Name" value="<?php echo set_value('district'); ?>" class="col-xs-10 col-sm-4" />
						<span id="nameMsg"></span>
						<?php echo form_error('district'); ?>
						<span style="color:red;font-size:15px;">
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<label class="col-sm-1 control-label no-padding-right"></label>
					<div class="col-sm-8">
						<button type="submit" class="btn btn-sm btn-success">
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
			Area Information
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
						<th>Area Name</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php
					$BRANCHid = $this->session->userdata('BRANCHid');
					$query = $this->db->query("SELECT * FROM tbl_district where status='a' order by District_Name asc");
					$row = $query->result();
					//echo "<pre>";print_r($row);exit;
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
							<td><a href="#"><?php echo $row->District_Name; ?></a></td>
							<td>
								<div class="hidden-sm hidden-xs action-buttons">
									<a class="blue" href="#">
										<i class="ace-icon fa fa-search-plus bigger-130"></i>
									</a>

									<?php if ($this->session->userdata('accountType') != 'u') { ?>
										<a class="green" href="<?php echo base_url() ?>areaedit/<?php echo $row->District_SlNo; ?>" title="Eidt" onclick="return confirm('Are you sure you want to Edit this item?');">
											<i class="ace-icon fa fa-pencil bigger-130"></i>
										</a>

										<a class="red" href="#" onclick="deleted(<?php echo $row->District_SlNo; ?>)">
											<i class="ace-icon fa fa-trash-o bigger-130"></i>
										</a>
									<?php } ?>
								</div>
							</td>
						</tr>

					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>


<script type="text/javascript">
	function formSubmit(event) {
		event.preventDefault()
		var district = $("#district").val();
		if (district == "") {
			$("#nameMsg").html("Required Filed").css("color", "red");
			$("#chargeMsg").html("").css({});
			return false;
		}

		var formdata = new FormData(event.target)
		var urldata = "<?php echo base_url(); ?>insertarea";
		$.ajax({
			type: "POST",
			url: urldata,
			data: formdata,
			contentType: false,
			processData: false,
			success: function(data) {
				if (data == "false") {
					alert("This area allready exists");
				} else {
					alert("Save Success");
					location.reload();
				}
			}
		});
	}
</script>

<script type="text/javascript">
	function deleted(id) {
		var deletedd = id;
		var inputdata = 'deleted=' + deletedd;
		var confirmation = confirm("are you sure you want to delete this ?");
		var urldata = "<?php echo base_url() ?>areadelete";
		if (confirmation) {
			$.ajax({
				type: "POST",
				url: urldata,
				data: inputdata,
				success: function(data) {
					//$("#saveResult").html(data);
					alert("Delete Success");
					window.location.href = '<?php echo base_url(); ?>Administrator/page/area';
				}
			});
		};
	}
</script>