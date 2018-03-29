<?php 

class Convite extends CI_Controller {

	public function resposta() {
		header("Content-Type: application/json");
		$this->form_validation->set_rules('id_convite','ID do convite','required|numeric');
		$this->form_validation->set_rules('status','Status da resposta','required|numeric');
	
		if($this->form_validation->run() == FALSE) {
			echo json_encode(array('erro' => true, 'msg' => validation_errors()));
		} else {
			$this->load->model('Convite_model');
			echo json_encode($this->Convite_model->respostaConvite($this->input->post('id_convite'),$this->input->post('status')));
		}
	}

	public function criarConvite(){
		header("Content-Type: application/json");
		$this->form_validation->set_rules('id_partida','ID partida','required|numeric');
		$this->form_validation->set_rules('id_equipe_desafiante','ID equipe desafiante','required|numeric');
		$this->form_validation->set_rules('id_equipe_desafiada','ID equipe desafianta','required|numeric');

		if($this->form_validation->run() == FALSE) {
			echo json_encode(array('erro' => true, 'msg' => validation_errors()));
		} else {
			$this->load->model('Convite_model');
			echo json_encode($this->Convite_model->criarConvite($this->input->post('id_partida'),$this->input->post('id_equipe_desafiante'),$this->input->post('id_equipe_desafiada')));
		}
	}

	public function cancelar() {
		header("Content-Type: application/json");
		$this->form_validation->set_rules('id_convite','ID do convite','required|numeric');
	
		if($this->form_validation->run() == FALSE) {
			echo json_encode(array('erro' => true, 'msg' => validation_errors()));
		} else {
			$this->load->model('Convite_model');
			echo json_encode($this->Convite_model->cancelarConvite($this->input->post('id_convite')));
		}
	}


}
