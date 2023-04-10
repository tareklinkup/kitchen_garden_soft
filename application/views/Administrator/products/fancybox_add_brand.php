<div class="content_scroll">
    <div class="tabContent">
        <div id="tabs" class="clearfix moderntabs">
            <div id="tabs-1">
               
                    <div class="middle_form">
                        <h2 id="">Add Brand</h2>
                        <div class="body">
						<!---<div class="full clearfix">
                                <span>Category Name</span>
                                <div class="left">                                      
                                  <div id="Search_Results_category">
                                        <select name="modalCategory" id="modalCategory" required>
                                            <option value="">Select</option>
                                             <?php /* $sql = mysql_query("SELECT * FROM tbl_productcategory order by ProductCategory_Name asc");
                                            while($row = mysql_fetch_array($sql)){ */ ?>
                                            <option value="<?php //echo $row['ProductCategory_SlNo'] ?>"><?php //echo $row['ProductCategory_Name'] ?></option>
                                            <?php //} ?>
                                        </select>  
                                    </div>               
                                </div>
                            </div>-->
						
                            <div class="full clearfix">
                                <span>Brand Name</span>
                                <div class="left">                                      
                                    <input name="modalBrand" type="text" id="modalBrand" class="required" placeholder="" autofocus="" style="width:100%" />
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
        //var pCategory= $("#modalCategory").val();
        var brand= $("#modalBrand").val();
        if(brand==""){
            $("#msg").html("Required Filed").css("color","red");
            return false;
        }
        //var inputdata = 'pCategory='+pCategory+'&brand='+brand;
        var inputdata = 'brand='+brand;
		//alert(inputdata);
        var urldata = "<?php echo base_url() ?>Administrator/page/fancybox_insert_brand";
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
                        $('#BRAND').html(data);                        
                        setTimeout(function() {$.fancybox.close()}, 100);
                    }
            }
        });
    }
</script>
=