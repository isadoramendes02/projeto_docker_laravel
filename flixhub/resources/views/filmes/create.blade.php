<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Filme - FlixHub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
    <div class="nav-container">
        <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
        <ul class="nav-menu">
            <li><a href="{{ route('dashboard') }}" class="nav-link">Início</a></li>
            <li><a href="/filmes" class="nav-link ativo">Filmes</a></li>
            <li><a href="/series" class="nav-link">Séries</a></li>
            <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
            
            <li><a href="{{ route('playlists.index') }}" class="nav-link">Trailer</a></li>
            
            <li><a href="/busca" class="nav-link">Lista</a></li>
            
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
        <div class="form-container">
            <h1>🎬 Adicionar Filme</h1>

            <form action="/filmes" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="titulo">Título do Filme</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ex: Batman" required>
                </div>

                <div class="form-group">
                <label for="genero">Gênero</label>
                <select id="genero" name="genero" class="form-control" required>
                    <option value="" disabled selected>Selecione um gênero</option>
                    <option value="Ação">Ação</option>
                    <option value="Comédia">Comédia</option>
                    <option value="Drama">Drama</option>
                    <option value="Ficção Científica">Ficção Científica</option>
                    <option value="Terror">Terror</option>
                    <option value="Romance">Romance</option>
                    <option value="Documentário">Documentário</option>
                    <option value="Animação">Animação</option>
                </select>
                </div>

                <div class="form-group">
                    <label for="imagem">Cartaz do Filme (Imagem)</label>
                    <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="descricao">Sinopse / Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="4" placeholder="Sinopse..." required></textarea>
                </div>

                <div class="form-group">
                    <label for="nota">Nota (0 a 5)</label>
                    <input type="number" id="nota" name="nota" class="form-control" min="0" max="5" step="0.1" placeholder="Ex: 4.5" required>
                </div>

                <button type="submit" class="btn-salvar">Salvar Filme</button>
            </form>

            <a href="/filmes" class="btn-cancelar">Voltar para a Lista</a>
        </div>
    </div>

</body>
</html>