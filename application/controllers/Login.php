<?php

class Login extends CI_Controller {

	public function index() {
		$this->load->view('Login/index');
	}

	public function esquecisenha() {
		if($this->input->server('REQUEST_METHOD') == 'GET'){
			$this->load->view('Login/esqueci-senha');
		} else {
			header("Content-type: application/json");
			$this->load->model('Login_model');
			echo json_encode($this->Login_model->resetarSenha($this->input->post('email')));
		}
	}

	public function action(){
		header("Content-type: application/json");
		$this->load->model('Login_model');
		$logar = $this->Login_model->Login("$_POST[email]", "$_POST[senha]");

		if($logar == false) {
			echo json_encode(array('error' => true,'msg' => 'Email ou a senha está errada.'));
		} else {
			$logar['logado'] = true;
			$this->session->set_userdata($logar);
			echo json_encode(array('error' => false,'msg' => 'Logado com sucesso.' , 'urlRedirect' => base_url('dashboard')));
		}
	}
	
}