<?php
$arquivo = "data.txt";

function lerDados($arquivo) {
    if(!file_exists($arquivo)) return [];
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $dados = [];
    foreach($linhas as $linha) $dados[] = json_decode($linha, true);
    return $dados;
}

function salvarDados($arquivo, $dados) {
    $linhas = [];
    foreach($dados as $d) $linhas[] = json_encode($d);
    file_put_contents($arquivo, implode("\n",$linhas)."\n");
}

if($_SERVER['REQUEST_METHOD']==='POST') {
    $dados = lerDados($arquivo);
    $id = count($dados)+1;
    $tipo = $_POST['tipo'];
    $pergunta = htmlspecialchars($_POST['pergunta']);
    $respostas = [];
    $correta = '';

    if($tipo==='multipla') {
        $respostas = [
            "a" => htmlspecialchars($_POST['a']),
            "b" => htmlspecialchars($_POST['b']),
            "c" => htmlspecialchars($_POST['c']),
            "d" => htmlspecialchars($_POST['d']),
            "e" => htmlspecialchars($_POST['e'])
        ];
        $correta = $_POST['correta'] ?? '';
    }

    $dados[] = [
        "id"=>$id,
        "tipo"=>$tipo,
        "pergunta"=>$pergunta,
        "respostas"=>$respostas,
        "correta"=>$correta
    ];

    salvarDados($arquivo, $dados);
    echo "Pergunta cadastrada com sucesso! <a href='criar.php'>Voltar</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Criar Pergunta</title>
</head>
<body>
<h1>Criar Pergunta</h1>

<form method="POST" action="">
    Pergunta:<br>
    <input type="text" name="pergunta" required><br><br>

    Tipo:<br>
    <select name="tipo" id="tipo" onchange="mostrarCampos()">
        <option value="">Selecione</option>
        <option value="multipla">Múltipla escolha</option>
        <option value="texto">Texto</option>
    </select><br><br>

    <div id="respostas" style="display:none;">
        a) <input type="text" name="a" required> <input type="radio" name="correta" value="a" required> Correta<br>
        b) <input type="text" name="b" required> <input type="radio" name="correta" value="b"> Correta<br>
        c) <input type="text" name="c" required> <input type="radio" name="correta" value="c"> Correta<br>
        d) <input type="text" name="d" required> <input type="radio" name="correta" value="d"> Correta<br>
        e) <input type="text" name="e" required> <input type="radio" name="correta" value="e"> Correta<br>
    </div><br>

    <button type="submit">Salvar</button>
</form>

<script>
function mostrarCampos() {
    var tipo = document.getElementById('tipo').value;
    document.getElementById('respostas').style.display = (tipo === 'multipla') ? 'block' : 'none';
}
</script>

</body>
</html>
