<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frozen Food Premium - Kesegaran Terjaga</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine JS untuk interaksi halaman tanpa reload -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .text-frozen-dark { color: #0c4a6e; } /* Sky 900 */
        .text-frozen-primary { color: #0ea5e9; } /* Sky 500 */
        .bg-frozen-primary { background-color: #0ea5e9; }
        .bg-frozen-light { background-color: #f0f9ff; } /* Sky 50 */
    </style>
</head>
<body class="bg-white text-gray-800" x-data="{ 
    currentPage: 'home', 
    cartCount: 2,
    mobileMenuOpen: false,
    products: [
        {id: 1, name: 'Nugget Ayam Premium', price: '35.000', img: 'https://images.unsplash.com/photo-1562967914-608f2226881c?auto=format&fit=crop&q=80&w=300&h=300'},
        {id: 2, name: 'Sosis Sapi Bratwurst', price: '45.000', img: 'https://images.unsplash.com/photo-1595480670876-0d6067746592?auto=format&fit=crop&q=80&w=300&h=300'},
        {id: 3, name: 'Dimsum Ayam Udang', price: '30.000', img: 'https://images.unsplash.com/photo-1496116218417-1a781b1c423c?auto=format&fit=crop&q=80&w=300&h=300'},
        {id: 4, name: 'Kentang Goreng Crinkle', price: '28.000', img: 'https://images.unsplash.com/photo-1630384060421-a4323ce5663e?auto=format&fit=crop&q=80&w=300&h=300'},
        {id: 5, name: 'Bakso Sapi Asli', price: '50.000', img: 'https://images.unsplash.com/photo-1529692236671-f1f6cf9683ba?auto=format&fit=crop&q=80&w=300&h=300'},
        {id: 6, name: 'Kebab Frozen Mini', price: '40.000', img: 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?auto=format&fit=crop&q=80&w=300&h=300'},
        {id: 7, name: 'Cireng Rujak', price: '15.000', img: 'https://images.unsplash.com/photo-1604382354936-07c5d9983bd3?auto=format&fit=crop&q=80&w=300&h=300'},
        {id: 8, name: 'Sayuran Beku Mix', price: '25.000', img: 'https://images.unsplash.com/photo-1567306301408-9b74779a11af?auto=format&fit=crop&q=80&w=300&h=300'},
    ]
}">

    <!-- ================= NAVBAR ================= -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-sm transition-all duration-300">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="#" @click.prevent="currentPage = 'home'" class="flex items-center gap-2">
                <div class="w-10 h-10 bg-frozen-primary rounded-full flex items-center justify-center text-white">
                    <i class="fa-solid fa-snowflake text-xl"></i>
                </div>
                <div class="leading-tight">
                    <h1 class="font-bold text-xl text-frozen-dark">FrostBite</h1>
                    <p class="text-xs text-gray-500 tracking-wider">PREMIUM FROZEN</p>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex space-x-8 items-center font-medium text-gray-600">
                <a href="#" @click.prevent="currentPage = 'home'" :class="currentPage === 'home' ? 'text-frozen-primary font-bold' : 'hover:text-frozen-primary transition'">Home</a>
                <a href="#" @click.prevent="currentPage = 'about'" :class="currentPage === 'about' ? 'text-frozen-primary font-bold' : 'hover:text-frozen-primary transition'">Tentang Kami</a>
                <a href="#" @click.prevent="currentPage = 'menu'" :class="currentPage === 'menu' ? 'text-frozen-primary font-bold' : 'hover:text-frozen-primary transition'">Menu Produk</a>
                <a href="#" @click.prevent="currentPage = 'contact'" :class="currentPage === 'contact' ? 'text-frozen-primary font-bold' : 'hover:text-frozen-primary transition'">Kontak</a>
            </div>

            <!-- Icons & CTA -->
            <div class="hidden md:flex items-center gap-6">
                <!-- Icon Keranjang -->
                <a href="#" class="relative text-gray-600 hover:text-frozen-primary transition">
                    <i class="fa-solid fa-shopping-bag text-2xl"></i>
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center" x-text="cartCount"></span>
                </a>
                
                <!-- Icon User/Riwayat -->
                <a href="#" class="text-gray-600 hover:text-frozen-primary transition" title="Riwayat Order">
                    <i class="fa-regular fa-user text-2xl"></i>
                </a>

                <a href="https://wa.me/628123456789" class="bg-green-500 hover:bg-green-600 text-white px-5 py-2.5 rounded-full font-medium transition shadow-lg shadow-green-200 flex items-center gap-2">
                    <i class="fa-brands fa-whatsapp text-lg"></i> Pesan WA
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-gray-600 text-2xl focus:outline-none">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" class="md:hidden bg-white border-t border-gray-100 p-4 shadow-lg">
            <div class="flex flex-col space-y-4">
                <a href="#" @click="currentPage = 'home'; mobileMenuOpen = false" class="text-gray-600 font-medium">Home</a>
                <a href="#" @click="currentPage = 'about'; mobileMenuOpen = false" class="text-gray-600 font-medium">Tentang Kami</a>
                <a href="#" @click="currentPage = 'menu'; mobileMenuOpen = false" class="text-gray-600 font-medium">Menu Produk</a>
                <a href="#" @click="currentPage = 'contact'; mobileMenuOpen = false" class="text-gray-600 font-medium">Kontak</a>
                <hr>
                <a href="#" class="text-gray-600 font-medium flex justify-between">Keranjang <span class="bg-red-500 text-white px-2 rounded-full text-xs" x-text="cartCount"></span></a>
                <a href="#" class="text-gray-600 font-medium">Riwayat Order</a>
            </div>
        </div>
    </nav>