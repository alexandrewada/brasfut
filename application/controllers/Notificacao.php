<?php 
class Notificacao extends CI_Controller {

	public function Index() {
			$this->load->model('Notificacao_model');			
			$view['notificacoes'] = $this->Notificacao_model->getNotificacoes($this->session->userdata()['id_pessoa']);
	}
	
}