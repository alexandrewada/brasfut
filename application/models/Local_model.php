<?php

class Local_model extends CI_Model
{



    private $table = 'tb_local';


    public function getAll() {
        $this->db->order_by('nome_local','ASC');
    	$query = $this->db->get($this->table);

    	if($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}

    }

    public function getAllByModalidade() {
        $this->db->order_by('nome_local','ASC');
        $this->db->where('id_modalidade',$this->session->userdata('id_modalidade'));
        $query = $this->db->get($this->table);

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }


     public function getByID($id) {  
        $query = $this->db->get_where($this->table, array('id_local' => $id));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
     }


    public function insert($data)
    {
        if($this->db->insert($this->table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function update($data,$where)
    {
        if($this->db->update($this->table, $data, $where)) {
            return true;
        } else {
            return false;
        }
    }
}
