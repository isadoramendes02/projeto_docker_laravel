<head>
    <meta charset="UTF-8">
    <title>Cadastro - Flixhub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<div class="login-container">
    <div id="bgSlider" class="bg-slider"></div>

    <div class="login-card">
        <h2>Cadastrar</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <input type="text" name="name" placeholder="Nome" value="{{ old('name') }}" required autofocus autocomplete="name">
                @error('name') <span>{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required autocomplete="username">
                @error('email') <span>{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Senha" required autocomplete="new-password">
                @error('password') <span>{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password_confirmation" placeholder="Confirmar Senha" required autocomplete="new-password">
                @error('password_confirmation') <span>{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-login">
                Cadastrar
            </button>

            <div class="login-links">
                <a href="{{ route('login') }}">Já tem uma conta? Entre aqui</a>
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
        setInterval(mudarFundo, 5000); // Troca a cada 5 segundos
    });
</script>