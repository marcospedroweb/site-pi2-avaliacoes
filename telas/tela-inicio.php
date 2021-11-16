<main>
    <div class="container-xxl">
        <section class="banner mb-6">
            <div class="banner-div position-relative">
                <div
                    class="d-flex flex-column justify-content-center align-items-center text-center banner-container">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="banner-frase">
                            <span class="d-block fs-2">Encontre. Avalie.</span>
                            <h2 class="fs-1 pb-3">Deixe sua marca</h2>
                        </div>
                        <p class="fs-4">Avalie uma diversidade de categorias e compartilhe seu comentários com a
                            comunidade.
                        </p>
                        <a href="./categorias.php" class="btn btn-primary btn-xl mt-3">Avaliar categorias</a>
                    </div>
                </div>
                <div class="banner-role pb-4 text-center" id="role-para-baixo">
                    <a href="#beneficios-section" class="text-decoration-none">
                        <span class="d-block display-6"><i class="fas fa-arrow-circle-down"></i></span>
                        <span class="d-block fs-4 fw-bold">Role para baixo</span>
                    </a>
                </div>
            </div>
        </section>
    </div>
    <section class="text-center mb-6" id="beneficios-section">
        <div class="container-xxl">
            <h2 class="fs-2 mb-3">Benefícios em ter uma conta Avalifind</h2>
            <div class="Beneficios row justify-content-center pt-3">
                <div class="beneficio-card col-xl-4">
                    <img src="./imgs/navegue.png" class="img-fluid" alt="homem sorrindo olhando notebook">
                    <p class="fs-4">Navegue por diversas categorias e escolha suas favoritas</p>
                </div>
                <div class="beneficio-card col-xl-4">
                    <img src="./imgs/avalie.png" class="img-fluid" alt="homem sorrindo olhando notebook">
                    <p class="fs-4">Avalie categorias de sua escolha gratuitamentes</p>
                </div>
                <div class="beneficio-card col-xl-4">
                    <img src="./imgs/compartilhe.png" class="img-fluid" alt="homem sorrindo olhando notebook">
                    <p class="fs-4">Compartilhe sua opinião junto a outros usuários em nossa comunidade</p>
                </div>
            </div>
            <a href="./criar-conta.php" class="btn btn-primary">Criar um conta</a>
        </div>
    </section>
    <section class="bg-light text-center mb-6" id="destaques-do-mes">
        <div class="container-xxl">
            <h2 class="fs-2 mb-3">Categorias destaques do mês</h2>
            <div class="buttons-section pt-3 mb-3">
                <a class="btn btn-secondary active" href="?categoria=Filmes">Filmes</a>
                <a class="btn btn-secondary" href="?categoria=Animes">Animes</a>
                <a class="btn btn-secondary" href="?categoria=Series">Series</a>
            </div>
            <div class="row destaques justify-content-center">
                <div class="col-12 col-lg-10 row justify-content-between">
                    <?php 
                        $categoria = $_GET['categoria'] ?? 'Filmes';
                        if($categoria !== 'Filmes' && $categoria !== 'Animes' && $categoria !== 'Series'){
                            $categoria = 'Filmes';
                        }
                        $sql = "SELECT t.id, t.nome, sinopse, capa, avaliacaoGeral, c.tipo 
                                    FROM titulo as t INNER JOIN categoria as c
                                    ON t.categoria = c.id
                                    WHERE c.tipo = '{$categoria}'";

                        foreach($bd->query($sql) as $registro){
                            echo "<div class='destaque-card col-12 col-lg my-2 text-center'>
                                    <a href='./categoria-escolhida.php?nome={$registro['nome']}&categoria={$categoria}' class='d-block destaque-container' style='background: url(./imgs-usuario/{$registro['capa']}) center top / cover no-repeat #ccc;'>
                                        <span class='card-nome'>{$registro['nome']}</span>
                                        <i class='fas fa-search-plus'></i>
                                    </a>
                                    <i class='fas fa-search-plus'></i>
                                    <div class='card-estrelas py-2 d-flex justify-content-center align-items-start'>
                                        <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                                        <span><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                                        <span class='ps-2'><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                                        <span class='pe-2'><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                                        <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                                        <span class='pe-2'><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                                        <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                                        <span class='pe-2'><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                                        <span><img src='./imgs/Metade - cinza - esquerda.png' alt=''></span>
                                        <span><img src='./imgs/Metade - cinza - direita.png' alt=''></span>
                                        <span class='card-avaliacao ms-2'>{$registro['avaliacaoGeral']}</span>
                                    </div>
                                 </div>";
                        }
                    ?>
                </div>
            </div>
        </div>
    </section>
    <section class="container-xxl secao-encontre mb-6">
        <div class="row flex-column flex-lg-row justify-content-between align-items-center">
            <img src="./imgs/encontre-filmes.png" class="col-lg-6" alt="homem impressioando">
            <div class="encontre-texto text-center col-lg-6">
                <h2 class="fs-2 text-lg-start my-2 my-lg-0">Encontre o seu novo filme favorito avaliado pela
                    comunidade Avalifind
                </h2>
                <a href="./categorias.php?categoria=Filmes" class="btn btn-primary my-2 mt-lg-3">Ver filmes</a>
            </div>
        </div>
    </section>
</main>