<div class="row">
  <div class="col-xs-12">
    <div class="widget-box">
      <div class="widget-header">
        <h4 class="widget-title">Check Information List</h4>
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
          <table id="dynamic-table" class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>#</th>
                <th>Check Date</th>
                <th>Chack No</th>
                <th>Bank Name - Branch Name</th>
                <th>Customer Name</th>
                <th>Submited Date</th>
                <th>Check Amount</th>
              </tr>
            </thead>

            <tbody id="tBody">
                <?php $i=1; if(isset($checks)&&$checks ): foreach($checks as $check):?>
              <tr>
                <td><?= $i++ ?></td>
                <td>
                  <?php 
                    $date = new DateTime($check->check_date);
                    echo date_format($date, 'd M Y'); 
                  ?>
                </td>
                <td><?= $check->check_no; ?></td>
                <td><?= $check->bank_name.'-'.$check->branch_name; ?></td>
                <td><?= $check->Customer_Name; ?></td>
                
                <td>
                  <?php 
                    $date = new DateTime($check->sub_date);
                    echo date_format($date, 'd M Y'); 
                  ?>
                </td>
                <td><?= number_format($check->check_amount,2); ?></td>
          
              </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
  