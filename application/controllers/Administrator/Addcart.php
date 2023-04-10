<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Addcart extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//load model
		$this->load->model('Billing_model');
        $this->load->library('cart');
        $this->load->library('Excel');
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->helper('form');
	}

	public function index(){	
        redirect("Administrator/Products");
	}
	
	function purchaseTOcart(){
		$insert_data = array(
			'id' => $this->input->post('id'),
			'ProCat' => $this->input->post('ProCat'),
			'name' => $this->input->post('name'),
			'group' => $this->input->post('group'),
			'category' => $this->input->post('category'),
			'proCode' => $this->input->post('proCode'),
			'price' => $this->input->post('PurchaseRate'),
			'cost' => $this->input->post('cost'),
			'totalAmount' => $this->input->post('totalAmount'),
			'qty' => $this->input->post('qty')
		);
		$this->cart->insert($insert_data);
		$this->load->view('Administrator/purchase/cartproduct');
	}



	
	function purchaseExcelTOcart(){
		if(isset($_FILES["excel_file"]["name"]))
		{
			$path = $_FILES["excel_file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				$i=1;
				for($row=2; $row<=$highestRow; $row++)
				{
					$i++;
					
					$bodynumber = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$value = $this->db->where('body_number',$bodynumber)->get('tbl_product')->row();
					if($this->db->affected_rows() > 0){
					$slno = $i-1;
					$name = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$groupname = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$qty = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					$bodyrate = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$cost = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$purchaserate = $bodyrate+$cost;
					$insert_data = array(
						'id' 			=> $value->Product_SlNo,
						'slno' 			=> $slno,
						'ProCat' 		=> $this->input->post('ProCat'),
						'name' 			=> $name,
						'group' 		=> $groupname,
						'proCode' 		=> $value->Product_Code,
						'bodynumber' 	=> $bodynumber,
						'bodyrate' 		=> $bodyrate,
						'price' 		=> $purchaserate,
						'cost' 			=> $cost,
						'totalAmount'	=> $purchaserate*$qty,
						'image' 		=> $this->input->post('image'),
						'packagename' 	=> $this->input->post('packagename'),
						'packagecode' 	=> $this->input->post('packagecode'),
						'qty' 			=> $qty
					);
					$this->cart->insert($insert_data);
				}
				}
				
				}
			}	
		
		$this->load->view('Administrator/purchase/cartproduct');
	}
	
	function productSheetCart(){
		$bodynumber = $this->input->post('body_number');
		$value = $this->db->where('body_number',$bodynumber)->get('tbl_product')->row();
		
		$group_id = $value->brand;
		$group = $this->db->where('brand_SiNo',$group_id)->get('tbl_brand')->row();
		$insert_data = array(
			'id' 			=> $value->Product_SlNo,
			'name' 			=> $value->Product_Name,
			'group' 		=> $group->brand_name,
			'bodynumber' 	=> $value->body_number,
			'bodyrate' 		=> $value->body_rate,
			'price' 		=> $value->body_rate,
			'image' 		=> $this->input->post('image'),
			'qty' 			=> 1
		);
		$this->cart->insert($insert_data);
		$this->load->view('Administrator/purchase/product_sheet_cart');
	}

	function ajax_cart_remove_productSheet() {
		$rowid = $this->input->post('rowid');
		if ($rowid==="all"){
			$this->cart->destroy();
		}
		else{
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
			$this->cart->update($data);
		}
		$this->load->view('Administrator/purchase/product_sheet_cart');
	}

	function purchase_update_TOcart(){

		$insert_data = array(
			'id' => $this->input->post('id'),
			'ProCat' => $this->input->post('ProCat'),
			'name' => $this->input->post('name'),
			'category' => $this->input->post('category'),
			'proCode' => $this->input->post('proCode'),
			'bodynumber' => $this->input->post('body_number'),
			'bodyrate' => $this->input->post('bodyRate'),
			'price' => $this->input->post('PurchaseRate'),
			'cost' => $this->input->post('cost'),
			'qty' => $this->input->post('qty'),


		);
		$this->cart->insert($insert_data);
		$this->load->view('Administrator/purchase/update_cartproduct');
	}




	function ajax_purchase_update_CartRemove() {

		$rowid = $this->input->post('rowid');
		$cartData = $this->cart->contents();
		$data = $cartData[$rowid];


		if(isset($data['PurchaseMaster_SlNo'])):

			/***************************************Purchasemaster*******************************************************/
			/*Get Purchase master product data */
			$purchasemaster = $this->db
				->where('PurchaseMaster_InvoiceNo',$data['PurchaseMaster_InvoiceNo'])
				->get('tbl_purchasemaster')
				->row();


			/*Get Purchase Master Total amount amd minus  to cart_subtotal */
			$totalPurchaseAmount = $purchasemaster->PurchaseMaster_TotalAmount - $data['subtotal'];

			/*Get Purchase Master Subtotal amount and  minus to cart_subtotal*/
			$subTotalAmount = $purchasemaster->PurchaseMaster_SubTotalAmount- $data['subtotal'];

			/*New Total due*/
			$totalDueAmount =  $subTotalAmount - $data['PurchaseMaster_PaidAmount'];

			/*Update purchasemaster data*/
			$this->db
				->set('PurchaseMaster_TotalAmount',$totalPurchaseAmount)
				->set('PurchaseMaster_SubTotalAmount',$subTotalAmount)
				->set('PurchaseMaster_DueAmount',$totalDueAmount)
				->where('PurchaseMaster_SlNo',$data['PurchaseMaster_SlNo'])
				->update('tbl_purchasemaster');

			/***************************************Inventory*******************************************************/
			/*Get Product Total Quantity*/
			$totalQuantity = $this->db
				->select('purchase_quantity')
				->where('product_id',$data['id'])
				->get('tbl_currentinventory')
				->row()
				->purchase_quantity;

			/*Update inventory table product quantity*/
			$newTotalQuantity = $totalQuantity - $data['qty'];

			$this->db->set('purchase_quantity',$newTotalQuantity)
				->where('product_id',$data['id'])
				->update('tbl_currentinventory');


		/***************************************PurchaseDetails*******************************************************/
			/*Delete from Details table*/
			$this->db->where('PurchaseDetails_SlNo',$data['PurchaseDetails_SlNo'])->delete('tbl_purchasedetails');

		endif;




		if ($rowid==="all"){
			$this->cart->destroy();
		}
		else{
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
			$this->cart->update($data);
		}
		$this->load->view('Administrator/purchase/update_cartproduct');
	}


	function ajax_cart_remove() {
		$rowid = $this->input->post('rowid');
		if ($rowid==="all"){
			$this->cart->destroy();
		}
		else{
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
			$this->cart->update($data);
		}
		$this->load->view('Administrator/purchase/cartproduct');
	}

	function SalesTOcart(){


		$insert_data = array(
			'id' => $this->input->post('ProID'),
			'name' => $this->input->post('proName'),
			'proBrand' => $this->input->post('proBrand'),
			'bodynumber' => $this->input->post('body_number'),
			'price' => $this->input->post('salePrice'),
			'saleIn' => $this->input->post('saleIn'),
			'pro_discount' =>$this->input->post('pro_discount'),
			'discount_amount' =>$this->input->post('discount_amount'),
			'purchaserate' => $this->input->post('ProPurchaseRATe'),
			'packagename' => $this->input->post('packagename'),
			'packagecode' => $this->input->post('packagecode'),
			'image' => $this->input->post('unit'),
			'qty' => $this->input->post('proQTY')
		);
		$this->cart->insert($insert_data);
		$this->load->view('Administrator/sales/selseCArtlist');

	}

	/*Add Product to Cart when Sales edit */
	function Sales_update_TOcart(){

		$insert_data = array(
			'id' => $this->input->post('ProID'),
			'name' => $this->input->post('proName'),
			'price' => $this->input->post('salePrice'),
			'saleIn' => $this->input->post('saleIn'),
			'discount_amount' =>$this->input->post('discount_amount'),
			'purchaserate' => $this->input->post('ProPurchaseRATe'),
			'qty' => $this->input->post('proQTY'),
			'unit' => $this->input->post('unit'),
			'SaleMaster_PaidAmount' => $this->input->post('SaleMaster_PaidAmount'),
		);
		$this->cart->insert($insert_data);
		$this->load->view('Administrator/sales/selse_Edit_CArtlist');

	}

	/*Delete Product form Sales Update Cart List*/
	function ajax_update_salsecart_remove() {
		$rowid = $this->input->post('rowid');
		$cartData = $this->cart->contents();
		$data = $cartData[$rowid];
		if(isset($data['SaleMaster_InvoiceNo'])):
		/***************************************Salemaster*******************************************************/
 		/*Get Sale master product data */
		$salemaster = $this->db
										  ->where('SaleMaster_InvoiceNo',$data['SaleMaster_InvoiceNo'])
			                    		  ->get('tbl_salesmaster')
										  ->row();

		/*Get Sales Master Total amount amd minus  to cart_subtotal and  sale details discount amount*/
		$totalSaleAmount = ($salemaster->SaleMaster_TotalSaleAmount - ($data['subtotal'] - $data['discount_amount']));
		/*Get Sale Master Subtotal amount and  minus to cart_subtotal and  sale details discount amount*/
		$subTotalAmount = ($salemaster->SaleMaster_SubTotalAmount-($data['subtotal'] - $data['discount_amount']));
		/*New Total due*/

		$totalDueAmount =  $subTotalAmount - $data['SaleMaster_PaidAmount'];

		/*Update salemaster data*/
		$this->db
				 ->set('SaleMaster_TotalSaleAmount',$totalSaleAmount)
				 ->set('SaleMaster_SubTotalAmount',$subTotalAmount)
				 ->set('SaleMaster_DueAmount',$totalDueAmount)
				->where('SaleMaster_SlNo',$data['SaleMaster_SlNo'])
				->update('tbl_salesmaster');


		/***************************************Inventory*******************************************************/
		/*Get Product Total Quantity*/
		$totalQuantity = $this->db
												->select('SaleInventory_TotalQuantity')
												->where('sellProduct_IdNo',$data['Product_IDNo'])
												->get('tbl_saleinventory')
												->row()
												->SaleInventory_TotalQuantity;

		/*Update inventory table product quantity*/
		$newTotalQuantity = $totalQuantity - $data['qty'];
		$this->db->set('SaleInventory_TotalQuantity',$newTotalQuantity)
						->where('sellProduct_IdNo',$data['Product_IDNo'])
						->update('tbl_saleinventory');
		/*date time updated by
			fix
		*/
		/***************************************Saledetails*******************************************************/
		/*Delete from Details table*/
		$this->db->where('SaleDetails_SlNo',$data['SaleDetails_SlNo'])->delete('tbl_saledetails');

		endif;/*check*/



		if ($rowid==="all"){
			$this->cart->destroy();
		}
		else{
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
			$this->cart->update($data);
		}


		$this->load->view('Administrator/sales/selse_Edit_CArtlist');
	}






	function ajax_salsecart_remove() {
		$rowid = $this->input->post('rowid');
		if ($rowid==="all"){
			$this->cart->destroy();
		}
		else{
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
			$this->cart->update($data);
		}
		$this->load->view('Administrator/sales/selseCArtlist');
	}
	
	function cart_view(){
		$data ['title']= "Checkout";
		$data['products_page'] = $this->load->view('Administrator/checkout', $data, TRUE);
		$this->load->view('Administrator/index', $data);
    }
    function showcartAjax(){
		
		$this->load->view('Administrator/showcartAjax');
    }
    public function checkout(){
		$data['title'] = "Checkout";
		$data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
		$data['products_page'] = $this->load->view('Administrator/checkout',$data,TRUE);
		$this->load->view('Administrator/index',$data);
	}
	
	function remove($rowid) {
            // Check rowid value.
		if ($rowid==="all"){
            // Destroy data which store in  session.
			$this->cart->destroy();
			$this->session->unset_userdata('totalcart');
		}
		else{
            // Destroy selected rowid in session.
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
            // Update cart data, after cancle.
			$this->cart->update($data);
			$this->session->unset_userdata('totalcart');
		}
        // This will show cancle data in cart.
		redirect('Shopping/checkout');
	}
	
	function update_cart(){
        // Recieve post values,calcute them and update
        $cart_info =  $_POST['cart'] ;
 		foreach( $cart_info as $id => $cart){	
            $rowid = $cart['rowid'];
            $price = $cart['price'];
            $amount = $price * $cart['qty'];
            $qty = $cart['qty'];
                    
                $data = array(
				'rowid'   => $rowid,
                'price'   => $price,
                'amount' =>  $amount,
				'qty'     => $qty
			);
			$this->cart->update($data);
		}
		redirect('Shopping/checkout');        
	}
	public function order_success(){
    	$data ['title']= "Order Complete";
    	$data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
		$data['products_page'] = $this->load->view('Administrator/order_success', $data, TRUE);
		$this->load->view('Administrator/index', $data);
    }
    public function billing_view(){
    	$idd = $this->session->userdata('LogiinSession');
    	if($idd ==NULL){
    		$data ['title']= "Billing Page";
			$data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
        	$data['products_page'] = $this->load->view('Administrator/billing_page',$data,TRUE);
			$this->load->view('Administrator/index', $data);
    	}else{
    		redirect("Shopping/billing_view_2");
    	}
    	
    }
    public function billing_view_2(){
    	$data ['title']= "Billing Page";
    	$data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
		$data['products_page'] = $this->load->view('Administrator/billing_page2', $data, TRUE);
		$this->load->view('Administrator/index', $data);
    }
    public function save_order(){
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        //Is it a proxy address
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        
			$customer = array(
				"fld_fullname"          =>$this->input->post('fullname'),
	            "fld_password"          =>md5($this->input->post('password')),
	            "fld_email"          =>$this->input->post('email'),
	            "fld_address"          =>$this->input->post('address'),
	            "fld_phone"          =>$this->input->post('phone'),
	            "customer_ip"          =>$ip
			);		
	        // And store user imformation in database.
	        $cust_id = $this->Billing_model->insert_customer($customer);
		
		$query = mysql_query("SELECT * from order_tbl order by fld_id desc limit 1");
		$row = mysql_fetch_array($query);

		$orderserial = "1000".$row['fld_id'];
		$order = array(
			'date' 			=> date('m/d/Y'),
			'customer_id' 	=> $cust_id,
			'payment' 		=> $this->input->post('payment'),
			'orderserial' 		=> $orderserial
		);
		$ord_id = $this->Billing_model->insert_order($order);
		
		if ($cart = $this->cart->contents()):
			foreach ($cart as $item):
				$order_detail = array(
					'orderid' 		=> $ord_id,
					'productid' 	=> $item['id'],
					'quantity' 		=> $item['qty'],
					'price' 		=> $item['price'],
					'image' 		=> $item['image']

				);
                // Insert product imformation with order detail, store in cart also store in database. 
                $cust_id = $this->Billing_model->insert_order_detail($order_detail);
			endforeach;
		endif;
        // After storing all imformation in database load "billing_success".
        $this->cart->destroy();
		redirect('Shopping/order_success');
	}
	public function Loginsave_order(){
    	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        //Is it a proxy address
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        $id = $this->input->post('orderID');
        $query = mysql_query("SELECT * from customer where fld_id = '$id'");
        $check = mysql_fetch_array($query);
        //$iidd = $check['fld_id'];
        if($query){$cust_id = $id;}

		$query = mysql_query("SELECT * from order_tbl order by fld_id desc limit 1");
		$row = mysql_fetch_array($query);

		$orderserial = "1000".$row['fld_id'];
		$order = array(
			'date' 			=> date('m/d/Y'),
			'customer_id' 	=> $cust_id,
			'payment' 		=> $this->input->post('payment'),
			'orderserial' 	=> $orderserial
		);
		$ord_id = $this->Billing_model->insert_order($order);
		
		if ($cart = $this->cart->contents()):
			foreach ($cart as $item):
				$order_detail = array(
					'orderid' 		=> $ord_id,
					'productid' 	=> $item['id'],
					'quantity' 		=> $item['qty'],
					'price' 		=> $item['price'],
					'image' 		=> $item['image']
				);
                // Insert product imformation with order detail, store in cart also store in database. 
                $cust_id = $this->Billing_model->insert_order_detail($order_detail);
			endforeach;
		endif;
        // After storing all imformation in database load "billing_success".
        $this->cart->destroy();
		redirect('Shopping/order_success');
	}
	public function Back() {
           $rowid = $this->input->post('rowid');
		if ($rowid==="all"){
            // Destroy data which store in  session.
			$this->cart->destroy();
			$this->session->unset_userdata('totalcart');
		}
		else{
            // Destroy selected rowid in session.
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
            // Update cart data, after cancle.
			$this->cart->update($data);
		}
		redirect(base_url());
	}
	public function PurchacLoginCheck(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        //Is it a proxy address
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
          $ip=$_SERVER['REMOTE_ADDR'];
        }
    	$data['title'] = ' Login';
        $user =$this->input->post('login_email');
        $pass = md5($this->input->post('login_pass'));
        $x = "SELECT * from customer where fld_email ='$user' AND fld_password ='$pass'";
        $sql = mysql_query($x);
        $d = mysql_fetch_array($sql); 

        if($d['cusStatus'] == "2"){
            $sdata['LogiinSession'] = $d['fld_id'];
            $sdata['ID'] = $d['fld_id'];
            $sdata['name'] = $d['fld_fullname'];
            $sdata['NaMe'] = $d['fld_fullname'];
            $sdata['email'] = $d['fld_email'];
            $sdata['address'] = $d['fld_address'];
            $sdata['phone'] = $d['fld_phone'];
            $sdata['customer_ip'] = $ip;
            $this->session->set_userdata($sdata);
            redirect('Shopping/billing_view_2');
        }
        else{
            $data['title'] = 'Billing Page';
            $data['staa'] = "Invalid Email or Password";
            $data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
        	$data['products_page'] = $this->load->view('Administrator/billing_page',$data,TRUE);
			$this->load->view('Administrator/index', $data);
        }
    }
    
    public function customerLogin(){
		
    	$data['title'] = ' Login';
        $user =$this->input->post('login_email');
        $pass = md5($this->input->post('login_pass'));
        $x = "SELECT * from customer where fld_email ='$user' AND fld_password ='$pass'";
        $sql = mysql_query($x);
        $d = mysql_fetch_array($sql); 

        if($d['cusStatus'] == "2"){
            $sdata['LogiinSession'] = $d['fld_id'];
            $sdata['ID'] = $d['fld_id'];
            $sdata['NaMe'] = $d['fld_fullname'];
            $this->session->set_userdata($sdata);
            redirect(base_url(),'refresh');
        }
        else{
            $data['title'] = ' Login';
            $data['sta'] = "Invalid Email or Password";
            $data['sidebar'] = $this->load->view('Administrator/sidebar',$data,TRUE);
            $data['products_page'] = $this->load->view('Administrator/create_an_account', $data, TRUE);
			$this->load->view('Administrator/index', $data);
        }
    }
    public function LogOut(){
        $this->session->unset_userdata('ID');
        $this->session->unset_userdata('LogiinSession');
        $this->session->unset_userdata('NaMe');
        redirect(base_url(), 'refresh');
    }

    
    function product_transfer_tocart(){
		$insert_data = array(
			'id' => $this->input->post('ProID'),
			'procode' => $this->input->post('proCode'),
			'name' => $this->input->post('proName'),
			'price' => 1,
			'image' => $this->input->post('proUnit'),
			'qty' => $this->input->post('proQTY')
		);
		$this->cart->insert($insert_data);
		$this->load->view('Administrator/transfer/cartproduct');
	}


	function product_transfer_remove(){
		$rowid = $this->input->post('rowid');
		//echo $rowid;
		if ($rowid==="all"){
			$this->cart->destroy();
		}else{			
			$data = array(
				'rowid'   => $rowid,
				'qty'     => 0
			);
			$this->cart->update($data);		
		}
		$this->load->view('Administrator/transfer/cartproduct');
	}


}
?>
