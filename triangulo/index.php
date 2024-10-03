<!DOCTYPE html>
<html lang="pt-br">
<?php
include_once('triangulo.php');
// include('../outros/navbar.php');

?>

<head>
    <title>Formulário de criação de formas</title>
</head>

<body>


    <form action="triangulo.php" method="post" enctype='multipart/form-data'>
        <!-- <input type="text" name="id" id="id" value="<?= $id ?>" placeholder=" Digite a altura de sua forma"> -->
        <label for="lado1">Lado1: </label>
        <input type="number" name="lado1" id="lado1" value="<?= $id ? $contato->getLado1() : 0 ?>"><br>
        <label for="lado2">Lado2: </label>
        <input type="number" name="lado2" id="lado2" value="<?= $id ? $contato->getLado2() : 0 ?>"><br>
        <label for="lado3">Base:</label>
        <input type="number" name="lado3" id="lado3" value="<?= $id ? $contato->getLado3() : 0 ?>">
        <br>
        <br>
        <select name="forma" id="forma">
            <option value="equi" <?php if ($id) {
                                        if ($contato->getFormato() == "equi") echo "selected";
                                    } ?>>Equilatero</option>
            <option value="esca" <?php if ($id) {
                                        if ($contato->getFormato() == "esca") echo "selected";
                                    } ?>>Escaleno</option>
            <option value="iso" <?php if ($id) {
                                    if ($contato->getFormato() == "iso") echo "selected";
                                } ?>>Isosceles</option>
        </select>
        <br><br>
        <label for="escolhaQuad">Tipo:</label>
        <input type="radio" name="escolhaQuad" id="escolhaQuad" value="color">Cor
        <input type="radio" name="escolhaQuad" id="escolhaQuad" value="img">Imagem
        <br>
        <input type="color" name="cor" id="cor" value="<?= $id ? $contato->getCor() : "black" ?>">
        <input type="file" name="imagem" id="imagem" value="<?= $id ? $contato->getImagem() : null ?>">
        <br>
        <label for="unidade">Unidade:</label>
        <select name='unidade' id='unidade'>
            <option value="0" disabled>Selecione</option>
            <?php
            $unidades = Medida::listar();
            foreach ($unidades as $unidade) {
                $str = "<option value='{$unidade->getIdMedida()} '";
                if (isset($contato) && $contato->getIdMedida()->getIdMedida() == $unidade->getIdMedida())
                    $str .= " selected";
                $str .= ">{$unidade->getNome()}</option>";
                echo $str;
            }
            ?>
        </select>



        <br>
        <input type="text" name="idTriangulo" id="idTriangulo" value="<?= isset($contato) ? $contato->getId() : 0 ?>" hidden>
        <input type="submit" name="acao" id="acao" value="salvar">
        <input type="submit" name="acao" id="acao" value="excluir">
        <input type="reset" name="resetar" id="resetar" value="Resetar">

    </form>
    <form action="" method="get">
        <input type="text" name="busca" id="busca">
        <select name="tipobusca" id="tipobusca">
            <option value="1">ID</option>
            <option value="2">Lado1</option>
            <option value="3">Base</option>
            <option value="4">Cor</option>
            <option value="5">Unidade</option>
        </select>
        <input type="submit" name="acao" id="acao" value="Buscar">
    </form>
    <!-- <table border="1px">
        <th>Id</th> <th>Altura</th> <th>cor</th> <th>unidade</th> -->
    <?php
    // Triangulo::listar(1,$id){}
    foreach ($lista as $triangulo) {
        echo $triangulo->desenhar() . "<br>
        Id: " . $triangulo->getId() . "<br>
        Tipo: " . $triangulo->getFormato() . " <br>
        Perímetro: " . $triangulo->calcularPerimetro() . "<br>
        Área: " . $triangulo->calcularArea() . "<br>";
        echo "
    Lado 1: " . $triangulo->getLado1() . "<br>
    Lado 2: " . $triangulo->getLado2() . "<br>
    Base: " . $triangulo->getLado3() . "<br>
    Cor: " . $triangulo->getCor() . "<br>
    Unidade de medida: " . $triangulo->getIdMedida()->getNome() . "<br><br><hr>";
    }




    ?>
    <!-- </table> -->
</body>
<script src="../js/tipo.js"></script>

</html>