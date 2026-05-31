<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Minhas Séries</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { background-image: url("{{ asset('img/fundo4.jpg') }}") !important; }
        /* Garante o posicionamento correto da estrela sobre o cartaz */
        .card-filme { position: relative; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
            <ul class="nav-menu">
                <li><a href="/filmes" class="nav-link">Início</a></li>
                <li><a href="/filmes" class="nav-link">Filmes</a></li>
                <li><a href="/series" class="nav-link ativo">Séries</a></li>
                <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <header class="cabecalho-secao">
            <h1 class="titulo-secao">Séries Cadastradas</h1>
            <a href="/series/create" class="btn-adicionar">+ Nova Série</a>
        </header>

        <div class="grade-filmes">
            @forelse($series as $serie)
                <div class="card-filme">
                    
                    @php
                        $favoritoSerie = \App\Models\Favorito::where('favoritavel_id', $serie->id)
                                                            ->where('favoritavel_type', \App\Models\Serie::class)
                                                            ->first();
                    @endphp

                    @if($favoritoSerie)
                        <form action="{{ route('favoritos.destroy', $favoritoSerie->id) }}" method="POST" style="position: absolute; top: 15px; right: 15px; margin: 0; z-index: 10;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" title="Remover dos Favoritos" style="background: none; border: none; font-size: 1.8rem; cursor: pointer; color: #ffca28; text-shadow: 0 0 5px rgba(0,0,0,0.7); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                ⭐
                            </button>
                        </form>
                    @else
                        <form action="{{ route('favoritos.store') }}" method="POST" style="position: absolute; top: 15px; right: 15px; margin: 0; z-index: 10;">
                            @csrf
                            <input type="hidden" name="id" value="{{ $serie->id }}">
                            <input type="hidden" name="tipo" value="Serie">
                            <button type="submit" title="Adicionar aos Favoritos" style="background: none; border: none; font-size: 1.8rem; cursor: pointer; color: #fff; text-shadow: 0 0 5px rgba(0,0,0,0.7); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                                ☆
                            </button>
                        </form>
                    @endif

                    @if($serie->imagem)
                        <img src="{{ asset('storage/' . $serie->imagem) }}" alt="{{ $serie->titulo }}" class="filme-cartaz">
                    @else
                        <img src="{{ asset('img/sem-foto.jpg') }}" alt="Sem Cartaz" class="filme-cartaz">
                    @endif

                    <div>
                        <div class="card-topo">
                            <h3 class="filme-titulo">{{ $serie->titulo }}</h3>
                            <span class="filme-nota">⭐ {{ $serie->nota == floor($serie->nota) ? floor($serie->nota) : $serie->nota }}/5</span>
                        </div>
                        
                        <div style="margin-bottom: 0.5rem;">
                            <span class="filme-genero" style="font-size: 0.85rem; color: #aaa; background: rgba(255,255,255,0.1); padding: 2px 8px; border-radius: 4px;">
                                🏷️ {{ $serie->genero ?? 'Outro' }}
                            </span>
                        </div>
                        
                        <p class="filme-descricao">{{ $serie->descricao ?? 'Nenhuma descrição informada.' }}</p>
                    </div>

                    <div class="card-acoes">
                        <a href="/series/{{ $serie->id }}/edit" class="btn-editar">✏️ Editar</a>
                        <form action="/series/{{ $serie->id }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta série?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-excluir">🗑️ Excluir</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="lista-vazia">
                    <p>Sua lista de séries está vazia.</p>
                    <p style="margin-top: 0.5rem;"><a href="/series/create">Cadastre a primeira série agora →</a></p>
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>