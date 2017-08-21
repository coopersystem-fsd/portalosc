<?php

namespace App\Dao;

use App\Dao\DaoPostgres;

class MenuDao extends DaoPostgres
{
    private $queriesOsc = array(
        'areaatuacao' => [
            'query' => 'SELECT * FROM syst.dc_area_atuacao ORDER BY cd_area_atuacao;', 
            'unique' => false
        ],
        'subareaatuacao' => [
            'query' => 'SELECT * FROM syst.dc_subarea_atuacao;', 
            'unique' => false
        ],
        'classeatividadeeconomica' => [
            'query' => 'SELECT * FROM syst.dc_classe_atividade_economica;', 
            'unique' => false
        ],
        'subclasseatividadeeconomica' => [
            'query' => 'SELECT * FROM syst.dc_subclasse_atividade_economica;', 
            'unique' => false
        ],
        'certificado' => [
            'query' => 'SELECT * FROM syst.dc_certificado;', 
            'unique' => false
        ],
        'conselho' => [
            'query' => 'SELECT * FROM syst.dc_conselho ORDER BY tx_nome_conselho;', 
            'unique' => false
        ],
        'conferencia' => [
            'query' => 'SELECT * FROM syst.dc_conferencia ORDER BY tx_nome_conferencia;', 
            'unique' => false
        ],
        'naturezajuridica' => [
            'query' => 'SELECT * FROM syst.dc_natureza_juridica;', 
            'unique' => false
        ],
        'situacaoimovel' => [
            'query' => 'SELECT * FROM syst.dc_situacao_imovel;', 
            'unique' => false
        ],
        'tipoparticipacao' => [
            'query' => 'SELECT * FROM syst.dc_tipo_participacao;', 
            'unique' => false
        ],
        'abrangenciaprojeto' => [
            'query' => 'SELECT * FROM syst.dc_abrangencia_projeto;', 
            'unique' => false
        ],
        'origemfonterecursososc' => [
            'query' => 'SELECT * FROM syst.dc_origem_fonte_recursos_osc;', 
            'unique' => false
        ],
        'fonterecursososc' => [
            'query' => 'SELECT * FROM syst.dc_fonte_recursos_osc;', 
            'unique' => false
        ],
        'origemfonterecursosprojeto' => [
            'query' => 'SELECT * FROM syst.dc_origem_fonte_recursos_projeto;', 
            'unique' => false
        ],
        'fonterecursosprojeto' => [
            'query' => 'SELECT * FROM syst.dc_fonte_recursos_projeto;', 
            'unique' => false
        ],
        'zonaatuacaoprojeto' => [
            'query' => 'SELECT * FROM syst.dc_zona_atuacao_projeto;', 
            'unique' => false
        ],
        'objetivoprojeto' => [
            'query' => 'SELECT cd_objetivo_projeto, tx_codigo_objetivo_projeto || \'. \' || tx_nome_objetivo_projeto AS tx_nome_objetivo_projeto FROM syst.dc_objetivo_projeto ORDER BY cd_objetivo_projeto;', 
            'unique' => false
        ],
        'metaprojeto' => [
            'query' => 'SELECT cd_meta_projeto, tx_codigo_meta_projeto || \' \' || tx_nome_meta_projeto AS tx_nome_meta_projeto FROM syst.dc_meta_projeto ORDER BY cd_meta_projeto;', 
            'unique' => false
        ],
        'statusprojeto' => [
            'query' => 'SELECT * FROM syst.dc_status_projeto;', 
            'unique' => false
        ],
        'periodicidadereuniao' => [
            'query' => 'SELECT * FROM syst.dc_periodicidade_reuniao_conselho;', 
            'unique' => false
        ],
        'formaparticipacaoconferencia' => [
            'query' => 'SELECT * FROM syst.dc_forma_participacao_conferencia;', 
            'unique' => false
        ],
        'tipoparceria' => [
            'query' => 'SELECT * FROM syst.dc_tipo_parceria;', 
            'unique' => false
        ]
    );
    
    private $queriesOscParametro = array(
        'subareaatuacao' => [
            'query' => 'SELECT * FROM syst.dc_subarea_atuacao WHERE cd_area_atuacao = ?::INTEGER;', 
            'unique' => false
        ],
        'subclasseatividadeeconomica' => [
            'query' => 'SELECT * FROM syst.dc_subclasse_atividade_economica WHERE cd_classe_atividade_economica = ?::CHARACTER VARYING;', 
            'unique' => false
        ],
        'metaprojeto' => [
            'query' => 'SELECT cd_meta_projeto, tx_codigo_meta_projeto || \' \' || tx_nome_meta_projeto AS tx_nome_meta_projeto FROM syst.dc_meta_projeto WHERE cd_objetivo_projeto = ?::INTEGER ORDER BY cd_meta_projeto;', 
            'unique' => false
        ],
        'fonterecursososc' => [
            'query' => 'SELECT * FROM syst.dc_fonte_recursos_osc WHERE cd_origem_fonte_recursos_osc = ?::INTEGER;', 
            'unique' => false
        ],
        'fonterecursosprojeto' => [
            'query' => 'SELECT * FROM syst.dc_fonte_recursos_projeto WHERE cd_origem_fonte_recursos_projeto = ?::INTEGER;', 
            'unique' => false
        ]
    );
    
    private $queriesGeografico = array(
        'municipio' => [
            'query' => 'SELECT * FROM portal.obter_menu_municipio(?::TEXT, ?::INTEGER, ?::INTEGER);', 
            'unique' => false
        ],
        'estado' => [
            'query' => 'SELECT * FROM portal.obter_menu_estado(?::TEXT, ?::INTEGER, ?::INTEGER);', 
            'unique' => false
        ],
        'regiao' => [
            'query' => 'SELECT * FROM portal.obter_menu_regiao(?::TEXT, ?::INTEGER, ?::INTEGER);', 
            'unique' => false
        ]
    );
    
    public function obterMenuOsc($menu, $parametro = null)
    {
        $resultado = null;
        
        $menu = str_replace([' ', '_', '-'], '', $menu);
        if($parametro && array_key_exists($menu, $this->queriesOscParametro)){
            $queryList = $this->queriesOscParametro[$menu];
            $query = $queryList['query'];
            $unique = $queryList['unique'];
            $params = [$parametro];
            $resultado = $this->executarQuery($query, $unique, $params);
        }else if(array_key_exists($menu, $this->queriesOsc)){
            $queryList = $this->queriesOsc[$menu];
            $query = $queryList['query'];
            $unique = $queryList['unique'];
            $resultado = $this->executarQuery($query, $unique);
        }
        
        return $resultado;
    }
    
    public function obterMenuGeografico($tipoRegiao, $parametro, $limit, $offset)
    {
        $resultado = null;
        
        $tipoRegiao = str_replace([' ', '_', '-'], '', $tipoRegiao);
        if(array_key_exists($tipoRegiao, $this->queriesGeografico)){
            $queryList = $this->queriesGeografico[$tipoRegiao];
            $query = $queryList['query'];
            $unique = $queryList['unique'];
            $params = [$parametro, $limit, $offset];
            $resultado = $this->executarQuery($query, $unique, $params);
        }
        
        return $resultado;
    }
}
