<div class="content_scroll">

    <table class="border" cellspacing="0" cellpadding="0" width="100%">

        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>customerPaymentReportPrint', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:20px;color:green"></i> Print</a></h4>
       
        <tr>
          <?php
            $Sales_startdate = $this->session->userdata('startdate');
            $Sales_enddate = $this->session->userdata('enddate');
          ?>
            <td colspan="2" style="height:;" align="center"><h1 style="font-size: 20px; font-weight: bold; text-decoration: underline;">Customer Transaction From <b style="color: #6F085C;"><?php echo $Sales_startdate ?></b> To <b style="color: #6F085C;"><?php echo $Sales_enddate ?></b></h1></td>
        </tr>
        <?php $Custid = $this->session->userdata("customerID");  if($Custid != 'All'): ?>
        <tr>
            <?php $cusInfo = $this->db->where('Customer_SlNo', $Custid)->get('tbl_customer')->row(); ?>
           <td style=" font-size: 14px; font-weight: bold;"  colspan="1">
             Customer ID : <?php if(isset($cusInfo->Customer_Code)): echo $cusInfo->Customer_Code; endif; ?>
           </td>
           <td style="text-align: right; font-size: 14px; font-weight: bold;">
             Address : <?php if(isset($cusInfo->Customer_Address)): echo $cusInfo->Customer_Address; endif;?>
           </td>
        </tr>
        <tr>
           <td style=" font-size: 14px; font-weight: bold;" colspan="1">
             Customer Name  : <?php if(isset($cusInfo->Customer_Name)): echo $cusInfo->Customer_Name; endif; ?>
           </td>
           <td style="text-align: right; font-size: 14px; font-weight: bold;">
             Contact : <?php if(isset($cusInfo->Customer_Mobile)): echo $cusInfo->Customer_Mobile; endif; ?>
           </td>
        </tr>
      <?php endif; ?>
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
                  <th style="text-align: center;">Date</th>
                  <th style="text-align: center;">Tr.Type- Description</th>
                  <th style="text-align: center;">Tr./Invoice No.</th>
                  <?php  if($Custid == 'All'){ ?>
                  <th style="text-align: center;">Customer Info</th>
                  <?php } ?>
                  <th style="text-align: right;">Total Sale</th>
                  <th style="text-align: right;">Inv. Discount</th>
                  <th style="text-align: right;">Inv. Cash</th>
                  <th style="text-align: right;">Inv. Due</th>
                  <th style="text-align: right;">Tr. Cash</th>
                  <th style="text-align: right;">Return</th>
                  <?php if($Custid != 'All'){ ?>
                  <th style="text-align: right;">Balance</th>
                  <?php }?>
              </tr>


              <?php
                $prevDue =0;
                $tSale = $tDis = $tInCash = $tDue = $tTrcash = 0;
              if($Custid != 'All'):
                
                $cusIfo = $this->db->where('Customer_SlNo',$Custid)->get('tbl_customer')->row();
                $prevDue = $due->dueAmount;
              ?>
              <tr>
                <td style="text-align: center;">
                  <?php
                  $date = new DateTime($cusIfo->AddTime);
                  echo $date->format('Y-m-d');
                  ?>
                </td>
                <td style="text-align: center;">Customer Prev. Due</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right"><?php echo number_format($prevDue,2); ?></td>
                <td></td>
                <td></td>
                <td align="right"><?php echo number_format($prevDue,2); ?></td>
              </tr>

              <?php
                endif;
              $bal=$prevDue; $sl=0; $prevDue=0;
              foreach($record as $record){ 
                // if($record->CPayment_TransactionType =='RP'){
                //   continue;
                // }
                 $sl++;
                $this->db->select('tbl_salesmaster.*')->select_sum('tbl_saledetails.Discount_amount ', 'pro_dis')->from('tbl_salesmaster');
                $this->db->join('tbl_saledetails', 'tbl_salesmaster.SaleMaster_SlNo = tbl_saledetails.SaleMaster_IDNo', 'left');
                $SaleM = $this->db->where('tbl_salesmaster.SaleMaster_InvoiceNo',$record->CPayment_invoice)->get()->row();

              ?>




              <tr align="center">
                  <td><?php echo $record->CPayment_date; ?></td>
                  <td>
                    <?php
                      if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                      echo "Sales";

                      elseif($record->CPayment_TransactionType == 'CP'):
                          echo "Cash Payment";

                      elseif($record->CPayment_TransactionType == 'CR'):
                          echo "Cash Receive";

                      endif;
                      if($record->CPayment_notes != ''){
                        echo '-'.$record->CPayment_notes;
                      }
                      
                    ?>
                    </td>
                  <td><?php echo $record->CPayment_invoice; ?></td>
                    <?php if($Custid == 'All'){ ?>
                  <td><?php echo $record->Customer_Name.'-'.$record->Customer_Code; ?></td>
                    <?php }?>
                  <td style="text-align: right;">
                    <?php
                    if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                      if($SaleM->SaleMaster_TotalSaleAmount == 'NaN'  || $SaleM->SaleMaster_TotalSaleAmount == ''):
                        echo "0.00";
                      else:
                        echo number_format($SaleM->SaleMaster_TotalSaleAmount,2); 
                      endif;
                    else:
                     echo "0.00";
                    endif;
                    $tSale += $SaleM->SaleMaster_TotalSaleAmount;
                   ?>
                     
                  </td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                      $sm_dis = 0;
                      if($SaleM->SaleMaster_TotalDiscountAmount != 'NaN' || $SaleM->SaleMaster_TotalDiscountAmount != '')
                      {
                        $sm_dis = $SaleM->SaleMaster_TotalDiscountAmount;
                      }

                      echo number_format($sm_dis + $SaleM->pro_dis,2);
                    $tDis += ($sm_dis + $SaleM->pro_dis);
                    else:
                      echo "0.00";
                    endif;
                    
                    ?>

                  </td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                      if($SaleM->SaleMaster_PaidAmount == 'NaN' || $SaleM->SaleMaster_PaidAmount == '' ):
                        echo "0.00";
                      else:
                        echo number_format($SaleM->SaleMaster_PaidAmount,2); 
                      endif;
                    else:
                     echo "0.00";
                    endif;
                    $tInCash += $SaleM->SaleMaster_PaidAmount;
                   ?>
                  </td>
                  
                  <td style="text-align: right;">
                    <?php
                    if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                      if($SaleM->SaleMaster_DueAmount == 'NaN' || $SaleM->SaleMaster_DueAmount == '' ):
                        echo "0.00";
                      else:
                        echo number_format($SaleM->SaleMaster_DueAmount,2); 
                        $tDue += $SaleM->SaleMaster_DueAmount;
                      endif; 
                    else:
                     echo "0.00";
                    endif;
                    
                   ?>
                  </td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($SaleM->SaleMaster_InvoiceNo) != $record->CPayment_invoice):
                        echo number_format($record->CPayment_amount,2);
                        $tTrcash += $record->CPayment_amount;
                    else:
                     echo "0.00";
                    endif;

                   ?>
                  </td>
                  <td><?php echo "0.00"; ?></td>
                  
                <?php if($Custid != 'All'){ ?>
                <td  style="text-align: right;">
                  <?php

                      if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                          $bal = $bal+ $SaleM->SaleMaster_DueAmount;
                      elseif($record->CPayment_TransactionType == 'CP'):
                          $bal = $bal + $record->CPayment_amount;
                      elseif($record->CPayment_TransactionType == 'CR'):
                          $bal = $bal - $record->CPayment_amount;
                      endif;
                    echo number_format($bal,2);
                  ?>
                    
                  </td>
                  <?php }?>
              </tr>
              <?php } ?>
              <?php if($Custid == 'All'){ ?>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: 800;">
                  Total =
                </td>
                <td style="text-align: right; font-weight: 800;"><?= number_format($tSale,2);?></td>
                <td style="text-align: right; font-weight: 800;"><?= number_format($tDis,2);?></td>
                <td style="text-align: right; font-weight: 800;"><?= number_format($tInCash,2);?></td>
                <td style="text-align: right; font-weight: 800;"><?= number_format($tDue,2);?></td>
                <td style="text-align: right; font-weight: 800;"><?= number_format($tTrcash,2);?></td>
                <td style="text-align: right; font-weight: 800;">00.00</td>
              </tr>
                <?php }?>
              </table>
            </td>
            
            <!-- Page Body end -->
        </tr>
       
    </table>

</div>
