<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function index()
	{

		$this->load->model('Convite_model');
		$this->load->model('Partida_model');
		$this->load->model('Equipe_model');

		$view['listarConvitesAceitos']	    	= $this->Convite_model->listarConvitesAceitos();
		$view['listarConvitesRecebidos']		= $this->Convite_model->listarConvitesRecebidos($this->session->userdata('id_equipe'));
		$view['listarMinhasPartidas']			= $this->Partida_model->minhasPartidasCriadas();
		$view['listarEntreVisitantes']			= $this->Partida_model->PartidasVisitantes();
		$view['resultadoPendente']				= $this->Partida_model->ResultadoPartidaFinalizada();
		$view['listarPartidasAgendadas']    	= $this->Partida_model->partidasAgendadas();
		$view['estatisticas']					= $this->Equipe_model->getEstasticas(); 
		$view['listarPartidasMandantes'] 		= $this->Partida_model->listarPartidasMandates();
		$view['listarMinhasPartidasMandantes'] 	= $this->Partida_model->listarMinhasPartidasMandates();
		$view['listarMinhasPartidasRealizadas']  = $this->Partida_model->listarMinhasPartidasRealizadas();
		$view['listarUltimasPartidasRealizadas'] = $this->Partida_model->listarUltimasPartidasRealizadas();

		$this->template->load('Templates/Dashboard','Dashboard/index',$view);
	}

	public function sair() {
	    $this->session->sess_destroy();
	    session_destroy();
		redirect();
	}

}
