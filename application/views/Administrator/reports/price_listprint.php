<?php
$row = $this->Other_model->get_current_branch_compnay_info();
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
		//window.close();
	}
</script>
<body style="background:none;">

      <table width="100%;" >
         <tr>
		<td style="width:150px;">
			 <img src="<?php echo base_url();?>uploads/company_profile_thum/<?php echo $row->Company_Logo_org; ?>" alt="Logo" style="width:60px; height: 60px; padding-left: 95px; float:right;">
		</td>
		
          <td style="float:left;width:650px;">
            <div class="headline">
				<div style="text-align:center" >
					<strong style="font-size:18px"><?php echo $row->Company_Name; ?></strong><br>
					<?php echo $row->Repot_Heading; ?><br>
				</div>
			</div>
          </td>
        </tr>
		
		<tr>
			<td colspan="2"> 
				
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
            <td colspan="2"> 
				<?php 
	$select_one = $this->session->userdata('select_one');
	if($select_one == 'All') 
	{
	?>
            <table class="border" cellspacing="0" cellpadding="0" width="80%" style="margin: 0 auto;text-align:center;">
                <tbody>
                    
                    <tr bgcolor="#ccc">
                        <th style="text-align: center;">ID</th>
                        <th style="text-align: center;">Product Name</th>
                        <th style="text-align: center;">Brand</th>
                        <th style="text-align: center;"> Avg. Purchase Rate</th>
                        <th style="text-align: center;">Sell Rate</th>
                    </tr>
					<?php
					if(isset($products) && $products){ foreach($products as $data){ ?>
						<tr>
							<td style="text-align: center;"><?php echo $data->Product_Code; ?></td>
							<td style="text-align: center;"><?php echo $data->Product_Name; ?></td>
							<td style="text-align: center;"><?php echo $data->brand_name; ?></td>
							<td style="text-align: center;"><?php echo $data->Product_Purchase_Rate; ?></td>
							<td style="text-align: center;"><?php echo $data->Product_SellingPrice; ?></td>
						</tr>
					<?php } } ?>
                </tbody>
            </table>
			
	<? }else if($select_one == 'Category'){ ?>
	 <table class="border" cellspacing="0" cellpadding="0" width="80%" style="margin: 0 auto;text-align:center;">
                <tbody>
                    <tr>
                        <td colspan="5" align="center"><h2><?php echo $category['ProductCategory_Name'] ?></h2></td>
                    </tr>
                    <tr bgcolor="#ccc">
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Purchase Rate</th>
                        <th>Sell Rate</th>
                    </tr>
					<?php
						$products = $this->Product_model->get_all_product_price_category_wise($category->ProductCategory_SlNo);
						if(isset($products) && $products){
							foreach($products as $product){
					?>
						<tr>
							<td><?php echo $product->Product_Code ?></td>
							<td><?php echo $product->Product_Name ?></td>
							<td><?php echo $product->brand_name ?></td>
							<td><?php echo $product->Product_Purchase_Rate ?></td>
							<td><?php echo $product->Product_SellingPrice ?></td>
						</tr>
					<?php } } ?>
                </tbody>
            </table>
	<? }else if($select_one == 'Product'){ ?>
	 <table class="border" cellspacing="0" cellpadding="0" width="80%" style="margin: 0 auto;text-align:center;">
                <tbody>
                    <tr bgcolor="#ccc">
                        <th  style="text-align: center;">ID</th>
                        <th  style="text-align: center;">Product Name</th>
                        <th  style="text-align: center;">Brand</th>
                        <th  style="text-align: center;">Purchase Rate</th>
                        <th  style="text-align: center;">Sell Rate</th>
                    </tr>
					<?php  if(isset($products) && $products){ foreach($products as $product){ ?>
						<tr>
							<td style="text-align: center;"><?php echo $product->Product_Code; ?></td>
							<td style="text-align: center;"><?php echo $product->Product_Name; ?></td>
							<td style="text-align: center;"><?php echo $product->brand_name; ?></td>
							<td style="text-align: center;"><?php echo $product->Product_Purchase_Rate; ?></td>
							<td style="text-align: center;"><?php echo $product->Product_SellingPrice; ?></td>
						</tr>
					<?php } }?>
                </tbody>
            </table>
	<?php } ?>


			</td>
        </tr>
       
    </table>

<div class="provied">
  <span style="float:left;font-size:11px;">Software Provied By Link-Up Technology</span>
</div>
</body>
</html>
