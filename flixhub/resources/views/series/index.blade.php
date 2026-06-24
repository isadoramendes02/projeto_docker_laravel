<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Minhas Séries</title>
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
                <li><a href="/series" class="nav-link ativo">Séries</a></li>
                <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
                <li><a href="{{ route('playlists.index') }}" class="nav-link">Trailer</a></li>
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

        <div class="alerta-container">
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
        
        <header class="cabecalho-secao">
            <h1 class="titulo-secao">Series Cadastradas</h1>
            <a href="/series/create" class="btn-adicionar">+ Nova Série</a>
        </header>

        <div class="grade-filmes">
            @forelse($series as $serie)
                <div class="card-filme">
                    
                    @php
                        $favoritoSerie = \App\Models\Favorito::where('favoritavel_id', $serie->id)
                            ->where('favoritavel_type', \App\Models\Serie::class)
                            ->first();
                    @endphp

                    @if($favoritoSerie)
                        <form action="{{ route('favoritos.destroy', $favoritoSerie->id) }}" method="POST" class="form-favorito">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Remover dos Favoritos" class="btn-favorito btn-favorito--ativo"
                                onmouseover="this.style.transform='scale(1.2)'"
                                onmouseout="this.style.transform='scale(1)'">
                                ⭐
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favoritos.store') }}" method="POST" class="form-favorito">
                            @csrf
                            <input type="hidden" name="id" value="{{ $serie->id }}">
                            <input type="hidden" name="tipo" value="Serie">
                            <button type="submit" title="Adicionar aos Favoritos" class="btn-favorito btn-favorito--inativo"
                                onmouseover="this.style.transform='scale(1.2)'"
                                onmouseout="this.style.transform='scale(1)'">
                                ☆
                            </button>
                        </form>
                    @endif

                    @if($serie->imagem)
                        <img src="{{ asset('storage/' . $serie->imagem) }}" alt="{{ $serie->titulo }}" class="filme-cartaz">
                    @else
                        <img src="{{ asset('img/sem-foto.jpg') }}" alt="Sem Cartaz" class="filme-cartaz">
                    @endif

                    <div>
                        <div class="card-topo">
                            <h3 class="filme-titulo">{{ $serie->titulo }}</h3>
                            <span class="filme-nota">⭐ {{ $serie->nota == floor($serie->nota) ? floor($serie->nota) : $serie->nota }}/5</span>
                        </div>
                        
                        <div class="card-genero-wrapper">
                            <span class="filme-genero">
                                🏷️ {{ $serie->genero ?? 'Outro' }}
                            </span>
                        </div>
                        
                        <p class="filme-descricao">{{ $serie->descricao ?? 'Nenhuma descrição informada.' }}</p>
                    </div>

                    <div class="card-acoes">
                        <a href="/series/{{ $serie->id }}/edit" class="btn-editar">✏️ Editar</a>
                        <form action="/series/{{ $serie->id }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta série?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-excluir">🗑️ Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="lista-vazia">
                    <p>Sua lista de séries está vazia.</p>
                    <p class="lista-vazia__link"><a href="/series/create">Cadastre a primeira série agora →</a></p>
                </div>
            @endforelse
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
        if (alertaContainer && alertaContainer.children.length > 0) {
            setTimeout(function() {
                alertaContainer.style.transition = "opacity 0.5s ease";
                alertaContainer.style.opacity = "0";
                setTimeout(function() {
                    alertaContainer.remove();
                }, 500);
            }, 4000);
        }
    });
</script>
</body>
</html>