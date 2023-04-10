<div id="AdPayArea">
<div class="content_scroll">
<h2>Advance Payment Customer Search</h2>
    <div style="width:100%; float:left;">
        <div style="border:1px solid #ddd">
            <table > 
                <tr>
                    <td><strong>Customer</strong></td>
                    <td>
                        <select name="" id="customerID" data-placeholder="Choose a Customer..." class="chosen-select" style="width:200px" onchange="Customerdata()">
                            <option value="">  </option>
                            <?php $sql = mysql_query("SELECT * FROM tbl_customer order by Customer_Name asc");
                            while($row = mysql_fetch_array($sql)){ ?>
                            <option value="<?php echo $row['Customer_SlNo']; ?>"><?php echo $row['Customer_Name']; ?> (<?php echo $row['Customer_Code']; ?>)</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div id="CustomerDue"></div>
    </div>

</div>
</div>
<script type="text/javascript">
    function Customerdata(){
        var customerID = $("#customerID").val();
        var inputData = 'customerID='+customerID;
        var urldata = "<?php echo base_url();?>Administrator/customer/advance_payment_customer_search";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputData,
            success:function(data){
                $("#CustomerDue").html(data);
            }
        });
    }
    function AdvancePay(){
        var CustID = $("#CustID").val();
        var CAPdate = $("#CAPdate").val();
        var AdvanceAmount = $("#AdvanceAmount").val();
        var Note = $("#Note").val();

        var inputData = 'CustID='+CustID+'&CAPdate='+CAPdate+'&AdvanceAmount='+AdvanceAmount+'&Note='+Note;
        var urldata = "<?php echo base_url();?>Administrator/customer/advance_payment_insert";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputData,
            success:function(data){
                var err = data;
                if(err){
                    if(confirm('Show Report')){
                        window.location.href='<?php echo base_url();?>Administrator/customer/customer_advance_payment_to_report';
                    }else{
                        $("#AdPayArea").html(data);
                        alert('Payment Success');
                    }
                }
            }
        });
    }
</script>