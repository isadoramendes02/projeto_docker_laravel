<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FlixHub - Editar Comentário</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body{
            background-image:url("{{ asset('img/fundo4.jpg') }}") !important;
            background-color:#0b0f19;
            color:white;
        }

        .formulario-container{
            max-width:1000px;
            margin:60px auto;
            background:rgba(15,23,42,.9);
            padding:30px;
            border-radius:8px;
            border:1px solid #1e40af;
        }

        .campo-grupo{
            margin-bottom:20px;
        }

        .campo-grupo label{
            display:block;
            margin-bottom:8px;
            font-weight:bold;
        }

        .input-form{
            width:100%;
            background:#1e293b;
            border:1px solid #334155;
            border-radius:4px;
            color:white;
            padding:10px;
            box-sizing:border-box;
        }

        .textarea-form{
            width:100%;
            background:#1e293b;
            border:1px solid #334155;
            border-radius:4px;
            color:white;
            padding:10px;
            height:120px;
            resize:none;
            box-sizing:border-box;
        }

        .btn-container{
            display:flex;
            gap:15px;
            width:100%;
            margin-top:20px;
        }

        .btn-form{
            flex:1;
            display:flex;
            justify-content:center;
            align-items:center;
            height:42px;
            border:none;
            border-radius:4px;
            text-decoration:none;
            font-weight:bold;
            cursor:pointer;
        }

        .btn-salvar{
            background:#1e40af;
            color:white;
        }

        .btn-salvar:hover{
            background:#1d4ed8;
        }

        .btn-cancelar{
            background:#dc2626;
            color:white;
        }

        .btn-cancelar:hover{
            background:#b91c1c;
        }

        .bloco-obra{
            display:flex;
            gap:20px;
            margin-bottom:30px;
            background:#111827;
            border:1px solid #1e40af;
            border-radius:10px;
            padding:20px;
        }

        .capa-obra{
            width:250px;
            height:350px;
            object-fit:cover;
            border-radius:8px;
        }

        .info-obra{
            flex:1;
        }

        .info-obra p{
            margin-bottom:10px;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <div class="nav-container">

        <a href="/filmes" class="nav-logo">
            Flix<span>Hub</span>
        </a>

        <ul class="nav-menu">

            <li>
                <a href="{{ route('dashboard') }}" class="nav-link">
                    Início
                </a>
            </li>

            <li>
                <a href="/filmes" class="nav-link">
                    Filmes
                </a>
            </li>

            <li>
                <a href="/series" class="nav-link">
                    Séries
                </a>
            </li>

            <li>
                <a href="/favoritos" class="nav-link">
                    Favoritos
                </a>
            </li>

            <li>
                <a href="{{ route('playlists.index') }}" class="nav-link">
                    Trailer
                </a>
            </li>

            <li>
                <a href="/busca" class="nav-link ativo">
                    Lista
                </a>
            </li>

        </ul>
    </div>
</nav>

<div class="container">

    <div class="formulario-container">

        <h2 style="margin-bottom:20px;color:#3b82f6;">
            Editar Comentário
        </h2>

        @if($obra)

        <div class="bloco-obra">

            <img
                src="{{ $obra->imagem ? asset('storage/'.$obra->imagem) : asset('img/sem-foto.jpg') }}"
                class="capa-obra"
            >

            <div class="info-obra">

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
                    <strong>📝 Descrição:</strong>
                    {{ $obra->descricao }}
                </p>

                @if($playlist)

                    <h3>🎥 Trailer</h3>

                    <video width="100%" controls>
                        <source
                            src="{{ asset($playlist->trailer) }}"
                            type="video/mp4"
                        >
                    </video>

                @endif

            </div>

        </div>

        @endif

        <form action="{{ route('busca.update', $busca->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="campo-grupo">

                <label>Filme / Série</label>

                <input
                    type="text"
                    value="{{ $busca->titulo_obra }}"
                    class="input-form"
                    readonly
                >

            </div>

            <div class="campo-grupo">

                <label>Modificar comentário</label>

                <textarea
                    name="comentario"
                    class="textarea-form"
                    required
                >{{ $busca->comentario }}</textarea>

            </div>

            <div class="btn-container">

                <button
                    type="submit"
                    class="btn-form btn-salvar"
                >
                    Atualizar
                </button>

                <a
                    href="{{ route('busca.index') }}"
                    class="btn-form btn-cancelar"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>