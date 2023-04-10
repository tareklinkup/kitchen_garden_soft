<div class="content_scroll">
<h2>Date wise cash view</h2>
    <div style="width:100%; float:left;">
        <div style="border:1px solid #ddd">
            <table > 
                <tr>
                    <td><strong>Branch</strong></td>
                   <td> 
                        <select name="" id="BranchID" data-placeholder="Choose a Branch..." class="chosen-select" style="width:200px">
                            <option value="">  </option>
                            <?php 
                            // $userBrunch = $this->session->userdata('BRANCHid');
                            $sql = mysql_query("SELECT * FROM tbl_brunch ORDER BY brunch_id ASC");
                            while($row = mysql_fetch_array($sql)){ ?>
                            <option value="<?php echo $row['brunch_id']; ?>"><?php echo $row['Brunch_name']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><strong>Date</strong></td>
                    <td id="ashiqeCalender"><input name="Purchase_date" type="text" id="Sales_startdate" value="<?php echo date("Y-m-d") ?>" class="inputclass" style="width:200px"/></td>
                    <td><input type="button" class="buttonAshiqe" onclick="Customerdata()" value="Search"></td>
                </tr>
            </table>
        </div>
        <div id="AjaxData">
            


        </div>
    </div>

</div>


<script type="text/javascript">

    function Customerdata(){
        var BranchID = $("#BranchID").val();
        var CDate = $("#Sales_startdate").val();
        var inputData = 'BranchID='+BranchID+'&CDate='+CDate;
        var urldata = "<?php echo base_url();?>Administrator/account/datewise_cash_view_search";

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