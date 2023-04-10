<div  class="dialog contact" >
    <div class="full clearfix" style="width:320px;height:200px">
        <strong>Add Unit</strong>
        <input name="add_unit" type="text" id="add_unit" style="width:300px;"  class="txt" placeholder="Add Unit"  />
        <span id="msc"></span>
	    <br><br><br>
	    <input type="button" onclick="Submitdata()" value="Add" class="button" style="width:50px;float:right"/>
    </div>
    <h3 id="success"></h3>
</div> 

<script type="text/javascript">
	function Submitdata(){
		var add_unit = $('#add_unit').val();

		if(add_unit ==""){
			$('#msc').html('Required Field').css("color","green");
			return false;
		}
		
		var succes = "";
		if(succes == ""){
			var inputdata = 'add_unit='+add_unit;
			//alert(inputdata);
			var urldata = "<?php echo base_url();?>Administrator/products/insert_unit/";
			$.ajax({
				type: "POST",
				url: urldata,
				data: inputdata,
				success:function(data){
					$('#success').html('Save Success').css("color","green");
					$('#Search_Results').html(data);
					//alert("ok");
					setTimeout(function() {$.fancybox.close()}, 2000);
				}
			});
		}
	}
</script>