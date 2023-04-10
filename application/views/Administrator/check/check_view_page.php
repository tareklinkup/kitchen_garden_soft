<div class="widget-box" style="width: 500px;">
    <div class="widget-header">
      <h4 class="widget-title">View Check Information</h4>
    </div>

    <div class="widget-body">
      <div class="widget-main">
		    <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="row" style="">
                <div class="col-xs-12 label label-lg label-info arrowed-in arrowed-right">
                    <b>Check Details</b>
                </div>
            </div>
            <div class="profile-user-info profile-user-info-striped">
                <div class="profile-info-row">
                    <div class="profile-info-name"> Cheque No: </div>

                    <div class="profile-info-value">
                        <span class="editable" id="username"><?= $check->check_no; ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Bank Name: </div>

                    <div class="profile-info-value">
                        <span class="editable" id="city"><?= $check->bank_name ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Branch Name: </div>

                    <div class="profile-info-value">
                        <span class="editable" id="age"><?= $check->branch_name ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Customer Name: </div>

                    <div class="profile-info-value">
                        <span class="editable" id="signup"><?= $check->Customer_Name ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Cheque Date: </div>
                    <?php 
                      $date = new DateTime($check->check_date);
                      $c_date = date_format($date, 'd M Y'); 
                    ?>
                    <div class="profile-info-value">
                        <span class="editable" id="login"><?= $c_date ?></span>
                    </div>
                </div>

                <div class="profile-info-row">
                    <div class="profile-info-name"> Reminder Date: </div>
                    <?php 
                      $date = new DateTime($check->remid_date);
                      $r_date = date_format($date, 'd M Y'); 
                    ?>
                    <div class="profile-info-value">
                        <span class="editable" id="about"><?= $r_date ?></span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Submited Date: </div>
                    <?php 
                      $date = new DateTime($check->sub_date);
                      $s_date = date_format($date, 'd M Y'); 
                    ?>
                    <div class="profile-info-value">
                        <span class="editable" id="about"><?= $s_date ?></span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Amount: </div>

                    <div class="profile-info-value">
                        <span class="editable" id="about"><?= number_format($check->check_amount,2) ?></span>
                    </div>
                </div>
                <div class="profile-info-row">
                    <div class="profile-info-name"> Note: </div>

                    <div class="profile-info-value">
                        <span class="editable" id="about"><?= $check->note ?></span>
                    </div>
                </div>
                
                <div class="profile-info-row">
                    <div class="profile-info-name"> Cheque Status: </div>

                    <div class="profile-info-value">
                        <span class="editable" id="about">
                            <?php if($check->check_status == 'Pa'): ?>
                              <span class="label " style="background: green;">Paid</span>
                              <?php else: ?>
                              <span class="label " style="background: #ec880a;">Pending</span>
                              <?php endif;?>
                        </span>
                    </div>
                </div>
                
            </div>
        </div>  
        </div>
      </div>
    </div>
 </div>
