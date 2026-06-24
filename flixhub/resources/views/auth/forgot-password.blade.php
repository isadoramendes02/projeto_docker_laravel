<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha - Flixhub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<div class="login-container">
    <div id="bgSlider" class="bg-slider"></div>

    <div class="login-card">
        <h2>Recuperar Senha</h2>

        <div class="login-instructions">
            Esqueceu sua senha? Sem problemas. Informe seu endereço de e-mail que enviaremos um link para você redefinir sua senha.
        </div>

        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <input type="email" name="email" placeholder="E-mail cadastrado" value="{{ old('email') }}" required autofocus>
                @error('email') <span>{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-login">
                Enviar 
            </button>

            <div class="login-links forgot-links">
                <a href="{{ route('login') }}">Voltar para o Login</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const imagens = [
            "/img/imagem1.jpg",
            "/img/imagem2.jpg",
            "/img/imagem3.jpg",
            "/img/imagem8.jpg",
            "/img/imagem9.jpg",
            "/img/imagem10.jpg",
            "/img/img5.jpg",
            "/img/img6.jpg",
            "/img/img7.jpg",
            "/img/img8.jpg",
            "/img/imagem4.jpg",
            "/img/imagem5.jpg",
            "/img/img11.jpg",
            "/img/img12.jpg",
            "/img/img13.jpg",
            "/img/imagem6.jpg",
            "/img/img15.jpg",
            "/img/img16.jpg",
            "/img/imagem7.jpg",
        ];

        const slider = document.getElementById("bgSlider");
        let index = 0;

        function mudarFundo() {
            slider.style.backgroundImage = `url('${imagens[index]}')`;
            index = (index + 1) % imagens.length;
        }

        mudarFundo();
        setInterval(mudarFundo, 5000);
    });
</script>