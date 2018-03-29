<?php



class Equipe extends CI_Controller {





	public function uploademblema() {

   				$config['upload_path']          = 'assets/imagem/equipe';

                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                
                $config['min_width']            = '200';
                $config['min_height']           = '200';

                $config['max_width']            = '1300';
                $config['max_height']           = '1300';


                $config['file_name']			= $this->session->userdata('id_equipe');

                $config['overwrite']			= true;

           

                $this->load->library('upload', $config);



                if ( ! $this->upload->do_upload('emblema'))

                {

                        $view['uploadRetorno'] = $this->upload->display_errors() . ' Tamanho 200x200 até 1300x1300';

                        $this->template->load('Templates/Dashboard','Dashboard/index',$view);

	

                }

                else

                {



                		$id_equipe = $this->session->userdata('id_equipe');

                		$this->db->update('tb_equipe',array('logo' => base_url('assets/imagem/equipe/'.$this->upload->data('file_name'))),"id_equipe = $id_equipe");

                		$this->session->set_userdata('logo',base_url('assets/imagem/equipe/'.$this->upload->data('file_name')));

    			        $view['uploadRetorno'] = "Imagem enviada com sucesso";

    			        redirect('/');

                }

		}



		public function Detalhes($id_equipe){

			$this->load->model('Equipe_model');



			$EquipeExiste 			= $this->Equipe_model->DetalhesEquipePorID($id_equipe);



			if($EquipeExiste != false) {

				$view['equipe'] 						= $EquipeExiste;

				$view['estatisticas']					= $this->Equipe_model->getEstasticas($id_equipe); 

				$this->template->load('Templates/Dashboard','Equipe/Detalhes',$view);

			} else {

				redirect('/');

			}

		}



		public function Cadastrar()

