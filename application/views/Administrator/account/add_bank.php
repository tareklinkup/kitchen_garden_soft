<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<div class="form-horizontal">
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Bank Name  </label>
			<label class="col-sm-1 control-label no-padding-right">:</label>
			<div class="col-sm-8">
				<input type="text" id="Bank_name" name="Bank_name" placeholder="Bank Name" value="<?php echo set_value('colorname'); ?>" class="col-xs-10 col-sm-4" />
				<span id="msg1"></span>
				<?php echo form_error('Bank_name'); ?>
				<span style="color:red;font-size:15px;">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
			<label class="col-sm-1 control-label no-padding-right"></label>
			<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-success" onclick="submit()" name="btnSubmit">
						Submit
						<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
					</button>
			</div>
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
			Bank Information
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
						<th>Bank Name</th>
						<th class="hidden-480">Description</th>

						<th>Status</th>
						<th>Action</th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php $i=1; foreach($bank as $bank){ ?>
					<tr>
						<td class="center" style="display:none;">
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td><?php echo $i++; ?></td>
						<td><a href="#"><?php echo $bank->Bank_name; ?></a></td>
						<td class="hidden-480"><?php echo $bank->Bank_name; ?></td>
						<td class="hidden-480"><?php if($bank->status=='a'){?> <strong class="text-success">Active</strong> <?php }else{ ?>  <strong class="text-danger">Deactive</strong>  <?php } ?></td>
						
						<td>
						<div class="hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="ace-icon fa fa-search-plus bigger-130"></i>
								</a>

								<a class="green" href="<?php echo base_url() ?>bankEdit/<?php echo $bank->Bank_SiNo; ?>" title="Eidt" onclick="return confirm('Are you sure you want to Edit this item?');">
									<i class="ace-icon fa fa-pencil bigger-130"></i>
								</a>

								<a class="red" href="#" onclick="deleted(<?php echo $bank->Bank_SiNo; ?>)">
									<i class="ace-icon fa fa-trash-o bigger-130"></i>
								</a>
							</div>
						</td>
						<td></td>
					</tr>
					
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
					

<script type="text/javascript">
    function submit(){
        var Bank_name= $("#Bank_name").val();
        if(Bank_name==""){
            $("#msg1").html("Required Filed").css("color","red");
            return false;
        }
        var inputdata = 'Bank_name='+Bank_name;
        var urldata = "<?php echo base_url() ?>insertBank";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                if(data){
					alert(data)
					$("#Bank_name").val('');
				}else{
					return false;
				}
                    /* var err = data;
                    if((err)=="F"){
                        alert("This Name Allready Exists");
                    }else{
                        alert("Save Success");
                        window.location.href='<?php echo base_url(); ?>Administrator/page/add_Bank';
                    } */
            }
        });
    }
</script>

<script type="text/javascript">
    function deleted(id){
        var deletedd= id;
        var inputdata = 'deleted='+deletedd;
		if(confirm("Are You Sure Want to delete This?")){
        var urldata = "<?php echo base_url() ?>bankDelete";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                //$("#saveResult").html(data);
                alert("Delete Success");
                window.location.href='<?php echo base_url(); ?>addBank';
            }
        });
		}
    }
</script>