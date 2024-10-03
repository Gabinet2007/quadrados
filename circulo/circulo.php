<?php
require_once("../classes/Circulo.class.php");
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");



$id = isset($_GET['idCirculo']) ? $_GET['idCirculo'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $contato = Circulo::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $lado = isset($_POST['altura']) ? $_POST['altura'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : "";
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : "";
    $tipo = isset($_POST['escolhaQuad']) ? $_POST['escolhaQuad'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    try {
        if ($tipo == "img") {
            $nome_arquivo = $_FILES['imagem']['name'];
            $tmp_nome = $_FILES['imagem']['tmp_name'];
            $nome_unico = uniqid() . '.' . pathinfo($nome_arquivo, PATHINFO_EXTENSION);

            $caminho_relativo = IMG . $nome_unico;
            // echo $caminho_relativo;
            // die();
            $medida = Medida::listar(1, $unidade)[0];
            $circulo = new Circulo($id, $lado, null, $caminho_relativo, $medida);
        } else {
            $medida = Medida::listar(1, $unidade)[0];
            $circulo = new Circulo($id, $lado, $cor, null, $medida);
        }


        // $medida = Medida::listar(1, $unidade)[0];
        // $circulo = new Circulo($id, $lado, $cor, $medida);
        $resultado = "";
        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $circulo->alterar();
            } else {
                $resultado = $circulo->incluir();
            }
        } elseif ($acao == 'excluir') {
            $resultado = $circulo->excluir();
        }
        if ($resultado) {
            move_uploaded_file($tmp_nome, IMG . $nome_unico);
            header('Location: index.php');
        } else
            echo "erro ao inserir dados!";

    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipobusca = isset($_GET['tipobusca']) ? $_GET['tipobusca'] : 0;
    $lista = Circulo::listar($tipobusca, $busca);
}
