<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Série - FlixHub</title>
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
                <li><a href="/series" class="nav-link ativo">Séries</a></li>
                <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
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
        <div class="form-container">
            <h1>✏️ Editar Série</h1>

            <form action="/series/{{ $serie->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="titulo">Título da Série</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" value="{{ $serie->titulo }}" required>
                </div>

                <div class="form-group">
                    <label for="genero">Gênero</label>
                    <select id="genero" name="genero" class="form-control" required>
                        <option value="Ação"             {{ $serie->genero == 'Ação'             ? 'selected' : '' }}>Ação</option>
                        <option value="Comédia"          {{ $serie->genero == 'Comédia'          ? 'selected' : '' }}>Comédia</option>
                        <option value="Drama"            {{ $serie->genero == 'Drama'            ? 'selected' : '' }}>Drama</option>
                        <option value="Ficção Científica"{{ $serie->genero == 'Ficção Científica'? 'selected' : '' }}>Ficção Científica</option>
                        <option value="Terror"           {{ $serie->genero == 'Terror'           ? 'selected' : '' }}>Terror</option>
                        <option value="Romance"          {{ $serie->genero == 'Romance'          ? 'selected' : '' }}>Romance</option>
                        <option value="Documentário"     {{ $serie->genero == 'Documentário'     ? 'selected' : '' }}>Documentário</option>
                        <option value="Animação"         {{ $serie->genero == 'Animação'         ? 'selected' : '' }}>Animação</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="imagem">Alterar Cartaz (Deixe vazio para manter o atual)</label>
                    <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="descricao">Sinopse / Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="4" required>{{ $serie->descricao }}</textarea>
                </div>

                <div class="form-group">
                    <label for="nota">Nota (0 a 5)</label>
                    <input type="number" id="nota" name="nota" class="form-control" min="0" max="5" step="0.1" value="{{ number_format($serie->nota, 1, '.', '') }}" required>
                </div>

                <button type="submit" class="btn-salvar">Atualizar Série</button>
            </form>

            <a href="/series" class="btn-retornar-lista">Voltar para a Lista</a>
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
    });
</script>

</body>
</html>