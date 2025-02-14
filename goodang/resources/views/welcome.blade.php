<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Goodang - Sistem Manajemen Gudang</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-50">
  <!-- Header & Navbar -->
  <header class="bg-white shadow">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <div class="text-xl font-bold text-gray-800">Goodang</div>
      <!-- Navigasi Desktop -->
      <nav class="hidden md:flex space-x-4">
        <a href="#home" class="text-gray-600 hover:text-blue-600">Beranda</a>
        <a href="#features" class="text-gray-600 hover:text-blue-600">Fitur</a>
        <a href="#about" class="text-gray-600 hover:text-blue-600">Tentang</a>
        <a href="#contact" class="text-gray-600 hover:text-blue-600">Kontak</a>
      </nav>
      <!-- Tombol Login/Dashboard (Desktop) -->
      <div class="hidden md:block">
        @if (Route::has('login'))
          @auth
            <a href="{{ url('/dashboard') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
              Dashboard
            </a>
          @else
            <a href="{{ route('login') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
              Masuk
            </a>
          @endauth
        @endif
      </div>
      <!-- Tombol Menu Mobile -->
      <div class="md:hidden">
        <button id="menuBtn" class="text-gray-600 focus:outline-none">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
    <!-- Menu Navigasi Mobile -->
    <div id="mobileMenu" class="hidden md:hidden">
      <nav class="px-6 pb-4 space-y-1">
        <a href="#home" class="block text-gray-600 hover:text-blue-600">Beranda</a>
        <a href="#features" class="block text-gray-600 hover:text-blue-600">Fitur</a>
        <a href="#about" class="block text-gray-600 hover:text-blue-600">Tentang</a>
        <a href="#contact" class="block text-gray-600 hover:text-blue-600">Kontak</a>
        @if (Route::has('login'))
          @auth
            <a href="{{ url('/dashboard') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mt-2">
              Dashboard
            </a>
          @else
            <a href="{{ route('login') }}" class="block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mt-2">
              Masuk
            </a>
          @endauth
        @endif
      </nav>
    </div>
  </header>

  <!-- Bagian Hero / Banner Kreatif -->
  <section id="home" class="relative bg-cover bg-center" style="background-image: url('{{ asset('images/new-banner.jpg') }}');">
    <!-- Overlay dan konten banner -->
    <div class="absolute inset-0 bg-blue-900 opacity-75"></div>
    <div class="container mx-auto px-6 py-32 relative z-10 text-center">
      <h1 class="text-4xl md:text-7xl font-bold text-white drop-shadow-lg">
        Digitalisasi Manajemen Gudang Anda
      </h1>
      <p class="mt-6 text-xl md:text-2xl text-blue-200 drop-shadow">
        Goodang adalah solusi web untuk mempermudah pengelolaan aktivitas gudang secara digital.
      </p>
      <div class="mt-8 flex justify-center space-x-4">
        <a href="https://github.com/FranzOle/goodang" target="_blank" class="px-8 py-3 bg-white text-blue-600 font-semibold rounded-full hover:bg-gray-100 transition">
          Mulai
        </a>
        <a href="#about" class="px-8 py-3 border border-white text-white font-semibold rounded-full hover:bg-white hover:text-blue-600 transition">
          Pelajari Lebih Lanjut
        </a>
      </div>
    </div>
  </section>
  
  <!-- Bagian Fitur (6 Fitur Utama) -->
  <section id="features" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Keunggulan Utama</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Fitur 1: Manajemen Gudang & Barang -->
        <div class="bg-white rounded-lg shadow p-6 text-center transform hover:scale-105 transition">
          <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Manajemen Gudang & Barang</h3>
          <p class="text-gray-600">
            Tambah, edit, dan hapus data gudang serta barang dengan mudah.
          </p>
        </div>
        <!-- Fitur 2: Transaksi & Stok -->
        <div class="bg-white rounded-lg shadow p-6 text-center transform hover:scale-105 transition">
          <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16m0-16l8 8m-8-8l8-8"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Transaksi & Stok</h3>
          <p class="text-gray-600">
            Catat barang masuk, keluar, dan stok opname secara real-time.
          </p>
        </div>
        <!-- Fitur 3: Laporan & Analisis -->
        <div class="bg-white rounded-lg shadow p-6 text-center transform hover:scale-105 transition">
          <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6m-4 0h4m-4 0H5"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Laporan & Analisis</h3>
          <p class="text-gray-600">
            Dapatkan laporan detail stok, transaksi, dan kartu stok untuk keputusan tepat.
          </p>
        </div>
        <!-- Fitur 4: Cetak Label -->
        <div class="bg-white rounded-lg shadow p-6 text-center transform hover:scale-105 transition">
          <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5h6m-6 4h6m-6 4h6m-6 4h6"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Cetak Label</h3>
          <p class="text-gray-600">
            Cetak label PDF untuk barang guna memudahkan identifikasi.
          </p>
        </div>
        <!-- Fitur 5: Pengelolaan Pengguna -->
        <div class="bg-white rounded-lg shadow p-6 text-center transform hover:scale-105 transition">
          <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 14a4 4 0 10-8 0m8 0a4 4 0 01-8 0m8 0v2a4 4 0 01-8 0v-2"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Pengelolaan Pengguna</h3>
          <p class="text-gray-600">
            Registrasi dan manajemen akses pengguna untuk keamanan data.
          </p>
        </div>
        <!-- Fitur 6: Integrasi AI -->
        <div class="bg-white rounded-lg shadow p-6 text-center transform hover:scale-105 transition">
          <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-blue-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
          </div>
          <h3 class="text-xl font-semibold text-gray-800 mb-2">Integrasi AI</h3>
          <p class="text-gray-600">
            Gunakan teknologi AI terintegrasi untuk analisis prediktif dan optimalisasi operasional.
          </p>
        </div>
      </div>
    </div>
  </section>

