<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BusinessMonitor extends CI_Controller {

	public $brunch;
	public function __construct() {
		parent::__construct();
		$this->brunch = $this->session->userdata('BRANCHid');
		$access = $this->session->userdata('userId');
		if($access == '' ){
			redirect("Login"); 
		}
		$this->load->model("Model_myclass", "mmc", TRUE);
		$this->load->model('Model_table', "mt", TRUE);
		$this->load->model('Billing_model');
	}

	public function business_monitor_page(){
		$data['title'] = "Graph Module";
		$data['branchID'] = $branchID =  $this->session->userdata("BRANCHid");
		$data['transactions'] = $this->db->where('Tr_branchid', $branchID)->where('status', 'a')->order_by('Tr_SlNo', 'desc')->limit(20)->get('tbl_cashtransaction')->result();
		$start_data = date('Y-m-d');
		$end_data = date('Y-m-d');


		$this->db->select('tbl_product.*,tbl_saledetails.AddTime')->select_sum("tbl_saledetails.SaleDetails_TotalQuantity",'qty');
		$this->db->from('tbl_saledetails');
		$this->db->join('tbl_product', 'tbl_saledetails.Product_IDNo = tbl_product.Product_SlNo');
		$this->db->where('tbl_product.Product_branchid',$branchID);
		$this->db->where("DATE_FORMAT(tbl_saledetails.AddTime,'%Y-%m-%d') >=",$start_data)->where("DATE_FORMAT(tbl_saledetails.AddTime,'%Y-%m-%d') <=",$end_data);
		$data['topSells'] = $dd = $this->db->group_by('tbl_saledetails.Product_IDNo')->order_by('qty','desc')->limit(10)->get()->result();

		$this->db->select_sum('tbl_salesmaster.SaleMaster_PaidAmount', 'total_amount')->select("tbl_salesmaster.SalseCustomer_IDNo, tbl_customer.*");
		$this->db->from('tbl_salesmaster');
		$this->db->join('tbl_customer','tbl_salesmaster.SalseCustomer_IDNo = tbl_customer.Customer_SlNo');
		$this->db->where('tbl_salesmaster.SaleMaster_branchid',$branchID);
		$this->db->where("DATE_FORMAT(tbl_salesmaster.AddTime,'%Y-%m-%d') >=",$start_data)->where("DATE_FORMAT(tbl_salesmaster.AddTime,'%Y-%m-%d') <=",$end_data);
		$data['top_cus_list'] =$this->db->group_by('tbl_salesmaster.SalseCustomer_IDNo')->order_by('total_amount','desc')->limit(10)->get()->result();


		$data['checks'] = $this->Check_model->get_all_remaind_check_info();

		$data['content'] = $this->load->view('Administrator/business_monitor_page', $data, TRUE);
		$this->load->view('Administrator/index', $data);
	}


	public function date_to_date_top_sale(){
		$start_data = $this->input->post('start_date');
		$end_data = $this->input->post('end_date');

		$this->db->select('tbl_product.*')->select_sum("tbl_saledetails.SaleDetails_TotalQuantity",'qty');
		$this->db->from('tbl_saledetails');
		$this->db->join('tbl_product', 'tbl_saledetails.Product_IDNo = tbl_product.Product_SlNo');
		$this->db->where('tbl_product.Product_branchid',$this->brunch);
		$this->db->where("DATE_FORMAT(tbl_saledetails.AddTime,'%Y-%m-%d') >=",$start_data)->where("DATE_FORMAT(tbl_saledetails.AddTime,'%Y-%m-%d') <=",$end_data);
		$data['topSells'] = 	$this->db->group_by('tbl_saledetails.Product_IDNo')->order_by('qty','desc')->limit(10)->get()->result();

		$this->load->view('Administrator/chart/top_sale', $data);
	}

	public function date_to_date_top_paid_cus(){
		$start_data = $this->input->post('start_date');
		$end_data = $this->input->post('end_date');

		$this->db->select_sum('tbl_salesmaster.SaleMaster_PaidAmount', 'total_amount')->select("tbl_salesmaster.SalseCustomer_IDNo, tbl_customer.*");
		$this->db->from('tbl_salesmaster');
		$this->db->join('tbl_customer','tbl_salesmaster.SalseCustomer_IDNo = tbl_customer.Customer_SlNo');
		$this->db->where('tbl_salesmaster.SaleMaster_branchid',$this->brunch);
		$this->db->where("DATE_FORMAT(tbl_salesmaster.AddTime,'%Y-%m-%d') >=",$start_data)->where("DATE_FORMAT(tbl_salesmaster.AddTime,'%Y-%m-%d') <=",$end_data);
		$data['top_cus_list'] = $dd = $this->db->group_by('tbl_salesmaster.SalseCustomer_IDNo')->order_by('total_amount','desc')->limit(10)->get()->result();

		
		$this->load->view('Administrator/chart/top_paid_cus', $data);
	}

}
