<div  class="dialog contact" >
    <div class="full clearfix" style="width:330px;height:200px">
        <strong>Add Depertment</strong>
        <input name="Depertment" type="text" id="Depertment" style="width:300px;"  class="txt" placeholder="Add Depertment"  />
        <span id="msc"></span>
        <br><br><br>
        <input type="button" onclick="Submitdata()" value="Add" class="button" style="width:50px;"/>
    </div>
    <h3 id="success"></h3>
</div> 

<script type="text/javascript">
    function Submitdata(){
        var Depertment = $('#Depertment').val();

        if(Depertment ==""){
            $('#msc').html('Required Field').css("color","green");
            return false;
        }
        var succes = "";
        if(succes == ""){
            var inputdata = 'Depertment='+Depertment;
            //alert(inputdata);
            var urldata = "<?php echo base_url();?>Administrator/employee/fancybox_insert_depertment/";
            $.ajax({
                type: "POST",
                url: urldata,
                data: inputdata,
                success:function(data){
                    $('#success').html('Save Success').css("color","green");
                    $('#Search_Resultsss').html(data);
                    //alert("ok");
                    setTimeout(function() {$.fancybox.close()}, 2000);
                }
            });
        }
    }
</script>