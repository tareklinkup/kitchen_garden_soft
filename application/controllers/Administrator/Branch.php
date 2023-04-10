<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $access = $this->session->userdata('userId');
        $this->accountType = $this->session->userdata('accountType');
         if($access == ''){
            redirect("Login");
        }  
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
    }
    public function index()  {
        
        //redirect('Administrator/Page',"Refresh");
    }
    public function setting($id)  {
       
        $data['title'] = "User Access Define";
        $datas['bid'] = $id;
        $this->session->set_userdata($datas);
        $data['content'] = $this->load->view('Administrator/brunch/menu_access', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function Update_Success()  {
       
        $data['title'] = "User Access Define";
        $data['content'] = $this->load->view('Administrator/brunch/Update_Success', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }


    /*===================================*/
    public function define_access()
    {
        $User = $this->input->post('User', TRUE);
        $Bra = $this->db->where('User_SlNo',$User)->where('status','a')->get('tbl_user')->row();
        $branch = $Bra->Brunch_ID;

        $CheckUserAccess = $this->db->from('tbl_user_access')->where('user_id',$User)->where('branch_id',$branch)->count_all_results();
      

        // echo $CheckUserAccess; exit();


        $attr = array(
            'user_id'                 => $User,
            'branch_id'               => $branch,
            'Accounts'                => $this->input->post('Accounts'), 
            'Cash_Transaction'        => $this->input->post('Cash_Transaction'), 
            'Create_Account'          => $this->input->post('Create_Account'), 
            'Add_Bank'                => $this->input->post('Add_Bank'), 
            
            'Accounts_Report'         => $this->input->post('Accounts_Report'), 
            'All_Transaction_Report'  => $this->input->post('All_Transaction_Report'), 
            'Deposite_Report'         => $this->input->post('Deposite_Report'), 
            'Withdraw_Report'         => $this->input->post('Withdraw_Report'), 
            'InCash_Report'           => $this->input->post('InCash_Report'), 
            'OutCash_Report'          => $this->input->post('OutCash_Report'), 
            'Cash_Statement'          => $this->input->post('Cash_Statement'), 
            'Balance_Sheet'           => $this->input->post('Balance_Sheet'), 

            'Administration'          => $this->input->post('Administration'), 
            'Add_Branch'              => $this->input->post('Add_Branch'), 
            'Add_Area'                => $this->input->post('Add_Area'), 
            'Company_Profile'         => $this->input->post('Company_Profile'), 
            'Category_Entry'          => $this->input->post('Category_Entry'), 
            'Unit_Entry'              => $this->input->post('Unit_Entry'), 
            'Color_Entry'             => $this->input->post('Color_Entry'), 

            'Product'                 => $this->input->post('Product'), 
            'Product_Entry'           => $this->input->post('Product_Entry'), 
            'Product_List'            => $this->input->post('Product_List'),

            'Product_Transfer'        => $this->input->post('Product_Transfer'),
            'Transfer_Entry'          => $this->input->post('Transfer_Entry'),
            'Recive_List'             => $this->input->post('Recive_List'),
            'Transfer_List'           => $this->input->post('Transfer_List'),

            'Damage_Info'             => $this->input->post('Damage_Info'),
            'Damage_Entry'            => $this->input->post('Damage_Entry'),
            'Damage_List'             => $this->input->post('Damage_List'),

            'Sales_Module'            => $this->input->post('Sales_Module'),
            'Sales_Entry'             => $this->input->post('Sales_Entry'), 
            'Sales_Return'            => $this->input->post('Sales_Return'),
            'Customer_Entry'          => $this->input->post('Customer_Entry'),
            'Customer_Payment'        => $this->input->post('Customer_Payment'),
            'Customer_List'           => $this->input->post('Customer_List'),

            'Sales_Reports'           => $this->input->post('Sales_Reports'),
            'Sales_Invoice'           => $this->input->post('Sales_Invoice'),
            'Sales_Record'            => $this->input->post('Sales_Record'),
            'Sales_Return_List'       => $this->input->post('Sales_Return_List'),
            'Customer_Due_Report'     => $this->input->post('Customer_Due_Report'),
            'Customer_Payment_Report' => $this->input->post('Customer_Payment_Report'),
            'Productwise_Sales'       => $this->input->post('Productwise_Sales'),
            'Customerwise_Sales'      => $this->input->post('Customerwise_Sales'),
            'Invoice_Product_Details' => $this->input->post('Invoice_Product_Details'),
            'Product_Price_List'      => $this->input->post('Product_Price_List'),

            'Stock'                   => $this->input->post('Stock'),
            'Current_Stock'           => $this->input->post('Current_Stock'),
            'Total_Stock'             => $this->input->post('Total_Stock'),
            'Stock_Available'         => $this->input->post('Stock_Available'),

            'Purchase_Module'         => $this->input->post('Purchase_Module'),
            'Purchase_Entry'          => $this->input->post('Purchase_Entry'),
            'Purchase_Return'         => $this->input->post('Purchase_Return'),
            'Supplier_Entry'          => $this->input->post('Supplier_Entry'),
            'Supplier_List'           => $this->input->post('Supplier_List'),
            'Supplier_Payment'        => $this->input->post('Supplier_Payment'),

            'Purchase_Report'         => $this->input->post('Purchase_Report'),
            'Purchase_Invoice'        => $this->input->post('Purchase_Invoice'),
            'Purchase_Record'         => $this->input->post('Purchase_Record'),
            'Supplier_Due_Report'     => $this->input->post('Supplier_Due_Report'),
            'Supplier_Payment_Report' => $this->input->post('Supplier_Payment_Report'),
            'Purchase_Return_List'    => $this->input->post('Purchase_Return_List'),

            'HR_Payroll'              => $this->input->post('HR_Payroll'),
            'Add_Employee'            => $this->input->post('Add_Employee'),
            'Employee_List'           => $this->input->post('Employee_List'),
            'Salary_Payment'          => $this->input->post('Salary_Payment'),
            'Add_Designation'         => $this->input->post('Add_Designation'),
            'Add_Department'          => $this->input->post('Add_Department'),
            'Add_Month'               => $this->input->post('Add_Month'),
            'HR_Payroll_Reports'      => $this->input->post('HR_Payroll_Reports'),
            'Salary_Payment_Report'   => $this->input->post('Salary_Payment_Report'),

            'Reports_Module'          => $this->input->post('Reports_Module'),
            'Profit_Loss_Report'      => $this->input->post('Profit_Loss_Report')
        );

        
        if($CheckUserAccess == 0):

            $insert = $this->db->insert('tbl_user_access', $attr);
       
            if ($insert) { redirect("Administrator/Branch/Update_Success"); } 
            else { redirect("access/".$User); }

        else:
            $this->db->where('user_id', $User);
            $qu = $this->db->update('tbl_user_access', $attr);
       
            if ( $this->db->affected_rows()) 
                { redirect("Administrator/Branch/Update_Success"); } 
            else { redirect("access/".$User); }
        endif;
        
    }


   

    
}
