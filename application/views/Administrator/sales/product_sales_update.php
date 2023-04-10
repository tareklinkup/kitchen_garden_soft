<div class="row">
    <div class="col-xs-12 col-md-12 col-lg-12" style="border-bottom:1px #ccc solid;margin-bottom:5px;">
        <div class="row">
            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right" for="salesInvoiceno"> Invoice no </label>
                <div class="col-sm-2">
                    <input type="text" id="salesInvoiceno" name="salesInvoiceno"
                           value="<?php echo $sm_cus->SaleMaster_InvoiceNo; ?>" class="form-control" readonly/>

                    <input type="hidden" name="SaleMaster_SlNo" id="SaleMaster_SlNo"
                           value=" <?php echo $sm_cus->SaleMaster_SlNo; ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right" for="salesby"> Sales By </label>
                <div class="col-sm-2">
                    <input type="text" id="salesby" name="salesby"
                           value="<?php echo $this->session->userdata("FullName"); ?>" class="form-control" readonly/>
                    <input type="hidden" class="" value="<?php echo $this->session->userdata("FullName"); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-1 control-label no-padding-right" for="SalesFrom"> Sales From </label>
                <div class="col-sm-2">

                    <select class="chosen-select form-control" name="SalesFrom" id="SalesFrom">
                        <?php $brName = $this->db->where('brunch_id', $sm_cus->SaleMaster_branchid)->get('tbl_brunch')->row(); ?>
                        <option value="<?php echo $brName->brunch_id; ?>"><?php echo $brName->Brunch_name; ?></option>
                    </select>


                </div>
            </div>

            <div class="form-group">
                <!--<label class="col-sm-1 control-label no-padding-right" for="Purchase_date"> Date </label>-->
                <div class="col-sm-3">
                    <input class="form-control date-picker" id="sales_date" name="sales_date" type="text"
                           value="<?php echo $sm_cus->SaleMaster_SaleDate; ?>" name="pdate" type="text"
                           data-date-format="yyyy-mm-dd"
                           style="border-radius: 5px 0px 0px 5px !important;padding: 4px 6px 4px !important;width: 230px;float:left;"/>
                    <span class="input-group-addon"
                          style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
                    <i class="fa fa-calendar bigger-110"></i>
                </span>
                </div>
            </div>
        </div>
    </div>


    <div class="col-xs-9 col-md-9 col-lg-9">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Honorable Buyer & Product Information</h4>
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
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right" for="customerID"> Buyer ID </label>
                                <div class="col-sm-8">
                                    <?php
//                                    $row1 = $this->db->where('Customer_Type', 'G')->get('tbl_customer')->row();
//                                    $row2 = $this->db->where('Customer_brunchid', $this->sbrunch)->where('Customer_Type', 'Local')->where('status', 'a')->order_by('Customer_Name', 'asc')->get('tbl_customer')->result();
                                    /*This query for get customer name and code*/
                                    $customer = $this->db->where('Customer_SlNo', $sm_cus->Customer_SlNo)->get('tbl_customer')->row();
                                    ?>
                                    <!--Hidden Customer Id -->
                                    <input
                                            type="hidden"
                                            id="customerID"
                                            value="<?=  $sm_cus->Customer_SlNo; ?>"
                                    >
                                    <!--For display customer name and code-->
                                    <input
                                            type="text"
                                            class="form-control"
                                            readonly
                                            value="<?= $customer->Customer_Name . ' - ' . $customer->Customer_Code ?>"
                                    >

                                    <!--This commented code for select customer -->
