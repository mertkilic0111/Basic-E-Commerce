<?php require_once('admin/set/func.php');
$settings = $db->prepare("SELECT * FROM settings WHERE id=:id");
$settings->execute(['id' => 1]);
$setting = $settings->fetch(); ?>
<?php $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : []; ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Site</title>
    <link href="assets/css/tailwind.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?= $setting['favicon']; ?>" />

</head>

<body>
    <header class="bg-gradient-to-r from-blue-600 to-purple-600 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="logo">
                <div class="text-white font-bold text-2xl">
                    <a href="anasayfa.html"><img src="<?= $setting['logo']; ?>" alt="Logo" style="width: 100%;" class="h-8"></a>
                </div>
            </div>
            <nav>
                <ul id="menu" class="hidden md:flex space-x-6">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18m-6 6h6M3 6h6"></path>
                        </svg>
                        <a href="anasayfa.html" class="text-white hover:text-gray-300 transition">Anasayfa</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                        </svg>
                        <a href="sepet.html" class="text-white hover:text-gray-300 transition">Sepet</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12l9 9m-9-9l-9 9m0-9l9-9"></path>
                        </svg>
                        <a href="hakkimizda.html" class="text-white hover:text-gray-300 transition">Hakkımızda</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <a href="iletisim.html" class="text-white hover:text-gray-300 transition">İleştişim</a>
                    </li>
                </ul>
                <button id="menu-btn" class="md:hidden text-white focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </nav>
        </div>
        <div id="mobile-menu" class="hidden md:hidden bg-gradient-to-r from-blue-600 to-purple-600 p-4 transition duration-100 ease-in-out transform">
            <ul class="flex flex-col space-y-2 mt-2">
                <li class="flex items-center">
                    <svg class="w-5 h-5 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18m-6 6h6M3 6h6"></path>
                    </svg>
                    <a href="anasayfa.html" class="text-white hover:text-gray-300 transition">Anasayfa</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                    <a href="sepet.html" class="text-white hover:text-gray-300 transition">Sepet</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12l9 9m-9-9l-9 9m0-9l9-9"></path>
                    </svg>
                    <a href="hakkimizda.html" class="text-white hover:text-gray-300 transition">Hakkımızda</a>
                </li>
                <li class="flex items-center">
                    <svg class="w-5 h-5 mr-1 text-white" fill="none" stroke="currentColor" viewBox="0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <a href="iletisim.html" class="text-white hover:text-gray-300 transition">İletişim</a>
                </li>
            </ul>
        </div>
    </header>
    <script>
        document.getElementById('menu-btn').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                setTimeout(function() {
                    menu.classList.add('transform', 'translate-y-0', 'opacity-100');
                }, 10);
            } else {
                menu.classList.add('opacity-0');
                setTimeout(function() {
                    menu.classList.add('hidden');
                    menu.classList.remove('transform', 'translate-y-0', 'opacity-100', 'opacity-0');
                }, 100);
            }
        });
    </script>