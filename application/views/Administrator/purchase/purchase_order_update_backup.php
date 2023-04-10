<div id="AllRefresh">
<div class="content_scroll">
<h2>Product Purchase Update</h2>
    <div style="width:78%; float:left;">
        <div style="border:1px solid #ddd">
            <table width="100%"> 
                <tr>
                    <td>Invoice no</td>
                    <td>
                    <div class="full clearfix">
                        

                        <input type="text"  class="inputclass" readonly="" style="width:200px"  id="purchInvoice" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_InvoiceNo; } ?>">
						<span>PS.No</span>
                        <input type="text"  class="PurchaseMaster_SlNo" readonly="" style="width:50px"  id="PurchaseMaster_SlNo" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_SlNo; } ?>">
                    </div></td>
                    <!-- <td>User</td>
                    <td>
                    <div class="full clearfix">
                        <input type="text" disabled="" class="inputclass" value="<?php //echo $this->session->userdata("FullName"); ?>" style="width:200px">
                        <input type="hidden" id="purchuser" class="inputclass" value="<?php //echo $this->session->userdata("FullName"); ?>" style="width:200px">
                    </div></td> -->
                    <td>Purchase For</td>
                <td>
                <div class="full clearfix">
                    <span id="Search_Results_warehouse">
                    <select id="PurchaseFor" data-placeholder="Purchase For..." style="width:170px;" >
                        <option value="">Select</option>
                    <?php $sql = mysql_query("SELECT * FROM tbl_warehouse");
                        while($row = mysql_fetch_array($sql)){ ?>
                        <option value="<?php echo $row['warehouse_SiNo'] ?>"><?php echo $row['warehouse_name'] ?></option>
                        <?php } ?>                        
                        <!-- <option value="Shop">Shop</option>
                        <option value="Warehouse">Warehouse</option> -->
                    </select>
                    </span>
                    <a class="btn-add fancybox fancybox.ajax" href="<?php echo base_url(); ?>Administrator/products/fanceybox_warehouse">
                        <input type="button" name="country_button" value="+" class="button" style="padding: 4px 8px;font-size: 14px;">
                    </a>
                </div></td>
                    <td>Date</td>
                    <td>
                    <div class="full clearfix" id="ashiqeCalender">
                        <input name="Purchase_date" type="text" id="Purchase_date" value="<?php echo date("Y-m-d") ?>" class="inputclass" style="width:200px"/>
                    </div></td>
                </tr>
            </table>
        </div><br>
        <div style="width:100%; ">
            <table width="100%" > 
                <tr>
                    <td style="border: 1px solid #ddd;"><!-- Customer area -->
                        <table class="purchestable"> 
                            <tr>
                                <td>Supplier ID</td>
                                <td style="width:200px">
                                    <div class="side-by-side clearfix">
                                        <div>
										<select id="SupplierID" data-placeholder="Choose a Supplier..." class="chosen-select" style="width:200px;" tabindex="2">
											<option value="<?php if(isset($pm_sup)){ echo $pm_sup->Supplier_SlNo; } ?>"><?php if(isset($pm_sup)){ echo $pm_sup->Supplier_Name; } ?>  - <?php if(isset($pm_sup)){ echo $pm_sup->Supplier_Mobile; } ?></option>
										</select>
										
                          <!--<select id="SupplierID" data-placeholder="Choose a Supplier..." class="chosen-select" style="width:200px;" tabindex="2" onchange="Supplier()">
                                 <option value=""></option>
                                <?php /* $sql = mysql_query("SELECT * FROM tbl_supplier order by Supplier_Name asc");
                                while($row = mysql_fetch_array($sql)){ */ ?>
                                <option value="<?php //echo $row['Supplier_SlNo'] ?>"><?php //echo $row['Supplier_Name']; ?>  - <?php //echo $row['Supplier_Mobile']; ?></option>
                                <?php //} ?>
                          </select>-->
                                        </div>
                                    </div>
                                </td>
                                <td><span id="SupplierResult">
                                    <table>
                                        <tr>
                                            <td>Name</td>
                                            <td style="width:200px">
                                                <div class="full clearfix">
                                                    <input type="text" class="inputclass" disabled="" value="<?php if(isset($pm_sup)){ echo $pm_sup->Supplier_Name; } ?>">
                                                </div>
                                            </td>
                                            <td>Address</td>
                                            <td style="width:200px">
                                                <div class="full clearfix">
                                                    <input type="text" class="inputclass" disabled="" value="<?php if(isset($pm_sup)){ echo $pm_sup->Supplier_Address; } ?>">
                                                </div>
                                            </td>
                                        </tr>
                                    </table></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="border: 1px solid #ddd;"><!-- Product area -->
                        <table class="purchestable"> 
                            <tr>
                                <td>
                                   <div class="side-by-side clearfix">
                                        <div>
                      <select id="ProCat" data-placeholder="Catagory..." class="chosen-select" style="width:150px;" tabindex="2" onchange="Catagory()">
                             <option value=""></option>
                            <?php $sql = mysql_query("SELECT  * FROM tbl_productcategory ");
                            while($row = mysql_fetch_array($sql)){ 
                                ?>
                            <option value="<?php echo $row['ProductCategory_SlNo'] ?>"><?php echo $row['ProductCategory_Name'] ?></option>
                            <?php } ?>
                      </select>
                                        </div>
                                    </div> 
                                </td>
                        
                                <td style="width:100px" id="ProductResult">
                                    <div class="side-by-side clearfix">
                                        <div>
                      <select id="ProID" data-placeholder="Product..." class="chosen-select" style="width:150px;" tabindex="2" onchange="Products()">
                             <option value=""></option>
                            
                      </select>
                                        </div>
                                    </div>
                                </td>
                        
                                <td id="ProductsResult">
                                    <table>
                                        <tr>
                                            <td> Name </td>
                                                <td style="width:200px">
                                                    <div class="full clearfix" >
                                                        <input type="text" id="productName" disabled="" class="inputclass">
                                                    </div>
                                                </td>
                                                <td> Quantity </td>
                                                <td style="width:100px">
                                                    <div class="full clearfix">
                                                        <input type="number" id="PurchaseQTY" class="inputclass">
                                                    </div>
                                                </td>
                                                <td> Rate </td>
                                                <td style="width:100px">
                                                    <div class="full clearfix">
                                                        <input type="number" id="ProductRATE" class="inputclass">
                                                    </div>
                                                </td>
                                                 <td style="width:80px;padding-left:20px">
                                                    <input class="buttonAshiqe" type="button" onclick="AddToPurchaseCart()" value="Add Cart">
                                                </td>
                                        </tr>
                                    </table>
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
                                <th style="width:20%">Product Name</th>
                                <th style="width:10%">Unit</th>
                                <th style="width:10%">Rate</th>
                                <th style="width:10%">Qty</th>
                                <th style="width:10%">Total Amount</th>
                                <th style="width:10%">Action</th>                                                      
                            </tr>
                        </thead>
                    </table>                    
                </div> 
				<?php
				if(isset($product_purchase_det)){
				?>
				 <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;border-collapse:collapse;">
						<tbody>
						<?php
						foreach($product_purchase_det as $vproduct_purchase_det){
						?>
						<form method="post" action="<?php echo base_url(); ?>Administrator/purchase/product_delete">
							<tr>
								<td style="width:2%" >
									<input type="hidden" id="PriCe_<?php //echo $item['rowid'];?>" value="<?php //echo $item['subtotal'];?>">
									<input type="hidden" name="PurchaseMaster_InvoiceNo" id="PurchaseMaster_InvoiceNo" value="<?php echo $pm_sup->PurchaseMaster_InvoiceNo; ?>">
									<input type="hidden" name="PurchaseMaster_SlNo" id="PurchaseMaster_SlNo" value="<?php echo $pm_sup->PurchaseMaster_SlNo; ?>">
									<input type="hidden" name="PurchaseMaster_TotalAmount" id="PurchaseMaster_TotalAmount" value="<?php echo $pm_sup->PurchaseMaster_TotalAmount; ?>">
									<input type="hidden" name="PurchaseMaster_DiscountAmount" id="PurchaseMaster_DiscountAmount" value="<?php echo $pm_sup->PurchaseMaster_DiscountAmount; ?>">
									<input type="hidden" name="PurchaseMaster_Tax" id="PurchaseMaster_Tax" value="<?php echo $pm_sup->PurchaseMaster_Tax; ?>">
									<input type="hidden" name="PurchaseMaster_Freight" id="PurchaseMaster_Freight" value="<?php echo $pm_sup->PurchaseMaster_Freight; ?>">
									<input type="hidden" name="PurchaseMaster_SubTotalAmount" id="PurchaseMaster_SubTotalAmount" value="<?php echo $pm_sup->PurchaseMaster_SubTotalAmount; ?>">
									<input type="hidden" name="PurchaseMaster_PaidAmount" id="PurchaseMaster_PaidAmount" value="<?php echo $pm_sup->PurchaseMaster_PaidAmount; ?>">
									<input type="hidden" name="PurchaseMaster_DueAmount" id="PurchaseMaster_DueAmount" value="<?php echo $pm_sup->PurchaseMaster_DueAmount; ?>">
									
									<input type="hidden" name="PurchaseDetails_SlNo" id="PurchaseDetails_SlNo" value="<?php echo $vproduct_purchase_det->PurchaseDetails_SlNo; ?>">
									<input type="hidden" name="Product_IDNo" id="Product_IDNo" value="<?php echo $vproduct_purchase_det->Product_IDNo; ?>">
									<input type="hidden" name="PurchaseDetails_TotalQuantity" id="PurchaseDetails_TotalQuantity" value="<?php echo $vproduct_purchase_det->PurchaseDetails_TotalQuantity; ?>">
									<input type="hidden" name="PurchaseDetails_TotalAmount" id="PurchaseDetails_TotalAmount" value="<?php echo $vproduct_purchase_det->PurchaseDetails_TotalQuantity*$vproduct_purchase_det->PurchaseDetails_Rate; ?>">
								</td>
								<td style="width:20%"><?php echo $vproduct_purchase_det->Product_Name; ?></td>
								<td style="width:10%"><?php echo $vproduct_purchase_det->PurchaseDetails_Unit; ?></td>
								<td style="width:10%"><?php echo $vproduct_purchase_det->Product_Purchase_Rate; ?></td>
								<td style="width:10%"><?php echo $vproduct_purchase_det->PurchaseDetails_TotalQuantity; ?></td>
								<td style="width:10%"><?php echo $vproduct_purchase_det->Product_Purchase_Rate*$vproduct_purchase_det->PurchaseDetails_TotalQuantity; ?></td>
								<td style="width:10%">
									<button type="submit" name="deleteProduct" id="deleteProduct" style="color:red;cursor:pointer;"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
								</td>
                              
							  <!--<td style="width:2%"> <input name="proID[]" type="hidden" value="<?php //echo $item['id']; ?>"></td>
                               <td style="width:20%"><?php //echo htmlentities($item['name']); ?> <?php //if(!empty($item['packagename'])){  ?> <input name="cartpackagename" type="hidden" value="<?php //echo $item['packagename']; ?>"> <?php //} ?></td>
                               <td style="width:10%"><?php //echo $item['image']; ?></td>
                               <td style="width:10%" ><?php //echo $vproduct_purchase_det->price; ?></td>
                               <td style="width:10%"><?php //echo $vproduct_purchase_det->qty; ?></td>
                               <td style="width:10%"><?php //$grand_total = $grand_total + $item['subtotal']; ?> <?php //echo number_format($item['subtotal'], 2) ?>
                               <input type="hidden" id="PriCe_<?php //echo $item['rowid'];?>" value="<?php //echo $item['subtotal'];?>"></td>
                               <td style="width:10%">
                                   <span style="cursor:pointer" onclick="cartRemove(a='<?php //echo $item['rowid'];?>')">
                                   <input type="hidden" id="rowid<?php// echo $item['rowid'];?>" value="<?php //echo $item['rowid'];?>">
                                   <img src='<?php //echo base_url();?>images/cart_cross.jpg' width='20px' height='15px'></span>
                               </td>-->
                            </tr>
							</form>
							<?php } ?>
						</tbody>    
                  </table> 
				<?php } ?>
					
            <span id="ShowcarTProduct">
                <div class="clearfix moderntabs" style="width:330px;width:100%;max-height:70px;min-height:70px;overflow:auto;">
						<?php  if ($cart = $this->cart->contents()): ?>
                        <table class="zebra" cellspacing="0" cellpadding="0" border="0" id="" style="text-align:left;width:100%;border-collapse:collapse;">
                            <tbody>
                            <?php
                                //echo form_open('shopping/update_cart');packagecode
                                $grand_total = 0;
                                $count = "";
                                $i = 1;
                                foreach ($cart as $item):
                                    $count++;
                                    echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
                                    echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
                                    echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
                                    echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
                                    echo form_hidden('cart[' . $item['id'] . '][purchaserate]', $item['purchaserate']);
                                    echo form_hidden('cart[' . $item['id'] . '][packagename]', $item['packagename']);
                                    echo form_hidden('cart[' . $item['id'] . '][packagecode]', $item['packagecode']);
                                    echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
                                    echo form_hidden('cart[' . $item['id'] . '][image]', $item['image']); 
                            ?> 
                                <tr>

                                    <td style="width:2%"> <input name="proID[]" type="hidden" value="<?php echo $item['id']; ?>"></td>
                                    <td style="width:20%"><?php echo htmlentities($item['name']); ?> <?php if(!empty($item['packagename'])){  ?> <input name="cartpackagename" type="hidden" value="<?php echo $item['packagename']; ?>"> <?php } ?></td>
                                    <td style="width:10%"><?php echo $item['image']; ?></td>
                                    <td style="width:10%" ><?php echo $item['price']; ?>
                                    </td>
                                    <td style="width:10%"><?php echo $item['qty']; ?></td>
                                    <td style="width:10%"><?php $grand_total = $grand_total + $item['subtotal']; ?> <?php echo number_format($item['subtotal'], 2) ?>
                                    <input type="hidden" id="PriCe_<?php echo $item['rowid'];?>" value="<?php echo $item['subtotal'];?>"></td>
                                    <td style="width:10%">
                                        <span style="cursor:pointer" onclick="cartRemove(a='<?php echo $item['rowid'];?>')">
                                        <input type="hidden" id="rowid<?php echo $item['rowid'];?>" value="<?php echo $item['rowid'];?>">
                                        <img src='<?php echo base_url();?>images/cart_cross.jpg' width='20px' height='15px'></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>    
                        </table> 
                        <?php endif; ?>
                </div>
                <table width="100%">
                    <tr>
                        <td width="40%" >
                            <fieldset style="height:65px">
                                <legend>Notes</legend>
                                <input type="text" name="PurchNotes" id="PurchNotes" style="width:100%;height:50px">
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
                        <input type="number" id="subTotalDisabled" disabled="" class="inputclass" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_TotalAmount; } ?>">
                        <input type="hidden" id="subTotal"  class="inputclass" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_TotalAmount; } ?>">
                    </div></td>
                </tr>
                <tr>
                    <td>Vat<br>
                    <div class="full clearfix">
                        <input type="number" id="vatPersent"  onkeyup="vatonkeyup()" class="inputclass" style="width:50px" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_Tax; } ?>"> % 
                        <input type="number" id="purchVat" readonly="" class="inputclass" style="width:86px" value="<?php echo ($pm_sup->PurchaseMaster_TotalAmount/100)*$pm_sup->PurchaseMaster_Tax; ?>">
                    </div></td>
                </tr>
                
                <tr>
                    <td>Freight<br>
                    <div class="full clearfix">
                        <input type="number" class="inputclass" id="purchFreight" onkeyup="Freightonkeyup()" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_Freight; } ?>">
                    </div></td>
                </tr>
                <tr>
                    <td>Discount<br>
                    <div class="full clearfix">
                        <input type="number" class="inputclass" id="purchDiscount" onkeyup="Discountonkeyup()" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_DiscountAmount; } ?>">
                    </div></td>
                </tr>
                <tr>
                    <td>Total<br>
                    <div class="full clearfix">
                        <input type="number" id="purchTotaldisabled" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_SubTotalAmount; } ?>" disabled="" class="inputclass">
                        <input type="hidden" id="purchTotal" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_SubTotalAmount; } ?>" class="inputclass">
                    </div></td>
                </tr>
                <tr>
                    <td>Paid<br>
                     <div class="full clearfix">
                        <input type="number" id="PurchPaid" class="inputclass" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_PaidAmount; } ?>" onkeyup="PaidAmount()">
                    </div></td>
                </tr>
				 <?php 
				 //$cep = ;
				 if($pm_sup->PurchaseMaster_PaidAmount > $pm_sup->PurchaseMaster_SubTotalAmount){ ?>
				 <tr>
                    <td>Extra Paid<br>
                    <div class="full clearfix">
                        <input type="number" id="extra_paid" class="inputclass" value="<?php echo $pm_sup->PurchaseMaster_PaidAmount - $pm_sup->PurchaseMaster_SubTotalAmount; ?>" disabled="" id="cusExtraPaid">
                        <!--<input type="hidden" id="purchaseDue" class="inputclass" value="0">-->
                    </div></td>
                </tr>
				 <?php } ?>
                <tr>
                    <td>Due<br>
                    <div class="full clearfix">
                        <input type="number" class="inputclass" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_DueAmount; } ?>" disabled="" id="purchaseDue2">
                        <input type="hidden" id="purchaseDue" class="inputclass" value="<?php if(isset($pm_sup)){ echo $pm_sup->PurchaseMaster_DueAmount; } ?>">
                    </div></td>
                </tr>
                <tr>
                    <td><input type="button" class="buttonAshiqe" onclick="ProductPurchase()" value="Update">
                    <input type="button" class="buttonAshiqe" onclick="window.location = '<?php echo base_url();?>Administrator/purchase'" value="New Purchase"></td>
                    </td>
                </tr>
            </table>
        </fieldset>
    </div>
     
