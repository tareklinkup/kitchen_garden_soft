<style type="text/css">
	.header{
		border-bottom: 1px double #e86100;
		width: 100%;
		height: 60px;
		margin-top: 0px;
	}
	.header h3{
		margin-top: 0;
		margin-bottom: 5px;
		font-size: 40px;
		font-weight: bold;
		font-style: italic;
		text-align: center;
		color: #a30bf1;
	}
	.img{
		height: 120px;
		margin-top: 0px;
		/*border: 1px solid;*/
	}
	.section3{
		/*border: 1px solid;*/
		height: 130px;
	}
	.section4{
		height: 130px;
		margin-bottom: 15px;
		/* z-index: -1; */
	}
	.section12{
		height: 110px;
		width: 100%;
		margin-top: 5px;
		border-radius: 5px;
	}
	.section12 .logo{
		/*border: 1px solid;*/
		height: 30px;
		width: 100%;
		font-size: 40px;
		text-align: center;
		margin-top: 5px;
	}
	.section12 .textModule{
		height: auto;
		width: 100%;
		margin-top: 20px;
		font-weight: bold;
		font-size: 14px;
		color: #000;
		text-align: center;
	}
	.section122{
		height: 130px;
		width: 100%;
		margin-top: 5px;
		border-radius: 5px;
		background-color: #A7ECFB;
		border: 1px solid #ccc;
	}
	.section122 .logo{
		/*border: 1px solid;*/
		height: 75px;
		width: 100%;
		font-size: 60px;
		text-align: center;
		margin-top: 5px;
	}
	.section122 .textModule{
		height: auto;
		width: 100%;
		margin-top: 15px;
		font-weight: bold;
		font-size: 17px;
		color: #000;
		text-align: center;
	}

	.section20{
		height: 90px;
		width: 100%;
		margin-top: 20px;
		border-radius: 5px;
	}

	.section20 .logo{
		height: 50px;
		width: 100%;
		font-size: 40px;
		text-align: center;
		margin-top: 5px;
		color: #FFF;
	}
	.section20 .textModule{
		height: auto;
		width: 100%;
		margin-top: 10px;
		font-weight: bold;
		font-size: 12px;
		color: #000;
		text-align: center;
	}
	.img{
		height: 100px;
		margin-top: 10px;
		/*border: 1px solid;*/
	}
	.txtBody{
		height: auto;
		width: 100%;
		margin-top: 5px;
		font-weight: bold;
		font-size: 70px;
		color: #1A7EB0;
		text-align: center;
	}
	a{
		color:#333;
	}
	.module_title{
		background-color: #00BE67 !important
		text-align: center;
		font-size: 18px!important;
		font-weight: bold;
		font-style: italic;
		color: #fff !important;
	}
</style>

<style type="text/css">

	
</style>

<?php $branch_id = $this->session->userdata('BRANCHid'); if($branch_id == 1){ ?>
<style>
	.section12 , .section20{
		background: #a8ff78;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #78ffd6, #a8ff78);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #78ffd6, #a8ff78); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
/*linear-gradient(to right, #b0baef, #ff81d8)*/
/*#78ffd6, #a8ff78);*/
	}
	
</style>
<?php } elseif($branch_id == 2){?>
<style>
	.section12 , .section20{
		background: #FC5C7D;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #b0baef, #ff81d8);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #b0baef, #ff81d8); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */




	}
	
</style>
<?php } elseif($branch_id == 3){?>
<style>
	.section12 , .section20{
		background: #8360c3;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #2ebf91, #8360c3);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #2ebf91, #8360c3); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	}
	
</style>
<?php } elseif($branch_id == 4){?>
<style>
	.section12 , .section20{
		background: #009FFF;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #ec2F4B, #009FFF);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #ec2F4B, #009FFF); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	}
	
</style>
<?php } elseif($branch_id == 5){?>
<style>
	.section12 , .section20{
		background: #654ea3;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #eaafc8, #654ea3);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #eaafc8, #654ea3); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	}
	
</style>
<?php } elseif($branch_id == 6){?>
<style>
	.section12 , .section20{
		background: #59C173;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #5D26C1, #a17fe0, #59C173);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #5D26C1, #a17fe0, #59C173); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	}
	
</style>
<?php } elseif($branch_id == 7){?>
<style>
	.section12 , .section20{
		background: #DA4453;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #89216B, #DA4453);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #89216B, #DA4453); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	}
	
</style>
<?php } elseif($branch_id == 8){?>
<style>
	.section12 , .section20{
		background: #a8c0ff;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #3f2b96, #a8c0ff);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #3f2b96, #a8c0ff); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	}
	
</style>
<?php } elseif($branch_id == 9){?>
<style>
	.section12 , .section20{
		background: #4e54c8;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #8f94fb, #4e54c8);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #8f94fb, #4e54c8); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	}
	
</style>
<?php } elseif($branch_id == 10){?>
<style>
	.section12 , .section20{
		background: #40E0D0;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #FF0080, #FF8C00, #40E0D0);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #FF0080, #FF8C00, #40E0D0); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	}
	
</style>
<?php } else{?>
<style>
	.section12 , .section20{
		background: #11998e;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #38ef7d, #11998e);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #38ef7d, #11998e); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

	}
	
</style>
<?php }?>
