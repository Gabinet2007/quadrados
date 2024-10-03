<?php
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");
// require_once("../classes/Formas.class.php");
require_once("../classes/Triangulo.class.php");

class Equilatero extends Triangulo
{

    
    public function  __construct($id = 0, $lado1 = 1, $lado2 = 1, $lado3 = 1,  $cor = "null", $imagem = "null", Medida $idMedida = null, $formato = "")
    {
        parent::__construct($id, $cor, $lado1, $lado2, $lado3, $imagem, $idMedida, $formato);
    }
    public function incluir()
    {
        $sql = 'INSERT INTO triangulo (idTriangulo, lado1, lado2, lado3, cor, imagem, idMedida, formato)   
        VALUES (:id, :lado1, :lado2, :lado3, :cor, :imagem, :idMedida, :formato)';

        $parametros = array(
            ':lado1' => $this->getLado1(),
            ':lado2' => $this->getLado2(),
            ':lado3' => $this->getLado3(),
            ':cor' => parent::getCor(),
            ':imagem' => parent::getImagem(),
            ':idMedida' => parent::getIdMedida()->getIdMedida(),
            ':formato' => parent::getFormato(),
            ':id' => $this->getId()
        );

        return Database::executar($sql, $parametros);
    }


    public function excluir()
    {
        $conexao = Database::getInstance();
        $sql = 'DELETE FROM triangulo WHERE idTriangulo = :id';
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', parent::getId());
        return $comando->execute();
    }

    public function alterar()
    {
        $sql = 'UPDATE triangulo 
            SET lado1 = :lado1, lado2 = :lado2, lado3 = :lado3, cor = :cor, imagem = :imagem, idMedida = :idMedida, formato = :formato
            WHERE idTriangulo = :id';
        $parametros = array(
            ':id' => parent::getId(),
            ':lado1' => $this->getLado1(),
            ':lado2' => $this->getLado2(),
            ':lado3' => $this->getLado3(),
            ':cor' => parent::getCor(),
            ':idMedida' => parent::getIdMedida()->getIdMedida(),
            ':imagem' => parent::getImagem(),
            ':formato' => parent::getFormato()
        );
        return Database::executar($sql, $parametros);
    }

    public static function listar($tipobusca = 0, $busca = ""): array
    {
        $sql = "SELECT * FROM triangulo";
        if ($tipobusca > 0) {
            switch ($tipobusca) {
                case 1:
                    $sql .= " WHERE idTriangulo = :busca";
                    break;
                case 2:
                    $sql .= " WHERE lado1 :busca";
                    $busca = "%{$busca}%";
                    break;
                case 3:
                    $sql .= " WHERE lado3 :busca";
                    $busca = "%{$busca}%";
                    break;
                case 4:
                    $sql .= " WHERE cor LIKE :busca";
                    $busca = "%{$busca}%";
                    break;
                case 5:
                    $sql .= ", idMedida WHERE idMedida.id = triangulo.idMedida and tipo like :busca";
                    break;
            }
        }
        $parametros = [];
        if ($tipobusca > 0)
            $parametros = array(':busca' => $busca);

        $comando = Database::executar($sql, $parametros);
        $triangulos = array();

        while ($forma = $comando->fetch(PDO::FETCH_ASSOC)) {
            $medida = Medida::listar(1, $forma['idMedida'])[0];
            if($forma['formato'] == 'equi'){
            $triangulo = new Equilatero($forma['idTriangulo'], $forma['lado1'], $forma['lado2'], $forma['lado3'], $forma['cor'], $forma['imagem'], $medida, $forma['formato']);
            array_push($triangulos, $triangulo);
        }
        }
        return $triangulos;
    }
    public function desenhar()
    {
        return "
        <a href='index.php?idTriangulo=" . $this->getId() . "'>
            <div style='position: relative; display: inline-block;'>
                <div style='
                    width: 0;
                    height: 0;
                    border-left: " . $this->getLado1() . $this->getIdMedida()->getNome() . " solid transparent;
                    border-right: " . $this->getLado2() . $this->getIdMedida()->getNome() . " solid transparent;
                    border-bottom: " . $this->getLado3() . $this->getIdMedida()->getNome() . " solid " . $this->getCor() . ";
                '></div>
                <div style='
                    position: absolute;
                    top: 0;
                    left: 50%;
                    transform: translateX(-50%);
                    width: " . ($this->getLado1() + $this->getLado2()) . $this->getIdMedida()->getNome() . ";
                    height: " . $this->getLado3() . $this->getIdMedida()->getNome() . ";
                    background-image: url(" . '"' . $this->getImagem() . '"' . ");
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                    clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
                    pointer-events: none;
                '></div>
            </div>
        </a>
    
        <br>";
    }

    public function calcularPerimetro(){
    
        return $this->getLado1() + $this->getLado2() + $this->getLado3(). " " .  $this->getIdMedida()->getNome();
    }

    public function calcularArea(){
        
        $p = ($this->getLado1() + $this->getlado2() + $this->getLado3()) / 2;

        return sqrt($p * ($p - $this->getLado1()) * ($p - $this->getLado2()) * ($p - $this->getLado3())). " " .  $this->getIdMedida()->getNome() . "²";

    }
}
