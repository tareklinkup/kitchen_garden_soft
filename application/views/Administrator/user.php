<?php
	$BRANCHid=$this->session->userdata('BRANCHid');

	$unit = $this->db->query("SELECT * FROM tbl_unit order by Unit_Name asc");
	$unitResult = $unit->result();
		//echo "<pre>";print_r($unitResult);exit;
?>
<span id="Edit_Product_form">	
<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<div class="form-horizontal">
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="txtFirstName"> Full Name </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" name="txtFirstName" id="txtFirstName" placeholder="Full Name" value="" class="form-control" />
			</div>
		</div>
		
	<div class="form-group">
			<label class="col-sm-4 control-label" for="user_email"> User Email </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="email" name="user_email" id="user_email" onchange="check_email()" placeholder="User Email" class="form-control" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-4 control-label" for="Brunch"> Select Branch </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select class="chosen-select form-control" name="Brunch" id="Brunch" data-placeholder="Choose a Brunch...">
					<option value="">  </option>
					
					<?php 
					$sql = $this->db->query("SELECT * FROM tbl_brunch where status = 'a' order by Brunch_name asc");
					$row = $sql->result();
					foreach($row as $row){ ?>
					<option value="<?php echo $row->brunch_id; ?>"><?php echo $row->Brunch_name; ?></option>
					<?php } ?>
				</select>
				 <div id="brand_" class="col-sm-12"></div>
			</div>
		</div> 
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="type"> User Type </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<select class="chosen-select form-control" name="type" id="type" data-placeholder="Choose a User Type...">
					<option value=""></option>
					<option value="a">Admin</option>
					<option value="u">User</option>
					<option value="e">Entry User</option>
				</select>
				 <div id="brand_" class="col-sm-12"></div>
			</div>
		</div> 
		
	</div>
		
	<div class="col-sm-6">
		<div class="form-group">
			<label class="col-sm-4 control-label" for="username"> User name </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="text" id="username" name="username" onchange="check_username()" placeholder="User name" class="form-control" />
				<div id="usermes" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="Password"> Password </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="password" id="assword" name="Password" placeholder="Password" class="form-control" />
				<div id="usermes" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for="rePassword"> Re-Password </label>
			<label class="col-sm-1 control-label">:</label>
			<div class="col-sm-6">
				<input type="password" id="rePassword" name="rePassword" placeholder="Re-Password" onchange="password()" class="form-control" />
				<div id="mes" class="col-sm-12"></div>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-4 control-label" for=""> </label>
			<label class="col-sm-1 control-label"></label>
			<div class="col-sm-6">
				<button type="button" onclick="submit()" name="btnSubmit" title="Save" class="btn btn-sm btn-success pull-left">
						Save
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</div>
	</div>
</div>	
</div>

</div>
</span>



<div class="row">
	<div class="col-xs-12">
		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		
		<div class="table-header">
			User Information
		</div>
		</div>
		
	<div class="col-xs-12" style="margin-top:5px;margin-bottom:5px;">

</div>



<div class="col-xs-12">
<!-- div.table-responsive -->

<!-- div.dataTables_borderWrap -->  
<span id="saveResult">
<div class="table-responsive">
	<table id="dynamic-table" class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Branch</th>
				<th class="hidden-480">Username</th>
				<th>User Email</th>
				<th>Type</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>

		<tbody>
		<?php 
		$query = $this->db->query("SELECT u.User_SlNo, u.User_ID, u.FullName, u.User_Name, u.UserEmail, u.userBrunch_id, u.UserType, u.status AS userstatus, br.brunch_id, br.Brunch_name FROM tbl_user AS u LEFT JOIN tbl_brunch AS br ON br.brunch_id = u.userBrunch_id");
		//$sql = $this->db->query("SELECT tbl_user.*,tbl_brunch.* FROM tbl_user left join tbl_brunch on tbl_brunch.brunch_id=tbl_user.userBrunch_id");
		$row = $query->result();
		foreach($row as $row){
		?>

			<tr>
				<td>
					<a href="#"><?php echo $row->FullName; ?></a>
				</td>
				<td><?php echo $row->Brunch_name; ?></td>
				<td class="hidden-480"><?php echo $row->User_Name; ?></td>
				<td><?php echo $row->UserEmail; ?></td>

				<td class="hidden-480">
					<span class="label label-sm label-info arrowed arrowed-righ">
					<?php if($row->UserType=='m'){ echo "Super Admin"; }elseif($row->UserType=='a'){ echo "Admin"; }elseif($row->UserType=='e'){ echo "Entry User"; }else{ echo "User"; } ?>
					</span>
				</td>
				
				<td class="hidden-480">
				<?php if($row->userstatus=='a'){ ?>
					<span class="label label-sm label-info arrowed arrowed-righ" title="Active">
						Active
					</span>
					<?php }else{ ?>
					<span class="label label-sm label-danger arrowed arrowed-righ" title="Deactive">
						Deactive
					</span>
					<?php } ?>
				</td>
				
				<td>
					<div class="hidden-sm hidden-xs action-buttons">
							<a class="blue" href="<?php echo base_url().'userEdit/'.$row->User_SlNo;?>" onclick="return confirm('Are you sure you want to edit this user?');">
								<i class="ace-icon fa fa-pencil bigger-130"></i>
							</a>
						<?php if($row->userstatus == 'a'){ ?>
							<a class="red" href="<?php echo base_url().'userDeactive/'.$row->User_SlNo;?>" onclick="return confirm('Are you sure you want to deactive this user?');" title="Deactive">
								<i class="ace-icon fa fa-arrow-circle-down bigger-130"></i>
							</a>
						<?php }else{ ?>
							<a class="green" href="<?php echo base_url().'userActive/'.$row->User_SlNo;?>" onclick="return confirm('Are you sure you want to active this user?');" title="Active">
								<i class="ace-icon fa fa-arrow-circle-up bigger-130"></i>
							</a>
						<?php } ?>

						<?php if($row->UserType == 'u' || $row->UserType == 'e'){ ?>
						<a title="User Access" class="blue" href="<?php echo base_url().'access/'.$row->User_SlNo;?>">
								<i class="ace-icon fa fa-users bigger-130"></i>
						</a>
						<?php } ?>
					</div>
				</td>
			</tr>
			
		<?php 
		}
		?>
			</tbody>
		</table>
	</div>
	</span>

	</div><!-- /.col -->
