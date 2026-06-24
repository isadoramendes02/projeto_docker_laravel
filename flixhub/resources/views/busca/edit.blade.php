<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Editar Registro</title>
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

<div class="container container-centralizado">
    
    <div class="secao-formulario">
        <h2 class="titulo-formulario">✏️ Editar Item da Minha Lista</h2>

        <form action="{{ route('busca.update', $busca->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="campo-grupo">
                <label>Título do Filme/Série:</label>
                <input type="text" name="titulo_obra" value="{{ $busca->titulo_obra }}" class="input-form" readonly>
            </div>

            <div class="campo-grupo">
                <label for="status">Status Atual:</label>
                <select name="status" id="status" class="select-form" required>
                    <option value="ja-assistido" {{ $busca->status == 'ja-assistido' ? 'selected' : '' }}>Já assistido</option>
                    <option value="quero-assistir" {{ $busca->status == 'quero-assistir' ? 'selected' : '' }}>Quero assistir</option>
                    <option value="abandonei" {{ $busca->status == 'abandonei' ? 'selected' : '' }}>Abandonei</option>
                    <option value="falta-terminar" {{ $busca->status == 'falta-terminar' ? 'selected' : '' }}>Falta terminar</option>
                </select>
            </div>

            <div class="campo-grupo">
                <label for="comentario">Meu Comentário/Crítica:</label>
                <textarea name="comentario" id="comentario" class="textarea-form" required>{{ $busca->comentario }}</textarea>
            </div>

            <div class="btn-container-form">
                <button type="submit" class="btn-form btn-salvar">
                    💾 Atualizar Registro
                </button>
                <a href="{{ route('busca.index') }}" class="btn-form btn-cancelar">
                    ❌ Cancelar
                </a>
            </div>
        </form>
    </div>

</div>

</body>
</html>