<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Filme - FlixHub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
            <ul class="nav-menu">
                <li><a href="/filmes" class="nav-link">Início</a></li>
                <li><a href="/filmes" class="nav-link ativo">Filmes</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h1>✏️ Editar Filme</h1>

            <form action="/filmes/{{ $filme->id }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') <div class="form-group">
        <label for="titulo">Título do Filme</label>
        <input type="text" id="titulo" name="titulo" class="form-control" value="{{ $filme->titulo }}" required>
    </div>

    <div class="form-group">
        <label for="imagem">Alterar Cartaz (Deixe vazio para manter o atual)</label>
        <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*">
    </div>

    <div class="form-group">
        <label for="descricao">Sinopse / Descrição</label>
        <textarea id="descricao" name="descricao" class="form-control" rows="4" required>{{ $filme->descricao }}</textarea>
    </div>

    <div class="form-group">
        <label for="nota">Nota</label>
        <input type="number" id="nota" name="nota" class="form-control" min="0" max="10" step="0.1" value="{{ $filme->nota }}" required>
    </div>

    <button type="submit" class="btn-salvar">Atualizar Filme</button>
</form>

            <a href="/filmes" class="btn-cancelar">Voltar para a Lista</a>
        </div>
    </div>

</body>
</html>