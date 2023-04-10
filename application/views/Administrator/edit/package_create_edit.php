
<div class="content_scroll">
    <div class="tabContent">
        <div id="tabs" class="clearfix moderntabs">
            <div id="tabs-1">
                <div class="middle_form">
                    <h2 id="">Edit Package Create<span style="color:green;float:right"><?php $status = $this->session->userdata('unit');if(isset($status))echo $status;$this->session->unset_userdata('unit'); ?></span>
                        <span style="color:red;float:right;font-size:15px;"><?php if(isset($exists))echo $exists;?></span>
                    </h2>
                    <div class="body">
                        <div class="full clearfix">
                            <span>Package Type</span>
                            <div class="left">                                      
                                <select id="packateType" class="required" style="width:175px">
                                    <option value="<?php echo $selected['create_pacageID'] ?>"><?php echo $selected['package_name'] ?></option>
                                <?php $sql = mysql_query("SELECT * FROM tbl_package ORDER BY package_name ");
                                while($ore = mysql_fetch_array($sql)){ ?>
                                    <option value="<?php echo $ore['package_ProCode'] ?>"><?php echo $ore['package_name'] ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="full clearfix">
                            <span>Category</span>
                            <div class="left">                                      
                                <select name="pCategory" id="pCategory" style="width:175px;" >
                                    <option value="<?php echo $selected['ProductCategory_ID'] ?>"><?php echo $selected['ProductCategory_Name'] ?></option>
                                     <?php $sql = mysql_query("SELECT * FROM tbl_productcategory order by ProductCategory_Name asc");
                                    while($row = mysql_fetch_array($sql)){ ?>
                                    <option value="<?php echo $row['ProductCategory_SlNo'] ?>"><?php echo $row['ProductCategory_Name'] ?></option>
                                    <?php } ?>
                                </select>  
                            </div>
                        </div>
                       <div class="full clearfix">
                            <span>Package Item</span>
                            <div class="left">                                      
                                <input name="packageItem" type="text" id="packageItem" class="required"  value="<?php echo $selected['create_item'] ?>" />
                                <input  type="hidden" id="id" class="required"  value="<?php echo $selected['create_ID'] ?>" />
                                <input type="hidden" id="pcode" class="required"  value="<?php echo $selected['create_proCode'] ?>" />
                            </div>
                        </div>
                        <div class="full clearfix">
                            <span>Purchase Price</span>
                            <div class="left">                                      
                                <input type="text" id="purchprice" class="required" value="<?php echo $selected['create_purch_price'] ?>" />
                            </div>
                        </div>
                        <div class="full clearfix">
                            <span>Sales Price</span>
                            <div class="left">                                      
                                <input type="text" id="sellpirce" class="required" value="<?php echo $selected['create_sell_price'] ?>" />
                            </div>
                        </div>
                        <div class="full clearfix">
                            <span>Item Qty</span>
                            <div class="left">                                      
                                <input type="text" id="itemqty" class="required" value="<?php echo $selected['cteate_qty'] ?>" />
                            </div>
                        </div>
                        <div class="full clearfix">
                            <div class=" clearfix" style="float:right">
                                <input type="button" onclick="update()" name="btnSubmit" value="Update"  title="Update" class="button" style="margin-left:20px" />
                                <a href="<?php echo base_url();?>Administrator/package/create" class="button">Cancel</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="row_section clearfix" style="margin-top:20px;padding-bottom:0px;">
        <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:100%;border-collapse:collapse;">
            <thead>
                <tr class="header">
                    <th style="width:10px"></th>
                    <th style="width:200px">Product Name</th>                                                               
                    <th style="width:200px">Item Name</th>                                                               
                    <th style="width:200px">Purchase Price</th>                                                               
                    <th style="width:200px">Sales Price</th>                                                               
                    <th style="width:200px">Item Qty</th>                                                               
                    <th style="width:97px">Action</th>                                                               
                </tr>
            </thead>
        </table>                    
    </div> 
    <div class="clearfix moderntabs" style="width:330px;width:100%;max-height:300px;overflow:auto;">
        <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;border-collapse:collapse;">
            <tbody>
                <?php $sql = mysql_query("SELECT tbl_package_create.*, tbl_package.* FROM tbl_package_create left join tbl_package on tbl_package.package_ProCode = tbl_package_create.create_pacageID order by tbl_package_create.create_item asc");
                while($row = mysql_fetch_array($sql)){ ?>
                <tr>
                    <td style="width:10px"></td>
                    <td style="width:200px"><?php echo $row['package_name'] ?></td>
                    <td style="width:200px"><?php echo $row['create_item'] ?></td>
                    <td style="width:200px"><?php echo $row['create_purch_price'] ?></td>
                    <td style="width:200px"><?php echo $row['create_sell_price'] ?></td>
                    <td style="width:200px"><?php echo $row['cteate_qty'] ?></td>
                    <td style="width:97px">
                        <span  style="cursor:pointer;color:green;font-size:20px;float:left;padding-left:10px" onclick="packageEdit(<?php echo $row['create_ID'] ?>)"><i class="fa fa-pencil"></i></span>
                        <span  style="cursor:pointer;color:red;font-size:20px;float:left;padding-left:10px" onclick="deleted(<?php echo $row['create_ID'] ?>)"><i class="fa fa-trash-o"></i></span>
                    </td>
                </tr>
            <?php } ?> 
            </tbody>    
        </table> 
    </div>