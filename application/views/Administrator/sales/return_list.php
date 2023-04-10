<style type="text/css">
th{text-align:center;}
</style>

	<table class="border" cellspacing="0" cellpadding="0" width="90%">
        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>salesreturnlist', 'newwindow', `width=${screen.width}, height=${screen.height}, left=0, top=0`); return false;"><i class="fa fa-print" style="font-size:24px;color:green"></i> Print</a></h4>
        <tr bgcolor="#fff">
           <td colspan="9" style="text-align:center;font-size:16px;font-style:bold;">Sales Return List</td>
        </tr>
		
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