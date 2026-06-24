<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Filme</title>
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
            
            <li><a href="{{ route('playlists.index') }}" class="nav-link ativo">Trailer</a></li>
            
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
            <h1>Editar Informações</h1>

            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('playlists.update', $playlist->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nome">Nome do Filme / Série</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $playlist->nome) }}" required>
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo de Conteúdo</label>
                    <select id="tipo" name="tipo" class="form-control" required>
                        <option value="Filme" {{ old('tipo', $playlist->tipo) == 'Filme' ? 'selected' : '' }}>Filme</option>
                        <option value="Série" {{ old('tipo', $playlist->tipo) == 'Série' ? 'selected' : '' }}>Série</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="trailer">Substituir Vídeo do Trailer</label>
                    <input type="file" id="trailer" name="trailer" class="form-control" accept="video/*">
                    @if($playlist->trailer)
                        <small style="color: var(--texto-escuro); margin-top: 5px; display: block;">
                            Já existe um vídeo salvo. Suba outro arquivo apenas se quiser trocá-lo.
                        </small>
                    @endif
                </div>

                <div class="form-group">
                    <label for="descricao">Comentário / Nota</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="4">{{ old('descricao', $playlist->descricao) }}</textarea>
                </div>

                <button type="submit" class="btn-salvar">Atualizar Informações</button>
                <a href="{{ route('playlists.index') }}" class="btn-cancelar">Cancelar Alterações</a>
            </form>
        </div>
    </div>

</body>
</html>