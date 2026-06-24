<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Adicionar Comentário</title>
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
    <div class="formulario-container">
        <h2>Adicionar à Minha Lista</h2>
        
        @if($obra)
            <div class="card-detalhado">
                <img src="{{ $obra->imagem ? asset('storage/'.$obra->imagem) : asset('img/sem-foto.jpg') }}" alt="{{ $obra->titulo }}">

                <div class="card-info">
                    <h2>{{ $obra->titulo }}</h2>
                    <p><strong>🎬 Tipo:</strong> {{ $obra->tipo }}</p>
                    <p><strong>🏷️ Gênero:</strong> {{ $obra->genero }}</p>
                    <p><strong>⭐ Nota:</strong> {{ $obra->nota }}</p>
                    <p><strong>❤️ Favorito:</strong> {{ $obra->favorito ? 'Sim' : 'Não' }}</p>

                    <div class="card-descricao">
                        <strong>📝 Descrição:</strong>
                        <p>{{ $obra->descricao }}</p>
                    </div>

                    @if($playlist)
                        <div class="trailer-box">
                            <h4>🎥 Trailer</h4>
                            <video class="trailer-video" controls>
                                <source src="{{ asset($playlist->trailer) }}" type="video/mp4">
                            </video>
                        </div>
                    @endif
                </div>
            </div>
        @endif
            
        <form action="{{ route('busca.store') }}" method="POST">
            @csrf
            
            <div class="campo-grupo">
                <label>Título do Filme/Série:</label>
                <input type="text" name="titulo_obra" value="{{ request('titulo') }}" class="input-form" readonly>
            </div>

            <div class="campo-grupo">
                <label for="status">Escolher status</label>
                <select name="status" id="status" class="select-form" required>
                    <option value="" disabled selected>Selecione uma opção</option>
                    <option value="ja-assistido">Já assistido</option>
                    <option value="quero-assistir">Quero assistir</option>
                    <option value="abandonei">Abandonei</option>
                    <option value="falta-terminar">Falta terminar</option>
                </select>
            </div>

            <div class="campo-grupo">
                <label>Escreva seu comentário/crítica:</label>
                <textarea name="comentario" class="textarea-form" placeholder="O que você achou dessa produção?" required></textarea>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn-form btn-salvar">
                    Salvar na Lista
                </button>
                <a href="{{ route('busca.index') }}" class="btn-form btn-cancelar">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>