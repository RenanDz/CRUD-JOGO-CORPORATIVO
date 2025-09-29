<?php
include "funcoes.php";
$arquivo = "usuarios.txt";

if (isset($_POST['acao']) && $_POST['acao'] == "criar") {
    $usuarios = lerArquivo($arquivo);
    $id = proximoId($usuarios);
    $usuarios[] = [$id, $_POST['nome'], $_POST['email'], $_POST['senha']];
    salvarArquivo($arquivo, $usuarios);
    echo "Usuário criado com sucesso! <a href='index.php'>Voltar</a>";
}

if (isset($_GET['listar'])) {
    $usuarios = lerArquivo($arquivo);
    echo "<h3>Lista de Usuários</h3>";
    foreach ($usuarios as $u) {
        echo "$u[0] - $u[1] - $u[2]<br>";
    }
    echo "<a href='index.php'>Voltar</a>";
}
?>
