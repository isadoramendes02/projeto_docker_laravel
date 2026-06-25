<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Editar Nota</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<div class="dashboard-wrapper">
    <div id="bgSlider" class="bg-slider"></div>

    <nav class="navbar">
        <div class="nav-container">
            <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
            <ul class="nav-menu">
                <li><a href="{{ route('dashboard') }}" class="nav-link">Início</a></li>
                <li><a href="/filmes" class="nav-link">Filmes</a></li>
                <li><a href="/series" class="nav-link">Séries</a></li>
                <li><a href="/favoritos" class="nav-link ativo">Favoritos</a></li>
                <li><a href="/busca" class="nav-link">Lista</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-dash" class="form-hidden">
                        @csrf
                    </form>
                    <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form-dash').submit();">
                        Sair
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container conteudo-pagina-fixa">

        <div class="alerta-container" id="alertaContainer">
            @if(session('success'))
                <div class="alerta alerta-sucesso">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alerta alerta-erro">
                    ❌ {{ session('error') }}
                </div>
            @endif
        </div>

        <div class="card-formulario">
            <h2 class="titulo-formulario-nota">Minha Nota Pessoal ✏️</h2>
            <p class="subtitulo-item-nota">
                {{ $favorito->favoritavel->titulo ?? 'Item' }}
            </p>
            
            <form action="{{ route('favoritos.update', $favorito->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grupo">
                    <label for="comentario">Sua anotação ou crítica sobre este título:</label>
                    <textarea 
                        id="comentario" 
                        name="comentario" 
                        rows="4" 
                        class="form-control" 
                        placeholder="Escreva seus comentários, lembretes ou críticas..."
                    >{{ $favorito->comentario }}</textarea>
                </div>

                <div class="btn-container-nota">
                    <button type="submit" class="btn-salvar-nota">
                        Salvar Nota
                    </button>
                    
                    <button type="button" class="btn-cancelar-nota" onclick="window.location.href='/favoritos'">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const imagens = [
            "/img/imagem1.jpg", "/img/imagem2.jpg", "/img/imagem3.jpg",
            "/img/imagem8.jpg", "/img/imagem9.jpg", "/img/imagem10.jpg",
            "/img/img5.jpg",    "/img/img6.jpg",    "/img/img7.jpg",
            "/img/img8.jpg",    "/img/imagem4.jpg", "/img/imagem5.jpg",
            "/img/img11.jpg",   "/img/img12.jpg",   "/img/img13.jpg",
            "/img/imagem6.jpg", "/img/img15.jpg",   "/img/img16.jpg",
            "/img/imagem7.jpg"
        ];

        const slider = document.getElementById("bgSlider");
        let index = 0;

        function mudarFundo() {
            if (slider) {
                slider.style.backgroundImage = `url('${imagens[index]}')`;
                index = (index + 1) % imagens.length;
            }
        }

        mudarFundo();
        setInterval(mudarFundo, 5000);

        const alertaContainer = document.getElementById("alertaContainer");
        if (alertaContainer) {
            setTimeout(function() {
                alertaContainer.style.display = "none";
            }, 4000);
        }
    });
</script>
</body>
</html>