<div class="">
<div>
<h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>cashStatmentListPrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><img src="<?php echo base_url(); ?>images/printer.png" alt=""> Print</a></h4>
</div>
<div class="row">
    <div class="col-sm-4">
        <table class="table table-bordered">
		<tr style="">
			<td colspan="3" align="center"><h4>Sales</h4></td>
		</tr>
		
			<tr>
				<td>Invoice No.</td>
				<th>Cash In</th>
				<th>Cash Out</th>
			</tr>
            <?php
            $sales = 0;
            $salesReturn = 0;
            if(isset($saleRecords) && $saleRecords){ 
            foreach($saleRecords as $record){
                $sales = $sales + $record->SaleMaster_SubTotalAmount;
                $salesReturn = $salesReturn + $record->SaleReturn_ReturnAmount;
                ?>
                <tr>
                    <td><?php echo $record->SaleMaster_InvoiceNo; ?></td>
                    <td><?php echo $record->SaleMaster_SubTotalAmount; ?></td>
                    <td><?php echo $record->SaleReturn_ReturnAmount; ?></td>
                </tr>
            <?php } } ?>
			<!--<tr>
				<td><?php echo $sales; ?></td>
				<td><?php echo $salesReturn; ?></td>
			</tr>-->
			
            <tr style="background: #ccc">
                <th>Balance</th>
                <th colspan="2" style="text-align: center;"><b><?php echo ($salesAndRetTotal = $sales - $salesReturn);?></b></th>
            </tr>
        </table>
    </div>
	
    <div class="col-sm-4">
        <table  class="table table-bordered">
		<tr style="">
			<td colspan="3" align="center"><h4>Purchase</h4></td>
		</tr>
			
		<tr>
			<td>Invoice No.</td>
			<th>Cash In </th>
			<th>Cash Out</th>
		</tr>
            <?php
            $purchase=0;
            $purchaseRet=0;
            if(isset($purchaseRecords) && $purchaseRecords){
            foreach($purchaseRecords as $record){
                $purchase = $purchase + $record->PurchaseMaster_SubTotalAmount;
                $purchaseRet = $purchaseRet + $record->PurchaseReturn_ReturnAmount;
                ?>
				<tr>
                    <td><?php echo $record->PurchaseMaster_InvoiceNo; ?></td>
					<td><?php echo $record->PurchaseReturn_ReturnAmount; ?></td>
                    <td><?php echo $record->PurchaseMaster_SubTotalAmount; ?></td>
                </tr>
            <?php } } ?>
			<!--<tr>
				<td><?php echo $purchaseRet; ?></td>
				<td><?php echo $purchase; ?></td>
			</tr>-->
			
            <tr style="background: #ccc">
                <th>Balance</th>
                <th colspan="2"><b><?php echo ($purAndRetTotal = $purchase - $purchaseRet);?></b></th>
            </tr>
        </table>
    </div>
	
    <div class="col-sm-4">
        
        <table class="table table-bordered">
			<tr style="">
				<td colspan="4" align="center"><h4>Cash In / Cash In</h4></td>
			</tr>
			<tr>
				<!--<td>Invoice No.</td>
				<th>In Amount</th>
				<th>Out Amount</th>-->
				
				<th>Withdraw</th>
				<th>Deposit</th>
                <th>Receive</th>
				<th>Payment</th>
			</tr>
            <?php
            $expenseTotal = 0;
            $incomeTotal = 0;
            $withdraw = 0;
            $deposit = 0;
            $rec = 0;
            $pay = 0;
            $payment=0;
            $receive=0;
            if(isset($expenseRecords) && $expenseRecords){
            foreach($expenseRecords as $record){
                $incomeTotal = $incomeTotal+$record->In_Amount;
                $expenseTotal = $expenseTotal+$record->Out_Amount;
				if($record->Tr_Type=='Withdraw Form Bank'){
					$withdraw = $withdraw+$record->In_Amount;
				}else if($record->Tr_Type=='Deposit To Bank'){
					$deposit = $deposit+$record->Out_Amount;
				}else if($record->Tr_Type=='In Cash'){
                    $receive = $rec+$record->In_Amount;
                }else if($record->Tr_Type=='Out Cash'){
                    $payment = $pay+$record->Out_Amount;
                }
                ?>
                 <!--<tr>
                   <td><?php echo $record->Tr_Id; ?></td>
                    <td><?php echo $record->In_Amount; ?></td>
                    <td><?php echo $record->Out_Amount; ?></td>
                </tr>-->

            <?php } } ?>
			<tr>
				<td><?php echo $withdraw; ?></td>
				<td><?php echo $deposit; ?></td>
                <td><?php echo $receive; ?></td>
				<td><?php echo $payment; ?></td>
			</tr>
			
            <tr style="background: #ccc;">
                <th>Balance</th>
                <th colspan="3" align="left"><b><?php echo ($inExTotal = $incomeTotal-$expenseTotal);?></b></th>
            </tr>
        </table>
    </div>
	</div>
    <div style="clear: both"></div>
    <div style="background:#1c7d42; color: #fff; height: 40px;line-height: 40px; border: 1px solid #DDE2EB; width:100%; text-align: center;"><strong style="font-size: 16px;">Cash Balance: <?php echo ($salesAndRetTotal+$inExTotal-$purAndRetTotal);?></strong></div>
</div>