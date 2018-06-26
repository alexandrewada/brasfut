<?php

class Partida_model extends CI_Model {
	
    private $table      = 'tb_partida';
    public  $last_insert_id;


    public function getPartidas($filters) {
        $this->db->select('*');
        $this->db->from('tb_partida');
        $this->db->join('tb_equipe as equipe_desafiante','equipe_desafiante.id_equipe = tb_partida.id_equipe_desafiante','inner');
        $this->db->join('tb_equipe as equipe_desafiado','equipe_desafiado.id_equipe = tb_partida.id_equipe_desafiante','inner');
        $this->db->join('tb_modalidade','tb_partida.id_modalidade = tb_modalidade.id_modalidade','inner');
        $this->db->join('tb_local','tb_local.id_local = tb_partida.id_local','inner');
       
        foreach ($filters as $campo => $value) {

            if($value == ''){
                continue;
            }

            switch ($campo) {
                case 'estado':
                    $this->db->where('tb_local.uf',$value);
                break;

                case 'cidade':
                    $this->db->where('tb_local.cidade',$value);
                break;

                case 'equipe_nome':
                    $this->db->like('equipe_desafiante.nome_equipe',$value);
                break;

                case 'id_modalidade':
                    $this->db->where('tb_partida.id_modalidade',$value);
                break; 

                case 'id_categoria':
                    $this->db->where('equipe_desafiante.id_categoria',$value);
                break;

                case 'id_local':
                    $this->db->where('tb_local.id_local',$value);
                break;

                default:
                     $this->db->like($campo,$value);
                break;

            }
        }

        $this->db->group_by('tb_partida.id_partida');

        
        return $this->db->get()->result_object();
    }


    public function DiferenciaDias($data1,$data2){
		$data_atual = new DateTime($data1);
		$data_jogo  = new DateTime($data2);
		$diferencia = $data_atual->diff($data_jogo);
		return (int) $diferencia->format('%a%');
    }



