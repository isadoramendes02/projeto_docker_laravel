<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Playlists de Filmes</title>
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

    <div class="cabecalho-secao">
        <h1 class="titulo-secao">Para Assistir Mais Tarde</h1>
        <a href="{{ route('playlists.create') }}" class="btn-adicionar">+ Adicionar</a>
    </div>

    @if($playlists->isEmpty())

        <div class="lista-vazia">
            <p>Você ainda não adicionou nenhum conteúdo.</p>
            <p>
                <a href="{{ route('playlists.create') }}">
                    Clique aqui para começar a sua lista!
                </a>
            </p>
        </div>

    @else

        <div class="grade-filmes">

            @foreach($playlists as $playlist)

                <div class="card-filme">

                    @if($playlist->trailer)
                        <div class="media-container">
                            <video class="card-video" controls preload="metadata">
                                <source src="{{ asset($playlist->trailer) }}" type="video/mp4">
                                Seu navegador não suporta vídeo.
                            </video>
                        </div>
                    @endif

                    <div class="card-topo">
                        <h2 class="filme-titulo">{{ $playlist->nome }}</h2>
                        <span class="filme-nota">{{ $playlist->tipo }}</span>
                    </div>

                    <p class="filme-descricao">
                        {{ $playlist->descricao ?? 'Sem comentários adicionados.' }}
                    </p>

                    <div class="card-acoes">

                        <a href="{{ route('playlists.edit', $playlist->id) }}"
                           class="btn-editar">
                            Editar
                        </a>

                        <form action="{{ route('playlists.destroy', $playlist->id) }}"
                              method="POST"
                              onsubmit="return confirm('Tem certeza que deseja remover este item da lista?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-excluir">
                                Excluir
                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

</body>
</html>