<div class="content_scroll">
    <div class="tabContent">
        <div id="tabs" class="clearfix moderntabs">
            <div id="tabs-1">
                <div class="middle_form">
                    <h2 id="">Edit Country</h2>
                    <div class="body">
                        <div class="full clearfix">
                            <span>Country Name</span>
                            <div class="left">                                      
                                <input name="Country" type="text" id="Country" class="required" value="<?php echo $selected['CountryName'] ?>" autofocus="" />
                                <input name="id" type="hidden" id="id" class="required" value="<?php echo $selected['Country_SlNo'] ?>" autofocus="" />
                                <span id="msg"></span>
                            </div>
                        </div>
                        <div class="full clearfix">
                            <div class="section_right clearfix">
                                <input type="button" onclick="submit()" name="btnSubmit" value="Update" class="button" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span id="saveResult">
    <div class="row_section clearfix" style="margin-top:20px;padding-bottom:0px;">
        <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:30%;border-collapse:collapse;">
            <thead>
                <tr class="header">
                    <th style="width:10px"></th>
                    <th style="width:200px">Country Name</th>                                                               
                    <th style="width:200px">Action</th>                                                               
                </tr>
            </thead>
        </table>                    
    </div> 
    <div class="clearfix moderntabs" style="width:330px;width:30%;max-height:300px;overflow:auto;">
        
        <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;border-collapse:collapse;">
            <tbody>
            <?php $sql = mysql_query("SELECT * FROM tbl_country order by CountryName asc");
                while($row = mysql_fetch_array($sql)){ ?>
                <tr>
                    <td style="width:10px"></td>
                    <td style="width:200px"><?php echo $row['CountryName'] ?></td>
                    <td style="width:90px">
                       <a href="<?php echo base_url().'Administrator/page/countryedit/'.$row['Country_SlNo'];?>" style="color:green;font-size:20px;float:left" title="Eidt" onclick="return confirm('Are you sure you want to edit this item?');"><i class="fa fa-pencil"></i></a>
                        <span  style="cursor:pointer;color:red;font-size:20px;float:left;padding-left:10px" onclick="deleted(<?php echo $row['Country_SlNo'] ?>)"><i class="fa fa-trash-o"></i></span>
                    </td>
                </tr>
            <?php } ?>
            </tbody>    
        </table>
    </div> 
     </span>
</div>  
<script type="text/javascript">
    function submit(){
        var Country= $("#Country").val();
        var id= $("#id").val();
        if(Country==""){
            $("#msg").html("Required Filed").css("color","red");
            return false;
        }
        var inputdata = 'Country='+Country+'&id='+id;
        var urldata = "<?php echo base_url();?>Administrator/page/countryupdate";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#saveResult").html(data);
                alert("Update Success");
            }
        });
    }
</script>
<script type="text/javascript">
    function deleted(id){
        var deletedd= id;
        var inputdata = 'deleted='+deletedd;
        //alert(inputdata);
        var urldata = "<?php echo base_url();?>Administrator/page/countrydelete";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#saveResult").html(data);
                alert("Delete Success");
            }
        });
    }
</script>
