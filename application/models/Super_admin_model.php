<?php



/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of super_admin_model

 *

 * @author Linktechbd

 */

class Super_admin_model extends CI_Model {

    

    public function selectAllContent($id)

    {

        $this->db->where('page_id',$id);

        $this->db->from('pages_tbl');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

    }

    

    

        public function updateAboutInfo($data,$id)

    {

        $this->db->where('page_id',$id);

        $this->db->update('pages_tbl',$data);

        

    }

    

    public function selectContactPageRow()

    {

        $this->db->where('page_id',2);

        $this->db->from('pages_tbl');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

        

    }

    

    

    public function updateContactInfo($data)

    {

        $this->db->where('page_id',2);

        $this->db->update('pages_tbl',$data);

        

    }

    

    public function updateScheduleInfo($id,$data)

    {

        $this->db->where('fld_id',$id);

        $this->db->update('tbl_schedule',$data);

        

    }

    

    public function saveScheduleMoreInfo($data)

    {

         $this->db->insert('tbl_schedule_more',$data);

        

    }



        public function selectAllSchedule()

    {

        $this->db->select('*');

        $this->db->from('tbl_schedule');

        $query_result=  $this->db->get();

        $result=$query_result->result();

        return $result;

        

    }

    

    public function selectAllScheduleMore()

    {

        $this->db->select('*');

        $this->db->from('tbl_schedule_more');

        $this->db->order_by("fld_id", "desc");

        $query_result=  $this->db->get();

        $result=$query_result->result();

        return $result;

        

    }

    

    public function selectScheduleMoreById($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->from('tbl_schedule_more');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result; 

        

    }



    public function savePointTable($data)

    {

        

        $this->db->insert('tbl_point',$data);

        

    }

    

    public function savePointTableMore($data)

    {

        $this->db->insert('tbl_point_more',$data);

        

    }



        public function selectAllPoint()

            

    {

        $this->db->select('*');

        $this->db->from('tbl_point');

        $this->db->order_by("fld_id", "desc");

        $query_result=  $this->db->get();

        $result=$query_result->result();

        return $result;

        

    }

    

    public function selectAllPointMore()

    {

        $this->db->select('*');

        $this->db->from('tbl_point_more');

        $this->db->order_by("fld_id", "desc");

        $query_result=  $this->db->get();

        $result=$query_result->result();

        return $result;

        

    }



    public function saveNextMetchInfo($data)

    {

        $this->db->where('fld_id',1);

        $this->db->update('tbl_next_match',$data);

        

    }

    

    public function selectAllNextMatch()

    {

        $this->db->select('*');

        $this->db->from('tbl_next_match');

        $this->db->order_by("fld_id", "desc");

        $query_result=  $this->db->get();

        $result=$query_result->result();

        return $result;

        

    }

    

    

    public function saveNewsInfo($data)

    {

         $this->db->insert('tbl_news',$data);

        

    }



        public function selectAllNews()

    {

        $this->db->select('*');

        $this->db->from('tbl_news');

        $this->db->order_by("fld_id", "desc");

        $query_result=  $this->db->get();

        $result=$query_result->result();

        return $result;

        

    }

    

    public function saveLastResultInfo($data)

    {

        

         $this->db->insert('tbl_last_result',$data);

        

    }

    

    public function deletLastResultInfo($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->delete('tbl_last_result');

    }



        public function selectAllLastResult()

    {

        $this->db->select('*');

        $this->db->from('tbl_last_result');

        $this->db->order_by("fld_id", "desc");

        $query_result=  $this->db->get();

        $result=$query_result->result();

        return $result; 

        

    }

    

    public function saveOriginResultInfo($data)

            

    {

        $this->db->insert('tbl_origin_news',$data);

        

    }

    

    public function selectAllOriginNews()

    {

        $this->db->select('*');

        $this->db->from('tbl_origin_news');

        $this->db->order_by("fld_id", "desc");

        $query_result=  $this->db->get();

        $result=$query_result->result();

        return $result;

        

    }

    

    public function saveImg_1($data)

    {

        $this->db->where('fld_id',1);

        $this->db->update('tbl_recent_moment',$data);

    }

    

    public function selectImage1()

    {

        $this->db->where('fld_id',1);

        $this->db->from('tbl_recent_moment');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

        

    }



        public function saveImg_2($data)

    {

        $this->db->where('fld_id',2);

        $this->db->update('tbl_recent_moment',$data);

        

    }

    

    

    public function selectImage2()

    {

        $this->db->where('fld_id',2);

        $this->db->from('tbl_recent_moment');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

        

    }

    

    

    public function saveImg_3($data)

    {

        $this->db->where('fld_id',3);

        $this->db->update('tbl_recent_moment',$data);

        

    }

    

    public function selectImage3()

    {

        $this->db->where('fld_id',3);

        $this->db->from('tbl_recent_moment');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

        

    }

    

