<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pergunta = $_POST['pergunta'];
    $tipo = $_POST['tipo'];
    $respostas = [];

    if ($tipo == "multipla") {
        $respostas = [
            "a) ".$_POST['a'],
            "b) ".$_POST['b'],
            "c) ".$_POST['c'],
            "d) ".$_POST['d'],
            "e) ".$_POST['e'],
        ];
    }

    // Pegar último ID
    $linhas = file("data.txt", FILE_IGNORE_NEW_LINES);
    $id = count($linhas) + 1;

    $dados = ["id"=>$id,"tipo"=>$tipo,"pergunta"=>$pergunta,"respostas"=>$respostas];

    file_put_contents("data.txt", json_encode($dados)."\n", FILE_APPEND);

    echo "Pergunta cadastrada com sucesso! <a href='index.php'>Voltar</a>";
    exit;
}
?>

<form method="POST" action="?acao=criar">
    Pergunta: <input type="text" name="pergunta" required><br>
    
    Tipo:
    <select name="tipo" id="tipo" onchange="mostrarCampos()">
        <option value="">Selecione</option>
        <option value="multipla">Múltipla escolha</option>
        <option value="texto">Texto</option>
    </select><br>
    
    <div id="respostas" style="display:none;">
        a) <input type="text" name="a"><br>
        b) <input type="text" name="b"><br>
        c) <input type="text" name="c"><br>
        d) <input type="text" name="d"><br>
        e) <input type="text" name="e"><br>
    </div>
    
    <button type="submit">Salvar</button>
</form>

<script>
function mostrarCampos() {
    var tipo = document.getElementById('tipo').value;
    var respostas = document.getElementById('respostas');
    if(tipo === 'multipla') {
        respostas.style.display = 'block';
    } else {
        respostas.style.display = 'none';
    }
}
</script>

<?php if(isset($_POST['tipo']) && $_POST['tipo']=="multipla"): ?>
<form method="POST">
    <input type="hidden" name="tipo" value="multipla">
    Pergunta: <input type="text" name="pergunta" required><br>
    a) <input type="text" name="a" required><br>
    b) <input type="text" name="b" required><br>
    c) <input type="text" name="c" required><br>
    d) <input type="text" name="d" required><br>
    e) <input type="text" name="e" required><br>
    <button type="submit">Salvar</button>
</form>
<?php endif; ?>

<?php if(isset($_POST['tipo']) && $_POST['tipo']=="texto"): ?>
<form method="POST">
    <input type="hidden" name="tipo" value="texto">
    Pergunta: <input type="text" name="pergunta" required><br>
    <button type="submit">Salvar</button>
</form>
<?php endif; ?>
