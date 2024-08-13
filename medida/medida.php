<?php
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");



$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $medida = Medida::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";

    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    try {
        $medida = new Medida($id, $nome);
        $resultado = "";
          if ($acao == 'salvar') {
              if ($id > 0) {
                  $resultado = $medida->alterar();
              } else {
                  $resultado = $medida->incluir();
              }
          } elseif ($acao == 'excluir') {
              $resultado = $medida->excluir();
          }
          if ($resultado)
              header('Location: index.php');
          else
              echo "erro ao inserir dados!";
    
        // var_dump($medida);
    
    } catch (Exception $e) {
        header('Location:index.php?MSG=ERROR:' . $e->getMessage());
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 0;
    $lista = Medida::listar($tipo, $busca);
}
