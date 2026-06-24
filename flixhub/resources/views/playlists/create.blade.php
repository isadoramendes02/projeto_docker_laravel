<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Filme</title>
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
                    <form method="POST" action="{{ route('logout') }}" id="logout-form-dash" style="display:none;">
                        @csrf
                    </form>

                    <a href="{{ route('logout') }}"
                       class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form-dash').submit();">
                        Sair
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">

            <h1>Adicionar à Lista</h1>

            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('playlists.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nome">Nome do Filme / Série</label>

                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        class="form-control"
                        value="{{ old('nome') }}"
                        placeholder="Ex: Interestelar"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="tipo">Tipo de Conteúdo</label>

                    <select id="tipo" name="tipo" class="form-control" required>
                        <option value="Filme" {{ old('tipo') == 'Filme' ? 'selected' : '' }}>
                            Filme
                        </option>

                        <option value="Série" {{ old('tipo') == 'Série' ? 'selected' : '' }}>
                            Série
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="trailer">Upload do Trailer</label>

                    <input
                        type="file"
                        id="trailer"
                        name="trailer"
                        class="form-control"
                        accept="video/mp4,video/ogg,video/quicktime"
                        required
                    >

                    <div id="preview-container" style="display:none; margin-top:15px;">
                        <video
                            id="video-preview"
                            controls
                            style="
                                width:100%;
                                max-height:300px;
                                border-radius:10px;
                                background:#000;
                            ">
                        </video>
                    </div>
                </div>

                <div class="form-group">
                    <label for="descricao">Comentário / Nota</label>

                    <textarea
                        id="descricao"
                        name="descricao"
                        class="form-control"
                        rows="4"
                        placeholder="Ex: Assistir no próximo final de semana."
                    >{{ old('descricao') }}</textarea>
                </div>

                <button type="submit" class="btn-salvar">
                    Salvar na Playlist
                </button>

                <a href="{{ route('playlists.index') }}" class="btn-cancelar">
                    Voltar para a Lista
                </a>

            </form>

        </div>
    </div>

    <script>
        document.getElementById('trailer').addEventListener('change', function(event) {

            const file = event.target.files[0];

            if (!file) return;

            const video = document.getElementById('video-preview');

            video.src = URL.createObjectURL(file);

            document.getElementById('preview-container').style.display = 'block';
        });
    </script>

</body>
</html>