<div class="guest-layout-wrapper">
    <div class="authentication-card-wrapper">

    <div class="reset-password-message">
            {{ __('Please enter your email and your new password.') }}
        </div>
        
        <div class="validation-errors-display">
            <x-validation-errors class="mb-4" /> 
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

          
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="form-group-block">
                <input 
                    id="email" 
                    class="form-input" 
                    type="email" 
                    name="email" 
                    :value="old('email', $request->email)" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder="Email" 
                />
            </div>

            <div class="form-group-block">
                <input 
                    id="password" 
                    class="form-input" 
                    type="password" 
                    name="password" 
                    required 
                    autocomplete="new-password" 
                    placeholder="Password"
                />
            </div>

            <div class="form-group-block">
                <input 
                    id="password_confirmation" 
                    class="form-input" 
                    type="password" 
                    name="password_confirmation" 
                    required 
                    autocomplete="new-password" 
                    placeholder="Confirm Password"
                />
            </div>

            <div class="form-button-container">
                <button type="submit" class="submit-button">
                    {{ __('Reset Password') }}
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
        height: auto; 
        background-color: white;
        border: 3px solid black;
        border-radius: 25px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 50px;
    }

    .reset-password-message, .session-status-message  {
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        text-align: center;
        line-height: 21px;
        margin-bottom: 12px;
    }

    .session-status-message {
        color: green;
    }
    
    .validation-errors-display {
        width: 100%;
        margin-bottom: 15px;
    }

    .authentication-card-wrapper form {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
    }

    .form-input {
        width: 500px;
        height: 36px;
        font-family: "Varela Round", sans-serif;
        font-size: 18px;
        border-radius: 15px;
        padding: 20px 10px;
    }
    
    .form-group-block {
        width: 100%;
    }


    .form-button-container {
        width: 100%;
        margin-top: 8px;
    }

    .submit-button {
        width: 100%;
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