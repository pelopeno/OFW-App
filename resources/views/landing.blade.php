<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pundar: An OFW Micro-Investment & Savings Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- SweetAlert2 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <div class="status-login-signup" class=>
                {{ $value }}
            </div>
            @endsession

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <input type="email" id="login_email" name="email" placeholder="Email" autofocus>
                <input type="password" id="login_password" name="password" placeholder="Password">
                <button type="submit">Log in</button>
            </form>
        </div>
    </div>
    <!----------↑↑↑-Login-↑↑↑---------->

    <!---------↓↓↓-Sign Up-↓↓↓--------->

    <div class="choose-type-body" id="chooseType" style="display:none;">
        <img src="/assets/x-btn.png" class="signup-x-btn" onClick="toggleChooseType()" style="right: 24%"/>

        <div class="choose-type-main">
            <h2>Who are you signing up as?</h2>
            <div class="choose-type-buttons-cont">
                <div class="signup-ofw-button-cont">
                    <button type="button" onclick="selectUserType('ofw')"> <img src="/assets/signup-ofw-btn.png" /> </button>
                    <p>OFW</p>
                </div>
                <div class="signup-bus-button-cont">
                    <button type="button" onclick="selectUserType('business_owner')"> <img src="/assets/signup-bus-btn.png" /> </button>
                    <p>Business Owner</p>
                </div>
            </div>
        </div>
    </div>

    <div class="signup-body" id="signup">
        <div class="signup-bg-cont">
            <img src="/assets/ls-signup-bg.png" class="signup-bg" />
        </div>
        <img src="/assets/x-btn.png" class="signup-x-btn" onClick="toggleSignup()" />
        <div class="signup-main">
            <h2>Sign-up</h2>
            <p class="signup-type-display"> Signing up as: <span id="selectedTypeLabel"></span></p>
            <img src="assets/ls-hr.png" class="signup-hr" />

            @if($errors->any() && (request()->is('register') || old('name') !== null))
            <div id="validation-errors-alert"></div>
            @endif

            <form id="signupForm" method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" id="user_type" name="user_type" value="">

                <input type="text" id="name" name="name" placeholder="Name" value="{{ old('name') }}">
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" autocomplete="off">
                <input type="password" id="password" name="password" placeholder="Password" autocomplete="off">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" autocomplete="off">
    
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
        <button type="button" onClick="toggleSignupChoice()">Sign-up</button>
    </div>

    @if(session('error'))
    <div class="error-message" style="color: #d32f2f; margin-bottom: 15px; text-align: center; font-weight: 500;">
        {{ session('error') }}
    </div>
    @endif
    
</body>

</html>

<script>
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

    var chooseType = document.getElementById('chooseType');

    function toggleChooseType() {
        if (chooseType.style.display === 'flex') {
            chooseType.classList.remove('fade-in');
            chooseType.classList.add('fade-out');
            setTimeout(() => chooseType.style.display = 'none', 300);
        } else {
            chooseType.style.display = 'flex';
            chooseType.classList.remove('fade-out');
            chooseType.classList.add('fade-in');
        }
    }

    function toggleSignupChoice() {
        toggleChooseType();
    }

    function selectUserType(type) {
        document.getElementById('user_type').value = type;
        document.getElementById('selectedTypeLabel').textContent =
            type === 'ofw' ? 'OFW' : 'Business Owner';

        const nameInput = document.querySelector('input[name="name"]');
        if (nameInput) {
            nameInput.placeholder = type === 'ofw' ? 'Display Name' : 'Business Name';
        }

        toggleChooseType();
        toggleSignup();
    }

    // SweetAlert2 Form Validation
    document.getElementById('signupForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const name = document.getElementById('name').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        const userType = document.getElementById('user_type').value;

        // Validate name
        if (!name) {
            Swal.fire({
                icon: 'error',
                title: 'Name Required',
                text: 'Please enter your name.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        if (name.length < 3) {
            Swal.fire({
                icon: 'error',
                title: 'Name Too Short',
                text: 'Name must be at least 3 characters long.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            Swal.fire({
                icon: 'error',
                title: 'Email Required',
                text: 'Please enter your email address.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please enter a valid email address.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        // Validate password
        if (!password) {
            Swal.fire({
                icon: 'error',
                title: 'Password Required',
                text: 'Please enter a password.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        if (password.length < 8) {
            Swal.fire({
                icon: 'error',
                title: 'Password Too Short',
                text: 'Password must be at least 8 characters long.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        // Validate password confirmation
        if (password !== passwordConfirmation) {
            Swal.fire({
                icon: 'error',
                title: 'Passwords Do Not Match',
                text: 'Password and confirmation password must match.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        // Validate user type
        if (!userType) {
            Swal.fire({
                icon: 'error',
                title: 'User Type Required',
                text: 'Please select whether you are an OFW or Business Owner.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        // All client-side validations passed, show loading and submit
        Swal.fire({
            icon: 'info',
            title: 'Creating Account',
            text: 'Please wait...',
            confirmButtonColor: '#A68749',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
                // Submit the form after showing the loading alert
                document.getElementById('signupForm').submit();
            }
        });
    });

    // SweetAlert2 Form Validation for Login
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const email = document.getElementById('login_email').value.trim();
        const password = document.getElementById('login_password').value;

        // Validate email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email) {
            Swal.fire({
                icon: 'error',
                title: 'Email Required',
                text: 'Please enter your email address.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please enter a valid email address.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        // Validate password
        if (!password) {
            Swal.fire({
                icon: 'error',
                title: 'Password Required',
                text: 'Please enter your password.',
                confirmButtonColor: '#A68749',
            });
            return;
        }

        // All validations passed, show loading and submit
        Swal.fire({
            icon: 'info',
            title: 'Logging In',
            text: 'Please wait...',
            confirmButtonColor: '#A68749',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
                document.getElementById('loginForm').submit();
            }
        });
    });

    // Show server-side errors with SweetAlert
    document.addEventListener('DOMContentLoaded', function() {
        var body = document.body;
        var hasErrors = body.getAttribute('data-has-errors') === '1';
        var isLoginError = body.getAttribute('data-is-login-error') === '1';
        var isRegisterError = body.getAttribute('data-is-register-error') === '1';
        var hasStatus = body.getAttribute('data-has-status') === '1';

        if (hasErrors && isRegisterError) {
            // Show server-side validation errors with SweetAlert
            let errorMessages = `{!! $errors->any() && (request()->is('register') || old('name') !== null) ? '<ul style="text-align: left;">' . collect($errors->all())->map(fn($error) => '<li>' . e($error) . '</li>')->join('') . '</ul>' : '' !!}`;

            if (errorMessages) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errorMessages,
                    confirmButtonColor: '#A68749',
                });

                signup.style.display = 'flex';
                signup.classList.add('fade-in');
            }
        } else if (hasErrors && isLoginError) {
            login.style.display = 'flex';
            login.classList.add('fade-in');
        }

        if (hasStatus) {
            login.style.display = 'flex';
            login.classList.add('fade-in');
        }
    });

    // Show login error with SweetAlert
    if ('{!! session('error') !!}') {
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '{!! session('error') !!}',
            confirmButtonColor: '#A68749',
        }).then(() => {
            login.style.display = 'flex';
            login.classList.add('fade-in');
        });
    }
</script>