<?php

class Webservice_model extends CI_Model {

	public function listarPartidas($status=2,$filtros) {

		if(!empty($filtros['id_equipe_tipo'])){
			$where[] = " AND equipe_desafiado.id_equipe_tipo = '$filtros[id_equipe_tipo]' ";
		}

		if(!empty($filtros['id_modalidade'])){
			$where[] = " AND  modalidade.id_modalidade = '$filtros[id_modalidade]' ";
		}




		$query = $this->db->query("SELECT 
									    partida.id_partida,
									    partida.data_inicio,
									    local.nome_local,
									    local.cidade,
									    modalidade.nome_modalidade,
									    equipe_desafiado.nome_equipe as 'equipe_desafiado',
									    equipe_desafiante.nome_equipe as 'equipe_desafiante',
									 	equipe_desafiado.logo as 'logo_desafiado',
									    equipe_desafiante.logo as 'logo_desafiante'
									FROM
									    tb_partida partida
										LEFT JOIN tb_local local ON partida.id_local = local.id_local
										LEFT JOIN tb_modalidade modalidade ON modalidade.id_modalidade = local.id_modalidade
									    LEFT JOIN tb_equipe equipe_desafiado ON equipe_desafiado.id_equipe = partida.id_equipe_desafiado
										LEFT JOIN tb_equipe equipe_desafiante ON equipe_desafiante.id_equipe = partida.id_equipe_desafiante
									WHERE partida.id_equipe_desafiado is not null
									".implode($where)."
									AND partida.id_equipe_desafiante is not null 
									AND partida.status = ?
									AND partida.data_inicio >= current_timestamp()"
								,array($status));

		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}	

	
	public function listarPartidasRealizadas($filtros) {


		if(!empty($filtros['id_equipe_tipo'])){
			$where[] = " equipe_desafiado.id_equipe_tipo = '$filtros[id_equipe_tipo]' ";
		}

		if(!empty($filtros['id_modalidade'])){
			$where[] = " modalidade.id_modalidade = '$filtros[id_modalidade]' ";
		}

		if(!empty($filtros['cidade'])){
			$where[] = " local.cidade = '$filtros[cidade]' ";
		}

		$where[] = " partida.status = '4' ";


		$query = $this->db->query("SELECT 
								    partida.id_partida,
								    equipe_desafiado.nome_equipe as 'equipe_desafiado',
								    equipe_desafiante.nome_equipe as 'equipe_desafiante',
								    equipe_desafiado.id_equipe_tipo,
								    equipe_desafiado.logo as 'logo_desafiado',
								    equipe_desafiante.logo as 'logo_desafiante',
								    resultados.ponto_desafiante,
								    resultados.ponto_desafiado,
								    partida.data_inicio,
								    local.nome_local,
								    local.cidade,
								    local.id_local,
								    tipo.tipo,
								    modalidade.nome_modalidade,
								    modalidade.id_modalidade
								FROM
								    tb_partida partida
									LEFT JOIN tb_local local ON partida.id_local = local.id_local
									LEFT JOIN tb_modalidade modalidade ON modalidade.id_modalidade = local.id_modalidade
								    LEFT JOIN tb_equipe equipe_desafiado ON equipe_desafiado.id_equipe = partida.id_equipe_desafiado
									LEFT JOIN tb_equipe equipe_desafiante ON equipe_desafiante.id_equipe = partida.id_equipe_desafiante
								    LEFT JOIN tb_partida_resultados resultados ON resultados.id_partida = partida.id_partida
								    LEFT JOIN tb_equipe_tipo tipo ON tipo.id_equipe_tipo = equipe_desafiado.id_equipe_tipo
								WHERE 
						
									".implode(" AND ",$where)."

								ORDER BY partida.data_inicio DESC");



		if($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}



    public function listarEquipes() {
        $query = $this->db->query("SELECT 
                                        eq.id_equipe,
                                        eq.nome_equipe,
                                        eq.logo,
                                        md.nome_modalidade,
                                        ct.nome_categoria,
                                        et.tipo,
                                        md.nome_modalidade,
                                        CONCAT(eq.cidade, '/', eq.uf) AS 'cidade'

                                    FROM
                                        brasfut_sistema.tb_equipe eq
                                            INNER JOIN
                                        tb_categoria ct ON ct.id_categoria = eq.id_categoria
                                            INNER JOIN
                                        tb_modalidade md ON md.id_modalidade = eq.id_modalidade
                                            INNER JOIN
                                        tb_equipe_tipo et ON et.id_equipe_tipo = et.id_equipe_tipo
GROUP BY eq.id_equipe");
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return false;
        }
	}


    public function listarRankingPorModalidade($id_modalidade=1,$limite=3) {
        $query = $this->db->query("
									SELECT 

										equipe.id_equipe,
									    equipe.nome_equipe,
										equipe.logo,
									    sum(if(pontuacao.pontos is null,0,pontuacao.pontos)) as 'pontos',
									    count(pontuacao.id_partida) as 'partidas'
									FROM
									    brasfut_sistema.tb_equipe equipe
									LEFT JOIN tb_equipe_pontuacao pontuacao ON pontuacao.id_equipe = equipe.id_equipe
									WHERE 
									equipe.id_modalidade =  ?

									GROUP BY equipe.id_equipe
									ORDER BY sum(pontuacao.pontos) DESC
									LIMIT $limite",array($id_modalidade));
        if($query->num_rows() > 0){
            return $query->result();
        } else {
            return false;
        }
	}


	public function listarLocais() {
		$query = $this->db->query("SELECT 
    local.*,
    modalidade.nome_modalidade as 'modalidade'
FROM
    tb_local local
LEFT JOIN tb_modalidade modalidade ON modalidade.id_modalidade = local.id_modalidade");
		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}

	}
}