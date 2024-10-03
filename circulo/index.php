<!DOCTYPE html>
<html lang="en">
<?php
include_once('circulo.php');
// include('../outros/navbar.php');
?>

<head>
    <title>Formulário de criação de formas</title>
</head>

<body>


    <form action="circulo.php" method="post" enctype="multipart/form-data">

        <input type="text" name="id" id="id" value="<?= $id ?>" readonly hidden>
        <label for=" altura">Altura:</label>
        <input type="number" name="altura" id="altura" value="<?= $id ? $contato->getAltura() : 0 ?>"><br>
        <label for="escolhaQuad">Tipo:</label>
        <input type="radio" name="escolhaQuad" id="escolhaQuad" value="color">Cor
        <input type="radio" name="escolhaQuad" id="escolhaQuad" value="img">Imagem
        <br>
        <input type="color" name="cor" id="cor" value="<?= $id ? $contato->getCor() : "black" ?>"><br>
        <input type="file" name="imagem" id="imagem" value="<?= $id ? $contato->getImagem() : null ?>">
        <br>
        <label for="unidade">Unidade:</label>
        <select name="unidade" id="unidade">
            <?php
            $unidades = Medida::listar(0);
            foreach ($unidades as $unidade) {
                $str = "<option value='" . $unidade->getIdMedida() . "'";
                if (isset($contato))
                    if ($contato->getIdMedida()->getIdMedida() == $unidade->getIdMedida())
                        $str .= "selected";
                $str .= " >" . $unidade->getNome() . "</option>";
                echo $str;
            }
            ?>
        </select>
        <br>
        <input type="submit" name="acao" id="acao" value="salvar">
        <input type="submit" name="acao" id="acao" value="excluir">

    </form>
    <form action="" method="get">
        <input type="text" name="tipobusca" id="tipobusca">
        <select name="tipobusca" id="tipobusca">
            <option value="1">ID</option>
            <option value="2">Lado</option>
            <option value="3">Cor</option>
            <option value="4">Medida</option>
        </select>
        <input type="submit" name="acao" id="acao" value="Buscar"><br>
    </form>
    <table border="0px">
        <?php
        foreach ($lista as $circulo) {
            echo "
            Altura: " . $circulo->getAltura() . "<br>
            Cor: " . $circulo->getCor() . "<br>
            Unidade de medida: " . $circulo->getIdMedida()->getNome()  . "</a><br>
            Perímetro: " . $circulo->calcularPerimetro() . "<br>
            Área: " . $circulo->calcularArea() . "<br>";
            echo "<a href='index.php?id=" . $circulo->getId() . "'>" . $circulo->desenhar() . "</a><hr>";
        }




        ?>
    </table>
    <!-- <script src="../js/tipo.js"></script> -->
</body>

</html>