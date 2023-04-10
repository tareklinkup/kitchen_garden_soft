<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
        <div class="row">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right text-right" for="purchInvoice"> Invoice no </label>
                <div class="col-sm-2">

                    <input
                            type="text"
                            id="purchInvoice"
                            name="purchInvoice"
                            value="<?= $pm_sup->PurchaseMaster_InvoiceNo ?>"
                            class="form-control"
                            readonly
                    />

                    <input
                            type="text"
                            id="PurchaseMaster_SlNo"
                            name="PurchaseMaster_SlNo"
                            value="<?= $pm_sup->PurchaseMaster_SlNo ?>"
                            class="form-control"
                            readonly
                            style="display: none"
                    />
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label no-padding-right text-right" for="PurchaseFor"> Purchase For </label>
                <div class="col-sm-3">

                    <input
                            type="text"
                            class="form-control"
                            value="<?= $pm_sup->PurchaseMaster_PurchaseFor ?>"
                            name="PurchaseFor"
                            id="PurchaseFor"
                            style="display: none;"
                    >
                    <input
                            type="text"
                            class="form-control"
                            readonly
                            value="<?= $this->mt->getBrunchNameById($pm_sup->PurchaseMaster_PurchaseFor) ?>"
                    >

                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right text-right" for="Purchase_date"> Date </label>
                <div class="col-sm-3">
                    <!--name="pdate"-->
                    <input
                            class="form-control date-picker"
                            id="Purchase_date"
                            name="Purchase_date"
                            type="text"
                            readonly
                            value="<?= $pm_sup->PurchaseMaster_OrderDate ?>"
                            data-date-format="yyyy-mm-dd"
                           style="border-radius: 5px 0px 0px 5px !important;padding: 4px 6px 4px !important;width: 230px;float:left;"
                    />
                    <span class="input-group-addon"
                              style="border-radius: 0px 5px 5px 0px !important;padding: 4px 6px 4px !important;">
                        <i class="fa fa-calendar bigger-110"></i>
				    </span>

                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-9 col-md-9 col-lg-9">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Supplier & Product Information</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"> <i class="ace-icon fa fa-chevron-up"></i> </a>
                    <a href="#" data-action="close"> <i class="ace-icon fa fa-times"></i> </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="SupplierID"> Supplier ID </label>
                                <div class="col-sm-8">

                                    <input
                                            type="hidden"
                                            class="form-control"
                                            name="SupplierID"
                                            id="SupplierID"
                                            value="<?= $pm_sup->Supplier_SlNo ?>"
                                    >

                                    <input
                                            type="text"
                                            readonly
                                            class="form-control"
                                            value="<?= $pm_sup->Supplier_Name . ' - ' . $pm_sup->Supplier_Mobile; ?>"
                                    >

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="supName"> Supplier Name </label>
                                <div class="col-sm-8">
                                    <input
                                            type="text"
                                            id="supName"
                                            name="supName"
                                            placeholder="Supplier Name"
                                            class="form-control"
                                            readonly
                                            value="<?= $pm_sup->Supplier_Name ?>"
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="Mobile"> Mobile No </label>
                                <div class="col-sm-8">

                                    <input
                                            type="text"
                                            id="mobile_no"
                                            name="mobile_no"
                                            placeholder="Mobile No"
                                            class="form-control"
                                            readonly
                                            value="<?= $pm_sup->Supplier_Mobile ?>"
                                    />

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="supaddress"> Address </label>
                                <div class="col-sm-8">

                                    <textarea
                                            id="supaddress"
                                            name="supaddress"
                                            placeholder="Address"
                                            class="form-control"
                                            readonly
                                    ><?= $pm_sup->Supplier_Address ?>
                                    </textarea>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="patient_id">
                                    Product </label>
                                <div class="col-sm-8">
                                    <select class="chosen-select form-control" name="ProID" id="ProID"
                                            data-placeholder="Choose a Product..." onchange="Products()">
                                        <option value=""></option>
                                        <?php if (isset($products) && $products):
                                                    foreach ($products as $product): ?>

                                                <option value="<?= $product->Product_SlNo; ?>" >
                                                    <?= $product->Product_Name . ' - ' . $product->Product_Code; ?>
                                                </option>
                                        <?php
                                                    endforeach;
                                                endif;
                                         ?>
                                    </select>
                                </div>
                            </div>

                            <!--Ajax fetch product data start-->
                            <span id="ProductsResult">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="productName"> Product Name </label>
                                <div class="col-sm-8">
                                    <input type="text" id="productName" name="productName" placeholder="Product Name"
                                           class="form-control" readonly/>
                                </div>
                            </div>

                            <div class="form-group" style="display:none;">
                                <label class="col-sm-4 control-label no-padding-right" for="productName"> Group Name</label>
                                <div class="col-sm-8">
                                    <input type="text" id="group" name="group" class="form-control" placeholder="Group name"
                                           readonly/>
                                </div>
                            </div>


                        <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right" for="ProductRATE"> Pur. Rate </label>
                        <div class="col-sm-3">
                            <input type="text" id="PurchaseRate" name="PurchaseRate" value="" class="form-control"
                                   placeholder="Pur. Rate" readonly/>
                        </div>

                        <label class="col-sm-2 control-label no-padding-right" for="PurchaseQTY"> Quantity </label>
                        <div class="col-sm-3">
                            <input type="text" id="PurchaseQTY" name="PurchaseQTY" value="" class="form-control"
                                   placeholder="Quantity" readonly/>
                        </div>
                    </div>

				 <div class="form-group" style="display:none;">
					<label class="col-sm-4 control-label no-padding-right" for="cost"> Cost </label>
					<div class="col-sm-3">
						<input type="text" id="cost" name="cost" value="" class="form-control" placeholder="Cost"
                               readonly/>
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label no-padding-right" for="totalAmount"> Total Amount </label>
					<div class="col-sm-8">
						<input type="text" id="totalAmount" name="totalAmount" value="0" class="form-control" readonly/>
					</div>
				</div>

				</span>
                <!--Ajax fetch product data end-->

                <div class="form-group">
                    <label class="col-sm-4 control-label no-padding-right"> </label>
                    <div class="col-sm-8">
                        <button class="btn btn-default pull-right" onclick="AddToPurchaseCart()">Add Cart
                        </button>
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
    <div class="table-responsive">
        <table class="table table-bordered" cellspacing="0" cellpadding="0"
               style="color:#000;margin-bottom: 5px;">
            <thead>
            <tr class="">
                <th style="width:4%;color:#000;">SL NO</th>
                <th style="width:20%;color:#000;">Product Name</th>
                <th style="width:13%;color:#000;">Category</th>
                <th style="width:8%;color:#000;">Pur. Rate</th>
                <th style="width:5%;color:#000;">Qty</th>
                <th style="width:13%;color:#000;">Total Amount</th>
                <th style="width:5%;color:#000;">Act.</th>
            </tr>
            </thead>
        </table>

        <span id="ShowcarTProduct">
            <?php $this->load->view('Administrator/purchase/update_cartproduct') ?>
        </span>

    </div>
