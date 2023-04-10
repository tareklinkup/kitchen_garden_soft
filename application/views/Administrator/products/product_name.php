<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="productID"> Select Product </label>
    <div class="col-sm-3">
        <select name="" id="productID" data-placeholder="Choose a Product..." class="chosen-select" >
            <option value="All">All</option>
            <?php 
            foreach($allproduct as $product){ ?>
                
            <option value="<?php echo $product->Product_SlNo; ?>"><?php echo $product->Product_Name; ?> -<?php echo $product->Product_Code; ?> </option>
            <?php } ?>
        </select>
    </div>
</div>