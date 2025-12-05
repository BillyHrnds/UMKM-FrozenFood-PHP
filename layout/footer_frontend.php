    <!-- ================= FOOTER (UMUM) ================= -->
    <footer class="bg-frozen-dark text-white pt-16 pb-8">
        <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
            <!-- Brand -->
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-8 h-8 bg-frozen-primary rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-snowflake"></i>
                    </div>
                    <span class="text-xl font-bold">FrostBite</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Menyediakan frozen food berkualitas premium, halal, dan higienis untuk keluarga Indonesia.
                </p>
            </div>
            <!-- Link -->
            <div>
                <h3 class="font-bold mb-4">Navigasi</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" @click.prevent="currentPage = 'home'" class="hover:text-frozen-primary">Home</a></li>
                    <li><a href="#" @click.prevent="currentPage = 'menu'" class="hover:text-frozen-primary">Menu</a></li>
                    <li><a href="#" @click.prevent="currentPage = 'about'" class="hover:text-frozen-primary">Tentang Kami</a></li>
                    <li><a href="#" @click.prevent="currentPage = 'contact'" class="hover:text-frozen-primary">Kontak</a></li>
                </ul>
            </div>
            <!-- Link -->
            <div>
                <h3 class="font-bold mb-4">Bantuan</h3>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="#" class="hover:text-frozen-primary">Cara Order</a></li>
                    <li><a href="#" class="hover:text-frozen-primary">Info Pengiriman</a></li>
                    <li><a href="#" class="hover:text-frozen-primary">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="hover:text-frozen-primary">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <!-- Sosmed -->
            <div>
                <h3 class="font-bold mb-4">Ikuti Kami</h3>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-frozen-primary transition"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-frozen-primary transition"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-gray-700 flex items-center justify-center hover:bg-frozen-primary transition"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 pt-8 text-center text-gray-500 text-sm">
            &copy; 2023 FrostBite Frozen Food. All rights reserved.
        </div>
    </footer>

</body>
</html>