<?php
if(validation_errors()){
?>
<div class="alert alert-danger">
	<button type="button" class="close" data-dismiss="alert">
		<i class="ace-icon fa fa-times"></i>
	</button>
	<?php echo validation_errors(); ?>
	<br>
</div>
	<?php
}
?>

<div class="main-content">
	<div class="main-content-inner">
		<div class="page-content">

			<div class="row">
				<div class="col-xs-12">
					<div id="home" class="tab-pane in active">
						<div class="row">
							<div class="col-xs-12 col-sm-3 center">
								<span class="profile-picture">
									<img class="editable img-responsive" alt="<?php echo $this->session->userdata('FullName');?>" id="profileImage" src="/uploads/users/<?php echo $this->session->userdata('user_image');?>" />
								</span>

								<div class="space space-4"></div>

								<label class="btn btn-sm btn-block btn-warning">
									<input type="file" style="display:none;" id="profileImageInput" accept="image/x-png,image/gif,image/jpeg">
									<span class="bigger-110">Change Image</span>
								</label>

								<a href="#" class="btn btn-sm btn-block btn-success">
									<i class="ace-icon fa fa-plus-circle bigger-120"></i>
									<span class="bigger-110"><?= ucwords($user->FullName)?></span>
								</a>

								<a href="#" class="btn btn-sm btn-block btn-primary">
									<i class="ace-icon fa fa-envelope-o bigger-110"></i>
									<span class="bigger-110">Email: <?= $user->UserEmail?></span>
								</a>
							</div><!-- /.col -->

							<div class="col-xs-12 col-sm-9">

								<div class="profile-user-info">
									<div class="profile-info-row">
										<div class="profile-info-name"> Username </div>

										<div class="profile-info-value">
											<span><?= $user->User_Name ?></span>
										</div>
									</div>
									<div class="profile-info-row">
										<div class="profile-info-name"> Branch Name </div>

										<div class="profile-info-value">
											<span><?= ucwords($branch_info->Brunch_name)?></span>
										</div>
									</div>

									<div class="profile-info-row">
										<div class="profile-info-name">Branch Location </div>

										<div class="profile-info-value">
											<i class="fa fa-map-marker light-orange bigger-110"></i>
											<span><?= ucwords($branch_info->Brunch_title)?></span>
											<span><?= ucwords($branch_info->Brunch_address)?></span>
										</div>
									</div>


									<div class="profile-info-row">
										<div class="profile-info-name"> Age </div>

										<div class="profile-info-value">
											<?php if($user->UserType == 'a'):?>
											<span>Admin</span>
											<?php elseif($user->UserType == 'u'):?>
											<span>User</span>
											<?php else:?>
											<span>Member</span>
											<?php endif;?>
										</div>
									</div>


								</div>

								<div class="hr hr-8 dotted"></div>
								<form action="<?= base_url()?>password_change" method="POST">
									<div class="profile-user-info">
										<div class="profile-info-row">
											<div class="profile-info-name"> Current Password </div>

											<div class="profile-info-value">
												<input type="password" name="current_password" class="form-control" placeholder="Current Password" style="width: 30%;">
											</div>
										</div>

										<div class="profile-info-row">
											<div class="profile-info-name"> New Password </div>

											<div class="profile-info-value">
												<input type="password" name="password" class="form-control" placeholder="New Password" style="width: 30%;">
											</div>
										</div>
										<div class="profile-info-row">
											<div class="profile-info-name"> Confirm Password </div>

											<div class="profile-info-value">
												<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" style="width: 30%;">
											</div>
										</div>
										<div class="profile-info-row">
											<div class="profile-info-name"> </div>

											<div class="profile-info-value">
												<button type="submit" class="btn btn-sm btn-info" style="margin-left: 16%;">Save</button>
											</div>
										</div>

									</div>
								</form>

							</div><!-- /.col -->
						</div><!-- /.row -->
						<div class="space-20"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php if($this->session->flashdata('msg')):?>
	<script>
		alert('<?= $this->session->flashdata('msg') ?>');
	</script>
<?php endif; ?>

<script>
	let fileInput = document.querySelector('#profileImageInput');
	let profileImage = document.querySelector('#profileImage');
	fileInput.addEventListener('change', (event) => {
		let file = event.target.files[0];
		let imageUrl = URL.createObjectURL(file);
		profileImage.src = imageUrl;

		let fd = new FormData();
		fd.append('image', file);
		fetch('/upload_user_image', {
			method: 'post',
			body: fd
		})
		.then(response => response.text())
		.then(response => {
			alert(response);
			location.reload();
		})
		.catch(error => console.log(error))
	})
</script>