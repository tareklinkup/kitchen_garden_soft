<?php 
class BillController extends CI_Controller
{
	public function __construct() {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
         if($access == '' ){
            redirect("Login");
        }
    }

	/*====================*/
	public function index()
	{
		$data['title'] 		= "Bill Entry";
		$data['getData'] 	= $this->Bill_model->get_bill_entry();
		$data['ExpHead'] 	= $this->Bill_model->getExpenseHead();
        $data['content'] 	= $this->load->view('Administrator/bill_entry/bill_entry', $data, TRUE);
        $this->load->view('Administrator/index', $data);
	}

	/*=============================*/
	public function store()
	{
		$attr = $this->input->post();
		if($this->Bill_model->insert_data('tbl_bill_entry', $attr)){
			$data['successMsg']="Save Successfully!";
			echo json_encode($data);
		}else{
			$data['errorMsg']="Save Unsuccessfully!";
			echo json_encode($data);
		}
	}


	/*====================*/
	public function edit($id = null)
	{
		$data['edit'] = $this->Bill_model->edit_data($id);
		$data['ExpHead'] 	= $this->Bill_model->getExpenseHead();
        $this->load->view('Administrator/bill_entry/edit_bill_entry', $data);
	}

	/*=============================*/
	public function update($id = null)
	{
		$attr = $this->input->post();
		if($this->Bill_model->update_data('tbl_bill_entry', $attr, $id)) :
			$data['successMsg']="Update Successfully!";
			echo json_encode($data);
		else:
			$data['errorMsg']="Update Unsuccessfully!";
			echo json_encode($data);
		endif;	
	}

	/*=============================*/
	public function delete($id = null)
	{
		if($this->Bill_model->delete_data($id)) :
			$data['successMsg']="Delete Successfully!";
			echo json_encode($data);
		else:
			$data['errorMsg']="Delete Unsuccessfully!";
			echo json_encode($data);
		endif;	
	}

	/*=============================*/
	public function search()
	{
		$type  = $this->input->post('stype');
		$sDate = $this->input->post('sDate');
		$eDate = $this->input->post('eDate');
		if($this->Bill_model->get_search_billEntry($type, $sDate, $eDate)){
			$data['getData'] = $this->Bill_model->get_search_billEntry($type, $sDate, $eDate);
			$this->load->view('Administrator/bill_entry/search_bill_entry', $data);
		}
	}








	/*============Expense Head Entry============*/
	/*============Expense Head Entry============*/
	/*============Expense Head Entry============*/
	/*============Expense Head Entry============*/
	/*====================*/
	public function Eindex()
	{
		$data['title'] 		= "Expense Head Entry";
		$data['getData'] 	= $this->Bill_model->getExpenseHead();
        $data['content'] 	= $this->load->view('Administrator/bill_entry/expense_head', $data, TRUE);
        $this->load->view('Administrator/index', $data);
	}

    public function expenseHeadFancyBox()
    {
        $data['title'] 		= "Expense Head Entry";
        $this->load->view('Administrator/bill_entry/expense_head_fancy_box', $data);
    }

    public function expenseHeadAll(){
        $data 	= $this->Bill_model->getExpenseHead();
        echo json_encode($data);
    }

	/*=============================*/
	public function Estore()
	{
		$attr = $this->input->post();
		if($this->Bill_model->insert_data('tbl_expense_head',$attr)){
			$data['successMsg']="Save Successfully!";
			echo json_encode($data);
		}else{
			$data['errorMsg']="Save Unsuccessfully!";
			echo json_encode($data);
		}
	}


	/*====================*/
	public function Eedit($id = null)
	{
		$data['edit'] = $this->Bill_model->editExpenseHead($id);
        $this->load->view('Administrator/bill_entry/edit_expense_head', $data);
	}

	/*=============================*/
	public function Eupdate($id = null)
	{
		$attr = $this->input->post();
		if($this->Bill_model->update_data('tbl_expense_head', $attr, $id)):
			$data['successMsg']="Update Successfully!";
			echo json_encode($data);
		else:
			$data['errorMsg']="Update Unsuccessfully!";
			echo json_encode($data);
		endif;	
	}

	/*=============================*/
	public function Edelete($id = null)
	{
		if($this->Bill_model->delete_data('tbl_expense_head',$id)) :
			$data['successMsg']="Delete Successfully!";
			echo json_encode($data);
		else:
			$data['errorMsg']="Delete Unsuccessfully!";
			echo json_encode($data);
		endif;	
	}



}
