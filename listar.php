<?php
$linhas = file("data.txt", FILE_IGNORE_NEW_LINES);
echo "<h1>Perguntas</h1>";
foreach ($linhas as $linha) {
    $dado = json_decode($linha, true);
    echo "<b>ID {$dado['id']}:</b> {$dado['pergunta']} ({$dado['tipo']})<br>";
    if ($dado['tipo']=="multipla") {
        foreach ($dado['respostas'] as $r) {
            echo $r."<br>";
        }
    }
    echo "<hr>";
}
echo "<a href='index.php'>Voltar</a>";
