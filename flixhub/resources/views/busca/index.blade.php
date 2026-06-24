<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Minha Lista e Busca</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { background-image: url("{{ asset('img/fundo4.jpg') }}") !important; background-color: #0b0f19; color: white; }
        .secao-busca { max-width: 600px; margin: 40px auto 20px auto; text-align: center; }
        .barra-busca-container { display: flex; gap: 10px; background: rgba(15, 23, 42, 0.8); padding: 15px; border-radius: 8px; border: 1px solid #1e40af; }
        .input-busca { flex: 1; background: #1e293b; border: 1px solid #334155; border-radius: 4px; color: white; padding: 12px; font-size: 1.1rem; outline: none; }
        .btn-busca { background: #1e40af; color: white; border: none; padding: 0 25px; border-radius: 4px; font-weight: bold; cursor: pointer; }
        .btn-busca:hover { background: #1e3a8a; }
        .secao-lista { max-width: 900px; margin: 40px auto; background: rgba(15, 23, 42, 0.9); padding: 20px; border-radius: 8px; border: 1px solid #1e3a8a; }
        .tabela-lista { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .tabela-lista th { background-color: #1e40af; color: white; padding: 10px; text-align: left; }
        .tabela-lista td { padding: 12px 10px; border-bottom: 1px solid #334155; }
        .btn-azul { background: #1e40af; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 0.85rem; display: inline-block; }
        .btn-azul:hover { background: #1e3a8a; }
        .btn-vermelho { background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; font-weight: bold; font-size: 0.85rem; }
        .btn-vermelho:hover { background: #dc2626; }
    </style>
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
    <div class="container">
        
        <div class="secao-busca">
            <h1 style="color: white; margin-bottom: 20px;">Pesquise por Titulo ou Categoria 🔍</h1>
            <form action="{{ route('busca.index') }}" method="GET" class="barra-busca-container">
                <input type="text" name="query" value="{{ $termo ?? '' }}" placeholder="Ex: Ação, Drama, Batman..." class="input-busca" required>
                <button type="submit" class="btn-busca">Buscar</button>
            </form>
        </div>

        @if(isset($termo) && $termo)

<h2 class="titulo-secao">Resultados encontrados:</h2>

@foreach($resultados as $item)
<div class="resultado-card">

    <div class="resultado-imagem">
        <img
            src="{{ $item->imagem ? asset('storage/' . $item->imagem) : asset('img/sem-foto.jpg') }}"
            class="resultado-cartaz"
        >
    </div>

    <div class="resultado-info">

        <h2 class="resultado-titulo">
            {{ $item->titulo }}
        </h2>

         <div class="resultado-trailer">

            <h4>🎥 Trailer</h4>

            <video class="video-trailer" controls>
                <source
                    src="{{ asset($item->trailer) }}"
                    type="video/mp4"
                >
            </video>

        </div>

        <p><strong>🎬 Tipo:</strong> {{ $item->tipo }}</p>

        <p><strong>🏷️ Gênero:</strong> {{ $item->genero }}</p>

        <p><strong>⭐ Nota:</strong> {{ $item->nota }}</p>

        <p>
            <strong>❤️ Favorito:</strong>
            {{ $item->favorito ? 'Sim' : 'Não' }}
        </p>

        <p class="resultado-descricao-titulo">
            <strong>📝 Descrição:</strong>
        </p>

        <p>
            {{ $item->descricao }}
        </p>

        @if($item->trailer)


        @endif

        <a
            href="{{ route('busca.create', ['titulo' => $item->titulo, 'tipo' => $item->tipo]) }}"
            class="btn-azul btn-adicionar-lista"
        >
            ➕ Adicionar à Minha Lista
        </a>

    </div>

</div>

        <a
            href="{{ route('busca.create', ['titulo' => $item->titulo, 'tipo' => $item->tipo]) }}"
            class="btn-azul"
            style="margin-top:20px;"
        >
            ➕ Adicionar à Minha Lista
        </a>

    </div>

</div>

@endforeach

@endif
        <div class="secao-lista">
            <h2 style="font-size: 1.3rem; border-bottom: 2px solid #1e40af; padding-bottom: 8px;">🍿 Minha Lista</h2>
            
            @if($minhaLista->isEmpty())
                <p style="color: #94a3b8; margin-top: 15px; text-align: center;">Sua lista está vazia. Pesquise acima para adicionar títulos!</p>
            @else
                <table class="tabela-lista">
                    <thead>
                        <tr>
                            <th>Filme / Série</th>
                            <th>Meu Comentário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($minhaLista as $linha)
                            <tr>
                                <td style="font-weight: bold; color: #3b82f6;">{{ $linha->titulo_obra }}</td>
                                <td>{{ $linha->comentario }}</td>
                                <td>
                                    <a href="{{ route('busca.edit', $linha->id) }}" class="btn-azul">Editar</a>
                                    
                                    <form action="{{ route('busca.destroy', $linha->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-vermelho" onclick="return confirm('Remover da lista?')">Deletar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</body>
</html>