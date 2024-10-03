<?php
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
    public function setNome($nome)
    {
        if ($nome == "")
            throw new Exception("Erro: nome inválido!");
        else
            $this->nome = $nome;
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


    public static function listar($tipobusca = 0, $busca = "")
    {
        $sql = "SELECT * FROM medida";
        if ($tipobusca > 0){
            switch ($tipobusca) {
                case 1:
                    $sql .= " WHERE idMedida = :busca";
                    break;
                case 2:
                    $sql .= " WHERE nome like :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        $parametros = [];
        if ($tipobusca > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $medidas = array();

        while ($registro = $comando->fetch()) {

            $medida = new Medida($registro['idMedida'], $registro['nome']);
            array_push($medidas, $medida);
        }
        return $medidas;
    }
}
