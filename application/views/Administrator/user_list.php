<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="adminId"> Select User </label>
    <div class="col-sm-3">
        <select name="" id="adminId" data-placeholder="Choose a User..." class="chosen-select" >
            <option value="">  </option>
            <?php 
            foreach($allUser as $User){ ?>
            <option value="<?php echo $User->FullName; ?>"><?php echo $User->FullName; ?></option>
            <?php } ?>
        </select>
    </div>
</div>