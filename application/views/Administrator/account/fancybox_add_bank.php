<div class="content_scroll">
    <div class="tabContent">
        <div id="tabs" class="clearfix moderntabs">
            <div id="tabs-1">
               
                    <div class="middle_form">
                        <h2 id="">Add Bank</h2>
                        <div class="body">
                            <div class="full clearfix">
                                <span>Bank Name</span>
                                <div class="left">                                      
                                    <input name="Bank" type="text" id="Bank" class="required" placeholder="" autofocus="" style="width:100%" />
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
        var Bank= $("#Bank").val();
        if(Bank==""){
            $("#msg").html("Required Filed").css("color","red");
            return false;
        }
        var inputdata = 'Bank='+Bank;
        var urldata = "<?php echo base_url() ?>Administrator/page/fancyBox_insert_Bank";
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
                        $("#BankResult").html(data);
                         setTimeout(function() {$.fancybox.close()}, 2000);
                    }
            }
        });
    }
</script>
