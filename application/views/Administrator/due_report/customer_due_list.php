<span id="Search_Results_Duepayment">
<link href="<?php echo base_url() ?>assets/css/prints.css" rel="stylesheet"/>
<div class="content_scroll" style="">

    <table class="border" cellspacing="0" cellpadding="0" width="80%">

        <h4><a style="cursor:pointer"
               onclick="window.open('<?php echo base_url(); ?>Administrator/reports/search_customer_due', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"> <i
                        class="fa fa-print" style="font-size:24px;color:green"></i> Print</a></h4>
        <tr bgcolor="#438eb9" style="">
          
            <th style="text-align:center;color:#fff;">Customer ID</th>
            <th style="text-align:center;color:#fff;">Customer Name</th>
            <th style="text-align:center;color:#fff;">Phone NO</th>
            <th style="text-align:center;color:#fff;">Last Pay. Date</th>
            <th style="text-align:center;color:#fff;">Last Pay. Amount</th>
            <?php if ($this->session->userdata('searchtype') == 'Customer'): ?>
                <th style="text-align:center;color:#fff;">Due</th>
                <th style="text-align:center;color:#fff;">Prv. Due</th>
            <?php endif; ?>
            <th style="text-align:center;color:#fff;">Total Due</th>
            <?php if ($this->session->userdata('searchtype') == 'All'): ?>
                <th style="text-align:center;color:#fff;">Action</th>
            <?php endif; ?>
        </tr>
        <?php
        $totalpurchase = "";
        $Totalpaid = "";
        $due = "";

        foreach ($records as $record) {
            $Custid = $record->Customer_SlNo;
            $prevDue = $record->previous_due;

            $dueAmont = $this->mt->getCustomerDueById($Custid);

            if ($dueAmont > 0):
                ?>
                <tr align="center">
                <td><?php echo $record->Customer_Code; ?></td>
                <td><?php echo $record->Customer_Name; ?></td>
                <td><?php echo $record->Customer_Mobile; ?></td>
                <?php $pay = $this->Customer_model->last_customer_payment($Custid); ?>
                <td><?php if ($pay) {
                        $date = New DateTime($pay->CPayment_date);
                        echo date_format($date, 'd M Y');
                    } else {
                        echo "-------";
                    } ?></td>
                <td><?php if ($pay) {
                        echo number_format($pay->CPayment_amount, 2);
                    } else {
                        echo "-------";
                    } ?></td>
                <?php if ($this->session->userdata('searchtype') == 'Customer'): ?>
                    <td><?php echo number_format($dueAmont - $prevDue, 2); ?></td>
                    <td><?php echo number_format($prevDue, 2); ?></td>
                <?php endif; ?>
                <td><?php echo number_format($dueAmont, 2); ?></td>
                <?php if ($this->session->userdata('searchtype') == 'All'): ?>
                    <td><a class="btn-add btn btn-xs btn-info print"
                           onclick="window.open('<?php echo base_url(); ?>Administrator/reports/cusDuePrint/<?php echo $record->Customer_SlNo; ?>', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i
                                    class="fa fa-print"></i></a></td>
                <?php endif; ?>
            </tr>

            <?php endif;
        } ?>
       
    </table>
    <!-- <br>
    <br>
    <table  cellspacing="0" cellpadding="0" width="70%">
        <tr>
            <td ><strong>Total Sales </strong><input type="text" disabled="" value="<?php echo $dueAmont + $paidAm . ".00"; ?>"></td>
            <td> <strong>Total Paid </strong> <input type="text" disabled="" value="<?php echo $paidAm . ".00"; ?>"></td>
            <td align="right"> <strong>Total Due </strong> <input type="text" disabled="" value="<?php echo $dueAmont . ".00"; ?>"></td>
            <td></td>
        </tr>
        <tr><td colspan="4">&nbsp;</td></tr> -->
    <!--  <tr>
           <td ></td>
           <td> </td>
           <td align="right"><a class="btn-add fancybox fancybox.ajax" href="<?php echo base_url(); ?>Administrator/customer/customer_due_payment">
               <input type="button" name="country_button" value="Due Payment"  class="button" style="padding:7px 10px;font-size:16px;"/>                                
           </a> </td>
           <td></td>
       </tr> -->
    <!-- </table> -->

</div>
</span>
<!-- <div id="print"></div> -->

<script>
    $('.print').click(function (e) {
        // e.preventDetault();

        var cus_id = $(this).attr('id');

        $.ajax({
            url: '<?= base_url();?>cusDuePrint',
            type: 'POST',
            dataType: 'html',
            data: {searchtype: 'Customer', customerID: cus_id},
            success: function (data) {

                $('body').html(data);
                window.print();
                location.reload();
            }, error: function (error) {

            }
        });
    });
</script>