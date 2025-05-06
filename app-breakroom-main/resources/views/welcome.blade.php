<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Breakroom Billiards</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.12/typed.min.js"></script>
    <style>
        .video-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        .video-background {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            object-fit: cover;
        }

        .scroll-down {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            animation: bounce 2s infinite;
            z-index: 20;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0) translateX(-50%);
            }
            40% {
                transform: translateY(-30px) translateX(-50%);
            }
            60% {
                transform: translateY(-15px) translateX(-50%);
            }
        }

        .glass-effect {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .gradient-text {
            background: linear-gradient(to right, #F59E0B, #D97706);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
    </style>
</head>

<body class="overflow-x-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-effect">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                <img src="{{ asset('photos/breakroom.png') }}" alt="Breakroom Logo"
                    class="h-16 w-16 rounded-lg object-contain" />
                    <span class="ml-3 text-xl font-bold gradient-text">Breakroom</span>
                </div>
                
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold px-6 py-2 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-300 hover:text-yellow-400 px-3 py-2 rounded-md transition-colors duration-200">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold px-6 py-2 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative h-screen">
        <!-- Video Background -->
        <div class="video-container">
            <video autoplay muted loop playsinline class="video-background">
                <source src="{{ asset('videos/index.mp4') }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-20 flex flex-col items-center justify-center h-full text-white px-4">
            <div class="mb-8 transform hover:scale-110 transition-transform duration-300" data-aos="fade-down">
                <img src="{{ asset('photos/breakroom.png') }}" alt="Breakroom Logo" class="w-32 h-32 rounded-2xl shadow-2xl"/>
            </div>

            <h1 class="text-6xl md:text-7xl lg:text-8xl font-bold mb-4 text-center gradient-text" data-aos="fade-down">
                Welcome to Breakroom
            </h1>

            <div class="h-12 mb-8" data-aos="fade-up" data-aos-delay="200">
                <span id="typed" class="text-xl md:text-2xl text-gray-300"></span>
            </div>

            <!-- CTA Buttons -->
            <div class="flex space-x-4 md:space-x-6" data-aos="fade-up" data-aos-delay="400">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold px-8 py-4 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transform hover:scale-105 transition-all duration-300">
                            Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold px-8 py-4 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transform hover:scale-105 transition-all duration-300">
                            Get Started
                        </a>
                        <a href="{{ route('register') }}" class="bg-black/30 backdrop-blur-md px-8 py-4 rounded-lg font-bold border border-yellow-400/30 hover:bg-black/50 transform hover:scale-105 transition-all duration-300">
                            Learn More
                        </a>
                    @endauth
                @endif
            </div>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-yellow-400 text-center">
            <p class="mb-2 text-sm font-medium">Discover More</p>
            <svg class="w-6 h-6 mx-auto animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 px-4 glass-effect">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16 gradient-text">Experience Excellence</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Premium Tables -->
                <div class="relative group" data-aos="fade-up" data-aos-delay="100">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 to-yellow-600/10 rounded-xl transform -rotate-1"></div>
                    <div class="relative glass-effect rounded-xl p-6 transform transition-all duration-300 hover:scale-105">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-yellow-400">Premium Tables</h3>
                        <p class="text-gray-300">Experience the game on our professional-grade tables, maintained to perfection for optimal play.</p>
                    </div>
                </div>

                <!-- Events & Tournaments -->
                <div class="relative group" data-aos="fade-up" data-aos-delay="200">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 to-yellow-600/10 rounded-xl transform rotate-1"></div>
                    <div class="relative glass-effect rounded-xl p-6 transform transition-all duration-300 hover:scale-105">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-yellow-400">Events & Tournaments</h3>
                        <p class="text-gray-300">Join our regular tournaments and special events designed for players of all skill levels.</p>
                    </div>
                </div>

                <!-- Food & Drinks -->
                <div class="relative group" data-aos="fade-up" data-aos-delay="300">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 to-yellow-600/10 rounded-xl transform -rotate-1"></div>
                    <div class="relative glass-effect rounded-xl p-6 transform transition-all duration-300 hover:scale-105">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-yellow-400">Food & Drinks</h3>
                        <p class="text-gray-300">Enjoy our extensive menu of refreshments and gourmet snacks while you play.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Maps Section -->
    <div class="py-20 px-4">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16 gradient-text" data-aos="fade-up">Find Us</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Map -->
                <div class="glass-effect rounded-xl overflow-hidden shadow-xl" data-aos="fade-right">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d247.89538186910138!2d106.61569400939328!3d-6.255277406837808!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNsKwMTUnMTkuMCJTIDEwNsKwMzYnNTYuNSJF!5e0!3m2!1sen!2sid!4v1704348060435!5m2!1sen!2sid"
                        width="100%"
                        height="400"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        class="rounded-xl">
                    </iframe>
                </div>

                <!-- Contact Information Box -->
                <div class="relative group" data-aos="fade-left">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 to-yellow-600/10 rounded-xl transform -rotate-1"></div>
                    <div class="relative glass-effect rounded-xl p-8 h-[400px] flex flex-col justify-between">
                        <!-- Header -->
                        <div class="text-center mb-6">
                            <div class="w-20 h-20 mx-auto mb-4 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold gradient-text">Contact Us</h3>
                        </div>

                        <!-- Contact Details -->
                        <div class="space-y-6 flex-grow">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-gray-300">Jl. Scientia Square Utara, Curug Sangereng, Kec. Klp. Dua, Kabupaten Tangerang, Banten 15810</p>
                            </div>

                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-300">info@breakroom.com</p>
                                    <p class="text-gray-400 text-sm">For general inquiries</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-gray-800 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-gray-300">0813-1999-0246</p>
                                    <p class="text-gray-400 text-sm">Mon-Sun 10:00 AM - 00:00 AM</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="text-center mt-11">
                            <a href="#" class="inline-block bg-gradient-to-r from-yellow-400 to-yellow-600 text-black font-bold px-6 py-3 rounded-lg hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200">
                                Book a Table Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="glass-effect py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Company Info -->
                <div>
                    <div class="flex items-center mb-6">
                        <img src="{{ asset('photos/breakroom.png') }}" alt="Breakroom Logo" class="h-10 w-10 rounded-lg object-contain"/>
                        <h4 class="ml-3 text-2xl font-bold gradient-text">Breakroom</h4>
                    </div>
                    <p class="text-gray-300 mb-4">Experience premium billiards in a sophisticated atmosphere. Join us for an unforgettable gaming experience.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center hover:scale-110 transition-transform duration-200">
                            <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center hover:scale-110 transition-transform duration-200">
                            <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"></path>
                            </svg>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gradient-to-r from-yellow-400 to-yellow-600 rounded-lg flex items-center justify-center hover:scale-110 transition-transform duration-200">
                            <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-2xl font-bold mb-6 gradient-text">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="#" class="text-gray-300 hover:text-yellow-400 transition-colors duration-300">About Us</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-yellow-400 transition-colors duration-300">Events</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-yellow-400 transition-colors duration-300">Membership</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-yellow-400 transition-colors duration-300">Contact</a></li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="text-2xl font-bold mb-6 gradient-text">Newsletter</h4>
                    <p class="text-gray-300 mb-4">Subscribe to our newsletter for updates and exclusive offers.</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Enter your email" class="flex-grow px-4 py-2 rounded-lg bg-gray-900/50 border border-gray-700 text-white focus:ring-2 focus:ring-yellow-400 focus:border-transparent">
                        <button type="submit" class="bg-gradient-to-r from-yellow-400 to-yellow-600 text-black px-6 py-2 rounded-lg font-semibold hover:from-yellow-500 hover:to-yellow-700 transition-all duration-200">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-700/50 mt-12 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 Breakroom. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize AOS
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100
            });

            // Initialize Typed.js
            new Typed('#typed', {
                strings: [
                    "Where Champions Are Made 🏆",
                    "Professional Tables Await You 🎱",
                    "Join Our Weekly Tournaments 🎯",
                    "Exclusive Member Benefits 💎",
                    "Book Your Table Online 24/7 ⚡",
                    "Experience Premium Billiards 🌟"
                ],
                typeSpeed: 50,
                backSpeed: 30,
                backDelay: 2000,
                loop: true,
                showCursor: true
            });

            // Smooth scroll functionality
            document.querySelector('.scroll-down').addEventListener('click', function(e) {
                e.preventDefault();
                const nextSection = document.querySelector('.py-20');
                nextSection.scrollIntoView({ behavior: 'smooth' });
            });

            // Add scroll-based animations for navbar
            const nav = document.querySelector('nav');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    nav.classList.add('backdrop-blur-lg');
                    nav.classList.add('border-gray-700/50');
                } else {
                    nav.classList.remove('backdrop-blur-lg');
                    nav.classList.remove('border-gray-700/50');
                }
            });

            // Handle newsletter form submission
            const newsletterForm = document.querySelector('form');
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const emailInput = this.querySelector('input[type="email"]');
                if (emailInput.value) {
                    showToast('Thank you for subscribing!', 'success');
                    emailInput.value = '';
                } else {
                    showToast('Please enter a valid email', 'error');
                }
            });

            // Toast notification function
            function showToast(message, type = 'success') {
                const toast = document.createElement('div');
                toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg text-white ${
                    type === 'success' ? 'bg-green-500' : 'bg-red-500'
                } transform transition-transform duration-300 ease-in-out z-50`;
                toast.textContent = message;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.transform = 'translateY(-20px)';
                }, 100);

                setTimeout(() => {
                    toast.style.transform = 'translateY(100px)';
                    setTimeout(() => {
                        document.body.removeChild(toast);
                    }, 300);
                }, 3000);
            }
        });
    </script>
</body>
</html>