<?php if ($cart = $this->cart->contents()) { ?>
    <table class="table table-bordered" cellspacing="0" cellpadding="0" style="color:#000;margin-bottom: 10px;">
        <tbody>
        <?php
        $grand_total = 0;
        $i = 1;
        foreach ($cart as $item) {
            echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
            echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
            echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
            echo form_hidden('cart[' . $item['id'] . '][proCode]', $item['proCode']);
            echo form_hidden('cart[' . $item['id'] . '][group]', $item['group']);
            echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
            echo form_hidden('cart[' . $item['id'] . '][totalAmount]', $item['totalAmount']);
            echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);

            $pro = $this->db->where('Product_SlNo', $item['id'])->get('tbl_product')->row();
            $category = $this->db->where('ProductCategory_SlNo', $pro->ProductCategory_ID)->get('tbl_productcategory')->row();
            ?>
            <tr>
                <td style="width:4%"><strong style="color:#438EB9;font-size:14px;"><?php echo $i++; ?></strong></td>
                <td style="width:20%"><?php echo $item['name']; ?></td>
                <!-- <td style="width:12%"><?php //echo $item['group'];
                ?></td> -->
                <td style="width:13%"><?php if (isset($category->ProductCategory_Name)): echo $category->ProductCategory_Name; endif; ?></td>
                <td style="width:8%"><?php echo $item['price']; ?></td>
                <td style="width:5%"><?php echo $item['qty']; ?></td>

                <td style="width:13%"><?php $grand_total = $grand_total + $item['subtotal']; ?> <?php echo number_format($item['subtotal'], 2) ?>
                    <input type="hidden" id="PriCe_<?php echo $item['rowid']; ?>"
                           value="<?php echo $item['subtotal']; ?>"></td>
                </td>
                <td style="width:20%">
				<span style="cursor:pointer" onclick="cartRemove(a='<?php echo $item['rowid']; ?>')">
				<input type="hidden" id="rowid<?php echo $item['rowid']; ?>" value="<?php echo $item['rowid']; ?>">
				<i class="fa fa-times" aria-hidden="true" style="color:red;font-size:17px;"></i></span>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>

<table class="table table-bordered" cellspacing="0" cellpadding="0" style="color:#000;margin-bottom: 5px;">
    <tr>
        <td width="40%">Notes</td>
        <td width="60%">Total</td>
    </tr>

    <tr>
        <td width="40%">
            <input type="text" name="PurchNotes" id="PurchNotes" style="width:100%;height:30px">
        </td>
        <td width="60%">
            <input type="hidden" id="grand_total" value="<?php if (isset($grand_total)) {
                echo $grand_total;
            } //echo number_format($grand_total,2); ?>">
            <span style="color:red"><?php if (isset($grand_total)) {
                    echo $grand_total;
                } else {
                    echo 0;
                } ?></span>
            <span>tk</span>
        </td>
    </tr>

    <tr>
        <td colspan="2">
        </td>
    </tr>
</table> 