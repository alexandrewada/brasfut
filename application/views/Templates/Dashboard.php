<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <script src="//code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="<?=base_url('assets/js/utilidades/ajax.js');?>" type="text/javascript"></script>
  <script src="<?=base_url('assets/js/utilidades/mask.js');?>" type="text/javascript"></script>
  <script src="<?=base_url('assets/js/template/dashboard.js');?>" type="text/javascript"></script>
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/template/template.css');?>">
  <title><?=(empty($title)) ? 'Brasfut @ Gerenciador de jogos ' : $title;?></title>

  <script type="text/javascript">
  	var base_url = '<?=base_url();?>';
  
  	$(function(){
  		$("#selecao-arquivo").change(function(){
  			$("#uploadEmblema").submit(); 
  		});
  	});

  </script>


  <style type="text/css">
    .titulo-esquerda {
      font-weight: 700;
      text-transform: uppercase;
    }
  </style>

</head>


<body>
  <div class='container-fluid' style="background-color: white;">
  <div class="container" style="background-color: white; padding-top: 20px; padding-bottom: 0px;">
      <div class='row'>
          <div class='col-md-4 hidden-xs hidden-sm'>
              <div style="float: left;">
              <form id='uploadEmblema' enctype="multipart/form-data" action="<?=base_url('equipe/uploademblema');?>" method="POST">
                  <label for='selecao-arquivo' style="text-align: center; cursor: pointer;">
                  <img height="80px" width="80px" src='<?=$this->session->userdata()[logo];?>'/><br><span style="font-size: 10px;">Alterar Emblema</span>
                  </label>
				  <input id='selecao-arquivo' type='file' name='emblema' style="display: none;">
              	<?if(!empty($uploadRetorno)):?>
              		<script>alert('<?=$uploadRetorno;?>');</script>
              	<?endif;?>
              </div>
              </form>
              <div class="informacoes-time" style="float: left;margin-left: 11px;font-size: 10px;">
      <table style="width: 100%;">
        <tbody>
          <tr>
            <td class="titulo-esquerda" style="text-align: right;">Equipe:</td>
            <td class="titulo-direito" style="text-align: left; padding-left: 7px;"><?=$this->session->userdata()[nome_equipe];?></td>
          </tr>
          <tr>
            <td class="titulo-esquerda" style="text-align: right;">Modalidade:</td>
            <td class="titulo-direito" style="text-align: left; padding-left: 7px;"><?=$this->session->userdata()[nome_modalidade];?></td>
          </tr>
          <tr>
            <td class="titulo-esquerda" style="text-align: right;">Fundação:</td>
            <td class="titulo-direito" style="text-align: left; padding-left: 7px;"><?=date('d/m/Y',strtotime($this->session->userdata()[data_fundacao]));?></td>
          </tr>
          <tr>
            <td class="titulo-esquerda" style="text-align: right;">Categoria:</td>
            <td class="titulo-direito" style="text-align: left; padding-left: 7px;"><?=$this->session->userdata()[nome_categoria];?></td>
          </tr>
          <tr>
            <td class="titulo-esquerda" style="text-align: right;">Responsável:</td>
            <td class="titulo-direito" style="text-align: left; padding-left: 7px;"><?=ucwords(strtolower($this->session->userdata()[nome_pessoa]));?></td>
          </tr>
          <tr>
            <td class="titulo-esquerda" style="text-align: right;">Sexo:</td>
            <td class="titulo-direito" style="text-align: left; padding-left: 7px;"><?=ucfirst($this->session->userdata()[sexo]);?></td>
          </tr>
          <tr>
            <td class="titulo-esquerda" style="text-align: right;">Cidade:</td>
            <td class="titulo-direito" style="text-align: left; padding-left: 7px;"><?=strtoupper($this->session->userdata()[cidade] .' / '.$this->session->userdata()[uf]);?></td>
          </tr>
        </tbody>
      </table>
      </div>
          </div>
          <div class='col-md-4 text-center'>
                  <div class='topo-logo' style="padding-top: 20px;">
                  <img src='http://www.brasfut.com.br/logo-brasfut.png'/>
              </div>
      
          </div>
          <div class='col-md-4'>
              <ul id='user-info'  style="float: right;">
                <li class='user-info-li'>
                  <img width="60" height="60" class='img-circle' src='<?=$this->session->userdata()[logo];?>'/>
                </li>
              
              <li class="dropdown user-info-li" >
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><b><?=$this->session->userdata()[nome_pessoa];?><span class="caret"></span></b></a>
                <ul class="dropdown-menu" style="text-align: left;">
                  <li><a href="<?=base_url('perfil/editar');?>">Meu Dados</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="<?=base_url('dashboard/sair');?>">Sair</a></li>
                </ul>
              </li>
              </ul>
          </div>
      </div>
  </div>
  </div>
 <nav class="navbar navbar-default">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!-- <a class="navbar-brand" href="#"><img src='//www.brasfut.com.br/logo-brasfut.png' style="height: 25px;" /></a> -->
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left">
              <li><a href="<?=base_url('dashboard');?>"><span class='glyphicon glyphicon-th-large'></span> Dashboard</a></li>

              <li><a href="<?=base_url('partida/listar');?>"><span class='glyphicon glyphicon-map-marker'></span> Partidas</a></li>

                 <?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>
              	<li><a href="<?=base_url('equipe/detalhes/'.$this->session->userdata('id_equipe'));?>"><span class='glyphicon glyphicon-user'></span> Meu Time</a></li>
              <?endif;?>

              <?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>
                <li><a href="<?=base_url('partida/agendar');?>"><span class='glyphicon glyphicon glyphicon-calendar'></span> Agendar Novo Jogo</a></li>
              <?endif;?>

              <?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>
                <li><a href="#"><span class='glyphicon glyphicon glyphicon-user'></span> Jogadores</a></li>
              <?endif;?>

              <?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>
                <li><a href="<?=base_url('/equipe/ranking');?>"><span class='glyphicon glyphicon-sort-by-order'></span> Ranking</a></li>
              <?endif;?>

                <li><a href="<?=base_url('local/listar');?>"><span class='glyphicon glyphicon-map-marker'></span> Locais</a></li>

              <?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>
              	<li><a href="#"><span class='glyphicon glyphicon glyphicon-usd'></span> Financeiro</a></li>
              <?endif;?>

           <!--    <?if(in_array($this->session->userdata('id_equipe_tipo'), array(2,3))):?>
              	<li><a href="<?=base_url('local/cadastrar');?>"><span class='glyphicon glyphicon glyphicon-map-marker'></span> Local </a></li>
              <?endif;?> -->

        </ul>
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>










<div class="container">
<?=$contents;?>
</div>








<!-- Small modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class='modal-body'>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<!-- Small -->

<script type="text/javascript">
  $(function(){
    modalAjax = function(url) {
      $.get(url,function(e){
        $(".modal-body").html("").html(e);
        $('.modal').modal('show');
      });
    }
  });
</script>
 
</body>
</html>