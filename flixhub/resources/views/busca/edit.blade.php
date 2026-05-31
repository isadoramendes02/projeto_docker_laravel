<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Editar Comentário</title>
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
            align-items: center; /* Alinha perfeitamente os botões na mesma altura pelo centro */
            width: 100%;
            margin-top: 20px;
        }

        /* PADRONIZAÇÃO DE ESTILOS E COMPORTAMENTO VISUAL */
        .btn-form {
            flex: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 42px; /* Força ambos a terem exatamente o mesmo tamanho vertical */
            font-weight: bold;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none !important; /* Bloqueia qualquer linha sob o texto */
            box-sizing: border-box;
            margin: 0; 
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
            background-color: #dc2626; /* Vermelho para dar contraste ao cancelar */
            color: white;
            text-decoration: none !important;
        }
        .btn-cancelar:hover {
            background-color: #b91c1c;
            color: white;
            text-decoration: none !important; /* Remove totalmente a linha ao passar o mouse */
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-container">
            <a href="/filmes" class="nav-logo">Flix<span>Hub</span></a>
            <ul class="nav-menu">
                <li><a href="/filmes" class="nav-link">Início</a></li>
                <li><a href="/filmes" class="nav-link">Filmes</a></li>
                <li><a href="/series" class="nav-link">Séries</a></li>
                <li><a href="/favoritos" class="nav-link">Favoritos</a></li>
                <li><a href="/busca" class="nav-link ativo">🔍 Minha Lista</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="formulario-container">
            <h2 style="margin-bottom: 20px; color: #3b82f6;">Editar Comentário</h2>
            
            <form action="{{ route('busca.update', $busca->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="campo-grupo">
                    <label>Filme / Série:</label>
                    <input type="text" value="{{ $busca->titulo_obra }}" class="input-form" readonly>
                </div>

                <div class="campo-grupo">
                    <label>Modificar seu comentário:</label>
                    <textarea name="comentario" class="textarea-form" required>{{ $busca->comentario }}</textarea>
                </div>

                <div class="btn-container">
                    <button type="submit" class="btn-form btn-salvar">
                        Atualizar
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