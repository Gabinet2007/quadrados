<?php
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");

class Quadrado
{
    private $idQuadrado;
    private $altura;
    private $cor;
    private $idMedida;

    public function  __construct($idQuadrado = 0, $altura = 1, $cor = "black", Medida $idMedida = null)
    {
        $this->setIdQuadrado($idQuadrado);
        $this->setAltura($altura);
        $this->setCor($cor);
        $this->setIdMedida($idMedida);
    }

    public function setIdMedida(Medida $idMedida)
    {
        $this->idMedida = $idMedida;
    }

    public function setIdQuadrado($novoIdQuadrado)
    {
        if ($novoIdQuadrado < 0)
            throw new Exception("Erro: idQuadrado inválido!");
        else
            $this->idQuadrado = $novoIdQuadrado;
    }

    public function setAltura($novoAltura)
    {
        if ($novoAltura < 1)
            throw new Exception("Erro, número indefinido");
        else
            $this->altura = $novoAltura;
    }

    public function setCor($novoCor)
    {
        if ($novoCor == "")
            throw new Exception("Erro, cor indefinido");
        else
            $this->cor = $novoCor;
    }

    public function getIdQuadrado()
    {
        return $this->idQuadrado;
    }

    public function getAltura()
    {
        return $this->altura;
    }

    public function getCor()
    {
        return $this->cor;
    }

    public function getIdMedida()
    {
        return $this->idMedida;
    }

    public function incluir()
    {
        $sql = 'INSERT INTO quadrado (lado, cor, idMedida, idQuadrado)   
                VALUES (:lado, :cor, :idMedida, :idQuadrado)';

        $parametros = array(':lado' => $this->altura, ':cor' => $this->cor, ':idMedida' => $this->idMedida->getIdMedida(), ':idQuadrado' => $this->idQuadrado);
        return Database::executar($sql, $parametros);
    }


    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM quadrado WHERE idQuadrado = :idQuadrado';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':idQuadrado', $this->idQuadrado);
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE quadrado 
                SET lado = :lado, cor = :cor, idMedida = :idMedida, idQuadrado = :idQuadrado
                WHERE idQuadrado = :idQuadrado';
        $parametros = array(':lado' => $this->altura, ':cor' => $this->cor, ':idMedida' => $this->idMedida->getIdMedida(), ':idQuadrado' => $this->idQuadrado);
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipo = 0, $busca = "")
    {
        $sql = "SELECT * FROM quadrado";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1:
                    $sql .= " WHERE idQuadrado = :busca";
                    break;
                case 2:
                    $sql .= " WHERE lado LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE cor LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " WHERE idMedida = :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipo > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $quadrados = array();
        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $medida = Medida::buscaPorId($forma['idMedida']);
            $quadrado = new Quadrado($forma['idQuadrado'], $forma['lado'], $forma['cor'], $medida);
            array_push($quadrados, $quadrado);
        }
        return $quadrados;
    }
    public function desenharQuadrado()
    {
        return "<div class = 'container' style='background-color:" . $this->getCor() . "; width:" . $this->getAltura() . $this->getIdMedida()->getNome() . "; height:" . $this->getAltura() . $this->getIdMedida()->getNome() . " ;border-radius: 0px;'></div><br> ";
    }
}
