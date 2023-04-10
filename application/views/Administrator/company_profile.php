<style>
	.inline-radio {
		display: inline;
	}

	#branch .Inactive {
		color: red;
	}
</style>
<div class="row">
	<div class="col-xs-12">
		<div class="col-sm-4 col-sm-offset-1">
			<?php if ($selected) { ?>
				<form class="form-vertical" method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>company_profile_Update">
					<div class="form-group">
						<!-- <label class="control-label" for="">Company Logo</label> -->
						<div class="row">
							<div class="col-sm-6">
								<label for="">Company Logo</label>
								<?php if ($selected->Company_Logo_thum != "") { ?>
									<img id="hideid" src="<?php echo base_url() . 'uploads/company_profile_thum/' . $selected->Company_Logo_thum; ?>" alt="" style="width:100px">
								<?php } else { ?>
									<img id="hideid" src="<?php echo base_url(); ?>images/No-Image-.jpg" alt="" style="width:200px">
								<?php } ?>
								<img id="preview" src="#" style="width:100px;height:100px" hidden>

							</div>
							<div class="col-sm-6">
								<label for="">Website Background</label>
								<?php if ($selected->websiteImage != "") { ?>
									<img id="hideids" src="<?php echo base_url() . 'uploads/website_image/' . $selected->websiteImage; ?>" alt="" style="width:100px;">
								<?php } else { ?>
									<img id="hideids" src="<?php echo base_url(); ?>images/No-Image-.jpg" alt="" style="width:200px">
								<?php } ?>
								<img id="previews" src="#" style="width:100px;height:100px" hidden>

							</div>
						</div>

					</div>

					<div class="control-group" style="margin-bottom:15px;">
						<label class="col-sm-12 control-label bolder blue">Invoice Print Type</label>
						<div class="radio inline-radio">
							<label>
								<input name="inpt" id="a4" type="radio" value="1" <?php if ($selected->print_type == 1) {
																						echo "checked";
																					} ?> class="ace" />
								<span class="lbl"> A4 Size</span>
							</label>
						</div>

						<div class="radio inline-radio">
							<label>
								<input name="inpt" id="a42" type="radio" value="2" <?php if ($selected->print_type == 2) {
																						echo "checked";
																					} ?> class="ace" />
								<span class="lbl"> 1/2 of A4 Size</span>
							</label>
						</div>

						<div class="radio inline-radio">
							<label>
								<input name="inpt" id="pos" type="radio" value="3" <?php if ($selected->print_type == 3) {
																						echo "checked";
																					} ?> class="ace" />
								<span class="lbl"> POS </span>
							</label>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="companyLogo">Change Logo</label>
						<div>
							<input name="companyLogo" id="companyLogo" type="file" onchange="readURL(this)" class="form-control" style="height:35px;" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="websiteImage">Website Image</label>
						<div>
							<span class="text-danger">(1600 x 1000)</span>
							<input name="websiteImage" id="websiteImage" type="file" onchange="readURLS(this)" class="form-control" style="height:35px;" />
						</div>
					</div>

					<div class="form-group" style="margin-top:15px">
						<label class="control-label" for="form-field-1"> Company Name </label>
						<div>
							<input name="Company_name" type="text" id="Company_name" value="<?php echo $selected->Company_Name; ?>" class="form-control" />
							<input name="iidd" type="hidden" id="iidd" value="<?php echo $selected->Company_SlNo; ?>" class="txt" />
						</div>
					</div>

					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1"> Phone </label>
						<div>
							<input name="phone" type="text" id="phone" value="<?php echo $selected->phone; ?>" class="form-control" />
						</div>
					</div>

					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1"> Google Map </label>
						<div>
							<input name="map" type="text" id="map" value="<?php echo $selected->map; ?>" class="form-control" />
						</div>
					</div>

					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1"> Facebook </label>
						<div>
							<input name="facebook" type="text" id="facebook" value="<?php echo $selected->facebook; ?>" class="form-control" />
						</div>
					</div>
					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1"> Instagram </label>
						<div>
							<input name="instagram" type="text" id="instagram" value="<?php echo $selected->instagram; ?>" class="form-control" />
						</div>
					</div>

					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1"> Youtube </label>
						<div>
							<input name="youtube" type="text" id="youtube" value="<?php echo $selected->youtube; ?>" class="form-control" />
						</div>
					</div>

					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1"> Twitter </label>
						<div>
							<input name="twitter" type="link" id="twitter" value="<?php echo $selected->twitter; ?>" class="form-control" />
						</div>
					</div>

					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1"> Linkedin </label>
						<div>
							<input name="linkedin" type="link" id="linkedin" value="<?php echo $selected->linkedin; ?>" class="form-control" />
						</div>
					</div>


					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1">Address</label>
						<div>
							<textarea id="Description" name="Description" class="form-control"><?php echo $selected->Repot_Heading; ?></textarea>
						</div>
					</div>

					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1"> About Us </label>
						<div>
							<textarea id="about_us" name="about_us" rows="10"><?php echo $selected->about_us; ?></textarea>
						</div>
					</div>

					<div class="form-group" style="margin-top:7px">
						<label class="control-label" for="form-field-1"> FAQ</label>
						<div>
							<textarea id="faq" name="faq" rows="10"><?php echo $selected->faq; ?></textarea>
						</div>
					</div>

					<div class="form-group" style="margin-top:7px;">
						<label class="col-sm-4 control-label" for=""> </label>
						<label class="col-sm-1 control-label"></label>
						<div class="col-sm-6">
							<button type="submit" name="btnSubmit" title="Update" class="btn btn-sm btn-info pull-left">
								Update
								<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
							</button>

						</div>
					</div>
				</form>
			<?php
			} else {
			?>

				<form method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>company_profile_insert">
					<div class="form-group">
						<label class="col-sm-12 control-label" for="pro_Name">Company Logo</label>
						<div class="col-sm-12">
							<img id="hideid" src="<?php echo base_url(); ?>images/No-Image-.jpg" alt="" style="width:100px">
							<img id="preview" src="#" style="width:100px;height:100px" hidden>
						</div>
					</div>

					<!-- <div class="form-group"> -->
					<label class="col-sm-12 control-label" for="pro_Name">Change Logo</label>
					<!-- <div class="col-sm-12"> -->
					<input name="companyLogo" required id="companyLogo" type="file" class="form-control" style="height:35px;" />
					<!-- </div> -->
					<!-- </div> -->

					<div class="form-group">
						<label class="col-sm-12 control-label" for="form-field-1" style="margin-top:15px;"> Company Name </label>
						<div class="col-sm-12">
							<input name="Company_name" type="text" id="Company_name" value="" class="form-control" />
							<input name="iidd" type="hidden" id="iidd" value="" class="txt" />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="form-field-1" style="margin-top:15px;"> Description </label>
						<div>
							<textarea id="Description" name="Description" class="form-control"></textarea>
						</div>
					</div>

					<div class="control-group" style="margin-top:15px;">
						<label class="col-sm-12 control-label bolder blue">Invoice Print Type</label>
						<div class="radio inline-radio">
							<label>
								<input name="inpt" id="a4" type="radio" value="1" class="ace" />
								<span class="lbl"> A4 Size</span>
							</label>
						</div>

						<div class="radio inline-radio">
							<label>
								<input name="inpt" id="a42" type="radio" value="2" class="ace" />
								<span class="lbl"> 1/2 of A4 Size</span>
							</label>
						</div>

						<div class="radio inline-radio">
							<label>
								<input name="inpt" id="pos" type="radio" value="3" class="ace" />
								<span class="lbl"> POS </span>
							</label>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label" for=""> </label>
						<label class="col-sm-1 control-label"></label>
						<div class="col-sm-6">
							<button type="submit" name="btnSubmit" title="Update" class="btn btn-sm btn-success pull-left">
								Save
								<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
							</button>

						</div>
					</div>
				</form>
			<?php
			}
			?>
		</div>
		<div class="col-sm-6 col-sm-offset-1">
			<div id="branch">
				<div class="row" style="margin-top: 15px;">
					<div class="col-md-12">
						<form class="form-horizontal" @submit.prevent="saveBranch">
							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right"> Branch Name </label>
								<label class="col-sm-1 control-label no-padding-right">:</label>
								<div class="col-sm-8">
									<input type="text" placeholder="Branch Name" class="form-control" v-model="branch.name" required />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right"> Branch Title </label>
								<label class="col-sm-1 control-label no-padding-right">:</label>
								<div class="col-sm-8">
									<input type="text" placeholder="Branch Title" class="form-control" v-model="branch.title" required />
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-3 control-label no-padding-right"> Branch Address </label>
								<label class="col-sm-1 control-label no-padding-right">:</label>
								<div class="col-sm-8">
									<textarea class="form-control" placeholder="Branch Address" v-model="branch.address" required></textarea>
								</div>
							</div>

							<div class="form-group">
								<label class="col-sm-8 control-label no-padding-right"></label>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-sm btn-success">
										Submit
										<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<div class="row" style="margin-top: 20px;display:none;" v-bind:style="{display: branches.length > 0 ? '' : 'none'}">
					<div class="col-md-12">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Sl</th>
									<th>Branch Name</th>
									<th>Branch Title</th>
									<th>Branch Address</th>
									<th>Status</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(branch, sl) in branches">
									<td>{{ sl + 1 }}</td>
									<td>{{ branch.Brunch_name }}</td>
									<td>{{ branch.Brunch_title }}</td>
									<td>{{ branch.Brunch_address }}</td>
									<td><span v-bind:class="branch.active_status">{{ branch.active_status }}</span></td>
									<td>
										<?php if ($this->session->userdata('accountType') != 'u') { ?>
											<a href="" title="Edit Branch" @click.prevent="editBranch(branch)"><i class="fa fa-pencil"></i></a>&nbsp;
											<a href="" title="Deactive Branch" v-if="branch.status == 'a'" @click.prevent="changeStatus(branch.brunch_id)"><i class="fa fa-trash"></i></a>
											<a href="" title="Active Branch" v-else><i class="fa fa-check" @click.prevent="changeStatus(branch.brunch_id)"></i></a>
										<?php } ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/js/vue/vue.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/vue/axios.min.js"></script>

