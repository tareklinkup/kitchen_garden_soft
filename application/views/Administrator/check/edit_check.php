<div class="row">
  <div class="col-xs-12">

      <!--============Customer Information============ -->
      <!--============Customer Information============ -->
      <div class="widget-box">
        <div class="widget-header">
          <h4 class="widget-title">Add New Cheque Information</h4>
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
            <form id="check_form" action="<?= base_url();?>check/update/<?= $check->id; ?>" method="POST">
              <div class="row">
                <div class="col-sm-2"></div>

                <div class="col-sm-4">
                  
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="cus_id">Select Customer:<span class="text-bold text-danger">*</span></label>
                    <div class="col-sm-7">
                      <select class="chosen-select form-control" id="cus_id" required name="cus_id" style="height: 30px; border-radius: 5px;">
                        <option value=" ">Select a Customer</option>
                        <?php if($customers && isset($customers)):  foreach($customers as $customer):?>
                          <option value="<?= $customer->Customer_SlNo; ?>" <?= ($check->cus_id == $customer->Customer_SlNo)?'selected':''?>><?= $customer->Customer_Code.'-'.ucfirst($customer->Customer_Name); ?></option>
                        <?php endforeach; endif; ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="bank_name">Bank Name:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <input type="text" id="bank_name"  name="bank_name" value="<?= $check->bank_name; ?>" required placeholder="Bank Name" class="form-control"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="branch_name">Branch Name:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <input type="text" id="branch_name"  name="branch_name" value="<?= $check->branch_name; ?>" required placeholder="Branch Name" class="form-control"  />
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="check_no">Cheque No:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <input type="text" id="check_no"  name="check_no" value="<?= $check->check_no; ?>" required placeholder="Cheque No" class="form-control"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="check_amount">Cheque Amount:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <input type="text" id="check_amount"  name="check_amount" value="<?= $check->check_amount; ?>" required placeholder="Cheque Amount" class="form-control"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="check_status">Cheque Status:<span class="text-bold text-danger">*</span></label>
                    <div class="col-sm-7">
                      <select class="chosen-select form-control" id="check_status" required name="check_status" style="height: 30px; border-radius: 5px;">
                        <option value="Pe" <?= ($check->check_status == 'Pe')?'selected':'' ?> >Pending</option>
                        <option value="Pa" <?= ($check->check_status == 'Pa')?'selected':'' ?>>Paid</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="date"> Date:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <?php 
                        $date = new DateTime($check->date);
                        $e_date=  date_format($date, 'Y-m-d'); 
                      ?>
                       <input class="form-control date-picker" required id="date" name="date" type="text" value="<?php echo $e_date; ?>"  data-date-format="yyyy-mm-dd" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="check_date">Cheque Date:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <?php 
                        $date = new DateTime($check->check_date);
                        $c_date=  date_format($date, 'Y-m-d'); 
                      ?>
                       <input class="form-control date-picker" required id="check_date" name="check_date" type="text" value="<?php echo $c_date; ?>"  data-date-format="yyyy-mm-dd" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="remid_date">Reminder Date:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <?php 
                        $date = new DateTime($check->remid_date);
                        $r_date=  date_format($date, 'Y-m-d'); 
                      ?>
                      <input class="form-control date-picker" required id="remid_date" name="remid_date" type="text" value="<?php echo $r_date; ?>"  data-date-format="yyyy-mm-dd" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="sub_date">Submit Date:<span class="text-bold text-danger">*</span> </label>
                    <div class="col-sm-7">
                      <?php 
                        $date = new DateTime($check->sub_date);
                        $s_date=  date_format($date, 'Y-m-d'); 
                      ?>
                      <input class="form-control date-picker" required id="sub_date" name="sub_date" type="text" value="<?php echo $s_date; ?>"  data-date-format="yyyy-mm-dd" />
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-5 control-label no-padding-left" for="note">Description: </label>
                    <div class="col-sm-7">
                       <input type="text" id="note" name="note" value="<?= $check->note; ?>" class="form-control"  placeholder="Description" />
                    </div>
                  </div>
                  
                  <div class="form-group" style="margin-top: 10px;">
                    <label class="col-sm-4 control-label no-padding-left" for="ord_budget_range"> </label>
                    <div class="col-sm-8">
                      <button type="submit" id="check_submit" style="height: 27px; padding-top: 0px; float: right; " class="btn btn-primary cus_submit">Update</button>
                    </div>
                  </div>


                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
  </div>  
</div>
