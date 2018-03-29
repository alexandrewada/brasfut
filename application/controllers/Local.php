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
			$this->form_validation->set_rules('telefone_local','Telefone','required|exact_length[14]');

			
			if($this->form_validation->run() == false) {
				echo json_encode(array('error' => true,'msg' => validation_errors()));
				exit;
			} else {
				$this->load->model('Local_model');
				if($this->Local_model->Cadastrar($this->input->post(NULL,true))){
					echo json_encode(array('error' => false,'msg' => 'Local cadastrado com sucesso. <script>$(".ajax-post").trigger(\'reset\');</script>'));
		
				}
			
			}
	}

	public function Listar() {
		$this->load->model('Modalidade_model');
		$this->load->model('Local_model');
		$view['listarModalidade']	= $this->Modalidade_model->getAll();
		$view['listarEstruturas']	= $this->Local_model->getEstruturas();
		$view['listarCidades']		= $this->Local_model->getCidades();
		$view['listarLocais']		= $this->Local_model->getAllFilters($this->input->get(null,true));
		$this->template->load('Templates/Dashboard','Local/Listar',$view);
	}

	public function Cadastrar() {
		$this->load->model('Modalidade_model');
		$this->load->model('Local_model');
		$view['listarModalidade']	= $this->Modalidade_model->getAll();
		$view['listarEstruturas']	= $this->Local_model->getEstruturas();
		$this->template->load('Templates/Dashboard','Local/Cadastrar',$view);
	}

}