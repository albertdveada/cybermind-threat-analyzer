<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <title>{{ config('app.name') }} - Reset Password</title>

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
                    <p class="tagline">Reset Your Password</p>

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
                            $decodedErrorMessage = html_entity_decode($combinedErrorMessage); // Untuk mengatasi &#039;
                        @endphp
                        <x-alert :message="$decodedErrorMessage" type="error" />
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="login-form">
                        @csrf
                        <input name="email" type="email" placeholder="Enter Your Email" required autofocus>
                        <button type="submit" class="btn btn-signin">
                            <i class="fas fa-paper-plane"></i> Send Reset Link
                        </button>
                    </form>
                    <p class="signup-text">Remembered your password? <a href="{{ route('signin') }}" class="signup-link">Back to Login</a></p>
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
