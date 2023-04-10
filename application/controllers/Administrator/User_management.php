<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_management extends CI_Controller {

	private  $access;

    public function __construct() {
        parent::__construct();
        $this->brunch = $this->session->userdata('BRANCHid');
        $this->access = $this->session->userdata('userId');
        $this->accountType = $this->session->userdata('accountType');
         if($this->access == ''){
            redirect("Login");
        }  
        $this->load->model("Model_myclass", "mmc", TRUE);
        $this->load->model('Model_table', "mt", TRUE);
        $this->load->model('Billing_model');
    }
	
    public function index()  {
        if($this->accountType == 'u'){
            redirect("Administrator/Page");
        }
        $access = $this->mt->userAccess();
        if(!$access){
            redirect(base_url());
        }
        $data['title'] = "Create User";
        $data['content'] = $this->load->view('Administrator/user', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getUsers(){
        $users = $this->db->query("
            select 
            * 
            from tbl_user u 
            where u.Brunch_ID = ?
            and u.status = 'a'
        ", $this->session->userdata('BRANCHid'))->result();

        echo json_encode($users);
    }

    public function getAllUsers(){
        $users = $this->db->query("select * from tbl_user")->result();

        echo json_encode($users);
    }
	
    public function add_user(){
        if($this->accountType =='u'){
            redirect("Administrator/Page");
        }
        $data['title'] = "Add User";
        $data['content'] = $this->load->view('Administrator/add_user', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
	
    public function user_Insert()  {
        if($this->accountType =='u'){
            redirect("Administrator/Page");
        }

        $res = ['success'=>false, 'message'=>''];
        $checkUsername = $this->db->query("select * from tbl_user where User_Name = ?", $this->input->post('username', TRUE))->num_rows();
        if($checkUsername > 0){
            $res = ['success'=>false, 'message'=>'Username already exists'];
            echo json_encode($res);
            exit;
        }

		$data = array(
			"User_Name"                 => $this->input->post('username', TRUE),
			"FullName"                  => $this->input->post('txtFirstName', TRUE),
			"UserEmail"                 => $this->input->post('user_email', TRUE),
			"Brunch_ID"                 => $this->input->post('Brunch',TRUE),
            "userBrunch_id"             => $this->input->post('Brunch',TRUE),
			"User_Password"             => md5($this->input->post('rePassword',TRUE)),
			"UserType"                  => $this->input->post('type',TRUE),
			"AddTime"                   => date('Y-m-d H:i:s')
		);
		if($this->mt->save_data("tbl_user", $data)){
			$res = ['success'=>true, 'message'=>'New user created'];
		}
        
        echo json_encode($res);
    }
   
    public function edit($id) {
        if($this->accountType =='u'){
            redirect("Administrator/Page");
        }
        $data['title'] = "User Update Form";
        $query = $this->db->query("SELECT tbl_user.*,tbl_brunch.* FROM tbl_user left join tbl_brunch on tbl_brunch.brunch_id=tbl_user.userBrunch_id WHERE tbl_user.User_SlNo = '$id'");
        $data['selected'] = $query->row();
        $data['content'] = $this->load->view('Administrator/edit/edit', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }
    public function userupdate(){
        if($this->accountType =='u'){
            redirect("Administrator/Page");
        }

        $id = $this->input->post('id');
        $res = ['success'=>false, 'message'=>''];
        $checkUsername = $this->db->query("select * from tbl_user where User_Name = ? and User_SlNo != ?", [$this->input->post('username', TRUE), $id])->num_rows();
        if($checkUsername > 0){
            $res = ['success'=>false, 'message'=>'Username already exists'];
            echo json_encode($res);
            exit;
        }

		$pass = $this->input->post('rePassword',TRUE);
		$fld = 'User_SlNo';
		if($pass!=null)
		{
            $data = array(
                "User_Name"                 => $this->input->post('username', TRUE),
                "FullName"                  => $this->input->post('txtFirstName', TRUE),
                "UserEmail"                  => $this->input->post('user_email', TRUE),
                "Brunch_ID"                  => $this->input->post('Brunch',TRUE),
                "userBrunch_id"              => $this->input->post('Brunch',TRUE),
                "User_Password"             => md5($this->input->post('rePassword',TRUE)),
                "UserType"                  => $this->input->post('type',TRUE),
                "AddTime"                   => date('Y-m-d H:i:s')
                );
            $this->mt->update_data("tbl_user", $data, $id,$fld);
		}else{
            $data = array(
                "User_Name"                 => $this->input->post('username', TRUE),
                "FullName"                  => $this->input->post('txtFirstName', TRUE),
                "UserEmail"                  => $this->input->post('user_email', TRUE),
                "userBrunch_id"              => $this->input->post('Brunch',TRUE),
                "Brunch_ID"                  => $this->input->post('Brunch',TRUE),
                //"User_Password"             => md5($this->input->post('rePassword',TRUE)),
                "UserType"                  => $this->input->post('type',TRUE),
                "AddTime"                   => date('Y-m-d H:i:s')
                );
            $this->mt->update_data("tbl_user", $data, $id,$fld);
        }
        $res = ['success'=>true, 'message'=>'Updated successfully'];

        echo json_encode($res);
        
    } 
	
    public function userActive($id){
        if($this->accountType =='u'){
            redirect("Administrator/Page");
        }
        $fld = 'User_SlNo';
        if($this->Billing_model->active_user("tbl_user", $id, $fld)){
            $sdata['status'] = 'Delete Success';
        }
        else {
            $sdata['status'] = 'Try Again';
        }
        $this->session->set_userdata($sdata);
        redirect("user"); 
    }
	
    public function userDeactive($id){
        if($this->accountType =='u'){
            redirect("Administrator/Page");
        }
        $fld = 'User_SlNo';
        if($this->Billing_model->deactive_user("tbl_user", $id, $fld)){
            $sdata['status'] = 'Delete Success';
        }
        else {
            $sdata['status'] = 'Try Again';
        }
        $this->session->set_userdata($sdata);
        redirect("user"); 
    } 
    public function check_username_availablity(){
      $get_result = $this->mt->check_username_availablity();
        if(!$get_result )
            echo '<span style="color:#f00">Username already in use. </span>';
        else
            echo '<span style="color:#00c">Username Available</span>';
    }
	
	public function check_user_name()
	{
        $username = $this->input->post('username',TRUE); 
        $query = $this->db->query("select User_Name from tbl_user where User_Name = ?", $username);
        if($query->num_rows() > 0) {
            echo '<span style="color:red;">This user name already exist</span>';
            exit;
        }
		
		$result = $query->row();
	}
	
	public function check_email()
	{
		$user_email = $this->input->post('user_email',TRUE); 
		$this->db->SELECT("UserEmail");
		$this->db->from('tbl_user');
		$this->db->where('UserEmail',$user_email);
		$query = $this->db->get();
		$result = $query->row();
		if(count($result)>0)
		 {
			echo '<span style="color:red;">This email ID already exist</span>';
		 }
	}
	
	
    public function user_access($id = null)  {
        if($this->accountType =='u'){
            redirect("Administrator/Page");
        }
        $data['title'] = "User Access Priority";
        $data['userId'] = $id;
        $data['content'] = $this->load->view('Administrator/menu_access_priority', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getUserAccess(){
        $data = json_decode($this->input->raw_input_stream);
        $accessQuery = $this->db->query("select * from tbl_user_access where user_id = ?", $data->userId);
        if($accessQuery->num_rows() == 0){
            echo '';
            exit;
        }

        echo json_encode($accessQuery->row()->access);
    }

    public function addUserAccess(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);

            $count = $this->db->query("select * from tbl_user_access where user_id = ?", $data->userId)->num_rows();
            $access = array(
                'user_id' => $data->userId,
                'access' => json_encode($data->access),
                'saved_by' => $this->session->userdata('userId'),
                'saved_datetime' => date('Y-m-d H:i:s')
            );
            if($count == 0){
                $this->db->insert('tbl_user_access', $access);
            } else {
                $this->db->set($access)->where('user_id', $data->userId)->update('tbl_user_access');
            }
            
            $res = ['success'=>true, 'message'=>'Success'];
        } catch(Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }

	public function select_user_by_branch($id){
		$this->db->SELECT('*');
		$this->db->from('tbl_user');
		$this->db->where('userBrunch_id',$id);
		$query = $this->db->get();
		$result = $query->result();
		foreach($result as $vresult){
		?>
			<option value="<?php echo $vresult->User_SlNo; ?>"><?php echo $vresult->FullName; ?></option>
		<?php
		}
	}
	
		
    public function profile()  {
        $data['title'] = "user profile";

		$user= $this->db->where('User_SlNo', $this->access)->get('tbl_user')->row();
		$data['branch_info'] = $this->db->where('brunch_id', $user->userBrunch_id)->get('tbl_brunch')->row();
		$data['user'] = $user;
		$data['content'] = $this->load->view('Administrator/profile', $data, TRUE);
		$this->load->view('Administrator/index', $data);
    }

    public function password_change(){

		$this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
		$this->form_validation->set_rules('password', 'New Password', 'required|trim|min_length[6]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|min_length[6]|matches[password]');

		if($this->form_validation->run() == FALSE)
		{
			$data['title'] = "user profile";
			$user= $this->db->where('User_SlNo', $this->access)->get('tbl_user')->row();
			$data['branch_info'] = $this->db->where('brunch_id', $user->userBrunch_id)->get('tbl_brunch')->row();
			$data['user'] = $user;
			$data['content'] = $this->load->view('Administrator/profile', $data, TRUE);
			$this->load->view('Administrator/index', $data);
		}
		else{

			$user_name = $this->session->userdata('User_Name');
			$check = $this->db->where('User_Name', $user_name)->where('User_Password', md5($this->input->post('current_password')))->get('tbl_user')->row();

			if($check){
				$attr = array(
					'User_Password'=> md5($this->input->post('password'))
				);
				$this->db->where('User_SlNo', $this->access);
				$res = $this->db->update('tbl_user', $attr);

				if($this->db->affected_rows()){
					$data['msg'] = 'Password Update Successful..!';
					$this->session->set_flashdata($data);
					return redirect('profile');
				}else{
					$data['msg'] = 'Password Update Un-Successful..!';
					$this->session->set_flashdata($data);
					return redirect('profile');
				}

			}else{
				$data['msg'] = 'Current Password not match..!';
				$this->session->set_flashdata($data);
				return redirect('profile');
			}
		}
	}


    public function all_user_name()
    {
        $res = $this->db->select('FullName')->where('status','a')->where('userBrunch_id', $this->brunch)->get('tbl_user')->result();
        $data['allUser'] = $res;
        $this->load->view('Administrator/user_list', $data);
    }

    public function uploadUserImage(){
        try{
            $userId = $this->access;
    
            if(!empty($_FILES)) {
                if(file_exists("./uploads/users/{$this->session->userdata('user_image')}")){
                    unlink("./uploads/users/{$this->session->userdata('user_image')}");
                }

                if(!is_dir("./uploads/users")){
                    mkdir("./uploads/users", 0777, true);
                }

                $config['upload_path'] = './uploads/users/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
    
                $imageName = $userId;
                $config['file_name'] = $imageName;
                $this->load->library('upload', $config);
                $this->upload->do_upload('image');
                //$imageName = $this->upload->data('file_ext'); /*for geting uploaded image name*/
    
                $config['image_library'] = 'gd2';
                $config['source_image'] = './uploads/users/'. $imageName ; 
                $config['new_image'] = './uploads/users/';
                $config['maintain_ratio'] = TRUE;
                $config['width']    = 640;
                $config['height']   = 480;
    
                $this->load->library('image_lib', $config); 
                $this->image_lib->resize();
    
                $imageName = $userId . $this->upload->data('file_ext');
    
                $this->db->query("update tbl_user set image_name = ? where User_SlNo = ?", [$imageName, $userId]);

                $this->session->userdata['user_image'] = $imageName;
            }

            echo "Image uploaded";

        } catch (Exception $ex){
            throw new Exception($ex->getMessage());
        }
    }

    public function userActivity()
    {
        if($this->accountType != 'm' || $this->brunch != 1){
            redirect("Administrator/Page");
        }
        $data['title'] = "User Activity";
        $data['content'] = $this->load->view('Administrator/user_activity', $data, TRUE);
        $this->load->view('Administrator/index', $data);
    }

    public function getUserActivity()
    {
        $data = json_decode($this->input->raw_input_stream);

        $clauses = "";
        if(isset($data->dateFrom) && $data->dateFrom != '' && isset($data->dateTo) && $data->dateTo != ''){
            $dateFrom   = $data->dateFrom.' 00:00:00';
            $dateTo     = $data->dateTo.' 23:59:59';
            $clauses .= " and ua.login_time between '$dateFrom' and '$dateTo'";
        }

        if(isset($data->user_id) && $data->user_id != ''){
            $clauses .= " and ua.user_id = '$data->user_id'";
        }
        
        $result = $this->db->query("
            SELECT ua.*,
            u.User_Name,
            CASE u.UserType
                WHEN 'm' then 'Super Admin'
                WHEN 'a' then 'Admin'
                WHEN 'u' then 'User'
                WHEN 'e' then 'Entry User'
                ELSE 'Unknown'
            END as UserType,
            b.Brunch_name

            from tbl_user_activity ua
            left join tbl_user u on u.User_SlNo = ua.user_id
            left join tbl_brunch b on b.brunch_id = ua.branch_id
            where ua.status = 'a'
            $clauses
            order by ua.id desc
        ")->result();

        echo json_encode($result);
    }

    public function deleteUserActivity(){
        $res = ['success'=>false, 'message'=>''];
        try{
            $data = json_decode($this->input->raw_input_stream);
            if (isset($data->id) && $data->id != '') {
                $this->db->query("DELETE FROM tbl_user_activity where id = '$data->id'");

                $res = ['success'=>true, 'message'=>'Data deleted'];
            }elseif (isset($data->mark_arr) && $data->mark_arr != []) {
                $ids = join("','",$data->mark_arr);
                $this->db->query("DELETE FROM tbl_user_activity where id in ('$ids')");

                $res = ['success'=>true, 'message'=>'Data deleted'];
            }else{
                $res = ['success'=>false, 'message'=>'Something went wrong!'];
            }

            
        } catch (Exception $ex){
            $res = ['success'=>false, 'message'=>$ex->getMessage()];
        }

        echo json_encode($res);
    }
	
}
