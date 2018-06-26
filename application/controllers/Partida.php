<?php

	class Partida extends CI_Controller {

		public function criarpartidamandante() {
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_local','ID local','required|numeric');
			$this->form_validation->set_rules('id_equipe_desafiante','ID equipe desafiante','required|numeric');
			$this->form_validation->set_rules('data_inicio','Data entrada','required|exact_length[19]');
			$this->form_validation->set_rules('data_fim','Data fim','required|exact_length[19]');

			if($this->form_validation->run() == false) {
				echo json_encode(array('erro' => true,'msg' => validation_errors()));
			} else {
				$this->load->model('Partida_model');
				echo json_encode($this->Partida_model->criarPartidaMandante($this->input->post('id_local'),$this->input->post('id_equipe_desafiante'),$this->input->post('data_inicio'),$this->input->post('data_fim')));
			}
		}

		public function Listar() {
			$this->load->model('Modalidade_model');
			$this->load->model('Partida_model');
			$this->load->model('Categoria_model');
			$this->load->model('Local_model');
			$view['partidas']			= $this->Partida_model->getPartidas($this->input->get(null,true));
			$view['listarModalidade']	= $this->Modalidade_model->getAll();
			$view['listarCategorias']	= $this->Categoria_model->getAll();
			$view['listarCidades']		= $this->Local_model->getCidades();
			$view['listarEstados']		= $this->Local_model->getEstados();
			$view['listarLocais']		  = $this->Local_model->getLocais();
			$this->template->load('Templates/Dashboard','Partida/Listar',$view);
		}

		public function cancelarreserva() {
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_equipe','ID equipe','required|numeric');
			$this->form_validation->set_rules('data_inicio','Data entrada','required|exact_length[19]');
	
			if($this->form_validation->run() == false) {
				echo json_encode(array('erro' => true,'msg' => validation_errors()));
			} else {
				$this->db->insert('tb_reserva_anulada',array('id_equipe_mandante' => $this->input->post('id_equipe'), 'data' => $this->input->post('data_inicio')));
				echo json_encode(array('erro' => false, 'msg' => 'Sua reserva foi cancelada com sucesso.'));
			}
		}



		public function resultado() {
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_partida','ID da partida','required|numeric');
			$this->form_validation->set_rules('placar','Informe o placar','required|numeric');

			if($this->form_validation->run() == false) {
				echo json_encode(array('erro' => true,'msg' => validation_errors()));
			} else {
				$this->load->model('Partida_model');
				echo json_encode($this->Partida_model->informarPlacar($this->input->post('id_partida'),$this->input->post('placar')));
			}
		}
		
		public function confirmarplacar() {
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_resultado','ID resultado','required|numeric');
			$this->form_validation->set_rules('status','Status','required|numeric');

			if($this->form_validation->run() == false) {
				echo json_encode(array('erro' => true,'msg' => validation_errors()));
			} else {
				$this->load->model('Partida_model');
				echo json_encode($this->Partida_model->confirmarPlacar($this->input->post('id_resultado'),$this->input->post('status')));
			}
		}

		public function placar(){
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_partida','ID da partida','required|numeric');
			$this->form_validation->set_rules('id_equipe_informou','Informou a equipe','required|numeric');
			$this->form_validation->set_rules('ponto_desafiante','Ponto desafiante','required|numeric');
			$this->form_validation->set_rules('ponto_desafiado','Ponto desafiado','required|numeric');


			if($this->form_validation->run() == false) {
				echo json_encode(array('erro' => true, 'msg' => validation_errors()));
			} else {
				$dadosIns = array(
									'id_partida' 				=> $this->input->post('id_partida'),
									'id_equipe_informou'		=> $this->input->post('id_equipe_informou'),
									'ponto_desafiado'			=> $this->input->post('ponto_desafiado'),
									'ponto_desafiante'			=> $this->input->post('ponto_desafiante'),
									'data'						=> date('Y-m-d H:i:s'),
									'status'					=> 2
							);

				$this->db->insert('tb_partida_resultados',$dadosIns);
				echo json_encode(array('erro' => false, 'msg' => 'O placar foi enviado! Aguarde confirmação da outra equipe.'));
			}

		}

		public function confirmada() {
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_convite','ID do convite','required|numeric');

			if($this->form_validation->run() == false) {
				echo json_encode(array('error' => true,'msg' => validation_errors()));
			} else {
				$this->load->model('Partida_model');
				echo json_encode($this->Partida_model->confirmada($this->input->post('id_convite')));
			}
		}

		public function autoconvidar(){
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_partida','ID da partida','required|numeric');
			$this->form_validation->set_rules('id_equipe_desafiante','ID equipe desafiante','required|numeric');

			if($this->form_validation->run() == false) {
				echo json_encode(array('error' => true,'msg' => validation_errors()));
			} else {
				$this->load->model('Partida_model');
				echo json_encode($this->Partida_model->autoconvidar($this->input->post('id_partida'),$this->input->post('id_equipe_desafiante')));
			}
			
		}

		public function autoconvidarmandante(){
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_partida','ID da partida','required|numeric');
			$this->form_validation->set_rules('id_equipe_desafiante','ID equipe desafiante','required|numeric');
			$this->form_validation->set_rules('id_equipe_desafiada','ID equipe desafiada','required|numeric');


			if($this->form_validation->run() == false) {
				echo json_encode(array('erro' => true,'msg' => validation_errors()));
			} else {
				$this->load->model('Convite_model');
				echo json_encode($this->Convite_model->criarConviteMandante($this->input->post('id_partida'),$this->input->post('id_equipe_desafiante'),$this->input->post('id_equipe_desafiada')));
			}
			
		}

		public function cancelarpartidamandante(){
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_partida','ID da partida','required|numeric');
			$this->form_validation->set_rules('id_equipe_desafiante','ID equipe desafiante','required|numeric');
			$this->form_validation->set_rules('data_inicio','Data inicio','required|exact_length[19]');


			if($this->form_validation->run() == false) {
				echo json_encode(array('erro' => true,'msg' => validation_errors()));
			} else {
				$this->load->model('Partida_model');
				$this->db->insert('tb_reserva_anulada',array('id_equipe_mandante' => $this->input->post('id_equipe_desafiante'), 'data' => $this->input->post('data_inicio')));
				$this->Partida_model->cancelar($this->input->post('id_partida'));
				echo json_encode(array('erro' => false,'msg' => 'Partida cancelada com sucesso'));
			}
			
		}

		public function cancelar(){
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_partida','ID da partida','required|numeric');

			if($this->form_validation->run() == false) {
				echo json_encode(array('error' => true,'msg' => validation_errors()));
			} else {
				$this->load->model('Partida_model');
				echo json_encode($this->Partida_model->cancelar($this->input->post('id_partida')));
			}
			
		}

		public function detalhes($id_partida) {
			$this->load->model('Partida_model');

			$partidaExiste 			= $this->Partida_model->DetalhesPartidaPorID($id_partida);

			if($partidaExiste != false) {
				$view['partida'] 				= $partidaExiste;


				$this->db->insert('tb_partida_visualizacao',array('id_partida' => $id_partida,'id_equipe' => $this->session->userdata('id_equipe'), 'data' => date('Y-m-d H:i:s')));				

				if($partidaExiste->id_equipe_desafiante == $this->session->userdata('id_equipe')) {
					$view['equipesConvidadas']				=   $this->Partida_model->convitesEnviadosByPartida($id_partida);
					$view['convitesAceitos']				=   $this->Partida_model->convitesAceitosByPartida($id_partida);
					$view['convitesRecusados']				=   $this->Partida_model->convitesRecusadosByPartida($id_partida);
					$view['listarEquipesVisualizaramPartida']	=  	$this->Partida_model->listarEquipesVisualizaramPartida($id_partida);
				} 

				$this->template->load('Templates/Dashboard','Partida/Detalhes',$view);
			} else {
				redirect('/');
			}
		}


		public function agendarpost() {
			header("Content-type: application/json");
			$this->form_validation->set_rules('id_local','Local','required|numeric');
			$this->form_validation->set_rules('data','Data partida do Ìnicio','required|exact_length[10]');
			$this->form_validation->set_rules('inicio','Horário do Ìnicio da partida','required|exact_length[5]');
			$this->form_validation->set_rules('fim',' Horário do fim da partida','required|exact_length[5]');
			$this->form_validation->set_rules('privado','Partida privada','required|numeric');


			if($this->input->post('privado') == 1) {
				$this->form_validation->set_rules('id_equipes_convidadas[]','Equipe convidados','required');
				
				if(count($_POST['id_equipes_convidadas']) < 1) {
					echo json_encode(array('error' => true, 'msg' => 'Você precisa convidar pelo menos 1 equipe.'));
					exit;
				}

			}


			if($this->form_validation->run() == false) {
				echo json_encode(array('error' => true,'msg' => validation_errors()));
			} else {

				$timestamp 		= 	time();
				$data_inicio 	= 	$this->input->post('data') . ' '. $this->input->post('inicio').':00';
				$data_inicio 	=	date('Y-m-d H:i:s',strtotime($data_inicio));

				$data_fim 		=   $this->input->post('data') . ' '. $this->input->post('fim').':00';
				$data_fim 		=	date('Y-m-d H:i:s',strtotime($data_fim));

				if(strtotime($data_inicio) <= $timestamp) {
					$erro[] = "A data da partida <b>'".date('d/m/Y H:i:s',strtotime($data_inicio))."'</b> não pode ser menor que a data atual <b>'".date('d/m/Y H:i:s')."'</b>";					
				}

				if(strtotime($data_fim) <= strtotime($data_inicio)) {
					$erro[] = "O horário do fim da partida <b>'".$this->input->post('fim')."'</b> não pode ser menor do que o horário do inicio da partida <b>'".$this->input->post('inicio')."'</b> ";					
				}

				if(strtotime($data_fim) <= $timestamp){
					$erro[] = "A data do fim da partida <b>'".date('d/m/Y H:i:s',strtotime($data_fim))."'</b> não pode ser menor que a data atual <b>'".date('d/m/Y H:i:s')."'</b>.";					
				}

				$datetime1 			 = strtotime("$data_inicio");
				$datetime2 			 = strtotime("$data_fim");
				$interval  			 = abs($datetime2 - $datetime1);
				$diferenciaMinutos   = round($interval / 60);

				if($diferenciaMinutos < 30) {
					$erro[] = "A duração de uma partida precisa ter pelo menos 30 minutos de duração";
				}

				if($diferenciaMinutos > 180) {
					$erro[] = "A duração de uma partida não pode passar de 4 horas de duração";
				}
				

				if(count($erro) > 0) {
					echo json_encode(array('error' => true,'msg' => implode($erro,'<br>')));
					exit;
				} else {

					$this->load->model('Partida_model');

					$insertArray = array(
									'id_equipe_desafiante' => $this->session->userdata()['id_equipe'],
									'data_inicio'		   => $data_inicio,
									'data_fim'			   => $data_fim,
									'id_modalidade'		   => $this->session->userdata()['id_modalidade'],
									'id_local'			   => $this->input->post('id_local'),
									'status'			   => 0,
									'privado'			   => $this->input->post('privado'),
									'data_criacao'		   => date('Y-m-d H:i:s')
								   );

					$partidaCriadaSucesso = $this->Partida_model->insert($insertArray);
					$id_partida 		  = $this->Partida_model->last_insert_id;

					if($partidaCriadaSucesso == true) {

						if(count($_POST['id_equipes_convidadas']) != 0){

							$this->load->model('Equipe_model');
							$this->load->model('Notificacao_model');

							foreach ($_POST['id_equipes_convidadas'] as $key => $id_equipe_desafiada) {
								if($this->session->userdata()['id_equipe'] != $id_equipe_desafiada) {
									
									$EquipeDesafiada 	= $this->Equipe_model->getByResponsabelByEquipe($id_equipe_desafiada);
									$EquipeDesafiante = $this->Equipe_model->getByResponsabelByEquipe($this->session->userdata()['id_equipe']);

									$msg = "
									A equipe ".$EquipeDesafiante->nome_equipe." convidou você para uma partida <a target='_BLANK' href='".base_url('partida/detalhes/'.$id_partida)."'>Ver detalhes</a>

									";

									$this->Notificacao_model->Notificacao($EquipeDesafiada->id_pessoa,$msg);


									$dadosInsert = array(
															'id_equipe_desafiante' 	=> $this->session->userdata()['id_equipe'],
															'id_equipe_desafiada'  	=> $id_equipe_desafiada,
															'id_partida'		   			=> $id_partida,
															'data'				   				=> date('Y-m-d H:i:s')
												  );
									$this->db->insert('tb_partida_convites',$dadosInsert);
								}
							}
						}

						echo json_encode(array('error' => false,
							'msg' => 'Sua partida foi criada com sucesso! Aguarde a resposta dos adversários em sua dashboard... aguarde você será redirecionado.
							<script>$(".ajax-post").trigger(\'reset\');     

								setTimeout(function(){
		    									window.location.href = "'.base_url('partida/detalhes/'.$id_partida).'";

		          				},5000);


							</script> '));
					}

				}
			}

		}

		public function agendar() {
				
				$this->load->model('Local_model');
				$this->load->model('Modalidade_model');
				$this->load->model('Equipe_model');
			
				$view['listarLocal'] 		= $this->Local_model->getAllByModalidade();
				$view['listarModalidade']	= $this->Modalidade_model->getAll();
				$view['listarEquipes']		= $this->Equipe_model->getAll();
				
				$this->template->load('Templates/Dashboard','Partida/Agendar',$view);
		}

		public function Cadastrar()
			{
				
				if($this->input->post() == true) {

						$this->load->model('Partida_Model');

						header("Content-type: application/json");

					 	$this->form_validation->set_rules('nome_categoria', 'Nome da Categoria', 'required');
					 	
		                if ($this->form_validation->run() == FALSE)
		                {
		             		echo json_encode(array('erro' => true, 'msg' => validation_errors()));
		             		exit;
		                }
		                	else
		                {

		                	$dados = array(
		                				'id_equipe_desafiante'		=> '',
		                				'data_inicio'				=> '',
		                				'data_fim'					=> '',
		                				'id_modalidade'				=> '',
		                				'descricao'					=> '',
		                				'id_campo'					=> '',
		                				'publico'					=> '',
		                				'data_criacao'				=> date('Y-m-d H:i:s')
		                			 );
		                   
		                	if($this->Partida_Model->insert($dados)){
		               			echo json_encode(array('erro' => false, 'msg' => 'Partida cadastrada com sucesso.'));
		                	}
		                }
				}
			}
		
	}

?>