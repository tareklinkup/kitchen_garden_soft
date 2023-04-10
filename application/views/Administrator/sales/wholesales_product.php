<span id="SalescartRefresh">
<div class="content_scroll">
<h2>Whole Sales Product </h2>
    <div style="width:78%; float:left;">
        <div style="border:1px solid #ddd">
            <table width="100%"> 
                <tr>
                    <td>Invoice no</td>
                    <td>
                    <div class="full clearfix">
                        <input type="text" class="inputclass" disabled="" style="width:200px" value="<?php $sql = mysql_query("SELECT * FROM tbl_salesmaster");
                            $rownumber ='00';$rownumber = mysql_num_rows($sql);
                            $rownumber = $rownumber+1;
                           echo 'WC'.date("Y-m-d").$rownumber;?>">
                        <input type="hidden" id="salesInvoiceno" value="<?php $sql = mysql_query("SELECT * FROM tbl_salesmaster");
                            $rownumber ='00';$rownumber = mysql_num_rows($sql);
                            $rownumber = $rownumber+1;
                           echo 'WC'.date("Y-m-d").$rownumber;?>">
                    </div></td>
                    <td>User</td>
                    <td>
                    <div class="full clearfix">
                        <input type="text" disabled="" class="inputclass" value="<?php echo $this->session->userdata("FullName"); ?>" style="width:200px">
                        <input type="hidden" class="inputclass" value="<?php echo $this->session->userdata("FullName"); ?>" style="width:200px">
                    </div></td>
                    <td>Date</td>
                    <td>
                    <div class="full clearfix" >
                        <input name="sales_date" readonly="" id="sales_date" type="text" value="<?php echo date("Y-m-d") ?>" id="em_Joint_date" class="inputclass" style="width:200px"/>
                    </div></td>
                </tr>
            </table>
        </div><br>
        <div style="width:100%; ">
        <table width="100%" style="float-left"> 
            <tr>
                <td style="border: 1px solid #ddd;"><!-- Customer area -->
                    <table > 
                        <tr>
                            <td style="width:100px">Customer ID</td>
                           
                            <td>
                                <div class="side-by-side clearfix">
                                    <div>
                                          <select id="customerID" data-placeholder="Choose a Customer..." class="chosen-select" style="width:200px;" tabindex="2" onchange="Customer()">
                                                <option value=""></option>
                                                <?php $sql = mysql_query("SELECT * FROM tbl_customer order by Customer_Name asc");
                                                while($row = mysql_fetch_array($sql)){ ?>
                                                <option value="<?php echo $row['Customer_SlNo'] ?>"> <?php echo $row['Customer_Name']; ?>(<?php echo $row['Customer_Code']; ?>) </option>
                                                <?php } ?>
                                          </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </table>
                        <span id="CustomerResult">
                            <table>
                                <tr>
                                    <td style="width:100px">Name</td>
                                    <td style="width:200px">
                                        <div class="full clearfix">
                                            <input type="text" class="inputclass" disabled="" value="">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Address</td>
                                    <td style="width:200px">
                                        <div class="full clearfix">
                                            <textarea name="" id="" rows="2" disabled="" class="inputclass"></textarea>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Contact No</td>
                                    <td style="width:200px">
                                        <div class="full clearfix">
                                            <input type="text" disabled="" class="inputclass" value="">
                                        </div>
                                    </td>
                                </tr>
                                
                            </table>
                        </span>
                </td>
                <td style="border: 1px solid #ddd;"><!-- Product area -->
                    <table > 
                        <tr>
                            <td style="width:100px">Product ID</td>
                            <td style="width:200px">
                                <div class="side-by-side clearfix">
                                    <div>
                                          <select id="ProID" data-placeholder="Choose a Product..." class="chosen-select" style="width:200px;" tabindex="2" onchange="Products()">
                                                <option value=""></option>
                                                <?php $sql = mysql_query("SELECT tbl_product.*, tbl_productcategory.* FROM tbl_product left join tbl_productcategory on tbl_productcategory.ProductCategory_SlNo= tbl_product.ProductCategory_ID order by tbl_product.Product_Code asc");
                                                while($row = mysql_fetch_array($sql)){ ?>
                                                <option value="<?php echo $row['Product_SlNo'] ?>"><?php echo $row['Product_Name'] ?> (<?php echo $row['Product_Code'] ?>)</option>
                                                <?php } ?>
                                          </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <span id="ProductsResult">
                    <table>
                        <tr>
                            <td  style="width:100px">Name</td>
                            <td style="width:200px">
                                <div class="full clearfix">
                                    <input type="text" id="proName" class="inputclass">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Quantity</td>
                            <td style="width:200px">
                                <div class="full clearfix">
                                    <input type="number" id="proQTY" onkeyup="keyUPAmount()" class="inputclass">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Rate</td>
                            <td style="width:200px">
                                <div class="full clearfix">
                                    <input type="number" id="ProRATe" onkeyup="keyupamount2()" class="inputclass">
                                    <input type="hidden" id="ProPurchaseRATe" >
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>Amount</td>
                            <td style="width:200px">
                                <div class="full clearfix">
                                    <input type="number" id="ProductAmont" class="inputclass" readonly="">
                                </div>
                            </td>
                        </tr>
                    </table>

                    </span>
                </td>
                <td> <!-- Stock  area -->
                    <table>
                        <tr>
                            <td>
                                <span style="color:red">Stock Available</span>
                            </td>
                        </tr>
                        <tr style="height:150px" >
                            <td align="center">
                                <input type="text" id="stockpro" readonly style="border:none;font-size:20px;width:78px;text-align:center;color:green"><br>
                                <input type="text" id="Prounit" readonly style="border:none;font-size:12px;width:20px">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="button" class="buttonAshiqe" value="Add Cart" onclick="ADDTOCART()">
                            </td>
                        </tr>
                    </table>
                </td>
                </tr>
        </table>
            <div class="row_section clearfix" style="margin-top:20px;padding-bottom:0px;">
                <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr class="header">
                            <th style="width:2%"></th>
                            <th style="width:20%">Product Information</th>
                            <th style="width:10%">Unit</th>
                            <th style="width:10%">Rate</th>
                            <th style="width:10%">Qty</th>
                            <th style="width:10%">Total</th>
                            <th style="width:10%"></th>                                                      
                        </tr>
                    </thead>
                </table>                    
            </div> 
            <span id="Salescartlist">
            <div class="clearfix moderntabs" style="width:330px;width:100%;max-height:100px;min-height:100px;overflow:auto;">
                
               <?php  if ($cart = $this->cart->contents()): ?>
                        <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;border-collapse:collapse;">
                            <tbody>
                            <?php
                                //echo form_open('shopping/update_cart');purchaserate
                                $grand_total = 0;
                                $count = "";
                                $i = 0;
                                foreach ($cart as $item):
                                    $i++;
                                    $count = $item['qty'];
                                    echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
                                    echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
                                    echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
                                    echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
                                    echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
                                    echo form_hidden('cart[' . $item['id'] . '][image]', $item['image']); 
                            ?> 
                                <tr>
                                    <td style="width:2%"></td>
                                    <td style="width:20%"><?php echo $item['name']; ?></td>
                                    <td style="width:10%"><?php echo $item['image']; ?></td>
                                    <td style="width:10%"><?php echo $item['price']; ?></td>
                                    <td style="width:10%"><?php echo $item['qty']; ?></td>
                                    <td style="width:10%"><?php $grand_total = $grand_total + $item['subtotal']; ?> <?php echo number_format($item['subtotal'], 2) ?>
                                    <input type="hidden" id="PriCe_<?php echo $item['rowid'];?>" value="<?php echo $item['subtotal']; ?>"></td>
                                    <td style="width:10%">
                                        <span style="cursor:pointer" onclick="cartRemove(a='<?php echo $item['rowid'];?>')">
                                        <input type="hidden" id="rowid<?php echo $item['rowid'];?>" value="<?php echo $item['rowid'];?>">
                                        <img src='<?php echo base_url() ?>images/cart_cross.jpg' width='20px' height='15px'></span>
                                    </td>
                                </tr>


                                <?php endforeach; ?>
                            </tbody>    
                        </table> 
                        <input type="hidden" id="ckqty" value="<?php echo $count; ?>">
                        <?php endif; ?>
                    
            </div>
        <table width="100%">
            <tr>
                <td width="40%" >
                    <fieldset style="height:65px">
                        <legend>Notes</legend>
                        <textarea name="SelesNotes" id="SelesNotes" rows="2" style="width:100%"></textarea>
                    </fieldset>
                </td>
                <td width="60%">
                    <fieldset style="height:65px">
                        <legend>Total</legend>
                        <h2>
                            <span>Total</span>
                            <div style="float:right">
                                <span style="color:red"><?php if(isset($grand_total)) {echo $grand_total;}else{echo 0;} ?></span>
                                <span>tk</span>
                            </div>
                        </h2>
                    </fieldset>
                </td>

            </tr>
        </table>
        </span>   
    </div>
    </div>
    <div style="width:20%; float:left">
        <fieldset>
            <legend>Amount Details</legend>
            <table width="100%"> 
                <tr>
                    <td>Sub Total<br>
                    <div class="full clearfix">
                        <input type="number" id="subTotalDisabled" disabled="" class="inputclass" value="0">
                        <input type="hidden" id="subTotal"  class="inputclass" value="0">
                    </div></td>
                </tr>
                <tr>
                    <td>Vat<br>
                    <div class="full clearfix">
                        <input type="number" id="vatPersent" onkeyup="vatonkeyup()" class="inputclass" style="width:50px" value="0"> % 
                        <input type="text" id="SellVat" readonly="" class="inputclass" style="width:86px" value="0">
                    </div></td>
                </tr>
                
                <tr>
                    <td>Freight<br>
                    <div class="full clearfix">
                        <input type="number" class="inputclass" id="SellsFreight" onkeyup="Freightonkeyup()" value="0">
                    </div></td>
                </tr>
                <tr>
                    <td>Discount<br>
                    <div class="full clearfix">
                        <input type="number" class="inputclass" id="SellsDiscount" onkeyup="Discountonkeyup()" value="0">
                    </div></td>
                </tr>
                <tr>
                    <td>Total<br>
                    <div class="full clearfix">
                        <input type="number" id="SellTotaldisabled" value="0" disabled="" class="inputclass">
                        <input type="hidden" id="SellTotals" value="" class="inputclass">
                    </div></td>
                </tr>
                <tr>
                    <td>Paid<br>
                     <div class="full clearfix">
                        <input type="number" id="SellsPaid" class="inputclass" value="0" onkeyup="PaidAmount()" onkeypress="CraditLimit()">
                    </div></td>
                </tr>
                <tr>
                    <td>Due<br>
                    <div class="full clearfix">
                        <input type="number" class="inputclass" value="0" disabled="" id="SellsDue2">
                        <input type="hidden" id="SellsDue" class="inputclass" value="0">
                    </div>
                    <div id="ShowCraditLimitAndDue"></div>
                    </td>
                </tr>
                <tr>
                    <td><input type="button" class="buttonAshiqe" onclick="SalseToCart()" value="Sell" style="width:50px">
                    <input type="button" class="buttonAshiqe" onclick="window.location = '<?php echo base_url(); ?>sales'" value="New Sell"></td>
                </tr>

            </table>
        </fieldset>
    </div>
