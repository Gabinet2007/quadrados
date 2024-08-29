<!DOCTYPE html>
<html lang="en">
<?php
include_once('medida.php');
?>

<head>
    <title>Formulário de criação de medidas</title>
</head>

<body>


    <form action="medida.php" method="post" enctype="multipart/form-data">

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
    <table border="1px">
        <th>Id</th><th>Medida</th>
        <?php
        foreach ($lista as $medidas) {
            echo "<tr><td><a href='index.php?id=" . $medidas->getIdMedida() . "'>" . $medidas->getIdMedida() . "</a></td><td>". $medidas->getNome() . "</td><tr>";
        }





        ?>
    </table>
</body>

</html>