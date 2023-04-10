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
.hide{display-none}

</style>
<script type="text/javascript">
window.onload = async () => {
		await new Promise(resolve => setTimeout(resolve, 1000));
		window.print();
		window.close();
	}
</script>
<body style="background-none;">


    <table width="800">
    <tr>
    <td style="padding-left-20px;"> 
	
	<div class="row">
	
	<div class="col-sm-12 text-center" style="background:#ccc;margin-bottom:10px;">
		 <strong style="line-height:40px;">Balance Sheet</strong>
	</div>
	
	<div class="col-sm-12 text-center" style="margin-bottom:10px;text-align:right;">
		 <strong style="line-height:20px;">From <?php echo $this->session->userdata('startdate'); ?> To <?php echo $this->session->userdata('enddate'); ?></strong>
	</div>
	
    <div class="col-sm-6">
        <table class="table table-bordered">
		<tr style="">
			<td colspan="3" align="center"><h4>Cash In</h4></td>
		</tr>
            <?php
            $sales = 0;
            $SaleDueAmount = 0;
            $salesReturn = 0;
            $cusPayment = 0;
			$purchase=0;
            $purchaseRet=0;
            $supplierPaid=0;
            $supplierDue=0;
            $supPayment=0;
			
			//$expenseTotal = 0;
            //$incomeTotal = 0;
            $withdraw = 0;
            $deposit = 0;
            $expense = 0;
            $incash = 0;
			
			$totalCashIn = 0;
			$totalCashOut = 0;
			
            if(isset($saleRecords) && $saleRecords){
	            foreach($saleRecords as $record){
	                $sales = $sales + $record->SaleMaster_SubTotalAmount;
	                $salesReturn = $salesReturn + $record->SaleReturn_ReturnAmount;
	                $SaleDueAmount = $SaleDueAmount + $record->SaleMaster_DueAmount;
	            } 
	        }
			
			if(isset($customerPayment) && $customerPayment){
	            foreach($customerPayment as $record){
	                $cusPayment = $cusPayment + $record->CPayment_amount;
	            }
        	}	 
			
			if(isset($purchaseRecords) && $purchaseRecords){
	            foreach($purchaseRecords as $record){
	                $purchase = $purchase + $record->PurchaseMaster_SubTotalAmount;
	                $purchaseRet = $purchaseRet + $record->PurchaseReturn_ReturnAmount;
	                $supplierPaid = $supplierPaid + $record->PurchaseMaster_PaidAmount;
	                $supplierDue = $supplierDue + $record->PurchaseMaster_DueAmount;
				}
			}
			
			if(isset($supplierPayment) && $supplierPayment){
	            foreach($supplierPayment as $record){
	                $supPayment = $supPayment + $record->SPayment_amount;
	            }
            } 
			
			if(isset($expenseRecords) && $expenseRecords){
	            foreach($expenseRecords as $record){
	               // $incomeTotal = $incomeTotal+$record->In_Amount;
	               // $expenseTotal = $expenseTotal+$record->Out_Amount;
					if($record->Tr_Type=='Withdraw Form Bank'){
						$withdraw = $withdraw+$record->In_Amount;
					}else if($record->Tr_Type=='Deposit To Bank'){
						$deposit = $deposit+$record->Out_Amount;
					}else if($record->Tr_Type=='Out Cash'){
						$expense = $expense+$record->Out_Amount;
					}else{
						$incash = $incash+$record->In_Amount;
					}
				}
			}
			
			$totalCashIn = $cusPayment + $purchaseRet + $withdraw + $incash;
			$totalCashOut = $salesReturn + $supPayment + $deposit + $expense;
			 ?>
			<tr>
				<td> Total Sales</td>
				<th><?php echo $sales; ?></th>
				<td>-</td>
			</tr>
			
			<tr>
				<td>Customer Payment Receive</td>
				<td>-</td>
				<td><?php echo $cusPayment; ?></td>
			</tr>
			
			<tr>
				<td>Customer Due</td>
				<th><?php echo $SaleDueAmount; ?></th>
				<td>-</td>
			</tr>
			
			<tr>
				<td>Purchase Return</td>
				<td>-</td>
				<td><?php echo $purchaseRet; ?></td>
			</tr>
			
			<tr>
				<td>Withdraw From Bank </td>
				<td>-</td>
				<td><?php echo $withdraw; ?></td>
			</tr>
			
			<tr>
				<td>Cash Receive </td>
				<td>-</td>
				<td><?php echo $incash; ?></td>
			</tr>
			
            <tr style="background: #ccc">
                <th>Total Cash In</th>
                <th>-</th>
                <th colspan=""><?php echo $totalCashIn;?></th>
            </tr>
        </table>
    </div>
	
	 <div class="col-sm-6">
        <table class="table table-bordered">
		<tr style="">
			<td colspan="3" align="center"><h4>Cash Out</h4></td>
		</tr>
			<tr>
				<td>Total Purchase</td>
				<th><?php echo $purchase; ?></th>
				<td>-</td>
			</tr>
			
			<tr>
				<td>Supplier Payment</td>
				<td>-</td>
				<td><?php echo $supPayment; ?></td>
			</tr>
			
			<tr>
				<td>Supplier Due</td>
				<th><?php echo $supplierDue; ?></th>
				<td>-</td>
			</tr>
			
			<tr>
				<td>Sales Return</td>
				<td>-</td>
				<td><?php echo $salesReturn; ?></td>
			</tr>
			
			<tr>
				<td>Deposit to Bank</td>
				<td>-</td>
				<td><?php echo $deposit; ?></td>
			</tr>
			
			<tr>
				<td>Cash Payment</td>
				<td>-</td>
				<td><?php echo $expense; ?></td>
			</tr>
			
            <tr style="background: #ccc">
                <th>Total Cash Out</th>
                <th>-</th>
                <th><?php echo $totalCashOut;?></th>
            </tr>
        </table>
    </div>

	    <div class="col-sm-12" style="background:#FFC107; border- 1px solid #DDE2EB; width-100%; text-align: center;">Cash Balance- <?php echo $totalCashIn - $totalCashOut; ?> </div>
		<div class="col-sm-12" style="margin-top-50px;text-align:right;">
		  <span style="float-left;font-size-11px;">Software Provied By Link-Up Technology</span>
		</div>
		
		</div>
           </td>
        </tr>
</table>

</body>
</html>

