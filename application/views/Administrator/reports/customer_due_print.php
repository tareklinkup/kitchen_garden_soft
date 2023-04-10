<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset='utf-8'>
    <link href="<?php echo base_url() ?>assets/css/prints.css" rel="stylesheet"/>
</head>
<style type="text/css" media="print">
    .hide {
        display: none
    }

</style>
<script type="text/javascript">
    function printpage() {
        document.getElementById('printButton').style.visibility = "hidden";
        window.print();
        document.getElementById('printButton').style.visibility = "visible";
    }
</script>
<body style="background:none;">


<table width="800px">
    <tr>
        <td align="right" width="150"><img
                    src="<?php echo base_url(); ?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>"
                    alt="Logo" style="width:100px;"/></td>
        <td align="center" width="650">
            <strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
            <?php echo $branch_info->Repot_Heading; ?><br/>
        </td>
    </tr>

    <tr>
        <td style="float:right">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="250px" style="text-align:right;"><strong></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <hr>
            <hr>
        </td>
        <td colspan="2"><br></td>
    </tr>
    <tr>
        <td colspan="2" style="background:#ddd;" align="center"><h2>Customer Due</h2></td>
    </tr>
    <tr>
        <td colspan="2">
            <!-- Page Body -->

            <table class="border" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <th>Customer ID</th>
                    <th>Customer Name</th>
                    <th>Phone No.</th>
                    <th>Last Pay. Date</th>
                    <th>Last Pay. Amount</th>
                    <?php if ($this->session->userdata('searchtype') == 'Customer'): ?>
                        <th>Due</th>
                        <th>Prv. Due</th>
                    <?php endif; ?>
                    <th>Total Due</th>
                </tr>
                <?php
                $totalpurchase = "";
                $Totalpaid = "";
                $due = "";
                foreach ($record as $record) {
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

                            <!-- <td><a class="btn-add linka fancybox fancybox.ajax" href="<?php echo base_url(); ?>Administrator/customer/customer_due_payment/<?php echo $record->SalseCustomer_IDNo; ?>">
                        <input type="button" name="country_button" value="Due Payment"  class="btn btn-info" style="font-size:12px;border: 0px solid #FFF;margin-top: 0px;letter-spacing:1px;"/>
                    </a></td> -->
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

</table>

<div class="provied">

      <span style="float:left;font-size:11px;">
    <i>"THANK YOU FOR YOUR BUSINESS"</i><br>
      </span>
</div>
<div class="signature">
    <span style="border-top:1px solid #000;">
      Authorize Signature
    </span>
</div>
</body>
</html>

