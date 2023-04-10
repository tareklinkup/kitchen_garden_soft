<!DOCTYPE html>
<html>

<head>
    <title> </title>
    <meta charset='utf-8'>
    <link href="<?php echo base_url()?>assets/css/prints.css" rel="stylesheet" />
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
    <input name="print" type="button" value="Print" id="printButton" onClick="printpage()">

    <table width="900px" align="center" style="margin-bottom:200px">
        <tr>
            <td align="right" width="150"><img
                    src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>"
                    alt="Logo" style="width:100px;" /></td>
            <td align="left" width="750">
                <div class="">
                    <div style="text-align:center;">
                        <strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br>
                        <?php echo $branch_info->Repot_Heading; ?><br>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <table class="border" cellspacing="0" cellpadding="0" style="text-align:center;width:100%;">
                    <thead>
                        <tr class="header">
                            <th style="width:5%; text-align:center !important;">SL No</th>
                            <th style="width:20%; text-align:center !important;">Material Name</th>
                            <th style="width:15%; text-align:center !important;">Category</th>
                            <th style="width:13%; text-align:center !important;">Purchase Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($materials as $key=>$material){?>
                        <tr>
                            <td style="width:5%;"><?php echo $key + 1; ?></td>
                            <td style="width:20%;"><?php echo $material->name; ?></td>
                            <td style="width:15%;"><?php echo $material->category_name; ?></td>
                            <td style="width:13%;"><?php echo $material->purchase_rate; ?></td>
                        </tr>
                        <?php };?>
                    </tbody>
                </table>
            </td>
        </tr>

    </table>

    <div class="provied">
        <span style="float:left;font-size:11px;">Software Provied By Link-Up Technology</span>
    </div>
</body>

</html>