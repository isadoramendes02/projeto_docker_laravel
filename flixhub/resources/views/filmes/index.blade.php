<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Meus Filmes</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<div class="dashboard-wrapper">
    <div id="bgSlider" class="bg-slider"></div>

    <nav class="navbar">
        <div class="nav-container">
            <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
            <ul class="nav-menu">
                <li><a href="/dashboard" class="nav-link">Início</a></li>
                <li><a href="/filmes" class="nav-link ativo">Filmes</a></li>
                <li><a href="/series" class="nav-link">Séries</a></li>
                <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
                <li><a href="/busca" class="nav-link">Lista</a></li>
                <li>
                    <form method="POST" action="/'logout" id="logout-form-dash" class="form-hidden">
                        @csrf
                    </form>
                    <a href="/logout" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form-dash').submit();">
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
            <h1 class="titulo-secao">Filmes Cadastrados</h1>
            <a href="/filmes/create" class="btn-adicionar">+ Novo Filme</a>
        </header>

        <div class="grade-filmes">
            @forelse($filmes as $filme)
                <div class="card-filme">
                    
                    @php
                        $favoritoFilme = \App\Models\Favorito::where('favoritavel_id', $filme->id)
                            ->where('favoritavel_type', \App\Models\Filme::class)
                            ->first();
                    @endphp

                    @if($favoritoFilme)
                        <form action="{{ route('favoritos.destroy', $favoritoFilme->id) }}" method="POST" class="form-favorito">
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
                            <input type="hidden" name="id" value="{{ $filme->id }}">
                            <input type="hidden" name="tipo" value="Filme">
                            <button type="submit" title="Adicionar aos Favoritos" class="btn-favorito btn-favorito--inativo"
                                onmouseover="this.style.transform='scale(1.2)'"
                                onmouseout="this.style.transform='scale(1)'">
                                ☆
                            </button>
                        </form>
                    @endif

                    @if($filme->imagem)
                        <img src="{{ asset('storage/' . $filme->imagem) }}" alt="{{ $filme->titulo }}" class="filme-cartaz">
                    @else
                        <img src="{{ asset('img/sem-foto.jpg') }}" alt="Sem Cartaz" class="filme-cartaz">
                    @endif

                    <div>
                        <div class="card-topo">
                            <h3 class="filme-titulo">{{ $filme->titulo }}</h3>
                            <span class="filme-nota">⭐ {{ $filme->nota }}/5</span>
                        </div>
                        
                        <div class="card-genero-wrapper">
                            <span class="filme-genero">
                                🏷️ {{ $filme->genero ?? 'Outro' }}
                            </span>
                        </div>
                        
                        <p class="filme-descricao">{{ $filme->descricao ?? 'Nenhuma descrição informada.' }}</p>
                    </div>

                    <div class="card-acoes">
                        <a href="/filmes/{{ $filme->id }}/edit" class="btn-editar">✏️ Editar</a>
                        <form action="/filmes/{{ $filme->id }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este filme?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-excluir">🗑️ Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="lista-vazia">
                    <p>Sua lista de filmes está vazia.</p>
                    <p class="lista-vazia__link"><a href="/filmes/create">Cadastre o primeiro filme agora →</a></p>
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