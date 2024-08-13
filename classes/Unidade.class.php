<?php
require_once("../config/config.inc.php");

require_once("../classes/Database.class.php");

class Medida
{

    private $idMedida;
    private $nome;

    public function __construct($idMedida = 0, $nome = "")
    {

        $this->setIdMedida($idMedida);
        $this->setNome($nome);
    }

    public function setIdMedida($novoIdMedida)
    {
        if ($novoIdMedida < 0)
            throw new Exception("Erro: idMedida inválido!");
        else
            $this->idMedida = $novoIdMedida;
    }
    public function setNome($novoNome)
    {
        if ($novoNome == "")
            throw new Exception("Erro: nome inválido!");
        else
            $this->nome = $novoNome;
    }

    public function getIdMedida()
    {
        return $this->idMedida;
    }
    public function getNome()
    {
        return $this->nome;
    }
    public function incluir()
    {
        $sql = 'INSERT INTO medida (idMedida, nome)   
                VALUES (:idMedida, :nome)';

        $parametros = array(':idMedida' => $this->idMedida, ':nome' => $this->nome);
        return Database::executar($sql, $parametros);
    }

    /*public function desenhar($quadrado){
        return "<center> <a href='index.php?id=".$quadrado->getid()."'><div class='container' style='background-color: ".$quadrado->getCor() . "; width:".$quadrado->getLadoTamanho().$quadrado->getUnidadeMedida()."; height:".$quadrado->getLadoTamanho().$quadrado->getUnidadeMedida()."'> </div></a></center><br>";
    }*/

    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM medida WHERE idMedida = :idMedida';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':idMedida', $this->idMedida);
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE medida 
                SET nome = :nome, idMedida = :idMedida
                WHERE idMedida = :idMedida';
        $parametros = array(':nome' => $this->nome,':idMedida' => $this->idMedida);
        return Database::executar($sql, $parametros);
    }

    public static function buscaPorId($idMedida){
        $sql = "SELECT * FROM medida WHERE idMedida = :idMedida";
        $parametros = array(':idMedida' => $idMedida);
        $comando = Database::executar($sql, $parametros);
        $dados = $comando->fetch(PDO::FETCH_ASSOC);

        if ($dados) {
            return new Medida($dados['idMedida'], $dados ['nome']);
        } else {
            throw new Exception("Erro: Medida não encontrada.");
        }
    }


    public static function listar($tipo = 0, $busca = "")
    {
        $conexao = Database::getInstance();
        $sql = "SELECT * FROM medida";
        if ($tipo > 0)
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idMedida = :busca";
                    break;
                case 2:
                    $sql .= " WHERE nome like :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        $comando = $conexao->prepare($sql);
        if ($tipo > 0)
            $comando->bindValue(':busca', $busca);
        $comando->execute();

        $medidas = array();
        while ($registro = $comando->fetch()) {

            $medida = new Medida($registro['idMedida'], $registro['nome']);
            array_push($medidas, $medida);
        }
        return $medidas;
    }
}
