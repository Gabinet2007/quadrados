<?php
require_once("../classes/Quadrado.class.php");
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");



$id = isset($_GET['id']) ? $_GET['id'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $contato = Quadrado::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $lado = isset($_POST['altura']) ? $_POST['altura'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : "";
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : "";

    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;

    try {
        $medida = Medida::listar(1,$unidade)[0];
        $quadrado = new Quadrado($id, $lado, $cor, $medida);
        $resultado = "";
          if ($acao == 'salvar') {
              if ($id > 0) {
                  $resultado = $quadrado->alterar();
              } else {
                  $resultado = $quadrado->incluir();
              }
          } elseif ($acao == 'excluir') {
              $resultado = $quadrado->excluir();
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
    $lista = Quadrado::listar($tipo, $busca);
}
