<?php
require_once '../func/func.php';
require_once '../cadastro/cadastro.php';
require_once '../model/produtoDAO.php';
require_once '../model/mercadoDAO.php';
require_once '../model/filtroProdutoDAO.php';
session_start();
$filtroProdutoDAO = new filtroProdutoDAO($conn);
$produtoDAO = new produtoDAO($conn);
$mercadoDAO = new mercadoDAO($conn);
$id_mercado = $_SESSION['usuario']['verMercado'] ?? '';
$infmercado = $mercadoDAO->getMercadoById($id_mercado);
$filtroproduto = $_GET['filtroproduto']??'';
$allfiltros = $filtroProdutoDAO->getAllFiltroByIdMercado($id_mercado);
require_once '../inc/cabecalho.php'; ?>

<div class="wrapper">
<div id="area-principal">
    <div id="area-postagens">


    <?php
    // o cabeçalho é mostrado em cima normal, porem, se a pessoa não estiver logada é criado uma div postagem e mostra pro usuário que ele não pode acessar essa pagina 
    voceNaoTemPermissao();



    ?>

    <!--Abertura postagem -->
    <div class="postagem home">

        <div class="login-box">
           


            <?php if (clienteEstaLogado() || admEstaLogado()) : ?>
                <h1>Produtos do mercado: <br><?= ucwords($infmercado['nomeMerc']); ?>
                </h1>
                    <button class='button_padrao' onclick="window.location.href='../home/verPerfilMercado.php' ">Voltar</button>
                    <form action="" method="GET">
                                <select name="filtroproduto" onchange="this.form.submit()">
                                    <option value="" selected disabled>Filtrar produto</option>
                                    <?php foreach ($allfiltros as $filtro) : ?>

                                        <option value="<?= $filtro['id_filtro'] ?>" <?= ($filtro['id_filtro'] == $filtroproduto) ? 'selected' : '' ?>>
                                            <?= ucwords($filtro['nomeFiltro']) ?>
                                        </option>

                                    <?php endforeach ?>
                                </select>
                            </form>

                            <div class="margin"><a class="button_padrao btn_delete" href="?">Limpar filtro</a></div>

            <?php endif ?>

           
        </div>
    </div>









<?php 
if (empty($id_mercado) || isset($id_mercado)) {
                voceNaoTemPermissao();
            }
            $produtos = $produtoDAO->getAllProdutoByIdMercado($id_mercado);
            $mercado = $mercadoDAO->getMercadoById($id_mercado);
            if (!empty($produtos)) { ?>
                <div class="postagem postagem_produto flex home">
                    <?php foreach ($produtos as $produto) : 
                        if(empty($_GET['filtroproduto']) || $_GET['filtroproduto']==$produto['id_filtro']):
                        ?>
                        <div class="view_produto" id="<?= $produto['id_produto'] ?>">

                            <h2> <?= $produto['nome'] ?> </h2>

                            <img src="../cadastro/uploads/<?= $produto['fotoProduto'] ?>" alt="Imagem do mercado" width="300px">


                            <h2> <?= number_format($produto['preco'], 2, ',', '.') ?> R$ </h2>
                            <?php if (!empty($produto['descricao'])) : ?>
                                <h3 class="descricao">Descrição
                                    <span class="mostrar"><?= $produto['descricao'] ?></span>
                                </h3>
                            <?php else : ?>
                                <h3 class="descricao ">Descrição
                                    <span class="mostrar">Este produto não possui descrição</span>
                                </h3>
                            <?php endif ?>

                            <?php if (clienteEstaLogado() && $mercado['compras'] == 'sim') : ?>
                                <a href="add_carrinho.php?id_produto=<?= $produto['id_produto'] ?>">Adicionar ao carrinho</a>
                            <?php endif ?>
                        </div>


                        <?php endif  ?>
                        <?php endforeach  ?>
                </div>
                </div>


                <?php if($mercado['compras']=='sim' && clienteEstaLogado()): ?>

                <div id="area-lateral">
                    <?php require_once '../home/carrinho.php'; ?>
                </div>

                <?php endif ?>

            <?php } else {
                echo "<div class='postagem'>
                <h2>Ainda não foram inseridos produtos</h2>
                </div>";
                }
                 ?>
            </div>
<!--// Fechamento postagem -->
<?php require_once '../inc/rodape.php'; ?>