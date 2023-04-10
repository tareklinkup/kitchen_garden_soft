<script>
    function printContents(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        $('.actions').css('display', 'none');
        window.print();
        location.reload();
        document.body.innerHTML = restorepage;
    }
</script>
<style>
    .ex-btn{
        padding: 1px 10px 1px 10px !important;
        margin-left: -12px !important;
    }
</style>

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form id="ValidateForm" method="POST">
            <input type="hidden" name="addby" value="<?= $this->session->userdata('userId') ?>">
            <div class="form-horizontal">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="Customer_id"> Date </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" name="date" id="date" class="form-control date-picker"
                                   data-date-format="yyyy-mm-dd" reaDOnly value="<?php echo date('Y-m-d'); ?>"/>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-4 control-label" for="cus_name"> Expense Head</label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-5">
                            <select name="exp_head" id="exp_head" required class="chosen-select form-control">
                                <option value="">Select Expense Head</option>
                                <?php foreach ($ExpHead as $head): ?>
                                    <option value="<?= $head->id ?>"> <?= $head->head_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-1">

                            <a href="<?= base_url('expenseHeadFancyBox') ?>"
                                class="fancybox fancybox.ajax">
                                <input
                                        type="button"
                                        name="expence"
                                        value="+"
                                        class="btn btn-primary btn-xs ex-btn"
                                >
                            </a>

                        </div>
                    </div>
                </div>


                <div class="col-sm-6">

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for=""> Amount </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <input type="text" id="amount" required name="amount" value="0" placeholder="Enter Amount"
                                   class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for=""> Remarks </label>
                        <label class="col-sm-1 control-label">:</label>
                        <div class="col-sm-6">
                            <textarea placeholder="Enter Remarks" name="remarks" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-4 control-label" for=""> </label>
                        <label class="col-sm-1 control-label"></label>
                        <div class="col-sm-6">
                            <button type="button" onclick="InsertBill()" name="btnSubmit" title="Save"
                                    class="btn btn-sm btn-success pull-left">
                                Save
                                <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="row" style="padding-top: 15px; margin-top: 15px; border-top: 2px solid #2ca980;">
    <div class="col-xs-2">
        <select name="search_type" id="search_type" class="chosen-select form-control">
            <option value="All">Select Expense Head</option>
            <?php foreach ($ExpHead as $head): ?>
                <option value="<?= $head->id ?>"> <?= $head->head_name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-xs-2">
        <div class="input-group">
            <input class="form-control date-picker" id="sDate" type="text" data-date-format="yyyy-mm-dd"
                   style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>"/>
            <span class="input-group-addon"
                  style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
				<i class="fa fa-calendar bigger-110"></i>
			</span>
        </div>
    </div>

    <div class="col-xs-2">
        <div class="input-group">
            <input class="form-control date-picker" id="eDate" type="text" data-date-format="yyyy-mm-dd"
                   style="border-radius: 5px 0px 0px 5px !important;" value="<?php echo date("Y-m-d") ?>"/>
            <span class="input-group-addon"
                  style="border-radius: 0px 4px 4px 0px !important;padding: 4px 6px 4px  !important;">
				<i class="fa fa-calendar bigger-110"></i>
			</span>
        </div>
    </div>
    <div class="col-xs-2" style="margin-bottom: 10px;">
        <button style="padding: 0px 10px;" type="button" onclick="searchDoSales()"
                class="btn btn-sm btn-primary pull-left">Search
            <i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
        </button>
    </div>
    <div class="col-xs-1">
        <a style="cursor:pointer; float: left;" onclick="printContents('printPage')"> <i class="fa fa-print"
                                                                                         style="font-size:20px;color:green"></i>
            Print</a>
    </div>
    <div class="col-xs-12">
        <div id="printPage">
            <div class="table-header">
                Bill Information
            </div>

            <!-- div.table-responsive -->
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th>SL.</th>
                    <th>Date</th>
                    <th>Expense Head</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th class="actions">Action</th>
                </tr>
                </thead>

                <tbody id="showResult">
                <?php $i = 1;
                if (!empty($getData)):
                    foreach ($getData as $row): ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td><?= $row->date; ?></td>
                            <td><?= $row->head_name; ?></td>
                            <td><?= $row->amount; ?></td>
                            <td><?= $row->remarks; ?></td>
                            <td class="actions">
                                <div class="hidden-sm hidden-xs action-buttons">
                                    <a class="green fancybox fancybox.ajax"
                                       href="<?php echo base_url() ?>BillEntry/edit/<?= $row->id; ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>

                                    <a class="red" href="#" onclick="deleted(<?= $row->id; ?>)">
                                        <i class="ace-icon fa fa-trash-o bigger-130"></i>
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


<script type="text/javascript">
    function searchDoSales() {
        var stype = $("#search_type").val();
        var sDate = $("#sDate").val();
        var eDate = $("#eDate").val();
        $.ajax({
            type: "POST",
            url: "<?= base_url();?>BillEntry/search",
            data: {stype: stype, sDate: sDate, eDate: eDate},
            dataType: "HTML",
            success: function (data) {
                $("#showResult").html(data);
            }
        });

    }

    function InsertBill() {
        var isvalid = validationCheck();
        if (isvalid) {
            $.ajax({
                type: "POST",
                url: "<?= base_url();?>BillEntry/store",
                data: $("#ValidateForm").serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.successMsg) {
                        alert(data.successMsg);
                    }
                    if (data.errorMsg) {
                        alert(data.errorMsg);
                    }
                    location.reload();
                }
            });
        }
    }

    function deleted(id) {
        var confirmation = confirm("are you sure you want to delete this ?");
        if (confirmation) {
            $.ajax({
                type: "POST",
                url: "<?= base_url();?>BillEntry/delete/" + id,
                dataType: "JSON",
                success: function (data) {
                    if (data.successMsg) {
                        alert(data.successMsg);
                    }
                    if (data.errorMsg) {
                        alert(data.errorMsg);
                    }
                    location.reload();
                }
            });
        }
    }


    function getExpanceHeads() {
        $("#exp_head").empty();
        $("#exp_head").append('<option value="">Select Expense Head<option/>');
        $.ajax({
            type: "get",
            url: "<?= base_url('expenseHeadAll');?>",
            dataType: "JSON",
            success:function(data){
                $.each(data,function (key,val) {
                    $("#exp_head").append('<option value="'+val.id+'">'+val.head_name+'<option/>');
                });
                $('.chosen-select').trigger('chosen:updated');
                setTimeout(function() {$.fancybox.close()}, 1000);

            }
        });
    }
</script>