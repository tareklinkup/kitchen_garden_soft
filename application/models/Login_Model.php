<?php

class Login_Model extends CI_Model
{

    public function check_login_info($user_email, $use_password)
    {
        $this->db->select('*');
        $this->db->from('tbl_admin_info');
        $this->db->where('email', $user_email);
        //$this->db->where('password',$use_password);
        $query = $this->db->get();
        $user_info = $query->row();

        $verify_password = $user_info->password;
        //echo $verify_password;
        // exit();
        if (password_verify($use_password, $verify_password)) {
            return $user_info;
        }
    }
}