<!--                                    <select class="chosen-select form-control" name="customerID" id="customerID"-->
<!--                                            onchange="Customer()">-->
<!---->
<!--                                        <option value="--><?php //if ($row1) {
//                                            echo $row1->Customer_SlNo;
//                                        } ?><!--"> --><?php //if ($row1) {
//                                                echo $row1->Customer_Name;
//                                            } ?><!-- </option>-->
<!--                                        --><?php //foreach ($row2 as $supplier) { ?>
<!--                                            <option-->
<!--                                                    value="--><?php //echo $supplier->Customer_SlNo; ?><!--"-->
<!--                                                --><?//= ($sm_cus->Customer_SlNo == $supplier->Customer_SlNo) ? 'selected' : false ?>
<!--                                            >-->
<!--                                                --><?php //echo $supplier->Customer_Name; ?>
<!--                                                - --><?php //echo $supplier->Customer_Code; ?>
<!--                                            </option>-->
<!---->
<!--                                        --><?php //} ?>
<!--                                    </select>-->
                                </div>
                            </div>

                            <span id="CustomerResult">
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right" for="supName"> Name </label>
                        <div class="col-sm-8">
                            <input type="text" id="CusName" name="CusName" placeholder="Customer Name"
                                   value="<?php echo $sm_cus->Customer_Name; ?>" class="form-control" readonly/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right" for="Mobile"> Mobile No </label>
                        <div class="col-sm-8">
                            <input type="text" id="CusMobile" name="CusMobile" placeholder="Mobile No"
                                   value="<?php echo $sm_cus->Customer_Mobile; ?>" class="form-control" readonly/>
                        </div>
                    </div>
                    
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-4 control-label no-padding-right" for="Mobile"> E-mail </label>
                        <div class="col-sm-8">
                            <input type="text" id="email" name="email" placeholder="E-mail" class="form-control"
                                   readonly/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-4 control-label no-padding-right" for="supaddress"> Address </label>
                        <div class="col-sm-8">
                            <textarea id="CusAddress" name="CusAddress" placeholder="Address" class="form-control"
                                      readonly><?php echo $sm_cus->Customer_Address; ?></textarea>
                        </div>
                    </div>
                    </span>
                        </div>

                        <div class="col-sm-5">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="patient_id"> Pro.
                                    ID </label>
                                <div class="col-sm-9">

                                    <select class="chosen-select form-control" name="ProID" id="ProID"
                                            data-placeholder="Choose a Product..." onchange="Products()">
                                        <option value=""></option>

                                        <?php foreach ($products as $product) { ?>
                                            <option value="<?php echo $product->Product_SlNo; ?>"><?php echo $product->Product_Name; ?>
                                                - <?php echo $product->Product_Code; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <span id="ProductsResult">
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="productName"> P. Name </label>
                        <div class="col-sm-9">
                            <input type="text" id="productName" name="productName" placeholder="Product Name"
                                   class="form-control"/>
                        </div>
                    </div>
                    
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label no-padding-right" for="productName"> Brand </label>
                        <div class="col-sm-9">
                            <input type="text" id="proBrand" name="proBrand" placeholder="Group" class="form-control"/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="PurchaseQTY"> Quantity </label>
                        <div class="col-sm-3">
                            <input type="number" id="PurchaseQTY" name="PurchaseQTY" placeholder="Qty"
                                   class="form-control"/>
                        </div>
                        <label class="col-sm-3 control-label no-padding-right" for="bodyRate"> Sale Rate </label>
                        <div class="col-sm-3">
                            <input type="number" id="PurchaseQTY" name="PurchaseQTY" placeholder="Rate"
                                   class="form-control"/>
                        </div>
                    </div>
                    
                    <div class="form-group" style="display: none;">
                        <label class="col-sm-3 control-label no-padding-right" for="saleIn"> Sale In % </label>
                        <div class="col-sm-3">
                            <input type="text" id="saleIn" name="saleIn" placeholder="Sale In" class="form-control"/>
                        </div>
                        <label class="col-sm-3 control-label no-padding-right" for="PurchaseQTY"> Body Price </label>
                        <div class="col-sm-3">
                            <input type="number" id="bodyRate" name="bodyRate" placeholder="Rate" class="form-control"/>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label no-padding-right" for="ProductRATE"> Amount </label>
                        <div class="col-sm-9">
                            <input type="text" id="ProductRATE" name="ProductRATE" placeholder="Amount"
                                   class="form-control" readonly/>
                        </div>
                    </div>
                    </span>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right"> </label>
                                <div class="col-sm-9">
                                    <button class="btn btn-default pull-right" onclick="ADDTOCART()">Add Cart</button>
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-2">
                            <span id="Available" style="color:red"></span>
                            <span id="Availabl" style="color:green"></span>

                            <input type="text" id="stockpro" readonly
                                   style="border:none;font-size:20px;width:100%;text-align:center;color:green"><br>
                            <input type="text" id="Prounit" readonly style="border:none;font-size:12px;width:100%;">
                            <br>
                            <span id="show_price" style="display: none;">
                        <input type="text" id="purc_rate" readonly
                               style="border:none;font-size:20px;width:100%;text-align:center;color:green">Tk
                        </span>
                            <input type="button" class="btn btn-info btn-xs" style="" value="Ave Purchase Price"
                                   id="addCart" onclick="purc_rate()">
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xs-12 col-md-12 col-lg-12" style="padding-left: 0px;padding-right: 0px;">
            <div class="table-responsive">
                <!--                <table class="table table-bordered" cellspacing="0" cellpadding="0"-->
                <!--                       style="color:#000;margin-bottom: 5px;">-->
                <!--                    <thead>-->
                <!--                    <tr class="">-->
                <!--                        <th style="width:10%;color:#000;">SL NO</th>-->
                <!--                        <th style="width:15%;color:#000;">Brand</th> -->
                <!--                        <th style="width:10%;color:#000;">Category</th>-->
                <!--                        <th style="width:20%;color:#000;">Product Name</th>-->
                <!--                         <th style="width:10%;color:#000;">Unit</th>-->
                <!--                        <th style="width:7%;color:#000;">Qty</th>-->
                <!--                        <th style="width:8%;color:#000;">Rate</th>-->
                <!--                        <th style="width:8%;color:#000;">Discount</th>-->
                <!--                        <th style="width:15%;color:#000;">Total Amount</th>-->
                <!--                        <th style="width:15%;color:#000;">Action</th>-->
                <!--                    </tr>-->
                <!--                    </thead>-->
                <!--                    --><?php //$i = 1;
                //                    if ($product_mas_det): ?>
                <!--                    <tbody>-->
                <!--                    --><?php //foreach ($product_mas_det as $product_mas_det):
                //                        if ($product_mas_det->Status != 'd'):
                //                            ?>
                <!--                            <form method="post" action="-->
                <?php //echo base_url(); ?><!--productDelete">-->
                <!--                                <tr>-->
                <!--                                    <td style="width:2%">-->
                <!--                                        --><?php //echo $i++ ?>
                <!--                                    </td>-->
                <!---->
                <!--                                    <td style="width:20%">--><?php
                //                                        $cat = $this->db->where('ProductCategory_SlNo', $product_mas_det->ProductCategory_ID)->get('tbl_productcategory')->row();
                //                                        echo $cat->ProductCategory_Name; ?><!--</td>-->
                <!--                                    <td style="width:10%">-->
                <?php //echo $product_mas_det->Product_Name; ?><!--</td>-->
                <!--                                    <td style="width:10%">-->
                <?php //echo $product_mas_det->SaleDetails_TotalQuantity; ?><!--</td>-->
                <!--                                    <td style="width:10%">-->
                <?php //echo $product_mas_det->SaleDetails_Rate; ?><!--</td>-->
                <!--                                    <td style="width:10%">-->
                <?php //echo $product_mas_det->Discount_amount; ?><!--</td>-->
                <!--                                    <td style="width:10%">--><?php //echo $product_mas_det->SaleDetails_Rate * $product_mas_det->SaleDetails_TotalQuantity; ?>
                <!--                                        <input type="hidden" name="" id="PriCe_-->
                <?php ////echo $item['rowid'];
                //                                        ?><!--" value="--><?php ////echo $item['subtotal'];
                //                                        ?><!--"></td>-->

                <!--                                    <input type="hidden" name="SaleMaster_InvoiceNo" id="SaleMaster_InvoiceNo"-->
                <!--                                           value="-->
                <?php //echo $sm_cus->SaleMaster_InvoiceNo; ?><!--"></td>-->

                <!--                                    <input type="hidden" name="SaleDetails_SlNo" id="SaleDetails_SlNo"-->
                <!--                                           value="-->
                <?php //echo $product_mas_det->SaleDetails_SlNo; ?><!--"></td>-->


<!--                </td>-->

                <!--                                    <input type="hidden" name="SaleDetails_TotalQuantity" id="SaleDetails_TotalQuantity"-->
                <!--                                           value="-->
                <?php //echo $product_mas_det->SaleDetails_TotalQuantity; ?><!--"></td>-->

                <!--                                    <input type="hidden" name="SaleDetailsPrice" id="SaleDetailsPrice"-->
                <!--                                           value="-->
                <?php //echo $product_mas_det->SaleDetails_Rate * $product_mas_det->SaleDetails_TotalQuantity; ?><!--"></td>-->
                <!--
                                                        <input type="hidden" name="SaleMaster_TaxAmount" id="SaleMaster_TaxAmount"-->
                <!--                                           value="-->
                <?php //echo $sm_cus->SaleMaster_TaxAmount; ?><!--"></td>-->

                <!--                                    <input type="hidden" name="SaleMaster_TotalSaleAmount"-->
                <!--                                           id="SaleMaster_TotalSaleAmount"-->
                <!--                                           value="-->
                <?php //echo $sm_cus->SaleMaster_TotalSaleAmount; ?><!--"></td>-->

                <!--                                    <input type="hidden" name="Product_IDNo" id="Product_IDNo"-->
                <!--                                           value="-->
                <?php //echo $product_mas_det->Product_IDNo; ?><!--"></td>-->
                <!---->
                <!--                                    <td style="width:10%">-->
                <!--                                        <button type="submit" name="deleteProduct" id="deleteProduct"-->
                <!--                                                onclick="productDelete('-->
                <?php //echo $product_mas_det->SaleDetails_SlNo; ?><!--//')"-->
                <!--//                                                style="color:red;cursor:pointer;"><i class="fa fa-trash-o"-->
                <!--//                                                                                     aria-hidden="true"></i></button>-->
                <!--//                                    </td>-->
                <!--//-->
                <!--//                                </tr>-->
                <!--//                            </form>-->
                <?php //endif; endforeach; ?>
                <!--                    </tbody>-->
                <!--                </table>-->
                <!---->
                <!--                --><?php //endif; ?>


                <span id="Salescartlist">

                    <?php $this->load->view('Administrator/sales/selse_Edit_CArtlist'); ?>

                </span>
            </div>
        </div>
    </div>


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
                                                    <input type="number" id="subTotalDisabled" name="subTotalDisabled"
                                                           value="<?php if ($sm_cus) {
                                                               echo $sm_cus->SaleMaster_TotalSaleAmount;
                                                           } ?>" class="form-control" readonly/>
                                                    <input type="hidden" id="subTotal" class="inputclass"
                                                           value="<?php if ($sm_cus) {
                                                               echo $sm_cus->SaleMaster_TotalSaleAmount;
                                                           } ?>">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"
                                                       for="vatPersent"> Vat </label>
                                                <div class="col-sm-4">
                                                    <input type="number" id="vatPersent" onkeyup="vatonkeyup()"
                                                           name="vatPersent" value="<?php if ($sm_cus) {
                                                        echo $sm_cus->SaleMaster_TaxAmount;
                                                    } ?>" class="form-control"/>
                                                </div>
                                                <label class="col-sm-1 control-label no-padding-right"
                                                       for="SellsDiscount">%</label>
                                                <div class="col-sm-7">
                                                    <input type="number" id="SellVat" readonly="" name="SellVat"
                                                           value="<?php echo ($sm_cus->SaleMaster_TotalSaleAmount / 100) * $sm_cus->SaleMaster_TaxAmount; ?>"
                                                           class="form-control"/>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr style="display:none;">
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"
                                                       for="SellsFreight">Freight</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="SellsFreight" onkeyup="Freightonkeyup()"
                                                           name="SellsFreight" value="0" class="form-control"/>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"
                                                       for="subTotalDisabled">Discount Persent</label>

                                                <div class="col-sm-4">
                                                    <input type="number" id="discPersent" onkeyup="Discountonkeyup()"
                                                           name="discPersent" value="<?php if ($sm_cus) {
                                                        echo $sm_cus->SaleMaster_TotalDiscountAmount;
                                                    } ?>" class="form-control"/>
                                                </div>

                                                <label class="col-sm-1 control-label no-padding-right"
                                                       for="SellsDiscount">%</label>

                                                <div class="col-sm-7">
                                                    <input type="number" id="SellsDiscount" onkeyup="Discountonkeyup2()"
                                                           name="SellsDiscount" value="0" class="form-control"/>
                                                </div>

                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"
                                                       for="Reword_Discount">Round Off</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="Reword_Discount"
                                                           onkeyup="Reword_Discount()" value="<?php if ($sm_cus) {
                                                        echo $sm_cus->SaleMaster_RewordDiscount;
                                                    } ?>" class="form-control"/>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"
                                                       for="SellTotaldisabled">Total</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="SellTotaldisabled"
                                                           value="<?php if ($sm_cus) {
                                                               echo $sm_cus->SaleMaster_SubTotalAmount;
                                                           } ?>" class="form-control" readonly/>
                                                    <input type="hidden" id="SellTotals" value="<?php if ($sm_cus) {
                                                        echo $sm_cus->SaleMaster_SubTotalAmount;
                                                    } ?>" class="inputclass">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right" for="SellsPaid">Paid</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="SellsPaid" value="<?php if ($sm_cus) {
                                                        echo $sm_cus->SaleMaster_PaidAmount;
                                                    } ?>" onkeyup="PaidAmount()" class="form-control"/>
                                                    <label
                                                            class="col-sm-12 control-label no-padding-right"
                                                           for="SellsPaid"
                                                           style="padding-left: 0"
                                                        >
                                                        Prev. Payment
                                                    </label>
                                                    <input
                                                            type="number"
                                                            id="SellsPaid_Old_amount"
                                                           value="<?php if ($sm_cus) {echo $sm_cus->SaleMaster_PaidAmount;} ?>"
                                                            readonly class="form-control"
                                                    />


                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right"
                                                       for="previousDue">Previous Due (Buyer)</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="previousDue" name="previousDue"
                                                           value="<?php echo $dueAmont-$sm_cus->SaleMaster_DueAmount; ?>" class="form-control"
                                                           readonly style="color:red;"/>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <input type="hidden" id="prevDue" name="prevDue" value="<?php echo $dueAmont; ?>"/>

                                    <input type="hidden" name="craditlimits" id="craditlimits"
                                           value="<?php echo $craditlimits; ?>">

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label no-padding-right" for="SellsDue2">Due</label>
                                                <div class="col-sm-12">
                                                    <input type="number" id="SellsDue2" name="SellsDue2"
                                                           value="<?php if ($sm_cus) {
                                                               echo $sm_cus->SaleMaster_DueAmount;
                                                           } ?>" class="form-control" readonly/>
                                                    <input type="hidden" id="SellsDue" class="inputclass"
                                                           value="<?php if ($sm_cus) {
                                                               echo $sm_cus->SaleMaster_DueAmount;
                                                           } ?>">
                                                    <div id="ShowCraditLimitAndDue"></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    <input type="button" class="btn btn-success" onclick="SalseToCart()"
                                                           value="Update" style="color:#fff;margin-top: 0px;">
                                                </div>
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-4">
                                                    <a href="<?php echo base_url(); ?>salesrecord" class="btn btn-info">Back</a>
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

    function keyUPAmount() {
        var proQTY = $("#proQTY").val();
        var ProRATe = $("#ProRATe").val();
        var salePrice = $("#salePrice").val();
        if (salePrice != 0) {
            var ProPurchaseRATe = $("#ProPurchaseRATe").val();
            var Amount = parseFloat(salePrice) * parseFloat(proQTY);
            $("#ProductAmont").val(Amount);
        }
    }

    function keyupamount2() {
        var proQTY = $("#proQTY").val();
        var ProRATe = $("#ProRATe").val();
        //var Cuslastsaleprice = $("#Cuslastsaleprice").val();
        // alert(Cuslastsaleprice);
        // if (Cuslastsaleprice<=ProRATe) {
        //     alert("Sale rate must equal or bigger than last sale price");
        //     return false;
        // }
        var Amount = parseFloat(ProRATe) * parseFloat(proQTY);
        $("#ProductAmont").val(Amount);
    }

    function Customer() {
        var cid = $("#customerID").val();
        var inputdata = 'cid=' + cid;
        var urldata = "<?php echo base_url();?>selectCustomer";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                $("#CustomerResult").html(data);
                var CType = $("#CType").val();
                if (CType == 'G') {
                    $("#SellsPaid").prop('readonly', true);
                } else {
                    $("#SellsPaid").prop('readonly', false);
                }
            }
        });
    }

    function Catagory() {
        var ProCat = $("#ProCat").val();
        var inputdata = 'ProCat=' + ProCat;
        var urldata = "<?php echo base_url();?>SelectCatWiseSaleProduct";
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
        $("#show_price").hide();
        $("#Available").html('');
        $("#Availabl").html('');
        var ProID = $("#ProID").val();
        var SalesFrom = $("#SalesFrom").val();
        if (SalesFrom == '') {
            alert("Select Sales From");
            return false;
        }
        var inputdata = 'ProID=' + ProID + '&SalesFrom=' + SalesFrom;
        var urldata = "<?php echo base_url();?>SelectProducts";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                $("#ProductsResult").html(data);

                // var Cuslastsaleprice = $("#Cuslastsaleprice").val();
                // $("#ProRATe").val(Cuslastsaleprice);

                var STock = $("#STock").val();
                var unitPro = $("#unitPro").val();
                var purc_price = $("#purc_price").val();
                $("#stockpro").val(STock);
                if (STock == '0') {
                    $("#Available").html('Stock Not Available');
                } else {
                    $("#Availabl").html('Stock Available');
                }
                $("#Prounit").val(unitPro);
                $("#purc_rate").val(purc_price);
                $('input[name=proQTY]').focus();
            }
        });

    }
