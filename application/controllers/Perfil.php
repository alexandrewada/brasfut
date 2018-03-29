<?php

	class Perfil extends CI_Controller {
		public function Editar() {
			$this->load->model('Pessoa_model');
			$this->load->model('Equipe_model');
			$view['pessoa'] 			= $this->Pessoa_model->getByID($this->session->userdata('id_pessoa'));
			$view['equipe'] 			= $this->Equipe_model->getByIDResponsavel($this->session->userdata('id_pessoa'));
			$view['disponibilidades']	= $this->Equipe_model->getDisponibilidadeById($view['equipe']->id_equipe);
			$this->template->load('Templates/Dashboard','Perfil/Editar',$view);
		}

		public function Atualizar(){
			
		header("Content-type: application/json");				
		if($this->input->post() == true) {

				$this->load->model('Equipe_model');
				$this->load->model('Pessoa_model');


			 	$this->form_validation->set_rules('nome_responsavel', 'Nome do responsável do time', 'required|max_length[40]|min_length[6]');
			 	$this->form_validation->set_rules('sexo_responsavel', 'Sexo do(a) responsável do time', 'required');
			 	$this->form_validation->set_rules('data_nascimento_responsavel', 'Data de nascimento do responsável', 'required|exact_length[10]');
			 	$this->form_validation->set_rules('senha_responsavel', 'Senha do responsável', 'required|min_length[4]|max_length[12]');
			 	$this->form_validation->set_rules('celular_responsavel', 'Celular do responsável', 'required|exact_length[15]');
			 	$this->form_validation->set_rules('cep_responsavel', 'CEP do responsável', 'required|exact_length[9]');
			 	$this->form_validation->set_rules('uf_responsavel', 'UF do local do responsável', 'required|exact_length[2]');
		 		$this->form_validation->set_rules('bairro_responsavel', 'Bairro do responsável', 'required');
		 		$this->form_validation->set_rules('endereco_responsavel', 'Endereço do responsável', 'required');
		 		$this->form_validation->set_rules('numero_responsavel', 'N° do endereço do responsável', 'required');
		 		

		 		for ($i=0; $i < count($this->input->post('dia_da_semana')); $i++) {
			 		$_POST['dia_da_semana_'.$i] = $_POST['dia_da_semana'][$i];
			 		$_POST['hora_inicio_'.$i]	= $_POST['hora_inicio'][$i];
			 		$_POST['fim_inicio_'.$i]    = $_POST['fim_inicio'][$i];

			 		$this->form_validation->set_rules('dia_da_semana_'.$i, '# '.$i.' Dia da semana do mandante', 'required|numeric');
			 		$this->form_validation->set_rules('hora_inicio_'.$i, '# '.$i.' Hora do ínicio do mandante', 'required');
			 		$this->form_validation->set_rules('fim_inicio_'.$i, '# '.$i.' Hora do fim do mandante', 'required');
				 }

			 	
                if ($this->form_validation->run() == FALSE)
                {
             		echo json_encode(array('error' => true, 'msg' => validation_errors()));
             		exit;
                }
                	else
                {


                	$pessoa 	= array(
                					'nome_pessoa'		=> removerAcento(trim($this->input->post('nome_responsavel'))),
                					'sexo'				=> $this->input->post('sexo_responsavel'),
                					'senha'				=> $this->input->post('senha_responsavel'),
                					'cep'				=> $this->input->post('cep_responsavel'),
                					'cidade'			=> strtoupper(removerAcento(trim($this->input->post('cidade_responsavel')))),
                					'uf'				=> strtoupper(removerAcento(trim($this->input->post('uf_responsavel')))),
                					'bairro'			=> strtoupper(removerAcento(trim($this->input->post('bairro_responsavel')))),
                					'rua'				=> strtoupper(removerAcento(trim($this->input->post('endereco_responsavel')))),
                					'rua_numero'		=> $this->input->post('numero_responsavel'),
                					'telefone'			=> $this->input->post('telefone_responsavel'),
                					'celular'			=> $this->input->post('celular_responsavel'),
                					'data_nascimento'	=> $this->input->post('data_nascimento_responsavel')				
                				 );

                	$id_equipe = $this->session->userdata('id_equipe');
                	$id_pessoa = $this->session->userdata('id_pessoa');
                	$this->db->update('tb_pessoa',$pessoa,"id_pessoa = $id_pessoa");
                

               
                	if(count($_POST[dia_da_semana]) > 0){
                		for ($i=0; $i < count($_POST[dia_da_semana]); $i++) { 
                			$semana_id 				= $_POST['dia_da_semana'][$i];
                			$hora_inicio 			= $_POST['hora_inicio'][$i];
                			$fim_inicio 			= $_POST['fim_inicio'][$i];
                			$id_disponibilidade		= $_POST['id_disponibilidade'][$i];

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
                									'id_semana' 	=> $semana_id,
                									'hora_inicio'	=> $hora_inicio,
                									'hora_fim'		=> $fim_inicio,
                									'semana'		=> strtoupper($semanaID[$semana_id])
                								);

                			$this->db->update('tb_equipe_disponibilidade',$dadosSemanaMando,array('id_disponibilidade' => $id_disponibilidade));

                		}
                	}

          			echo json_encode(array('error' => false, 'msg' => 'Dados atualizados com sucesso <script>window.location.href = "'.base_url('perfil/editar').'"; </script>'));             		

                }
		} 
	}
}

?>