<script>
	new Vue({
		el: '#branch',
		data() {
			return {
				branch: {
					branchId: 0,
					name: '',
					title: '',
					address: ''
				},
				branches: []
			}
		},
		created() {
			this.getBranches();
		},
		methods: {
			getBranches() {
				axios.get('/get_branches').then(res => {
					this.branches = res.data;
				})
			},

			saveBranch() {
				let url = "/add_branch";
				if (this.branch.branchId != 0) {
					url = "/update_branch";
				}

				axios.post(url, this.branch).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getBranches();
						this.clearForm();
					}
				})
			},

			editBranch(branch) {
				this.branch.branchId = branch.brunch_id;
				this.branch.name = branch.Brunch_name;
				this.branch.title = branch.Brunch_title;
				this.branch.address = branch.Brunch_address;
			},

			changeStatus(branchId) {
				let changeConfirm = confirm('Are you sure?');
				if (changeConfirm == false) {
					return;
				}
				axios.post('/change_branch_status', {
					branchId: branchId
				}).then(res => {
					let r = res.data;
					alert(r.message);
					if (r.success) {
						this.getBranches();
					}
				})
			},

			clearForm() {
				this.branch = {
					branchId: 0,
					name: '',
					title: '',
					address: ''
				}
			}
		}
	})