</script>
<script type="text/javascript">


    function ADDTOCART() {
        var ProID = $('#ProID').val();

        if (ProID == 0) {
            alert('Select Product');
            return false;
        }
        var proName = $('#proName').val();
        // var SaleDetails_SlNo = $("input[name='SaleDetails_SlNo']").val();

        var packaNaMe = $('#packaNaMe').val();
        var proQTY = $('#proQTY').val();
        var packnames = document.getElementsByName('sqty[]');
        var getlenth = packnames.length;
        var itemname = document.getElementsByName('itemname[]');
        var itemlength = itemname.length;
        var allname = document.getElementsByName('allname[]');
        var namelength = allname.length;


        for (f = 1; f <= namelength; f++) {
            var allname = "#allname" + f;
            var AllName = $(allname).val();
            var allqty = "#allqty" + f;
            var AllQty = $(allqty).val();
            for (j = 1; j <= itemlength; j++) {
                var itemname = "#itemname" + j;
                var itemName = $(itemname).val();
                if (itemName != AllName) {
                    var StQTs = $('#stockpro').val();
                    var totalQtY = parseFloat(AllQty) + parseFloat(proQTY);
                    if (totalQtY > StQTs) {
                        alert("Stock Not Available");
                        return false;
                    }
                }
            }
        }


        for (i = 1; i <= getlenth; i++) {
            var getid = "#sqty" + i;
            var sNaMe = "#sNaMe" + i;
            var getName = $(sNaMe).val();
            var getdat = $(getid).val();
            var StQTY = $('#stockpro').val();

            //=============================
            if (getName == packaNaMe) {
                var totalqty = parseFloat(StQTY) - parseFloat(getdat);
                if (parseFloat(totalqty) < parseFloat(proQTY)) {
                    alert("Stock Not Available");
                    return false;
                }
            }
        }

        if (proQTY == 0) {
            $('#proQTY').css("border-color", "red");
            return false;
        } else {
            $('#proQTY').css("border-color", "green");
        }

        var ProRATe = parseFloat($('#ProRATe').val());
        var saleIn = parseFloat($('#saleIn').val());
        var salePrice = parseFloat($('#salePrice').val());

        var ProPurchaseRATe = $('#ProPurchaseRATe').val();
        var unit = $('#Prounit').val();
        var stockpro = $('#stockpro').val();
        var qty = $('#ckqty').val();
        var packagename = $("#packagename").val();
        var checkname = $("#checkname").val();


        var minimum = parseFloat($("#purc_price").val());

        if (salePrice < minimum) {
            alert("Sorry it's under minimum price - " + minimum);
            return false;
        }

        if (parseFloat(proQTY) > parseFloat(stockpro)) {
            alert("Stock Not Available");
            return false;
        }
        var proBrand = $('#proBrand').val();
        var body_number = $('#body_number').val();
        //alert(proBrand);
        var pro_discount = $('#pro_discount').val();
        var discount_amount = $('#discount_amount').val();
        var SellsPaid = $('#SellsPaid').val();

        var packagecode = $("#packagecode").val();
        var inputdata = 'packagecode=' + packagecode + '&packagename=' + packagename + '&ProID=' + ProID + '&proName=' + proName + '&proQTY=' + proQTY + '&ProRATe=' + ProRATe + '&unit=' + unit + '&ProPurchaseRATe=' + ProPurchaseRATe + '&proBrand=' + proBrand + '&body_number=' + body_number + '&saleIn=' + saleIn + '&salePrice=' + salePrice + '&pro_discount=' + pro_discount + '&discount_amount=' + discount_amount + '&SellsPaid=' + SellsPaid;
        var urldata = "<?php echo base_url();?>Sales_update_TOcart";
        //alert(inputdata);
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                // console.log(data);
                $("#Salescartlist").html(data);
                $('#ProID').val('');
                $('#pro_discount').val('');
                $('#proName').val('');
                $('#ProRATe').val('');
                $('#Prounit').val('');
                $('#proQTY').val('');
                $('#stockpro').val('0');
                $('#saleIn').val('');
                $('#salePrice').val('');
                $('#ProductAmont').val('');
                $('#ProID').trigger('chosen:updated');
                //
                var TotalPrice = (parseFloat(salePrice) * parseFloat(proQTY)) - discount_amount;
                var subToTal = $("#subTotalDisabled").val();
                var TotalAmount = parseFloat(TotalPrice) + parseFloat(subToTal);
                var grTotal = $("#subTotalDisabled").val(TotalAmount);
                $("#subTotal").val(TotalAmount);
                //
                var subTotal = $("#subTotal").val();
                var vatPersent = $("#vatPersent").val();
                var vattotal = parseFloat(subTotal) * parseFloat(vatPersent);
                var grtotal = parseFloat(vattotal) / 100;
                $('#SellVat').val(grtotal);
                $('#SellVat2').val(grtotal);
                //Reword_Discount
                var SellVat = $("#SellVat").val();
                var SellsFreight = $("#SellsFreight").val();
                var SellsDiscount = $("#SellsDiscount").val();
                var Reword_Discount = $("#Reword_Discount").val();
                var totalAmOuNT = parseFloat(TotalAmount) + parseFloat(SellVat) + parseFloat(SellsFreight) - parseFloat(SellsDiscount) + parseFloat(Reword_Discount);
                $('#SellTotals').val(totalAmOuNT);
                $('#SellTotaldisabled').val(totalAmOuNT);
                $('#SellsPaid').val(totalAmOuNT);
                //due
                var total = $("#SellTotaldisabled").val();
                var SellsPaid = $("#SellsPaid").val();
                var SellsDue = $("#SellsDue").val();
                var totalDUE = parseFloat(total) - parseFloat(SellsPaid);
                $('#SellsDue').val(totalDUE);
                $('#SellsDue2').val(totalDUE);
            }
        });


    }


    function cartRemove(aid) {
        var rowid = $("#rowid" + aid).val();
        var RemoveID = $("#PriCe_" + aid).val();

        var inputdata = 'rowid=' + rowid;
        var urldata = "<?php echo base_url();?>productRemoveUpdate";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                $("#Salescartlist").html(data);
                // location.reload();
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
        $('#SellVat').val(grtotal);
        $('#SellVat2').val(grtotal);
        //Reword_Discount
        var SellVat = $("#SellVat").val();
        var SellsFreight = $("#SellsFreight").val();
        var SellsDiscount = $("#SellsDiscount").val();
        var Reword_Discount = $("#Reword_Discount").val();
        var totalAmOuNT = parseFloat(subTotal) - parseFloat(Reword_Discount) + parseFloat(SellVat) + parseFloat(SellsFreight) - parseFloat(SellsDiscount);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //due
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total) - parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);
    }

    function vatonkeyup() {
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
        var Reword_Discount = $("#Reword_Discount").val();
        var totalAmOuNT = parseFloat(subtotal) - parseFloat(Reword_Discount) + parseFloat(SellVat) + parseFloat(SellsFreight) - parseFloat(SellsDiscount);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //Reword_Discount
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total) - parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);
    }

    function Freightonkeyup() {
        var subtotal = $("#subTotal").val();
        var SellVat = $("#SellVat").val();
        var SellsFreight = $("#SellsFreight").val();
        var SellsDiscount = $("#SellsDiscount").val();
        var Reword_Discount = $("#Reword_Discount").val();
        var totalResult = parseFloat(subtotal) - parseFloat(Reword_Discount) + parseFloat(SellVat) + parseFloat(SellsFreight) - parseFloat(SellsDiscount);
        var totalAmOuNT = parseFloat(totalResult).toFixed(2);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //Reword_Discount
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total) - parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);

    }

    function Discountonkeyup2() {
        var subtotal = $("#subTotal").val();
        var SellVat = $("#SellVat").val();
        var SellsFreight = $("#SellsFreight").val();

        /* var discPersent = $("#discPersent").val();
        var discounttotal = parseFloat(subtotal) * parseFloat(discPersent);
        var grtotal = parseFloat(discounttotal) / 100;
        $('#SellsDiscount').val(grtotal); */
        //$('#SellVat2').val(grtotal);

        var SellsDiscount = $("#SellsDiscount").val();
        var Reword_Discount = $("#Reword_Discount").val();
        var totalResult = parseFloat(subtotal) - parseFloat(Reword_Discount) + parseFloat(SellVat) + parseFloat(SellsFreight) - parseFloat(SellsDiscount);
        var totalAmOuNT = parseFloat(totalResult).toFixed(2);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //Reword_Discount
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total) - parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);
    }

    function Discountonkeyup() {
        var subtotal = $("#subTotal").val();
        var SellVat = $("#SellVat").val();
        var SellsFreight = $("#SellsFreight").val();

        var discPersent = $("#discPersent").val();
        var discounttotal = parseFloat(subtotal) * parseFloat(discPersent);
        var grtotal = parseFloat(discounttotal) / 100;
        $('#SellsDiscount').val(grtotal);
        //$('#SellVat2').val(grtotal);

        var SellsDiscount = $("#SellsDiscount").val();
        var Reword_Discount = $("#Reword_Discount").val();
        var totalResult = parseFloat(subtotal) - parseFloat(Reword_Discount) + parseFloat(SellVat) + parseFloat(SellsFreight) - parseFloat(SellsDiscount);
        var totalAmOuNT = parseFloat(totalResult).toFixed(2);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //Reword_Discount
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total) - parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);
    }

    function Reword_Discount() {
        var subtotal = $("#subTotal").val();
        var SellVat = $("#SellVat").val();
        var SellsFreight = $("#SellsFreight").val();
        var SellsDiscount = $("#SellsDiscount").val();
        var Reword_Discount = $("#Reword_Discount").val();
        var totalResult = parseFloat(subtotal) - parseFloat(Reword_Discount) + parseFloat(SellVat) + parseFloat(SellsFreight) - parseFloat(SellsDiscount);
        var totalAmOuNT = parseFloat(totalResult).toFixed(2);
        $('#SellTotals').val(totalAmOuNT);
        $('#SellTotaldisabled').val(totalAmOuNT);
        $('#SellsPaid').val(totalAmOuNT);
        //Reword_Discount
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total) - parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);
    }

    function PaidAmount() {
        var total = $("#SellTotaldisabled").val();
        var SellsPaid = $("#SellsPaid").val();
        var SellsDue = $("#SellsDue").val();
        var totalDUE = parseFloat(total) - parseFloat(SellsPaid);
        $('#SellsDue').val(totalDUE);
        $('#SellsDue2').val(totalDUE);

    }
