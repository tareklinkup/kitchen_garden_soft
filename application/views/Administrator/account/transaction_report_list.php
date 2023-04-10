<link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
<div class="content_scroll" style="">
    <h4><a style="cursor:pointer" id="printIcon"><i class="fa fa-print" style="font-size:24px;color:green"></i> Print</a></h4>

    <div id="reportContent">
        <table class="table table-bordered" cellspacing="0" cellpadding="0" width="80%">

            <tr bgcolor="#ccc" style="text-align:center;">
                <th style="text-align:center;">Tr. ID</th>
                <th style="text-align:center;">Date</th>
                <th style="text-align:center;">Tr Account</th>
                <th style="text-align:center;">Account Name</th>
                <th style="text-align:center;">Description</th>
                <th style="text-align:center;">Receive Amount</th>
                <th style="text-align:center;">Payment Amount</th>
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
                        if($row->Tr_Type == 'In Cash'): echo 'Cash Receive';
                        elseif($row->Tr_Type == 'Out Cash'): echo 'Cash Payment';
                        endif;
                    ?>
                </td>
                <td><?php echo $row->Acc_Name." - ".$row->Acc_Code; ?></td>
                <td><?php  echo $row->Tr_Description; ?></td>
                <td><?php if($row->In_Amount=="" ||$row->In_Amount=="0" ){echo '0';}else{ echo $row->In_Amount;} ?></td>
                <td><?php if($row->Out_Amount=="" ||$row->Out_Amount=="0" ){echo '0';}else{ echo $row->Out_Amount;} ?></td>
            </tr>
            <?php } ?>
            
        <tr align="center">
                <td colspan="5" align="right"><strong>Total : </strong></td>
                <!-- <td><strong><?php echo $totalin;?></strong></td>-->
            <td><strong><?php echo $totalin; ?></strong></td>
            <td><strong><?php echo $totalinout; ?></strong></td>
            </tr>
            
        </table>
    </div>

</div>