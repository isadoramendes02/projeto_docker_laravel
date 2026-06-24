<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Editar Comentário</title>
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
        </ul>
    </div>
</nav>

<div class="container">

    <div class="formulario-container">

        <h2>Editar Registro</h2>

        @if($obra)
            <div class="bloco-obra">
                <img src="{{ $obra->imagem ? asset('storage/'.$obra->imagem) : asset('img/sem-foto.jpg') }}" class="capa-obra">

                <div class="info-obra">
                    <h2>{{ $obra->titulo }}</h2>
                    <p><strong>🎬 Tipo:</strong> {{ $obra->tipo }}</p>
                    <p><strong>🏷️ Gênero:</strong> {{ $obra->genero }}</p>
                    <p><strong>⭐ Nota:</strong> {{ $obra->nota }}</p>
                    <p><strong>📝 Descrição:</strong> {{ $obra->descricao }}</p>

                    @if($playlist)
                        <h3>🎥 Trailer</h3>
                        <video class="video-preview-edit" controls>
                            <source src="{{ asset($playlist->trailer) }}" type="video/mp4">
                        </video>
                    @endif
                </div>
            </div>
        @endif

        <form action="{{ route('busca.update', $busca->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="campo-grupo">
                <label>Filme / Série</label>
                <input type="text" value="{{ $busca->titulo_obra }}" class="input-form" readonly>
            </div>

            <div class="campo-grupo">
                <label for="status">Modificar status</label>
                <select name="status" id="status" class="select-form" required>
                    <option value="ja-assistido" {{ $busca->status == 'ja-assistido' ? 'selected' : '' }}>Já assistido</option>
                    <option value="quero-assistir" {{ $busca->status == 'quero-assistir' ? 'selected' : '' }}>Quero assistir</option>
                    <option value="abandonei" {{ $busca->status == 'abandonei' ? 'selected' : '' }}>Abandonei</option>
                    <option value="falta-terminar" {{ $busca->status == 'falta-terminar' ? 'selected' : '' }}>Falta terminar</option>
                </select>
            </div>

            <div class="campo-grupo">
                <label>Modificar comentário</label>
                <textarea name="comentario" class="textarea-form" required>{{ $busca->comentario }}</textarea>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn-form btn-salvar">Atualizar</button>
                <a href="{{ route('busca.index') }}" class="btn-form btn-cancelar">Cancelar</a>
            </div>

        </form>

    </div>
</div>

</body>
</html>