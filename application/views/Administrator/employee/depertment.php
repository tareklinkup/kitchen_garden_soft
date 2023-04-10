<script>

	
    function editDepertment(id){
        var id= id;
        var inputdata = 'id='+id;
        var urldata = "<?php echo base_url();?>depertmentedit/"+id;
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
<div class="row">
<div class="col-xs-12">
	<!-- PAGE CONTENT BEGINS -->
	<span id="saveResult">
	<div class="form-horizontal">
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Depertment Name  </label>
			<label class="col-sm-1 control-label no-padding-right">:</label>
			<div class="col-sm-8">
				<input type="text" id="Depertment" name="Depertment" placeholder="Depertment Name" value="<?php echo set_value('Depertment'); ?>" class="col-xs-10 col-sm-4" />
				<span id="msg"></span>
				<?php echo form_error('Depertment'); ?>
				<span style="color:red;font-size:15px;">
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
			<label class="col-sm-1 control-label no-padding-right"></label>
			<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-success" onclick="Addsubmited()" name="btnSubmit">
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
			Depertment Information
		</div>

		<!-- div.table-responsive -->

		<!-- div.dataTables_borderWrap -->
		<div id="">
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
						<th>Depertment Name</th>
						<th class="hidden-480">Description</th>

						<th>Action</th>
						<th></th>
						<th></th>
					</tr>
				</thead>

				<tbody>
					<?php 
					$query = $this->db->query("SELECT * FROM tbl_department order by Department_Name asc ");
					$row = $query->result();
					 $i=1; foreach($row as $row){ ?>
					<tr>
						<td class="center" style="display:none;">
							<label class="pos-rel">
								<input type="checkbox" class="ace" />
								<span class="lbl"></span>
							</label>
						</td>

						<td><?php echo $i++; ?></td>
						<td><a href="#"><?php echo $row->Department_Name; ?></a></td>
						<td class="hidden-480"><?php echo $row->Department_Name; ?></td>
						<td>
						<div class="hidden-sm hidden-xs action-buttons">
								<a class="blue" href="#">
									<i class="ace-icon fa fa-search-plus bigger-130"></i>
								</a>

								<?php if($this->session->userdata('accountType') != 'u'){?>
								<a class="green" style="cursor:pointer;" onclick="editDepertment(<?php echo $row->Department_SlNo; ?>)" title="Eidt">
									<i class="ace-icon fa fa-pencil bigger-130"></i>
								</a>

								<a class="red" style="cursor:pointer;" onclick="deleted(<?php echo $row->Department_SlNo; ?>)">
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
    function Addsubmited(){
        var Depertment= $("#Depertment").val();
        if(Depertment==""){
            $("#msg").html("Required Filed").css("color","red");
            return false;
        }
        var inputdata = 'Depertment='+Depertment;
        var urldata = "<?php echo base_url();?>insertDepertment";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                alert(data);
				location.reload();
            }
        });
    }
</script>
<script type="text/javascript">

    function deleted(id){
        var deletedd= id;
        var inputdata = 'deleted='+deletedd;
		var x = confirm("Are you sure you want to delete?");
		if (x){
        var urldata = "<?php echo base_url();?>depertmentdelete";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
               // $("#saveResult").html(data);
                alert("Delete Success");
				location.reload();
            }
		}else{
			return false;
		}
        });
    }
</script>


<script type="text/javascript">
    function submited(){
        var Depertment= $("#Depertment").val();
        var id= $("#id").val();
        if(Depertment==""){
            $("#msg").html("Required Filed").css("color","red");
            return false;
        }
        var inputdata = 'Depertment='+Depertment+'&id='+id;
        var urldata = "<?php echo base_url();?>depertmentupdate";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                //$("#saveResult").html(data);
                alert("Update Success");
				location.reload();
            }
        });
    }
</script>
