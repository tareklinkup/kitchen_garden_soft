<?php
$brunch=$this->session->userdata('BRANCHid');

?>
<!DOCTYPE html>
<html>
<head>
<title> </title>
<meta charset='utf-8'>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
</head>
<style type="text/css" media="print">
.hide{display:none}

</style>
<script type="text/javascript">
window.onload = async () => {
		await new Promise(resolve => setTimeout(resolve, 1000));
		window.print();
		window.close();
	}
</script>
<body style="background:none;">


    <table width="800">
    <tr>
    <td style="padding-left:20px;"> 
	
	<div class="row">
	<div class="col-sm-12 text-center" style="height:40px;background:#ccc;margin-bottom:10px;">
		 <strong style="line-height:40px;">Cash Statement</strong>
	</div>
			
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
                <th colspan="2"><?php echo ($salesAndRetTotal = $sales - $salesReturn);?></th>
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
            <?php } }?>
			<!--<tr>
				<td><?php echo $purchaseRet; ?></td>
				<td><?php echo $purchase; ?></td>
			</tr>-->
			
            <tr style="background: #ccc">
                <th>Balance</th>
                <th colspan="2"><?php echo ($purAndRetTotal = $purchase - $purchaseRet);?></th>
            </tr>
        </table>
    </div>
	
    <div class="col-sm-4">
        
        <table class="table table-bordered">
			<tr style="">
				<td colspan="3" align="center"><h4>Cash In / Cash In</h4></td>
			</tr>
			<tr>
				<!--<td>Invoice No.</td>
				<th>In Amount</th>
				<th>Out Amount</th>-->
				
				<th>Withdraw</th>
				<th>Deposit</th>
				<th>Expense</th>
			</tr>
            <?php
            $expenseTotal = 0;
            $incomeTotal = 0;
            $withdraw = 0;
            $deposit = 0;
            $expense = 0;
            if(isset($expenseRecords) && $expenseRecords){
            foreach($expenseRecords as $record){
                $incomeTotal = $incomeTotal+$record->In_Amount;
                $expenseTotal = $expenseTotal+$record->Out_Amount;
				if($record->Tr_Type=='Withdraw Form Bank'){
					$withdraw = $withdraw+$record->In_Amount;
				}else if($record->Tr_Type=='Deposit To Bank'){
					$deposit = $deposit+$record->Out_Amount;
				}else if($record->Tr_Type=='Expense'){
					$expense = $deposit+$record->Out_Amount;
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
				<td><?php echo $expense; ?></td>
			</tr>
			
            <tr style="background: #ccc;">
                <th>Balance</th>
                <th colspan="2" align="left"><?php echo ($inExTotal = $incomeTotal-$expenseTotal);?></th>
            </tr>
        </table>
    </div>
	    <div class="col-sm-12" style="background:#FFC107; border: 1px solid #DDE2EB; width:100%; text-align: center;">Cash Balance: <?php echo ($salesAndRetTotal+$inExTotal-$purAndRetTotal);?></div>
	</div>
           </td>
        </tr>
</table>

<div class="provied" style="margin-top:50px;">
  <span style="float:left;font-size:11px;">Software Provied By Link-Up Technology</span>
</div>
</body>
</html>

