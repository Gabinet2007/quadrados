<!DOCTYPE html>
<html lang="en">
<?php
include_once('medida.php');
?>

<head>
    <title>Formulário de criação de medidas</title>
</head>

<body>


    <form action="medida.php" method="post">

        <input type="text" name="id" id="id" value="<?= $id ?>" readonly><br>
        <label for="altura">Altura:</label>
        <br>
        <label for="nome">Unidade: </label>
        <input type="text" name="nome" id="nome" value="<?= $id ? $medida->getNome() : "" ?>">
        <br>
        <input type="submit" name="acao" id="acao" value="salvar">
        <input type="submit" name="acao" id="acao" value="excluir">

    </form>
    <form action="" method="get">
        <input type="text" name="busca" id="busca">
        <select name="tipo" id="tipo">
            <option value="1">ID</option>
            <option value="2">Nome</option>
        </select>
        <input type="submit" name="acao" id="acao" value="Buscar"><br>
        <a href="../quadrado/index.php">quadrado</a><br><br><br>
    </form>
    <!-- <table border="1px">
        <th>Id</th> <th>Altura</th> <th>cor</th> <th>unidade</th> -->
    <?php
    foreach ($lista as $medidas) {
        echo "<td><a href='index.php?id=" . $medidas->getIdMedida() . "'>" . $medidas->getNome() . "</a></td><br>";
    }





    ?>
    <!-- </table> -->
</body>

</html>