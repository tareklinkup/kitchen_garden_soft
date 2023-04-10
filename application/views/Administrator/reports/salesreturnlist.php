<?php
	$searchtype = $this->session->userdata('searchtype');
	$productID = $this->session->userdata('productID');
	$startdate = $this->session->userdata('startdate');
	$enddate = $this->session->userdata('enddate');
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
th{text-align:center;}
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
          <td align="left" width="150"><img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $branch_info->Company_Logo_org;; ?>" alt="Logo" style="width:100px;" /></td>
          <td width="650">
		       <p style="text-align:center;">
				<strong style="font-size:18px;"><?php echo $branch_info->Company_Name; ?></strong><br/>
				<?php echo $branch_info->Repot_Heading; ?><br/>
				</p>
          </td>
        </tr>
		
        <tr>
          <td style="float:right" colspan="2">
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
            <td colspan="2" style="background:#ddd;" align="center"><h2 >Sales Return List</h2></td>
        </tr>
        <tr>
            <td colspan="2">
            <!-- Page Body -->
          
              <table class="border" cellspacing="0" cellpadding="0" width="100%">
          
		<tr bgcolor="#ccc">
            <th>Invoice No.</th>
            <th>Date</th>
            <th>Customer Code</th>
            <th>Customer Name</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Return Qty</th>
            <th>Return Amount</th>
            <th>Notes</th>
        </tr>
        <?php 
			$total = "";
			$BRANCHid = $this->session->userdata("BRANCHid");
			if($searchtype == 'All'){
            $sql = $this->db->query("SELECT tbl_salereturn.*,tbl_salesmaster.*,tbl_customer.* FROM tbl_salereturn left join tbl_salesmaster on tbl_salesmaster.SaleMaster_InvoiceNo=tbl_salereturn.SaleMaster_InvoiceNo left join tbl_customer on tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo where tbl_salereturn.SaleReturn_brunchId='$BRANCHid'");
            $record = $sql->result();
			//echo "<pre>";print_r($record);exit;
			foreach($record as $record){
				$id = $record->SaleReturn_SlNo;
				$psql = $this->db->query("SELECT tbl_salereturndetails.*,tbl_product.* FROM tbl_salereturndetails left join tbl_product on tbl_product.Product_SlNo=tbl_salereturndetails.SaleReturnDetailsProduct_SlNo where tbl_salereturndetails.SaleReturn_IdNo='$id'");
				$record2= $psql->result();
				foreach($record2 as $record2){
					$total = $total+$record2->SaleReturnDetails_ReturnAmount;
			?>
		<tr align="center">
            <td><?php echo $record->SaleMaster_InvoiceNo; ?></td>
            <td><?php echo $record->SaleReturn_ReturnDate; ?></td>
            <td><?php echo $record->Customer_Code; ?></td>
            <td><?php echo $record->Customer_Name; ?></td> 
			
			<td><?php echo $record2->Product_Code; ?></td>
            <td><?php echo $record2->Product_Name; ?></td>
			
            <td><?php echo $record2->SaleReturnDetails_ReturnQuantity; ?></td>
            <td><?php echo $record2->SaleReturnDetails_ReturnAmount; ?></td>
            <td><?php echo $record->SaleReturn_Description; ?></td>
        </tr>
        <?php 
				}
		}
		
		}elseif($searchtype == 'Product'){
			 $sql = $this->db->query("SELECT tbl_salereturn.*,tbl_salesmaster.*,tbl_customer.* FROM tbl_salereturn left join tbl_salesmaster on tbl_salesmaster.SaleMaster_InvoiceNo=tbl_salereturn.SaleMaster_InvoiceNo left join tbl_customer on tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo where tbl_salereturn.SaleReturn_brunchId='$BRANCHid'");
			 $record = $sql->result();
			 foreach($record as $record){
                $id = $record->SaleReturn_SlNo;
				$psql = $this->db->query("SELECT tbl_salereturndetails.*,tbl_product.* FROM tbl_salereturndetails left join tbl_product on tbl_product.Product_SlNo=tbl_salereturndetails.SaleReturnDetailsProduct_SlNo where tbl_salereturndetails.SaleReturnDetailsProduct_SlNo='$productID' AND tbl_salereturndetails.SaleReturn_IdNo='$id'");
				$record2= $psql->result();
				foreach($record2 as $record2){
				$total = $total+$record2->SaleReturnDetails_ReturnAmount;
			?>
			<tr align="center">
				<td><?php echo $record->SaleMaster_InvoiceNo; ?></td>
				<td><?php echo $record->SaleReturn_ReturnDate; ?></td>
				<td><?php echo $record->Customer_Code; ?></td>
				<td><?php echo $record->Customer_Name; ?></td> 
				
				<td><?php echo $record2->Product_Code; ?></td>
				<td><?php echo $record2->Product_Name; ?></td>
				
				<td><?php echo $record2->SaleReturnDetails_ReturnQuantity; ?></td>
				<td><?php echo $record2->SaleReturnDetails_ReturnAmount; ?></td>
				<td><?php echo $record->SaleReturn_Description; ?></td>
			</tr>
        <?php 
				}
		}
		}elseif($searchtype == 'Date'){ //exit;
			$sql = $this->db->query("SELECT tbl_salereturn.*,tbl_salesmaster.*,tbl_customer.* FROM tbl_salereturn left join tbl_salesmaster on tbl_salesmaster.SaleMaster_InvoiceNo=tbl_salereturn.SaleMaster_InvoiceNo left join tbl_customer on tbl_customer.Customer_SlNo = tbl_salesmaster.SalseCustomer_IDNo where tbl_salereturn.SaleReturn_brunchId='$BRANCHid' AND tbl_salereturn.SaleReturn_ReturnDate between '$startdate' and '$enddate'");
            $record = $sql->result();
			 foreach($record as $record){
				$id = $record->SaleReturn_SlNo;
				$psql = $this->db->query("SELECT tbl_salereturndetails.*,tbl_product.* FROM tbl_salereturndetails left join tbl_product on tbl_product.Product_SlNo=tbl_salereturndetails.SaleReturnDetailsProduct_SlNo where tbl_salereturndetails.SaleReturn_IdNo='$id'");
				$record2= $psql->result();
				foreach($record2 as $record2){
				$total = $total+$record2->SaleReturnDetails_ReturnAmount;
			?>
			<tr align="center">
				<td><?php echo $record->SaleMaster_InvoiceNo; ?></td>
				<td><?php echo $record->SaleReturn_ReturnDate; ?></td>
				<td><?php echo $record->Customer_Code; ?></td>
				<td><?php echo $record->Customer_Name; ?></td> 
				
				<td><?php echo $record2->Product_Code; ?></td>
				<td><?php echo $record2->Product_Name; ?></td>
				
				<td><?php echo $record2->SaleReturnDetails_ReturnQuantity; ?></td>
				<td><?php echo $record2->SaleReturnDetails_ReturnAmount; ?></td>
				<td><?php echo $record->SaleReturn_Description; ?></td>
			</tr>
        <?php 
				}
			}
		}
		?>
        <tr>
            <td colspan="7" align="right"><strong>Total </strong></td>
            <td align="center"><strong><?php echo $total; ?></strong></td>
            <td></td>
        </tr>
       
    </table>
            </td>
            
            <!-- Page Body end -->
       
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

