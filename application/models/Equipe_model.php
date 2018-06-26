<?php

class Equipe_model extends CI_Model
{

    private $table = 'tb_equipe';


    public function getEquipes($filters){

        $this->db->select('*');
        $this->db->join('tb_modalidade','tb_equipe.id_modalidade = tb_modalidade.id_modalidade','inner');
        $this->db->join('tb_categoria','tb_equipe.id_categoria = tb_categoria.id_categoria','inner');

        $this->db->from('tb_equipe');
    

        foreach ($filters as $campo => $value) {

            if($value == ''){
                continue;
            }

            switch ($campo) {
                case 'estado':
                    $this->db->where('tb_equipe.uf',$value);
                break;

                case 'cidade':
                    $this->db->where('tb_equipe.cidade',$value);
                break;

                case 'equipe_nome':
                    $this->db->like('tb_equipe.nome_equipe',$value);
                break;

                case 'cidade':
                    $this->db->where($campo,$value);
                break;

                case 'id_categoria':
                    $this->db->where('tb_equipe.id_categoria',$value);
                break;

                case 'id_modalidade':
                    $this->db->where('tb_modalidade.id_modalidade',$value);
                break;

                default:
                     $this->db->like($campo,$value);
                break;

            }
        }

        
        return $this->db->get()->result_object();
    }


    public function Ranking($filters) {
        $this->db->select('*');
        $this->db->select_sum('tb_equipe_pontuacao.pontos');
        $this->db->from('tb_equipe_pontuacao');
        $this->db->join('tb_equipe','tb_equipe.id_equipe = tb_equipe_pontuacao.id_equipe','inner');
        $this->db->join('tb_modalidade','tb_equipe.id_modalidade = tb_modalidade.id_modalidade','inner');
        $this->db->join('tb_categoria','tb_equipe.id_categoria = tb_categoria.id_categoria','inner');
        $this->db->group_by('tb_equipe.id_equipe');
        $this->db->order_by('tb_equipe_pontuacao.pontos','DESC');

        foreach ($filters as $campo => $value) {

            if($value == ''){
                continue;
            }

            switch ($campo) {
                case 'estado':
                    $this->db->where('tb_equipe.uf',$value);
                break;

                case 'cidade':
                    $this->db->where('tb_equipe.cidade',$value);
                break;

                case 'equipe_nome':
                    $this->db->like('tb_equipe.nome_equipe',$value);
                break;

                case 'id_modalidade':
                    $this->db->where('tb_modalidade.id_modalidade',$value);
                break; 

                case 'id_categoria':
                    $this->db->where('tb_categoria.id_categoria',$value);
                break;

                default:
                     $this->db->like($campo,$value);
                break;

            }
        }

        
        return $this->db->get()->result_object();
    }


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

    public function getByResponsabelByEquipe($id_equipe) {

        $this->db->select('*');
        $this->db->from('tb_equipe');
        $this->db->join('tb_pessoa','tb_equipe.id_pessoa_responsavel = tb_pessoa.id_pessoa','inner');
        $this->db->where('tb_equipe.id_equipe',$id_equipe);
        $query = $this->db->get();
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
