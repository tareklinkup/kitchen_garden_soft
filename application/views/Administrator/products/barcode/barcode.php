<!DOCTYPE html>
<html>
    <head>
        <title>Barcode Generator</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style type="text/css">
		   .article{min-height:90px;max-height:100px;width:20px;float:left;writing-mode: tb-rl;}
		   .content{width:120px;float:left;padding:2px;}
		   .name{height:auto;width:120px;font-size:11px;}
		   .img{height:60px;width:120px;}
		   .pid{height:15px;width:120px;}
		   .price{height:10px;width:120px;}
		   .date{height:90px;width:20px;float:right;writing-mode: tb-rl;}
		   .mytext{height:25px !important;padding: 2px;}
		   
        </style>
        <link type="text/css" rel="stylesheet" href="<?php echo base_url('barcode/style.css'); ?>" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="shortcut icon" href="<?php echo base_url('barcode/favicon.ico'); ?>" />
        <script src="<?php //echo base_url('barcode/jquery-1.7.2.min.js'); ?>"></script>
        <script src="<?php //echo base_url('barcode/barcode.js'); ?>"></script>
		<script type="text/javascript">
          function printpage() {
          // document.getElementById('printButton').style.visibility="hidden";
			  document.getElementById("printButton").style.cssText = "visibility:hidden;height:0px;margin-top:0px"
			  document.getElementById('printButton2').style.visibility="hidden";
			  window.print();
			  document.getElementById('printButton').style.visibility="visible";  
			  location.reload();
          }
       </script>

    </head>
<body class="">
	<div class="container-fluid">
		<div class="row">
		<div class="col-md-12">
		<form class="form-horizontal" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<section class="" id="printButton" style="background:#f4f4f4;height:200px;">
			 <div class="">
				<div class="col-sm-12 text-center">
					<h3 class="text-info">Barcode Generator</h3>
				</div>
			  </div>
		  
			  <div class="form-group">
				<label class="control-label col-sm-2" for="text">Product ID</label>
				<div class="col-sm-2"> 
					<input type="text" name="pID" class="form-control mytext" placeholder="Product ID ..." value="<?php echo $product->Product_Code; ?>" />
				</div>
				
				<label class="control-label col-sm-2" for="text">Product Name</label>
				<div class="col-sm-2"> 
					<input type="text" name="pname" class="form-control mytext" placeholder="Product name ..." value="<?php echo $product->Product_Name; ?>" /> 
				</div>
			  </div>

			  <div class="form-group">
				<label class="control-label col-sm-2" for="Price">Price </label>
				<div class="col-sm-2">
					<input type="text" name="Price" class="form-control mytext" placeholder="Product price ..." value="<?php echo $product->Product_SellingPrice; ?>" />
				</div>
				
				<label class="control-label col-sm-2" for="Price">Article </label>
				<div class="col-sm-2">
					<input type="text" name="article" class="form-control mytext" placeholder="Article ..." />
				</div>
				<div class="col-sm-2">
				   <input type="submit" name="submit" value="Generate" class="btn btn-primary" />
				   <input name="print" type="button" value="Print" id="printButton2" onClick="printpage()" class="btn btn-success" style="width:100px;"/>
				</div>
			  </div>
		  
			  <div class="form-group">
				<label class="control-label col-sm-2" for="qty">Quantity</label>
				<div class="col-sm-2"> 
				  <input type="text" name="qty" class="form-control mytext" placeholder="Product quantity ...">
				</div>
				
				<label  style="display: none;" class="control-label col-sm-2" for="date">Date</label>
				<div class="col-sm-2" style="display: none;"> 
					<input type="date" name="date" class="form-control mytext" />
				</div>
			  </div>
		</section>
		</form>
	</div>
</div>

		<div class="row">
            <div class="output col-md-8 col-md-offset-2">
                <section class="output">
                    <?php 

                    if(isset($_REQUEST['submit'])){
						$PID= $_POST['pID'];
                        $Price = $_POST['Price'];
                        $article = $_POST['article'];
                        $qty = $_POST['qty'];
                        $date = $_POST['date'];
                        $pname = $_POST['pname'];
                        $Price = $_POST['Price'];
                    for ($i=0; $i < $qty; $i++) { 

                    if(isset($kode)): echo $kode; endif;
					?>
						<!-- <div id="imageOutput" style="padding:5px;width:172px;float:left;background:#fff;border:1px #ccc solid;" align="center">	
							  <div class="article"><?php echo $article; ?></div>
							  <div class="content">
								<div class="name"><?php echo $pname; ?></div>
								<div class="img">
									<img src='<?php echo site_url();?>GenerateBarcode/<?php echo $PID;?>' style="height: 1.3cm; width: 2.5cm;"/>
								</div>
								<div class="price"><?php echo $this->session->userdata('Currency_Name') . ' ' . $Price;?></div>
							  </div>
							<div class="date"><?php echo $date; ?></div>
						</div> -->


						<div style="padding: 2px; float: left; height: 102.5px; width: 135px; border: 1px solid #ddd;">
							<div style="width: 135px; text-align: center; float: right;">
								<span class="article" style="font-size: 12px;"><?php echo $article; ?></span>
								<span  style="font-size: 12px; text-align: center;">
								<?php 
								if(strlen($pname)>15){
									echo substr($pname,0,15).' ..'; 
								}
								else{
									echo $pname;
								}								
								?>						
							</span>
								<img src='<?php echo site_url();?>GenerateBarcode/<?php echo $PID;?>' style="height: 50px; width: 100px;" /><br>
								<span style=" margin-top: 5px; text-align: center;"><?php echo $this->session->userdata('Currency_Name') . ' ' . $Price;?></span>
							</div>
						</div>
                    <?php 
						} 
					} 
					?>
                    
						</section>
					</div>
					</div>
				
			</div>
    </body>
</html>

