<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} - Security Identification for Web and Apps</title>
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,200;0,400;0,700;1,200&family=Unbounded:wght@400;700&display=swap">
        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tooplate-kool-form-pack.css') }}">
    </head>

    <body>
        <main>
            <header class="site-header">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-lg-12 col-12 d-flex align-items-center">
                            <a class="site-header-text d-flex justify-content-center align-items-center me-auto" href="/">
                                <span>{{ config('app.name') }}</span>
                            </a>

                            <ul class="social-icon d-flex justify-content-center align-items-center mx-auto">
                                <span class="text-white me-4 d-none d-lg-block">Social Media</span>
                                <li class="social-icon-item">
                                    <a href="https://www.instagram.com/albert_devada" class="social-icon-link bi-instagram"></a>
                                </li>
                                <li class="social-icon-item">
                                    <a href="https://github.com/albertdveada" class="social-icon-link bi-github"></a>
                                </li>
                                <li class="social-icon-item">
                                    <a href="https://www.linkedin.com/in/noufalburhan" class="social-icon-link bi-linkedin"></a>
                                </li>
                            </ul>
                            <a class="offcanvas-icon" href="{{ route('signin') }}" >Sign In</a>
                        </div>

                    </div>
                </div>
            </header>
            <section id="section_welcome" class="hero-section d-flex justify-content-center align-items-center">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12 mx-auto">
                            <small>Always protect and analyze.
                            <a rel="nofollow" target="_blank" href="https://www.pexels.com/video/digital-projection-of-the-earth-mass-in-blue-lights-3129957/">CyberSecurity System</a></small>
                            <!-- please set the date time in the init.js file -->

                        <h1 class="text-white mt-2 mb-4 pb-2">
                                Stay tuned!
                            </h1>
                            <ul class="countdown d-flex flex-wrap align-items-center">
                                <li class="countdown-item d-flex flex-column justify-content-center align-items-center">
                                    <h2 class="countdown-title days">00</h2> <span class="countdown-text">Days</span>
                                </li>

                                <li class="countdown-item d-flex flex-column justify-content-center align-items-center">
                                    <h2 class="countdown-title hours">00</h2> <span class="countdown-text">Hours</span>
                                </li>

                                <li class="countdown-item d-flex flex-column justify-content-center align-items-center">
                                    <h2 class="countdown-title minutes">00</h2> <span class="countdown-text">Minutes</span>
                                </li>

                                <li class="countdown-item d-flex flex-column justify-content-center align-items-center">
                                    <h2 class="countdown-title seconds">00</h2> <span class="countdown-text">Seconds</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="video-wrap">
                    <video autoplay="" loop="" muted="" class="custom-video" poster="">
                        <source src="{{ asset('img/video.mp4') }}" type="video/mp4">Your browser does not support the video tag.
                    </video>
                </div>
            </section>
        </main>

        <!-- JAVASCRIPT FILES -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/countdown.js') }}"></script>
        <script src="{{ asset('js/init.js') }}"></script>
    </body>
</html>
