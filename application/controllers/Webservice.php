<?php



class Webservice extends CI_Controller {





	public function listarEquipes(){

		$this->load->model('Webservice_model');

		$view['listarEquipes'] = $this->Webservice_model->listarEquipes();

		$this->template->load('Webservice/wordpress/templateDatatable','Webservice/wordpress/listarEquipes',$view);

	}



	public function listarPartidasMarcadas() {

		$this->load->model('Webservice_model');

        $this->load->model('Modalidade_model');

        $this->load->model('Equipe_model');



        $view['listarModalidades']        = $this->Modalidade_model->getAll();

        $view['listarTipos']              = $this->Equipe_model->getTipos();

        $view['listarPartidas']           = $this->Webservice_model->listarPartidas(2,$_GET);

		$this->template->load('Webservice/wordpress/templateDatatable','Webservice/wordpress/listarPartidasMarcadas',$view);

	}



    public function listarPartidasRealizadas() {

        $this->load->model('Webservice_model');

        $this->load->model('Modalidade_model');

        $this->load->model('Equipe_model');

        $view['listarPartidasRealizadas'] = $this->Webservice_model->listarPartidasRealizadas($_GET);

        $view['listarModalidades']        = $this->Modalidade_model->getAll();

        $view['listarTipos']			  = $this->Equipe_model->getTipos();

        

        $this->template->load('Webservice/wordpress/templateDatatable','Webservice/wordpress/listarPartidasRealizadas',$view);

    }



    public function Ranking() {

        $this->load->model('Webservice_model');

        $view['rankCampo']      = $this->Webservice_model->listarRankingPorModalidade(1,3);

        $view['rankFutsal']     = $this->Webservice_model->listarRankingPorModalidade(2,3);

        $view['rankSociety']    = $this->Webservice_model->listarRankingPorModalidade(3,3);

        $this->load->view('Webservice/wordpress/ranking',$view);

    }



    public function listarLocais(){

        $this->load->model('Webservice_model');

        $view['listarLocais'] = $this->Webservice_model->listarLocais();

     	$this->template->load('Webservice/wordpress/templateDatatable','Webservice/wordpress/listarLocais',$view);

	}





	public function CEP($cep)

    {

        header('Content-Type: application/json');

        $cep    = preg_replace('/[^0-9]/', '', $cep);

        $result = file_get_contents("https://api.postmon.com.br/v1/cep/$cep");




        if (json_decode($result) == NULL) {

            echo json_encode(array('erro' => 1));

        } else {

            echo $result;

        }

    }

}