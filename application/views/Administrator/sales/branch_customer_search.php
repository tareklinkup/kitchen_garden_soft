<select name="" id="customerID" data-placeholder="Choose a Customer..." class="chosen-select" style="width:200px">
<option value=""></option>
<option value="ALL">All</option>
<?php
$SC = mysql_query("SELECT * FROM tbl_customer WHERE Customer_brunchid = '$BranchID' ORDER BY Customer_Code ASC");
while ($CROW = mysql_fetch_array($SC)) {
?>
<option value="<?php echo $CROW['Customer_SlNo']; ?>"><?php echo $CROW['Customer_Name'].' '. $CROW['Customer_Mobile']; ?></option>
<?php
}
?>
</select>