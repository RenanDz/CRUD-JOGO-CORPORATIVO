<!DOCTYPE html>
<html>
<head><title>Game Corporativo</title></head>
<body>
<h1>Menu</h1>

<!-- Usuários -->
<a href="usuario.php?listar=1">Listar Usuários</a><br>
<form method="post" action="usuario.php">
    <h3>Criar Usuário</h3>
    Nome: <input type="text" name="nome"><br>
    Email: <input type="text" name="email"><br>
    Senha: <input type="password" name="senha"><br>
    <input type="hidden" name="acao" value="criar">
    <button type="submit">Salvar</button>
</form>
<hr>

<!-- Perguntas -->
<a href="pergunta.php?listar=1">Listar Perguntas</a><br>
<form method="post" action="pergunta.php">
    <h3>Criar Pergunta</h3>
    Texto: <input type="text" name="texto"><br>
    Tipo:
    <select name="tipo">
        <option value="texto">Texto</option>
        <option value="multipla">Múltipla escolha</option>
    </select><br>
    <p>Respostas (somente se múltipla escolha):</p>
    <input type="text" name="respostas[]"><br>
    <input type="text" name="respostas[]"><br>
    <input type="text" name="respostas[]"><br>
    <input type="hidden" name="acao" value="criar">
    <button type="submit">Salvar</button>
</form>

</body>
</html>
