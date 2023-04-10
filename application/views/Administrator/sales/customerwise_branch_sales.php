
<div class="content_scroll">
<h2></h2>
    <div style="width:100%; float:left;">
        <div style="border:1px solid #ddd">
            <table > 
                <tr>
                    <td style="padding:5px 0px"><strong>Branch</strong></td>
                    <td style="padding:5px 0px"> 
                        <select name="" id="BranchID" data-placeholder="Choose a Branch..." class="chosen-select" style="width:200px" onchange="SelectBranchCustomer()">
                            <option value="">  </option>
                            <?php $SB = mysql_query("SELECT * FROM tbl_brunch ORDER BY Brunch_name ASC");
                            while($brow = mysql_fetch_array($SB)){ ?>
                            <option value="<?php echo $brow['brunch_id']; ?>"><?php echo $brow['Brunch_name']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td style="padding:5px 0px"><strong>Customer</strong></td>
                    <td style="padding:5px 0px"> 
                        <span id="CustomerData">
                        <select name="" id="customerID" data-placeholder="Choose a Customer..." class="chosen-select" style="width:200px">
                            <option value=""></option>
                        </select>
                        </span>
                    </td>
					
					 <td style="padding:5px 0px"><strong>Date From</strong></td>
                    <td style="padding:5px 0px" id="ashiqeCalender"><input name="Purchase_date" type="text" id="Sales_startdate" value="<?php echo date("Y-m-d") ?>" class="inputclass" style="width:185px"/></td>
                    <td style="padding:5px 0px">Date To</td>
                    <td style="padding:5px 0px" id="ashiqeCalender"><input name="Purchase_date" type="text" id="Sales_enddate" value="<?php echo date("Y-m-d") ?>" class="inputclass" style="width:185px"/></td>
                    <td style="padding:5px 5px"><input type="button" class="buttonAshiqe" onclick="Customerdata()" value="Search"></td>
                </tr>
                
            </table>
        </div>

        <div id="AjaxData">
            


        </div>
    </div>

</div>


<script type="text/javascript">

    function SelectBranchCustomer(){
        var BranchID = $("#BranchID").val();
        var inputData = 'BranchID='+BranchID;
        var urldata = "<?php echo base_url();?>Administrator/sales/branch_customer_search";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputData,
            success:function(data){
                $("#CustomerData").html(data);
                var config = {
                  '.chosen-select'           : {},
                  '.chosen-select-deselect'  : {allow_single_deselect:true},
                  '.chosen-select-no-single' : {disable_search_threshold:10},
                  '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                  '.chosen-select-width'     : {width:"95%"}
                }
                for (var selector in config) {
                  $(selector).chosen(config[selector]);
                }
            }
        });
    }

    function Customerdata(){
        var BranchID = $("#BranchID").val();
        var customerID = $("#customerID").val();
            if(customerID == ''){
                alert("Select Customer");
                return false;
            }
        var startdate = $("#Sales_startdate").val();
        var enddate = $("#Sales_enddate").val();
        var inputData = 'BranchID='+BranchID+'&customerID='+customerID+'&startdate='+startdate+'&enddate='+enddate;
        var urldata = "<?php echo base_url();?>Administrator/sales/branch_customer_sales_search";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputData,
            success:function(data){
                $("#AjaxData").html(data);
            }
        });
    }
</script>