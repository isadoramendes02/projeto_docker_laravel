<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Meus Favoritos</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background-image: url("{{ asset('img/fundo4.jpg') }}") !important;
        }
        .card-filme {
            position: relative;
        }
        .balao-comentario {
            margin-top: 1rem; 
            background: rgba(255,255,255,0.05); 
            padding: 10px; 
            border-radius: 4px; 
            border-left: 3px solid #1e3a8a; 
        }
        .botoes-acoes {
            display: flex;
            gap: 8px;
            margin-top: auto;
            padding-top: 1rem;
            width: 100%;
        }
        .botoes-acoes form {
            flex: 1;
        }
        .tag-tipo {
            font-size: 0.75rem; 
            color: #fff; 
            background: #1e40af; 
            padding: 2px 6px; 
            border-radius: 4px; 
            font-weight: bold;
        }
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
            <li><a href="/favoritos" class="nav-link ativo">Favoritos</a></li>
            
            <li><a href="{{ route('playlists.index') }}" class="nav-link">Trailer</a></li>
            
            <li><a href="/busca" class="nav-link">Lista</a></li>
            
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
        
        <header class="cabecalho-secao">
            <h1 class="titulo-secao">Meus Favoritos </h1>
        </header>

        <div class="grade-filmes">
            @forelse($favoritos as $favorito)
                @php 
                    $item = $favorito->favoritavel; 
                    $isFilme = $favorito->favoritavel_type === \App\Models\Filme::class;
                    $tipoTexto = $isFilme ? 'Filme' : 'Série';
                @endphp

                @if($item)
                <div class="card-filme">

                    @if($item->imagem)
                        <img src="{{ asset('storage/' . $item->imagem) }}" alt="{{ $item->titulo }}" class="filme-cartaz">
                    @else
                        <img src="{{ asset('img/sem-foto.jpg') }}" alt="Sem Cartaz" class="filme-cartaz">
                    @endif

                    <div>
                        <div class="card-topo">
                            <h3 class="filme-titulo">{{ $item->titulo }}</h3>
                            <span class="filme-nota">⭐ {{ $item->nota }}/5</span>
                        </div>
                        
                        <div style="margin-bottom: 0.5rem; display: flex; gap: 5px;">
                            <span class="tag-tipo">
                                {{ $tipoTexto }}
                            </span>
                            <span style="font-size: 0.85rem; color: #aaa; background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px;">
                                🏷️ {{ $item->genero ?? 'Outro' }}
                            </span>
                        </div>
                        
                        <p class="filme-descricao">
                            {{ $item->descricao ?? 'Nenhuma descrição informada.' }}
                        </p>
                    </div>

                    @if(!$favorito->comentario)
                        <div class="botoes-acoes">
                            <a href="{{ route('favoritos.edit', $favorito->id) }}" class="btn-editar" style="width: 100%; text-align: center; box-sizing: border-box; text-decoration: none;">
                                ➕ Adicionar Nota
                            </a>
                        </div>
                    @else
                        <div class="balao-comentario">
                            <span style="font-size: 0.75rem; color: #aaa; display: block; margin-bottom: 2px; font-weight: bold;">📝 Minha Nota:</span>
                            <p style="font-size: 0.85rem; color: #eee; margin: 0; font-style: italic;">
                                "{{ $favorito->comentario }}"
                            </p>
                        </div>

                        <div class="botoes-acoes">
                            <a href="{{ route('favoritos.edit', $favorito->id) }}" class="btn-editar" style="flex: 1; text-align: center; box-sizing: border-box; text-decoration: none;">
                                ✏️ Editar Nota
                            </a>

                            <form action="{{ route('favoritos.destroy', $favorito->id) }}" method="POST" onsubmit="return confirm('Deseja mesmo remover este título dos seus favoritos?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-excluir" style="width: 100%; text-align: center; cursor: pointer;">
                                    🗑️ Remover
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
                @endif
            @empty
                <div class="lista-vazia">
                    <p>Você ainda não favoritou nenhum filme ou série.</p>
                    <p style="margin-top: 0.5rem;"><a href="/filmes">Explore o catálogo aqui →</a></p>
                </div>
            @endforelse
        </div>

    </div>

</body>
</html>