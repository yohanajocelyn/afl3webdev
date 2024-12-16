<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>
    <body class="bg-gray-100 pt-[4.5rem]">

    <!-- Header -->
    <x-navigation></x-navigation>

        {{ $slot }}

    <!-- Footer -->
    <x-footer></x-footer>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('navbar');
            
            window.addEventListener('scroll', function() {
                // Adjust opacity based on scroll position
                const scrollPosition = window.scrollY;
                const maxScroll = 200; // Adjust this value to control when full transparency occurs
                
                if (scrollPosition > 0) {
                    // Calculate opacity
                    const opacity = Math.max(0.3, 1 - (scrollPosition / maxScroll));
                    
                    navbar.style.backgroundColor = `rgba(255, 255, 255, ${opacity})`;
                    navbar.style.backdropFilter = scrollPosition > 0 ? 'blur(5px)' : 'none';
                    
                    // Optional: Reduce shadow as we scroll
                    navbar.classList.toggle('shadow-md', scrollPosition < 50);
                    navbar.classList.toggle('shadow-sm', scrollPosition >= 50);
                } else {
                    // Reset to default when at top of page
                    navbar.style.backgroundColor = 'rgba(255, 255, 255, 1)';
                    navbar.style.backdropFilter = 'none';
                    navbar.classList.add('shadow-md');
                }
            });
        });
    </script> --}}

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