</div>

</div>

<!--Right Sidebar Amount Details Section-->
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Amount Details</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                        <i class="ace-icon fa fa-chevron-up"></i>
                    </a>

                    <a href="#" data-action="close">
                        <i class="ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="" cellspacing="0" cellpadding="0" style="color:#000;margin-bottom: 0px;">

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"
                                                       for="subTotalDisabled">Sub Total</label>
                                                <div class="col-sm-12">

                                                    <input
                                                            type="number"
                                                            id="subTotalDisabled"
                                                            name="subTotalDisabled"
                                                            class="form-control"
                                                            readonly
                                                            value="<?= $pm_sup->PurchaseMaster_TotalAmount ?>"
                                                    />
                                                    <input
                                                            type="hidden"
                                                            id="subTotal"
                                                            class="inputclass"
                                                            value="<?= $pm_sup->PurchaseMaster_TotalAmount ?>"
                                                    />

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"
                                                       for="subTotalDisabled"> Vat
                                                </label>
                                                <div class="col-sm-12">

                                                    <input
                                                            type="number"
                                                            id="vatPersent"
                                                            onkeyup="vatonkeyup()"
                                                            name="vatPersent"
                                                            class=""
                                                            style="width:50px;height:25px;"
                                                            value="<?= $pm_sup->PurchaseMaster_Tax ?>"
                                                    />

                                                    <span style="width:20px;"> % </span>

                                                    <input
                                                            type="number"
                                                            id="purchVat"
                                                            readonly=""
                                                            name="purchVat"
                                                            class=""
                                                            style="width:140px;height:25px;"
                                                            value="<?= ($pm_sup->PurchaseMaster_TotalAmount/100)*$pm_sup->PurchaseMaster_Tax ?>"
                                                    />

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label
                                                        class="col-sm-12 control-label no-padding-right"
                                                       for="subTotalDisabled">Transport / Labour Cost
                                                </label>
                                                <div class="col-sm-12">

                                                    <input
                                                            type="number"
                                                            id="purchFreight"
                                                            onkeyup="Freightonkeyup()"
                                                           name="purchFreight"
                                                            class="form-control"
                                                            value="<?=  $pm_sup->PurchaseMaster_Freight ?>"
                                                    />

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label
                                                        class="col-sm-12 control-label no-padding-right"
                                                       for="subTotalDisabled">Discount
                                                </label>
                                                <div class="col-sm-12">

                                                    <input
                                                            type="number"
                                                            id="purchDiscount"
                                                            onkeyup="Discountonkeyup()"
                                                            name="purchDiscount"
                                                            class="form-control"
                                                            value="<?= $pm_sup->PurchaseMaster_DiscountAmount ?>"
                                                    />

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label
                                                        class="col-sm-12 control-label no-padding-right"
                                                       for="subTotalDisabled">Total
                                                </label>

                                                <div class="col-sm-12">
                                                    <input
                                                            type="number"
                                                            id="purchTotaldisabled"
                                                            class="form-control"
                                                            readonly
                                                            value="<?= $pm_sup->PurchaseMaster_SubTotalAmount ?>"
                                                    />
                                                    <input
                                                            type="hidden"
                                                            id="purchTotal"
                                                            class="inputclass"
                                                            value="<?= $pm_sup->PurchaseMaster_SubTotalAmount ?>"
                                                    />

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label
                                                        class="col-sm-12 control-label no-padding-right"
                                                        for="subTotalDisabled">Paid
                                                </label>
                                                <div class="col-sm-12">

                                                    <input
                                                            type="number"
                                                            id="PurchPaid"
                                                            onkeyup="PaidAmount()"
                                                            class="form-control"
                                                            value="<?= $pm_sup->PurchaseMaster_PaidAmount ?>"
                                                    />
                                                    <!--previous paid amount start-->
                                                    <label
                                                            class="col-sm-12 control-label no-padding-right"
                                                            style="padding-left: 0"
                                                            for="subTotalDisabled">Prev. Payment
                                                    </label>
                                                    <div class="col-sm-12"   style="padding-left: 0">

                                                        <input
                                                                type="number"
                                                                readonly
                                                                class="form-control"
                                                                value="<?= $pm_sup->PurchaseMaster_PaidAmount ?>"
                                                        />
                                                        <!--previous paid amount end-->
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label
                                                        class="col-sm-12 control-label no-padding-right"
                                                       for="previousDue">Previous Due
                                                </label>
                                                <div class="col-sm-12">

                                                    <input
                                                            type="number"
                                                            id="previousDue"
                                                            name="previousDue"
                                                            class="form-control"
                                                            readonly
                                                            style="color:red;"
                                                            value="<?=
                                                            $this->mt->getSupplierDueById($pm_sup->Supplier_SlNo) - $pm_sup->PurchaseMaster_DueAmount
                                                            ?>"
                                                    />

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label
                                                        class="col-sm-12 control-label no-padding-right"
                                                       for="subTotalDisabled">Due
                                                </label>
                                                <div class="col-sm-12">

                                                    <input
                                                            type="number"
                                                            id="purchaseDue2"
                                                            name="purchaseDue2"
                                                            class="form-control"
                                                            readonly
                                                            value="<?= $pm_sup->PurchaseMaster_DueAmount ?>"
                                                    />

                                                    <input
                                                            type="hidden"
                                                            id="purchaseDue"
                                                            class="inputclass"
                                                            value="<?= $pm_sup->PurchaseMaster_DueAmount ?>"
                                                    />

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-sm-4">
                                                    <input
                                                            type="button"
                                                            class="btn btn-success"
                                                           onclick="ProductPurchase()"
                                                            value="Update"
                                                           style="background:#000;color:#fff;">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input
                                                            type="button"
                                                            class="btn btn-info"
                                                           onclick="window.location = '<?php echo base_url(); ?>purchase'"
                                                           value="New Purchase"
                                                            style="background:#000;color:#fff;">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    function Catagory() {
        var ProCat = $("#ProCat").val();
        var inputdata = 'ProCat=' + ProCat;
        var urldata = "<?php echo base_url();?>SelectCat";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                $("#ProductResult").html(data);

            }
        });
    }

    function Products() {
        var ProID = $("#ProID").val();
        var inputdata = 'ProID=' + ProID;
        var urldata = "<?php echo base_url();?>SelectPruduct";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                $("#ProductsResult").html(data);
                $('input[name=PurchaseQTY]').focus();
            }
        });
    }

    function calculatePurchaseRate() {
        var PurchaseQTY = $("#PurchaseQTY").val();
        var perPrRate = parseFloat($("#cost").val());
        var Amount = parseFloat(perPrRate) * parseFloat(PurchaseQTY);
        $("#PurchaseRate").val(perPrRate);
        $("#totalAmount").val(Amount);
    }

    function QuantityUpdate() {
        var PurchaseQTY = $("#PurchaseQTY").val();
        var PurchaseRate = $("#PurchaseRate").val();
        var Amount = parseFloat(PurchaseRate) * parseFloat(PurchaseQTY);
        $("#totalAmount").val(Amount);
    }

    function AddToPurchaseCart() {
        var id = $("#ProID").val();
        if (id == "") {
            alert("Select Product");
            return false;
        }
        var ProCat = $("#ProCat").val();

        var qty = $("#PurchaseQTY").val();

        if (qty == "") {
            $("#PurchaseQTY").css("border-color", "red")
            return false;
        }
        var name = $("#productName").val();
        var price = $("#ProductRATE").val();
        var PurchaseRate = $("#PurchaseRate").val();
        var totalAmount = $("#totalAmount").val();
        var cost = $("#cost").val();

        var proCode = $("#proCode").val();
        var group = $("#group").val();

        var inputdata = 'id=' + id + '&ProCat=' + ProCat + '&qty=' + qty + '&name=' + name + '&price=' + price + '&proCode=+' + proCode + '&group=' + group + '&PurchaseRate=' + PurchaseRate + '&totalAmount=' + totalAmount + '&cost=' + cost;

        var urldata = "<?php echo base_url();?>purchase_update_TOcart";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                $("#ShowcarTProduct").html(data);
                document.getElementById('ProID').value = "";
                $('#ProID').trigger('chosen:updated');
                document.getElementById('PurchaseQTY').value = "";
                document.getElementById('productName').value = "";
                document.getElementById('PurchaseRate').value = "";
                document.getElementById('productName2').value = "";
                document.getElementById('cost').value = "";
                document.getElementById('totalAmount').value = "";
                document.getElementById('group').value = "";
            }
        });
        var PurchaseQTY = $("#PurchaseQTY").val();
        var PurchaseRate = $("#PurchaseRate").val();
        var TotalPrice = parseFloat(PurchaseRate) * parseFloat(PurchaseQTY);

        var subToTal = $("#subTotalDisabled").val();
        var TotalAmount = parseFloat(TotalPrice) + parseFloat(subToTal);
        var grTotal = $("#subTotalDisabled").val(TotalAmount);
        $("#subTotal").val(TotalAmount);
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
        var totalAmOuNT = parseFloat(TotalAmount) + parseFloat(purchVat) + parseFloat(purchFreight) - parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total) - parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);

    }

    function cartRemove(aid) {
        var rowid = $("#rowid" + aid).val();
        var RemoveID = $("#PriCe_" + aid).val();
        var PurchaseMaster_SlNo = $("#PurchaseMaster_SlNo").val();
        var inputdata = 'rowid=' + rowid +'&PurchaseMaster_SlNo='+PurchaseMaster_SlNo;
        var urldata = "<?php echo base_url();?>ajax_purchase_update_CartRemove";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                $("#ShowcarTProduct").html(data);
            }
        });

        var subToTal = $("#subTotal").val();
        var rastAmount = parseFloat(subToTal) - parseFloat(RemoveID);
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
        var totalAmOuNT = parseFloat(subTotal) + parseFloat(purchVat) + parseFloat(purchFreight) - parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total) - parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
        // Null Value


    }

    function vatonkeyup() {
        var subtotal = $("#subTotal").val();
        var vatPersent = $("#vatPersent").val();
        var vattotal = parseFloat(subtotal) * parseFloat(vatPersent);
        var grtotal = parseFloat(vattotal) / 100;
        $('#purchVat').val(grtotal);
        //
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subtotal) + parseFloat(purchVat) + parseFloat(purchFreight) - parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total) - parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
    }

    function Freightonkeyup() {
        var subtotal = $("#subTotal").val();
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subtotal) + parseFloat(purchVat) + parseFloat(purchFreight) - parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total) - parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);

    }

    function Discountonkeyup() {
        var subtotal = $("#subTotal").val();
        var purchVat = $("#purchVat").val();
        var purchFreight = $("#purchFreight").val();
        var purchDiscount = $("#purchDiscount").val();
        var totalAmOuNT = parseFloat(subtotal) + parseFloat(purchVat) + parseFloat(purchFreight) - parseFloat(purchDiscount);
        $('#purchTotal').val(totalAmOuNT);
        $('#purchTotaldisabled').val(totalAmOuNT);
        $('#PurchPaid').val(totalAmOuNT);
        //due
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total) - parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);
    }

    function PaidAmount() {
        var total = $("#purchTotaldisabled").val();
        var PurchPaid = $("#PurchPaid").val();
        var purchaseDue = $("#purchaseDue").val();
        var totalDUE = parseFloat(total) - parseFloat(PurchPaid);
        $('#purchaseDue').val(totalDUE);
        $('#purchaseDue2').val(totalDUE);

    }

    function ProductPurchase() {

        var packagename = $("#packagename").val();
        var purchInvoice = $("#purchInvoice").val();
        var PurchaseFor = $("#PurchaseFor").val();
        if (PurchaseFor == '') {
            alert("Select Purchase For");
            return false;
        }
        var Purchase_date = $("#Purchase_date").val();

        var SupplierID = $("#SupplierID").val();
        if (SupplierID == "") {
            alert("Select Supplier");
            return false;
        }
        //
        var subTotal = $("#subTotal").val();
        if (subTotal == 0) {
            return false;
        }
        var vatPersent = $("#vatPersent").val();
        if (vatPersent == "") {
            $("#vatPersent").css('border-color', 'red');
            return false;
        } else {
            $("#vatPersent").css('border-color', 'gray');
        }
        var purchFreight = $("#purchFreight").val();
        if (purchFreight == "") {
            $("#purchFreight").css('border-color', 'red');
            return false;
        } else {
            $("#purchFreight").css('border-color', 'gray');
        }
        var purchDiscount = $("#purchDiscount").val();
        if (purchDiscount == "") {
            $("#purchDiscount").css('border-color', 'red');
            return false;
        } else {
            $("#purchDiscount").css('border-color', 'gray');
        }
        var purchTotal = $("#purchTotal").val();

        var PurchPaid = $("#PurchPaid").val();

        var purchaseDue = $("#purchaseDue").val();
        var Notes = $("#PurchNotes").val();

        var SType = $("#SType").val();
        var supName = $("#supName").val();
        var supaddress = $("#supaddress").val();
        var mobile_no = $("#mobile_no").val();
        var PurchaseMaster_SlNo = $("#PurchaseMaster_SlNo").val();
        var inputdata = 'PurchaseMaster_SlNo=' + PurchaseMaster_SlNo +'&packagename=' + packagename + '&purchInvoice=' + purchInvoice + '&PurchaseFor=' + PurchaseFor + '&Purchase_date=' + Purchase_date + '&SupplierID=' + SupplierID + '&subTotal=' + subTotal + '&vatPersent=' + vatPersent + '&purchFreight=' + purchFreight + '&purchDiscount=' + purchDiscount + '&purchTotal=' + purchTotal + '&PurchPaid=' + PurchPaid + '&purchaseDue=' + purchaseDue + '&SType=' + SType + '&supName=' + supName + '&supaddress=' + supaddress + '&mobile_no=' + mobile_no + '&Notes=' + Notes;
        var urldata = "<?php echo base_url();?>Administrator/purchase/Purchase_order_update";

        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                var err = data;
                if (err) {
                    if (confirm('Show Report')) {
                        window.location.href = '<?php echo base_url();?>purchaseToReport';
                    } else {
                        alert('Update Success');
                        location.reload();
                        return false;
                    }
                }
            }
        });
    }
</script>

<script>
    document.addEventListener('keydown', function (event) {
        if (event.keyCode == 13 || event.keyCode == 17 || event.keyCode == 74)
            event.preventDefault();
    });
</script>
