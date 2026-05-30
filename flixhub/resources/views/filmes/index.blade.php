<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Meus Filmes</title>
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            background-image: url("{{ asset('img/fundo4.jpg') }}") !important;
        }
    </style>
</head>
<body>

    <nav class="navbar">
    <div class="nav-container">
        <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
        <ul class="nav-menu">
            <li><a href="/filmes" class="nav-link">Início</a></li>
            <li><a href="/filmes" class="nav-link ativo">Filmes</a></li>
            <li><a href="/series" class="nav-link">Séries</a></li>
        </ul>
    </div>
</nav>

    <div class="container">
        
        <header class="cabecalho-secao">
            <h1 class="titulo-secao">Filmes Cadastrados</h1>
            <a href="/filmes/create" class="btn-adicionar">+ Novo Filme</a>
        </header>

        <div class="grade-filmes">
            @forelse($filmes as $filme)
                <div class="card-filme">
                    @if($filme->imagem)
                        <img src="{{ asset('storage/' . $filme->imagem) }}" alt="{{ $filme->titulo }}" class="filme-cartaz">
                    @else
                        <img src="{{ asset('img/sem-foto.jpg') }}" alt="Sem Cartaz" class="filme-cartaz">
                    @endif

                    <div>
                        <div class="card-topo">
                            <h3 class="filme-titulo">{{ $filme->titulo }}</h3>
                            <span class="filme-nota">⭐ {{ $filme->nota }}/5</span>
                        </div>
                        
                        <p class="filme-descricao">
                            {{ $filme->descricao ?? 'Nenhuma descrição informada.' }}
                        </p>
                    </div>

                    <div class="card-acoes">
                        <a href="/filmes/{{ $filme->id }}/edit" class="btn-editar">✏️ Editar</a>

                        <form action="/filmes/{{ $filme->id }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este filme?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-excluir">🗑️ Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="lista-vazia">
                    <p>Sua lista de filmes está vazia.</p>
                    <p style="margin-top: 0.5rem;"><a href="/filmes/create">Cadastre o primeiro filme agora →</a></p>
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>