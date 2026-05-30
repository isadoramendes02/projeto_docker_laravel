<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Série - FlixHub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
            <ul class="nav-menu">
                <li><a href="/series" class="nav-link">Início</a></li>
                <li><a href="/filmes" class="nav-link">Filmes</a></li>
                <li><a href="/series" class="nav-link ativo">Séries</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h1>📺 Adicionar Série</h1>

            <form action="/series" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="titulo">Título da Série</label>
                    <input type="text" id="titulo" name="titulo" class="form-control" placeholder="Ex: Stranger Things" required>
                </div>

                <div class="form-group">
                    <label for="imagem">Cartaz da Série (Imagem)</label>
                    <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="descricao">Sinopse / Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="4" placeholder="Sinopse da série..." required></textarea>
                </div>

                <div class="form-group">
                <label for="nota">Nota (0 a 5)</label>
                <input type="number" id="nota" name="nota" class="form-control" min="0" max="5" step="0.1" placeholder="Ex: 4.5" required>
                </div>

                <button type="submit" class="btn-salvar">Salvar Série</button>
            </form>

            <a href="/series" class="btn-cancelar">Voltar para a Lista</a>
        </div>
    </div>

</body>
</html>