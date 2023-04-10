<?php
$brunch=$this->session->userdata('BRANCHid');
?>
<!DOCTYPE html>
<html>
<head>
<title> </title>
<meta charset='utf-8'>
    <link href="<?php echo base_url()?>assets/css/prints.css" rel="stylesheet" />
</head>
<style type="text/css" media="print">
.hide{display:none}

</style>
<script type="text/javascript">
window.onload = async () => {
		await new Promise(resolve => setTimeout(resolve, 1000));
		window.print();
		window.close();
	}
</script>
<body style="background:none;">




      <table width="800px" >
        <tr>
          <td align="right" style="float:left;width:150px;"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org; ?>" alt="Logo" style="width:100px;" /></td>
          <td style="width:650px;">
            <div class="">
        <div style="text-align:center;float:left;" >
        <strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br>
        <?php echo $branch_info->Repot_Heading; ?><br>
              </div>
      </div>
      </td>
        </tr>
    
        <tr>
          <td style="float:right" colspan="center">
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="250px" style="text-align:right;"><strong></td>
              </tr>
          </table>
          </td>
        </tr>
        <tr>
            <td colspan="2"><hr><hr></td>
            <td colspan="2"><br></td>
        </tr>
        <tr>
          <?php
            $Sales_startdate = $this->session->userdata('startdate');
            $Sales_enddate = $this->session->userdata('enddate');
          ?>
            <td colspan="2" style="height:;" align="center"><h1 style="font-size: 20px; font-weight: bold; text-decoration: underline;">Customer Transaction From <b style="color: #6F085C;"><?php echo $Sales_startdate ?></b> To <b style="color: #6F085C;"><?php echo $Sales_enddate ?></b></h1></td>
        </tr>
        <?php $Custid = $this->session->userdata("customerID"); if($Custid != 'All'):?>
            <?php $cusInfo = $this->db->where('Customer_SlNo', $Custid)->get('tbl_customer')->row(); ?>
        <tr> 
           <td style=" font-size: 14px; font-weight: bold;"  colspan="1">
             Customer ID : <?php echo $cusInfo->Customer_Code; ?>
           </td>
           <td style="text-align: right; font-size: 14px; font-weight: bold;">
             Address : <?php echo $cusInfo->Customer_Address; ?>
           </td>
        </tr>
        <tr>
           <td style=" font-size: 14px; font-weight: bold;" colspan="1">
             Customer Name  : <?php echo $cusInfo->Customer_Name; ?>
           </td>
           <td style="text-align: right; font-size: 14px; font-weight: bold;">
             Contact : <?php echo $cusInfo->Customer_Mobile; ?>
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
                  <th>Date fgdgdfg</th>
                  <th>Tr. Description</th>
                  <th>Tr./Invoice No.</th>
                  <?php $Custid = $this->session->userdata("customerID");  if($Custid == 'All'){ ?>
                     <th style="text-align: center;">Customer Info</th>
                  <?php } ?>
                  <th>Total Sale</th>
                  <th>Inv. Discount</th>
                  <th>Inv. Cash</th>
                  <th>Inv. Due</th>
                  <th>Tr. Cash</th>
                  <th>Return</th>
                  <th>Balance</th>
              </tr>

              <?php
                $prevDue =0;
                if($Custid != 'All'):
                $cusIfo = $this->db->where('Customer_SlNo',$Custid)->get('tbl_customer')->row();
                if(isset($cusIfo->previous_due)):
                  $prevDue = $cusIfo->previous_due;
                else:
                   $prevDue = 0;
                endif;
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
              $bal = 0; $sl  = 0;
              foreach($record as $record){ 
                 $sl++;

				  $this->db->select('tbl_salesmaster.*')->select_sum('tbl_saledetails.Discount_amount ', 'pro_dis')->from('tbl_salesmaster');
				  $this->db->join('tbl_saledetails', 'tbl_salesmaster.SaleMaster_SlNo = tbl_saledetails.SaleMaster_IDNo', 'left');
				  $SaleM = $this->db->where('tbl_salesmaster.SaleMaster_InvoiceNo',$record->CPayment_invoice)->get()->row();

                // if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                //     $bal = $SaleM->SaleMaster_DueAmount + $bal;
                // endif;
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
                   ?>
                  </td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                      if($SaleM->SaleMaster_DueAmount == 'NaN' || $SaleM->SaleMaster_DueAmount == '' ):
                        echo "0.00";
                      else:
                        echo number_format($SaleM->SaleMaster_DueAmount,2); 
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
                    else:
                     echo "0.00";
                    endif;
                   ?>
                  </td>
                   <td><?php echo "0.00"; ?></td>
          
                <td  style="text-align: right;">
                  <?php
                    if($sl == 1):
                        if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                          $bal = $SaleM->SaleMaster_DueAmount + $prevDue +  $bal;
                          echo number_format($bal,2);
                          
                        else:
                          if($record->CPayment_TransactionType == 'CP'):
                            echo number_format($bal = $bal + $record->CPayment_amount,2);
                          elseif($record->CPayment_TransactionType == 'CR'):
                            echo number_format($bal = $bal - $record->CPayment_amount,2);
                          endif;
                        endif;

                    else:
                      if(isset($SaleM->SaleMaster_InvoiceNo) == $record->CPayment_invoice):
                          $bal = $SaleM->SaleMaster_DueAmount + $prevDue + $bal;
                        echo number_format($bal,2); 
                        else:
                          if($record->CPayment_TransactionType == 'CP'):
                            $bal = $bal + $record->CPayment_amount;
                            echo number_format($bal,2);
                          elseif($record->CPayment_TransactionType == 'CR'):
                             $bal = $bal - $record->CPayment_amount;
                             echo number_format($bal,2);
                          endif;
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

    <tr height="150">
     <td align="left" width="50%">
      <span style="font-size:11px;">
      <i>"THANK YOU FOR YOUR BUSINESS"</i><br>
        </span>
     </td>
     <td align="right" width="50%">
      <span style="border-top:1px solid #000;">
        Authorize Signature
      </span>
     </td>
    </tr>
       
    </table>
</body>
</html>

