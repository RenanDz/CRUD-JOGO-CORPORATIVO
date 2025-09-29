<?php
include "funcoes.php";
$arquivoPerguntas = "perguntas.txt";
$arquivoRespostas = "respostas.txt";
if (isset($_POST['acao']) && $_POST['acao'] == "criar") {
    $perguntas = lerArquivo($arquivoPerguntas);
    $idPergunta = proximoId($perguntas);
    $perguntas[] = [$idPergunta, $_POST['tipo'], $_POST['texto']];
    salvarArquivo($arquivoPerguntas, $perguntas);

    if ($_POST['tipo'] == "multipla" && !empty($_POST['respostas'])) {
        $respostas = lerArquivo($arquivoRespostas);
        foreach ($_POST['respostas'] as $texto) {
            if (trim($texto) == "") continue;
            $idResposta = proximoId($respostas);
            $respostas[] = [$idResposta, $idPergunta, $texto];
        }
        salvarArquivo($arquivoRespostas, $respostas);
    }

    echo "Pergunta criada com sucesso! <a href='index.php'>Voltar</a>";
}
if (isset($_POST['acao']) && $_POST['acao'] == "alterar") {
    $id = $_POST['id'];

    $perguntas = lerArquivo($arquivoPerguntas);
    foreach ($perguntas as &$p) {
        if ($p[0] == $id) {
            $p[1] = $_POST['tipo'];
            $p[2] = $_POST['texto'];
        }
    }
    salvarArquivo($arquivoPerguntas, $perguntas);

    if ($_POST['tipo'] == "multipla") {
        $respostas = lerArquivo($arquivoRespostas);
        $respostas = array_filter($respostas, fn($r) => $r[1] != $id);

        foreach ($_POST['respostas'] as $texto) {
            if (trim($texto) == "") continue;
            $novoId = proximoId($respostas);
            $respostas[] = [$novoId, $id, $texto];
        }
        salvarArquivo($arquivoRespostas, $respostas);
    }

    echo "Pergunta alterada com sucesso! <a href='index.php'>Voltar</a>";
}
if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $perguntas = lerArquivo($arquivoPerguntas);
    $respostas = lerArquivo($arquivoRespostas);

    foreach ($perguntas as $p) {
        if ($p[0] == $id) {
            echo "<h3>Editar Pergunta</h3>";
            echo "<form method='post' action='pergunta.php'>";
            echo "Texto: <input type='text' name='texto' value='$p[2]'><br>";
            echo "Tipo: <select name='tipo'>";
            echo "<option value='texto' ".($p[1]=='texto'?'selected':'').">Texto</option>";
            echo "<option value='multipla' ".($p[1]=='multipla'?'selected':'').">Múltipla escolha</option>";
            echo "</select><br>";

            if ($p[1] == "multipla") {
                echo "Respostas:<br>";
                foreach ($respostas as $r) {
                    if ($r[1] == $p[0]) {
                        echo "<input type='text' name='respostas[]' value='$r[2]'><br>";
                    }
                }
                echo "<input type='text' name='respostas[]'><br>";
                echo "<input type='text' name='respostas[]'><br>";
            }

            echo "<input type='hidden' name='acao' value='alterar'>";
            echo "<input type='hidden' name='id' value='$p[0]'>";
            echo "<button type='submit'>Salvar Alterações</button>";
            echo "</form>";
        }
    }
}

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];

    $perguntas = lerArquivo($arquivoPerguntas);
    $perguntas = array_filter($perguntas, fn($p) => $p[0] != $id);
    salvarArquivo($arquivoPerguntas, $perguntas);

    $respostas = lerArquivo($arquivoRespostas);
    $respostas = array_filter($respostas, fn($r) => $r[1] != $id);
    salvarArquivo($arquivoRespostas, $respostas);

    echo "Pergunta excluída com sucesso! <a href='index.php'>Voltar</a>";
}
if (isset($_GET['listar'])) {
    $perguntas = lerArquivo($arquivoPerguntas);
    $respostas = lerArquivo($arquivoRespostas);

    echo "<h3>Lista de Perguntas</h3>";
    foreach ($perguntas as $p) {
        echo "<b>$p[0] - $p[2]</b> (tipo: $p[1]) ";
        echo "<a href='pergunta.php?editar=$p[0]'>[Editar]</a> ";
        echo "<a href='pergunta.php?excluir=$p[0]'>[Excluir]</a><br>";
        foreach ($respostas as $r) {
            if ($r[1] == $p[0]) {
                echo " - $r[2]<br>";
            }
        }
        echo "<hr>";
    }
    echo "<a href='index.php'>Voltar</a>";
}
?>
