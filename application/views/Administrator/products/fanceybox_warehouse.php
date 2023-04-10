<div  class="dialog contact" >
    <div class="full clearfix" style="width:320px;height:250px">
        <strong>Purchase For</strong>
        <input name="add_Category" type="text" id="add_Category" style="width:300px;"  class="txt" placeholder="Purchase For"  />
        <span id="msc"></span><br><br>
        
	    <br><br><br>
	    <input type="button" onclick="SubmitdatW()" value="Add" class="button" style="width:50px;float:right"/>
    </div>
    <h3 id="success"></h3>
</div> 

<script type="text/javascript">
	function SubmitdatW(){
		var add_Category = $('#add_Category').val();

		if(add_Category ==""){
			$('#msc').html('Required Field').css("color","green");
			return false;
		}
		
		var inputdata = 'add_Category='+add_Category;
		//alert(inputdata);
		var urldata = "<?php echo base_url();?>Administrator/products/insert_fanceybox_Warehouse/";
		$.ajax({
			type: "POST",
			url: urldata,
			data: inputdata,
			success:function(data){
				$('#success').html('Save Success').css("color","green");
				$('#Search_Results_warehouse').html(data);
				//alert("ok");
				setTimeout(function() {$.fancybox.close()}, 2000);
			}
		});
		
	}
</script>