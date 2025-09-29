<form method="GET">
    ID da Pergunta: <input type="number" name="id" required>
    <button type="submit">Ver</button>
</form>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $linhas = file("data.txt", FILE_IGNORE_NEW_LINES);
    foreach ($linhas as $linha) {
        $dado = json_decode($linha, true);
        if ($dado['id'] == $id) {
            echo "<h2>{$dado['pergunta']}</h2>";
            if ($dado['tipo']=="multipla") {
                foreach ($dado['respostas'] as $r) echo $r."<br>";
            } else {
                echo "<i>Resposta livre em texto.</i>";
            }
        }
    }
}
?>
