<?php

class Auth
{
    public $ci;

    public function __construct()
    {
        $this->ci = &get_instance();
        $this->ControleAcesso();
    }

    public function ControleAcesso()
    {
  		  $paginaAtual            = strtolower($this->ci->router->fetch_class().'/'.$this->ci->router->fetch_method());
  		  $perfil            	  = $this->ci->session->userdata()[id_perfil];
	    	         
          $SemForcarLogin 		  = array('login/index','login/action','dashboard/sair','equipe/cadastrar','webservice/cep','login/esquecisenha','local/listarlocalmodalidade','webservice/listarequipes','webservice/listarlocais','webservice/listarpartidas','webservice/listarpartidasmarcadas','webservice/ranking','webservice/listarpartidasrealizadas');
          

	        // Checa se a pagina precisa de login se sim
	        if(in_array(strtolower($paginaAtual), $SemForcarLogin) == false) 
	        {		

	        	   // Checa se o cliente está logado. se nao tiver redireciona para o login
	        	   if ($this->ci->session->userdata()['logado'] != true) {
			            redirect('/login');
			       // Se estiver logado aplcia regras de cada pagina que ele pode acessar
			       } else {
		            	   $paginaComAcesso 			= $this->ci->db->query("SELECT * FROM tb_perfil WHERE id_perfil = '$perfil' ")->row()->AuthPaginas;
		    			   $paginaComAcesso				= explode(",",$paginaComAcesso);

		    			// Se a pagina não tiver acesso de acordo com perfil você é deslogado.
		                if(in_array(strtolower($paginaAtual), $paginaComAcesso) != true) {
		                    // echo 'Você não tem acesso a está pagina <b>'.$paginaAtual.'</b> você precisa solicitar acesso ao desenvolvedor TutiJapa.';
		                    // exit;
		                    // $this->ci->session->sess_destroy();
		                    // session_destroy();
		                    //redirect('/');
		                }
			        }
	        }
    }
}
