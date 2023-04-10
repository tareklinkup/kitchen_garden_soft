<?php
$sql = mysql_query("SELECT * FROM tbl_customer WHERE Customer_SlNo = '$customerID'");
$row = mysql_fetch_array($sql);
?>
<div class="tabContent">
    <div id="tabs" class="clearfix moderntabs">
        <div id="tabs-1">
            <div class="right_form">
            <div class="body">
                <div class="full clearfix" id="ashiqeCalender">
                    <span>Date</span>
                    <input name="CAPdate" type="text" id="CAPdate" class="txt" value="<?php echo date('Y-m-d'); ?>" />
                </div>
                <div class="full clearfix">
                    <span>Customer ID</span>
                    <input name="CCode" type="text" id="CCode" class="txt" value="<?php echo $row['Customer_Code']; ?>" />
                </div>
                <div class="full clearfix">
                    <span>Customer Name</span>
                    <input type="hidden" id="CustID" value="<?php echo $row['Customer_SlNo']; ?>">
                    <input name="CName" type="text" id="CName" class="txt" value="<?php echo $row['Customer_Name']; ?>"/>
                </div>
                                    
                <div class="full clearfix">
                    <span>Advance Amount</span>
                    <input type="text" id="AdvanceAmount" class="txt" placeholder="0" />
                </div> 
                <div class="full clearfix">
                    <span>Note</span>
                    <textarea id="Note" class="txt" cols="31" rows="5"></textarea>
                </div> 
                <div class="full clearfix">
                    <span></span>
                    <input type="button" onclick="AdvancePay()" value="Pay" class="button" />
                </div>                                                                                                                                                                                
            </div>
            </div>
        </div>
    </div>
</div>