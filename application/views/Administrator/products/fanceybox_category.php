<div  class="dialog contact" >
    <div class="full clearfix" style="width:320px;height:250px">
        <strong>Add Category</strong>
        <input name="add_Category" type="text" id="add_Category" style="width:300px;"  class="txt" placeholder="Add Category"  />
        <span id="msc"></span><br><br>
        <strong>Description</strong>
        <textarea name="catdescrip" id="catdescrip" style="width:300px" rows="2"></textarea>
        <span id="msc"></span>
	    <br><br><br>
	    <input type="button" onclick="Submitdata()" value="Add" class="button" style="width:50px;float:right"/>
    </div>
    <h3 id="success"></h3>
</div> 

<script type="text/javascript">
	function Submitdata(){
		var add_Category = $('#add_Category').val();

		if(add_Category ==""){
			$('#msc').html('Required Field').css("color","green");
			return false;
		}
		var catdescrip = $('#catdescrip').val();
		var succes = "";
		if(succes == ""){
			var inputdata = 'add_Category='+add_Category+'&catdescrip='+catdescrip;
			//alert(inputdata);
			var urldata = "<?php echo base_url();?>Administrator/products/insert_fanceybox_category/";
			$.ajax({
				type: "POST",
				url: urldata,
				data: inputdata,
				success:function(data){
					$('#success').html('Save Success').css("color","green");
					$('#Search_Results_category').html(data);
					//alert("ok");
					setTimeout(function() {$.fancybox.close()}, 2000);
				}
			});
		}
	}
</script>