<?php
class Notificacao_model extends CI_Model
{
    private $table 		= 'tb_notificacao';


    public function getNotificacoes($id_pessoa) {
        $query = $this->db->query("SELECT 
                                        tb_notificacao.id_notificacao,
                                        tb_notificacao.mensagem,
                                        tb_notificacao.data as 'data_criacao',
                                        tb_notificacao_history.id_notificacao_history,
                                        tb_notificacao_history.status,
                                        tb_notificacao_history.id_pessoa,
                                        tb_notificacao_history.data_ultima_atualizacao
                                    FROM
                                        tb_notificacao
                                    INNER JOIN tb_notificacao_history ON tb_notificacao_history.id_notificacao = tb_notificacao.id_notificacao
                                    WHERE 
                                        tb_notificacao_history.id_pessoa = ?
                                        AND tb_notificacao_history.status in ('Pendente','Visto')",array($id_pessoa));

        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return array();
        }

    }
   
    public function Notificacao($id_pessoa,$mensagem=''){

    	$dadosNotificacao = array(
    												'mensagem'  => $mensagem,
    												'data'			=> date('Y-m-d H:i:s')
    											);


    	$this->db->insert('tb_notificacao',$dadosNotificacao);
    	
    	$id_notificacao = $this->db->insert_id();
    	$dadosNotificacaoHistory = array(
    															'id_notificacao' 					=> $id_notificacao,
    															'status'				 					=> 'Pendente',
    															'id_pessoa'			 					=> $id_pessoa,
    															'data_ultima_atualizacao' => date('Y-m-d H:i:s')
    														);

    	$this->db->insert('tb_notificacao_history',$dadosNotificacaoHistory);

    }

    public function getAll() {
    	$query = $this->db->get($this->table);

    	if($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}

    }

     public function getByID($id) {  
        $query = $this->db->get_where($this->table, array('id_modalidade' => $id));
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
