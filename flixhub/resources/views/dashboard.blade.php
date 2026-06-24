<head>
    <meta charset="UTF-8">
    <title>Painel - Flixhub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<div class="login-container dashboard-wrapper">
    <div id="bgSlider" class="bg-slider"></div>

    <nav class="navbar">
        <div class="nav-container">
            <a href="{{ route('filmes.index') }}" class="nav-logo">Flix<span>Hub</span></a>
            <ul class="nav-menu">
                <li><a href="{{ route('dashboard') }}" class="nav-link">Início</a></li>
                <li><a href="{{ route('filmes.index') }}" class="nav-link">Filmes</a></li>
                <li><a href="{{ route('series.index') }}" class="nav-link">Séries</a></li>
                <li><a href="{{ route('favoritos.index') }}" class="nav-link">Favoritos</a></li>
                <li><a href="{{ route('busca.index') }}" class="nav-link">Lista</a></li>
                
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Sair
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-menu-container">
        <h1 class="dashboard-title">O que vamos gerenciar hoje?</h1>
        
        <div class="menu-grid">
            <a href="{{ route('filmes.index') }}" class="menu-card">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6v7.5c0 .414.336.75.75.75h3.75a.75.75 0 0 0 .75-.75V6zM3.75 18v1.5c0 .414.336.75.75.75h3.75a.75.75 0 0 0 .75-.75V18zM12 6v7.5c0 .414.336.75.75.75h3.75a.75.75 0 0 0 .75-.75V6zM12 18v1.5c0 .414.336.75.75.75h3.75a.75.75 0 0 0 .75-.75V18z" />
                    </svg>
                </div>
                <span class="card-text">Filmes</span>
            </a>

            <a href="{{ route('series.index') }}" class="menu-card">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Zm0-13.5h12M6 11.25h12M6 15.75h12" />
                    </svg>
                </div>
                <span class="card-text">Séries</span>
            </a>

            <a href="{{ route('favoritos.index') }}" class="menu-card">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.172-.435.744-.435.916 0l2.3 5.122 5.436.701c.479.062.67.65.323.987l-4.053 3.954.96 5.31c.085.474-.413.836-.83.606L12 17.65l-4.83 2.768c-.416.23-.914-.132-.83-.605l.96-5.31-4.053-3.954c-.347-.336-.156-.925.322-.987l5.436-.701 2.3-5.122ZM12 3v13.5" />
                    </svg>
                </div>
                <span class="card-text">Favoritos</span>
            </a>

            <a href="{{ route('busca.index') }}" class="menu-card">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.602 10.602Z" />
                    </svg>
                </div>
                <span class="card-text">Lista</span>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const imagens = [
            "/img/imagem1.jpg", "/img/imagem2.jpg", "/img/imagem3.jpg",
            "/img/imagem8.jpg", "/img/imagem9.jpg", "/img/imagem10.jpg",
            "/img/img5.jpg", "/img/img6.jpg", "/img/img7.jpg",
            "/img/img8.jpg", "/img/imagem4.jpg", "/img/imagem5.jpg",
            "/img/img11.jpg", "/img/img12.jpg", "/img/img13.jpg",
            "/img/imagem6.jpg", "/img/img15.jpg", "/img/img16.jpg",
            "/img/imagem7.jpg"
        ];

        const slider = document.getElementById("bgSlider");
        let index = 0;

        function mudarFundo() {
            if(slider) {
                slider.style.backgroundImage = `url('${imagens[index]}')`;
                index = (index + 1) % imagens.length;
            }
        }

        mudarFundo();
        setInterval(mudarFundo, 5000);
    });
</script>