</div> 
</div>
<script type="text/javascript">
    function Supplier()   {
        var sid = $("#SupplierID").val();
        var inputdata = 'sid='+sid;
        var urldata = "<?php echo base_url();?>Administrator/purchase/Selectsuplier";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#SupplierResult").html(data);
            }
        });
    }
    function Catagory(){
        var ProCat = $("#ProCat").val();
        var inputdata = 'ProCat='+ProCat;
        var urldata = "<?php echo base_url();?>Administrator/purchase/SelectCat";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ProductResult").html(data);
                
            }
        });
    }
    function Products()   {
        var ProID = $("#ProID").val();
        var inputdata = 'ProID='+ProID;
        var urldata = "<?php echo base_url();?>Administrator/purchase/SelectPruduct";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ProductsResult").html(data);
                $('input[name=PurchaseQTY]').focus();
            }
        });
    }
    function AddToPurchaseCart()   {
        var id = $("#ProID").val();
        if(id == ""){
            //$("#ProID").css("border-color","red")
            alert("Select Product");
            return false;
        }
        var ProCat = $("#ProCat").val();

        var qty = $("#PurchaseQTY").val();
        if(qty == ""){
            $("#PurchaseQTY").css("border-color","red")
            return false;
        }
        var name = $("#productName").val();
        var price = $("#ProductRATE").val();
        var image = $("#ProductUnit").val();

        var packageprice = $("#packageprice").val();
        var packagename = $("#packagename").val();
        var packagecode = $("#packagecode").val();

        var inputdata = 'id='+id+'&ProCat='+ProCat+'&qty='+qty+'&name='+name+'&price='+price+'&image='+image+'&packagename='+packagename+'&packagecode='+packagecode;
        
        var urldata = "<?php echo base_url();?>Administrator/addcart/purchaseTOcart";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ShowcarTProduct").html(data);
                document.getElementById('ProID').value="";
                document.getElementById('PurchaseQTY').value="";
                document.getElementById('productName').value="";
                document.getElementById('ProductRATE').value="";
                document.getElementById('productName2').value="";
            }
        });
        var TotalPrice = parseFloat(price)*parseFloat(qty);
        var subToTal = $("#subTotalDisabled").val();
        var TotalAmount = parseFloat(TotalPrice)+parseFloat(subToTal);
		//alert(TotalAmount);
        var grTotal = $("#subTotalDisabled").val(TotalAmount);
		//alert(grTotal);
        $("#subTotal").val(TotalAmount);
        //
        var subTotal = $("#subTotal").val();
		
        var vatPersent = $("#vatPersent").val();
        var vattotal = parseFloat(subTotal) * parseFloat(vatPersent);
		
        var grtotal = parseFloat(vattotal) / 100;
		
        $('#purchVat').val(grtotal);
        //
        var purchVat = $("#purchVat").val();
		//alert(purchVat);
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        
		var totalAmOuNT = parseFloat(TotalAmount)+ parseFloat(purchVat)+ parseFloat(purchFreight)-parseFloat(purchDiscount);
        //alert(totalAmOuNT);
		$('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);

    }
    function cartRemove(aid)   {
        var rowid = $("#rowid"+aid).val();
        var RemoveID = $("#PriCe_"+aid).val();

        var inputdata = 'rowid='+rowid;
        var urldata = "<?php echo base_url();?>Administrator/addcart/ajax_cart_remove/";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                $("#ShowcarTProduct").html(data);
            }
        });
        //alert(RemoveID);
        var subToTal = $("#subTotal").val();
        var rastAmount = parseFloat(subToTal)-parseFloat(RemoveID); 
        $("#subTotalDisabled").val(rastAmount);
        $("#subTotal").val(rastAmount);
        //
        var subTotal = $("#subTotal").val();
        var vatPersent = $("#vatPersent").val();
        var vattotal = parseFloat(subTotal) * parseFloat(vatPersent);
        var grtotal = parseFloat(vattotal) / 100;
        $('#purchVat').val(grtotal);
        //
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subTotal)+ parseFloat(purchVat)+ parseFloat(purchFreight)-parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
        // Null Value


    }
    function vatonkeyup(){
        var subtotal = $("#subTotal").val();
		//alert(subTotal);
        var vatPersent = $("#vatPersent").val();
        var vattotal = parseFloat(subtotal) * parseFloat(vatPersent);
        var grtotal = parseFloat(vattotal) / 100;
        $('#purchVat').val(grtotal);
        //
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subtotal)+ parseFloat(purchVat)+ parseFloat(purchFreight)-parseFloat(purchDiscount);
        //alert(totalAmOuNT);
		$('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
    }
    function Freightonkeyup(){
        var subtotal = $("#subTotal").val();
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subtotal)+ parseFloat(purchVat)+ parseFloat(purchFreight)-parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);

    }
    function Discountonkeyup(){
        var subtotal = $("#subTotal").val();
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subtotal)+ parseFloat(purchVat)+ parseFloat(purchFreight)-parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
    }
    function PaidAmount(){
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total)- parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
       
    }

