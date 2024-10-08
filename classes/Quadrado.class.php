<?php
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");
require_once("../classes/Formas.class.php");

class Quadrado extends Formas
{
    private $altura;

    public function  __construct($id = 0, $altura = 1, $cor = "null", $imagem = "null", Medida $idMedida = null)
    {
        parent::__construct($id, $cor, $imagem, $idMedida);
        $this->setAltura($altura);
    }

    public function setAltura($altura)
    {
        if ($altura < 1)
            throw new Exception("Erro, número indefinido");
        else
            $this->altura = $altura;
    }

    public function getAltura()
    {
        return $this->altura;
    }
    public function incluir()
    {
        $sql = 'INSERT INTO quadrado (altura, cor, idMedida, idQuadrado, imagem)   
                VALUES (:altura, :cor, :idMedida, :id, :imagem)';

        $parametros = array(
            ':altura' => $this->getAltura(), 
            ':cor' => parent::getCor(), 
            ':idMedida' => parent::getIdMedida()->getIdMedida(), 
            ':id' => parent::getId(), 
            ':imagem' => parent::getImagem());
        return Database::executar($sql, $parametros);
    }


    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM quadrado WHERE idQuadrado = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', parent::getId());
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE quadrado 
                SET altura = :altura, cor = :cor, idMedida = :idMedida, idQuadrado = :id, imagem = :imagem
                WHERE idQuadrado = :id';
        $parametros = array(':altura' => $this->getAltura(), ':cor' => parent::getCor(), ':idMedida' => parent::getIdMedida()->getIdMedida(), ':id' => parent::getId(), ':imagem' => parent::getImagem());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipobusca = 0, $busca = ""):array
    {
        $sql = "SELECT * FROM quadrado";
        if ($tipobusca > 0) {
            switch ($tipobusca) {
                case 1:
                    $sql .= " WHERE idQuadrado = :busca";
                    break;
                case 2:
                    $sql .= " WHERE altura LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE cor LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " WHERE idMedida LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
            }
        }
        // $comando = $conexao->prepare($sql);
        $parametros = [];
        if ($tipobusca > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $quadrados = array();
        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $medida = Medida::listar(1, $forma['idMedida'])[0];
            $quadrado = new Quadrado($forma['idQuadrado'], $forma['altura'], $forma['cor'], $forma['imagem'], $medida);
            array_push($quadrados, $quadrado);
        }
        return $quadrados;
    }
    public function desenhar()
    {
        return "<div class = 'container' style='background-color:" . $this->getCor() . "; background-image: url(" . parent::getImagem() . "); background-repeat:no-repeat;background-size:100% 100%; width:" . $this->getAltura() . $this->getIdMedida()->getNome() . "; height:" . $this->getAltura() . $this->getIdMedida()->getNome() . "'></div><br> ";
    }
    public function calcularPerimetro()
    {
        $peri = 4 * $this->getAltura();
        return "O perímetro é $peri ".parent::getIdMedida()->getNome();
    }

    public function calcularArea()
    {
        $area = $this->getAltura() * $this->getAltura();
        return "A área é $area ".parent::getIdMedida()->getNome();
    }
}
