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
        /* Garante que o card seja a referência para o posicionamento absoluto da estrela */
        .card-filme {
            position: relative;
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
                <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
                <li><a href="/busca" class="nav-link">Lista</a></li>
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
                    
                    @php
                        $favoritoFilme = \App\Models\Favorito::where('favoritavel_id', $filme->id)
                                                             ->where('favoritavel_type', \App\Models\Filme::class)
                                                             ->first();
                    @endphp

                    @if($favoritoFilme)
                        <form action="{{ route('favoritos.destroy', $favoritoFilme->id) }}" method="POST" style="position: absolute; top: 15px; right: 15px; margin: 0; z-index: 10;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Remover dos Favoritos" style="background: none; border: none; font-size: 1.8rem; cursor: pointer; color: #ffca28; text-shadow: 0 0 5px rgba(0,0,0,0.7); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                ⭐
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favoritos.store') }}" method="POST" style="position: absolute; top: 15px; right: 15px; margin: 0; z-index: 10;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $filme->id }}">
                            <input type="hidden" name="tipo" value="Filme">
                            <button type="submit" title="Adicionar aos Favoritos" style="background: none; border: none; font-size: 1.8rem; cursor: pointer; color: #fff; text-shadow: 0 0 5px rgba(0,0,0,0.7); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                ☆
                            </button>
                        </form>
                    @endif

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
                        
                        <div style="margin-bottom: 0.5rem;">
                            <span class="filme-genero" style="font-size: 0.85rem; color: #aaa; background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px;">
                                🏷️ {{ $filme->genero ?? 'Outro' }}
                            </span>
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