			{

				

				if($this->input->post() == true) {



						$this->load->model('Equipe_model');

						$this->load->model('Pessoa_model');



						header("Content-type: application/json");



						if($this->Pessoa_model->getByEmail(trim($this->input->post('email_responsavel'))) != false){

				  			echo json_encode(array('error' => true, 'msg' => 'O email do responsável <b>'.trim($this->input->post('email_responsavel')).'</b> já existe em nosso sistema.'));

				  			exit;

						}



						if($this->Pessoa_model->getByCpf(trim($this->input->post('cpf_responsavel'))) != false){

				  			echo json_encode(array('error' => true, 'msg' => 'O cpf do responsável <b>'.trim($this->input->post('cpf_responsavel')).'</b> já existe em nosso sistema.'));

				  			exit;

						}



						if($this->Equipe_model->getByNome(trim($this->input->post('nome_equipe'))) != false){

				  			echo json_encode(array('error' => true, 'msg' => 'O nome desta equipe já existe <b>'.trim($this->input->post('nome_equipe')).'</b> já existe em nosso sistema.'));

				  			exit;

						}







					 	$this->form_validation->set_rules('nome_responsavel', 'Nome do responsável do time', 'required|max_length[40]|min_length[6]');

					 	$this->form_validation->set_rules('sexo_responsavel', 'Sexo do(a) responsável do time', 'required');

					 	$this->form_validation->set_rules('cpf_responsavel', 'CPF do responsável', 'required|exact_length[14]');

					 	$this->form_validation->set_rules('data_nascimento_responsavel', 'Data de nascimento do responsável', 'required|exact_length[10]');

					 	$this->form_validation->set_rules('email_responsavel', 'Email do responsável', 'required|valid_email');

					 	$this->form_validation->set_rules('senha_responsavel', 'Senha do responsável', 'required|min_length[4]|max_length[12]');

					 	$this->form_validation->set_rules('celular_responsavel', 'Celular do responsável', 'required|exact_length[15]');

					 	$this->form_validation->set_rules('cep_responsavel', 'CEP do responsável', 'required|exact_length[9]');

					 	$this->form_validation->set_rules('nome_equipe', 'Nome da equipe', 'required|min_length[6]|max_length[30]');

					 	$this->form_validation->set_rules('data_fundacao', 'Data da fundação da equipe', 'required|exact_length[10]');

					 	$this->form_validation->set_rules('id_modalidade', 'Modalidade da equipe', 'required|numeric');

					 	$this->form_validation->set_rules('id_categoria', 'Categoria da equipe', 'required|numeric');

					 	$this->form_validation->set_rules('tipo', 'Tipo da Equipe', 'required|numeric');

					 	$this->form_validation->set_rules('uf_responsavel', 'UF do local do responsável', 'required|exact_length[2]');

				 		$this->form_validation->set_rules('bairro_responsavel', 'Bairro do responsável', 'required');

				 		$this->form_validation->set_rules('endereco_responsavel', 'Endereço do responsável', 'required');

				 		$this->form_validation->set_rules('numero_responsavel', 'N° do endereço do responsável', 'required');

				 		$this->form_validation->set_rules('concordo','Você precisa concordar com o regulamento da Brasfut','required');



				 		$cep_inicio = (int) str_replace('-','',$this->input->post('cep_responsavel'));

				 		$cep_fim 	= (int) str_replace('-','',$this->input->post('cep_responsavel'));



				 		// if($cep_inicio >= 13000000 AND $cep_fim <= 13139999){



				 		// } else {

				 		// 	echo json_encode(array('error' => true, 'msg' => 'Infelizmente, por enquanto só estamos aceitamos cadastro de novas equipes da região de <b>Campinas/SP</b> CEP entre <b>13000-000</b> ao <b>13139-999</b>'));

				 		// 		exit;

				 		// }



				 		for ($i=0; $i < count($this->input->post('dia_da_semana')); $i++) {

					 		$_POST['dia_da_semana_'.$i] = $_POST['dia_da_semana'][$i];

					 		$_POST['hora_inicio_'.$i]	= $_POST['hora_inicio'][$i];

					 		$_POST['fim_inicio_'.$i]    = $_POST['fim_inicio'][$i];



					 		$this->form_validation->set_rules('dia_da_semana_'.$i, '# '.$i.' Dia da semana do mandante', 'required|numeric');

					 		$this->form_validation->set_rules('hora_inicio_'.$i, '# '.$i.' Hora do ínicio do mandante', 'required|exact_length[5]');

					 		$this->form_validation->set_rules('fim_inicio_'.$i, '# '.$i.' Hora do fim do mandante', 'required|exact_length[5]');

						 }





					 	if($this->input->post('tipo') != 2 AND !is_numeric($this->input->post('local_existente'))) {

						 	$this->form_validation->set_rules('nome_local_mandate', 'Local do time mandante', 'required|min_length[4]|max_length[30]');

						 	$this->form_validation->set_rules('cep_local_mandante', 'Cep do local do time mandante', 'required|exact_length[9]');

						 	$this->form_validation->set_rules('uf_mandante', 'UF do local do mandante', 'required|exact_length[2]');

					 		$this->form_validation->set_rules('bairro_mandante', 'Bairro do mandante', 'required');

					 		$this->form_validation->set_rules('endereco_mandante', 'Endereço do mandante', 'required');

					 		$this->form_validation->set_rules('numero_mandante', 'N° do endereço do mandante', 'required');

					 	}

					 	

		                if ($this->form_validation->run() == FALSE)

		                {

		             		echo json_encode(array('error' => true, 'msg' => validation_errors()));

		             		exit;

		                }

		                	else

		                {



			    //             $captcha = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LcXvhkUAAAAACLKWXzYmsyYpIRD6ELq1yVqL1us&response=".$this->input->post('g-recaptcha-response')."&remoteip=".$_SERVER['HTTP_X_FORWARDED_FOR']));



							// if ($captcha->success == false) {

							//     echo json_encode(array('error' => true, 'msg' => 'O captcha está errado tente novamente.'));

							//     exit;

							// }



		                	$pessoa 	= array(

		                					'id_perfil' 		=> 3,

		                					'nome_pessoa'		=> removerAcento(trim($this->input->post('nome_responsavel'))),

		                					'sexo'				=> $this->input->post('sexo_responsavel'),

		                					'cpf'				=> trim($this->input->post('cpf_responsavel')),

		                					'email'				=> $this->input->post('email_responsavel'),

		                					'senha'				=> $this->input->post('senha_responsavel'),

		                					'cep'				=> $this->input->post('cep_responsavel'),

		                					'cidade'			=> strtoupper(removerAcento(trim($this->input->post('cidade_responsavel')))),

		                					'uf'				=> strtoupper(removerAcento(trim($this->input->post('uf_responsavel')))),

		                					'bairro'			=> strtoupper(removerAcento(trim($this->input->post('bairro_responsavel')))),

		                					'rua'				=> strtoupper(removerAcento(trim($this->input->post('endereco_responsavel')))),

		                					'rua_numero'		=> $this->input->post('numero_responsavel'),

		                					'telefone'			=> $this->input->post('telefone_responsavel'),

		                					'celular'			=> $this->input->post('celular_responsavel'),

		                					'data_nascimento'	=> $this->input->post('data_nascimento_responsavel'),

		                					'data_cadastro'		=> date('Y-m-d H:i:s'),

		                					'status'			=> 1

		                				

		                				 );



		                	$this->db->insert('tb_pessoa',$pessoa);

		                	$id_pessoa 		= $this->db->insert_id();







		                	if(!is_numeric($this->input->post('local_existente'))) {

			                	if($this->input->post('tipo') == '1' OR $this->input->post('tipo') == '3'){

			                		$dadosLocalMando = array(

										'nome_local' 		=> strtoupper(removerAcento(trim($this->input->post('nome_local_mandate')))),

										'id_modalidade'		=> $this->input->post('id_modalidade_mandante'),

										'cep'		 		=> trim($this->input->post('cep_local_mandante')),

										'uf'		 		=> strtoupper(trim($this->input->post('uf_mandante'))),

										'cidade'		    => strtoupper(removerAcento(trim($this->input->post('cidade_mandante')))),

										'bairro'	 		=> strtoupper(removerAcento(trim($this->input->post('bairro_mandante')))),

										'endereco'	 		=> strtoupper(removerAcento(trim($this->input->post('endereco_mandante')))),

										'numero'	 		=> trim($this->input->post('numero_mandante'))

									);



			                		$this->db->insert('tb_local',$dadosLocalMando);

			                		$id_local = $this->db->insert_id();



			                	}

		                	} else {

		                		$id_local = $this->input->post('local_existente');

		                	}



		                	$dadosEquipe 		= array(

			                				'id_pessoa_responsavel' 	=> $id_pessoa,

			                				'id_modalidade' 			=> $this->input->post('id_modalidade'),

			                				'id_categoria' 				=> $this->input->post('id_categoria'),

			                				'nome_equipe' 				=> $this->input->post('nome_equipe'),

			                				'cores_predominantes'		=> $this->input->post('cores'),

			                				'sexo'						=> $this->input->post('sexo_equipe'),

			                				'id_equipe_tipo'			=> $this->input->post('tipo'),

			                				'cidade'					=> strtoupper(removerAcento(trim($this->input->post('cidade_responsavel')))),

		                					'uf'						=> strtoupper(removerAcento(trim($this->input->post('uf_responsavel')))),

		                					'bairro'					=> strtoupper(removerAcento(trim($this->input->post('bairro_responsavel')))),

		                					'data_fundacao'				=> $this->input->post('data_fundacao'),

		                					'data_cadastro'				=> date('Y-m-d H:i:s'),

			                				'id_local_mandante'			=> $id_local

		                			 	 );

		                   

		                	$this->db->insert('tb_equipe',$dadosEquipe);

		                	$id_equipe = $this->db->insert_id();



		                	if(count($_POST[dia_da_semana]) > 0){

		                		for ($i=0; $i < count($_POST[dia_da_semana]); $i++) { 

		                			$semana_id 		= $_POST['dia_da_semana'][$i];

		                			$hora_inicio 	= $_POST['hora_inicio'][$i];

		                			$fim_inicio 	= $_POST['fim_inicio'][$i];



		                			$semanaID = array(

		                								'0' => 'Domingo',

		                								'1' => 'Segunda',

		                								'2' => 'TERÇA',

		                								'3' => 'Quarta',

		                								'4' => 'Quinta',

		                								'5' => 'Sexta',

		                								'6' => 'Sábado'

		                							 );



		                			$dadosSemanaMando = array(

		                									'id_equipe' 	=> $id_equipe,

		                									'id_semana' 	=> $semana_id,

		                									'hora_inicio'	=> $hora_inicio,

		                									'hora_fim'		=> $fim_inicio,

		                									'semana'		=> strtoupper($semanaID[$semana_id])

		                								);



		                			$this->db->insert('tb_equipe_disponibilidade',$dadosSemanaMando);



		                		}

		                	}





		          			echo json_encode(array('error' => false, 'msg' => 'Equipe cadastrada com sucesso! Aguarde, você será redirecionado.<script>

		          				setTimeout(function(){
		          					window.location.href = "'.base_url('login').'";
		          				},3000);

		          				 </script>'));

		             		



		                }

				} else {



					$this->load->model('Categoria_model');

					$this->load->model('Modalidade_model');



					$view = array(

									'listarCategoria'  => $this->Categoria_model->getAll(),

								 	'listarModalidade' => $this->Modalidade_model->getAll()

								 );



					$this->load->view('Equipe/Cadastrar',$view);

				}

			}

}