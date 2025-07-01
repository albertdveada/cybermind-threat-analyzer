<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <title>{{ config('app.name') }} - Sign In</title>

            <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
            <link rel="stylesheet" href="{{ asset('css/signin.style.css') }}">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
            <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@400;500;600;700&display=swap" rel="stylesheet">
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        </head>
        <body>
            <div class="login-wrapper">
                <div class="login-container">
                    <a href="/" class="logo_alien">
                        <h1 class="logo">ALIEN66.<span class="logo-net">TECH</span></h1>
                    </a>
                    <p class="tagline">Sign in to Your account</p>

                    @if (session('status'))
                        <x-alert :message="session('status')" type="success" />
                    @elseif ($errors->any())
                        @php
                            $allErrorMessages = [];
                            foreach ($errors->getMessages() as $fieldErrors) {
                                foreach ($fieldErrors as $error) {
                                    $allErrorMessages[] = $error;
                                }
                            }
                            $combinedErrorMessage = implode(' ', $allErrorMessages);
                        @endphp
                        <x-alert :message="$combinedErrorMessage" type="error" />
                    @endif

                    <form method="POST" action="{{ route('signin') }}" class="login-form">
                        @csrf
                        <div class="email-area">
                            <input name="email" type="email" placeholder="Email" required autofocus autocomplete="username">
                        </div>
                        <div class="pass-area">
                            <input name="password" type="password" placeholder="Password" required autocomplete="current-password">
                        </div>
                        <div class="reset-password">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-signin">
                            <i class="fas fa-sign-in-alt"></i>Sign In
                        </button>
                    </form>

                    <div class="separator">
                        <span>or</span>
                    </div>

                    <button class="btn btn-google">
                        <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google Logo" class="google-icon">
                    </button>

                    <p class="signup-text">Don't have an account?<a href="{{ route('registration') }}" class="signup-link">&nbsp;Sign up</a></p>
                </div>
            </div>
            <footer class="footer">
                <p>Copyright © 2025 <span class="logo-footer">ALIEN66.TECH</span> | All Right Reserved.</p>
                <a href="/" class="privacy-terms">Privacy Terms</a>
            </footer>

            <div class="bottom-right-box">
                <img src="https://img.icons8.com/ios-filled/50/ffffff/privacy-policy.png" alt="Privacy Policy Icon" class="privacy-icon">
            </div>
        </body>
    </html>