</script>
<script type="text/javascript">
    function ProductPurchase(){

        var packagename = $("#packagename").val();
        var PurchaseMaster_SlNo = $("#PurchaseMaster_SlNo").val();
        var purchInvoice = $("#purchInvoice").val();
        var PurchaseFor = $("#PurchaseFor").val();
        if(PurchaseFor === ''){
            alert("Select Purchase For");
            return false;
        }
        var Purchase_date = $("#Purchase_date").val();

        var SupplierID = $("#SupplierID").val();
        if(SupplierID===""){
            alert("Select Supplier");
            return false;
        }
        //
        var subTotal = $("#subTotal").val();
        if(subTotal===0){
            return false;
        }
        var vatPersent = $("#vatPersent").val();
        if(vatPersent===""){
            $("#vatPersent").css('border-color','red');
            return false;
        }else{
            $("#vatPersent").css('border-color','gray');
        }
        var purchFreight = $("#purchFreight").val();
        if(purchFreight===""){
            $("#purchFreight").css('border-color','red');
            return false;
        }else{
            $("#purchFreight").css('border-color','gray');
        }
        var purchDiscount = $("#purchDiscount").val();
        if(purchDiscount===""){
            $("#purchDiscount").css('border-color','red');
            return false;
        }else{
            $("#purchDiscount").css('border-color','gray');
        }
        var purchTotal = $("#purchTotal").val();

        var PurchPaid = $("#PurchPaid").val();
        
        var purchaseDue = $("#purchaseDue").val();
        var Notes = $("#PurchNotes").val();
        var inputdata = 'packagename='+packagename+'&purchInvoice='+purchInvoice+'&PurchaseMaster_SlNo='+PurchaseMaster_SlNo+'&PurchaseFor='+PurchaseFor+'&Purchase_date='+Purchase_date+'&SupplierID='+SupplierID+'&subTotal='+subTotal+'&vatPersent='+vatPersent+'&purchFreight='+purchFreight+'&purchDiscount='+purchDiscount+'&purchTotal='+purchTotal+'&PurchPaid='+PurchPaid+'&purchaseDue='+purchaseDue+'&Notes='+Notes;
        var urldata = "<?php echo base_url();?>Administrator/purchase/Purchase_order_update";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success:function(data){
                var err = data;
                if(err){
                    if(confirm('Show Report')){
                        window.location.href='<?php echo base_url();?>Administrator/purchase/purchase_to_report';
                    }else{
                        //$("#AllRefresh").html(data);
                        alert('Purchase Success');
                        location.reload();
                        return false;
                    }
                }
            }
        });
    }
</script>
