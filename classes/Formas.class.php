<?php
abstract class Formas
{
    private $id;
    private $cor;
    private $idMedida;
    private $imagem;

    public function  __construct($id = 0, $cor = "null", $imagem = "null", Medida $idMedida = null)
    {
        $this->setId($id);
        $this->setCor($cor);
        $this->setIdMedida($idMedida);
        $this->setImagem($imagem);
    }

    public function setId($id)
    {
        if ($id < 0)
            throw new Exception("Erro: id inválido!");
        else
            $this->id = $id;
    }


    public function setCor($cor)
    {
        $this->cor = $cor;
    }

    public function setImagem($imagem)
    {
        $this->imagem = $imagem;
    }

    public function setIdMedida(Medida $idMedida)
    {
        $this->idMedida = $idMedida;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCor()
    {
        return $this->cor;
    }

    public function getIdMedida()
    {
        return $this->idMedida;
    }

    public function getImagem()
    {
        return $this->imagem;
    }
    abstract public function incluir();
    abstract public function alterar();
    abstract public function excluir();
    abstract public static function listar($tipo=0,$busca=""):array;
    abstract public function desenhar();
    abstract public function calcularArea();
    abstract public function calcularPerimetro();
}