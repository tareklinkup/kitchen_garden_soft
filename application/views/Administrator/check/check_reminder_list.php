<div class="row">
  <div class="col-xs-12">
    <div class="widget-box">
      <div class="widget-header">
        <h4 class="widget-title">Cheque Information List</h4>
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
                <th>Cheque Date</th>
                <th>Cheque No</th>
                <th>Bank Name - Branch Name</th>
                <th>Customer Name</th>
                <th>Reminder Date</th>
                <th>Cheque Amount</th>
                <th>Action</th>
              </tr>
            </thead>

            <tbody id="tBody">
                <?php $i=1; if(isset($checks)&&$checks ): foreach($checks as $check): ?>
              <tr style="<?= ($check->check_status == 'Di')?'background-color:#ff000036;':''?>" >
                <td>
                  <?php 
                    $date = new DateTime($check->check_date);
                    echo date_format($date, 'd M Y'); 
                  ?>
                </td>
                <td><?= $check->check_no; ?></td>
                <td><?= $check->bank_name.'-'.$check->branch_name; ?></td>
				  <td><?= $check->Customer_Code.' - '.$check->Customer_Name; ?></td>
                
                <td>
                  <?php 
                    $date = new DateTime($check->remid_date);
                    echo date_format($date, 'd M Y'); 
                  ?>
                </td>
                <td><?= number_format($check->check_amount,2); ?></td>
                <td>
                    <div class="hidden-sm hidden-xs action-buttons">
						<a class="green btn btn-xs btn-success cheque_submit" title="Paid" id="<?= $check->id; ?>" >
							<i class="fa fa-money" aria-hidden="true"></i>
						</a>
						<a class="red btn btn-xs btn-danger" title="Dishonor"  href="<?= base_url()?>check/dishonor/submit/<?= $check->id ?>"  >
							<i class="fa fa-ban" aria-hidden="true"></i>
						</a>
                    </div>
                </td>
              </tr>
              <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>



<script>
	$('.cheque_submit').click(function(){
		var cheque_id = $(this).attr('id');

		$.ajax({
			url:'<?= base_url();?>check/paid/submit/'+cheque_id,
			type:'POST',
			dataType:'json',
			success:function(data){
				if(data == 1){
					alert('Cheque Successfully Paid');
					location.reload();
				}else{
					alert('Cheque Not Successfully Paid');
					location.reload();
				}
			}
		});
	});
</script>
