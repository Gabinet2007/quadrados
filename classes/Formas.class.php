<?php

abstract class Formas{
    private $id;
    private $altura;
    private $cor;
    private $idMedida;
    private $imagem;
    
    public function  __construct($id = 0, $altura = 1, $cor = "black", $imagem = "null", Medida $idMedida = null)
    {
        $this->setId($id);
        $this->setAltura($altura);
        $this->setCor($cor);
        $this->setIdMedida($idMedida);
        $this->setImagem($imagem);
    }

    public function setIdMedida(Medida $idMedida)
    {
        $this->idMedida = $idMedida;
    }

    public function setId($novoId)
    {
        if ($novoId < 0)
            throw new Exception("Erro: id inválido!");
        else
            $this->id = $novoId;
    }
    public function setImagem($novoImagem)
    {
            $this->imagem = $novoImagem;
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
            $this->cor = $novoCor;
    }

    public function getId()
    {
        return $this->id;
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
    public function getImagem()
    {
        return $this->imagem;
    }
    
}