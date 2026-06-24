<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Adicionar Comentário</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { background-image: url("{{ asset('img/fundo4.jpg') }}") !important; background-color: #0b0f19; color: white; }
        .formulario-container { max-width: 500px; margin: 60px auto; background: rgba(15, 23, 42, 0.9); padding: 30px; border-radius: 8px; border: 1px solid #1e40af; }
        .campo-grupo { margin-bottom: 20px; }
        .campo-grupo label { display: block; margin-bottom: 8px; font-weight: bold; }
        .input-form { width: 100%; background: #1e293b; border: 1px solid #334155; border-radius: 4px; color: white; padding: 10px; box-sizing: border-box; }
        .textarea-form { width: 100%; background: #1e293b; border: 1px solid #334155; border-radius: 4px; color: white; padding: 10px; height: 100px; box-sizing: border-box; resize: none; }
        
        /* CONTAINER DE BOTÕES CORRIGIDO COM FLEXBOX */
        .btn-container { 
            display: flex; 
            gap: 15px; 
            align-items: center; /* Passa uma régua invisível centralizando os dois verticalmente */
            width: 100%;
        }

        /* PADRONIZAÇÃO COMPLETA DE ALTURA E ESTILO */
        .btn-form {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 42px; /* Altura idêntica travada para ambos */
            font-weight: bold;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none !important;
            box-sizing: border-box;
            margin: 0; /* Zera qualquer margem residual */
            transition: background 0.2s ease;
        }

        .btn-salvar {
            background-color: #1e40af;
            color: white;
        }
        .btn-salvar:hover {
            background-color: #1d4ed8;
        }

        .btn-cancelar {
            background-color: #dc2626; /* Cor vermelha para dar contraste ao cancelar */
            color: white;
        }
        .btn-cancelar:hover {
            background-color: #b91c1c;
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
        <div class="formulario-container">
            <h2 style="margin-bottom: 20px; color: #3b82f6;">Adicionar à Minha Lista</h2>
           @if($obra)

<div class="card-detalhado">

    <img
        src="{{ $obra->imagem ? asset('storage/'.$obra->imagem) : asset('img/sem-foto.jpg') }}"
        alt="{{ $obra->titulo }}"
    >

    <div class="card-info">

        <h2>{{ $obra->titulo }}</h2>

        <p>
            <strong>🎬 Tipo:</strong>
            {{ $obra->tipo }}
        </p>

        <p>
            <strong>🏷️ Gênero:</strong>
            {{ $obra->genero }}
        </p>

        <p>
            <strong>⭐ Nota:</strong>
            {{ $obra->nota }}
        </p>

        <p>
            <strong>❤️ Favorito:</strong>
            {{ $obra->favorito ? 'Sim' : 'Não' }}
        </p>

        <div class="card-descricao">

            <strong>📝 Descrição:</strong>

            <p>
                {{ $obra->descricao }}
            </p>

        </div>

        @if($playlist)

        <div class="trailer-box">

            <h4>🎥 Trailer</h4>

            <video class="trailer-video" controls>
                <source
                    src="{{ asset($playlist->trailer) }}"
                    type="video/mp4"
                >
            </video>

        </div>

        @endif

    </div>

</div>

@endif
            
            <form action="{{ route('busca.store') }}" method="POST">
                @csrf
                <div class="campo-grupo">
                    <label>Título do Filme/Série:</label>
                    <input type="text" name="titulo_obra" value="{{ request('titulo') }}" class="input-form" readonly>
                </div>

                <div class="campo-grupo">
                    <label>Escreva seu comentário/crítica:</label>
                    <textarea name="comentario" class="textarea-form" placeholder="O que você achou dessa produção?" required></textarea>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn-form btn-salvar">
                        Salvar na Lista
                    </button>
                    <a href="{{ route('busca.index') }}" class="btn-form btn-cancelar">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>