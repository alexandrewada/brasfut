<?php
class Login_model extends CI_Model
{

    public function resetarSenha($email) {
        $query = $this->db->query("SELECT * FROM tb_pessoa pessoa WHERE pessoa.email = ?",array($email));

        if($query->num_rows() > 0 ){
            $senhaNova = uniqid();
            $this->db->update('tb_pessoa',array('senha' => $senhaNova),array('email' => $email));

	        $this->load->library('Sendmail');
		    $this->sendmail->toEmail 		= $email;
	        $this->sendmail->toNome 		= $email;
	        $this->sendmail->assunto 		= 'Você solicitou uma recuperação de senha';
	        $this->sendmail->msg 			= 'Você solicitou uma nova senha, sua nova senha é '.$senhaNova.'<br>'.'http://www.brasfut.com.br/painel/login';
	        $this->sendmail->enviar(); 
            return array('error' => false,'msg' => 'Sua nova senha foi enviada para o seu email '.$email);
        } else {
            return array('error' => true, 'msg' => 'Este email '.$email.' não está cadastrado em nosso sistema.');
        }

    }

    public function Login($email, $pw)
    {
        if (strlen($email) < 3 or strlen($pw) < 3) {
            return false;
        }

        $query = $this->db->query("SELECT 
                                        tb_pessoa.*,
                                        tb_equipe.*,
                                        tb_categoria.id_categoria,
                                        tb_categoria.nome_categoria,
                                        tb_modalidade.id_modalidade,
                                        tb_modalidade.nome_modalidade,
                                        tb_equipe_tipo.id_equipe_tipo,
                                        tb_equipe_tipo.tipo,
                                        tb_equipe.logo,
                                        tb_equipe.uf as 'uf_equipe',
                                        tb_equipe.sexo as 'sexo_equipe'
                                   FROM
                                        tb_pessoa
                                        LEFT JOIN tb_equipe ON tb_equipe.id_pessoa_responsavel = tb_pessoa.id_pessoa
                                        LEFT JOIN tb_modalidade ON tb_equipe.id_modalidade = tb_modalidade.id_modalidade
                                        LEFT JOIN tb_categoria ON tb_equipe.id_categoria = tb_categoria.id_categoria 
                                        LEFT JOIN tb_equipe_tipo ON tb_equipe.id_equipe_tipo = tb_equipe_tipo.id_equipe_tipo
                                    WHERE tb_pessoa.email = ? and tb_pessoa.senha = ? and tb_pessoa.status in ('1') LIMIT 0,1", array($email, $pw));
        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return false;
        }
    }
}
?>