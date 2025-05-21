<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Workshop Guru 2024</title>
    @vite('resources/css/app.css') {{-- Pastikan Vite sudah diatur untuk Tailwind CSS --}}
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Poppins';
        }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
</head>
    <body class="bg-gray-100 pt-[4.5rem]">

    <!-- Header -->
    <x-navigation></x-navigation>

        <div class=" px-4 md:px-24">
            {{ $slot }}
        </div>

    <!-- Footer -->
    <x-footer></x-footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('navbar');
            let lastScrollTop = 0;
            const navbarHeight = navbar.offsetHeight;

            // window.addEventListener('load', function() {
            //     window.scrollTo(0, 0);
            // });
        
            window.addEventListener('scroll', function() {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                
                // Only apply effects after scrolling past the navbar height
                if (scrollTop > navbarHeight) {
                    if (scrollTop > lastScrollTop) {
                        // Scrolling down - hide navbar
                        navbar.style.transform = `translateY(-${navbarHeight}px)`;
                    } else {
                        // Scrolling up - show navbar
                        navbar.style.transform = 'translateY(0)';
                    }
                }
        
                lastScrollTop = scrollTop;
            });
        });
    </script>

    </body>
</html>
