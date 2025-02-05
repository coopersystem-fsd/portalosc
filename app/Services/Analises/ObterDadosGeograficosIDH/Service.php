<?php

namespace App\Services\Analises\ObterDadosGeograficosIDH;

use App\Services\BaseService;
use App\Dao\Analises\DadosGeograficosIDHDao;

class Service extends BaseService{
	public function executar(){
		$conteudoRequisicao = $this->requisicao->getConteudo();
		$modelo = new Model($conteudoRequisicao);
		
	    if($modelo->obterCodigoResposta() === 200){
	    	$requisicao = $modelo->obterRequisicao();
			$resultadoDao = (new DadosGeograficosIDHDao())->obterDadosGeograficosIDHDao($requisicao);

	    	if($resultadoDao->codigo === 200){
				$resultado = json_decode($resultadoDao->resultado);
	    	    $this->resposta->prepararResposta($resultado, 200);
	    	}else{
				$mensagem = $resultadoDao->mensagem;
				$codigo = $resultadoDao->codigo;
	    		$this->resposta->prepararResposta(['msg' => $mensagem], $codigo);
	    	}
	    }else{
			$mensagem = $modelo->obterMensagemResposta();
			$codigo = $modelo->obterCodigoResposta();
            $this->resposta->prepararResposta($mensagem, $codigo);
        }
	}
}