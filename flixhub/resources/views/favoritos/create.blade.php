<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Adicionar aos Favoritos</title>
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
        .btn-confirmar {
            background: #1e40af;
            color: white;
            padding: 10px;
            border-radius: 4px;
            border: none;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-confirmar:hover {
            background: #1e3a8a;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
        </div>
    </nav>

    <div class="container">
        <div class="card-formulario">
            <h2 style="color: #fff; margin-bottom: 5px;">Adicionar aos Favoritos ❤️</h2>
            <p style="color: #1e40af; margin-top: 0; font-weight: bold; font-size: 1.1rem;">
                {{ $item->titulo }} ({{ $tipo }})
            </p>
            
            <form action="{{ route('favoritos.store') }}" method="POST">
                @csrf
                
                <input type="hidden" name="id" value="{{ $item->id }}">
                <input type="hidden" name="tipo" value="{{ $tipo }}">

                <div class="form-grupo">
                    <label for="comentario">Deseja adicionar uma nota ou comentário inicial? (Opcional):</label>
                    <textarea 
                        id="comentario" 
                        name="comentario" 
                        rows="4" 
                        class="form-control" 
                        placeholder="Escreva algo sobre este título ou deixe em branco..."
                    ></textarea>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn-confirmar" style="flex: 1; font-weight: bold;">
                        Confirmar Favorito
                    </button>
                    <button type="button" class="btn-excluir" onclick="window.location.href='/{{ $tipo === 'Filme' ? 'filmes' : 'series' }}'" style="flex: 1; font-weight: bold; cursor: pointer; border: none;">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>