<link href="<?php echo base_url()?>css/prints.css" rel="stylesheet" />
		<br/>
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
						if(isset($products) && $products){
                        foreach($products as $data){
                    ?>
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
			
	<?php } ?>
