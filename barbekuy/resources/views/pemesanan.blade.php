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
    <main class="max-w-3xl mx-auto p-6 pt-4">
        <form id="formPemesanan" action="{{ route('pemesanan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- Produk -->
            <div class="bg-white rounded-2xl shadow p-4 mb-2">
                <div class="flex items-center mb-3">
                    <span class="iconify text-gray-500 text-xl mr-2" data-icon="solar:cart-3-outline"></span>
                    <h2 class="font-semibold text-gray-700">Produk:</h2>
                </div>

                <div class="flex items-center gap-4 border rounded-xl p-3">
                    <img src="{{ asset('storage/' . $produk->gambar) }}" 
                        alt="{{ $produk->nama_produk }}" 
                        class="w-24 h-24 object-cover rounded-lg">

                    <div class="flex-1">
                        <h3 class="font-semibold text-lg text-gray-800">{{ $produk->nama_produk }}</h3>
                        <div class="flex items-center gap-1 text-gray-500 text-sm">
                            <span class="iconify" data-icon="mdi:calendar-range"></span>
                            <p>
                                Tanggal sewa:
                                {{ $tanggalMulaiSewa && $tanggalSelesai 
                                    ? \Carbon\Carbon::parse($tanggalMulaiSewa)->translatedFormat('d F Y') . ' - ' . \Carbon\Carbon::parse($tanggalSelesai)->translatedFormat('d F Y')
                                    : '-' 
                                }}
                            </p>
                        </div>
                        <p class="text-sm text-green-600 flex items-center gap-1">
                            <span class="iconify" data-icon="mdi:check-circle-outline"></span>
                            {{ $produk->status }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-[#7B0D1E] font-bold">
                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-500">x{{ $produk->jumlah ?? 1 }}</p>
                    </div>
                </div>

                <div class="flex justify-between items-center mt-3 border-t pt-2 text-gray-700">
                    <span>Total {{ $produk->jumlah ?? 1 }} Produk</span>
                    <span class="font-semibold">
                        Rp{{ number_format($produk->harga * ($produk->jumlah ?? 1), 0, ',', '.') }}
                    </span>
                </div>

                <!-- Hidden input agar data produk terkirim ke controller -->
                <input type="hidden" name="id_produk" value="{{ $produk->id_produk }}">
                <input type="hidden" name="harga" value="{{ $produk->harga }}">
                <input type="hidden" name="jumlah" value="{{ $produk->jumlah ?? 1 }}">
                <input type="hidden" name="tanggal_mulai_sewa" value="{{ $tanggalMulaiSewa }}">
                <input type="hidden" name="tanggal_selesai" value="{{ $tanggalSelesai }}">

                <!-- Pesan -->
                <div class="mt-3">
                    <button type="button" id="togglePesan" 
                            class="text-gray-500 text-sm flex items-center gap-1 hover:text-[#7B0D1E] transition">
                        <span class="iconify" data-icon="mdi:message-text-outline"></span>
                        Tinggalkan Pesan
                    </button>
                    <textarea id="pesanTextarea" name="pesan"
                            class="hidden w-full border border-gray-300 rounded-lg mt-2 p-2 text-sm text-gray-700 focus:bg-white focus:ring-[#7B0D1E] focus:border-[#7B0D1E]" 
                            placeholder="Contoh: Akan saya ambil siang"></textarea>
                </div>
            </div>

            <!-- Nama Penerima -->
            <div class="bg-white rounded-2xl shadow p-4 mb-2">
                <div class="flex items-center mb-3">
                    <span class="iconify text-gray-500 text-xl mr-2" data-icon="mdi:account-outline"></span>
                    <h2 class="font-semibold text-gray-700">Nama Penerima</h2>
                </div>
                <input type="text" id="namaPenerima" name="nama_penerima" 
                    class="w-full border border-gray-300 rounded-lg p-2 text-gray-700 focus:border-[#7B0D1E] focus:ring-[#7B0D1E]" 
                    placeholder="Masukkan nama penerima" required>
            </div>

            <!-- Lokasi Pengambilan -->
            <div class="bg-white rounded-2xl shadow p-4 mb-2">
                <div class="flex items-center mb-3">
                    <span class="iconify text-gray-500 text-xl mr-2" data-icon="mdi:map-marker-outline"></span>
                    <h2 class="font-semibold text-gray-700">Lokasi Pengambilan</h2>
                </div>
                <p class="text-gray-600 text-sm">
                    Sumampir Kulon, Sumampir, Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125
                </p>

                <!-- Hidden input agar ikut tersimpan ke database -->
                <input type="hidden" name="lokasi_pengambilan" 
                    value="Sumampir Kulon, Sumampir, Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125">
            </div>

            <!-- Upload KTP -->
            <div class="bg-white rounded-2xl shadow p-4 mb-2">
                <div class="flex items-center mb-3">
                    <span class="iconify text-gray-500 text-xl mr-2" data-icon="mdi:upload-outline"></span>
                    <h2 class="font-semibold text-gray-700">Upload KTP</h2>
                </div>

                <!-- Dropzone (tampil awal) -->
                <div id="dropZone"
                    class="border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center py-10 hover:border-[#7B0D1E] transition bg-gray-50 cursor-pointer">
                    <div class="w-16 h-16 rounded-full border border-gray-300 flex items-center justify-center mb-3 bg-white">
                        <span class="iconify text-3xl text-gray-400" data-icon="mdi:upload"></span>
                    </div>
                    <p class="text-gray-500 text-sm mb-1">Upload KTP Anda</p>
                    <p class="text-gray-400 text-xs mb-3 text-center">
                        Drag & drop KTP ke sini atau klik untuk memilih<br>Mendukung PNG & JPG
                    </p>

                    <label class="bg-[#7B0D1E] text-white px-4 py-2 rounded-lg cursor-pointer hover:bg-[#5d0a17] transition">
                        Pilih File
                        <input id="fileInput" type="file" name="ktp" class="hidden" accept=".png,.jpg,.jpeg">
                    </label>
                </div>

                <!-- Preview -->
                <div id="previewContainer" class="hidden mt-4">
                    <div class="flex flex-col sm:flex-row items-start gap-4">
                        <img id="previewImage" src="" alt="Preview KTP" class="w-full sm:max-w-sm rounded-lg shadow">
                        <div class="flex flex-col gap-2">
                            <button type="button" id="btnGanti"
                                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-medium flex items-center gap-2 transition hover:border-[#7B0D1E] active:bg-[#7B0D1E]/10">
                                Ganti KTP
                            </button>
                            <button type="button" id="btnHapus"
                                class="px-4 py-2 bg-[#7B0D1E] text-white rounded-lg text-sm font-medium shadow hover:bg-[#5d0a17] active:scale-95 transition">
                                Hapus KTP
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metode Pembayaran -->
            <div class="bg-white rounded-2xl shadow p-4 mb-2">
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
            <div class="bg-white rounded-2xl shadow p-4 mb-2">
                <div class="flex items-center mb-3">
                    <span class="iconify text-gray-500 text-xl mr-2" data-icon="mdi:cash-multiple"></span>
                    <h2 class="font-semibold text-gray-700">Rincian Pembayaran</h2>
                </div>
                <div class="space-y-2 text-gray-700 text-sm">
                    <div class="flex justify-between">
                        <span>Subtotal Pesanan</span>
                        <span>Rp{{ number_format($total_produk, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Layanan</span>
                        <span>Rp{{ number_format($biaya_layanan, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-semibold border-t pt-2">
                        <span>Total Pembayaran</span>
                        <span>Rp{{ number_format($total_pembayaran, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Tombol Buat Pesanan -->
            <div class="flex justify-between items-center mt-4 pb-10">
                <span class="font-semibold text-gray-700">
                    Total <span class="text-[#7B0D1E]">Rp{{ number_format($total_pembayaran, 0, ',', '.') }}</span>
                </span>

                <button type="submit" class="bg-[#7B0D1E] text-white font-medium px-6 py-2 rounded-lg hover:bg-[#5d0a17] transition">
                    Buat Pesanan
                </button>
            </div>
        </form>
    </main>

    <script>
        const toggleBtn = document.getElementById('togglePesan');
        const pesanTextarea = document.getElementById('pesanTextarea');
        toggleBtn?.addEventListener('click', () => {
            pesanTextarea.classList.toggle('hidden');
            if (!pesanTextarea.classList.contains('hidden')) pesanTextarea.focus();
        });

        // === Upload KTP ===
        let sedangGantiKTP = false;
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');
        const btnGanti = document.getElementById('btnGanti');
        const btnHapus = document.getElementById('btnHapus');

        function handleSelectedFile(file) {
            if (!file) return;
            if (!['image/png', 'image/jpeg', 'image/jpg'].includes(file.type)) {
                alert('Hanya mendukung format PNG atau JPG.');
                return;
            }
            const reader = new FileReader();
            reader.onload = e => {
                previewImage.src = e.target.result;
                dropZone.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        fileInput?.addEventListener('change', function() {
            const file = this.files[0];
            if (file) handleSelectedFile(file);
        });

        dropZone?.addEventListener('dragover', e => {
            e.preventDefault();
            dropZone.classList.add('border-[#7B0D1E]', 'bg-white');
        });

        dropZone?.addEventListener('dragleave', e => {
            e.preventDefault();
            dropZone.classList.remove('border-[#7B0D1E]', 'bg-white');
        });

        dropZone?.addEventListener('drop', e => {
            e.preventDefault();
            dropZone.classList.remove('border-[#7B0D1E]', 'bg-white');
            const file = e.dataTransfer.files[0];
            if (file) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;
                handleSelectedFile(file);
            }
        });

        btnGanti?.addEventListener('click', () => {
            sedangGantiKTP = true; // tandai sedang ganti
            previewContainer.classList.add('hidden');
            dropZone.classList.remove('hidden');

            fileInput.value = null;

            setTimeout(() => {
                fileInput.click();
            }, 50);
        });

        dropZone?.addEventListener('click', (e) => {
            // Cegah event ganda jika yang diklik adalah label atau input
            if (e.target.tagName.toLowerCase() === 'label' || e.target.tagName.toLowerCase() === 'input') return;
            
            if (!sedangGantiKTP) fileInput.click();
            sedangGantiKTP = false;
        });


        btnHapus?.addEventListener('click', () => {
            fileInput.value = '';
            previewImage.src = '';
            previewContainer.classList.add('hidden');
            dropZone.classList.remove('hidden');
        });

        document.getElementById('formPemesanan').addEventListener('submit', function(e) {
            if (!fileInput.files.length) {
                e.preventDefault();
                alert('Silakan upload foto KTP terlebih dahulu.');
            }
        });


        // === Kirim data pemesanan ===
        function lanjutPemesanan(idProduk, tanggalMulaiSewa, tanggalSelesai) {
            const formData = new FormData();
            formData.append('id_produk', idProduk);
            formData.append('tanggal_mulai_sewa', tanggalMulaiSewa);
            formData.append('tanggal_selesai', tanggalSelesai);
            formData.append('lokasi_pengambilan', 'Sumampir Kulon, Sumampir, Purwokerto Utara, Kabupaten Banyumas, Jawa Tengah 53125');
            
            if (fileInput.files[0]) {
                formData.append('ktp', fileInput.files[0]);
            }

            fetch("{{ route('pemesanan.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: formData,
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                } else {
                    alert("Gagal menyimpan pesanan.");
                }
            })
            .catch(err => {
                console.error(err);
                alert("Terjadi kesalahan server.");
            });
        }

        // Auto-preview jika file masih ada saat reload/back navigation
        if (fileInput.files && fileInput.files[0]) {
            handleSelectedFile(fileInput.files[0]);
        }
    </script>
</body>
</html>
