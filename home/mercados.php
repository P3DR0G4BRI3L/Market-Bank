<?php
require_once '../cadastro/cadastro.php';
require_once '../func/func.php';
session_start();

//verifica se tem algum usuário logado retorna true ou false



if (usuarioEstaLogado()) {
    $userlog = ucwords($_SESSION['usuario']['nome']);

    if ($_SESSION['usuario']['tipo'] == 'dono') {
        $mercName = $_SESSION['usuario']['id_usuario'];
        $mercado=$conn->prepare("SELECT * FROM mercado WHERE id_dono = :id_dono");
        $mercado->bindValue(':id_dono',$mercName,PDO::PARAM_INT);
        $mercado->execute();
        $infmercado = $mercado->fetch();

    }
}
require_once '../inc/cabecalho.php';//mostra o cabeçalho
?>



    <div id="area-principal">

        <div id="area-postagens">


            <?php
            // o cabeçalho é mostrado em cima normal, porem, se a pessoa não estiver logada é criado uma div postagem e mostra pro usuário que ele não pode acessar essa pagina 
            if (!usuarioEstaLogado()) {
                ?>
                <div class="postagem">
                    <link rel="stylesheet" href="../css/cadastro.css">
                    <h2>Você não tem permissão para acessar essa página</h2>
                    <h2>Realize o cadastro</h2>

                    <div class="login-box"><button class='btn_left' onclick="window.location.href='../index.php'; ">Voltar</button></div>

                </div>
                <div id="rodape">
                    &copy Todos os direitos reservados
                </div>
                <?php
                exit;
            }

            ?>


            <?php
            $result = $conn->prepare("SELECT * FROM mercado;");
            $result->execute();
            ?>

            <!--Abertura postagem -->

            <!--lista os mercados, usando fetchAll no $result,  -->
            <?php if ($result->rowCount() > 0) {
                $mercados=$result->fetchAll();
                foreach ($mercados as $mercado  ) { ?>
                    <div class="postagem">
                    
                        <?php
                        
                        
                        
                        echo "<h2> " . ucwords($mercado['nomeMerc']) . " </h2>"; //nome do mercado
                
                        echo '<img src="../cadastro/uploads/' . $mercado['imagem'] . '" alt="Imagem do mercado" width="620px">';


                        echo "<h2>" . $mercado['endereco'] . "</h2>"; //endereço do mercado

                        echo "<h2>Aberto das " . date('H:i', strtotime($mercado['horarioAbert'])) . "</h2>"; //endereço do mercado

                        echo "<h2> Até as " . date('H:i', strtotime($mercado['horarioFecha'])) . "</h2>"; //endereço do mercado
                        
                        echo "<h2> telefone para contato: " . formatarTelefone($mercado['telefone']) . "</h2>";
                        
                
                            ?>
                        <?php if (clienteEstaLogado()): ?>
                            <form action="../CRUD/read-prod.php" method="POST">
                                <input type="hidden" name="id_mercado" value="<?= $mercado['id_mercado']; ?>">
                                <button class='btn_left' type="submit">Ver produtos</button>

                            </form>
                        <?php endif ?>
                    </div><?php }    
                    
            } ?>
            <hr>
            <!--// Fechamento postagem -->

            <!--Abertura postagem -->
            <h2 class="postagem2">Sessões</h2>
            <div class="postagem" id="paes">
                <h2>Pães e Bolos</h2>
                <span class="data-postagem">postado 20 março 2022</span>
                <img width="400px" src="img/pao.jpg">

                <p>
                    Pães, Bolos e Queijos.
                </p>
                <a href="">Ver mais</a>
            </div>
            <div class="postagem" id="bebidas">
                <h2>Bebidas Alcoolicas.</h2>
                <span class="data-postagem">postado 20 março 2022</span>
                <img width="400px" src="img/img5.webp">

                <p>
                    Cervejas,Vinhos e Destilados.
                </p>
                <a href="">Ver mais</a>
            </div>
            <div class="postagem" id="bebidas2">
                <h2>Refrigerantes.</h2>
                <span class=" data-postagem">postado 10 março 2022</span>
                <img width="400px" src="img/img6.webp">
                <p>
                    Coca Cola, Sprite, Fanta, Cola etc.
                </p>
                <a href="">Ver mais</a>
            </div>
            <div class="postagem" id="fvl">
                <h2>Frutas, Legumes e Verduras.</h2>
                <span class="data-postagem">postado 10 março 2022</span>
                <img width="400px" src="img/img7.jpg">
                <p>
                    Maçã, Melancia, Berinjela, Alface etc.
                </p>
                <a href="">Ver mais</a>
            </div>
            <div class="postagem" id="limpeza">
                <h2 href="">Produtos de limpeza</h2>
                <span class="data-postagem">postado 10 março 2022</span>
                <img width="400px" src="img/img8.jpg">
                <p>
                    Vassouras, Desinfetantes, Sabão, Detergente etc.
                </p>
                <a href="">Ver mais</a>
            </div>
            <div class="postagem" id="frios">
                <h2>Congelados</h2>
                <span class="data-postagem">postado 10 março 2022</span>
                <img width="400px" src="img/img9.avif">
                <p>
                    Hamburguer, Lasanha, Pizza, Frango etc.
                </p>
                <a href="">Ver mais</a>
            </div>
            <!-- // Fechamento postagem -->
        </div>

        <div id="area-lateral">
            <div class="conteudo-lateral">
                <h3>Postagens recentes</h3>
                <div class="postagem-lateral">
                    <p>O Market Bank é para você ter </p>
                    <a href="">Ver mais</a>
                </div>

                <div class="postagem-lateral" style="border-bottom: none;">
                    <p>Produtos em destaque</p>
                    <a href="">Ver mais</a>
                </div>
            </div>

            <div class="conteudo-lateral">
                <h3>Categorias/Sessões</h3>

                <a href="#paes">Pães e Bolos</a><br>
                <a href="#bebidas">Bebidas Alcoolicas</a><br>
                <a href="#bebidas2">Bebidas sem alcool</a><br>
                <a href="#limpeza">Limpeza</a><br>
                <a href="#fvl">Frutas/Legumes/Verduras</a><br>
                <a href="#frios">Congelados</a><br>

            </div>

        </div>


        
       <?php require_once '../inc/rodape.php'; ?>