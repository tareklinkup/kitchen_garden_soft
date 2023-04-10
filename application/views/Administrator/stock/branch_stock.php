<div class="content_scroll">
    <div style="width:100%; float:left;">
        <div style="border:1px solid #ddd">
            <table > 
                <tr>
                    <td style="padding:5px 0px"><strong>Branch</strong></td>
                    <td style="padding:5px 0px"> 
                        <select name="" id="BranchID" data-placeholder="Choose a Branch..." class="chosen-select" style="width:200px" onchange="showCategoryforSearch(this.value)">
                            <option value="">  </option>
                            <?php $SB = mysql_query("SELECT * FROM tbl_brunch ORDER BY Brunch_name ASC");
                            while($brow = mysql_fetch_array($SB)){ ?>
                            <option value="<?php echo $brow['brunch_id']; ?>"><?php echo $brow['Brunch_name']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td><strong>Category </strong></td>
               <td> 
                    <select id="Categorys" class="inputclass" style="width:200px">
                      	<!--<option value="All">Select All</option> -->
                    </select>
                </td>
                <td style="padding:5px 5px"><input type="button" class="buttonAshiqe" onclick="BranchStock()" value="Search"></td>
				<td width="200"></td>
				<td><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>Administrator/reports/branch_stock_print', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><img src="<?php echo base_url(); ?>images/printer.png" alt=""> Print</a></td>
            </tr>
                
            </table>
        </div>

        <div id="AjaxData">
            


        </div>
    </div>

</div>


<script type="text/javascript">

    function BranchStock(){
        var BranchID = $("#BranchID").val();
        var Categorys = $("#Categorys").val();
        var inputData = 'BranchID='+BranchID+'&Categorys='+Categorys;
        var urldata = "<?php echo base_url();?>Administrator/products/branch_stock_search";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputData,
            success:function(data){
                $("#AjaxData").html(data);
            }
        });
    }
	
	function showCategoryforSearch(str) {
	//alert(str);
    if (str == "") {
        document.getElementById("Categorys").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("Categorys").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","<?php echo base_url(); ?>Administrator/page/select_category_by_branch/"+str,true);
        xmlhttp.send();
    }
}
</script>