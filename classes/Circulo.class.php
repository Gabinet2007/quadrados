<?php
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");
require_once("../classes/Formas.class.php");

class Circulo extends Formas
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
        $sql = 'INSERT INTO circulo (altura, cor, idMedida, idCirculo, imagem)   
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
        $sql = 'DELETE FROM circulo WHERE idCirculo = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', parent::getId());
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE circulo 
                SET altura = :altura, cor = :cor, idMedida = :idMedida, idCirculo = :id, imagem = :imagem
                WHERE idCirculo = :id';
        $parametros = array(':altura' => $this->getAltura(), ':cor' => parent::getCor(), ':idMedida' => parent::getIdMedida()->getIdMedida(), ':id' => parent::getId(), ':imagem' => parent::getImagem());
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipobusca = 0, $busca = ""):array
    {
        $sql = "SELECT * FROM circulo";
        if ($tipobusca > 0) {
            switch ($tipobusca) {
                case 1:
                    $sql .= " WHERE idCirculo = :busca";
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
        $circulos = array();
        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $medida = Medida::listar(1, $forma['idMedida'])[0];
            $circulo = new circulo($forma['idCirculo'], $forma['altura'], $forma['cor'], $forma['imagem'], $medida);
            array_push($circulos, $circulo);
        }
        return $circulos;
    }
    public function desenhar()
    {
        return "<a 
        href='index.php?idCirculo=" . $this->getId() . "'>
        <div class='container' style='background-image:url(".'"'.$this->getImagem().'"'.");
        border-radius: 50%;
        background-color: " . $this->getCor() . "; 
        background-repeat:no repeat;
        background-size: 100% 100%;
        width:" . $this->getAltura() . $this->getIdMedida()->getNome() . "; 
        height:" . $this->getAltura() . $this->getIdMedida()->getNome() . "'> </div></a><br>";
    }

    public function calcularPerimetro(){
        return 2 * ($this->altura/2) * 3.14 . " " . $this->getIdMedida()->getNome();
    }

    public function calcularArea(){
        return 3.14 * (($this->altura/2) * ($this->altura/2))  . " " . $this->getIdMedida()->getNome()."²";
    }
}