    public function listarUltimasPartidasRealizadas() {
    	$query = $this->db->query("
								SELECT 
								    partida.id_partida,
								    equipe_desafiante.id_equipe as 'id_equipe_desafiante',
								    equipe_desafiante.nome_equipe as 'equipe_desafiante',
								    equipe_desafiante.logo as 'desafiante_logo',
								    resultado.ponto_desafiante as 'ponto_desafiante',
									equipe_desafiado.id_equipe as 'id_equipe_desafiado',
								    equipe_desafiado.nome_equipe as 'equipe_desafiado',
								    equipe_desafiado.logo as 'desafiado_logo',
								    resultado.ponto_desafiado as 'ponto_desafiado',
								    partida.data_inicio as 'data'
								FROM
								    tb_partida partida
								        LEFT JOIN
								    tb_partida_resultados resultado ON partida.id_partida = resultado.id_partida
										LEFT JOIN
									tb_equipe equipe_desafiante ON equipe_desafiante.id_equipe = partida.id_equipe_desafiante
										LEFT JOIN
									tb_equipe equipe_desafiado ON equipe_desafiado.id_equipe = partida.id_equipe_desafiado
								WHERE
								    partida.status = 4 AND
								    resultado.status = 3 AND
								    partida.id_modalidade = ?
								ORDER BY data DESC LIMIT 10",array($this->session->userdata('id_modalidade')));

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }

    public function listarMinhasPartidasRealizadas() {
    	$query = $this->db->query("
								SELECT 
								    partida.id_partida,
								    equipe_desafiante.id_equipe as 'id_equipe_desafiante',
								    equipe_desafiante.nome_equipe as 'equipe_desafiante',
								    equipe_desafiante.logo as 'desafiante_logo',
								    resultado.ponto_desafiante as 'ponto_desafiante',
									equipe_desafiado.id_equipe as 'id_equipe_desafiado',
								    equipe_desafiado.nome_equipe as 'equipe_desafiado',
								    equipe_desafiado.logo as 'desafiado_logo',
								    resultado.ponto_desafiado as 'ponto_desafiado',
								    partida.data_inicio as 'data'
								FROM
								    tb_partida partida
								        LEFT JOIN
								    tb_partida_resultados resultado ON partida.id_partida = resultado.id_partida
										LEFT JOIN
									tb_equipe equipe_desafiante ON equipe_desafiante.id_equipe = partida.id_equipe_desafiante
										LEFT JOIN
									tb_equipe equipe_desafiado ON equipe_desafiado.id_equipe = partida.id_equipe_desafiado
								WHERE
								    partida.status = 4 AND
								    resultado.status = 3 AND
								    (partida.id_equipe_desafiante = ? OR partida.id_equipe_desafiado = ?)
								ORDER BY data DESC",array($this->session->userdata('id_equipe'),$this->session->userdata('id_equipe')));

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }

    public function criarPartidaMandante($id_local,$id_equipe_desafiante,$data_inicio,$data_fim){

    		$this->load->model('Partida_model');

			$insertArray = array(
							'id_equipe_desafiante' => $id_equipe_desafiante,
							'data_inicio'		   => $data_inicio,
							'data_fim'			   => $data_fim,
							'id_modalidade'		   => $this->session->userdata()['id_modalidade'],
							'id_local'			   => $id_local,
							'status'			   => 0,
							'privado'			   => 1,
							'data_criacao'		   => date('Y-m-d H:i:s')
						   );

			$partidaCriadaSucesso = $this->Partida_model->insert($insertArray);
			$id_partida 		  = $this->Partida_model->last_insert_id;

			if($partidaCriadaSucesso == true) {

				$dadosInsert = array(
										'id_equipe_desafiante' 			=> $id_equipe_desafiante,
										'id_equipe_desafiada'  			=> $this->session->userdata('id_equipe'),
										'resposta_equipe_desafiada' 	=> 0,
										'id_partida'		   			=> $id_partida,
										'data'				   			=> date('Y-m-d H:i:s')
							  		);

				$this->db->insert('tb_partida_convites',$dadosInsert);
				
				return array('erro' => false,'msg' => 'Convite enviado! Aguarde a equipe confirmar.');
			} else {
				return array('erro' => true,'msg' => 'Não conseguimos reserva sua partida.');
			}

    }


      public function listarMinhasPartidasMandates() {
    	$start 		= new DateTime(date('Y-m-d'));
		$interval 	= new DateInterval('P1D');
		$end 		= new DateTime(date('Y-m-d',strtotime('+3 month')));

		$period 	= new DatePeriod($start, $interval, $end);
		$dados 		= array();

		foreach ($period as $date) {
			$dia_da_semana = $date->format('N');
			$data 		   = $date->format('Y-m-d');
		    
		    $query = $this->db->query("SELECT 
								    equipe.id_equipe,
								    equipe.nome_equipe,
								    disponibilidade.semana,
								    disponibilidade.hora_inicio,
                                    CONCAT(local.nome_local,' - ',local.cidade ,'/' , local.uf) as 'localidade',
                                    local.id_local,
								    disponibilidade.hora_fim
								FROM
								    tb_equipe equipe
								        INNER JOIN
								    tb_equipe_disponibilidade disponibilidade ON disponibilidade.id_equipe = equipe.id_equipe
                                        LEFT JOIN
                                    tb_local local ON local.id_local = equipe.id_local_mandante
								WHERE
								    equipe.id_equipe_tipo in (1,3)
								    	AND equipe.id_equipe = ?
								        AND equipe.id_modalidade = ? 
                                        AND equipe.sexo = ?
                                        AND equipe.id_categoria = ?
								        AND disponibilidade.id_semana = ? 
								GROUP BY disponibilidade.id_equipe",array($this->session->userdata('id_equipe'),$this->session->userdata('id_modalidade'),$this->session->userdata('sexo_equipe'),$this->session->userdata('id_categoria'),$dia_da_semana));

		    if($query->num_rows() > 0) {
		    	foreach ($query->result() as $key => $v) {



		    		$partidaCriada = $this->db->query("SELECT 
    													*
												  FROM
   	 													tb_partida partida
												  WHERE
													partida.id_equipe_desafiante = ? 
													AND partida.data_inicio = ? 
													AND partida.data_fim = ? 
													AND partida.id_modalidade = ?
													AND partida.id_local = ?
													",array($v->id_equipe,$data . ' '.$v->hora_inicio,$data . ' '.$v->hora_fim,$this->session->userdata('id_modalidade'),$v->id_local))->row();

		    		if($partidaCriada != NULL) {
		    			$jaConvidado = $this->db->query("SELECT 
		    												* 
		    											FROM 
		    												tb_partida_convites convites 
		    											WHERE 
		    												convites.id_equipe_desafiante = ?
		    												AND convites.id_equipe_desafiada = ?
		    												AND convites.resposta_equipe_desafiada  in (0,1)
 		    												AND convites.resposta_equipe_desafiante in (0,1)
		    												AND convites.id_partida = ?
                 											AND convites.status = 0",array($v->id_equipe,$this->session->userdata('id_equipe'),$partidaCriada->id_partida))->row();
		    		} else {
		    			$jaConvidado = NULL;
		    		}


		    		$partidaAnulada = $this->db->query("SELECT * FROM tb_reserva_anulada WHERE id_equipe_mandante = ? and data = ?",array($v->id_equipe,$data . ' '.$v->hora_inicio))->row();


		    		if($jaConvidado == NULL AND $partidaCriada->status != 2 AND $partidaAnulada == NULL){


		    				if(time() < strtotime($data . ' '.$v->hora_inicio)){
				    			$dados[] = array(
				    							'nome_equipe'   			=> $v->nome_equipe,
				    							'id_equipe_desafiante'		=> $v->id_equipe,
				    							'id_local'					=> $v->id_local,
				    							'partida'					=> $partidaCriada,
				    							'localidade'				=> $v->localidade,
				    							'semana'					=> $v->semana,
				    							'dia'		 				=> $date->format('d'),
				    							'mes' 		 				=> $date->format('M'),
				    							'data'						=> $data,
				    							'horas_inicio'				=> $v->hora_inicio,
				    							'horas_fim'					=> $v->hora_fim,
				    							'data_inicio'				=> $data . ' '.$v->hora_inicio,
				    							'data_fim'					=> $data . ' '.$v->hora_fim
				    						);
				    		}
		    		}
		    	}
		    }

		}

        if(count($dados) > 0) {
            return $dados;
        } else {
            return false;
        }
    }

    

    public function listarPartidasMandates() {
    	$start 		= new DateTime(date('Y-m-d'));
		$interval 	= new DateInterval('P1D');
		$end 		= new DateTime(date('Y-m-d',strtotime('+3 month')));

		$period 	= new DatePeriod($start, $interval, $end);
		$dados 		= array();

		foreach ($period as $date) {
			$dia_da_semana = $date->format('N');
			$data 		   = $date->format('Y-m-d');
		    
		    $query = $this->db->query("SELECT 
								    equipe.id_equipe,
								    equipe.nome_equipe,
								    disponibilidade.semana,
								    disponibilidade.hora_inicio,
                                    CONCAT(local.nome_local,' - ',local.cidade ,'/' , local.uf) as 'localidade',
                                    local.id_local,
								    disponibilidade.hora_fim
								FROM
								    tb_equipe equipe
								        INNER JOIN
								    tb_equipe_disponibilidade disponibilidade ON disponibilidade.id_equipe = equipe.id_equipe
                                        LEFT JOIN
                                    tb_local local ON local.id_local = equipe.id_local_mandante
								WHERE
								    equipe.id_equipe_tipo = 1
								        AND equipe.id_modalidade = ? 
                                        AND equipe.sexo = ?
                                        AND equipe.id_categoria = ?
								        AND disponibilidade.id_semana = ? 
								GROUP BY disponibilidade.id_equipe",array($this->session->userdata('id_modalidade'),$this->session->userdata('sexo_equipe'),$this->session->userdata('id_categoria'),$dia_da_semana));

		    if($query->num_rows() > 0) {
		    	foreach ($query->result() as $key => $v) {



		    		$partidaCriada = $this->db->query("SELECT 
    													*
												  FROM
   	 													tb_partida partida
												  WHERE
													partida.id_equipe_desafiante = ? 
													AND partida.data_inicio = ? 
													AND partida.data_fim = ? 
													AND partida.id_modalidade = ?
													AND partida.id_local = ?
													",array($v->id_equipe,$data . ' '.$v->hora_inicio,$data . ' '.$v->hora_fim,$this->session->userdata('id_modalidade'),$v->id_local))->row();

		    		if($partidaCriada != NULL) {
		    			$jaConvidado = $this->db->query("SELECT 
		    												* 
		    											FROM 
		    												tb_partida_convites convites 
		    											WHERE 
		    												convites.id_equipe_desafiante = ?
		    												AND convites.id_equipe_desafiada = ?
		    												AND convites.resposta_equipe_desafiada  in (0,1)
 		    												AND convites.resposta_equipe_desafiante in (0,1)
		    												AND convites.id_partida = ?
                 											AND convites.status = 0",array($v->id_equipe,$this->session->userdata('id_equipe'),$partidaCriada->id_partida))->row();
		    		} else {
		    			$jaConvidado = NULL;
		    		}

		    		$partidaAnulada = $this->db->query("SELECT * FROM tb_reserva_anulada WHERE id_equipe_mandante = ? and data = ?",array($v->id_equipe,$data . ' '.$v->hora_inicio))->row();

		    		if($jaConvidado == NULL AND $partidaCriada->status != 2 AND $partidaAnulada == NULL){

		    				if(time() < strtotime($data . ' '.$v->hora_inicio)){
					    		$dados[] = array(
					    							'nome_equipe'   			=> $v->nome_equipe,
					    							'id_equipe_desafiante'		=> $v->id_equipe,
					    							'id_local'					=> $v->id_local,
					    							'partida'					=> $partidaCriada,
					    							'localidade'				=> $v->localidade,
					    							'semana'					=> $v->semana,
					    							'dia'		 				=> $date->format('d'),
					    							'mes' 		 				=> $date->format('M'),
					    							'data'						=> $data,
					    							'horas_inicio'				=> $v->hora_inicio,
					    							'horas_fim'					=> $v->hora_fim,
					    							'data_inicio'				=> $data . ' '.$v->hora_inicio,
					    							'data_fim'					=> $data . ' '.$v->hora_fim
					    						);
				    		}
		    		}
		    	}
		    }

		}

        if(count($dados) > 0) {
            return $dados;
        } else {
            return false;
        }
    }



    public function partidasAgendadas() {

        $id_equipe = $this->session->userdata('id_equipe');

        $query = $this->db->query("
                            SELECT 
                                partida.id_partida,
                                equipe.nome_equipe,
                                equipe.id_equipe,
                                equipe_desafiada.nome_equipe as 'nome_equipe_desafiada',
                                date_format(partida.data_inicio,'%H:%i') as 'horas_inicio',
                                date_format(partida.data_fim,'%H:%i') as 'horas_fim',
                                CONCAT(local.nome_local,' - ',local.cidade ,'/' , local.uf) as 'localidade',
                                DATE_FORMAT(partida.data_inicio,'%b') as 'mes',
                                DATE_FORMAT(partida.data_inicio,'%d') as 'dia'
                            FROM
                                tb_partida partida
                            LEFT JOIN tb_local local ON local.id_local = partida.id_local
                            LEFT JOIN tb_equipe equipe ON equipe.id_equipe = partida.id_equipe_desafiante
                            LEFT JOIN tb_equipe equipe_desafiada ON equipe_desafiada.id_equipe = partida.id_equipe_desafiado
                            WHERE partida.id_equipe_desafiado is not null AND
                            partida.id_equipe_desafiante is not null AND
                            (partida.id_equipe_desafiado = ? OR partida.id_equipe_desafiante = ?) AND
                            partida.status = 2 AND 
                            partida.data_fim >= current_timestamp() ORDER BY partida.data_inicio ASC",array($id_equipe,$id_equipe));


        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }

    }

    public function confirmarPlacar($id_resultado,$status){
    	$dadosResultado = $this->db->query("SELECT * FROM     tb_partida_resultados resultados LEFT JOIN tb_partida partida ON partida.id_partida = resultados.id_partida WHERE resultados.id_resultado = ?",array($id_resultado))->row();

    	if($dadosResultado != false) {

    		switch ($status) {
    			// Aprovado
    			case '1':

    				// Se um dos times for W.0
    				if($dadosResultado->ponto_desafiante == -3 OR $dadosResultado->ponto_desafiado == -3) {
    					
    					// Time desafiante for w.o
    					if($dadosResultado->ponto_desafiante == -3){

	    					$this->db->insert('tb_equipe_pontuacao',array('id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiante, 'wo' => 1, 'pontos' => -5, 'derrota' => 1, 'data' => date('Y-m-d H:i:s')));
							
			                $this->db->insert('tb_equipe_pontuacao',array('id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiado, 'vitoria' => 1, 'pontos' => 3 ,'data' => date('Y-m-d H:i:s')));

    					} elseif($dadosResultado->ponto_desafiado == -3){
    						$this->db->insert('tb_equipe_pontuacao',array('id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiado, 'wo' => 1, 'derrota' => 1, 'pontos' => -5, 'data' => date('Y-m-d H:i:s')));
						
		                    $this->db->insert('tb_equipe_pontuacao',array('id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiante, 'vitoria' => 1, 'pontos' => 3  ,'data' => date('Y-m-d H:i:s')));
    					} elseif($dadosResultado->ponto_desafiante == -3 AND $dadosResultado->ponto_desafiado == -3){
    						
    						$this->db->insert('tb_equipe_pontuacao',array('id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiante, 'wo' => 1, 'derrota' => 1, 'pontos' => -5,  'data' => date('Y-m-d H:i:s')));
							
							$this->db->insert('tb_equipe_pontuacao',array('id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiado, 'wo' => 1, 'derrota' => 1,  'pontos' => -5, 'data' => date('Y-m-d H:i:s')));
						
    					}
    				} 
    					elseif($dadosResultado->ponto_desafiante == $dadosResultado->ponto_desafiado)
		            {
		                $this->db->insert('tb_equipe_pontuacao',array('pontos' => 1,'gols' => $dadosResultado->ponto_desafiante,  'id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiante, 'empate' => 1, 'data' => date('Y-m-d H:i:s')));
						
		                $this->db->insert('tb_equipe_pontuacao',array('pontos' => 1,'gols' => $dadosResultado->ponto_desafiado,  'id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiado, 'empate' => 1, 'data' => date('Y-m-d H:i:s')));
		                
		            // Ganhou
		            } elseif($dadosResultado->ponto_desafiante > $dadosResultado->ponto_desafiado)
		            {
		                $this->db->insert('tb_equipe_pontuacao',array('pontos' => 3, 'gols' => $dadosResultado->ponto_desafiante, 'id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiante, 'vitoria' => 1, 'data' => date('Y-m-d H:i:s')));

		                $this->db->insert('tb_equipe_pontuacao',array('pontos' => 0, 'gols' => $dadosResultado->ponto_desafiado,'id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiado, 'derrota' => 1, 'data' => date('Y-m-d H:i:s')));
		            // Perdeu
		            } else {
		             	$this->db->insert('tb_equipe_pontuacao',array('pontos' => 3, 'gols' => $dadosResultado->ponto_desafiado, 'id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiado, 'vitoria' => 1, 'data' => date('Y-m-d H:i:s')));

		                $this->db->insert('tb_equipe_pontuacao',array('pontos' => 0, 'gols' => $dadosResultado->ponto_desafiante,'id_partida' => $dadosResultado->id_partida, 'id_equipe' => $dadosResultado->id_equipe_desafiante, 'derrota' => 1, 'data' => date('Y-m-d H:i:s')));
		            }

    				$this->db->update('tb_partida',array('status' => 4),array('id_partida' => $dadosResultado->id_partida));
    				$this->db->update('tb_partida_resultados',array('status' => 3),array('id_resultado' => $id_resultado));
    			break;
    			
    			// Reprovado
    			case '4':
					$this->db->delete('tb_partida_resultados',array('id_resultado' => $id_resultado));    				
    			break;

    			default:
    				# code...
    				break;
    		}

    		return array('erro' => false, 'msg' => ($status == 1) ? 'Você confirmou a pontuação.' : 'Você recusou a pontuação.' );
    	} else {
    		return array('erro' => true,  'msg'  => 'O id do resultado não existe.');	
    	}

    }

    


    public function listarEquipesVisualizaramPartida($id_partida) {
        $query = $this->db->query("
            
            SELECT 
                equipe.id_equipe,
                equipe.nome_equipe as 'nome_equipe',
                equipe.logo,
                visualizacao.id_partida,
                DATE_FORMAT(visualizacao.data,'%d/%m/%Y %H:%i:%s') as 'data'
            FROM
                tb_partida_visualizacao visualizacao
            LEFT JOIN tb_equipe equipe ON equipe.id_equipe = visualizacao.id_equipe
            WHERE visualizacao.id_partida = ? AND visualizacao.id_equipe != ?
            #GROUP BY visualizacao.id_equipe
            ORDER BY data DESC LIMIT 10
        ",array($id_partida,$this->session->userdata('id_equipe')));

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function getAll() {
    	$this->db->order_by('nome','ASC');
    	$query = $this->db->get($this->table);

    	if($query->num_rows() > 0) {
    		return $query->result();
    	} else {
    		return false;
    	}
    }

    public function ResultadoPartidaFinalizada() {
        $query = $this->db->query("SELECT 
										partida.id_partida,
									    partida.data_inicio,
									    partida.data_fim,
									    partida.status,
									    partida.data_criacao,
										equipe_desafiado.id_equipe as 'id_equipe_desafiado',
										equipe_desafiado.nome_equipe as 'nome_equipe_desafiante',
                                        equipe_desafiado.logo as 'logo_desafiado',
                                		equipe_desafiante.id_equipe as 'id_equipe_desafiante',
									    equipe_desafiante.nome_equipe as 'nome_equipe_desafiada',
                                        equipe_desafiante.logo as 'logo_desafiante',
                                        resultados.id_resultado,
                                        resultados.id_equipe_informou,
                                        resultados.ponto_desafiante,
                                        resultados.ponto_desafiado,
                                        resultados.status as 'status_ponto'
                                	FROM
										tb_partida partida
									LEFT JOIN tb_equipe equipe_desafiante ON equipe_desafiante.id_equipe 	= partida.id_equipe_desafiante
									LEFT JOIN tb_equipe equipe_desafiado ON equipe_desafiado.id_equipe 		= partida.id_equipe_desafiado
									LEFT JOIN tb_partida_resultados resultados ON resultados.id_partida 	= partida.id_partida 
									WHERE
									partida.data_fim <= CURRENT_TIME() AND
                                    partida.status != 4 AND
                                	partida.id_equipe_desafiado is not null AND
									partida.id_equipe_desafiante is not null AND
                                    (partida.id_equipe_desafiado = ? OR partida.id_equipe_desafiante = ?)
                                    ORDER BY partida.data_fim ASC
                                  ",array($this->session->userdata('id_equipe'),$this->session->userdata('id_equipe')));
        // Alguma partida que você jogou está pedindo para informar placar
        if($query->num_rows() > 0) {
        	$dadosPartida = $query->row();
        	return $dadosPartida;
        } else {
            return false;
        }
    }
    
    public function confirmada($id_convite) {
        $query = $this->db->query("SELECT 
                                            *
                                   FROM
                                            tb_partida_convites convites
                                   WHERE
                                            convites.id_convite = ? AND convites.status = 0
                                  ",array($id_convite));
        // Checar se o convite e o id existe
        if($query->num_rows() > 0) {

            $dados_convite = $query->row();
            
            $this->db->update('tb_partida',array('id_equipe_desafiado' => $dados_convite->id_equipe_desafiada,'status' => 2),"id_partida = $dados_convite->id_partida");

            $dadosUpdate = array(
                            'status'                        => 1,
                            'resposta_equipe_desafiante'    => 1,
                            'data_rsp_desafiante'           => date('Y-m-d H:i:s')
                           );

            $this->db->update('tb_partida_convites',$dadosUpdate,"id_convite = $id_convite");

            return array('erro' => false,'msg' => 'Partida agendada e confirmada com sucesso.');
        } else {
            return array('erro' => true,'msg' => 'ID do convite não existe ou a equipe desafiada não existe.');
        }

    }

    public function autoconvidar($id_partida,$id_equipe_desafiante) {
        $dados_partida      = $this->getByID($id_partida);
        

        $conviteExiste      = $this->db->query("SELECT * FROM brasfut_sistema.tb_partida_convites WHERE id_partida = ? AND id_equipe_desafiada  = ?",array($id_partida,$this->session->userdata()['id_equipe']))->num_rows();

        if($conviteExiste > 0 ){
        	return array('erro' => true, 'msg' => 'Você já enviou um convite.');
        	exit;
        }

        // Partida existe
        if($dados_partida  != false){
            $this->load->model('Convite_model');
            $dadosInsert = array(
                                    'id_equipe_desafiante'      => $id_equipe_desafiante,
                                    'id_equipe_desafiada'       => $this->session->userdata()['id_equipe'],
                                    'id_partida'                => $id_partida,
                                    'resposta_equipe_desafiada' => 1,
                                    'data_rsp_desafiada'        => date('Y-m-d H:i:s'),
                                    'data'                      => date('Y-m-d H:i:s')
                          );
            $this->db->insert('tb_partida_convites',$dadosInsert);            
            return array('erro' => false, 'msg' => 'Um convite foi enviado, aguarde a confirmação da equipe adversária.');
        } else {
            return array('erro' => true, 'msg' => 'A partida que você deseja enviar um convite não existe.');
        }
    }

    public function cancelar($id_partida) {
        $dados_partida      = $this->getByID($id_partida);
        
        // Partida existe
        if($dados_partida  != false){
            // if($dados_partida->id_equipe_desafiante == $this->session->userdata('id_equipe')){

              if($this->DiferenciaDias(date('Y-m-d H:i:s'),$dados_partida->data_inicio) >= 5){
                $this->db->update($this->table,array('status' => 5),"id_partida = $id_partida");
	              return array('erro' => false, 'msg' => 'Sua partida foi cancelada com sucesso.');
          	  } else {
          	  	  return array('erro' => true, 'msg' => 'Sua partida não pode ser cancelada, por causa que você precisava ter solicitado com 5 dias de antecedência');
          	  }
            // } else {
            //   return array('erro' => true, 'msg' => 'Você não pode cancelar uma partida que não é sua.');               
            // }

        } else {
            return array('erro' => true, 'msg' => 'A partida que você deseja cancelar não existe.');
        }
    }

    public function convitesEnviadosByPartida($id_partida) {
        $query = $this->db->query("
            SELECT
                equipe_desafiada.id_equipe,
                equipe_desafiada.nome_equipe,
                equipe_desafiada.logo,
                convites.data,
                convites.data_rsp_desafiada,
                convites.data_rsp_desafiante
            FROM
                tb_partida_convites convites
                LEFT JOIN tb_equipe equipe_desafiada ON equipe_desafiada.id_equipe = convites.id_equipe_desafiada
            WHERE 
                convites.id_partida = ? AND
                convites.id_equipe_desafiante = ?
                AND convites.resposta_equipe_desafiada = 0
                AND convites.resposta_equipe_desafiante = 0",array($id_partida,$this->session->userdata('id_equipe')));

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function convitesAceitosByPartida($id_partida) {
        $query = $this->db->query("
            SELECT
                equipe_desafiada.id_equipe,
                equipe_desafiada.nome_equipe,
                equipe_desafiada.logo,
                convites.id_convite,
                convites.data,
                convites.data_rsp_desafiada,
                convites.data_rsp_desafiante
            FROM
                tb_partida_convites convites
                LEFT JOIN tb_equipe equipe_desafiada ON equipe_desafiada.id_equipe = convites.id_equipe_desafiada
            WHERE 
                convites.id_partida = ? AND
                convites.id_equipe_desafiante = ?
                AND convites.resposta_equipe_desafiada = 1
                AND convites.resposta_equipe_desafiante = 0",array($id_partida,$this->session->userdata('id_equipe')));

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function convitesRecusadosByPartida($id_partida) {
        $query = $this->db->query("
            SELECT
                equipe_desafiada.id_equipe,
                equipe_desafiada.nome_equipe,
                equipe_desafiada.logo,
                convites.data,
                convites.data_rsp_desafiada,
                convites.data_rsp_desafiante
            FROM
                tb_partida_convites convites
                LEFT JOIN tb_equipe equipe_desafiada ON equipe_desafiada.id_equipe = convites.id_equipe_desafiada
            WHERE 
                convites.id_partida = ? AND
                convites.id_equipe_desafiante = ?
                AND convites.resposta_equipe_desafiada = 2
                AND convites.resposta_equipe_desafiante = 0",array($id_partida,$this->session->userdata('id_equipe')));

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function PartidasVisitantes() {
        $query = $this->db->query("
                    SELECT 
                        distinct(partida.id_partida),
                        equipe.nome_equipe,
                        equipe.id_equipe,
                        date_format(partida.data_inicio,'%H:%i') as 'horas_inicio',
                        date_format(partida.data_fim,'%H:%i') as 'horas_fim',
                        CONCAT(local.nome_local,' - ',local.cidade ,'/' , local.uf) as 'localidade',
                        DATE_FORMAT(partida.data_inicio,'%b') as 'mes',
                        DATE_FORMAT(partida.data_inicio,'%d') as 'dia'
                    FROM
                            tb_partida partida
                    LEFT JOIN tb_local local ON local.id_local = partida.id_local
                    LEFT JOIN tb_equipe equipe ON equipe.id_equipe = partida.id_equipe_desafiante
                    LEFT JOIN tb_partida_convites convites ON partida.id_partida = convites.id_partida
                    WHERE
                    partida.privado = 0
                    AND equipe.id_equipe_tipo in (2,3)
                    AND partida.id_equipe_desafiante != ? 
                  #AND convites.id_equipe_desafiada is null
                    AND partida.data_inicio > current_timestamp() 
                    AND equipe.id_categoria = ?
                    AND equipe.id_modalidade = ?
                    AND equipe.uf = ?
                    AND equipe.sexo = ? 
                    AND partida.status = ? ORDER BY partida.data_inicio ASC",array(
                    		$this->session->userdata('id_equipe'),
                    		$this->session->userdata('id_categoria'),
                    		$this->session->userdata('id_modalidade'),
                    		$this->session->userdata('uf_equipe'),
                    		$this->session->userdata('sexo_equipe'),
                    		'0'));

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }


    public function minhasPartidasCriadas() {
        $query = $this->db->query("
                                SELECT 
                                    partida.id_partida,
                                    equipe.nome_equipe,
                                    date_format(partida.data_inicio,'%H:%i') as 'horas_inicio',
                                    date_format(partida.data_fim,'%H:%i') as 'horas_fim',
                                    CONCAT(local.nome_local,' - ',local.cidade ,'/' , local.uf) as 'localidade',
                                    DATE_FORMAT(partida.data_inicio,'%b') as 'mes',
                                    DATE_FORMAT(partida.data_inicio,'%d') as 'dia'
                                FROM
                                    tb_partida partida
                                LEFT JOIN tb_local local ON local.id_local = partida.id_local
                                LEFT JOIN tb_equipe equipe ON equipe.id_equipe = partida.id_equipe_desafiante
                                WHERE partida.id_equipe_desafiante = ? 

                                AND partida.data_inicio > current_timestamp() AND partida.status = ? ORDER BY partida.data_inicio ASC",array($this->session->userdata('id_equipe'),'0'));

        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }



    public function DetalhesPartidaPorID($id) {
        $query = $this->db->query("SELECT 
                                    partida.id_partida,
                                    modalidade.nome_modalidade,
                                    partida.status,
                                    partida.privado,
                                    partida.data_criacao,
                                    equipe_desafiante.id_equipe as 'id_equipe_desafiante',
                                    equipe_desafiante.logo as 'logo_desafiante',
                                    equipe_desafiado.logo as 'logo_desafiado',
                                    equipe_desafiado.id_equipe as 'id_equipe_desafiada',
                                    equipe_desafiante.nome_equipe as 'nome_equipe_desafiante',
                                    resultado.ponto_desafiante as 'pontuacao_desafiante',
                                    equipe_desafiado.nome_equipe as 'nome_equipe_desafiada',
                                    resultado.ponto_desafiado as 'pontuacao_desafiado',
                                    DATE_FORMAT(partida.data_inicio,'%d/%m/%Y') as 'data_partida',
                                    DATE_FORMAT(partida.data_inicio,'%H:%i') as 'hora_inicio_partida',
                                    DATE_FORMAT(partida.data_fim,'%H:%i') as 'hora_fim_partida',
                                    local.*,
                                    pessoa.nome_pessoa as 'responsavel'
    
                                FROM    
                                    tb_partida partida
                                    LEFT JOIN tb_equipe equipe_desafiante ON  equipe_desafiante.id_equipe = partida.id_equipe_desafiante
                                    LEFT JOIN tb_equipe equipe_desafiado  ON  equipe_desafiado.id_equipe = partida.id_equipe_desafiado  
                                    LEFT JOIN tb_modalidade modalidade ON partida.id_modalidade = modalidade.id_modalidade
                                    LEFT JOIN tb_local local ON local.id_local = partida.id_local
                                    LEFT JOIN tb_partida_resultados resultado ON resultado.id_partida = partida.id_partida
                                LEFT JOIN tb_pessoa pessoa ON pessoa.id_pessoa = equipe_desafiante.id_pessoa_responsavel
                                WHERE partida.id_partida = ?",array($id));


        if($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getByID($id) {  
        $query = $this->db->get_where($this->table, array('id_partida' => $id));
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