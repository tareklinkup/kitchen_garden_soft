<div class="row">
<div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-top:15px;">
	<div class="form-group" style="margin-top:10px;">
		<label class="col-sm-1 control-label no-padding-right" for="searchtype"> Search Type </label>
		<div class="col-sm-2">
			<select id="searchtype" data-placeholder="Choose an Option..." class="chosen-select" onchange="fatchAccountID()">
				<option value=""></option>
				<option value="All"> All </option>
				<option value="Account"> By Account </option>
			</select>
		</div>
	</div>
	
	<div class="form-group" style="margin-top:10px;" id="showcustomer">
		<label class="col-sm-1 control-label no-padding-right" for="accountid"> Account No </label>
		<div class="col-sm-3">
			 <select id="accountid" class="form-control" style="height: 30px;" name="accountid" data-placholder="Select an account" >
				<option value=""> Select a option </option>
			</select>
		</div>
	</div>

		<div class="col-sm-2">
			<div class="input-group">
				<input class="form-control date-picker" id="startdate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>" />
				<span class="input-group-addon"style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
	

		<div class="col-sm-2">
			<div class="input-group">
				<input class="form-control date-picker" id="enddate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>" />
				<span class="input-group-addon"style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
					<i class="fa fa-calendar bigger-110"></i>
				</span>
			</div>
		</div>
	
	<div class="form-group">
		<div class="col-sm-1">
			<input type="button" class="btn btn-primary" onclick="searchforRecord()" value="Show" style="margin-top:0px;border:0px;height:28px;">
		</div>
	</div>
</div>

<div class="col-xs-12 col-md-12 col-lg-12">
	<span id="expense">
	
	</span>

</div>
</div>


<script type="text/javascript">

	function fatchAccountID(){
      // debugger
      var searchtype = $("#searchtype").val();
        if(searchtype == "Account"){
            $("#showcustomer").show();
        }
        if(searchtype == "All"){
            $("#showcustomer").hide();
        }

      var id = 'Deposit To Bank';
        $.ajax({
            url : "<?php echo base_url(); ?>Administrator/Account/fatch_all_account_id",
            type: "POST",
            data:{id:id},
            dataType: "JSON",
            success: function(data)
            {
            	
                if(data){
                    $('#accountid>option').remove();
                    $('#accountid').html('<option value="">Select a Option</option>');
                    $.each(data, function (i, datas) {
                        $('#accountid').append($('<option>', { 
                            value: datas.Acc_SlNo,
                            text : datas.Acc_Name+' - '+datas.Acc_Code  
                        }));
                    });
                }
                
            }
        });
    }



    function searchforRecord(){
        var startdate = $("#startdate").val();
        var enddate = $("#enddate").val();
        var accountid = $("#accountid").val();
        var searchtype = $("#searchtype").val();
		if(searchtype==''){
			alert('Plz select sarch type');
			return false;
		}
        
        var inputData = 'searchtype='+searchtype+'&startdate='+startdate+'&enddate='+enddate+'&accountid='+accountid;
        var urldata = "<?php echo base_url();?>depositSearch";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputData,
            success:function(data){
                $("#expense").html(data);
            }
        });
    }
    
</script>

<script type="text/javascript">
    function Selected(){
        var searchtype = $("#searchtype").val();
        if(searchtype == "Account"){
            $("#showcustomer").show();
        }
        if(searchtype == "All"){
            $("#showcustomer").hide();
        }
    }
</script>