</script>
<script type="text/javascript">
    function SalseToCart() {
        var SalesFrom = $("#SalesFrom").val();
        var packagename = $("#packagename").val();
        var salesInvoiceno = $("#salesInvoiceno").val();
        var SaleMaster_SlNo = $("#SaleMaster_SlNo").val();

        var sales_date = $("#sales_date").val();
        var customerID = $("#customerID").val();
        if (customerID == "") {
            //$("#customerID").css("border-color","red");
            alert("Select Customer");
            return false;
        }
        var SelesNotes = $("#SelesNotes").val();

        var subTotal = $("#subTotal").val();
        if (subTotal == "0") {
            $("#subTotal").css("border-color", "red");
            return false;
        } else {
            $("#subTotal").css("border-color", "gray");
        }
        var vatPersent = $("#vatPersent").val();
        if (vatPersent == "") {
            $("#vatPersent").css("border-color", "red");
            return false;
        } else {
            $("#vatPersent").css("border-color", "gray");
        }
        var SellsFreight = $("#SellsFreight").val();
        if (SellsFreight == "") {
            $("#SellsFreight").css("border-color", "red");
            return false;
        } else {
            $("#SellsFreight").css("border-color", "gray");
        }

        var SellsDiscount = $("#SellsDiscount").val();
        if (SellsDiscount == "") {
            $("#SellsDiscount").css("border-color", "red");
            return false;
        } else {
            $("#SellsDiscount").css("border-color", "gray");
        }

        var Reword_Discount = $("#Reword_Discount").val();
        if (Reword_Discount == "") {
            $("#Reword_Discount").css("border-color", "red");
            return false;
        } else {
            $("#Reword_Discount").css("border-color", "gray");
        }
        //Reword_Discount
        var SellTotals = $("#SellTotals").val();
        var SellsPaid = $("#SellsPaid").val();
        var regex = /^[0-9]+$/;
        if (!regex.test(SellsPaid)) {
            $("#SellsPaid").css('border-color', 'red');
            return false;
        } else {
            $("#SellsPaid").css('border-color', 'gray');
        }
        var SellsDue = $("#SellsDue").val();

        var prevDue = $("#prevDue").val();
        var craditlimits = $("#craditlimits").val();
        var totaldue = parseFloat(SellsDue) + parseFloat(prevDue);
        if (craditlimits < totaldue) {
            alert('Cradit Limit');
            return false;
        }
        var C_name = $("#CusName").val();
        var C_Address = $("#CusAddress").val();
        var C_Mobile = $("#CusMobile").val();
        //var CType = $("#CType").val();
        var inputdata = 'SalesFrom=' + SalesFrom + '&packagename=' + packagename + '&SaleMaster_SlNo=' + SaleMaster_SlNo + '&salesInvoiceno=' + salesInvoiceno + '&sales_date=' + sales_date + '&customerID=' + customerID + '&SelesNotes=' + SelesNotes + '&subTotal=' + subTotal + '&vatPersent=' + vatPersent + '&SellsFreight=' + SellsFreight + '&SellsDiscount=' + SellsDiscount + '&SellTotals=' + SellTotals + '&SellsPaid=' + SellsPaid + '&SellsDue=' + SellsDue + '&Reword_Discount=' + Reword_Discount + '&C_name=' + C_name + '&C_Address=' + C_Address + '&C_Mobile=' + C_Mobile;
        var urldata = "<?php echo base_url();?>salesOrderUpdate";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                var err = data;
                if (err) {
                    if (confirm('Show Report')) {
                        window.location.href = '<?php echo base_url();?>sellAndPrint';
                    } else {
                        //$("#SalescartRefresh").html(data);
                        alert('Update Success');
                        location.reload();
                        return false;
                    }
                } else {
                    alert('Stock not available!');
                }
            }
        });
    }

    function CraditLimit() {
        var custID = $("#customerID").val();
        var inputdata = 'custID=' + custID;
        var urldata = "<?php echo base_url();?>craditlimit/";
        $.ajax({
            type: "POST",
            url: urldata,
            data: inputdata,
            success: function (data) {
                $("#ShowCraditLimitAndDue").html(data);
            }
        });
    }
