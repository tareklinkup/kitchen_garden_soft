<style>
    #invoiceTable {
        width: 100%;
        border-collapse: collapse;
    }

    #invoiceTable th,
    #invoiceTable td {
        padding: 3px;
        border: 1px solid #ccc;
    }

    #invoiceTable th {
        text-align: center;
    }

    #invoiceTable thead {
        background-color: #edede7;
    }
</style>

<div id="transferInvoice">
    <div class="row">
        <div class="col-xs-12">
            <a href="" id="printIcon"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2" id="invoiceContent">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <div style="background-color:#ebebeb;padding:3px 15px;font-size:16px;font-weight:bold;">Transfer Invoice</div>
                </div>
            </div>

            <div class="row" style="padding: 15px 0;">
                <div class="col-xs-7">
                    <strong>Transfer Date: </strong> <?php echo $transfer->transfer_date; ?><br>
                    <strong>Transferred by: </strong> <?php echo $transfer->transfer_by_name; ?><br>
                    <strong>Transferred to: </strong> <?php echo $transfer->transfer_to_name; ?><br>
                </div>

                <div class="col-xs-5">
                    <strong>Note: </strong><br>
                    <?php echo $transfer->note; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <table id="invoiceTable">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Category</th>
                                <th>Product Id</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transferDetails as $key => $product) { ?>
                                <tr>
                                    <td style="text-align:right;"><?php echo $key + 1; ?></td>
                                    <td><?php echo $product->ProductCategory_Name; ?></td>
                                    <td><?php echo $product->Product_Code; ?></td>
                                    <td><?php echo $product->Product_Name; ?></td>
                                    <td style="text-align:right;"><?php echo $product->quantity; ?></td>
                                    <td style="text-align:right;"><?php echo $product->total; ?></td>
                                </tr>
                            <?php }; ?>
                            <tr>
                                <td colspan="5" style="text-align:right;">Total</td>
                                <td style="text-align:right;"><?php echo $transfer->total_amount;?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#printIcon').on('click', function(e) {
        let invoiceContent = document.querySelector('#invoiceContent').innerHTML;
        let printWindow = window.open('', 'PRINT', 'width=400,height=500');
        printWindow.document.write(`
            <html>
                <head>
                    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
                    <style>
                        body, table{
                            font-size:12px;
                            font-family: tahoma;
                        }
                    </style>
                </head>
                <body>
                    ${invoiceContent}
                </body>
            </html>
        `);

        let invoiceStyle = `
            <style>
                #invoiceTable {
                    width: 100%;
                    border-collapse: collapse;
                }

                #invoiceTable th, #invoiceTable td {
                    padding: 3px;
                    border: 1px solid #ccc;
                }

                #invoiceTable th {
                    text-align: center;
                }

                #invoiceTable thead{
                    background-color: #edede7;
                }
            </style>
        `;

        printWindow.document.head.innerHTML += invoiceStyle;

        printWindow.focus();
    })
</script>