</div> 
</span>
<script type="text/javascript">
    function keyUPAmount()   {
        var proQTY = $("#proQTY").val();
        var ProRATe = $("#ProRATe").val();
        var Amount = parseFloat(ProRATe)* parseFloat(proQTY);
        $("#ProductAmont").val(Amount);
    }
    function keyupamount2()   {
        var proQTY = $("#proQTY").val();
        var ProRATe = $("#ProRATe").val();
        var Amount = parseFloat(ProRATe)* parseFloat(proQTY);
        $("#ProductAmont").val(Amount);
    }
    function Customer()   {
        var cid = $("#customerID").val();
        var inputdata = 'cid='+cid;
        var urldata = "<?php echo base_url(); ?>Administrator/sales/selectCustomer";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#CustomerResult").html(data);
            }
        });
    }
    function Products()   {
        var ProID = $("#ProID").val();
        var inputdata = 'ProID='+ProID;
        var urldata = "<?php echo base_url(); ?>Administrator/wholesales/SelectProducts";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ProductsResult").html(data);
                var STock = $("#STock").val();
                var unitPro = $("#unitPro").val();
                $("#stockpro").val(STock);
                $("#Prounit").val(unitPro);
                $('input[name=proQTY]').focus();
            }
        });
        
    }
</script>
<script type="text/javascript">
    function ADDTOCART(){
        var ProID = $('#ProID').val();
        if(ProID==0){
            alert('Select Product');
            return false;
        }
        var proName = $('#proName').val();
        var packaNaMe = $('#packaNaMe').val();
        var proQTY = $('#proQTY').val();
        var packnames = document.getElementsByName('sqty[]');
        var getlenth =  packnames.length;
        var itemname = document.getElementsByName('itemname[]');
        var itemlength =  itemname.length;
        var allname = document.getElementsByName('allname[]');
        var namelength =  allname.length;       
       
       
            for(f=1; f <= namelength; f++){
                var allname = "#allname"+f;
                var AllName = $(allname).val();
                var allqty = "#allqty"+f;
                var AllQty = $(allqty).val();
                for(j=1; j <= itemlength; j++){
                    var itemname = "#itemname"+j;
                    var itemName = $(itemname).val();
                    if(itemName != AllName){
                        var StQTs = $('#stockpro').val();
                        var totalQtY = parseFloat(AllQty) + parseFloat(proQTY);
                        if(totalQtY > StQTs){
                            alert("Stock Not Available");
                            return false;
                        }   
                    }
                }
            }
        

        for(i =1; i <= getlenth; i++){
            var getid = "#sqty"+i;
            var sNaMe = "#sNaMe"+i;
            var getName = $(sNaMe).val();
            var getdat = $(getid).val();
            var StQTY = $('#stockpro').val();
            
            //=============================
            if(getName == packaNaMe){
                var totalqty = parseFloat(StQTY) - parseFloat(getdat);
                if(parseFloat(totalqty) < parseFloat(proQTY)){
                    alert("Stock Not Available");
                    return false;
                }else{
                    //var totalqty = parseFloat(StQTY) - parseFloat(proQTY);
                    //alert(totalqty) ;//
                }  
            }
            /*for(f=1; f <= namelength; f++){
                var allname = "#allname"+f;
                var AllName = $(allname).val();
                var allqty = "#allqty"+f;
                var AllQty = $(allqty).val();
                for(j=1; j <= itemlength; j++){
                    var itemname = "#itemname"+j;
                    var itemName = $(itemname).val();
                    if(itemName != AllName){
                        var totalQtY = parseFloat(AllQty) + parseFloat(proQTY);
                        alert(totalQtY);    
                    }
                }
            }*/
        }
                
        if(proQTY == 0){
            $('#proQTY').css("border-color","red");
            return false;
        }else{
            $('#proQTY').css("border-color","green");
        }

        var ProRATe = $('#ProRATe').val();
        var ProPurchaseRATe = $('#ProPurchaseRATe').val();

        var unit = $('#Prounit').val();
        var stockpro = $('#stockpro').val();
        var qty = $('#ckqty').val();
        var packagename = $("#packagename").val();
        var checkname = $("#checkname").val();
        
        if(parseFloat(proQTY) > parseFloat(stockpro)){
            alert("Stock Not Available");
            return false;
        }
        
        var packagecode = $("#packagecode").val();
        var inputdata = 'packagecode='+packagecode+'&packagename='+packagename+'&ProID='+ProID+'&proName='+proName+'&proQTY='+proQTY+'&ProRATe='+ProRATe+'&unit='+unit+'&ProPurchaseRATe='+ProPurchaseRATe;
        var urldata = "<?php echo base_url(); ?>addcart/SalesTOcart";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#Salescartlist").html(data); 
                $('#ProID').val('');
                $('#proName').val('');
                $('#ProRATe').val('');
                $('#Prounit').val('');
                $('#proQTY').val('');
                $('#stockpro').val('0');
                $('#ProductAmont').val('');
                //
                var TotalPrice = parseFloat(ProRATe)*parseFloat(proQTY);
                var subToTal = $("#subTotalDisabled").val();
                var TotalAmount = parseFloat(TotalPrice)+parseFloat(subToTal);
                var grTotal = $("#subTotalDisabled").val(TotalAmount);
                $("#subTotal").val(TotalAmount);
                //
                var subTotal = $("#subTotal").val();
                var vatPersent = $("#vatPersent").val();
                var vattotal = parseFloat(subTotal) * parseFloat(vatPersent);
                var grtotal = parseFloat(vattotal) / 100;
                $('#SellVat').val(grtotal);
                $('#SellVat2').val(grtotal);
                //
                var SellVat = $("#SellVat").val();
                var SellsFreight = $("#SellsFreight").val();
                var SellsDiscount = $("#SellsDiscount").val();
                var totalAmOuNT = parseFloat(TotalAmount)+ parseFloat(SellVat)+ parseFloat(SellsFreight)+parseFloat(SellsDiscount);
                $('#SellTotals').val(totalAmOuNT);
                $('#SellTotaldisabled').val(totalAmOuNT);
                $('#SellsPaid').val(totalAmOuNT);
                //due
                var total = $("#SellTotaldisabled").val();
                var SellsPaid = $("#SellsPaid").val();
                var SellsDue = $("#SellsDue").val();
                var totalDUE = parseFloat(total)- parseFloat(SellsPaid);
                $('#SellsDue').val(totalDUE);
                $('#SellsDue2').val(totalDUE);
            }
        });
        
       
    }
    function cartRemove(aid)   {
        var rowid = $("#rowid"+aid).val();
        var RemoveID = $("#PriCe_"+aid).val();

        var inputdata = 'rowid='+rowid;
        var urldata = "<?php echo base_url(); ?>Administrator/addcart/ajax_salsecart_remove/";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#Salescartlist").html(data);
            }
        });
        var subToTal = $("#subTotal").val();
        var rastAmount = parseFloat(subToTal)-parseFloat(RemoveID); 
        $("#subTotalDisabled").val(rastAmount);
        $("#subTotal").val(rastAmount);
        //
        var subTotal = $("#subTotal").val();
        var vatPersent = $("#vatPersent").val();
        var vattotal = parseFloat(subTotal) * parseFloat(vatPersent);
        var grtotal = parseFloat(vattotal) / 100;
        $('#SellVat').val(grtotal);
        $('#SellVat2').val(grtotal);
        //
        var SellVat = $("#SellVat").val();
        var SellsFreight = $("#SellsFreight").val();
        var SellsDiscount = $("#SellsDiscount").val();
        var totalAmOuNT = parseFloat(subTotal)+ parseFloat(SellVat)+ parseFloat(SellsFreight)-parseFloat(SellsDiscount);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //due
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total)- parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);
    }
    function vatonkeyup(){
        var subtotal = $("#subTotal").val();
        var vatPersent = $("#vatPersent").val();
        var vattotal = parseFloat(subtotal) * parseFloat(vatPersent);
        var grtotal = parseFloat(vattotal) / 100;
        $('#SellVat').val(grtotal);
        $('#SellVat2').val(grtotal);
        //
        var SellVat = $("#SellVat").val();
        var SellsFreight = $("#SellsFreight").val();
        var SellsDiscount = $("#SellsDiscount").val();
        var totalAmOuNT = parseFloat(subtotal)+ parseFloat(SellVat)+ parseFloat(SellsFreight)-parseFloat(SellsDiscount);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //due
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total)- parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);
    }
    function Freightonkeyup(){
        var subtotal = $("#subTotal").val();
        var SellVat = $("#SellVat").val();
        var SellsFreight = $("#SellsFreight").val();
        var SellsDiscount = $("#SellsDiscount").val();
        var totalAmOuNT = parseFloat(subtotal)+ parseFloat(SellVat)+ parseFloat(SellsFreight)-parseFloat(SellsDiscount);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //due
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total)- parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);

    }
    function Discountonkeyup(){
        var subtotal = $("#subTotal").val();
        var SellVat = $("#SellVat").val();
        var SellsFreight = $("#SellsFreight").val();
        var SellsDiscount = $("#SellsDiscount").val();
        var totalAmOuNT = parseFloat(subtotal)+ parseFloat(SellVat)+ parseFloat(SellsFreight)-parseFloat(SellsDiscount);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //due
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total)- parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);
    }
    function PaidAmount(){
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total)- parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);
       
    }