</script>

<script type="text/javascript">
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				document.getElementById('preview').src = e.target.result;
			}
			reader.readAsDataURL(input.files[0]);
			$("#hideid").hide();
			$("#preview").show();
		}
	}
	function readURLS(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				document.getElementById('previews').src = e.target.result;
			}
			reader.readAsDataURL(input.files[0]);
			$("#hideids").hide();
			$("#previews").show();
		}
	}
</script>

<script type="text/javascript">
	function Employee_submit() {
		var logo = $('#companyLogo').val();
		if (logo == "") {
			alert('Please Select a logo')
			return false;
		}
		var Company_name = $("#Company_name").val();
		var inpt = $('input[name=inpt]:checked').val();
		//alert(inpt);
		if (Company_name == "") {
			$("#Company_name").css('border-color', 'red');
			return false;
		}
		var fd = new FormData();
		var Description = CKEDITOR.instances['Description'].getData();
		var Description = encodeURIComponent(Description);
		fd.append('companyLogo', $('#companyLogo')[0].files[0]);
		fd.append('websiteImage', $('#websiteImage')[0].files[0]);
		fd.append('Company_name', $('#Company_name').val());
		fd.append('Description', Description);
		fd.append('inpt', inpt);
		fd.append('iidd', $('#iidd').val());


		var x = $.ajax({
			url: "<?php echo base_url(); ?>Administrator/page/company_profile_Update/",
			type: "POST",
			data: fd,
			enctype: 'multipart/form-data',
			processData: false,
			contentType: false,
			success: function(data) {
				//$("#Company").html(data);
				alert("Update Success");
				//setTimeout( function() {$.fancybox.close(); },1200);
				// location.reload();
			}
		});
	}
</script>
<!-- TextArea editor -->
<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/ckeditor.js'></script>

<script type="text/javascript">
	ClassicEditor
		.create(document.querySelector('#about_us'))
		.catch(error => {
			console.error(error);
		});
</script>

<script type="text/javascript">
	ClassicEditor
		.create(document.querySelector('#faq'))
		.catch(error => {
			console.error(error);
		});
</script>
<!-- end TextArea editor -->