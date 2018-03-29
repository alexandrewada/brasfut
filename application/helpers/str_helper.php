<?php

    function removerAcento($string, $slug = false) {
      $string = utf8_decode($string);
      $string = strtolower($string);
      // Código ASCII das vogais
      $ascii['a'] = range(224, 230);
      $ascii['e'] = range(232, 235);
      $ascii['i'] = range(236, 239);
      $ascii['o'] = array_merge(range(242, 246), array(240, 248));
      $ascii['u'] = range(249, 252);
      // Código ASCII dos outros caracteres
      $ascii['b'] = array(223);
      $ascii['c'] = array(231);
      $ascii['d'] = array(208);
      $ascii['n'] = array(241);
      $ascii['y'] = array(253, 255);
      foreach ($ascii as $key=>$item) {
        $acentos = '';
        foreach ($item AS $codigo) $acentos .= chr($codigo);
        $troca[$key] = '/['.$acentos.']/i';
      }
      $string = preg_replace(array_values($troca), array_keys($troca), $string);
      // Slug?
      if ($slug) {
        // Troca tudo que não for letra ou número por um caractere ($slug)
        $string = preg_replace('/[^a-z0-9]/i', $slug, $string);
        // Tira os caracteres ($slug) repetidos
        $string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
        $string = trim($string, $slug);
      }
      return $string;
    }

    function validaCPF($cpf = false) {
			 				
				/**
				 * Multiplica dígitos vezes posições 
				 *
				 * @param string $digitos Os digitos desejados
				 * @param int $posicoes A posição que vai iniciar a regressão
				 * @param int $soma_digitos A soma das multiplicações entre posições e digitos
				 * @return int Os digitos enviados concatenados com o último dígito
				 *
				 */
				function calc_digitos_posicoes( $digitos, $posicoes = 10, $soma_digitos = 0 ) {
					// Faz a soma dos digitos com a posição
					// Ex. para 10 posições: 
					//   0    2    5    4    6    2    8    8   4
					// x10   x9   x8   x7   x6   x5   x4   x3  x2
					// 	 0 + 18 + 40 + 28 + 36 + 10 + 32 + 24 + 8 = 196
					for ( $i = 0; $i < strlen( $digitos ); $i++  ) {
						$soma_digitos = $soma_digitos + ( $digitos[$i] * $posicoes );
						$posicoes--;
					}

					// Captura o resto da divisão entre $soma_digitos dividido por 11
					// Ex.: 196 % 11 = 9
					$soma_digitos = $soma_digitos % 11;

					// Verifica se $soma_digitos é menor que 2
					if ( $soma_digitos < 2 ) {
						// $soma_digitos agora será zero
						$soma_digitos = 0;
					} else {
						// Se for maior que 2, o resultado é 11 menos $soma_digitos
						// Ex.: 11 - 9 = 2
						// Nosso dígito procurado é 2
						$soma_digitos = 11 - $soma_digitos;
					}

					// Concatena mais um digito aos primeiro nove digitos
					// Ex.: 025462884 + 2 = 0254628842
					$cpf = $digitos . $soma_digitos;
					
					// Retorna
					return $cpf;
				}
				
				// Verifica se o CPF foi enviado
				if ( ! $cpf ) {
					return false;
				}

				// Remove tudo que não é número do CPF
				// Ex.: 025.462.884-23 = 02546288423
				$cpf = preg_replace( '/[^0-9]/is', '', $cpf );


				// if($cpf == (int)0) {
				// 	return false;
				// }

				if( $cpf == '00000000000' || 
			        $cpf == '11111111111' || 
			        $cpf == '22222222222' || 
			        $cpf == '33333333333' || 
			        $cpf == '44444444444' || 
			        $cpf == '55555555555' || 
			        $cpf == '66666666666' || 
			        $cpf == '77777777777' || 
			        $cpf == '88888888888' || 
			        $cpf == '99999999999'){ 
       			 	return false;
       			}

				// Verifica se o CPF tem 11 caracteres
				// Ex.: 02546288423 = 11 números
				if ( strlen( $cpf ) != 11 ) {
					return false;
				}	

				// Captura os 9 primeiros dígitos do CPF
				// Ex.: 02546288423 = 025462884
				$digitos = substr($cpf, 0, 9);
				
				// Faz o cálculo dos 9 primeiros dígitos do CPF para obter o primeiro dígito
				$novo_cpf = calc_digitos_posicoes( $digitos );
				
				// Faz o cálculo dos 10 digitos do CPF para obter o último dígito
				$novo_cpf = calc_digitos_posicoes( $novo_cpf, 11 );
				
				// Verifica se o novo CPF gerado é identico ao CPF enviado
				if ( $novo_cpf === $cpf ) {
					// CPF válido
					return true;
				} else {
					// CPF inválido
					return false;
				}
		  

		}
?>