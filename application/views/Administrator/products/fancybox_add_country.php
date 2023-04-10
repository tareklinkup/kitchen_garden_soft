<div class="content_scroll">
    <div class="tabContent">
        <div id="tabs" class="clearfix moderntabs">
            <div id="tabs-1">
               
                    <div class="middle_form">
                        <h2 id="">Add Country</h2>
                        <div class="body">
                            <div class="full clearfix">
                                <span>Country Name</span>
                                <div class="left">                                      
                                    <input name="Country" type="text" id="Country" class="required" placeholder="" autofocus="" style="width:100%" />
                                    <span id="msg"></span>
                                </div>
                            </div>
                            <div class="full clearfix">
                                <div class="section_right clearfix">
                                    <input type="button" onclick="submit()" name="btnSubmit" value="Add"  title="Save" class="button" style="margin-left:55px" />
                                </div>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
    
</div> 
<script type="text/javascript">
    function submit(){
        var Country= $("#Country").val();
        if(Country==""){
            $("#msg").html("Required Filed").css("color","red");
            return false;
        }
        var inputdata = 'Country='+Country;
        var urldata = "<?php echo base_url();?>Administrator/page/fancybox_insert_country";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                
                    var err = data;
                    if((err)=="F"){
                        alert("This Name Allready Exists");
                    }else{
                        alert("Save Success");
                        $('#Coun').html(data);                        
                        setTimeout(function() {$.fancybox.close()}, 1000);
                    }
            }
        });
    }
</script>
