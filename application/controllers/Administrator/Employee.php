<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Employee extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        if ($access == '') {
            redirect("Login");
        }
        $this->load->model('Billing_model');
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);

        $vars['branch_info'] = $this->Billing_model->company_branch_profile($this->brunch);
        $this->load->vars($vars);
    }

    public function index()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Employee";
        $data['content'] = $this->load->view('Administrator/employee/add_employee', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getEmployees(){
        $data = json_decode($this->input->raw_input_stream);

        $statusClause = " and e.status = 'a'";
        if(isset($data->with_deactive)){
            $statusClause = " and e.status != 'd'";
        }
        
        $employees = $this->db->query("
            SELECT 
                e.*,
                dp.Department_Name,
                ds.Designation_Name,
                concat(e.Employee_Name, ' - ', e.Employee_ID) as display_name
            from tbl_employee e 
            join tbl_department dp on dp.Department_SlNo = e.Department_ID
            join tbl_designation ds on ds.Designation_SlNo = e.Designation_ID
            where e.Employee_brinchid = ?
            $statusClause
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($employees);
    }

    public function getMonths(){
        $months = $this->db->query(
            "SELECT * from tbl_month
            order by month_id desc
        ")->result();

        echo json_encode($months);
    }

    public function getEmployeePayments(){
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if(isset($data->employeeId) && $data->employeeId != ''){
            $clauses .= " and e.Employee_SlNo = '$data->employeeId'";
        }

        if(isset($data->month) && $data->month != ''){
            $clauses .= " and ep.month_id = '$data->month'";
        }

        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and ep.payment_date between '$data->dateFrom' and '$data->dateTo'";
        }

        $payments = $this->db->query("
            select 
                ep.*,
                e.Employee_Name,
                e.Employee_ID,
                e.salary_range,
                dp.Department_Name,
                ds.Designation_Name,
                m.month_name

            from tbl_employee_payment ep
            join tbl_employee e on e.Employee_SlNo = ep.Employee_SlNo
            join tbl_department dp on dp.Department_SlNo = e.Department_ID
            join tbl_designation ds on ds.Designation_SlNo = e.Designation_ID
            join tbl_month m on m.month_id = ep.month_id

            where ep.paymentBranch_id = ?
            and ep.status = 'a'
            $clauses
            order by ep.employee_payment_id desc
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($payments);
    }

    public function getSalarySummary(){

        $data = json_decode($this->input->raw_input_stream);

        $yearMonth = date("Ym", strtotime($data->monthName));

        $summary = $this->db->query("
            select 
                e.*,
                dp.Department_Name,
                ds.Designation_Name,
                (
                    select ifnull(sum(ep.payment_amount), 0) from tbl_employee_payment ep
                    where ep.Employee_SlNo = e.Employee_SlNo
                    and ep.status = 'a'
                    and ep.month_id = " . $data->monthId . "
                    and ep.paymentBranch_id = " . $this->session->userdata('BRANCHid') . "
                ) as paid_amount,
                
                (
                    select ifnull(sum(ep.deduction_amount), 0) from tbl_employee_payment ep
                    where ep.Employee_SlNo = e.Employee_SlNo
                    and ep.status = 'a'
                    and ep.month_id = " . $data->monthId . "
                    and ep.paymentBranch_id = " . $this->session->userdata('BRANCHid') . "
                ) as deducted_amount,
                
                (
                    select e.salary_range - (paid_amount + deducted_amount)
                ) as due_amount
                
            from tbl_employee e 
            join tbl_department dp on dp.Department_SlNo = e.Department_ID
            join tbl_designation ds on ds.Designation_SlNo = e.Designation_ID
            where e.status = 'a'
            and " . $yearMonth . " >= extract(YEAR_MONTH from e.Employee_JoinDate)
            and e.Employee_brinchid = " . $this->session->userdata('BRANCHid') . "
        ")->result();

        echo json_encode($summary);
    }

    public function getPayableSalary(){
        $data = json_decode($this->input->raw_input_stream);

        $payableAmount = $this->db->query("
            select 
            (e.salary_range - ifnull(sum(ep.payment_amount + ep.deduction_amount), 0)) as payable_amount
            from tbl_employee_payment ep
            join tbl_employee e on e.Employee_SlNo = ep.Employee_SlNo
            where ep.status = 'a'
            and ep.month_id = ?
            and ep.Employee_SlNo = ?
            and ep.paymentBranch_id = ?        
        ", [$data->monthId, $data->employeeId, $this->brunch])->row()->payable_amount;

        echo $payableAmount;
    }

    //Designation
    public function designation()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Add Designation";
        $data['content'] = $this->load->view('Administrator/employee/designation', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function insert_designation()
    {
        $mail = $this->input->post('Designation');
        $query = $this->db->query("SELECT Designation_Name from tbl_designation where Designation_Name = '$mail'");

        if ($query->num_rows() > 0) {
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/designation', $data);
        } else {
            $data = array(
                "Designation_Name" => $this->input->post('Designation', TRUE),
                "AddBy" => $this->session->userdata("FullName"),
                "AddTime" => date("Y-m-d H:i:s")
            );
            $this->mt->save_data('tbl_designation', $data);
            //$this->load->view('Administrator/ajax/designation');
        }
    }

    public function designationedit($id)
    {
        $data['title'] = "Edit Designation";
        $fld = 'Designation_SlNo';
        $data['selected'] = $this->Billing_model->select_by_id('tbl_designation', $id, $fld);
        $this->load->view('Administrator/edit/designation_edit', $data);
    }

    public function designationupdate()
    {
        $id = $this->input->post('id');
        $fld = 'Designation_SlNo';
        $data = array(
            "Designation_Name" => $this->input->post('Designation', TRUE),
            "UpdateBy" => $this->session->userdata("FullName"),
            "UpdateTime" => date("Y-m-d H:i:s")
        );
        $this->mt->update_data("tbl_designation", $data, $id, $fld);
    }

    public function designationdelete()
    {
        $fld = 'Designation_SlNo';
        $id = $this->input->post('deleted');
        $this->mt->delete_data("tbl_designation", $id, $fld);
        //$this->load->view('Administrator/ajax/designation');

    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^
    //
    public function depertment()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Add Depertment";
        $data['content'] = $this->load->view('Administrator/employee/depertment', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function insert_depertment()
    {
        $mail = $this->input->post('Depertment');
        $query = $this->db->query("SELECT Department_Name from tbl_department where Department_Name = '$mail'");

        if ($query->num_rows() > 0) {
            $exists = "This Name is Already Exists";
            echo json_encode($exists);
            //$this->load->view('Administrator/ajax/depertment', $data);
        } else {
            $data = array(
                "Department_Name" => $this->input->post('Depertment', TRUE),
                "AddBy" => $this->session->userdata("FullName"),
                "AddTime" => date("Y-m-d H:i:s")
            );
            $this->mt->save_data('tbl_department', $data);
            $message = "Save Successful";
            echo json_encode($message);
        }
    }

    public function depertmentedit($id)
    {
        $data['title'] = "Edit Department";
        $fld = 'Department_SlNo';
        $data['selected'] = $this->Billing_model->select_by_id('tbl_department', $id, $fld);
        $data['content'] = $this->load->view('Administrator/edit/depertment_edit', $data);
        //$this->load->view('Administrator/index', $data);
    }

    public function depertmentupdate()
    {
        $id = $this->input->post('id');
        $fld = 'Department_SlNo';
        $data = array(
            "Department_Name" => $this->input->post('Depertment', TRUE),
            "UpdateBy" => $this->session->userdata("FullName"),
            "UpdateTime" => date("Y-m-d H:i:s")
        );
        $this->mt->update_data("tbl_department", $data, $id, $fld);
    }

    public function depertmentdelete()
    {
        $fld = 'Department_SlNo';
        $id = $this->input->post('deleted');
        $this->mt->delete_data("tbl_department", $id, $fld);
        //$this->load->view('Administrator/ajax/depertment');

    }

    //^^^^^^^^^^^^^^^^^^^^
    public function emplists($status = 'all')
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Employee List";
        $data['employes'] = $this->HR_model->get_all_employee_list($status);
        $data['content'] = $this->load->view('Administrator/employee/list', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    // fancybox add
    public function fancybox_depertment()
    {
        $this->load->view('Administrator/employee/em_depertment');
    }

    public function fancybox_insert_depertment()
    {
        $mail = $this->input->post('Depertment');
        $query = $this->db->query("SELECT Department_Name from tbl_department where Department_Name = '$mail'");

        if ($query->num_rows() > 0) {
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/fancybox_depertmetn', $data);
        } else {
            $data = array(
                "Department_Name" => $this->input->post('Depertment', TRUE),
                "AddBy" => $this->session->userdata("FullName"),
                "AddTime" => date("Y-m-d H:i:s")
            );
            $this->mt->save_data('tbl_department', $data);
            $this->load->view('Administrator/ajax/fancybox_depertmetn');
        }
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

    // fancybox add 
    public function month()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = 'Month';
        $data['content'] = $this->load->view('Administrator/employee/month', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function insert_month()
    {
        $month_name = $this->input->post('month');
        $query = $this->db->query("SELECT month_name from tbl_month where month_name = '$month_name'");

        if ($query->num_rows() > 0) {
            $exists = "This Name is Already Exists";
            echo json_encode($exists);
        } else {
            $data = array(
                "month_name" => $this->input->post('month', TRUE),
                /*   "AddBy"                  =>$this->session->userdata("FullName"),
                  "AddTime"                =>date("Y-m-d H:i:s") */
            );
            if ($this->mt->save_data('tbl_month', $data)) {
                $message = "Month insert success";
                echo json_encode($message);
            }
        }
    }

    public function editMonth($id)
    {
        $query = $this->db->query("SELECT * from tbl_month where month_id = '$id'");
        $data['row'] = $query->row();
        $this->load->view('Administrator/employee/edit_month', $data);
    }

    public function updateMonth()
    {
        $id = $this->input->post('month_id');
        $fld = 'month_id';
        $data = array(
            "month_name" => $this->input->post('month', TRUE),
        );
        if ($this->mt->update_data("tbl_month", $data, $id, $fld)) {
            redirect('month');
        }
    }

    public function fancybox_designation()
    {
        $this->load->view('Administrator/employee/em_designation');
    }

    public function fancybox_insert_designation()
    {
        $mail = $this->input->post('Designation');
        $query = $this->db->query("SELECT Designation_Name from tbl_designation where Designation_Name = '$mail'");

        if ($query->num_rows() > 0) {
            $data['exists'] = "This Name is Already Exists";
            $this->load->view('Administrator/ajax/fancybox_designation', $data);
        } else {
            $data = array(
                "Designation_Name" => $this->input->post('Designation', TRUE),
                "AddBy" => $this->session->userdata("FullName"),
                "AddTime" => date("Y-m-d H:i:s")
            );
            $this->mt->save_data('tbl_designation', $data);
            $this->load->view('Administrator/ajax/fancybox_designation');
        }
    }
    //^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
    // Employee Insert
    public function employee_insert()
    {
        $employee_code = $this->input->post('Employeer_id', true);
        $designation_id = $this->input->post('em_Designation', true);
        $department_id = $this->input->post('em_Depertment', true);
        $employee_name = $this->input->post('em_name', true);
        $bio_id = $this->input->post('bio_id', true);

        if($bio_id){
            $bio_id_count = $this->db->query("SELECT * from tbl_employee where bio_id = '$bio_id' and Employee_brinchid = '$this->brunch'")->num_rows();
            if($bio_id_count != 0){
                echo json_encode(['success' => false, 'message' => 'Bio ID Already Exist!']);
                exit;
            }
        }

        $employee_count = $this->db->query(
            "SELECT * from tbl_employee 
            where Designation_ID = '$designation_id'
            and Department_ID = '$department_id'
            and Employee_Name = '$employee_name'
            and Employee_brinchid = '$this->brunch'
        ")->num_rows();

        
        if($employee_count != 0){
            echo json_encode(['success' => false, 'message' => 'Duplicate Employee!']);
            exit;
        }
        
        $data = array();
        $this->load->library('upload');
        $config['upload_path'] = './uploads/employeePhoto_org/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '10000';
        $config['image_width'] = '4000';
        $config['image_height'] = '4000';
        $config['file_name'] = $employee_code; 
        $this->upload->initialize($config);

        $data['Designation_ID'] = $designation_id;
        $data['Department_ID'] = $department_id;
        $data['Employee_ID'] = $employee_code;
        $data['Employee_Name'] = $employee_name;
        $data['bio_id'] = $bio_id;
        $data['Employee_JoinDate'] = $this->input->post('em_Joint_date');
        $data['Employee_Gender'] = $this->input->post('Gender', true);
        $data['Employee_BirthDate'] = $this->input->post('em_dob', true);
        $data['Employee_ContactNo'] = $this->input->post('em_contact', true);
        $data['Employee_Email'] = $this->input->post('ec_email', true);
        $data['Employee_MaritalStatus'] = $this->input->post('Marital', true);
        $data['Employee_FatherName'] = $this->input->post('em_father', true);
        $data['Employee_MotherName'] = $this->input->post('mother_name', true);
        $data['Employee_PrasentAddress'] = $this->input->post('em_Present_address', true);
        $data['Employee_Reference'] = $this->input->post('em_reference', true);
        $data['Employee_PermanentAddress'] = $this->input->post('em_Permanent_address', true);
        $data['salary_range'] = $this->input->post('salary_range', true);
        $data['status'] = $this->input->post('status', true);

        $data['AddBy'] = $this->session->userdata("FullName");
        $data['Employee_brinchid'] = $this->session->userdata("BRANCHid");
        $data['AddTime'] = date("Y-m-d H:i:s");

        $this->upload->do_upload('em_photo');
        $images = $this->upload->data();
        if($images['orig_name']){
            $data['Employee_Pic_org'] = $images['file_name'];

            $config['image_library'] = 'gd2';
            $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
            $config['new_image'] = 'uploads/' . 'employeePhoto_thum/' . $this->upload->file_name;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 165;
            $config['height'] = 175;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $data['Employee_Pic_thum'] = $this->upload->file_name;
        }else{
            $data['Employee_Pic_org'] = '';
            $data['Employee_Pic_thum'] = '';
        }
        
        $this->mt->save_data('tbl_employee', $data);

        echo json_encode(['success' => true, 'message' => 'Save Success!']);
        exit;
    }

    public function employee_edit($id)
    {
        $data['title'] = "Edit Employee";
        $query = $this->db->query("SELECT tbl_employee.* FROM tbl_employee  where Employee_SlNo = '$id'");
        $data['selected'] = $query->row();
        // echo "<pre>";print_r($data);exit;
        $data['content'] = $this->load->view('Administrator/edit/employee_edit', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function employee_Update()
    {
        $id = $this->input->post('iidd');
        $employee_code = $this->input->post('Employeer_id', true);
        $designation_id = $this->input->post('em_Designation', true);
        $department_id = $this->input->post('em_Depertment', true);
        $employee_name = $this->input->post('em_name', true);
        $bio_id = $this->input->post('bio_id', true);

        if($bio_id){
            $bio_id_count = $this->db->query("SELECT * from tbl_employee where bio_id = '$bio_id' and Employee_brinchid = '$this->brunch' and Employee_SlNo != '$id'")->num_rows();
            if($bio_id_count != 0){
                echo json_encode(['success' => false, 'message' => 'Bio ID Already Exist!']);
                exit;
            }
        }

        $employee_count = $this->db->query(
            "SELECT * from tbl_employee 
            where Designation_ID = '$designation_id'
            and Department_ID = '$department_id'
            and Employee_Name = '$employee_name'
            and Employee_brinchid = '$this->brunch'
            and Employee_SlNo != '$id'
        ")->num_rows();

        
        if($employee_count != 0){
            echo json_encode(['success' => false, 'message' => 'Duplicate Employee!']);
            exit;
        }

        $fld = 'Employee_SlNo';
        $this->load->library('upload');
        $config['upload_path'] = './uploads/employeePhoto_org/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '10000';
        $config['image_width'] = '4000';
        $config['image_height'] = '4000';
        $config['file_name'] = $employee_code; 
        $this->upload->initialize($config);

        $data['Designation_ID'] = $designation_id;
        $data['Department_ID'] = $department_id;
        $data['Employee_ID'] = $employee_code;
        $data['Employee_Name'] = $employee_name;
        $data['bio_id'] = $bio_id;
        $data['Employee_JoinDate'] = $this->input->post('em_Joint_date');
        $data['Employee_Gender'] = $this->input->post('Gender', true);
        $data['Employee_BirthDate'] = $this->input->post('em_dob', true);
        $data['Employee_ContactNo'] = $this->input->post('em_contact', true);
        $data['Employee_Email'] = $this->input->post('ec_email', true);
        $data['Employee_MaritalStatus'] = $this->input->post('Marital', true);
        $data['Employee_FatherName'] = $this->input->post('em_father', true);
        $data['Employee_MotherName'] = $this->input->post('mother_name', true);
        $data['Employee_PrasentAddress'] = $this->input->post('em_Present_address', true);
        $data['Employee_Reference'] = $this->input->post('em_reference', true);
        $data['Employee_PermanentAddress'] = $this->input->post('em_Permanent_address', true);
        $data['Employee_brinchid'] = $this->session->userdata("BRANCHid");
        $data['salary_range'] = $this->input->post('salary_range', true);
        $data['status'] = $this->input->post('status', true);

        $data['UpdateBy'] = $this->session->userdata("FullName");
        $data['UpdateTime'] = date("Y-m-d H:i:s");

        $xx = $this->mt->select_by_id("tbl_employee", $id, $fld);

        $image = $this->upload->do_upload('em_photo');
        $images = $this->upload->data();

        if ($image != "") {
            if ($xx['Employee_Pic_thum'] && $xx['Employee_Pic_org']) {
                unlink("./uploads/employeePhoto_thum/" . $xx['Employee_Pic_thum']);
                unlink("./uploads/employeePhoto_org/" . $xx['Employee_Pic_org']);
            }
            $data['Employee_Pic_org'] = $images['file_name'];

            $config['image_library'] = 'gd2';
            $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
            $config['new_image'] = 'uploads/' . 'employeePhoto_thum/' . $this->upload->file_name;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 165;
            $config['height'] = 175;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $data['Employee_Pic_thum'] = $this->upload->file_name;
        } else {

            $data['Employee_Pic_org'] = $xx['Employee_Pic_org'];
            $data['Employee_Pic_thum'] = $xx['Employee_Pic_thum'];
        }

        $this->mt->update_data("tbl_employee", $data, $id, $fld);

        echo json_encode(['success' => true, 'message' => 'Update Success!']);
        exit;
    }

    public function employee_Delete()
    {
        $id = $this->input->post('deleted');
        $this->db->set(['status'=>'d'])->where('Employee_SlNo', $id)->update('tbl_employee');
    }

    public function active()
    {
        $fld = 'Employee_SlNo';
        $id = $this->input->post('deleted');
        $this->mt->active("tbl_employee", $id, $fld);
        // $this->load->view('Administrator/ajax/employee_list');
    }

    public function employeesalarypayment()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Employee Salary Payment";
        $data['content'] = $this->load->view('Administrator/employee/employee_salary', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function selectEmployee()
    {
        $data['title'] = "Employee Salary Payment";
        $employee_id = $this->input->post('employee_id');
        $query = $this->db->query("SELECT `salary_range` FROM tbl_employee where Employee_SlNo='$employee_id'");
        $data['employee'] = $query->row();
        $this->load->view('Administrator/employee/ajax_employeey', $data);
    }

    public function addEmployeePayment()
    {
        $res = ['success'=>false, 'message'=>'Nothing happened'];
        try{
            $paymentObj = json_decode($this->input->raw_input_stream);
            $payment = (array)$paymentObj;
            unset($payment['employee_payment_id']);
            $payment['status'] = 'a';
            $payment['save_by'] = $this->session->userdata('userId');
            $payment['save_date'] = Date('Y-m-d H:i:s');
            $payment['paymentBranch_id'] = $this->brunch;

            $this->db->insert('tbl_employee_payment', $payment);
            $res = ['success'=>true, 'message'=>'Employee payment added'];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }

    public function employeesalaryreport()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Employee Salary Report";
        $data['content'] = $this->load->view('Administrator/employee/employee_salary_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function EmployeeSalary_list()
    {
        $datas['employee_id'] = $employee_id = $this->input->post('employee_id');
        $datas['month'] = $month = $this->input->post('month');

        $this->session->set_userdata($datas);

        $BRANCHid = $this->session->userdata("BRANCHid");

        if ($employee_id == 'All') {

            $employeequery = $this->db
                ->join('tbl_designation', 'tbl_designation.Designation_SlNo=tbl_employee.Designation_ID', 'left')
                ->where('tbl_employee.Employee_brinchid', $BRANCHid)
                ->get('tbl_employee')->result();
            $data['employee_list'] = $employeequery;


        } else {


            $employeequery = $this->db
                ->join('tbl_designation', 'tbl_designation.Designation_SlNo=tbl_employee.Designation_ID', 'left')
                ->where('tbl_employee.Employee_brinchid', $BRANCHid)
                ->where('tbl_employee.Employee_SlNo	', $employee_id)
                ->get('tbl_employee')->result();
            $data['employee_list'] = $employeequery;
        }

        $data['month'] = $month;
        $this->load->view('Administrator/employee/employee_salary_report_list', $data);
    }

    public function EmploeePaymentReportPrint()
    {
        $BRANCHid = $this->session->userdata("BRANCHid");

        $employee_id = $this->session->userdata('employee_id');
        $month = $this->session->userdata('month');

        if ($employee_id == 'All') {

            $employeequery = $this->db
                ->join('tbl_designation', 'tbl_designation.Designation_SlNo=tbl_employee.Designation_ID', 'left')
                ->where('tbl_employee.Employee_brinchid', $BRANCHid)
                ->get('tbl_employee')->result();
            $data['employee_list'] = $employeequery;


        } else {

            $employeequery = $this->db
                ->join('tbl_designation', 'tbl_designation.Designation_SlNo=tbl_employee.Designation_ID', 'left')
                ->where('tbl_employee.Employee_brinchid', $BRANCHid)
                ->where('tbl_employee.Employee_SlNo	', $employee_id)
                ->get('tbl_employee')->result();
            $data['employee_list'] = $employeequery;
        }

        $data['month'] = $month;
        $this->load->view('Administrator/employee/employee_salary_report_print', $data);
    }

    public function edit_employee_salary($id)
    {
        $data['title'] = "Edit Employee Salary";
        $BRANCHid = $this->session->userdata("BRANCHid");
        $query = $this->db->query("SELECT tbl_employee.*,tbl_employee_payment.*,tbl_month.*,tbl_designation.* FROM tbl_employee left join tbl_employee_payment on tbl_employee_payment.Employee_SlNo=tbl_employee.Employee_SlNo left join tbl_month on tbl_employee_payment.month_id=tbl_month.month_id left join tbl_designation on tbl_designation.Designation_SlNo=tbl_employee.Designation_ID where tbl_employee_payment.employee_payment_id='$id' AND tbl_employee_payment.paymentBranch_id='$BRANCHid'");
        $data['selected'] = $query->row();
        //echo "<pre>";print_r($data['selected']);exit;
        $data['content'] = $this->load->view('Administrator/employee/edit_employee_salary', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function updateEmployeePayment()
    {
        $res = ['success'=>false, 'message'=>'Nothing happened'];
        try{
            $paymentObj = json_decode($this->input->raw_input_stream);
            $payment = (array)$paymentObj;
            unset($payment['employee_payment_id']);
            $payment['update_by'] = $this->session->userdata('userId');
            $payment['update_date'] = Date('Y-m-d H:i:s');

            $this->db->where('employee_payment_id', $paymentObj->employee_payment_id)->update('tbl_employee_payment', $payment);
            $res = ['success'=>true, 'message'=>'Employee payment updated'];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }

    public function deleteEmployeePayment(){
        $res = ['success'=>false, 'message'=>'Nothing happened'];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $this->db->set(['status'=>'d'])->where('employee_payment_id', $data->paymentId)->update('tbl_employee_payment');
            $res = ['success'=>true, 'message'=>'Employee payment deleted'];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }


    //salary Payment
    public function employeePayment()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Employee Salary Payment";
        $data['content'] = $this->load->view('Administrator/employee/salary/payment', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function checkPaymentMonth()
    {
        $data = json_decode($this->input->raw_input_stream);
        $monthId = $data->month_id;

        $query = $this->db->query("SELECT month_id FROM tbl_employee_payment WHERE month_id = ? and branch_id = ? and status = 'a'",[$monthId, $this->session->userdata("BRANCHid")]);
        if($query->num_rows() > 0 ) {
            echo json_encode(['success' => true]);
            exit();
        }
        echo json_encode(['success' => false]);
        exit();

    }

    public function getPayments()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";

        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and ep.payment_date between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->user_id) && $data->user_id != ''){
            $clauses .= " and ep.saved_by = '$data->user_id'";
        }

        if(isset($data->month_id) && $data->month_id != ''){
            $clauses .= " and ep.month_id = '$data->month_id'";
        }

        $payments = $this->db->query("
            SELECT ep.*,
            m.month_name,
            u.User_Name

            from tbl_employee_payment ep
            join tbl_month m on m.month_id = ep.month_id
            left join tbl_user u on u.User_SlNo = ep.saved_by

            where ep.status = 'a'
            and ep.branch_id = ?
            $clauses
            order by ep.id desc
        ", $this->session->userdata("BRANCHid"))->result();

        if(isset($data->details)){
            foreach($payments as $payment){
                $payment->details = $this->db->query("
                    SELECT pd.*,
                    e.Employee_ID,
                    e.Employee_Name,
                    d.Department_Name,
                    de.Designation_Name

                    from tbl_employee_payment_details pd
                    join tbl_employee e on e.Employee_SlNo = pd.employee_id
                    left join tbl_department d on d.Department_SlNo = e.Department_ID
                    left join tbl_designation de on de.Designation_SlNo = e.Designation_ID

                    where pd.status = 'a'
                    and pd.payment_id = '$payment->id'
                ")->result();
            }
        }

        echo json_encode($payments);
    }

    public function getSalaryDetails()
    {
        $data = json_decode($this->input->raw_input_stream);
        $clauses = "";

        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $clauses .= " and ep.payment_date between '$data->dateFrom' and '$data->dateTo'";
        }

        if(isset($data->month_id) && $data->month_id != ''){
            $clauses .= " and ep.month_id = '$data->month_id'";
        }

        if(isset($data->employee_id) && $data->employee_id != ''){
            $clauses .= " and pd.employee_id = '$data->employee_id'";
        }

        $payments = $this->db->query(
            "SELECT pd.*,
            e.Employee_ID,
            e.Employee_Name,
            d.Department_Name,
            de.Designation_Name,
            m.month_name,
            ep.payment_date

            from tbl_employee_payment_details pd
            join tbl_employee_payment ep on ep.id = pd.payment_id
            join tbl_month m on m.month_id = ep.month_id
            join tbl_employee e on e.Employee_SlNo = pd.employee_id
            left join tbl_designation de on de.Designation_SlNo = e.Designation_ID
            left join tbl_department d on d.Department_SlNo = e.Department_ID
            
            where pd.status = 'a'
            and pd.branch_id = ?
            $clauses
        ", $this->session->userdata("BRANCHid"))->result();

        echo json_encode($payments);
    }

    public function saveSalaryPayment()
    {
        $res = ["success" => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);
            $paymentObj = $data->payment;
            $employees = $data->employees;
            
            $payment = (array)$paymentObj;
            unset($payment['id']);
            $payment['saved_by'] = $this->session->userdata("userId");
            $payment['saved_at'] = date("Y-m-d H:i:s");
            $payment['branch_id'] = $this->session->userdata("BRANCHid");
            $payment['status'] = 'a';

            $this->db->insert('tbl_employee_payment', $payment);
            $payment_id = $this->db->insert_id();

            $total_payment_amount = 0;

            foreach($employees as $emp){
                $employee = [
                  'payment_id'      => $payment_id,
                  'employee_id'     => $emp->Employee_SlNo,
                  'salary'          => $emp->salary,
                  'benefit'         => $emp->benefit,
                  'deduction'       => $emp->deduction,
                  'net_payable'     => $emp->net_payable,
                  'payment'         => $emp->payment,
                  'comment'         => $emp->comment,
                  'saved_by'        => $this->session->userdata("userId"),
                  'saved_at'        => date("Y-m-d H:i:s"),
                  'branch_id'       => $this->session->userdata("BRANCHid"),
                  'status'          => 'a',
                ];

                $this->db->insert('tbl_employee_payment_details', $employee);

                $total_payment_amount += $emp->payment;
            }

            $this->db->where('id', $payment_id)->update('tbl_employee_payment', ['total_payment_amount' => $total_payment_amount]);

            $res = ["success" => true, 'message' => 'Payment Success'];

            echo json_encode($res);

        } catch (\Exception $e) {
            $res = ["success" => false, 'message' => $e->getMessage()];
        }
    }

    public function updateSalaryPayment()
    {
        $res = ["success" => false, 'message' => ''];
        try {
            $data = json_decode($this->input->raw_input_stream);

            $paymentObj = $data->payment;
            $employees = $data->employees;
            $payment_id = $paymentObj->id;

            $payment = (array)$paymentObj;
            unset($payment['id']);
            $payment['updated_by'] = $this->session->userdata("userId");
            $payment['updated_at'] = date("Y-m-d H:i:s");

            $this->db->where('id', $payment_id);
            $this->db->update('tbl_employee_payment', $payment);

            $total_payment_amount = 0;

            foreach($employees as $emp){
                $employee = [
                  'payment_id'      => $payment_id,
                  'employee_id'     => $emp->employee_id,
                  'salary'          => $emp->salary,
                  'benefit'         => $emp->benefit,
                  'deduction'       => $emp->deduction,
                  'net_payable'     => $emp->net_payable,
                  'payment'         => $emp->payment,
                  'comment'         => $emp->comment,
                  'updated_by'      => $this->session->userdata("userId"),
                  'updated_at'      => date("Y-m-d H:i:s"),
                ];

                $this->db->where('id', $emp->id);
                $this->db->update('tbl_employee_payment_details', $employee);

                $total_payment_amount += $emp->payment;
            }

            $this->db->where('id', $payment_id)->update('tbl_employee_payment', ['total_payment_amount' => $total_payment_amount]);

            $res = ["success" => true, 'message' => 'Update Success'];

            echo json_encode($res);

        } catch (\Exception $e) {
            $res = ["success" => false, 'message' => $e->getMessage()];
        }
    }

    public function employeePaymentReport()
    {
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Employee Salary Payment Report";
        $data['content'] = $this->load->view('Administrator/employee/salary/payment_report', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function deletePayment()
    {
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $details = $this->db->query(
                "SELECT pd.id from tbl_employee_payment_details pd
                    where pd.payment_id = '$data->paymentId'
                ")->result();

            foreach($details as $detail){
                $this->db->set(['status'=>'d'])->where('id', $detail->id)->update('tbl_employee_payment_details');
            }

            $this->db->set(['status'=>'d'])->where('id', $data->paymentId)->update('tbl_employee_payment');
            $res = ['success'=>true, 'message'=>'Salary Payment deleted'];
        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }

        echo json_encode($res);
    }

    public function getShifts(){
        $shifts = $this->db->query("
            select
            *
            from tbl_shifts
        ")->result();

        echo json_encode($shifts);
    }

}
