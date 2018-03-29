<?php

class Convite_model extends CI_Model {
	
    private $table      = 'tb_partida_convites';
    public  $last_insert_id;

    public function getAll() {
    	$query = $this->db->get($this->table);

    	if($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}

    }


    public function criarConviteMandante($id_partida,$id_equipe_desafiante,$id_equipe_desafiada) {

            $dadosInsert = array(
                                    'id_equipe_desafiante'          => $id_equipe_desafiante,
                                    'id_equipe_desafiada'           => $id_equipe_desafiada,
                                    'resposta_equipe_desafiada'     => 0,
                                    'id_partida'                    => $id_partida,
                                    'data'                          => date('Y-m-d H:i:s')
                                );

        if($this->db->insert('tb_partida_convites',$dadosInsert)){
            return array('erro' => false, 'msg' => 'Convite enviado com sucesso.');
        } else {
            return array('erro' => true, 'msg' => 'Já existe um convite criado deste tipo.');
        }

    }


    public function criarConvite($id_partida,$id_equipe_desafiante,$id_equipe_desafiada) {


        $query = $this->db->query("SELECT 
                                    *
                           FROM
                                    tb_partida_convites convites
                           WHERE
                                    convites.id_partida = ? AND
                                    convites.id_equipe_desafiante = ? AND
                                    convites.id_equipe_desafiada = ?
                           ",array($id_partida,$id_equipe_desafiante,$id_equipe_desafiada));


        if($query->num_rows() > 0) {
            $dadosInsert = array(
                                    'id_equipe_desafiante'          => $id_equipe_desafiante,
                                    'id_equipe_desafiada'           => $id_equipe_desafiada,
                                    'resposta_equipe_desafiada'     => 0,
                                    'id_partida'                    => $id_partida,
                                    'data'                          => date('Y-m-d H:i:s')
                                );

            $this->db->insert('tb_partida_convites',$dadosInsert);
            return array('erro' => false, 'Convite enviado com sucesso.');
        } else {
            return array('erro' => true, 'Já existe um convite criado deste tipo.');
        }



    }

    public function respostaConvite($id_convite,$status) {
        $query = $this->db->query("SELECT 
                                            *
                                   FROM
                                            tb_partida_convites convites
                                   WHERE
                                            convites.id_convite = ? AND
                                            convites.id_equipe_desafiada = ? AND
                                            convites.resposta_equipe_desafiada = ?
                                   ",array($id_convite,$this->session->userdata('id_equipe'),'0'));
        // Checar se o convite e o id existe
        if($query->num_rows() > 0) {
            $this->db->update("$this->table",array('resposta_equipe_desafiada' => $status, 'data_rsp_desafiada' => date('Y-m-d H:i:s')),"id_convite = $id_convite");
            if($status == 1) {
                return array('erro' => false,'msg' => 'A resposta do seu convite foi enviada para a equipe adversária, aguarde a confirmação.');
            } elseif($status == 2) {
                return array('erro' => false,'msg' => 'A resposta do seu convite foi enviada!');
            }
        } else {
            return array('erro' => true,'msg' => 'ID do convite não existe ou a equipe desafiada não existe.');
        }

    }

     public function cancelarConvite($id_convite) {
        $query = $this->db->query("SELECT 
                                            *
                                   FROM
                                            tb_partida_convites convites
                                   WHERE
                                            convites.id_convite = ? AND
                                            convites.id_equipe_desafiada = ? 
                                   ",array($id_convite,$this->session->userdata('id_equipe')));
        // Checar se o convite e o id existe
        if($query->num_rows() > 0) {
            $this->db->update("$this->table",array('resposta_equipe_desafiada' => '2', 'data_rsp_desafiada' => date('Y-m-d H:i:s')),"id_convite = $id_convite");
            return array('erro' => false,'msg' => 'O seu convite foi cancelado com sucesso.');
        } else {
            return array('erro' => true,'msg' => 'ID do convite não existe ou a equipe desafiada não existe.');
        }

    }

    public function listarConvitesAceitos() {
        $query = $this->db->query("SELECT 
                                        convites.id_convite,
                                        partida.id_partida,
                                        equipe.nome_equipe,
                                        date_format(partida.data_inicio,'%H:%i') as 'horas_inicio',
                                        date_format(partida.data_fim,'%H:%i') as 'horas_fim',
                                        CONCAT(local.nome_local,' - ',local.cidade ,'/' , local.uf) as 'localidade',
                                        DATE_FORMAT(partida.data_inicio,'%b') as 'mes',
                                        DATE_FORMAT(partida.data_inicio,'%d') as 'dia' 
                                    FROM
                                        tb_partida_convites convites
                                        LEFT JOIN tb_equipe equipe ON equipe.id_equipe = convites.id_equipe_desafiante
                                        LEFT JOIN tb_partida partida ON partida.id_partida = convites.id_partida
                                        LEFT JOIN tb_local local ON local.id_local = partida.id_local
                                        LEFT JOIN tb_modalidade modalidade ON modalidade.id_modalidade = partida.id_modalidade

                                    WHERE 
                                    convites.id_equipe_desafiada = ? AND
                                    partida.id_equipe_desafiado is null AND
                                    partida.status = 0 AND
                                    partida.data_inicio >= current_timestamp() AND
                                    partida.id_modalidade = ? AND
                                    convites.resposta_equipe_desafiada = 1 AND
                                    convites.status = 0

                                    GROUP BY partida.id_equipe_desafiado, partida.id_partida

                                ",array($this->session->userdata('id_equipe'),$this->session->userdata('id_modalidade')));
        
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function listarConvitesRecebidos($id_equipe_desafiada) {
        $query = $this->db->query("SELECT 
                                        convites.id_convite,
                                        partida.id_partida,
                                        equipe.nome_equipe,
                                        date_format(partida.data_inicio,'%H:%i') as 'horas_inicio',
                                        date_format(partida.data_fim,'%H:%i') as 'horas_fim',
                                        CONCAT(local.nome_local,' - ',local.cidade ,'/' , local.uf) as 'localidade',
                                        DATE_FORMAT(partida.data_inicio,'%b') as 'mes',
                                        DATE_FORMAT(partida.data_inicio,'%d') as 'dia' 
                                    FROM
                                        tb_partida_convites convites
                                        LEFT JOIN tb_equipe equipe ON equipe.id_equipe = convites.id_equipe_desafiante
                                        LEFT JOIN tb_partida partida ON partida.id_partida = convites.id_partida
                                        LEFT JOIN tb_local local ON local.id_local = partida.id_local
                                        LEFT JOIN tb_modalidade modalidade ON modalidade.id_modalidade = partida.id_modalidade

                                    WHERE 
                                    convites.id_equipe_desafiada = ? AND
                                    partida.id_equipe_desafiado is null AND
                                    partida.status = 0 AND
                                    partida.data_inicio >= current_timestamp() AND
                                    partida.id_modalidade = ? AND
                                    convites.resposta_equipe_desafiada = 0 AND
                                    convites.status = 0 ORDER BY partida.data_inicio ASC
                                ",array($id_equipe_desafiada,$this->session->userdata('id_modalidade')));
        
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getByID($id) {  
        $query = $this->db->get_where($this->table, array('id_convite' => $id));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function insert($data)
    {
        if($this->db->insert($this->table, $data)) {
            $this->last_insert_id = $this->db->insert_id();
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