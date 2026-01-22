{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        @if (Route::has('login'))
            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                @auth
                    <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <!-- Cart Sidebar -->
        <div id="cartSidebar" class="fixed top-0 right-0 w-80 h-full bg-white shadow-lg p-4 transform translate-x-full transition-transform z-50">
            <h2 class="font-bold text-lg mb-4">Your Cart</h2>
            <div id="cartItems" class="space-y-2">
                <p class="text-gray-500">Cart is empty</p>
            </div>

            <div id="guestInfo" class="mt-4">
    <input type="text" id="guestName" placeholder="Your Name" class="w-full mb-2 p-2 border rounded">
    <input type="email" id="guestEmail" placeholder="Your Email" class="w-full mb-2 p-2 border rounded">
</div>


            <button onclick="checkoutCart()" class="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Checkout</button>
        </div>

        <!-- Cart Button -->
        <button id="cartBtn" class="fixed bottom-6 right-6 bg-blue-600 text-white p-4 rounded-full shadow-lg z-50">
            🛒 <span id="cartCount">0</span>
        </button>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($products as $product)
                    <div class="bg-white shadow p-4 rounded-lg text-center">
                        <h2 class="font-bold text-lg mb-2">{{ $product->name }}</h2>
                        <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="mx-auto mb-2 h-48 object-cover">
                        <p class="text-gray-700 mb-1">${{ $product->price }}</p>
                        <p class="text-gray-500 text-sm mb-2">{{ $product->description }}</p>
                        <button onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})" class="bg-green-500 text-white py-1 px-3 rounded hover:bg-green-600">Add to Cart</button>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        const cartBtn = document.getElementById('cartBtn');
        const cartSidebar = document.getElementById('cartSidebar');
        const cartItems = document.getElementById('cartItems');
        const cartCount = document.getElementById('cartCount');

        cartBtn.addEventListener('click', () => {
            cartSidebar.classList.toggle('translate-x-full');
        });

        function addToCart(id, name, price) {
            const existing = cart.find(item => item.id === id);
            if (existing) {
                existing.qty++;
            } else {
                cart.push({ id, name, price, qty: 1 });
            }
            updateCart();
        }

        function updateCart() {
            cartCount.textContent = cart.reduce((sum, item) => sum + item.qty, 0);
            if (cart.length === 0) {
                cartItems.innerHTML = '<p class="text-gray-500">Cart is empty</p>';
                return;
            }
            cartItems.innerHTML = '';
            cart.forEach(item => {
                const div = document.createElement('div');
                div.className = 'flex justify-between items-center';
                div.innerHTML = `
                    <span>${item.name} x${item.qty}</span>
                    <span>$${item.price * item.qty}</span>
                `;
                cartItems.appendChild(div);
            });
        }

        function checkoutCart() {
            if(cart.length === 0) {
                alert('Cart is empty!');
                return;
            }
            // Example: just log cart for now
            console.log(cart);
            alert('Proceeding to checkout...');
        }

        function checkoutCart() {
    if(cart.length === 0) {
        alert('Cart is empty!');
        return;
    }

    // Grab guest info
    const name = document.getElementById('guestName').value;
    const email = document.getElementById('guestEmail').value;

    if(!name || !email) {
        alert('Please enter your name and email.');
        return;
    }

    fetch('/checkout/cart', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ cart, name, email })
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            window.location.href = data.checkoutUrl; // Redirect to Flutterwave
        } else {
            alert('Checkout failed. Try again.');
        }
    });
}

    </script>
</body>

</html> --}}




