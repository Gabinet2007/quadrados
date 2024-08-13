<!DOCTYPE html>
<html lang="en">
<?php
include_once('quadrado.php');
?>

<head>
    <title>Formulário de criação de formas</title>
</head>

<body>


    <form action="quadrado.php" method="post">

        <input type="text" name="id" id="id" value="<?= $id ?>" readonly><br>
        <label for="altura">Altura:</label>
        <input type="number" name="altura" id="altura" value="<?= $id ? $contato->getAltura() : 0 ?>" placeholder=" Digite a altura de sua forma">
        <br>
        <label for="altura">Cor:</label>
        <input type="color" name="cor" id="cor" placeholder=" Digite a cor de sua forma" value="<?= $id ? $contato->getCor() : "black" ?>">
        <br>
        <label for="altura">Unidade:</label>
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
        <input type="text" name="busca" id="busca" placeholder="Buque">
        <select name="tipo" id="tipo">
            <option value="1">ID</option>
            <option value="2">Lado</option>
            <option value="3">Cor</option>
            <option value="4">Medida</option>
        </select>
        <input type="submit" name="acao" id="acao" value="Buscar"><br>
        <a href="../medida/index.php">medidas</a><br><br><br>
    </form>
    <!-- <table border="1px">
        <th>Id</th> <th>Altura</th> <th>cor</th> <th>unidade</th> -->
    <?php
    foreach ($lista as $quadrado) {
        echo "<td><a href='index.php?id=" . $quadrado->getIdQuadrado() . "'>" . $quadrado->desenharQuadrado($quadrado) . "</a></td>";
    }




    ?>
    <!-- </table> -->
</body>

</html>