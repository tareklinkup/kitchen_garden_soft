
<script>
    function editMonth(id){
        var id = id;
        var inputdata = 'id='+id;
        var urldata = "<?php echo base_url();?>editMonth/"+id;
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
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Month Name  </label>
			<label class="col-sm-1 control-label no-padding-right">:</label>
			<div class="col-sm-8">
				<input type="text" id="month" name="month" placeholder="Month Name" value="" class="col-xs-10 col-sm-4" />
				<span id="msc"></span>
			</div>
		</div>
		 
		<div class="form-group">
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
			<label class="col-sm-1 control-label no-padding-right"></label>
			<div class="col-sm-8">
				    <button type="button" class="btn btn-sm btn-success" onclick="Submitdata()" name="btnSubmit">
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
			Month Information
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
						<th>Month Name</th>

						<th>Action</th>
					</tr>
				</thead>

				<tbody>
					<?php 
					$query = $this->db->query("SELECT * FROM tbl_month order by month_id ASC ");
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
						<td><a href="#"><?php echo $row->month_name; ?></a></td>
						<td>
							<?php if($this->session->userdata('accountType') != 'u'){?>
							<div class="hidden-sm hidden-xs action-buttons">
							
								<span class="green" style="cursor:pointer;" onclick="editMonth(<?php echo $row->month_id; ?>);" title="Edit">
									<i class="ace-icon fa fa-pencil bigger-130"></i>
								</span>
							</div>
							<?php }?>
						</td>
					</tr>
					
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	 function updatedata(){
        var month_id = $('#month_id').val();
        var month = $('#month').val();

        if(month ==""){
            $('#msc').html('Required Field').css("color","red");
            return false;
        }
            var inputdata = 'month_id='month_id+'&month='+month;
            //alert(inputdata);
            var urldata = "<?php echo base_url();?>updateMonth";
            $.ajax({
                type: "POST",
                url: urldata,
                data: inputdata,
                success:function(data){
					if(data){
						alert(data);
					}else{
						return false;
					}
					location.reload();
                }
            });
    }
</script>
<script type="text/javascript">
    function Submitdata(){
        var month = $('#month').val();

        if(month ==""){
            $('#msc').html('Required Field').css("color","red");
            return false;
        }
        var succes = "";
        if(succes == ""){
            var inputdata = 'month='+month;
            //alert(inputdata);
            var urldata = "<?php echo base_url();?>insertMonth";
            $.ajax({
                type: "POST",
                url: urldata,
                data: inputdata,
                success:function(data){
                    //$('#success').html('Save Success').css("color","green");
                    //$('#Search_Resultsmonth').html(data);
                    //alert("ok");
                    //setTimeout(function() {$.fancybox.close()}, 500);
					if(data){
						alert(data);
					}else{
						return false;
					}
					location.reload();
                }
            });
        }
    }


</script>