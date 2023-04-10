<link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
<div class="content_scroll" style="">

    <table class="border" cellspacing="0" cellpadding="0" width="80%">

        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>expensePrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:24px;color:green"></i> Print</a></h4>
        <tr bgcolor="#ccc" style="text-align:center;">
            <th style="text-align:center;">Tr. ID</th>
            <th style="text-align:center;">Date</th>
            <th style="text-align:center;">Tr Account</th>
            <th style="text-align:center;">Account Name</th>
            <th style="text-align:center;">Description</th>
            <!--<th style="text-align:center;">In Amount</th> --->                     
            <th style="text-align:center;">Out Amount</th>
        </tr>
        <?php
		$totalin = 0;
		$totalinout = 0;
        foreach($record as $row){
		$totalin = $totalin + $row->In_Amount;
		$totalinout = $totalinout + $row->Out_Amount;
		?>
        <tr align="center">
            <td><?php echo $row->Tr_Id; ?></td>
            <td><?php echo $row->Tr_date; ?></td>
            <td>
            <?php 
                if($row->Tr_Type == 'Out Cash'): echo 'Cash Payment';
                endif;
            ?> 
            </td>
            <td><?php echo $row->Acc_Name; ?></td>
            <td><?php echo $row->Tr_Description; ?></td>
            <!--<td><?php if($row->In_Amount=="" ||$row->In_Amount=="0" ){echo '0';}else{ echo $row->In_Amount;} ?></td>-->
            <td><?php if($row->Out_Amount=="" ||$row->Out_Amount=="0" ){echo '0';}else{ echo $row->Out_Amount;} ?></td>
        </tr>
        <?php } ?>
		
       <tr align="center">
            <td colspan="5" align="right">Total : </td>
            <!--<td><?php echo $totalin;?></td>-->
            <td><?php echo $totalinout; ?></td>
        </tr>
		
    </table>

</div>