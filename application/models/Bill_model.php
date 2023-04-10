<?php
class Bill_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->branch   = $this->session->userdata('BRANCHid');
    }

    /*===========insert Data============*/
    public function insert_data($table,$attr=null)
    {
        $insert     = $this->db->insert($table, $attr);
        $insertID   = $this->db->insert_id();
        if($insert)
            return $insertID;
        return FALSE;
    }


    // get data===========
    public function get_bill_entry()
    {
        $res = $this->db->select('be.*, eh.head_name')
                    ->join('tbl_expense_head as eh','eh.id= be.exp_head', 'left')
                    ->where('be.status', 'a')->order_by('be.id', 'desc')
                    ->get('tbl_bill_entry as be')->result();
        if($res)
            return $res;
        return FALSE;
    }



    //edit data===========
    public function edit_data($id=null)
    {
        $res = $this->db->select('be.*, eh.head_name')
                    ->join('tbl_expense_head as eh','eh.id= be.exp_head', 'left')
                    ->where('be.id', $id)->where('be.status', 'a')
                    ->get('tbl_bill_entry as be')->row();
        if($res)
            return $res;
        return FALSE;
    }

    // Update data===================
    public function update_data($table, $attr, $id)
    {
        $this->db->where('id', $id);
        $this->db->update($table, $attr);

        if($this->db->affected_rows())
            return TRUE;
        return FALSE;
    }

    // Update data===================
    public function delete_data($table, $id)
    {
        $this->db->set('status','d')
        ->where('id',$id)->update($table);

        if($this->db->affected_rows())
            return TRUE;
        return FALSE;
    }



    // get search data===========
    public function get_search_billEntry($type = null,$form = null,$to = null)
    {
        $res = null;
        $query = $this->db->from('tbl_bill_entry as be')
                        ->select('be.*, eh.head_name')
                        ->join('tbl_expense_head as eh','eh.id= be.exp_head', 'left')
                        ->where('be.status', 'a')
                        ->order_by('be.id', 'desc');

        if($type == 'All'):
            $res = $query->where('be.date >=', $form)
                    ->where('be.date <=',  $to)
                    ->get()->result();
        else:
            $res = $query->where('be.exp_head', $type)->get()->result();
        endif;  

        if($res)
            return $res;
        return FALSE;
    }




    /*============Expense Head Entry============*/
    /*============Expense Head Entry============*/
    /*============Expense Head Entry============*/
    /*============Expense Head Entry============*/

    // get data===========
    public function getExpenseHead()
    {
        $res = $this->db->where('status', 'a')->get('tbl_expense_head')->result();
        if($res)
            return $res;
        return FALSE;
    }



    //edit data===========
    public function editExpenseHead($id=null)
    {
        $res = $this->db->where('id', $id)->where('status', 'a')
                        ->get('tbl_expense_head')->row();
        if($res)
            return $res;
        return FALSE;
    }

}   
?>
