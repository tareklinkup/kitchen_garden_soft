
<div class="content_scroll">

    <table class="border" cellspacing="0" cellpadding="0" width="100%">

        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>supplierPaymentPrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a></h4>
       
        <tr>
          <?php
            $Purchase_startdate = $this->session->userdata('Purchase_startdate');
            $Purchase_enddate = $this->session->userdata('Purchase_enddate');
          ?>
            <td colspan="2" style="height:;" align="center"><h1 style="font-size: 20px; font-weight: bold; text-decoration: underline;">Supplier Transaction From <b style="color: #6F085C;"><?php echo $Purchase_startdate ?></b> To <b style="color: #6F085C;"><?php echo $Purchase_enddate ?></b></h1></td>
        </tr>
        <tr>
           <td style=" font-size: 14px; font-weight: bold;"  colspan="1">
             Supplier ID : <?php if(isset($recordss->Supplier_Code)): echo $recordss->Supplier_Code; endif; ?>
           </td>
           <td style="text-align: right; font-size: 14px; font-weight: bold;">
             Address : <?php if(isset($recordss->Supplier_Address)): echo $recordss->Supplier_Address; endif;?>
           </td>
        </tr>
        <tr>
           <td style=" font-size: 14px; font-weight: bold;" colspan="1">
             Supplier Name  : <?php if(isset($recordss->Supplier_Name)): echo $recordss->Supplier_Name; endif; ?>
           </td>
           <td style="text-align: right; font-size: 14px; font-weight: bold;">
             Contact : <?php if(isset($recordss->Supplier_Mobile)): echo $recordss->Supplier_Mobile; endif; ?>
           </td>
        </tr>
        <!-- <tr>
           <td colspan="1">
           </td>
           <td style="text-align: right; font-size: 14px; font-weight: bold;">
             Previous Due : <?php //echo  ?> 
           </td>
        </tr> -->
        <!-- <tr>
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Customer Payment</h2></td>
        </tr> -->
        <tr>
            <td colspan="2">
            <!-- Page Body -->
          
              <table class="border" cellspacing="0" cellpadding="0" width="100%" >
                <tr>
                  <th>Date</th>
                  <th>Tr. Description</th>
                  <th>Tr./Invoice No.</th>
                  <th>Total Purchase</th>
                  <th>Inv. Cash</th>
                  <th>Tr. Cash</th>
                  <th>Return</th>
                  <th>Inv. Due</th>
                  <th>Balance</th>
              </tr>

               <?php
                $prevDue =0;
                $Suppid = $this->session->userdata("Supplierid");
                $suppID = $this->db->where('Supplier_SlNo',$Suppid)->get('tbl_supplier')->row();
                $prevDue = $due->dueAmount;
                ?>
                <tr>
                  <td style="text-align: center;">
                    <?php
                    $date = new DateTime($suppID->AddTime);
                    echo $date->format('Y-m-d');
                    ?>
                  </td>
                  <td style="text-align: center;">Supplier Prev. Due</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td align="right"><?php echo number_format($prevDue,2); ?></td>
                  <td align="right"><?php echo number_format($prevDue,2); ?></td>
                </tr>



              <?php
              $bal = 0;
              foreach($record as $key=>$record){

                $PurchaseM = $this->db->where('PurchaseMaster_InvoiceNo',$record->SPayment_invoice)->get('tbl_purchasemaster')->row();

                // if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->CPayment_invoice):
                //     $bal = $PurchaseM->PurchaseMaster_DueAmount + $bal;
                // endif;
              ?>
              <tr align="center">
                  <td><?php echo $record->SPayment_date; ?></td>
                  <td>
                    <?php
                      if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->SPayment_invoice):
                      echo "Purchase";

                      elseif($record->SPayment_TransactionType == 'CR'):
                          echo "Cash Payment";

                      elseif($record->SPayment_TransactionType == 'CP'):
                          echo "Cash Receive";

                      endif;
                    ?>
                    </td>
                  <td><?php echo $record->SPayment_invoice; ?></td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->SPayment_invoice):
                        echo number_format($PurchaseM->PurchaseMaster_TotalAmount,2); 
                    else:
                     echo "0.00";
                    endif;
                   ?>
                     
                  </td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->SPayment_invoice):
                        echo number_format($PurchaseM->PurchaseMaster_PaidAmount,2); 
                    else:
                     echo "0.00";
                    endif;
                   ?>
                  </td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($PurchaseM->PurchaseMaster_InvoiceNo) != $record->SPayment_invoice):
                        echo number_format($record->SPayment_amount,2); 
                    else:
                     echo "0.00";
                    endif;
                   ?>
                  </td>
                  <td><?php echo "0.00"; ?></td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->SPayment_invoice):
                        echo number_format($PurchaseM->PurchaseMaster_DueAmount,2); 
                    else:
                     echo "0.00";
                    endif;
                   ?>
                  </td>
                  <td  style="text-align: right;">
                    <?php
                        if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->SPayment_invoice):
                          if($key == 0){
                            $bal = $PurchaseM->PurchaseMaster_DueAmount + $prevDue + $bal;
                          } else {
                            $bal = $PurchaseM->PurchaseMaster_DueAmount + $bal;
                          }
                        echo number_format($bal,2); 
                        else:
                          if($record->SPayment_TransactionType == 'CP'):
                            $bal = $bal + $record->SPayment_amount;
                            echo number_format($bal,2);
                          elseif($record->SPayment_TransactionType == 'CR'):
                             $bal = $bal- $record->SPayment_amount;
                             echo number_format($bal,2);
                          endif;
                        endif;
                    ?>
                      
                    </td>
              </tr>
              <?php } ?>

              </table>
            </td>
            
            <!-- Page Body end -->
        </tr>
       
    </table>

</div>