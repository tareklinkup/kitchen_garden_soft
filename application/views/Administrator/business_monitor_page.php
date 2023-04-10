

<div class="row" style="margin-top: 30px; border-radius: 3px;">
	<?php if(isset($transactions) && $transactions): ?>
	<div class="col-md-12">
		<?php 
			$brunch = $this->session->userdata('BRANCHid');
			$total = $this->db->select_sum('SaleMaster_SubTotalAmount')->select_sum('SaleMaster_DueAmount')->select_sum('SaleMaster_PaidAmount')->where('SaleMaster_branchid' , $brunch)->where("DATE_FORMAT(SaleMaster_SaleDate,'%Y-%m-%d') >=",date('Y-m-d'))->get('tbl_salesmaster')->row();
		?>
		<div class="well" style="background-color:#080808; color: #fff; padding: 5px; ">
			<marquee behavior="scroll" onmouseover="this.stop();" onmouseout="this.start();" >
			<ul style="list-style: none; margin: 0; padding: 0; width: 500%;">
				<li style="float: left; padding: 0 10px;">

					<p style="padding:5px 0 0 0px; margin: 0px; font-weight: 500;">
						<i class="fa fa-circle" aria-hidden="true" style="padding-right: 1px; color:green; "></i>
						<span>Today Total Sale: <?= number_format($total->SaleMaster_SubTotalAmount, 2);?></span>
					</p>
				</li>
				<li style="float: left; padding: 0 10px;">

					<p style="padding:5px 0 0 0px; margin: 0px; font-weight: 500;">
						<i class="fa fa-circle" aria-hidden="true" style="padding-right: 1px; color:red; "></i>
						<span>Today Due Sale: <?= number_format($total->SaleMaster_DueAmount, 2);?></span>
					</p>
				</li>
				<li style="float: left; padding: 0 10px;">

					<p style="padding:5px 0 0 0px; margin: 0px; font-weight: 500;">
						<i class="fa fa-circle" aria-hidden="true" style="padding-right: 1px; color:green; "></i>
						<span>Today Paid Sale: <?= number_format($total->SaleMaster_PaidAmount, 2);?></span>
					</p>
				</li>
				<?php foreach($transactions as $transaction):?>
				<?php $date = New DateTime($transaction->Tr_date);
					$tr_date = date_format($date, 'd M Y');
				?>
				<li style="float: left; padding: 0 10px;">

					<p style="padding:5px 0 0 0px; margin: 0px; font-weight: 500;">
						<?php if($transaction->Tr_Type== 'Out Cash' ||$transaction->Tr_Type == 'Deposit To Bank'): ?>
							<i class="fa fa-arrow-up" aria-hidden="true" style="padding-right: 1px; color:red; "></i>
						<?php else:?>
							<i class="fa fa-arrow-down" aria-hidden="true" style="padding-right: 1px; color:green; "></i>
						<?php endif; ?>

						<?= $transaction->Tr_Id.' - '.$tr_date.' - '.$transaction->Tr_Type.' - '?> <?= ($transaction->Tr_Type== 'Out Cash' ||$transaction->Tr_Type == 'Deposit To Bank')? number_format($transaction->Out_Amount, 2): number_format($transaction->In_Amount, 2)?>
					</p>
				</li>
				<?php endforeach;?>
			</ul>
			</marquee>
		</div>
	</div>
	<?php endif;?>
	<div class="col-xs-12">
		
		<div class="col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Top Customer Information List</h4>
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
								<div class="col-sm-4"></div>
								<div class="form-group">
									<div class="col-sm-3 no-padding-right">
										<input class="form-control date-picker" id="paid_start_date" type="text" value="<?= date('Y-m-d')?>" placeholder="Start Date"  data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important; padding: 4px 6px 4px !important; width: 175px;float:left; " />
										<span class="input-group-addon" style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
											<i class="fa fa-calendar bigger-110"></i>
										</span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-3 no-padding-right">
										<input class="form-control date-picker" id="paid_end_date" type="text" value="<?= date('Y-m-d')?>" placeholder="End Date" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;padding: 4px 6px 4px !important;width: 175px;float:left;" />
										<span class="input-group-addon" style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
											<i class="fa fa-calendar bigger-110"></i>
										</span>
									</div>
								</div>
								<div class="col-sm-2">
									<input type="button" class="btn btn-info btn-xs" style="height: 25px; padding-top: 1px!important;" value="Search"  onclick="top_paic_cus()">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<table  id="dynamic-table2" class="table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>Customer ID</th>
								<th>Customer Name</th>
								<th>Phone NO</th>
								<th>Address</th>
								<th>Paid Amount</th>
							</tr>
							</thead>

							<tbody id="cus_tbody">
							<?php $i=1; if(isset($top_cus_list)&&$top_cus_list ): foreach($top_cus_list as $cus):?>
								<tr>
									<td><?= $i++ ?> </td>
									<td><?= $cus->Customer_Code; ?></td>
									<td><?= $cus->Customer_Name; ?></td>
									<td><?= $cus->Customer_Mobile; ?></td>
									<td><?= $cus->Customer_Address?></td>
									<td><?= number_format($cus->total_amount,2); ?></td>
								</tr>
							<?php endforeach; endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Top Sale Product List</h4>
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
								<div class="col-sm-4"></div>
								<div class="form-group">
									<div class="col-sm-3 no-padding-right">
										<input class="form-control date-picker" id="sale_start_date" name="sales_date" type="text" value="<?php echo date('Y-m-d'); ?>" name="pdate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important; padding: 4px 6px 4px !important; width: 175px;float:left; " />
										<span class="input-group-addon" style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
											<i class="fa fa-calendar bigger-110"></i>
										</span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-3 no-padding-right">
										<input class="form-control date-picker" id="sale_end_date" name="sales_date" type="text" value="<?php echo date('Y-m-d'); ?>" name="pdate" type="text" data-date-format="yyyy-mm-dd" style="border-radius: 5px 0px 0px 5px !important;padding: 4px 6px 4px !important;width: 175px;float:left;" />
										<span class="input-group-addon" style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
											<i class="fa fa-calendar bigger-110"></i>
										</span>
									</div>
								</div>
								<div class="col-sm-2">
									<input type="button" class="btn btn-info btn-xs" style="height: 25px; padding-top: 1px!important;" value="Search" onclick="top_sell_product()">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="widget-body">
					<div class="widget-main">
						<table id="dynamic-table" class="table table-striped table-bordered table-hover">
							<thead>
							<tr>
								<th>#</th>
								<th>Product Code</th>
								<th>Product Name</th>
								<th>Total Sale</th>
								<th>Purchase Rate</th>
								<th>Sale Rate</th>
							</tr>
							</thead>

							<tbody id="sale_tBody">
							<?php $i=1; if(isset($topSells)&&$topSells ): foreach($topSells as $sale):?>
								<tr>
									<td><?= $i++ ?></td>
									<td><?= $sale->Product_Code?></td>
									<td><?= $sale->Product_Name; ?></td>
									<td><?= $sale->qty; ?></td>
									<td><?= number_format($sale->Product_Purchase_Rate,2); ?></td>
									<td><?= number_format($sale->Product_SellingPrice,2); ?></td>
								</tr>
							<?php endforeach; endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="widget-title">Reminder Cheque Information List</h4>
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
							<?php $i=1; if(isset($checks)&&$checks ): foreach($checks as $check):?>
								<tr>
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
											<a class="green btn btn-xs btn-info cheque_submit" id="<?= $check->id; ?>" >
												Paid
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
</div>

<script type="text/javascript">
	function top_sell_product(){
		var start_date = $('#sale_start_date').val();
		var end_date = $('#sale_end_date').val();

		$.ajax({
			url:'<?= base_url(); ?>date_to_date_top_sale',
			type:'post',
			dataType:'html',
			data:'start_date='+start_date+'&end_date='+end_date,
			success:function(data){
				console.log(data);
				$('#sale_tBody').empty();
				$('#sale_tBody').html(data)
			}
		});
	}

	function top_paic_cus(){
		var start_date = $('#paid_start_date').val();
		var end_date = $('#paid_end_date').val();
		$.ajax({
			url:'<?= base_url(); ?>date_to_date_top_paid_cus',
			type:'post',
			dataType:'html',
			data:'start_date='+start_date+'&end_date='+end_date,
			success:function(data){
				console.log(data);
				$('#cus_tbody').empty();
				$('#cus_tbody').html(data);
			}
		});
	}

</script>

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

