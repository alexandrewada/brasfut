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


    public function getAllFilters($filters){

        $this->db->select('*');
        $this->db->from('tb_local');
        $this->db->join('tb_modalidade','tb_local.id_modalidade = tb_modalidade.id_modalidade','inner');


        foreach ($filters as $campo => $value) {

            if($value == ''){
                continue;
            }

            switch ($campo) {
                case 'cidade':
                    $this->db->where($campo,$value);
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

    public function getCidades() {
        $this->db->group_by('cidade');
        return $this->db->get('tb_local')->result();
    }

    public function getLocais() {
        $this->db->group_by('nome_local');
        return $this->db->get('tb_local')->result();
    }  

    public function getEstados() {
        $this->db->group_by('uf');
        return $this->db->get('tb_local')->result();
    }


    public function getEstruturas() {
        return $this->db->get('tb_local_estrutura')->result();
    }

    public function getByID($id) {  
        $query = $this->db->get_where($this->table, array('id_local' => $id));
        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function Cadastrar($p){



        $dadosInsert = array(
                        'nome_local'        => strtoupper(removerAcento(trim($p['nome_local']))),
                        'id_modalidade'     => trim($p['id_modalidade']),
                        'cep'               => trim($p['cep']),
                        'uf'                => strtoupper(trim($p['uf'])),
                        'cidade'            => strtoupper(removerAcento(trim($p['cidade']))),
                        'bairro'            => strtoupper(removerAcento(trim($p['bairro']))),
                        'endereco'          => strtoupper(removerAcento(trim($p['endereco']))),
                        'numero'            => trim($p['numero']),
                        'telefone'          => $p['telefone_local'],
                        'celular'           => $p['celular_local'],
                        'referencia'        => $p['referencia']
                    );
        
        if($this->db->insert($this->table,$dadosInsert)){
            $id_local = $this->db->insert_id();
            if(count($p['estruturas']) > 0){
                foreach ($p['estruturas'] as $k => $id) {
                    $dados = array(
                                    'id_local'          => $id_local,
                                    'id_estrutura'      => $id
                                  );
                    $this->db->insert('tb_local_estrutura_relations',$dados);
                }
            }

            return true;
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
