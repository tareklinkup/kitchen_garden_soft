<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class loginVerify extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->model("model_myclass", "mmc", TRUE);
        $this->load->model('model_table', "mt", TRUE);
    }
	public function verify_code(){
        $data['title'] = "verify_code";
       $this->load->view('Administrator/verify_code', $data);
        
    }
    public function Verify_Code_check(){
        $pass = ($this->input->post('txtPassword'));
        $User_Name=$this->session->userdata('User_Name');        
        $x = "SELECT tbl_user.*,tbl_brunch.* from tbl_user left join tbl_brunch on tbl_brunch.brunch_id = tbl_user.userBrunch_id where  tbl_user.verifycode ='$pass' AND tbl_user.User_Name='$User_Name'";
        $sql = mysql_query($x);
        $d = mysql_fetch_array($sql);
        if ($d['Status']=='a') {
            if ($d['UserType'] =='a') {
                $sdata['userId'] = $d['User_SlNo'];
                $sdata['BRANCHid'] = $d['userBrunch_id'];
                $sdata['FullName'] = $d['FullName'];
                $sdata['User_Name'] = $d['User_Name'];
                $sdata['accountType'] = $d['UserType'];
                $sdata['userBrunch'] = $d['Brunch_sales'];
                $sdata['Brunch_name'] = $d['Brunch_name'];
                $this->session->set_userdata($sdata);
                $id=$d['User_SlNo'];
                $fld='User_SlNo';
                $Data = array('verifycode' => '01846899039', );
                $this->mt->update_data("tbl_user", $Data, $id,$fld);
                redirect('Administrator/');
                
            }else{
                $sdata['userId'] = $d['User_SlNo'];
                $sdata['BRANCHid'] = $d['userBrunch_id'];
                $sdata['FullName'] = $d['FullName'];
                $sdata['User_Name'] = $d['User_Name'];
                $sdata['accountType'] = $d['UserType'];
                $sdata['userBrunch'] = $d['Brunch_sales'];
                $sdata['Brunch_name'] = $d['Brunch_name'];
                $this->session->set_userdata($sdata);
                $id=$d['User_SlNo'];
                $fld='User_SlNo';
                $Data = array('verifycode' => '01846899039', );
                $this->mt->update_data("tbl_user", $Data, $id,$fld);
                redirect('Page/');
            }
        }else{            
                echo "<script>alert('This Code is Not Match!!!')</script>";
                redirect('LoginVerify/verify_code');
            }
    }
}