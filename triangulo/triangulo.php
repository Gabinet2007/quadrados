<?php
require_once("../classes/T_Equilatero.class.php");
require_once("../classes/T_Escaleno.class.php");
require_once("../classes/T_Isoceles.class.php");
require_once("../classes/Triangulo.class.php");
require_once("../classes/Database.class.php");
require_once("../classes/Unidade.class.php");

$id = isset($_GET['idTriangulo']) ? $_GET['idTriangulo'] : 0;
$msg = isset($_GET['MSG']) ? $_GET['MSG'] : "";
if ($id > 0) {
    $contato = Triangulo::listar(1, $id)[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['idTriangulo']) ? $_POST['idTriangulo'] : 0;
    $lado1 = isset($_POST['lado1']) ? $_POST['lado1'] : 0;
    $lado2 = isset($_POST['lado2']) ? $_POST['lado2'] : 0;
    $lado3 = isset($_POST['lado3']) ? $_POST['lado3'] : 0;
    $cor = isset($_POST['cor']) ? $_POST['cor'] : "null";
    $unidade = isset($_POST['unidade']) ? $_POST['unidade'] : 0;
    $tipo = isset($_POST['escolhaQuad']) ? $_POST['escolhaQuad'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : 0;
    $formato = isset($_POST['forma']) ? $_POST['forma'] : "";

    try {
        $validacao = VerificarForma($lado1, $lado2, $lado3, $formato);
        if ($validacao !== $formato) {
            throw new Exception("Formato informado inválido");
        }
        $unid = Medida::listar(1, $unidade)[0];
        if ($tipo == "img") {
            $nome_arquivo = $_FILES['imagem']['name'];
            $tmp_nome = $_FILES['imagem']['tmp_name'];
            $nome_unico = uniqid() . '.' . pathinfo($nome_arquivo, PATHINFO_EXTENSION);

            $caminho_relativo = IMG . $nome_unico;

            if ($formato == "equi") {
                $triangulo = new Equilatero($id, $lado1, $lado2, $lado3, null, $caminho_relativo, $unid, $validacao);
            } elseif ($formato == "iso")
                $triangulo = new Isoceles($id, $lado1, $lado2, $lado3, null, $caminho_relativo, $unid, $validacao);
            else {
                $triangulo = new Escaleno($id, $lado1, $lado2, $lado3, null, $caminho_relativo, $unid, $validacao);
            }
            move_uploaded_file($tmp_nome, IMG . $nome_unico);
        } else {
            if ($formato == "equi")
                $triangulo = new Equilatero($id, $lado1, $lado2, $lado3, $cor, null, $unid, $validacao);
            elseif ($formato == "iso")
                $triangulo = new Isoceles($id, $lado1, $lado2, $lado3, $cor, null, $unid, $validacao);
            else
                $triangulo = new Escaleno($id, $lado1, $lado2, $lado3, $cor, null, $unid, $validacao);
        }
        if (!$triangulo->verificarTriangulo()) {
            throw new Exception("A soma dos ângulos não fecha.");
        }

        $resultado = "";
        if ($acao == 'salvar') {
            if ($id > 0) {
                $resultado = $triangulo->alterar();
            } else {
                $resultado = $triangulo->incluir();
            }
        } elseif ($acao == 'excluir') {
            $resultado = $triangulo->excluir();
            header('Location:index.php');
        }
        if ($resultado) {
            header('Location: index.php');
        } else {
            echo "Erro ao inserir dados!";
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $busca = isset($_GET['busca']) ? $_GET['busca'] : "";
    $tipobusca = isset($_GET['tipobusca']) ? $_GET['tipobusca'] : 0;
    $lista = Triangulo::listar($tipobusca, $busca);
}
function VerificarForma($lado1, $lado2, $lado3, $formato)
{
    $shape = "";

    if ($lado1 == $lado2 && $lado2 == $lado3) {
        $shape = "equi";
    } elseif ($lado1 == $lado2 || $lado1 == $lado3 || $lado2 == $lado3) {
        $shape = "iso";
    } else {
        $shape = "esca";
    }

    if ($shape == $formato) {
        return $shape;
    } else {
        return "Formato informado inválido";
    }
}
