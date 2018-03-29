<?php

class Sendmail {

	public $mail;
	public $deEmail;
	public $deNome;
	public $toEmail;
	public $toNome;
	public $assunto;
	public $msg;
	public $ccs;


	public function enviar() {
			require_once "./lib/phpmailer/PHPMailerAutoload.php";
			$this->mail = new PHPMailer();
			$this->mail->isSMTP();
			$this->mail->CharSet = 'UTF-8';
			$this->mail->SMTPDebug = false;
			$this->mail->Host = 'smtp.gmail.com';
			$this->mail->Port = 587;
			$this->mail->SMTPSecure = 'tls';
			$this->mail->SMTPAuth = true;
			$this->mail->Username = "brasfutenvio@gmail.com";
			$this->mail->Password = "ygen200h";
			$this->mail->setFrom(($this->deEmail == NULL ) ? 'brasfutenvio@gmail.com' : $this->deEmail,($this->deNome == NULL ) ? 'Brasfut' : $this->deNome);
			
			if(empty($this->ccs)){
				// $this->mail->AddCC('sistema@brasfut.com.br', 'Brasfut');
			} else {
				if(is_array($this->ccs)) {
					foreach ($this->ccs as $key => $email) {
						$nome = explode("@",$email);
						$this->mail->AddCC($email,$nome[0]);
					}
				} else {
						$nome = explode("@",$this->ccs);
						$this->mail->AddCC($this->ccs,$nome[0]);
					
				}
			}

			$this->mail->addAddress($this->toEmail,$this->toNome);
			$this->mail->Subject = ($this->assunto == NULL) ? 'Brasfut' : $this->assunto;
			$this->mail->msgHTML($this->msg);
			if (!$this->mail->send()) {
				return false;
			} else {
			 	return true;
			}
	}

}