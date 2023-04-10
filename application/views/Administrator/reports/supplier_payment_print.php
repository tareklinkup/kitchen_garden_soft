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
                  <th>Total Sale</th>
                  <th>Inv. Cash</th>
                  <th>Tr. Cash</th>
                  <th>Return</th>
                  <th>Inv. Due</th>
                  <th>Balance</th>
              </tr>
              <?php
              $bal = 0;
              foreach($record as $record){

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
                      echo "Sales";

                      elseif($record->SPayment_TransactionType == 'CP'):
                          echo "Cash Payment";

                      elseif($record->SPayment_TransactionType == 'CR'):
                          echo "Cash Receive";

                      endif;
                    ?>
                    </td>
                  <td><?php echo $record->SPayment_invoice; ?></td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->SPayment_invoice):
                        echo number_format($PurchaseM->PurchaseMaster_TotalAmount).".00"; 
                    else:
                     echo "0.00";
                    endif;
                   ?>
                     
                  </td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->SPayment_invoice):
                        echo number_format($PurchaseM->PurchaseMaster_PaidAmount).".00"; 
                    else:
                     echo "0.00";
                    endif;
                   ?>
                  </td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($PurchaseM->PurchaseMaster_InvoiceNo) != $record->SPayment_invoice):
                        echo number_format($record->SPayment_amount).".00"; 
                    else:
                     echo "0.00";
                    endif;
                   ?>
                  </td>
                  <td><?php echo "0.00"; ?></td>
                  <td style="text-align: right;">
                    <?php
                    if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->SPayment_invoice):
                        echo number_format($PurchaseM->PurchaseMaster_DueAmount).".00"; 
                    else:
                     echo "0.00";
                    endif;
                   ?>
                  </td>
                  <td  style="text-align: right;">
                    <?php
                        if(isset($PurchaseM->PurchaseMaster_InvoiceNo) == $record->SPayment_invoice):
                          $bal = $PurchaseM->PurchaseMaster_DueAmount + $bal;
                        echo number_format($bal).".00"; 
                        else:
                          if($record->SPayment_TransactionType == 'CP'):
                            echo $bal = $bal + $record->SPayment_amount;
                          elseif($record->SPayment_TransactionType == 'CR'):
                            echo $bal = $bal - $record->SPayment_amount;
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
        Software Provied By Link-Up Technology</span>
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

