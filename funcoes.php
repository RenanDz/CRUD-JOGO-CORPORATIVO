<?php
function lerArquivo($arquivo) {
    if (!file_exists($arquivo)) return [];
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $dados = [];
    foreach ($linhas as $linha) {
        $dados[] = explode("|", $linha);
    }
    return $dados;
}

function salvarArquivo($arquivo, $dados) {
    $conteudo = [];
    foreach ($dados as $linha) {
        $conteudo[] = implode("|", $linha);
    }
    file_put_contents($arquivo, implode("\n", $conteudo));
}

function proximoId($dados) {
    if (empty($dados)) return 1;
    return max(array_map('intval', array_column($dados, 0))) + 1;
}
?>
