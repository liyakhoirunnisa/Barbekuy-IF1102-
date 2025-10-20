<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.iconify.design/3/3.1.0/iconify.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Header Sticky -->
    <header class="sticky top-0 left-0 w-full bg-[#7B0D1E] text-white py-4 px-4 flex items-center justify-center shadow-md z-50">
        <!-- Tombol Kembali -->
        <button 
            onclick="window.history.back()" 
            class="absolute left-4 top-1/2 -translate-y-1/2 w-9 h-9 flex items-center justify-center rounded-full bg-white/15 hover:bg-white/25 transition">
            <span class="iconify text-xl text-white" data-icon="mdi:chevron-left"></span>
        </button>

        <!-- Judul -->
        <h1 class="text-lg font-semibold">Pemesanan</h1>
    </header>

    <!-- Konten -->
    <main class="max-w-3xl mx-auto p-6 space-y-6 pt-4">

        <!-- Produk -->
        <div class="bg-white rounded-2xl shadow p-4">
            <div class="flex items-center mb-3">
                <span class="iconify text-gray-500 text-xl mr-2" data-icon="solar:cart-3-outline"></span>
                <h2 class="font-semibold text-gray-700">Produk:</h2>
            </div>

            <div class="flex items-center gap-4 border rounded-xl p-3">
                <img src="{{ asset('images/ber4extra.png') }}" alt="Produk" class="w-24 h-24 object-cover rounded-lg">
                <div class="flex-1">
                    <h3 class="font-semibold text-lg text-gray-800">Paket Slice Ber-4 Xtra</h3>
                    <div class="flex items-center gap-1 text-gray-500 text-sm">
                        <span class="iconify" data-icon="mdi:calendar-range"></span>
                        <p>Tanggal 6–7 Okt 2025</p>
                    </div>
                    <p class="text-sm text-green-600 flex items-center gap-1">
                        <span class="iconify" data-icon="mdi:check-circle-outline"></span> Tersedia
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-[#7B0D1E] font-bold">Rp245.000</p>
                    <p class="text-sm text-gray-500">x1</p>
                </div>
            </div>

            <div class="flex justify-between items-center mt-3 border-t pt-2 text-gray-700">
                <span>Total 1 Produk</span>
                <span class="font-semibold">Rp245.000</span>
            </div>

            <div class="mt-3">
                <button id="togglePesan" 
                        class="text-gray-500 text-sm flex items-center gap-1 hover:text-[#7B0D1E] transition">
                    <span class="iconify" data-icon="mdi:message-text-outline"></span>
                    Tinggalkan Pesan
                </button>
                <textarea id="pesanTextarea" 
                          class="hidden w-full border border-gray-300 bg-gray-50 rounded-lg mt-2 p-2 text-sm text-gray-700 focus:bg-white focus:ring-[#7B0D1E] focus:border-[#7B0D1E]" 
                          placeholder="Contoh: Akan saya ambil siang"></textarea>
            </div>
        </div>

        <!-- Lokasi Pengambilan -->
        <div class="bg-white rounded-2xl shadow p-4">
            <div class="flex items-center mb-3">
                <span class="iconify text-gray-500 text-xl mr-2" data-icon="mdi:map-marker-outline"></span>
                <h2 class="font-semibold text-gray-700">Lokasi Pengambilan</h2>
            </div>
            <p class="text-gray-600 text-sm">
                Sumampir Kulon, Sumampir, Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125
            </p>
        </div>

        <!-- Upload KTP -->
        <div class="bg-white rounded-2xl shadow p-4">
            <div class="flex items-center mb-3">
                <span class="iconify text-gray-500 text-xl mr-2" data-icon="mdi:upload-outline"></span>
                <h2 class="font-semibold text-gray-700">Upload KTP</h2>
            </div>

            <div class="border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center py-10 hover:border-[#7B0D1E] transition">
                <div class="w-16 h-16 rounded-full border border-gray-300 flex items-center justify-center mb-3 bg-gray-50">
                    <span class="iconify text-3xl text-gray-400" data-icon="mdi:upload"></span>
                </div>
                <p class="text-gray-500 text-sm mb-1">Upload KTP Anda</p>
                <p class="text-gray-400 text-xs mb-3 text-center">Drag & drop KTP ke sini atau klik untuk memilih<br>Mendukung PNG & JPG</p>
                <label class="bg-[#7B0D1E] text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-[#5d0a17] transition">
                    Pilih File
                    <input type="file" class="hidden" accept=".png,.jpg,.jpeg">
                </label>
            </div>
        </div>

        <!-- Metode Pembayaran -->
        <div class="bg-white rounded-2xl shadow p-4">
            <div class="flex items-center mb-3">
                <span class="iconify text-gray-500 text-xl mr-2" data-icon="mdi:credit-card-outline"></span>
                <h2 class="font-semibold text-gray-700">Metode Pembayaran</h2>
            </div>

            <div class="space-y-3">
                <label class="flex items-center justify-between border p-3 rounded-xl cursor-pointer hover:border-[#7B0D1E] transition">
                    <span class="font-medium text-gray-700 flex items-center gap-2">
                        <span class="iconify text-gray-500 text-lg" data-icon="mdi:truck-delivery-outline"></span>
                        Bayar di Tempat (COD)
                    </span>
                    <input type="radio" name="metode_pembayaran" value="cod" class="h-5 w-5 text-[#7B0D1E]">
                </label>

                <label class="flex items-center justify-between border p-3 rounded-xl cursor-pointer hover:border-[#7B0D1E] transition">
                    <span class="font-medium text-gray-700 flex items-center gap-2">
                        <span class="iconify text-gray-500 text-lg" data-icon="mdi:bank-transfer"></span>
                        Transfer Bank (BCA / Mandiri)
                    </span>
                    <input type="radio" name="metode_pembayaran" value="transfer_bank" class="h-5 w-5 text-[#7B0D1E]">
                </label>

                <label class="flex items-center justify-between border p-3 rounded-xl cursor-pointer hover:border-[#7B0D1E] transition">
                    <span class="font-medium text-gray-700 flex items-center gap-2">
                        <span class="iconify text-blue-500 text-lg" data-icon="mdi:wallet-outline"></span>
                        DANA
                    </span>
                    <input type="radio" name="metode_pembayaran" value="dana" class="h-5 w-5 text-[#7B0D1E]">
                </label>

                <label class="flex items-center justify-between border p-3 rounded-xl cursor-pointer hover:border-[#7B0D1E] transition">
                    <span class="font-medium text-gray-700 flex items-center gap-2">
                        <span class="iconify text-purple-500 text-lg" data-icon="mdi:cellphone-wireless"></span>
                        OVO
                    </span>
                    <input type="radio" name="metode_pembayaran" value="ovo" class="h-5 w-5 text-[#7B0D1E]">
                </label>

                <label class="flex items-center justify-between border p-3 rounded-xl cursor-pointer hover:border-[#7B0D1E] transition">
                    <span class="font-medium text-gray-700 flex items-center gap-2">
                        <span class="iconify text-cyan-500 text-lg" data-icon="mdi:credit-card-scan-outline"></span>
                        GoPay
                    </span>
                    <input type="radio" name="metode_pembayaran" value="gopay" class="h-5 w-5 text-[#7B0D1E]">
                </label>

                <label class="flex items-center justify-between border p-3 rounded-xl cursor-pointer hover:border-[#7B0D1E] transition">
                    <span class="font-medium text-gray-700 flex items-center gap-2">
                        <span class="iconify text-gray-500 text-lg" data-icon="mdi:numeric"></span>
                        Virtual Account (Otomatis)
                    </span>
                    <input type="radio" name="metode_pembayaran" value="va" class="h-5 w-5 text-[#7B0D1E]">
                </label>
            </div>
        </div>

        <!-- Rincian Pembayaran -->
        <div class="bg-white rounded-2xl shadow p-4">
            <div class="flex items-center mb-3">
                <span class="iconify text-gray-500 text-xl mr-2" data-icon="mdi:cash-multiple"></span>
                <h2 class="font-semibold text-gray-700">Rincian Pembayaran</h2>
            </div>
            <div class="space-y-2 text-gray-700 text-sm">
                <div class="flex justify-between">
                    <span>Subtotal Pesanan</span>
                    <span>Rp245.000</span>
                </div>
                <div class="flex justify-between">
                    <span>Biaya Layanan</span>
                    <span>Rp1.000</span>
                </div>
                <div class="flex justify-between font-semibold border-t pt-2">
                    <span>Total Pembayaran</span>
                    <span>Rp246.000</span>
                </div>
            </div>
        </div>

        <!-- Tombol Buat Pesanan -->
        <div class="flex justify-between items-center mt-4 pb-10">
            <span class="font-semibold text-gray-700">Total <span class="text-[#7B0D1E]">Rp246.000</span></span>
            <button class="bg-[#7B0D1E] text-white font-medium px-6 py-2 rounded-lg hover:bg-[#5d0a17] transition">
                Buat Pesanan
            </button>
        </div>

    </main>

    <script>
        const toggleBtn = document.getElementById('togglePesan');
        const pesanTextarea = document.getElementById('pesanTextarea');
        toggleBtn.addEventListener('click', () => {
            pesanTextarea.classList.toggle('hidden');
            if (!pesanTextarea.classList.contains('hidden')) {
                pesanTextarea.focus();
            }
        });
    </script>

</body>
</html>
