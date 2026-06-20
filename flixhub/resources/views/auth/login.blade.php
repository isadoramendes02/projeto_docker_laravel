<head>
    <meta charset="UTF-8">
    <title>Login - Flixhub</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<div class="login-container">
    <div id="bgSlider" class="bg-slider"></div>

    <div class="login-card">
        <h2>Entrar</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input type="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required autofocus>
                @error('email') <span style="color: #e50914; font-size: 0.85rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder="Senha" required autocomplete="current-password">
                @error('password') <span style="color: #e50914; font-size: 0.85rem;">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="btn-login">Entrar</button>

            <div class="login-links">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Esqueceu a senha?</a>
                @endif
                <a href="{{ route('register') }}">Criar uma conta</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Coloque os links ou caminhos das suas imagens preferidas aqui:
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