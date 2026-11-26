<?php
require_once "conexao.php";

// Guardar uma mensagem para mostrar depois de cada ação
$mensagem = "";

// CADASTRAR OU ATUALIZAR UMA NOTÍCIA
if (isset($_POST["salvar"])) {
    $titulo = trim($_POST["titulo"]);
    $categoria = trim($_POST["categoria"]);
    $descricao = trim($_POST["descricao"]);
    $id = $_POST["id"];

    if ($titulo != "" && $categoria != "" && $descricao != "") {
        if ($id == "") {
            // Cadastrar uma notícia nova
            $sql = "INSERT INTO noticias (titulo, categoria, descricao) VALUES (?, ?, ?)";
            $consulta = $pdo->prepare($sql);
            $consulta->execute([$titulo, $categoria, $descricao]);
            $mensagem = "Notícia cadastrada com sucesso!";
        } else {
            // Atualizar uma notícia que já existe
            $sql = "UPDATE noticias SET titulo = ?, categoria = ?, descricao = ? WHERE id = ?";
            $consulta = $pdo->prepare($sql);
            $consulta->execute([$titulo, $categoria, $descricao, $id]);
            $mensagem = "Notícia atualizada com sucesso!";
        }
    } else {
        $mensagem = "Preencha todos os campos.";
    }
}

// EXCLUIR UMA NOTÍCIA
if (isset($_POST["excluir"])) {
    $id = $_POST["id"];
    $consulta = $pdo->prepare("DELETE FROM noticias WHERE id = ?");
    $consulta->execute([$id]);
    $mensagem = "Notícia excluída com sucesso!";
}

// BUSCAR UMA NOTÍCIA PARA EDITAR
$noticiaEditar = ["id" => "", "titulo" => "", "categoria" => "", "descricao" => ""];

if (isset($_GET["editar"])) {
    $id = $_GET["editar"];
    $consulta = $pdo->prepare("SELECT * FROM noticias WHERE id = ?");
    $consulta->execute([$id]);
    $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $noticiaEditar = $resultado;
    }
}

// LISTAR TODAS AS NOTÍCIAS
$consulta = $pdo->query("SELECT * FROM noticias ORDER BY id DESC");
$noticias = $consulta->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusTech - Gerenciar notícias</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>NexusTech</h1>
    <nav>
        <a href="index.html">Início</a>
        <a href="aplicativos.html">Aplicativos</a>
        <a href="mercado.html">Mercado</a>
        <a href="seguranca.html">Segurança</a>
        <a href="admin.php">Gerenciar notícias</a>
    </nav>
</header>

<main>
    <section>
        <h2>Gerenciar notícias</h2>
        <p>Nesta página é possível cadastrar, editar, listar e excluir notícias.</p>

        <?php if ($mensagem != "") { ?>
            <p class="mensagem"><?php echo htmlspecialchars($mensagem); ?></p>
        <?php } ?>

        <h3><?php echo $noticiaEditar["id"] == "" ? "Cadastrar notícia" : "Editar notícia"; ?></h3>
        <form method="POST" action="admin.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($noticiaEditar["id"]); ?>">

            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" maxlength="150" required value="<?php echo htmlspecialchars($noticiaEditar["titulo"]); ?>">

            <label for="categoria">Categoria:</label>
            <input type="text" id="categoria" name="categoria" maxlength="80" required value="<?php echo htmlspecialchars($noticiaEditar["categoria"]); ?>">

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($noticiaEditar["descricao"]); ?></textarea>

            <button type="submit" name="salvar">Salvar</button>
            <?php if ($noticiaEditar["id"] != "") { ?>
                <a href="admin.php">Cancelar edição</a>
            <?php } ?>
        </form>
    </section>

    <section>
        <h2>Notícias cadastradas</h2>
        <?php if (count($noticias) == 0) { ?>
            <p>Nenhuma notícia cadastrada.</p>
        <?php } ?>

        <?php foreach ($noticias as $noticia) { ?>
            <article class="item-noticia">
                <h3><?php echo htmlspecialchars($noticia["titulo"]); ?></h3>
                <p><strong>Categoria:</strong> <?php echo htmlspecialchars($noticia["categoria"]); ?></p>
                <p><?php echo nl2br(htmlspecialchars($noticia["descricao"])); ?></p>

                <a href="admin.php?editar=<?php echo $noticia["id"]; ?>">Editar</a>

                <form method="POST" action="admin.php" class="form-excluir" onsubmit="return confirm('Deseja realmente excluir esta notícia?');">
                    <input type="hidden" name="id" value="<?php echo $noticia["id"]; ?>">
                    <button type="submit" name="excluir">Excluir</button>
                </form>
            </article>
        <?php } ?>
    </section>
</main>

<footer><p>NexusTech - Trabalho de Desenvolvimento Web</p></footer>
</body>
</html>
