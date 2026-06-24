<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Adicionar Comentário</title>
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
                <li><a href="{{ route('playlists.index') }}" class="nav-link">Trailer</a></li>
                <li><a href="/busca" class="nav-link ativo">Lista</a></li>
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
            <h1>Adicionar a Minha Lista</h1>
            
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
                
                <div class="form-group">
                    <label for="titulo_obra">Título do Filme/Série</label>
                    <input type="text" id="titulo_obra" name="titulo_obra" value="{{ request('titulo') }}" class="form-control" readonly>
                </div>

                <div class="form-group">
                    <label for="status">Escolher status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="" disabled selected>Selecione uma opção</option>
                        <option value="ja-assistido">Já assistido</option>
                        <option value="quero-assistir">Quero assistir</option>
                        <option value="abandonei">Abandonei</option>
                        <option value="falta-terminar">Falta terminar</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="comentario">Escreva seu comentário/crítica</label>
                    <textarea id="comentario" name="comentario" class="form-control" rows="4" placeholder="O que você achou dessa produção?" required></textarea>
                </div>

                <button type="submit" class="btn-salvar">Salvar na Lista</button>
                <a href="{{ route('busca.index') }}" class="btn-retornar-lista">Cancelar</a>
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
    });
</script>
</body>
</html>