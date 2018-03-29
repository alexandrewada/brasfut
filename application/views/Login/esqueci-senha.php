<style>
  @import url(http://fonts.googleapis.com/css?family=Roboto);


body {
  background-image: url('http://www.brasfut.com.br/wp-content/uploads/2016/08/004.jpg');
  background-position: center;
  /*background-repeat: no-repeat;*/
  background-attachment: fixed;
}

/****** LOGIN MODAL ******/
.loginmodal-container {
  padding: 30px;
  max-width: 350px;
  width: 100% !important;
  background-color: #F7F7F7;
  margin: 0 auto;
  border-radius: 2px;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  font-family: roboto;
  margin-top: 90px;
}

.loginmodal-container h1 {
  text-align: center;
  font-size: 1.8em;
  font-family: roboto;
}

.loginmodal-container input[type=submit] {
  width: 100%;
  display: block;
  margin-bottom: 10px;
  position: relative;
}

.loginmodal-container input[type=text], input[type=password] {
  height: 44px;
  font-size: 16px;
  width: 100%;
  margin-bottom: 10px;
  -webkit-appearance: none;
  background: #fff;
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  /* border-radius: 2px; */
  padding: 0 8px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.loginmodal-container input[type=text]:hover, input[type=password]:hover {
  border: 1px solid #b9b9b9;
  border-top: 1px solid #a0a0a0;
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.loginmodal {
  text-align: center;
  font-size: 14px;
  font-family: 'Arial', sans-serif;
  font-weight: 700;
  height: 36px;
  padding: 0 8px;
/* border-radius: 3px; */
/* -webkit-user-select: none;
  user-select: none; */
}

.loginmodal-submit {
  /* border: 1px solid #3079ed; */
  border: 0px;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1); 
  background-color: #4d90fe;
  padding: 17px 0px;
  font-family: roboto;
  font-size: 14px;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
}

.loginmodal-submit:hover {
  /* border: 1px solid #2f5bb7; */
  border: 0px;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #357ae8;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
}

.loginmodal-container a {
  text-decoration: none;
  color: #666;
  font-weight: 400;
  text-align: center;
  display: inline-block;
  opacity: 0.6;
  transition: opacity ease 0.5s;
} 

.login-help{
  font-size: 12px;
}
</style>
<head>
	<title>Àrea da equipe</title>
    <meta name="viewport"
     content="width=device-width, initial-scale=1, user-scalable=yes">
</head>
<script src="//code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

		

		<script type="text/javascript">
			$(function(){
				$("#login").submit(function(e){
					 e.preventDefault();
					 $.ajax({
					 	url:'<?=base_url('login/esquecisenha');?>',
					 	method: 'POST',
					 	data: $("#login").serialize(),
					 	complete: function(e){
							$(".loginmodal-submit").show();
					 	},
					 	done: function(e){
					 		$(".loginmodal-submit").show();
					 	},
					 	success: function(e){
					 		if(e.error == true) {
					 			alert(e.msg);
					 		} else if(e.error == false) {
					 			alert(e.msg);
					 			window.location.href = '/painel/login';
					 		}
					 	},
					 	beforeSend: function(){
					 		$(".loginmodal-submit").hide();
					 	}
					 	,
					 	fail: function(){
					 		$(".loginmodal-submit").show();
					 	}
					 });
				});
			});
		</script>


        <div class="loginmodal-container">
          <div style="text-align: center;">
            <img src='//www.brasfut.com.br/logo-brasfut.png'/>
          </div>
          <br>
          <form method='POST' id='login'>
          <input type="text" name="email" placeholder="Digite o email do seu cadastro.">
         <input type="submit" class="login loginmodal-submit" value="Resetar minha senha">
          </form>
          
         <!--  <div class="login-help">
          <a href="#">Register</a> - <a href="#">Forgot Password</a>
          </div> -->
        </div>