<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pundar: An OFW Micro-Investment & Savings Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="landing-body"
    data-has-errors="{{ $errors->any() ? '1' : '0' }}"
    data-is-login-error="{{ (request()->is('login') || (old('email') !== null && old('name') === null)) ? '1' : '0' }}"
    data-is-register-error="{{ (request()->is('register') || old('name') !== null) ? '1' : '0' }}"
    data-has-status="{{ session('status') ? '1' : '0' }}">

    <!----------↓↓↓-Login-↓↓↓---------->
    <div class="login-body" id="login">
        <div class="login-bg-cont">
            <img src="/assets/ls-login-bg.png" class="login-bg" />
        </div>
        <img src="/assets/x-btn.png" class="login-x-btn" onClick="toggleLogin()" />
        <div class="login-main">
            <h2>Login</h2>
            @if (Route::has('password.request'))
            <a class="login-forgot-pass" href="{{ route('password.request') }}">Forgot your password?</a>
            @endif
            <img src="assets/ls-hr.png" class="login-hr" />

            @if($errors->any() && (request()->is('login') || (old('email') !== null && old('name') === null)))
            <x-validation-errors class="mb-4" />
            @endif

            @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
            @endsession

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" name="email" placeholder="Email" required autofocus autocomplete="username">
                <input type="password" name="password" placeholder="Password" required autocomplete="current-password">
                <button type="submit">Log in</button>
            </form>
        </div>
    </div>
    <!----------↑↑↑-Login-↑↑↑---------->

    <!---------↓↓↓-Sign Up-↓↓↓--------->
    <div class="signup-body" id="signup">
        <div class="signup-bg-cont">
            <img src="/assets/ls-signup-bg.png" class="signup-bg" />
        </div>
        <img src="/assets/x-btn.png" class="signup-x-btn" onClick="toggleSignup()" />
        <div class="signup-main">
            <h2>Sign-up</h2>
            <a class="signup-forgot-pass" href="{{ route('login') }}">Already have an account?</a>
            <img src="assets/ls-hr.png" class="signup-hr" />

            @if($errors->any() && (request()->is('register') || old('name') !== null))
            <x-validation-errors class="mb-4" />
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="text" name="name" placeholder="Display Name" required autofocus autocomplete="name">
                <input type="email" name="email" placeholder="Email" required autocomplete="username">
                <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                <button type="submit">Sign up</button>
            </form>
        </div>
    </div>
    <!---------↑↑↑-Sign Up-↑↑↑--------->

    <div class="landing-dev-btn-cont">
        <a href=""><img src="/assets/landing-dev-btn.png" class="landing-dev-btn-img"></a>
    </div>
    <img src="/assets/landing-logo.png" class="landing-logo" />
    <br>
    <div class="landing-button-cont">
        <button type="button" onClick="toggleLogin()">Login</button>
        <button type="button" onClick="toggleSignup()">Sign-up</button>
    </div>

</body>

</html>

<script>
    // Show and Hide Login and Signup UI
    var login = document.getElementById('login');
    var loginVisibility = 1;

    function toggleLogin() {
        if (login.style.display === 'flex') {
            login.classList.remove('fade-in');
            login.classList.add('fade-out');
            setTimeout(() => login.style.display = 'none', 300);
        } else {
            login.style.display = 'flex';
            login.classList.remove('fade-out');
            login.classList.add('fade-in');
        }
    }

    var signup = document.getElementById('signup');
    var signupVisibility = 1;

    function toggleSignup() {
        if (signup.style.display === 'flex') {
            signup.classList.remove('fade-in');
            signup.classList.add('fade-out');
            setTimeout(() => signup.style.display = 'none', 300);
        } else {
            signup.style.display = 'flex';
            signup.classList.remove('fade-out');
            signup.classList.add('fade-in');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        var body = document.body;
        var hasErrors = body.getAttribute('data-has-errors') === '1';
        var isLoginError = body.getAttribute('data-is-login-error') === '1';
        var isRegisterError = body.getAttribute('data-is-register-error') === '1';
        var hasStatus = body.getAttribute('data-has-status') === '1';

        if (hasErrors && isLoginError) {
            login.style.display = 'flex';
            login.classList.add('fade-in');
        } else if (hasErrors && isRegisterError) {
            signup.style.display = 'flex';
            signup.classList.add('fade-in');
        }

        if (hasStatus) {
            login.style.display = 'flex';
            login.classList.add('fade-in');
        }
    });
</script>