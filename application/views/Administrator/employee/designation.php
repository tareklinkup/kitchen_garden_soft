<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<span id="saveResult">
	<div class="form-horizontal">
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Designation Name  </label>
			<label class="col-sm-1 control-label no-padding-right">:</label>
			<div class="col-sm-8">
				<input type="text" id="Designation" name="Designation" placeholder="Designation Name" value="<?php echo set_value('Designation'); ?>" class="col-xs-10 col-sm-4" />
				<span id="msg"></span>
				<?php echo form_error('Designation'); ?>
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
</span>
</div>
</div>


			
<div class="row">
	<div class="col-xs-12">

		<div class="clearfix">
			<div class="pull-right tableTools-container"></div>
		</div>
		<div class="table-header">
			Designation Information
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
						<th>Designation Name</th>
						<th class="hidden-480">Description</th>

						<th>Action</th>
						<th></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php 
					$query = $this->db->query("SELECT * FROM tbl_designation where Status='a' order by Designation_Name asc");
					$row = $query->result();
					 ?>
					<?php $i=1; foreach($row as $row){ ?>
					<tr>
						<td class="center" style="display:none;">
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td><?php echo $i++; ?></td>
						<td><a href="#"><?php echo $row->Designation_Name; ?></a></td>
						<td class="hidden-480"><?php echo $row->Designation_Name; ?></td>
						<td>
						<div class="hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="ace-icon fa fa-search-plus bigger-130"></i>
								</a>

								<?php if($this->session->userdata('accountType') != 'u'){?>
								<a class="green" style="cursor:pointer;" onclick="editDesignation(<?php echo $row->Designation_SlNo; ?>)" title="Eidt" onclick="return confirm('Are you sure you want to Edit this item?');">
									<i class="ace-icon fa fa-pencil bigger-130"></i>
								</a>

								<a class="red" href="#" onclick="deleted(<?php echo $row->Designation_SlNo; ?>)">
									<i class="ace-icon fa fa-trash-o bigger-130"></i>
								</a>
								<?php }?>
							</div>
						</td>

						<td class="hidden-480">
							<span class="label label-sm label-info arrowed arrowed-righ"><?php //echo $row->ProductCategory_Name; ?></span>
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
        var Designation= $("#Designation").val();
        if(Designation==""){
            $("#msg").html("Required Filed").css("color","red");
            return false;
        }
        var inputdata = 'Designation='+Designation;
        var urldata = "<?php echo base_url();?>insertDesignation";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                alert("Save Success");
				location.reload();
            }
        });
    }
</script>
<script type="text/javascript">

    function deleted(id){
        var deletedd= id;
        var inputdata = 'deleted='+deletedd;
        //alert(inputdata);
        var urldata = "<?php echo base_url();?>designationdelete";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                alert("Delete Success");
				location.reload();
            }
        });
    }
	
    function editDesignation(id){
        var id= id;
        var inputdata = 'id='+id;
        var urldata = "<?php echo base_url();?>designationedit/"+id;
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
			 $("#saveResult").html(data);
            }
        });
    }
</script>


<script type="text/javascript">
    function update(){
        var Designation= $("#Designation").val();
        var id= $("#id").val();
        if(Designation==""){
            $("#msg").html("Required Filed").css("color","red");
            return false;
        }
        var inputdata = 'Designation='+Designation+'&id='+id;
        var urldata = "<?php echo base_url();?>designationUpdate";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                alert("Updaet Success");
            }
        });
    }
</script>