</script>
<script type="text/javascript">
    function purc_rate() {
        var x = document.getElementById("show_price");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }
</script>

<script type="text/javascript">
    function productDelete(id) {
        var deletedd = id;
        var SaleMaster_SlNo = $('#SaleMaster_SlNo').val();
        var SaleDetails_TotalQuantity = $('#SaleDetails_TotalQuantity').val();
        var SaleDetailsPrice = $('#SaleDetailsPrice').val();
        var SaleMaster_TotalSaleAmount = $('#SaleMaster_TotalSaleAmount').val();
        var Product_IDNo = $('#Product_IDNo').val();

        /* alert(SaleMaster_SlNo);
        alert(SaleDetails_TotalQuantity);
        alert(SaleDetailsPrice);
        alert(SaleMaster_TotalSaleAmount);
        alert(Product_IDNo); */

        var inputdata = 'deleted=' + deletedd + '&SaleMaster_SlNo=' + SaleMaster_SlNo + '&SaleDetails_TotalQuantity=' + SaleDetails_TotalQuantity + '&SaleDetailsPrice=' + SaleDetailsPrice + '&SaleMaster_TotalSaleAmount=' + SaleMaster_TotalSaleAmount;
        var x = confirm("Confirm To Delete ?");
        var urldata = "<?php echo base_url();?>Administrator/Sales/product_delete/" + id;
        if (x) {
            $.ajax({
                type: "POST",
                url: urldata,
                data: inputdata,
                success: function (data) {
                    $("#saveResult").html(data);
                    alert("Delete Success");
                }
            });
        }
    }


    function discount_amount() {


        var discount = $("#pro_discount").val();
        var proQTY = $("#proQTY").val();
        var ProRATe = $("#salePrice").val();
        var Amount = parseFloat(ProRATe) * parseFloat(proQTY);
        var sall_price = Amount;
        var discount_amount = 0;

        $('#discount_amount').val(discount_amount);
        if (discount > 0) {
            discount_amount = (Amount * parseInt(discount)) / 100;
            sall_price = Amount - discount_amount;
            $('#discount_amount').val(discount_amount);
        }


        $("#ProductAmont").val(sall_price);
    }

</script>