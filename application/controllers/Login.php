<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model("model_myclass", "mmc", TRUE);
		$this->load->model('model_table', "mt", TRUE);
		$this->load->helper('JWT');
		$this->load->helper('my_helper');
    }
    public function index()  {
        $data['title'] = "Login";
        $this->load->view('login/login', $data);
    }

    function procedure(){

        $user = $this->input->post('user_name');
		$pass = md5($this->input->post('password'));
		$query = $this->db->query("SELECT u.User_SlNo, u.User_ID, u.FullName, u.User_Name, u.userBrunch_id, u.UserType, u.image_name as user_image, u.status AS userstatus, br.brunch_id, br.Brunch_name, br.Brunch_sales FROM tbl_user AS u LEFT JOIN tbl_brunch AS br ON br.brunch_id = u.userBrunch_id where br.status = 'a' and u.User_Name = ? AND u.User_Password = ?", [$user, $pass]);

		$data = $query->row();

		if(isset($data)){
			
			if ($data->userstatus=='a') {

				$company = $this->db->select(['Company_Logo_org', 'Currency_Name'])->get('tbl_company')->row();

				$this->db->insert('tbl_user_activity', 
					[
						'user_id' 		=>	$data->User_SlNo,
						'ip_address' 	=>	get_client_ip(),
						'login_time' 	=>	date("Y-m-d H:i:s"),
						'status' 		=>	'a',
						'branch_id' 	=>	$data->userBrunch_id,
					]
				);

                $sdata['user_activity_id'] = $this->db->insert_id();

				$sdata['userId'] = $data->User_SlNo;
				$sdata['BRANCHid'] = $data->userBrunch_id;
				$sdata['FullName'] = $data->FullName;
				$sdata['User_Name'] = $data->User_Name;
				$sdata['user_image'] = $data->user_image;
				$sdata['accountType'] = $data->UserType;
				$sdata['userBrunch'] = $data->Brunch_sales;
				$sdata['Brunch_name'] = $data->Brunch_name;
				$sdata['Brunch_image'] = $company->Company_Logo_org;
				$sdata['Currency_Name'] = $company->Currency_Name;
				$this->session->set_userdata($sdata);
				redirect('Administrator/');
			}else{
				$sdata['message'] = "Sorry your are deactivated";
				$this->load->view('login/login', $sdata);
			}

		}else{
			 $sdata['message'] = "Invalid User name or Password";
             $this->load->view('login/login', $sdata);
		}
    }
    

    public function forgotpassword()  {
        $data['title'] = "Forgot Password";
        $this->load->view('ForgotPassword', $data);
    }

    public function logout(){
        $this->db->where('id', $this->session->userdata("user_activity_id"));
        $this->db->update('tbl_user_activity', [ 'logout_time' => date("Y-m-d H:i:s") ]);

        $this->session->unset_userdata('user_activity_id');
        $this->session->unset_userdata('userId');
        $this->session->unset_userdata('User_Name');
        $this->session->unset_userdata('accountType');
        $this->session->unset_userdata('module');
        //$this->session->unset_userdata('useremail');
        redirect("Login");
	}
	
	public function userLogin()
	{
		$res = ['success' => false, 'message' => ''];

		$postData = json_decode($this->input->raw_input_stream);
		
		$user = $postData->username;
		$pass = md5($postData->password);

		$query = $this->db->query("SELECT u.User_SlNo, u.User_ID, u.FullName, u.User_Name, u.userBrunch_id, u.UserType, u.image_name as user_image, u.status AS userstatus, br.brunch_id, br.Brunch_name, br.Brunch_sales FROM tbl_user AS u LEFT JOIN tbl_brunch AS br ON br.brunch_id = u.userBrunch_id where br.status = 'a' and u.User_Name = ? AND u.User_Password = ?", [$user, $pass]);
		$data = $query->row();
		if(isset($data)){
			
			if ($data->userstatus=='a') {
				$encData['userId'] = $data->User_SlNo;
				$encData['BRANCHid'] = $data->userBrunch_id;
				$encData['FullName'] = $data->FullName;
				$encData['User_Name'] = $data->User_Name;

				$resData['userId'] = $data->User_SlNo;
				$resData['fullName'] = $data->FullName;
				$resData['username'] = $data->User_Name;
				$resData['branchId'] = $data->userBrunch_id;
				$resData['branchName'] = $data->Brunch_name;

				$token = JWT::encode($encData, 'secret1234');
				
				$res = [
					'success' => true,
					'message' => 'Login success',
					'data' => $resData,
					'token' => $token
				];
			}
		} else {
			$res = ['success' => false, 'message' => 'Invalid login'];
		}

		echo json_encode($res);
	}

}
