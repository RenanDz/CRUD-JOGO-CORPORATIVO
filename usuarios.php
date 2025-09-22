<?php
$arquivo_usuarios = "usuarios.txt";

function lerUsuarios($arquivo) {
    if (!file_exists($arquivo)) return [];
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $usuarios = [];
    foreach ($linhas as $linha) {
        $usuarios[] = json_decode($linha, true);
    }
    return $usuarios;
}

function salvarUsuarios($arquivo, $usuarios) {
    $linhas = [];
    foreach ($usuarios as $u) $linhas[] = json_encode($u);
    file_put_contents($arquivo, implode("\n",$linhas)."\n");
}

$acao = $_GET['acao'] ?? 'menu';

if ($acao === 'criar_usuario' && $_SERVER['REQUEST_METHOD']==='POST') {
    $usuarios = lerUsuarios($arquivo_usuarios);
    $id = count($usuarios)+1;
    $usuarios[] = ["id"=>$id,"nome"=>$_POST['nome'],"email"=>$_POST['email']];
    salvarUsuarios($arquivo_usuarios, $usuarios);
    echo "Usuário cadastrado! <a href='?'>Voltar</a>";
    exit;
}

if ($acao === 'alterar_usuario' && isset($_POST['id'])) {
    $usuarios = lerUsuarios($arquivo_usuarios);
    foreach ($usuarios as &$u) {
        if ($u['id']==$_POST['id']) {
            $u['nome'] = $_POST['nome'];
            $u['email'] = $_POST['email'];
        }
    }
    salvarUsuarios($arquivo_usuarios, $usuarios);
    echo "Usuário alterado! <a href='?'>Voltar</a>";
    exit;
}

if ($acao === 'excluir_usuario' && isset($_POST['id'])) {
    $usuarios = lerUsuarios($arquivo_usuarios);
    $usuarios = array_filter($usuarios, fn($u)=>$u['id'] != $_POST['id']);
    salvarUsuarios($arquivo_usuarios, $usuarios);
    echo "Usuário excluído! <a href='?'>Voltar</a>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CRUD Usuários</title>
</head>
<body>
<h1>CRUD Usuários</h1>
<ul>
    <li><a href="?acao=criar_usuario">Criar Usuário</a></li>
    <li><a href="?acao=listar_usuarios">Listar Usuários</a></li>
    <li><a href="?acao=alterar_usuario">Alterar Usuário</a></li>
    <li><a href="?acao=excluir_usuario">Excluir Usuário</a></li>
</ul>

<?php if ($acao==='criar_usuario'): ?>
<form method="POST" action="?acao=criar_usuario">
    Nome: <input type="text" name="nome" required><br>
    Email: <input type="email" name="email" required><br>
    <button type="submit">Cadastrar</button>
</form>

<?php elseif ($acao==='listar_usuarios'): ?>
<h2>Lista de Usuários</h2>
<?php
$usuarios = lerUsuarios($arquivo_usuarios);
foreach ($usuarios as $u) {
    echo "ID {$u['id']} - {$u['nome']} ({$u['email']})<br>";
}
?>

<?php elseif ($acao==='alterar_usuario' && isset($_GET['id'])): ?>
<?php
$usuarios = lerUsuarios($arquivo_usuarios);
$id = $_GET['id'];
foreach ($usuarios as $u) {
    if ($u['id']==$id) {
        ?>
        <form method="POST" action="?acao=alterar_usuario">
            <input type="hidden" name="id" value="<?= $u['id'] ?>">
            Nome: <input type="text" name="nome" value="<?= $u['nome'] ?>"><br>
            Email: <input type="email" name="email" value="<?= $u['email'] ?>"><br>
            <button type="submit">Salvar Alterações</button>
        </form>
        <?php
    }
}
?>

<?php elseif ($acao==='alterar_usuario'): ?>
<form method="GET">
    <input type="hidden" name="acao" value="alterar_usuario">
    Digite o ID do usuário que deseja alterar: <input type="number" name="id">
    <button type="submit">Buscar</button>
</form>

<?php elseif ($acao==='excluir_usuario'): ?>
<form method="POST" action="?acao=excluir_usuario">
    ID do usuário: <input type="number" name="id" required>
    <button type="submit">Excluir</button>
</form>
<?php endif; ?>
</body>
</html>