</script>
<script type="text/javascript">
    function SalseToCart(){
        var packagename = $("#packagename").val();
        var salesInvoiceno = $("#salesInvoiceno").val();
        var sales_date = $("#sales_date").val();
        var customerID = $("#customerID").val();
        if(customerID==""){
            alert("Select Customer");
            return false;
        }
        var SelesNotes = $("#SelesNotes").val();

        var subTotal = $("#subTotal").val();
        if(subTotal=="0"){
            $("#subTotal").css("border-color","red");
            return false;
        }else{
            $("#subTotal").css("border-color","gray");
        }
        var vatPersent = $("#vatPersent").val();
        if(vatPersent==""){
            $("#vatPersent").css("border-color","red");
            return false;
        }else{
            $("#vatPersent").css("border-color","gray");
        }
        var SellsFreight = $("#SellsFreight").val();
        if(SellsFreight==""){
            $("#SellsFreight").css("border-color","red");
            return false;
        }else{
            $("#SellsFreight").css("border-color","gray");
        }
        var SellsDiscount = $("#SellsDiscount").val();
        if(SellsDiscount==""){
            $("#SellsDiscount").css("border-color","red");
            return false;
        }else{
            $("#SellsDiscount").css("border-color","gray");
        }
        var SellTotals = $("#SellTotals").val();
        var SellsPaid = $("#SellsPaid").val();
        var regex = /^[0-9]+$/;
        if(!regex.test(SellsPaid)){
            $("#SellsPaid").css('border-color','red');
            return false;
        }else{
            $("#SellsPaid").css('border-color','gray');
        }
        var SellsDue = $("#SellsDue").val();

        var customerdue = $("#customerdue").val();
        var craditlimits = $("#craditlimits").val();
        var totaldue = parseFloat(SellsDue)+parseFloat(customerdue);
        if(craditlimits < totaldue){
            alert('Cradit Limit');
            return false;
        }
        var inputdata = 'packagename='+packagename+'&salesInvoiceno='+salesInvoiceno+'&sales_date='+sales_date+'&customerID='+customerID+'&SelesNotes='+SelesNotes+'&subTotal='+subTotal+'&vatPersent='+vatPersent+'&SellsFreight='+SellsFreight+'&SellsDiscount='+SellsDiscount+'&SellTotals='+SellTotals+'&SellsPaid='+SellsPaid+'&SellsDue='+SellsDue;
        var urldata = "<?php echo base_url(); ?>Administrator/wholesales/sales_order/";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){

                var err = data;
                if(err){
                    if(confirm('Show Report')){
                        window.location.href='<?php echo base_url(); ?>Administrator/sales/sellAndPrint';
                    }else{
                        $("#SalescartRefresh").html(data);
                        alert('Sell Success');
                        return false;
                    }
                }
            }
        });
    }
    function CraditLimit(){
        var custID = $("#customerID").val();
        var inputdata = 'custID='+custID;
        var urldata = "<?php echo base_url(); ?>Administrator/sales/craditlimit/";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ShowCraditLimitAndDue").html(data);
            }
        });
    }
</script>
