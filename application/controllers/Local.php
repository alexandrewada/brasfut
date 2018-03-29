<?php

class Local extends CI_Controller {

	public function listarLocalModalidade($id_modalidade) {
		$query = $this->db->query("SELECT * FROM tb_local local WHERE local.id_modalidade = ?",array($id_modalidade));
		
		if($query->num_rows() > 0) {
			foreach ($query->result() as $key => $v) {
				echo '<option value="'.$v->id_local.'">'.$v->nome_local.' - ' . $v->uf.'/'.$v->cidade.' </option>';
			}
		} 
	}

	public function cadastrarpost() {
			header("Content-type: application/json");
			$this->form_validation->set_rules('nome_local','Nome local','required|min_length[4]|max_length[40]');
			$this->form_validation->set_rules('id_modalidade','Modalidade do Local','required|numeric');
			$this->form_validation->set_rules('cep','CEP do local','required|exact_length[9]');
			$this->form_validation->set_rules('uf','UF do local','required|exact_length[2]');
			$this->form_validation->set_rules('bairro','Bairro do local','required');
			$this->form_validation->set_rules('endereco','Endereço do local','required');
			$this->form_validation->set_rules('numero','Número do local','required|min_length[1]|max_length[8]');
			

			$cep_inicio = (int) str_replace('-','',$this->input->post('cep'));
	 		$cep_fim 	= (int) str_replace('-','',$this->input->post('cep'));

	 		// if($cep_inicio >= 13000000 AND $cep_fim <= 13139999){

	 		// } else {
	 		// 	echo json_encode(array('error' => true, 'msg' => 'Infelizmente, por enquanto só estamos aceitando cadastro de novos locais da região de <b>Campinas/SP</b> CEP entre <b>13000-000</b> ao <b>13139-999</b>'));
	 		// 		exit;
	 		// }

			if($this->form_validation->run() == false) {
				echo json_encode(array('error' => true,'msg' => validation_errors()));
				exit;
			} else {
				$this->load->model('Local_model');

				$dadosInsert = array(
									'nome_local' 		=> strtoupper(removerAcento(trim($this->input->post('nome_local')))),
									'id_modalidade'		=> trim($this->input->post('id_modalidade')),
									'cep'		 		=> trim($this->input->post('cep')),
									'uf'		 		=> strtoupper(trim($this->input->post('uf'))),
									'cidade'		    => strtoupper(removerAcento(trim($this->input->post('cidade')))),
									'bairro'	 		=> strtoupper(removerAcento(trim($this->input->post('bairro')))),
									'endereco'	 		=> strtoupper(removerAcento(trim($this->input->post('endereco')))),
									'numero'	 		=> trim($this->input->post('numero'))
								);
				$this->Local_model->insert($dadosInsert);
				echo json_encode(array('error' => false,'msg' => 'Local cadastrado com sucesso. <script>$(".ajax-post").trigger(\'reset\');</script>'));
	
			}
	}

	public function Cadastrar() {
		$this->load->model('Modalidade_model');
		$view['listarModalidade']	= $this->Modalidade_model->getAll();
		$this->template->load('Templates/Dashboard','Local/Cadastrar',$view);
	}

}