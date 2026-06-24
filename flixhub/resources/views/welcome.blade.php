<head>
    <meta charset="UTF-8">
    <title>Flixhub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<div class="login-container welcome-wrapper">
    <div id="bgSlider" class="bg-slider"></div>

    <nav class="welcome-nav">
        <h2 class="logo-text">FlixHub</h2>
    </nav>

    <div class="profile-selection-container">
        <h1 class="welcome-title">Bem-vindo ao FlixHub</h1>
        <p class="welcome-phrase">Escolha como deseja acessar a plataforma</p>

        <div class="profile-options">
            <a href="{{ route('login') }}" class="profile-card">
                <div class="profile-icon icon-login">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <span class="profile-name">Fazer Login</span>
            </a>

            <a href="{{ route('register') }}" class="profile-card">
                <div class="profile-icon icon-register">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </div>
                <span class="profile-name">Criar Conta</span>
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
            slider.style.backgroundImage = `url('${imagens[index]}')`;
            index = (index + 1) % imagens.length;
        }

        mudarFundo();
        setInterval(mudarFundo, 5000);
    });
</script>