</div><!-- /.row -->
								

<script type="text/javascript">
    function password(){
        var pass = $("#assword").val();
        var passre = $("#rePassword").val();
        //alert(pass+passre);
        if(pass != passre){
            $('#mes').html('Your password and confirm password do not match').css('color','red');
            return false;
        }else{
            $('#mes').html('Your password and confirm password matched').css('color','green');
            setTimeout( function() {$.fancybox.close(); },1200);
        }
        
    }
	
    function onblurPassword(){
        var pass = $("#Password").val();
        var passre = $("#rePassword").val();
        //alert(pass+passre);
        if(pass != passre){
            $('#mes').html('Your password and confirm password do not match').css('color','red');
            return false;
        }else{
            $('#mes').html('Your password and confirm password matched').css('color','green');
            //setTimeout( function() {$.fancybox.close(); },1200);
        }
        
    }

</script>

<script type="text/javascript">
    function submit(){
        var txtFirstName= $("#txtFirstName").val();
        if(txtFirstName==""){
            $("#txtFirstName").css("border-color","red");
            return false;
        }else{
            $("#txtFirstName").css("border-color","green");
        }
        
        var user_email= $("#user_email").val();
        if(user_email==""){
            $("#user_email").css("border-color","red");
            return false;
        }else{
            $("#user_email").css("border-color","green");
        }
        var username= $("#username").val();
        if(username==""){
            $("#username").css("border-color","red");
            return false;
        }else{
            $("#username").css("border-color","green");
        }
        var assword= $("#assword").val();
        if(assword==""){
            $("#assword").css("border-color","red");
            return false;
        }else{
            $("#assword").css("border-color","green");
        }
        var rePassword= $("#rePassword").val();
        if(rePassword==""){
            $("#rePassword").css("border-color","red");
            return false;
        }else{
            $("#rePassword").css("border-color","green");
        }
        if(assword != rePassword){
            $('#mes').html('Your password and confirm password do not match').css('color','red');
            return false;
        }else{
            $('#mes').html('Your password and confirm password matched').css('color','green');
            setTimeout( function() {$.fancybox.close(); },1200);
        }
        var Brunch= $("#Brunch").val();
        if(Brunch==""){
            $("#Brunch").css("border-color","red");
            return false;
        }else{
            $("#Brunch").css("border-color","green");
        }
        var type= $("#type").val();
        if(type==""){
            $("#type").css("border-color","red");
            return false;
        }else{
            $("#type").css("border-color","green");
        }

        var inputdata = 'username='+username+'&rePassword='+rePassword+'&txtFirstName='+txtFirstName+'&user_email='+user_email+'&Brunch='+Brunch+'&type='+type;
        var urldata = "<?php echo base_url();?>userInsert";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
			   let r = JSON.parse(data);
			   alert(r.message);
			   if(r.success){
				   location.reload();
			   }
            }
        });
    }
</script>

<script type="text/javascript">
    
function check_username()
{
	 var username=document.getElementById( "username" ).value;
	 if(username)
	 {
	  $.ajax({
	  type: 'POST',
	  url: '<?php echo base_url(); ?>Administrator/user_management/check_user_name/',
	  data: {
	   username:username,
	  },
		  success: function (response) {
		   $( '#usermes' ).html(response);
			   if(response)	
			   {
				return true;	
			   }
			   else
			   {
				return false;	
			   }
		  }
	  });
	 }
	 else
	 {
		$( '#mes' ).html("");
		return false;
	 }
} 

function check_email()
{
	 var user_email=document.getElementById( "user_email" ).value;
	 if(user_email)
	 {
	  $.ajax({
	  type: 'POST',
	  url: '<?php echo base_url(); ?>Administrator/user_management/check_email/',
	  data: {
	   user_email:user_email,
	  },
		  success: function (response) {
		   $( '#emailmes' ).html(response);
			   if(response)	
			   {
				return true;	
			   }
			   else
			   {
				return false;	
			   }
		  }
	  });
	 }
	 else
	 {
		$( '#mes' ).html("");
		return false;
	 }
}  
</script>