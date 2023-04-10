<?php
 $product_sql = mysql_query("SELECT * FROM tbl_product WHERE Product_SlNo=$Product_SlNo");
 $row_product = mysql_fetch_array($product_sql)
?>
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
					<input type="text" name="pID" class="form-control mytext" placeholder="Product ID ..." value="<?php echo $row_product['Product_Code']; ?>" />
				</div>
				
				<label class="control-label col-sm-2" for="text">Product Name</label>
				<div class="col-sm-2"> 
					<input type="text" name="pname" class="form-control mytext" placeholder="Product name ..." value="<?php echo $row_product['Product_Name']; ?>" /> 
				</div>
			  </div>

			  <div class="form-group">
				<label class="control-label col-sm-2" for="Price">Price </label>
				<div class="col-sm-2">
					<input type="text" name="Price" class="form-control mytext" placeholder="Product price ..." value="<?php echo $row_product['Product_SellingPrice']; ?>" />
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
				
				<label class="control-label col-sm-2" for="date">Date</label>
				<div class="col-sm-2"> 
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
					?>
						<div id="imageOutput" style="padding:5px;width:172px;float:left;background:#fff;border:1px #ccc solid;" align="center">	
							  <div class="article"><?php echo $article; ?></div>
							  <div class="content">
								<div class="name"><?php echo $pname; ?></div>
								<div class="img">
									<img src='<?php echo site_url();?>Administrator/Products/barcode/<?php echo $PID;?>' height="100%" width="100%"/>
								</div>
								<div class="price"><?php echo $this->session->userdata('Currency_Name') . ' ' . $Price?></div>
							  </div>
							<div class="date"><?php echo $date; ?></div>
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


<script type="text/javascript">
	function Submitdata(){
		var add_country = $('#add_country').val();

		if(add_country ==""){
			$('#msc').html('Required Field').css("color","green");
			return false;
		}
		var succes = "";
		if(succes == ""){
			var inputdata = 'add_country='+add_country;
			//alert(inputdata);
			var urldata = "<?php //echo base_url();?>Administrator/supplier/insert_country/";
			$.ajax({
				type: "POST",
				url: urldata,
				data: inputdata,
				success:function(data){
					$('#success').html('Save Success').css("color","green");
					$('#Search_Results').html(data);
					//alert("ok");
					setTimeout(function() {$.fancybox.close()}, 2000);
				}
			});
		}
	}
</script>