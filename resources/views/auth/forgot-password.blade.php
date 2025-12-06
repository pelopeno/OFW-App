<div class="guest-layout-wrapper">
    <div class="authentication-card-wrapper">

        <div class="forgot-password-message">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @session('status')
        <div class="session-status-message">
            {{ $value }}
        </div>
        @endsession

        <div class="validation-errors-display"></div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group-block">
                <input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email" />
            </div>

            <div class="form-button-container">
                <button type="submit" class="submit-button">
                    {{ __('Email Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Tilt+Warp&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Varela+Round&display=swap');

    body {
        width: 100%;
        height: 100%;
        background-image: url('/assets/db-bg.png');
        background-size: cover;
        padding: 0;
        margin: 0;
        overflow: hidden;
    }

    .guest-layout-wrapper {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .authentication-card-wrapper {
        width: 500px;
        height: 250px;
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 50px;
    }

    .forgot-password-message, .session-status-message  {
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        text-align: center;
        line-height: 21px;
        margin-bottom: 12px;
    }

    .session-status-message {
        color: green;
    }

    .authentication-card-wrapper form {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .authentication-card-wrapper form input {
        width: 500px;
        height: 36px;
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        border-radius: 15px;
        padding: 20px 10px;
    }

    .form-button-container {
        width: 100%;
    }

    .form-button-container button {
        width: 500px;
        background-color: #494949;
        border: 3px #878787 solid;
        border-radius: 25px;
        padding: 10px;
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: white;
        text-align: center;
        cursor: pointer;
    }
</style>