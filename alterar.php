<form method="POST">
    ID da Pergunta para alterar: <input type="number" name="id" required>
    <button type="submit" name="buscar">Buscar</button>
</form>

<?php
if (isset($_POST['buscar'])) {
    $id = $_POST['id'];
    $linhas = file("data.txt", FILE_IGNORE_NEW_LINES);
    foreach ($linhas as $linha) {
        $dado = json_decode($linha, true);
        if ($dado['id'] == $id) {
            $pergunta = $dado['pergunta'];
            $tipo = $dado['tipo'];
            ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">
                Pergunta: <input type="text" name="pergunta" value="<?= $pergunta ?>"><br>
                <?php if ($tipo=="multipla"): ?>
                    a) <input type="text" name="a" value="<?= $dado['respostas'][0] ?>"><br>
                    b) <input type="text" name="b" value="<?= $dado['respostas'][1] ?>"><br>
                    c) <input type="text" name="c" value="<?= $dado['respostas'][2] ?>"><br>
                    d) <input type="text" name="d" value="<?= $dado['respostas'][3] ?>"><br>
                    e) <input type="text" name="e" value="<?= $dado['respostas'][4] ?>"><br>
                <?php endif; ?>
                <button type="submit" name="salvar">Salvar Alterações</button>
            </form>
            <?php
        }
    }
}

if (isset($_POST['salvar'])) {
    $id = $_POST['id'];
    $pergunta = $_POST['pergunta'];

    $linhas = file("data.txt", FILE_IGNORE_NEW_LINES);
    $novas = [];

    foreach ($linhas as $linha) {
        $dado = json_decode($linha, true);
        if ($dado['id'] == $id) {
            if ($dado['tipo']=="multipla") {
                $dado['pergunta'] = $pergunta;
                $dado['respostas'] = [
                    $_POST['a'],$_POST['b'],$_POST['c'],$_POST['d'],$_POST['e']
                ];
            } else {
                $dado['pergunta'] = $pergunta;
            }
        }
        $novas[] = json_encode($dado);
    }

    file_put_contents("data.txt", implode("\n",$novas)."\n");
    echo "Pergunta alterada! <a href='index.php'>Voltar</a>";
}
?>
