<form method="POST">
    ID da Pergunta: <input type="number" name="id" required>
    <button type="submit">Excluir</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $id = $_POST['id'];
    $linhas = file("data.txt", FILE_IGNORE_NEW_LINES);
    $novas = [];
    foreach ($linhas as $linha) {
        $dado = json_decode($linha, true);
        if ($dado['id'] != $id) {
            $novas[] = $linha;
        }
    }
    file_put_contents("data.txt", implode("\n",$novas)."\n");
    echo "Pergunta excluída! <a href='index.php'>Voltar</a>";
}
?>
