<?php
require_once("../classes/Formas.class.php");

abstract class Triangulo extends Formas
{
    private $lado1;
    private $lado2;
    private $lado3;
    private $formato;
    private $idMedida;
    private $cor;
    private $imagem;

    public function  __construct($id = 0, $cor = "null", $lado1 = 1, $lado2 = 1, $lado3 = 1, $imagem = "null", Medida $idMedida = null, $formato = "")
    {

        parent::__construct($id, $cor, $imagem, $idMedida);

        $this->setLado1($lado1);
        $this->setLado2($lado2);
        $this->setLado3($lado3);
        $this->setFormato($formato);
    }

    public function setLado1($lado1)
    {
        if ($lado1 < 0)
            throw new Exception("Erro: lado1 inválido!");
        else
            $this->lado1 = $lado1;
    }

    public function setLado2($lado2)
    {
        if ($lado2 < 0)
            throw new Exception("Erro: lado2 inválido!");
        else
            $this->lado2 = $lado2;
    }

    public function setLado3($lado3)
    {
        if ($lado3 < 0)
            throw new Exception("Erro: lado3 inválido!");
        else
            $this->lado3 = $lado3;
    }

    public function setFormato($formato)
    {
        if ($formato < 0)
            throw new Exception("Erro: formato inválido!");
        else
            $this->formato = $formato;
    }

    public function getLado1()
    {
        return $this->lado1;
    }

    public function getLado2()
    {
        return $this->lado2;
    }

    public function getLado3()
    {
        return $this->lado3;
    }

    public function getFormato()
    {
        return $this->formato;
    }

    abstract public function incluir();
    abstract public function alterar();
    abstract public function excluir();
    public static function listar($tipobusca = 0, $busca = ""): array
    {
        $lista = array_merge(
            Isoceles::listar($tipobusca, $busca),
            Escaleno::listar($tipobusca, $busca),
            Equilatero::listar($tipobusca, $busca)
        );
        return $lista;
    }
    abstract public function desenhar();
    abstract public function calcularArea();
    abstract public function calcularPerimetro();
    private function calcularAngulo($a, $b, $c) {
        $cosC = ($a * $a + $b * $b - $c * $c) / (2 * $a * $b); 
        $angulo = rad2deg(acos($cosC));
        return $angulo;
    }
    public function verificarTriangulo() {
        $anguloA = $this->calcularAngulo($this->getLado2(), $this->getLado3(), $this->getLado1()); // Ângulo oposto ao lado a
        $anguloB = $this->calcularAngulo($this->getLado1(), $this->getLado3(), $this->getLado2()); // Ângulo oposto ao lado b
        $anguloC = $this->calcularAngulo($this->getLado1(), $this->getLado2(), $this->getLado3()); // Ângulo oposto ao lado c
    
        $somaAngulos = $anguloA + $anguloB + $anguloC;
    
        if (abs($somaAngulos - 180) < 0.0001) {
            return true;
        } else {
            return false;
        }
    }
}
