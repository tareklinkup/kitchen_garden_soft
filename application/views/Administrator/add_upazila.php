<div class="row">
	<div class="col-xs-12">
		<!-- PAGE CONTENT BEGINS -->
		<div class="form-horizontal">
			<form id="addUpazila" onsubmit="formSubmit(event)">
				<input type="hidden" name="upazila_id" id="upazila_id">
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Area Name </label>
					<label class="col-sm-1 control-label no-padding-right">:</label>
					<?php
					$BRANCHid = $this->session->userdata('BRANCHid');
					$query = $this->db->query("SELECT * FROM tbl_district where status='a' order by District_Name asc");
					$district = $query->result();
					?>
					<div class="col-sm-8">
						<!-- <input type="text" id="district" name="district" placeholder="Area Name" value="<?php echo set_value('district'); ?>" class="col-xs-10 col-sm-4" /> -->
						<select name="district_id" id="district_id" class="col-xs-10 col-sm-4" style="padding-left: 2px;">
							<option value="">Select District Name</option>
							<?php 
								foreach($district as $key => $item){?>
									<option value="<?php echo $item->District_SlNo;?>"><?php echo $item->District_Name;?></option>;
							<?php }?>
						</select>
						<span id="areaMsg"></span>
						<?php echo form_error('district'); ?>
						<span style="color:red;font-size:15px;">
					</div>
				</div>
				<div class="form-group" style="margin: 20px -12px;">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Upazila Name </label>
					<label class="col-sm-1 control-label no-padding-right">:</label>
					<div class="col-sm-8">
						<input type="text" id="name" name="name" placeholder="Upazila Name" value="<?php echo set_value('name'); ?>" class="col-xs-10 col-sm-4" />
						<span id="nameMsg"></span>
						<?php echo form_error('name'); ?>
						<span style="color:red;font-size:15px;">
					</div>
				</div>
				<div class="form-group" style="margin: 20px -12px;">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Shipping Charge </label>
					<label class="col-sm-1 control-label no-padding-right">:</label>
					<div class="col-sm-8">
						<input type="text" id="charge_amount" name="charge_amount" placeholder="Shipping Charge" value="<?php echo set_value('charge_amount'); ?>" class="col-xs-10 col-sm-4" />
						<span id="nameMsg"></span>
						<?php echo form_error('charge_amount'); ?>
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
						<th>Upazila Name</th>
						<th>Shipping Charge</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php
					$BRANCHid = $this->session->userdata('BRANCHid');
					$query = $this->db->query("SELECT * FROM upazilas order by name asc");
					$rows = $query->result();
					?>
					<?php $i = 1;
					foreach ($rows as $row) { ?>
						<tr>
							<td class="center" style="display:none;">
								<label class="pos-rel">
									<input type="checkbox" class="ace" />
									<span class="lbl"></span>
								</label>
							</td>

							<td><?php echo $i++; ?></td>
							<td><a href="#"><?php echo $row->name; ?></a></td>
							<td><a href="#">৳ <?php echo $row->charge_amount; ?></a></td>
							<td>
								<div class="hidden-sm hidden-xs action-buttons">
									<a class="blue" href="#">
										<i class="ace-icon fa fa-search-plus bigger-130"></i>
									</a>

									<?php if ($this->session->userdata('accountType') != 'u') { ?>
										<a class="green" style="cursor: pointer;" title="Eidt" onclick="editUpazila('<?php echo $row->id ?>', '<?php echo $row->district_id;?>', '<?php echo $row->name;?>','<?php echo $row->charge_amount;?>')">
											<i class="ace-icon fa fa-pencil bigger-130"></i>
										</a>

										<a class="red" href="#" onclick="deleted(<?php echo $row->id; ?>)">
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
		var district_id = $("#district_id").val();
		var name = $("#name").val();
		if (district_id == "") {
			$("#areaMsg").html("Required Filed").css("color", "red");
			$("#nameMsg").html("").css({});
			return false;
		}
		if (name == "") {
			$("#nameMsg").html("Required Filed").css("color", "red");
			$("#areaMsg").html("").css({});
			return false;
		}

		var formdata = new FormData(event.target)
		var urldata = "<?php echo base_url(); ?>insertupazila";
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
					if(district_id){
						alert("Updated Upazila")
					}else{
						alert("Saved Upazila")
					}
					$("#addUpazila").find("#upazila_id").val("");
					location.reload();
				}
			}
		});
	}

	function editUpazila(id, district_id, name, charge_amount){
		$("#addUpazila").find("#upazila_id").val(id);
		$("#addUpazila").find("#name").val(name);
		$("#addUpazila").find("#charge_amount").val(charge_amount);
		$("#addUpazila").find("#district_id").val(district_id);
	}
</script>

<script type="text/javascript">
	function deleted(id) {
		var deletedd = id;
		var inputdata = 'deleted=' + deletedd;
		var confirmation = confirm("are you sure you want to delete this ?");
		var urldata = "<?php echo base_url() ?>upaziladelete";
		if (confirmation) {
			$.ajax({
				type: "POST",
				url: urldata,
				data: inputdata,
				success: function(data) {
					alert("Delete Success");
					location.reload();
				}
			});
		};
	}
</script>