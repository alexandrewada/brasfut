<?php

class Equipe_model extends CI_Model
{

    private $table = 'tb_equipe';


    public function getAll() {
    	$this->db->order_by('nome_equipe','ASC');
        $this->db->where('id_modalidade',$this->session->userdata('id_modalidade'));
		$this->db->where('id_categoria',$this->session->userdata('id_categoria'));
		$this->db->where('uf',$this->session->userdata('uf_equipe'));
		$this->db->where('sexo',$this->session->userdata('sexo_equipe'));
        $this->db->where('id_equipe_tipo',2);
    	$query = $this->db->get($this->table);

    	if($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}

    }

    public function getTipos(){
        $query = $this->db->get('tb_equipe_tipo');
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function getEstasticas($id_equipe) {


        if(empty($id_equipe)){

            $query = $this->db->query("SELECT 
                                        IF(count(*) is not null,count(*),0) as 'partidas',
                                        IF(sum(pontos) is not null,sum(pontos),0) as 'pontos',
                                        IF(sum(gols) is not null,sum(gols),0) as 'gols',  
                                        IF(sum(vitoria) is not null,sum(vitoria),0)  as 'vitoria',
                                        IF(sum(derrota) is not null,sum(derrota),0)  as 'derrota',
                                        IF(sum(empate) is not null,sum(empate),0)  as 'empate',
                                        IF(sum(wo) is not null,sum(wo),0)  as 'wo'
                                    FROM
                                        tb_equipe_pontuacao pontuacao
                                    WHERE
                                        pontuacao.id_equipe = ?",array($this->session->userdata('id_equipe')));
        } else {
            $query = $this->db->query("SELECT 
                                        IF(count(*) is not null,count(*),0) as 'partidas',
                                        IF(sum(pontos) is not null,sum(pontos),0) as 'pontos',
                                        IF(sum(gols) is not null,sum(gols),0) as 'gols',  
                                        IF(sum(vitoria) is not null,sum(vitoria),0)  as 'vitoria',
                                        IF(sum(derrota) is not null,sum(derrota),0)  as 'derrota',
                                        IF(sum(empate) is not null,sum(empate),0)  as 'empate',
                                        IF(sum(wo) is not null,sum(wo),0)  as 'wo'
                                    FROM
                                        tb_equipe_pontuacao pontuacao
                                    WHERE
                                        pontuacao.id_equipe = ?",array($id_equipe));
        }
        
        return $query->row();
    }

    public function DetalhesEquipePorID($id) {
        $query = $this->db->query("SELECT 
                                        equipe.*,
                                        equipe_tipo.tipo,
                                        modalidade.nome_modalidade,
                                        categoria.nome_categoria,
                                        pessoa.nome_pessoa,
                                        pessoa.telefone,
                                        pessoa.celular
                                   FROM
                                        tb_equipe equipe
                                        LEFT JOIN tb_pessoa pessoa ON pessoa.id_pessoa = equipe.id_pessoa_responsavel
                                        LEFT JOIN tb_modalidade modalidade ON modalidade.id_modalidade = equipe.id_modalidade
                                        LEFT JOIN tb_equipe_tipo equipe_tipo ON equipe_tipo.id_equipe_tipo = equipe.id_equipe_tipo
                                        LEFT JOIN tb_categoria categoria ON categoria.id_categoria = equipe.id_categoria
                                        LEFT JOIN tb_local local ON local.id_local = equipe.id_local_mandante 
                                    WHERE equipe.id_equipe = ?",array($id));


        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getByID($id) {  
        $query = $this->db->get_where($this->table, array('id_equipe' => $id));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getDisponibilidadeById($id) {  
        $query = $this->db->get_where('tb_equipe_disponibilidade', array('id_equipe' => $id));
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getByNome($nome) {  
        $query = $this->db->get_where($this->table, array('nome_equipe' => $nome));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getByIDResponsavel($id) {  
        $query = $this->db->get_where($this->table, array('id_pessoa_responsavel' => $id));
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
