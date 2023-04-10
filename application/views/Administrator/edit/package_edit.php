
<div class="content_scroll">
    <div class="tabContent">
        <div id="tabs" class="clearfix moderntabs">
            <div id="tabs-1">
               
                    <div class="middle_form">
                        <h2 id="">Edit Package<span style="color:green;float:right"><?php $status = $this->session->userdata('unit');if(isset($status))echo $status;$this->session->unset_userdata('unit'); ?></span>
                            <span style="color:red;float:right;font-size:15px;"><?php if(isset($exists))echo $exists;?></span>
                        </h2>
                        <div class="body">
                            <div class="full clearfix">
                                <span>Package Name</span>
                                <div class="left">                                      
                                    <input name="packagename" type="text" id="packagename" class="required" value="<?php echo $selected['package_name'] ?>" autofocus="" required/>
                                    <input type="hidden" id="id" value="<?php echo $selected['package_ID'] ?>" >
                                    <span id="msg"></span>
                                </div>
                            </div>
                            <div class="full clearfix">
                                <span>Category</span>
                                <div class="left">                                      
                                    <select name="pCategory" id="pCategory" style="width:175px;" >
                                        <option value="<?php echo $selected['package_categoryid'] ?>"><?php echo $selected['ProductCategory_Name'] ?></option>
                                         <?php $sql = mysql_query("SELECT * FROM tbl_productcategory order by ProductCategory_Name asc");
                                        while($row = mysql_fetch_array($sql)){ ?>
                                        <option value="<?php echo $row['ProductCategory_SlNo'] ?>"><?php echo $row['ProductCategory_Name'] ?></option>
                                        <?php } ?>
                                    </select>  
                                </div>
                            </div>
                            <div class="full clearfix">
                                <span>Purchase Price</span>
                                <div class="left">                                      
                                    <input name="purchaseprice" type="text" id="purchaseprice" class="required" value="<?php echo $selected['package_purchPrice'] ?>" />
                                </div>
                            </div>
                            <div class="full clearfix">
                                <span>Sales Price</span>
                                <div class="left">                                      
                                    <input name="salesprice" type="text" id="salesprice" class="required" value="<?php echo $selected['package_sellPrice'] ?>" />
                                </div>
                            </div>
                            <div class="full clearfix">
                                <div class="section_right clearfix">
                                    <input type="button" onclick="update()" name="btnSubmit" value="Update"  title="Save" class="button" />
                                </div>
                            </div>
                        </div>
                    </div>
               
            </div>
        </div>
    </div>
    <div class="row_section clearfix" style="margin-top:20px;padding-bottom:0px;">
        <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:60%;border-collapse:collapse;">
            <thead>
                <tr class="header">
                    <th style="width:10px"></th>
                    <th style="width:200px">Package Name</th>                                                               
                    <th style="width:200px">Category Name</th>                                                               
                    <th style="width:200px">Purchase Price</th>                                                               
                    <th style="width:200px">Sales Price</th>                                                               
                    <th style="width:90px">Action</th>                                                               
                </tr>
            </thead>
        </table>                    
    </div> 
    <div class="clearfix moderntabs" style="width:330px;width:60%;max-height:300px;overflow:auto;">
        
        <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;border-collapse:collapse;">
            <tbody>
                <?php $sql = mysql_query("SELECT tbl_package.*, tbl_productcategory.* FROM tbl_package left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo =tbl_package.package_categoryid  order by package_name asc");
                while($row = mysql_fetch_array($sql)){ ?>
                <tr>
                    <td style="width:10px"></td>
                    <td style="width:200px"><?php echo $row['package_name'] ?></td>
                    <td style="width:200px"><?php echo $row['ProductCategory_Name'] ?></td>
                    <td style="width:200px"><?php echo $row['package_purchPrice'] ?></td>
                    <td style="width:200px"><?php echo $row['package_sellPrice'] ?></td>
                    <td style="width:90px">
                        <span  style="cursor:pointer;color:green;font-size:20px;float:left;padding-left:10px" onclick="packageEdit(<?php echo $row['package_ID'] ?>)"><i class="fa fa-pencil"></i></span>
                        <span  style="cursor:pointer;color:red;font-size:20px;float:left;padding-left:10px" onclick="deleted(<?php echo $row['package_ID'] ?>)"><i class="fa fa-trash-o"></i></span>
                    </td>
                </tr>
            <?php } ?> 
            </tbody>    
        </table> 
        
    </div> 
</div> 