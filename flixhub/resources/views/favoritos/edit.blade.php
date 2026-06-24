<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Editar Nota</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background-image: url("{{ asset('img/fundo4.jpg') }}") !important;
        }
        .card-formulario {
            background: rgba(0, 0, 0, 0.75);
            padding: 30px;
            border-radius: 8px;
            max-width: 500px;
            margin: 50px auto;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.5);
        }
        .form-grupo {
            margin-bottom: 20px;
        }
        .form-grupo label {
            display: block;
            color: #aaa;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }
        .form-control {
            width: 100%;
            background: #333;
            border: 1px solid #444;
            border-radius: 4px;
            color: white;
            padding: 10px;
            font-size: 1rem;
            resize: none;
            box-sizing: border-box;
            font-family: inherit;
        }
        .form-control:focus {
            outline: none;
            border-color: #1e40af;
        }
        .btn-container {
            display: flex;
            gap: 10px;
        }
        .btn-salvar {
            background: #1e40af;
            color: white;
            padding: 10px;
            border-radius: 4px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-salvar:hover {
            background: #1e3a8a;
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
        <div class="card-formulario">
            <h2 style="color: #fff; margin-bottom: 5px;">Minha Nota Pessoal ✏️</h2>
            <p style="color: #1e40af; margin-top: 0; font-weight: bold; font-size: 1.1rem;">
                {{ $favorito->favoritavel->titulo ?? 'Item' }}
            </p>
            
            <form action="{{ route('favoritos.update', $favorito->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-grupo">
                    <label for="comentario">Sua anotação ou crítica sobre este título:</label>
                    <textarea 
                        id="comentario" 
                        name="comentario" 
                        rows="4" 
                        class="form-control" 
                        placeholder="Escreva seus comentários, lembretes ou críticas..."
                    >{{ $favorito->comentario }}</textarea>
                </div>

                <div class="btn-container" style="display: flex; gap: 10px; width: 100%;">
                    <button type="submit" class="btn-salvar" style="flex: 1; font-weight: bold; height: 42px; display: flex; align-items: center; justify-content: center; padding: 0; margin: 0; line-height: 1; box-sizing: border-box; cursor: pointer; border: none; text-align: center;">
                        Salvar Nota
                    </button>
                    
                    <button type="button" onclick="window.location.href='/favoritos'" style="flex: 1; font-weight: bold; height: 42px; display: flex; align-items: center; justify-content: center; padding: 0; margin: 0; line-height: 1; box-sizing: border-box; cursor: pointer; border: none; text-align: center; background-color: #1e40af; color: white; border-radius: 4px; transition: background 0.2s;" onmouseover="this.style.backgroundColor='#1e3a8a'" onmouseout="this.style.backgroundColor='#1e40af'">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>