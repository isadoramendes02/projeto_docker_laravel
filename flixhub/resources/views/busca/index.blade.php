<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Minha Lista e Busca</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
        <ul class="nav-menu">
            <li><a href="{{ route('dashboard') }}" class="nav-link">Início</a></li>
            <li><a href="/filmes" class="nav-link">Filmes</a></li>
            <li><a href="/series" class="nav-link">Séries</a></li>
            <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
            <li><a href="{{ route('playlists.index') }}" class="nav-link">Trailer</a></li>
            <li><a href="/busca" class="nav-link ativo">Lista</a></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" id="logout-form-dash" style="display: none;">
                    @csrf
                </form>
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form-dash').submit();">
                    Sair
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    
    <div class="secao-busca">
        <h1>Pesquise por Título ou Categoria 🔍</h1>
        <form action="{{ route('busca.index') }}" method="GET" class="barra-busca-container">
            <input type="text" name="query" value="{{ $termo ?? '' }}" placeholder="Ex: Ação, Drama, Batman..." class="input-busca" required>
            <button type="submit" class="btn-busca">Buscar</button>
        </form>
    </div>

    @if(isset($termo) && $termo)
        <h2 class="titulo-secao">Resultados encontrados: {{ $resultados->count() }}</h2>

        @foreach($resultados as $item)
            <div class="resultado-card">
                <div class="resultado-imagem">
                    <img src="{{ $item->imagem ? asset('storage/' . $item->imagem) : asset('img/sem-foto.jpg') }}" class="resultado-cartaz" alt="{{ $item->titulo }}">
                </div>

                <div class="resultado-info">
                    <h2 class="resultado-titulo">{{ $item->titulo }}</h2>
                    <p><strong>🎬 Tipo:</strong> {{ ucfirst($item->tipo) }}</p>
                    <p><strong>🏷️ Gênero:</strong> {{ $item->genero }}</p>
                    <p><strong>⭐ Nota:</strong> {{ $item->nota }}</p>
                    <p><strong>❤️ Favorito:</strong> {{ $item->favorito ? 'Sim' : 'Não' }}</p>
                    
                    <h4 class="resultado-descricao-titulo">📝 Descrição</h4>
                    <p class="resultado-descricao">{{ $item->descricao }}</p>

                    <div class="btn-acoes-container">
                        <a href="{{ route('busca.create', ['titulo' => $item->titulo, 'tipo' => $item->tipo]) }}" class="btn-acao-lista btn-salvar-lista">
                            ➕ Adicionar à Lista
                        </a>
                        <a href="{{ route('busca.index') }}" class="btn-acao-lista btn-cancelar-lista">
                            ❌ Cancelar
                        </a>
                    </div>
                </div>

                @if($item->trailer)
                    <div class="resultado-trailer">
                        <h4>🎥 Trailer</h4>
                        <video class="video-trailer" controls>
                            <source src="{{ asset($item->trailer) }}" type="video/mp4">
                        </video>
                    </div>
                @endif
            </div>
        @endforeach
    @endif

    <div class="secao-lista">
        <h2>🍿 Minha Lista Completa</h2>
        
        @if($minhaLista->isEmpty())
            <p class="lista-vazia-texto">Sua lista está vazia. Pesquise acima para adicionar títulos!</p>
        @else
            @foreach($minhaLista as $linha)
                <div class="resultado-card card-salvo">
                    <div class="resultado-imagem">
                        <img src="{{ $linha->imagem ? asset('storage/' . $linha->imagem) : asset('img/sem-foto.jpg') }}" class="resultado-cartaz" alt="{{ $linha->titulo_obra }}">
                    </div>

                    <div class="resultado-info">
                        <h2 class="resultado-titulo">{{ $linha->titulo_obra }}</h2>
                        <p><strong>🎬 Tipo:</strong> {{ $linha->tipo ?? 'Não informado' }}</p>
                        <p><strong>🏷️ Gênero:</strong> {{ $linha->genero ?? '-' }}</p>
                        <p><strong>⭐ Nota:</strong> {{ $linha->nota ?? '-' }}</p>
                        <p><strong>❤️ Favorito:</strong> {{ $linha->favorito ? 'Sim' : 'Não' }}</p>
                        
                        <p>
                            <strong>📌 Status:</strong> 
                            @if($linha->status == 'ja-assistido') <span class="status-tag status-ja-assistido">Já assistido</span>
                            @elseif($linha->status == 'quero-assistir') <span class="status-tag status-quero-assistir">Quero assistir</span>
                            @elseif($linha->status == 'abandonei') <span class="status-tag status-abandonei">Abandonei</span>
                            @elseif($linha->status == 'falta-terminar') <span class="status-tag status-falta-terminar">Falta terminar</span>
                            @else <span class="status-tag">{{ $linha->status }}</span>
                            @endif
                        </p>

                        <h4 class="resultado-descricao-titulo">💬 Meu Comentário</h4>
                        <p class="resultado-comentario-texto">{{ $linha->comentario }}</p>

                        <div class="btn-acoes-container">
                            <a href="{{ route('busca.edit', $linha->id) }}" class="btn-acao-lista btn-salvar-lista" style="background-color: #2563eb !important;">
                                ✏️ Editar
                            </a>
                            <form action="{{ route('busca.destroy', $linha->id) }}" method="POST" class="form-deletar" style="flex: 1; display: flex;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-acao-lista btn-cancelar-lista" onclick="return confirm('Remover da lista?')" style="width: 100%;">
                                    🗑️ Deletar
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($linha->trailer)
                        <div class="resultado-trailer">
                            <h4>🎥 Trailer</h4>
                            <video class="video-trailer" controls>
                                <source src="{{ asset($linha->trailer) }}" type="video/mp4">
                            </video>
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>
</div>

</body>
</html>