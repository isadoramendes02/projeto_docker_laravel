<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Meus Favoritos</title>
    <link class="css-link" rel="stylesheet" href="{{ asset('css/style.css') }}">
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
        
        <header class="cabecalho-secao">
            <h1 class="titulo-secao">Meus Favoritos</h1>
        </header>

        <div class="grade-filmes">
            @forelse($favoritos as $favorito)
                @php 
                    $item = $favorito->favoritavel; 
                    $isFilme = $favorito->favoritavel_type === \App\Models\Filme::class;
                    $tipoTexto = $isFilme ? 'Filme' : 'Série';
                @endphp

                @if($item)
                <div class="card-filme">

                    @if($item->imagem)
                        <img src="{{ asset('storage/' . $item->imagem) }}" alt="{{ $item->titulo }}" class="filme-cartaz">
                    @else
                        <img src="{{ asset('img/sem-foto.jpg') }}" alt="Sem Cartaz" class="filme-cartaz">
                    @endif

                    <div>
                        <div class="card-topo">
                            <h3 class="filme-titulo">{{ $item->titulo }}</h3>
                            <span class="filme-nota">⭐ {{ $item->nota }}/5</span>
                        </div>
                        
                        <div class="wrapper-tags-favoritos">
                            <span class="tag-tipo">
                                {{ $tipoTexto }}
                            </span>
                            <span class="filme-genero">
                                🏷️ {{ $item->genero ?? 'Outro' }}
                            </span>
                        </div>
                        
                        <p class="filme-descricao">
                            {{ $item->descricao ?? 'Nenhuma descrição informada.' }}
                        </p>
                    </div>

                    @if(!$favorito->comentario)
                        <div class="botoes-acoes botoes-acoes--unico">
                            <a href="{{ route('favoritos.edit', $favorito->id) }}" class="btn-editar">
                                ➕ Adicionar Nota
                            </a>
                        </div>
                    @else
                        <div class="balao-comentario">
                            <span class="balao-comentario__titulo">📝 Minha Nota:</span>
                            <p class="balao-comentario__texto">
                                "{{ $favorito->comentario }}"
                            </p>
                        </div>

                        <div class="botoes-acoes">
                            <a href="{{ route('favoritos.edit', $favorito->id) }}" class="btn-editar">
                                ✏️ Editar Nota
                            </a>

                            <form action="{{ route('favoritos.destroy', $favorito->id) }}" method="POST" onsubmit="return confirm('Deseja mesmo remover este título dos seus favoritos?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-excluir">
                                    🗑️ Remover
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
                @endif
            @empty
                <div class="lista-vazia">
                    <p>Você ainda não favoritou nenhum filme ou série.</p>
                    <p class="lista-vazia__link"><a href="/filmes">Explore o catálogo aqui →</a></p>
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
        if (alertaContainer) {
            setTimeout(function() {
                alertaContainer.style.display = "none";
            }, 4000);
        }
    });
</script>
</body>
</html>