<!-- Bagian Tentang dengan Carousel Otomatis -->
<section id="about" class="py-16">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row items-center">
        <!-- Carousel & Konten Teks -->
        <div class="w-full md:w-1/2">
          <div id="about-carousel" class="relative overflow-hidden">
            <!-- Carousel Wrapper (Flex Container) -->
            <div id="carousel-wrapper" class="flex transition-transform duration-500">
              <!-- Slide 1 -->
              <div class="about-slide w-full flex-shrink-0 p-4">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Tentang Goodang</h2>
                <p class="text-base sm:text-lg text-gray-600 mb-6">
                  Goodang adalah aplikasi berbasis web untuk mempermudah pengelolaan aktivitas gudang secara digital. Dengan fitur canggih seperti integrasi AI, free API, dan dukungan aplikasi Flutter, Goodang membantu Anda mengelola gudang dengan lebih efisien dan modern.
                </p>
              </div>
              <!-- Slide 2 -->
              <div class="about-slide w-full flex-shrink-0 p-4">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Sejarah Pengembangan</h2>
                <p class="text-base sm:text-lg text-gray-600 mb-6">
                  Dimulai dari kebutuhan nyata di dunia logistik, Goodang telah berkembang secara berkelanjutan untuk menjawab tantangan pengelolaan gudang digital dengan inovasi dan teknologi terkini.
                </p>
              </div>
              <!-- Slide 3 -->
              <div class="about-slide w-full flex-shrink-0 p-4">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Visi &amp; Misi</h2>
                <p class="text-base sm:text-lg text-gray-600 mb-6">
                  Visi kami adalah menciptakan solusi manajemen gudang terintegrasi yang efisien dan inovatif, sedangkan misi kami adalah menyediakan platform yang mudah digunakan dan selalu diperbarui sesuai kebutuhan pasar.
                </p>
              </div>
              <!-- Slide 4 -->
              <div class="about-slide w-full flex-shrink-0 p-4">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">Inovasi dan Pengembangan</h2>
                <p class="text-base sm:text-lg text-gray-600 mb-6">
                  Dengan mengintegrasikan teknologi AI dan API gratis, Goodang terus berinovasi agar setiap proses operasional gudang berjalan optimal dan akurat, mendukung pertumbuhan bisnis Anda.
                </p>
              </div>
            </div>
          </div>
          <!-- Tombol "Hubungi Kami" -->
          <div class="mt-4 text-center">
            <a href="https://wa.me/6289514590179?text=Hai!%20Saya%20tertarik%20memakai%20aplikasi%20ini." target="_blank" class="inline-block px-6 py-3 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
              Hubungi Kami
            </a>
          </div>
        </div>
        <!-- Gambar -->
        <div class="w-full md:w-1/2 mt-8 md:mt-0">
          <img src="{{ asset('images/gudang.jpg') }}" alt="Gambar Gudang" class="rounded-lg shadow w-full" />
        </div>
      </div>
    </div>
  </section>
  <!-- Bagian Kontak (Form Kontak) -->
  <section id="contact" class="py-20 bg-gray-100">
    <div class="container mx-auto px-6">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">Hubungi Kami</h2>
      <div class="max-w-xl mx-auto">
        <form id="contactForm" action="mailto:lionel@societyco.com" method="post" enctype="text/plain" class="bg-white p-8 rounded-lg shadow">
          <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="name">Nama</label>
            <input class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" type="text" id="name" name="name" placeholder="Nama Anda" required>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="email">Email</label>
            <input class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" type="email" id="email" name="email" placeholder="Email Anda" required>
          </div>
          <div class="mb-4">
            <label class="block text-gray-700 mb-2" for="message">Pesan</label>
            <textarea class="w-full px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-600" id="message" name="message" rows="4" placeholder="Pesan Anda" required></textarea>
          </div>
          <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            Kirim Pesan
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- Expanded Footer -->
  <footer class="bg-white dark:bg-gray-900">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
      <div class="md:flex md:justify-between">
        <div class="mb-6 md:mb-0">
          <a href="https://www.instagram.com/societycoid/" class="flex items-center">
            <img src="{{ asset('images/society-logo.png') }}" class="h-8 mr-3" alt="Goodang Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Goodang</span>
          </a>
        </div>
        <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
          <div>
            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Source</h2>
            <ul class="text-gray-500 dark:text-gray-400 font-medium">
              <li class="mb-4">
                <a href="https://github.com/FranzOle/goodang" class="hover:underline">Goodang GitHub</a>
              </li>
              <li>
                <a href="https://tailwindcss.com/" class="hover:underline">Tailwind CSS</a>
              </li>
            </ul>
          </div>
          <div>
            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Ikuti Kami</h2>
            <ul class="text-gray-500 dark:text-gray-400 font-medium">
              <li class="mb-4">
                <a href="https://github.com/FranzOle" class="hover:underline">GitHub</a>
              </li>
              <li class="mb-4">
                <a href="#" class="hover:underline">Discord</a>
              </li>
              <li>
                <a href="#" class="hover:underline">Instagram</a>
              </li>
            </ul>
          </div>
          <div>
            <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
            <ul class="text-gray-500 dark:text-gray-400 font-medium">
              <li class="mb-4">
                <a href="#" class="hover:underline">Kebijakan Privasi</a>
              </li>
              <li>
                <a href="#" class="hover:underline">Syarat &amp; Ketentuan</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="#" class="hover:underline">Goodang™</a>. Semua Hak Dilindungi.</span>
        <div class="flex mt-4 sm:justify-center sm:mt-0">
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
              <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
            </svg>
            <span class="sr-only">Halaman Facebook</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ml-5">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 21 16">
              <path d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418.33-.544.328-1.116.606-1.71.832a12.52 12.52 0 0 0 1.084 1.785 16.46 16.46 0 0 0 5.064-2.595 17.286 17.286 0 0 0-2.973-11.59ZM6.678 10.813a1.941 1.941 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.919 1.919 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Zm6.644 0a1.94 1.94 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.918 1.918 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Z"/>
            </svg>
            <span class="sr-only">Komunitas Discord</span>
          </a>
          <a href="#" class="text-gray-500 hover:text-gray-900 dark:hover:text-white ml-5">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
              <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
            </svg>
            <span class="sr-only">Akun Dribbble</span>
          </a>
        </div>
      </div>
      <!-- Link untuk membuka modal panduan -->
      <div class="text-center mt-4">
        <a href="#" id="openModal" class="text-blue-600 font-medium hover:underline">Lihat Panduan Penggunaan</a>
      </div>
    </div>
  </footer>

  <!-- Modal Panduan dengan Paginasi -->
  <div id="rulesModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg max-w-3xl w-full p-6 relative">
      <!-- Tombol Close -->
      <button id="closeModal" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
      <!-- Konten Modal (dibagi per halaman) -->
      <div id="modalPages">
        <!-- Halaman 1: Pengenalan -->
        <div class="modal-page">
          <h2 class="text-2xl font-bold mb-4">I. Pengenalan</h2>
          <p class="text-gray-700">
            Goodang adalah aplikasi berbasis web yang mempermudah pengelolaan aktivitas gudang secara digital. Dengan Goodang, Anda dapat melakukan pencatatan, pelacakan, dan analisis aktivitas barang mulai dari penerimaan hingga pengiriman.
          </p>
        </div>
        <!-- Halaman 2: Panduan Penggunaan (Public Side) -->
        <div class="modal-page hidden">
          <h2 class="text-2xl font-bold mb-4">II. Panduan Penggunaan</h2>
          <ul class="list-disc ml-6 text-gray-700 space-y-2">
            <li><strong>Login & Dashboard:</strong> Masuk menggunakan username dan password, lalu dashboard menampilkan ringkasan stok dan transaksi.</li>
            <li><strong>Manajemen Barang:</strong> Tambah, edit, atau hapus data barang. Perhatian: Penghapusan barang akan mempengaruhi catatan log transaksi.</li>
            <li><strong>Manajemen Gudang:</strong> Tambah, edit, atau hapus data gudang. Gudang tidak dapat dihapus jika masih terkait dengan barang atau transaksi.</li>
            <li><strong>Transaksi Barang:</strong> Catat barang masuk, keluar, dan stok opname untuk update stok secara real-time.</li>
            <li><strong>Laporan:</strong> Akses laporan stok, transaksi, dan kartu stok untuk analisis mendalam.</li>
            <li><strong>Cetak Label:</strong> Cetak label PDF dengan barcode untuk identifikasi barang.</li>
            <li><strong>Pengelolaan Pengguna:</strong> Admin dapat mengelola akun pengguna dan izin akses.</li>
            <li><strong>Integrasi API & Flutter:</strong> Gunakan API gratis dan dukungan aplikasi Flutter untuk integrasi sistem.</li>
          </ul>
        </div>
        <!-- Halaman 3: Panduan Teknis (Technical Side) -->
        <div class="modal-page hidden">
          <h2 class="text-2xl font-bold mb-4">III. Panduan Teknis</h2>
          <ul class="list-disc ml-6 text-gray-700 space-y-2">
            <li><strong>Mekanisme Login:</strong> Sistem memverifikasi username dan password, lalu mengarahkan ke dashboard jika valid.</li>
            <li><strong>Struktur Database:</strong> Data disimpan dalam tabel seperti <code>users</code>, <code>warehouses</code>, <code>items</code>, <code>transactions</code>, dan <code>suppliers</code>.</li>
            <li><strong>Logging & Validasi:</strong> Setiap perubahan, terutama penghapusan, dicatat dalam log. Data tidak bisa dihapus jika masih terhubung dengan transaksi lain.</li>
            <li><strong>Notifikasi:</strong> Sistem mengirim notifikasi saat stok mencapai batas minimum atau terjadi transaksi penting.</li>
            <li><strong>Keamanan Akses:</strong> Pengelolaan peran dan izin akses dilakukan secara ketat untuk menjaga integritas data.</li>
          </ul>
        </div>
        <!-- Halaman 4: Catatan Penting -->
        <div class="modal-page hidden">
          <h2 class="text-2xl font-bold mb-4">IV. Catatan Penting</h2>
          <p class="text-gray-700">
            Sebelum menghapus data (barang, gudang, atau supplier), pastikan tidak ada keterkaitan dengan transaksi lain agar catatan log tetap utuh. Untuk modifikasi besar, diskusikan dengan tim teknis.
          </p>
        </div>
      </div>
      <!-- Tombol Navigasi Modal -->
      <div class="flex justify-between mt-6">
        <button id="prevBtn" class="px-4 py-2 bg-gray-200 rounded disabled:opacity-50" disabled>Sebelumnya</button>
        <button id="nextBtn" class="px-4 py-2 bg-blue-600 text-white rounded">Berikutnya</button>
      </div>
    </div>
  </div>

  <!-- JavaScript -->
  <script>
    // Toggle menu mobile
    document.getElementById('menuBtn').addEventListener('click', function() {
      var mobileMenu = document.getElementById('mobileMenu');
      mobileMenu.classList.toggle('hidden');
    });

    // Modal Paginasi
    const modalPages = document.querySelectorAll('.modal-page');
    let currentPage = 0;
    const totalPages = modalPages.length;
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');

    function updateModalPages() {
      modalPages.forEach((page, index) => {
        page.classList.toggle('hidden', index !== currentPage);
      });
      prevBtn.disabled = currentPage === 0;
      if (currentPage === totalPages - 1) {
        nextBtn.textContent = "Tutup";
      } else {
        nextBtn.textContent = "Berikutnya";
      }
    }
    
    nextBtn.addEventListener('click', function() {
      if (currentPage === totalPages - 1) {
        // Tutup modal jika di halaman terakhir
        document.getElementById('rulesModal').classList.add('hidden');
        currentPage = 0; // reset ke halaman pertama
        updateModalPages();
      } else {
        currentPage++;
        updateModalPages();
      }
    });

    prevBtn.addEventListener('click', function() {
      if (currentPage > 0) {
        currentPage--;
        updateModalPages();
      }
    });

    // Buka modal
    document.getElementById('openModal').addEventListener('click', function(e) {
      e.preventDefault();
      document.getElementById('rulesModal').classList.remove('hidden');
      currentPage = 0;
      updateModalPages();
    });

    // Tutup modal ketika klik di luar konten modal
    window.addEventListener('click', function(e) {
      const modal = document.getElementById('rulesModal');
      if (e.target === modal) {
        modal.classList.add('hidden');
      }
    });

    // Tombol close modal
    document.getElementById('closeModal').addEventListener('click', function() {
      document.getElementById('rulesModal').classList.add('hidden');
    });

    const carouselWrapper = document.getElementById("carousel-wrapper");
  const slides = document.querySelectorAll("#about-carousel .about-slide");
  const totalSlides = slides.length;
  let currentSlide = 0;
  
  // Fungsi untuk mengubah posisi wrapper
  function showSlide(index) {
    carouselWrapper.style.transform = `translateX(-${index * 100}%)`;
  }
  
  // Ganti slide setiap 5 detik
  setInterval(() => {
    currentSlide = (currentSlide + 1) % totalSlides;
    showSlide(currentSlide);
  }, 5000);
    
  </script>
</body>
</html>
