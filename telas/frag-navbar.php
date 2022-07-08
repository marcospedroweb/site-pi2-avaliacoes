<body>
    <header class="bg-primary">
        <div class="container-xxl">
            <nav class="navbar navbar-expand-lg navbar-light py-2 py-lg-0 flex-column flex-lg-row justify-content-start align-items-center">
                <div id="div-logo-mobile">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="./index.php" class="navbar-brand m-0 p-0"><img src="./imgs/logo-branca.png" alt="">
                            <h1 class="sr-only sr-only-focusable">Avalifind</h1>
                        </a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-categorias" aria-controls="navbar-categorias" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    </div>
                </div>
                <div class="collapse navbar-collapse justify-content-between align-items-center" id="navbar-categorias">
                    <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center ms-lg-2">
                        <div class="dropdown py-1 py-lg-0 drop-icon">
                            <button class="btn dropdown-toggle p-0 border-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Categorias
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <span class="dropdown-item fs-3 fw-bold dropdown-titulo">Categorias</span>
                                <li><a class="dropdown-item" href="./categorias.php?categoria=Filmes">Filmes</a></li>
                                <li><a class="dropdown-item" href="./categorias.php?categoria=Animes">Animes</a></li>
                                <li><a class="dropdown-item" href="./categorias.php?categoria=Series">Series</a></li>
                                <li><a class="dropdown-item" href="./categorias.php">Ver todas</a></li>
                            </ul>
                        </div>
                    </div>
                    <form action="./categorias.php" method="GET" class="py-3 px-0" id="form-procurar">
                        <div class="position-relative">
                            <i class="fas fa-search fs-3" id="fake-icon-procurar"></i>
                            <button class="btn btn-icon-procurar p-0 border-0"><i class="fas fa-search fs-3 icon-procurar"></i></button>
                            <input type="text" class="form-control d-block" list="opcoes-datalist" name="procurar-categoria" id="procurar-categoria" aria-describedby="emailHelp" autocomplete="off">
                            <?php 
                                include('./telas/frag-datalist.php');
                            ?>
                        </div>
                    </form>
                    <?php 
                        include("./telas/frag-mudar-login.php");//Verifica se usuario está logado
                    ?>
                </div>
            </nav>
        </div>
    </header>