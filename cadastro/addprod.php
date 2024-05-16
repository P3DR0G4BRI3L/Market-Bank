<?php
require_once 'cadastro.php';
require_once '../func/func.php';

session_start();


if(!usuarioEstaLogado()){
    header('location:../index.php');
    exit;
}

if (!usuarioEstaLogado()) {
    echo "<script>alert('Você não tem permissão para acessar essa página');</script>";
    echo "<script>window.location.href='../index.php';</script>";
}


if (usuarioEstaLogado()) {
    $userlog = ucwords($_SESSION['usuario']['nome']);

    if ($_SESSION['usuario']['tipo'] == 'dono') {
        $mercName = $_SESSION['usuario']['id_usuario'];
        $mercado=$conn->prepare("SELECT * FROM mercado WHERE id_dono = :id_dono");
        $mercado->bindValue(':id_dono',$mercName,PDO::PARAM_STR);
        $mercado->execute();
        $infmercado = $mercado->fetch();

    }
}



?>
<!DOCTYPE html>
<html>

<head>
    <title>Mercados</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../css/cadastro.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="script/script.js"></script>

</head>

<body>

    <div id="area-cabecalho">

        <?php if (usuarioEstaLogado()): ?>

            <p class="aviso-login">Seja bem vindo&nbsp;<?= $userlog; ?></p>

            <!-- só mostra se for um mercado que estiver logado, mostra o nome do mercado -->
            <?php if (mercadoEstaLogado()): ?>
                <p class="aviso-login">Você está logado no mercado&nbsp;<?= $infmercado['nomeMerc']; ?></p>
            <?php endif ?>

        <?php endif ?>

        <!-- abertura postagem -->
        <div id="area-logo">
            <img src="../home/img/logo.png" alt="logo">
        </div>
        <div id="area-menu">
            <a href="../index.php">Home</a>

            <?php if (usuarioEstaLogado()): ?>
                <a href="../home/mercados.php">Mercados</a>
            <?php endif ?>

            <a href="../home/contato.php">Contato</a>
            <a href="../home/fale.php">Fale Conosco</a>



            

            <?php if (mercadoEstaLogado()): ?>
                <a href="verMeuMercado.php">Visualizar perfil</a>
            <?php endif ?>

            <?php if (usuarioEstaLogado()): ?>
                <a href="logout.php" onclick="return confirm('Deseja realizar logout?');">Logout</a>
            <?php endif ?>
        </div>

    </div>
    </div>
    <?php
   
    ?>
    <div id="area-principal">

        <div id="area-postagens">
            <!--Abertura postagem -->
            <div class="postagem">

                <h2>Adicionar produto em:&nbsp;<?= $infmercado['nomeMerc'] ?></h2>
               

                <div class="container">
					<div class="login-box">
						<form action="CRUD/create-prod.php" method="POST" enctype="multipart/form-data">
							
							<div class="input-group">
								<label for="nome">Nome do produto:</label>
								<input type="text" id="nome" name="nomeprod" onkeydown="if(event.keyCode === 13) event.preventDefault()" required>
							</div>
							
							<div class="input-group">
								<label for="preco">Preço:</label>
								<input type="number" id="preco" name="preco" onkeydown="if(event.keyCode === 13) event.preventDefault()" required>
							</div>
							
							<div class="input-group">
								<label for="senha">Foto do produto:</label>
								<input type="file" id="senha" name="imgprod" onkeydown="if(event.keyCode === 13) event.preventDefault()" required>
							</div>
							<button class="btn_left" onclick="window.location.href='CRUD/read-prod.php'">Voltar</button>
							<button type="submit">Entrar</button>
						</form>
					</div>
				</div>
            </div>
            <!--// Fechamento postagem -->

            <!--Abertura postagem -->
           
            
        <div id="rodape">
            &copy Todos os direitos reservados
        </div>
    </div>

</body>

</html>
<?php


?>