<?php

class Pessoa_model extends CI_Model
{



    private $table = 'tb_pessoa';


    public function getAll() {
      	$query = $this->db->get($this->table);

    	if($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}

    }


    public function getByEmail($email) {
        $query = $this->db->get_where($this->table, array('email' => $email));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getByCpf($cpf) {
        $query = $this->db->get_where($this->table, array('cpf' => $cpf));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getByID($id) {  
        $query = $this->db->get_where($this->table, array('id_pessoa' => $id));
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