    public function saveImg_4($data)

    {

        $this->db->where('fld_id',4);

        $this->db->update('tbl_recent_moment',$data);

        

    }

    

    

    public function selectImage4()

    {

        $this->db->where('fld_id',4);

        $this->db->from('tbl_recent_moment');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

        

    }

    

    public function selectAllImage()

    {

        $this->db->select('*');

        $this->db->from('tbl_recent_moment');

        $query_result=  $this->db->get();

        $result=$query_result->result();

        return $result;

    }

    

    public function saveComplement_1($data)

    {

        $this->db->where('fld_id',1);

        $this->db->update('tbl_complements',$data);

        

    }

    

    public function saveComplement_2($data)

    {

        $this->db->where('fld_id',2);

        $this->db->update('tbl_complements',$data);

        

    }

    

    public function saveComplement_3($data)

    {

        $this->db->where('fld_id',3);

        $this->db->update('tbl_complements',$data); 

        

    }

    

    public function selectComplement()

    {

        $this->db->where('fld_id',1);

        $this->db->from('tbl_complements');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

    }

    

    public function selectComplement1()

    {

        $this->db->where('fld_id',2);

        $this->db->from('tbl_complements');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

    }

    

    public function selectComplement2()

    {

        $this->db->where('fld_id',3);

        $this->db->from('tbl_complements');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

    }

    

    public function deletScheduleInfo($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->delete('tbl_schedule');

        

    }

    

    public function slectScheduleById($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->from('tbl_schedule');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

    }

    

    public function updateScheduleMoreInfo($id,$data)

    {

        $this->db->where('fld_id',$id);

        $this->db->update('tbl_schedule_more',$data);

        

    }

    

    public function delete_schedule_more_info($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->delete('tbl_schedule_more');

        

    }

    

    public function selectAllvideo()

    {

        $this->db->where('fld_id',1);

        $this->db->from('tbl_video');

        $query_result=  $this->db->get();

        $result=$query_result->row();

        return $result;

    }

    

    public function updateVideoInfo($data)

    {

        $this->db->where('fld_id',1);

        $this->db->update('tbl_video',$data);

    }

    

    public function delete_point_info($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->delete('tbl_point_more');

    }

    

    

    public function selectSuperAmin($id)

    {

        $this->db->select('*');

        $this->db->where('admin_id',$id);

        $this->db->from('admin_tbl');

        $query=  $this->db->get();

        return $result=$query->row();

    }

    

    

    public function update_profile_info($data,$id)

    {

        $this->db->where('admin_id',$id);

        $this->db->update('admin_tbl',$data);

        

    }

    

    public function save_new_user_info($data)

    {

        $this->db->insert('admin_tbl',$data);

        

    }

    

    public function selectNewUser($id)

    {

        $this->db->where('status',$id);

        $this->db->from('admin_tbl');

        $query=  $this->db->get();

        return $resut= $query->result();

    }

    

    

    public function delete_orogin_news_info($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->delete('tbl_origin_news');

    }

    

    public function delete_news_info($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->delete('tbl_news');

        

    }

    

    public function delete_new_user_info($id)

    {

        $this->db->where('admin_id',$id);

        $this->db->delete('admin_tbl');

        

    }

    

    public function selectAllRegister()

    {

        $this->db->select('*');

        $this->db->from('tbl_registration');

        $this->db->order_by('fld_id','desc');

        $query=  $this->db->get();

        return $result=$query->result();

    }

    

    public function selectRegisterById($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->from('tbl_registration');

        $query=  $this->db->get();

        return $result=$query->row();

        

    }

    

    public function selectAllTeamByYear($id)

    {

        $this->db->where('fld_year',$id);

        $this->db->from('tbl_registration');

        $query=  $this->db->get();

        return $result=$query->result();

    }

    

    public function selectPointById($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->from('tbl_point');

        $query=  $this->db->get();

        return $result=$query->row();

    }

    

    public function updatePointInfo($data,$id)

    {

        $this->db->where('fld_id',$id);

        $this->db->update('tbl_point',$data);

    }

    

    public function saveSlider($data)

    {

        $this->db->insert('slider_tb',$data);

    }

    

    public function selectAllSponsor()

    {

        $this->db->select('*');

        $this->db->from('tbl_sponsor&mediapartner');

        $this->db->order_by('fld_id','desc');

        $query=  $this->db->get();

        return $result=$query->result();

    }

    

    public function deletesponsor_partner($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->delete('tbl_sponsor&mediapartner');

        

    }

    

    public function deleteSpondorLogo($id)

    {

        $this->db->where('fld_id',$id);

        $this->db->from('tbl_sponsor&mediapartner');

        $query=  $this->db->get();

        return $result=$query->row();

    }

    

    public function deleteRegisterInfo($kk)

    {

        $this->db->where('fld_id',$kk);

        $this->db->delete('tbl_registration');

        

    }

  

}

