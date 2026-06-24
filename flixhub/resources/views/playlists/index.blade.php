<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Minhas Playlists de Filmes</title>
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
                <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
                <li><a href="{{ route('playlists.index') }}" class="nav-link ativo">Trailer</a></li>
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

        <div class="cabecalho-secao">
            <h1 class="titulo-secao">Para Assistir Mais Tarde</h1>
            <a href="{{ route('playlists.create') }}" class="btn-adicionar">+ Adicionar</a>
        </div>

        @if($playlists->isEmpty())
            <div class="lista-vazia">
                <p>Você ainda não adicionou nenhum conteúdo.</p>
                <p class="lista-vazia__link">
                    <a href="{{ route('playlists.create') }}">
                        Clique aqui para começar a sua lista!
                    </a>
                </p>
            </div>
        @else
            <div class="grade-filmes">
                @foreach($playlists as $playlist)
                    <div class="card-filme">
                        
                        @if($playlist->trailer)
                            <div class="media-container">
                                <video class="card-video" controls preload="metadata">
                                    <source src="{{ asset($playlist->trailer) }}" type="video/mp4">
                                    Seu navegador não suporta vídeo.
                                </video>
                            </div>
                        @endif

                        <div class="card-topo">
                            <h2 class="filme-titulo">{{ $playlist->nome }}</h2>
                            <span class="filme-nota">{{ $playlist->tipo }}</span>
                        </div>

                        <p class="filme-descricao">
                            {{ $playlist->descricao ?? 'Sem comentários adicionados.' }}
                        </p>

                        <div class="card-acoes">
                            <a href="{{ route('playlists.edit', $playlist->id) }}" class="btn-editar">
                                ✏️ Editar
                            </a>

                            <form action="{{ route('playlists.destroy', $playlist->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja remover este item da lista?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-excluir">
                                    🗑️ Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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