<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>M-Exmu</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        </style>

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            .auth-links {
                position: fixed;
                top: 0;
                right: 0;
                padding: 1rem 1.5rem;
                z-index: 50;
                color: white;
            }

            .auth-links a {
                margin-left: 1rem;
                text-decoration: underline;
                color: white;
                font-size: 0.875rem;
            }
            .construction-container {
            width: 100%;
            height: 100vh;
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            perspective: 1000px;
            }

            .construction-content {
            position: relative;
            z-index: 10;
            text-align: center;
            }

            /* 3D Cubes */
            .cubes-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            }

            .cube {
            position: absolute;
            width: 100px;
            height: 100px;
            transform-style: preserve-3d;
            animation: float 6s ease-in-out infinite;
            }

            .cube-1 {
            top: 20%;
            left: 15%;
            animation-delay: 0s;
            animation-duration: 8s;
            }

            .cube-2 {
            top: 60%;
            right: 20%;
            animation-delay: 2s;
            animation-duration: 10s;
            }

            .cube-3 {
            bottom: 15%;
            left: 50%;
            animation-delay: 4s;
            animation-duration: 12s;
            }

            .cube-face {
            position: absolute;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            }

            .cube-face.front {
            transform: translateZ(50px);
            }

            .cube-face.back {
            transform: translateZ(-50px) rotateY(180deg);
            }

            .cube-face.left {
            transform: rotateY(-90deg) translateZ(50px);
            }

            .cube-face.right {
            transform: rotateY(90deg) translateZ(50px);
            }

            .cube-face.top {
            transform: rotateX(90deg) translateZ(50px);
            }

            .cube-face.bottom {
            transform: rotateX(-90deg) translateZ(50px);
            }

            @keyframes float {
            0%, 100% {
                transform: translateY(0) rotateX(0deg) rotateY(0deg);
            }
            25% {
                transform: translateY(-30px) rotateX(180deg) rotateY(90deg);
            }
            50% {
                transform: translateY(-60px) rotateX(360deg) rotateY(180deg);
            }
            75% {
                transform: translateY(-30px) rotateX(540deg) rotateY(270deg);
            }
            }

            /* Text Content */
            .text-content {
            position: relative;
            z-index: 20;
            animation: fadeInUp 1s ease-out;
            }

            .main-title {
            font-size: 4rem;
            font-weight: 300;
            background: linear-gradient(135deg, #ffffff 0%, #a0a0a0 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            letter-spacing: 0.05em;
            animation: shimmer 3s ease-in-out infinite;
            }

            .subtitle {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 2rem;
            font-weight: 300;
            letter-spacing: 0.1em;
            min-height: 2rem;
            }

            @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
            }

            @keyframes shimmer {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            }

            /* Progress Bar */
            .progress-bar {
            width: 300px;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            border-radius: 2px;
            }

            .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, transparent, #ffffff, transparent);
            animation: progress 2s ease-in-out infinite;
            width: 50%;
            }

            @keyframes progress {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(300%);
            }
            }

            /* Floating Particles */
            .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            }

            .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: rise linear infinite;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            }

            @keyframes rise {
            0% {
                bottom: -10px;
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                bottom: 110%;
                opacity: 0;
            }
            }

            /* Responsive Design */
            @media (max-width: 768px) {
            .main-title {
                font-size: 2.5rem;
            }

            .subtitle {
                font-size: 1rem;
            }

            .cube {
                width: 60px;
                height: 60px;
            }

            .cube-face {
                width: 60px;
                height: 60px;
            }

            .cube-face.front {
                transform: translateZ(30px);
            }

            .cube-face.back {
                transform: translateZ(-30px) rotateY(180deg);
            }

            .cube-face.left {
                transform: rotateY(-90deg) translateZ(30px);
            }

            .cube-face.right {
                transform: rotateY(90deg) translateZ(30px);
            }

            .cube-face.top {
                transform: rotateX(90deg) translateZ(30px);
            }

            .cube-face.bottom {
                transform: rotateX(-90deg) translateZ(30px);
            }

            .progress-bar {
                width: 200px;
            }
            }

</style>
    </head>
    <body>

        @if (Route::has('login'))
            <div class="auth-links" style="color:white">
                @auth
                    <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline" style="color:white">Home</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline" style="color:white">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline" style="color:white">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="construction-container">
                <div class="construction-content">

                    <!-- 3D Floating Cubes -->
                    <div class="cubes-container">
                        <div class="cube cube-1">
                            <div class="cube-face front"></div>
                            <div class="cube-face back"></div>
                            <div class="cube-face left"></div>
                            <div class="cube-face right"></div>
                            <div class="cube-face top"></div>
                            <div class="cube-face bottom"></div>
                        </div>

                        <div class="cube cube-2">
                            <div class="cube-face front"></div>
                            <div class="cube-face back"></div>
                            <div class="cube-face left"></div>
                            <div class="cube-face right"></div>
                            <div class="cube-face top"></div>
                            <div class="cube-face bottom"></div>
                        </div>

                        <div class="cube cube-3">
                            <div class="cube-face front"></div>
                            <div class="cube-face back"></div>
                            <div class="cube-face left"></div>
                            <div class="cube-face right"></div>
                            <div class="cube-face top"></div>
                            <div class="cube-face bottom"></div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="text-content">
                        <h1 class="main-title">Under Construction</h1>
                        <p class="subtitle">
                            We're building something amazing<span id="dots"></span>
                        </p>

                        <div class="progress-bar">
                            <div class="progress-fill"></div>
                        </div>
                    </div>

                    <!-- Floating Particles -->
                    <div class="particles">
                        <!-- JS will inject particles here -->
                    </div>

                </div>
            </div>
        
    </body>
</html>
