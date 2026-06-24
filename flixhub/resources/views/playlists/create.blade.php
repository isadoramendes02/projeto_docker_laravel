<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Adicionar à Playlist</title>
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
                <li><a href="/series" class="nav-link">Séries</a></li>
                <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
                <li><a href="{{ route('playlists.index') }}" class="nav-link ativo">Trailer</a></li>
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

            @if ($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>⚠️ {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="form-container">
            <h1>Adicionar</h1>

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
                        <option value="Filme" {{ old('tipo') == 'Filme' ? 'selected' : '' }}>Filme</option>
                        <option value="Série" {{ old('tipo') == 'Série' ? 'selected' : '' }}>Série</option>
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

                    <div id="preview-container" class="preview-video-container">
                        <video id="video-preview" controls class="video-preview-elemento"></video>
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

                <button type="submit" class="btn-salvar">Salvar trailer</button>
                <a href="{{ route('playlists.index') }}" class="btn-retornar-lista">Cancelar</a>
            </form>
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

        const trailerInput = document.getElementById('trailer');
        if (trailerInput) {
            trailerInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (!file) return;

                const video = document.getElementById('video-preview');
                video.src = URL.createObjectURL(file);
                document.getElementById('preview-container').style.display = 'block';
            });
        }
    });
</script>
</body>
</html>