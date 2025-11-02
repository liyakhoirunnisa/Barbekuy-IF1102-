<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang | Barbekuy</title>

  {{-- Bootstrap & Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  {{-- Google Font --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

  <style>
    * {
      font-family: 'Poppins', sans-serif;
    }

    body {
      background-color: #fff;
      color: #1a1a1a;
      overflow-x: hidden;
    }

    /* Navbar */
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .nav-link {
      color: #1a1a1a !important;
      font-weight: 500;
    }

    .nav-link:hover {
      color: #751A25 !important;
    }

    /* ===== KERANJANG ===== */
    .cart-container {
      padding: 25px 0;
      min-height: 75vh;
    }

    .item-keranjang {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #eaeaea;
      padding: 25px 0;
      gap: 15px;
      /* penting */
    }

    .item-keranjang input[type="checkbox"] {
      flex-shrink: 0;
      cursor: pointer;
      z-index: 5;
    }

    .item-keranjang img {
      width: 120px;
      border-radius: 12px;
      object-fit: cover;
    }

    .detail-item {
      flex: 1;
      margin-left: 20px;
    }

    .nama-produk {
      font-weight: 600;
      font-size: 1rem;
      color: #1a1a1a;
    }

    .info-sewa {
      font-size: 0.9rem;
      color: #666;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 5px;
    }

    .info-sewa i {
      color: #751A25;
    }

    .kontrol-jumlah {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-right: 20px;
    }

    .kontrol-jumlah button {
      background: none;
      border: none;
      font-size: 1.3rem;
      color: #777;
      transition: 0.2s;
    }

    .kontrol-jumlah button:hover {
      color: #751A25;
    }

    .kontrol-jumlah input {
      width: 35px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 0.9rem;
    }

    .harga-item {
      font-weight: 700;
      font-size: 1.1rem;
      color: #751A25;
      text-align: right;
      min-width: 130px;
    }

    .aksi-item {
      display: flex;
      gap: 10px;
      margin-top: 8px;
    }

    .aksi-item button {
      border: none;
      background: none;
      color: #751A25;
      font-size: 1rem;
      cursor: pointer;
    }

    .aksi-item button:hover {
      color: #a00000;
    }

    /* Total Section */
    .bagian-total {
      background-color: #fafafa;
      border-radius: 16px;
      padding: 25px 35px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      margin-top: 40px;
      font-size: 1.2rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    /* Tombol Checkout */
    /* === Checkout button base === */
    .btn-primary-custom {
      background-color: #751A25;
      /* maroon default */
      color: #fff !important;
      /* pastikan teks selalu putih */
      border: none;
      border-radius: 8px;
      transition: background-color .2s, transform .1s;
      font-weight: 600;
      box-shadow: none !important;
      outline: none !important;
    }

    .btn-disabled {
      background-color: #ccc !important;
      color: #666 !important;
      pointer-events: none;
      cursor: not-allowed;
    }

    .btn-primary-custom:hover {
      background-color: #751A25;
      color: #fff !important;
      /* tetap putih saat hover */
    }

    .btn-primary-custom:focus,
    .btn-primary-custom:active,
    .btn-primary-custom:focus-visible {
      outline: none !important;
      color: #fff !important;
      /* tetap putih saat klik/fokus */
    }

    /* === Saat ada item yang dicentang === */
    .btn-primary-custom.bold-active {
      background-color: #751A25;
      /* merah aktif */
      font-weight: 700;
      box-shadow: none !important;
      color: #fff !important;
      /* teks tetap putih */
    }

    .btn-primary-custom.bold-active:hover,
    .btn-primary-custom.bold-active:active,
    .btn-primary-custom.bold-active:focus,
    .btn-primary-custom.bold-active:focus-visible {
      background-color: #a00000 !important;
      box-shadow: none !important;
      outline: none !important;
      color: #fff !important;
      /* teks tetap putih di semua state */
    }

    /* === Tombol hapus custom (warna maroon Barbekuy) === */
    .btn-delete-custom {
      color: #751A25;
    }

    .btn-delete-custom i {
      color: #751A25;
      line-height: 1;
    }

    @media (max-width: 768px) {
      .item-keranjang {
        flex-direction: column;
        align-items: flex-start;
      }

      .harga-item {
        text-align: left;
        margin-top: 10px;
      }

      .bagian-total {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
    }
  </style>
</head>

<body>
  @include('layouts.navbar')

  <section class="cart-container container">
    @forelse ($keranjang as $key => $barang)
    @php
    $produk = \App\Models\Produk::where('id_produk', $barang['produk_id'])->first();

    $mulai = $barang['tanggal_mulai'] ?? null;
    $akhir = $barang['tanggal_pengembalian'] ?? null;
    $diffSec = 0;
    if ($mulai && $akhir) {
    $diffSec = max(0, strtotime($akhir) - strtotime($mulai));
    }
    $durasiAwal = max(1, (int) floor($diffSec / 86400));
    $subtotalAwal = ($produk->harga ?? 0) * ($barang['jumlah'] ?? 1) * $durasiAwal;
    @endphp

    <div class="item-keranjang"
      data-id="{{ $barang['produk_id'] }}"
      data-key="{{ $key }}"
      data-harga="{{ $produk->harga }}"
      data-durasi="{{ $durasiAwal }}">
      <input type="checkbox" class="checkbox" value="{{ $key }}">
      <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}">
      <div class="detail-item">
        <div class="nama-produk">{{ $produk->nama_produk }}</div>

        <div class="info-sewa">
          <i class="bi bi-calendar"></i>
          <input type="date" class="form-control form-control-sm d-inline-block w-auto"
            value="{{ $barang['tanggal_mulai'] }}" name="tanggal_mulai">
          <span>–</span>
          <input type="date" class="form-control form-control-sm d-inline-block w-auto"
            value="{{ $barang['tanggal_pengembalian'] }}" name="tanggal_pengembalian">

          <!-- 👇 indikator status simpan -->
          <small class="status-simpan ms-2 text-muted" style="display:none;">Menyimpan…</small>
        </div>
      </div>

      <div class="kontrol-jumlah">
        <button class="kurang">−</button>
        <input type="text" value="{{ $barang['jumlah'] }}" readonly>
        <button class="tambah">+</button>
      </div>

      <div class="harga-item">
        Rp{{ number_format($subtotalAwal, 0, ',', '.') }}
      </div>
    </div>
    @empty
    <p class="text-center text-muted mt-5">Keranjang Anda masih kosong 🛒</p>
    @endforelse

    {{-- Bagian Total --}}
    <div id="totalSection" class="bagian-total" style="display:none;">
      <span>Total Pembayaran</span>
      <div class="d-flex align-items-center gap-3">
        <span id="totalHarga">Rp0</span>

        {{-- tombol hapus massal: hanya muncul saat ada item terpilih --}}
        <button id="bulkDeleteBtn" type="button"
          class="btn btn-delete-custom px-1 py-1 d-inline-flex align-items-center"
          style="display:none;">
          <i class="bi bi-trash" style="font-size:2rem;"></i>
        </button>

        <a href="#" id="checkoutBtn" class="btn btn-primary-custom px-4 py-2">Checkout</a>
      </div>
    </div>

    <!-- 🗑️ Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-sm rounded-4" style="border-radius:16px;">
          <div class="modal-body text-center p-4">
            <h5 class="fw-semibold text-danger mb-3" style="color:#751A25 !important;">
              Konfirmasi Hapus Produk
            </h5>
            <p class="text-secondary mb-4" id="deleteConfirmText">
              Apakah kamu yakin ingin menghapus produk ini?
            </p>

            <div class="d-flex justify-content-center gap-3">
              <button type="button" class="btn btn-outline-secondary px-4 py-2 rounded-3"
                data-bs-dismiss="modal">Batal</button>
              <button type="button" id="confirmDeleteBtn"
                class="btn px-4 py-2 rounded-3 text-white"
                style="background-color:#751A25;">Hapus</button>
            </div>
          </div>
        </div>
      </div>
    </div>



  </section>

  {{-- Script --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const tombolCheckout = document.getElementById('checkoutBtn');
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');

    if (bulkDeleteBtn) {
      bulkDeleteBtn.classList.add('d-none');
      bulkDeleteBtn.style.display = 'none';
      bulkDeleteBtn.setAttribute('aria-hidden', 'true');
    }

    // ==== Helpers ====
    const toDateUTC = (yyyyMMdd) => new Date(yyyyMMdd + 'T00:00:00Z');
    const rupiah = (n) => `Rp${(Number(n) || 0).toLocaleString('id-ID')}`;

    const hitungDurasiHari = (mulaiRaw, akhirRaw) => {
      if (!mulaiRaw || !akhirRaw) return 1;
      const start = toDateUTC(mulaiRaw);
      const end = toDateUTC(akhirRaw);
      const MS = 24 * 60 * 60 * 1000;
      const diff = (end - start) / MS;
      return Math.max(1, Math.round(diff));
    };

    function clampQty(v) {
      const n = parseInt(String(v).replace(/[^\d]/g, ''), 10);
      return Math.max(1, isNaN(n) ? 1 : n);
    }

    function debounce(fn, delay = 500) {
      let t;
      return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), delay);
      };
    }

    // === FIX 1: Helper fetch aman JSON/non-JSON + kirim cookie & CSRF ===
    async function fetchJSON(url, {
      method = 'GET',
      body,
      headers = {}
    } = {}) {
      const finalHeaders = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        ...headers
      };

      let res;
      try {
        res = await fetch(url, {
          method,
          headers: finalHeaders,
          body,
          credentials: 'same-origin', // penting untuk bawa cookie sesi
        });
      } catch (e) {
        return {
          ok: false,
          networkError: true,
          status: 0,
          data: null,
          text: 'Network error'
        };
      }

      // Coba parse JSON; jika gagal, fallback ke text agar tidak melempar
      let data = null,
        text = null;
      const ct = res.headers.get('content-type') || '';
      if (ct.includes('application/json')) {
        try {
          data = await res.json();
        } catch {
          data = null;
        }
      } else {
        try {
          text = await res.text();
        } catch {
          text = null;
        }
      }

      return {
        ok: res.ok,
        status: res.status,
        data,
        text
      };
    }

    async function updateQtyOnServer(item, id, jumlah, tanggalMulai, tanggalPengembalian) {
      const key = item.dataset.key;
      const resp = await fetchJSON(`/keranjang/ubah/${encodeURIComponent(id)}`, {
        method: 'POST',
        body: JSON.stringify({
          key,
          jumlah,
          tanggal_mulai: tanggalMulai,
          tanggal_pengembalian: tanggalPengembalian
        })
      });

      if (resp.data && resp.data.new_key) {
        item.dataset.key = resp.data.new_key; // sinkron key baru ke DOM
        const cb = item.querySelector('.checkbox');
        if (cb) cb.value = resp.data.new_key;
      }
      return resp; // ← consistent: { ok, status, data }
    }

    function updateTotalSelected() {
      let total = 0;
      const checked = Array.from(document.querySelectorAll('.checkbox:checked'));
      checked.forEach(cb => {
        const item = cb.closest('.item-keranjang');
        const sub = parseInt(item.querySelector('.harga-item').innerText.replace(/[^\d]/g, '')) || 0;
        total += sub;
      });

      document.getElementById('totalHarga').innerText = rupiah(total);

      const anySelected = checked.length > 0;

      // === Tampilkan/sembunyikan kotak total secara keseluruhan ===
      const totalSection = document.getElementById('totalSection');
      if (totalSection) {
        totalSection.style.display = anySelected ? 'flex' : 'none';
      }

      // Tombol Checkout
      tombolCheckout.classList.toggle('bold-active', anySelected);
      tombolCheckout.classList.toggle('btn-disabled', !anySelected);
      tombolCheckout.setAttribute('aria-disabled', String(!anySelected));

      // Tombol hapus massal
      if (bulkDeleteBtn) {
        bulkDeleteBtn.classList.toggle('d-none', !anySelected);
        bulkDeleteBtn.style.display = anySelected ? 'inline-flex' : 'none';
        bulkDeleteBtn.setAttribute('aria-hidden', String(!anySelected));
        bulkDeleteBtn.disabled = !anySelected;
      }
    }

    // ===== Checkbox listener =====
    document.querySelectorAll('.checkbox').forEach(cb => {
      cb.addEventListener('change', updateTotalSelected);
    });

    // ===== Qty (+ / −) dan ketik manual =====
    const debouncedTypeUpdate = debounce(async (item, id, jumlah) => {
      const tanggalMulai = item.querySelector('input[name="tanggal_mulai"]').value;
      const tanggalPengembalian = item.querySelector('input[name="tanggal_pengembalian"]').value;

      // Optimistic subtotal
      const harga = Number(item.dataset.harga || 0);
      const durasi = hitungDurasiHari(tanggalMulai, tanggalPengembalian);
      const subLoc = harga * durasi * jumlah;
      item.querySelector('.harga-item').innerText = rupiah(subLoc);
      updateTotalSelected();

      const resp = await updateQtyOnServer(item, id, jumlah, tanggalMulai, tanggalPengembalian);
      if (!resp.ok) return; // diam, biar user coba lagi
      const {
        data
      } = resp;
      if (data && data.success) {
        const sub = (typeof data.subtotal === 'number') ? data.subtotal : subLoc;
        item.querySelector('.harga-item').innerText = rupiah(sub);
        updateTotalSelected();
        window.dispatchEvent(new Event('cart:updated'));
      }
    }, 450);

    document.querySelectorAll('.item-keranjang').forEach(item => {
      const id = item.dataset.id;
      const btnMinus = item.querySelector('.kurang');
      const btnPlus = item.querySelector('.tambah');
      const qtyInput = item.querySelector('.kontrol-jumlah input');

      if (qtyInput && qtyInput.hasAttribute('readonly')) qtyInput.removeAttribute('readonly');
      qtyInput.value = clampQty(qtyInput.value);

      btnPlus.addEventListener('click', async () => {
        const next = clampQty(qtyInput.value) + 1;
        qtyInput.value = next;

        const tanggalMulai = item.querySelector('input[name="tanggal_mulai"]').value;
        const tanggalPengembalian = item.querySelector('input[name="tanggal_pengembalian"]').value;

        const harga = Number(item.dataset.harga || 0);
        const durasi = hitungDurasiHari(tanggalMulai, tanggalPengembalian);
        const subLoc = harga * durasi * next;
        item.querySelector('.harga-item').innerText = rupiah(subLoc);
        updateTotalSelected();

        const resp = await updateQtyOnServer(item, id, next, tanggalMulai, tanggalPengembalian);
        if (!resp.ok) {
          if (resp.status === 419) alert('Sesi kadaluarsa. Silakan muat ulang halaman.');
          return;
        }
        const {
          data
        } = resp;
        if (data && data.success) {
          const sub = (typeof data.subtotal === 'number') ? data.subtotal : subLoc;
          item.querySelector('.harga-item').innerText = rupiah(sub);
          updateTotalSelected();
          window.dispatchEvent(new Event('cart:updated'));
        }
      });

      btnMinus.addEventListener('click', async () => {
        const current = clampQty(qtyInput.value);
        const next = Math.max(1, current - 1);
        if (next === current) return;
        qtyInput.value = next;

        const tanggalMulai = item.querySelector('input[name="tanggal_mulai"]').value;
        const tanggalPengembalian = item.querySelector('input[name="tanggal_pengembalian"]').value;

        const harga = Number(item.dataset.harga || 0);
        const durasi = hitungDurasiHari(tanggalMulai, tanggalPengembalian);
        const subLoc = harga * durasi * next;
        item.querySelector('.harga-item').innerText = rupiah(subLoc);
        updateTotalSelected();

        const resp = await updateQtyOnServer(item, id, next, tanggalMulai, tanggalPengembalian);
        if (!resp.ok) {
          if (resp.status === 419) alert('Sesi kadaluarsa. Silakan muat ulang halaman.');
          return;
        }
        const {
          data
        } = resp;
        if (data && data.success) {
          const sub = (typeof data.subtotal === 'number') ? data.subtotal : subLoc;
          item.querySelector('.harga-item').innerText = rupiah(sub);
          updateTotalSelected();
          window.dispatchEvent(new Event('cart:updated'));
        }
      });

      // Ketik manual + sinkron debounce (satu versi saja, hapus duplikat blur lama)
      qtyInput.addEventListener('input', () => {
        const jumlah = clampQty(qtyInput.value);
        debouncedTypeUpdate(item, id, jumlah);
      });
      qtyInput.addEventListener('blur', () => {
        qtyInput.value = clampQty(qtyInput.value);
      });
    });

    // ===== FIX 2: Simpan tanggal (AJAX) aman & informatif =====
    async function saveDatesForItem(itemEl) {
      const id = itemEl.dataset.id;
      const tanggalMulai = itemEl.querySelector('input[name="tanggal_mulai"]').value;
      const tanggalPengembalian = itemEl.querySelector('input[name="tanggal_pengembalian"]').value;
      const status = itemEl.querySelector('.status-simpan');

      if (!tanggalMulai || !tanggalPengembalian) {
        if (status) {
          status.style.display = 'inline';
          status.textContent = 'Tanggal belum lengkap';
        }
        setTimeout(() => {
          if (status) status.style.display = 'none';
        }, 1200);
        return;
      }
      if (toDateUTC(tanggalPengembalian) < toDateUTC(tanggalMulai)) {
        if (status) {
          status.style.display = 'inline';
          status.textContent = 'Tanggal tidak valid';
        }
        setTimeout(() => {
          if (status) status.style.display = 'none';
        }, 1200);
        return;
      }

      const harga = Number(itemEl.dataset.harga || 0);
      const qty = clampQty(itemEl.querySelector('.kontrol-jumlah input').value);
      const durasi = hitungDurasiHari(tanggalMulai, tanggalPengembalian);
      const subLoc = harga * durasi * qty;

      // Optimistic UI
      itemEl.querySelector('.harga-item').innerText = rupiah(subLoc);
      updateTotalSelected();

      if (status) {
        status.style.display = 'inline';
        status.textContent = 'Menyimpan…';
      }

      const resp = await fetchJSON(`/keranjang/ubah/${encodeURIComponent(id)}`, {
        method: 'POST',
        body: JSON.stringify({
          key: itemEl.dataset.key,
          tanggal_mulai: tanggalMulai,
          tanggal_pengembalian: tanggalPengembalian,
          jumlah: qty,
          lama_hari: durasi
        })
      });

      if (!resp.ok) {
        if (status) {
          status.textContent =
            resp.status === 419 ? 'Sesi kadaluarsa' :
            resp.status === 422 ? 'Input tidak valid' :
            resp.networkError ? 'Gagal koneksi' :
            `Gagal (${resp.status})`;
        }
        setTimeout(() => {
          if (status) status.style.display = 'none';
        }, 1500);
        return;
      }

      const {
        data
      } = resp;
      if (data && data.success) {
        const sub = (typeof data.subtotal === 'number') ? data.subtotal : subLoc;
        itemEl.querySelector('.harga-item').innerText = rupiah(sub);
        updateTotalSelected();
        if (data.new_key) {
          itemEl.dataset.key = data.new_key; 
          const cb = itemEl.querySelector('.checkbox'); 
          if (cb) cb.value = data.new_key; 
        }
        if (status) status.textContent = 'Tersimpan';
        setTimeout(() => {
          if (status) status.style.display = 'none';
        }, 900);
      } else {
        if (status) status.textContent = 'Gagal menyimpan';
        setTimeout(() => {
          if (status) status.style.display = 'none';
        }, 1500);
      }
    }

    const debouncedSaveDates = debounce((e) => {
      const item = e.target.closest('.item-keranjang');
      if (item) saveDatesForItem(item);
    }, 600);

    document.querySelectorAll('.item-keranjang').forEach(item => {
      item.querySelectorAll('input[name="tanggal_mulai"], input[name="tanggal_pengembalian"]').forEach(inp => {
        inp.addEventListener('input', debouncedSaveDates);
        inp.addEventListener('change', debouncedSaveDates);
      });
    });

    // ===== Checkout guard =====
    tombolCheckout.addEventListener('click', (e) => {
      const selected = document.querySelectorAll('.checkbox:checked');
      if (selected.length === 0) {
        e.preventDefault();
        return;
      }
      e.preventDefault(); // TODO: ganti ke route checkout saat siap
      alert('Checkout siap. Sambungkan ke route /checkout milikmu.');
    });

    // ===== Hapus massal (tetap sama dengan punyamu, disingkat) =====
    if (bulkDeleteBtn) {
      const modalEl = document.getElementById('confirmDeleteModal');
      const confirmBtn = document.getElementById('confirmDeleteBtn');
      const deleteText = document.getElementById('deleteConfirmText');
      const bsModal = new bootstrap.Modal(modalEl);

      let selectedItems = [];

      bulkDeleteBtn.addEventListener('click', () => {
        selectedItems = Array.from(document.querySelectorAll('.checkbox:checked'));
        if (selectedItems.length === 0) return;
        deleteText.innerHTML = `Apakah kamu yakin ingin menghapus <b>${selectedItems.length}</b> produk dari keranjang?`;
        bsModal.show();
      });

      confirmBtn.addEventListener('click', async () => {
        bsModal.hide();
        const keys = selectedItems.map(cb => cb.value || cb.closest('.item-keranjang')?.dataset.key).filter(Boolean);

        const resp = await fetchJSON(`/keranjang/hapus-banyak`, {
          method: 'POST',
          body: JSON.stringify({
            keys
          })
        });
        if (!resp.ok || !resp.data?.success) return;

        const removed = Array.isArray(resp.data.removed_keys) ? resp.data.removed_keys : keys;
        removed.forEach(k => {
          const el = document.querySelector(`.item-keranjang[data-key="${CSS.escape(k)}"]`);
          if (el) el.remove();
        });

        if (document.querySelectorAll('.item-keranjang').length === 0) {
          const container = document.querySelector('.cart-container');
          if (!document.getElementById('emptyCartMsg')) {
            const emptyMsg = document.createElement('p');
            emptyMsg.id = 'emptyCartMsg';
            emptyMsg.className = 'text-center text-muted mt-5';
            emptyMsg.textContent = 'Keranjang Anda masih kosong 🛒';
            container.appendChild(emptyMsg);
          }
          const totalSection = document.getElementById('totalSection');
          if (totalSection) totalSection.style.display = 'none';
        }

        if (typeof resp.data.count === 'number') {
          const badge = document.getElementById('cart-badge');
          if (badge) {
            badge.textContent = resp.data.count;
            badge.style.display = resp.data.count > 0 ? 'inline-block' : 'none';
          }
        }

        selectedItems = [];
        updateTotalSelected();
      });
    }

    // Init
    updateTotalSelected();
  </script>
</body>

</html>