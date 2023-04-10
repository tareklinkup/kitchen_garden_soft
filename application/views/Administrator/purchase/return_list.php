<style type="text/css">
	th{text-align:center;}
</style>

	<table class="border" cellspacing="0" cellpadding="0" width="90%">
        <h4><a style="cursor:pointer" onclick="window.open('<?php echo base_url();?>purchaseReturnlist', 'newwindow', `width=${screen.width}, height=${screen.height}`); return false;"><i class="fa fa-print" style="font-size:24px;color:green"></i> Print</a></h4>
        <tr bgcolor="#fff">
           <td colspan="9" style="text-align:center;font-size:16px;font-style:bold;">Purchase Return List</td>
        </tr>
		
		<tr bgcolor="#ccc">
            <th>Invoice No.</th>
            <th>Date</th>
            <th>Supplier Code</th>
            <th>Supplier Name</th>
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
            $sql = $this->db->query("SELECT tbl_purchasereturn.*,tbl_purchasemaster.*, tbl_supplier.* FROM tbl_purchasereturn left join tbl_purchasemaster on tbl_purchasemaster.PurchaseMaster_InvoiceNo=tbl_purchasereturn.PurchaseMaster_InvoiceNo left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo where tbl_purchasereturn.PurchaseReturn_brunchID='$BRANCHid'");
            $record = $sql->result();
			foreach($record as $record){
				$id = $record->PurchaseReturn_SlNo;
				$psql = $this->db->query("SELECT tbl_purchasereturndetails.*,tbl_product.* FROM tbl_purchasereturndetails left join tbl_product on tbl_product.Product_SlNo=tbl_purchasereturndetails.PurchaseReturnDetailsProduct_SlNo where tbl_purchasereturndetails.PurchaseReturn_SlNo='$id'");
				$record2= $psql->result();
				foreach($record2 as $record2){
					$total = $total+$record2->PurchaseReturnDetails_ReturnAmount;
			?>
		<tr align="center">
            <td><?php echo $record->PurchaseMaster_InvoiceNo; ?></td>
            <td><?php echo $record->PurchaseReturn_ReturnDate; ?></td>
            <td><?php echo $record->Supplier_Code; ?></td>
            <td><?php echo $record->Supplier_Name; ?></td> 
			
			<td><?php echo $record2->Product_Code; ?></td>
            <td><?php echo $record2->Product_Name; ?></td>
			
            <td><?php echo $record2->PurchaseReturnDetails_ReturnQuantity; ?></td>
            <td><?php echo $record2->PurchaseReturnDetails_ReturnAmount; ?></td>
            <td><?php echo $record->PurchaseReturn_Description; ?></td>
        </tr>
        <?php 
				}
		}
		
		}elseif($searchtype == 'Product'){
			 $sql = $this->db->query("SELECT tbl_purchasereturn.*,tbl_purchasemaster.*, tbl_supplier.* FROM tbl_purchasereturn left join tbl_purchasemaster on tbl_purchasemaster.PurchaseMaster_InvoiceNo=tbl_purchasereturn.PurchaseMaster_InvoiceNo left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo where tbl_purchasereturn.PurchaseReturn_brunchID='$BRANCHid'");
			 $record = $sql->result();
			 foreach($record as $record){
                $id = $record->PurchaseReturn_SlNo;
				$psql = $this->db->query("SELECT tbl_purchasereturndetails.*,tbl_product.* FROM tbl_purchasereturndetails left join tbl_product on tbl_product.Product_SlNo=tbl_purchasereturndetails.PurchaseReturnDetailsProduct_SlNo where tbl_purchasereturndetails.PurchaseReturnDetailsProduct_SlNo='$productID' AND tbl_purchasereturndetails.PurchaseReturn_SlNo='$id'");
				$record2= $psql->result();
				foreach($record2 as $record2){
					$total = $total+$record2->PurchaseReturnDetails_ReturnAmount;
			?>
			<tr align="center">
				<td><?php echo $record->PurchaseMaster_InvoiceNo; ?></td>
				<td><?php echo $record->PurchaseReturn_ReturnDate; ?></td>
				<td><?php echo $record->Supplier_Code; ?></td>
				<td><?php echo $record->Supplier_Name; ?></td> 
				
				<td><?php echo $record2->Product_Code; ?></td>
				<td><?php echo $record2->Product_Name; ?></td>
				
				<td><?php echo $record2->PurchaseReturnDetails_ReturnQuantity; ?></td>
				<td><?php echo $record2->PurchaseReturnDetails_ReturnAmount; ?></td>
				<td><?php echo $record->PurchaseReturn_Description; ?></td>
			</tr>
        <?php 
				}
		}
		}elseif($searchtype == 'Date'){ //exit;
			 $sql = $this->db->query("SELECT tbl_purchasereturn.*,tbl_purchasemaster.*, tbl_supplier.* FROM tbl_purchasereturn left join tbl_purchasemaster on tbl_purchasemaster.PurchaseMaster_InvoiceNo=tbl_purchasereturn.PurchaseMaster_InvoiceNo left join tbl_supplier on tbl_supplier.Supplier_SlNo = tbl_purchasemaster.Supplier_SlNo where tbl_purchasereturn.PurchaseReturn_brunchID='$BRANCHid' AND tbl_purchasereturn.PurchaseReturn_ReturnDate between '$startdate' and '$enddate'");
			 $record = $sql->result();
			 
			foreach($record as $record){
				$id = $record->PurchaseReturn_SlNo;
				$psql = $this->db->query("SELECT tbl_purchasereturndetails.*,tbl_product.* FROM tbl_purchasereturndetails left join tbl_product on tbl_product.Product_SlNo=tbl_purchasereturndetails.PurchaseReturnDetailsProduct_SlNo where tbl_purchasereturndetails.PurchaseReturn_SlNo='$id'");
				$record2= $psql->result();
				foreach($record2 as $record2){
					$total = $total+$record2->PurchaseReturnDetails_ReturnAmount;
			?>
		<tr align="center">
            <td><?php echo $record->PurchaseMaster_InvoiceNo; ?></td>
            <td><?php echo $record->PurchaseReturn_ReturnDate; ?></td>
            <td><?php echo $record->Supplier_Code; ?></td>
            <td><?php echo $record->Supplier_Name; ?></td> 
			
			<td><?php echo $record2->Product_Code; ?></td>
            <td><?php echo $record2->Product_Name; ?></td>
			
            <td><?php echo $record2->PurchaseReturnDetails_ReturnQuantity; ?></td>
            <td><?php echo $record2->PurchaseReturnDetails_ReturnAmount; ?></td>
            <td><?php echo $record->PurchaseReturn_Description; ?></td>
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