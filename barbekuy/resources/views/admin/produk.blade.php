<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manajemen Produk | Barbekuy</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif }
    html,body{height:100%}
    body{display:flex;min-height:100vh;background:#f5f6fa;color:#1f1f1f;overflow-x:hidden}

    /* === KONTEN PRODUK === */
    .content{flex:1;padding:25px 30px;overflow:auto}
    .content-box{background:#fff;border-radius:12px;padding:25px;box-shadow:0 2px 10px rgba(0,0,0,0.05)}
    .content-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:25px;flex-wrap:wrap;gap:10px;}
    .content-header h2{font-size:20px;font-weight:600;color:#333}
    .header-actions{display:flex;gap:10px;flex-wrap:wrap;}
    .btn{border:none;padding:9px 16px;border-radius:6px;font-size:14px;cursor:pointer;font-weight:500;transition:0.3s}
    .btn-primary{background:#751A25;color:#fff}
    .btn-primary:hover{background:#3d030a}
    .btn-secondary{background:#fff;border:1px solid #ccc;color:#333}

    .filters{display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:25px;flex-wrap:wrap;}
    .filter-group{display:flex;gap:10px;flex:1;flex-wrap:wrap;}
    .filters select,.filters input{padding:9px 12px;border-radius:6px;border:1px solid #dcdcdc;font-size:13px;outline:none;background:#fff;}
    .filters input{flex:1;min-width:160px;}
    .icon-actions{display:flex;gap:12px;align-items:center;}
    .icon-actions i{font-size:18px;cursor:pointer;transition:0.3s;color:#751A25}
    .icon-actions i:hover{transform:scale(1.1)}

    .table-container{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;min-width:900px;}
    th,td{text-align:left;padding:12px 10px;border-bottom:1px solid #eee;font-size:14px;white-space:nowrap;}
    th{color:#555;font-weight:500}
    td strong{color:#000}
    .status{padding:4px 10px;border-radius:6px;font-size:12px;font-weight:500;display:inline-block}
    .status.active{background:#d2f7d0;color:#2e7d32}
    .status.inactive{background:#f9d2d0;color:#b71c1c}
    td a{color:#751A25;text-decoration:none;font-weight:500;cursor:pointer}
    td a:hover{text-decoration:underline}
    table tbody tr:hover{background-color:rgba(211,47,47,0.08);transform:scale(1.01)}

    /* POPUP UMUM */
    .popup{display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);justify-content:center;align-items:center;z-index:999;padding:15px;}
    .popup-content{background:#fff;border-radius:12px;width:600px;max-width:95%;padding:25px 30px;box-shadow:0 4px 15px rgba(0,0,0,0.2);overflow-y:auto;max-height:90vh;}
    .popup-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
    .popup-header h3{font-size:18px;color:#751A25}
    .close-btn{background:none;border:none;font-size:20px;cursor:pointer;color:#751A25}
    .popup-footer{margin-top:15px;display:flex;justify-content:flex-end;gap:10px;flex-wrap:wrap;}

    /* FORM TAMBAH & EDIT PRODUK */
    form label{display:block;font-weight:600;color:#751A25;margin-bottom:6px;font-size:14px;}
    form input, form select, form textarea{
      width:100%;padding:10px 12px;border:1px solid #ccc;border-radius:8px;font-size:14px;outline:none;background:#fff;transition:all 0.3s ease;
    }
    form input:focus, form select:focus, form textarea:focus{
      border-color:#751A25;box-shadow:0 0 4px rgba(117,26,37,0.25);
    }
    form textarea{min-height:90px;resize:vertical;}
    .popup-footer .btn{font-size:14px;padding:9px 16px;border-radius:6px;font-weight:500;transition:0.3s;}
    .popup-footer .btn-primary{background:#751A25;color:#fff;}
    .popup-footer .btn-primary:hover{background:#3d030a;}
    .popup-footer .btn-secondary{background:#fff;border:1px solid #ccc;color:#333;}
    .popup-footer .btn-secondary:hover{background:#f7f7f7;}
  </style>
</head>

<body>
   {{-- 🔹 Sidebar + Topbar --}}
  @include('layouts.navbarAdmin')

    <!-- MAIN -->
  <main class="main-content">
    <div class="content">
      <div class="content-box">

        <div class="content-header">
          <h2>Manajemen Produk Penyewaan</h2>
          <div class="header-actions">
            <button class="btn btn-secondary">Export Excel</button>
            <button class="btn btn-primary" onclick="openPopup('popupTambah')">Tambah Produk</button>
          </div>
        </div>

        <div class="filters">
          <div class="filter-group">
            <select name="kategori">
              <option value="">Filter Kategori</option>
              <option value="Paket Slice">Paket Slice</option>
              <option value="Paket Alat">Paket Alat</option>
            </select>

            <select name="status">
              <option value="">Filter Status</option>
              <option value="tersedia">Tersedia</option>
              <option value="tidak tersedia">Tidak Tersedia</option>
            </select>

            <div style="display:flex;align-items:center;gap:8px;flex:1;">
              <input type="text" placeholder="Cari Produk..." style="flex:1;">
              <i id="resetFilter" class="fa-solid fa-rotate-right" 
                title="Reset Filter"
                style="cursor:pointer;font-size:18px;color:#751A25;transition:0.3s;"></i>
            </div>
          </div>

          <div class="icon-actions">
            <i class="fa-solid fa-pen-to-square" title="Edit" id="iconEdit"></i>
            <i class="fa-solid fa-trash" title="Hapus" id="iconDelete" onclick="triggerDelete()"></i>
          </div>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Deskripsi Singkat</th>
                <th>Harga Sewa/Hari</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($produk as $item)
              <tr data-gambar="{{ asset('storage/' . $item->gambar) }}">
                  <td><input type="checkbox" class="rowCheck"></td>
                  <td><strong>{{ $item->id_produk }}</strong></td>
                  <td>{{ $item->nama_produk }}</td>
                  <td>{{ $item->kategori }}</td>
                  <td>{{ $item->stok }}</td>
                  <td>{{ Str::limit($item->deskripsi, 1000) }}</td>
                  <td>Rp{{ number_format($item->harga, 0, ',', '.') }}</td>
                  <td>
                    @if ($item->status_ketersediaan == 'tersedia')
                        <span class="status active">Tersedia</span>
                    @else
                        <span class="status inactive">Tidak tersedia</span>
                    @endif
                  </td>
                  <td><a onclick="openDetail('{{ $item->id_produk }}')">Detail</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- POPUPS (Detail, Tambah, Edit, Hapus) -->
        <div class="popup" id="popupDetail">
          <div class="popup-content">
            <div class="popup-header">
              <h3>Detail Produk</h3>
              <button class="close-btn" onclick="closePopup('popupDetail')">&times;</button>
            </div>
            <img id="detailGambar" src="" alt="Gambar Produk"
                 style="width:180px; height:180px; align-items: center; object-fit:cover; border-radius:10px; margin: 0 auto 15px auto; display:block; border:1px solid #ccc;">
            <p><b>ID Produk:</b> <span id="detailID"></span></p>
            <p><b>Nama Produk:</b> <span id="detailNama"></span></p>
            <p><b>Kategori:</b> <span id="detailKategori"></span></p>
            <p><b>Stok:</b> <span id="detailStok"></span></p>
            <p><b>Deskripsi:</b> <span id="detailDeskripsi" style="white-space: pre-wrap; word-wrap: break-word;"></span></p>
            <p><b>Harga:</b> <span id="detailHarga"></span>/hari</p>
          </div>
        </div>

        <div class="popup" id="popupTambah">
          <div class="popup-content">
            <div class="popup-header"><h3>Tambah Produk</h3></div>

            <!-- FORM BENAR -->
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
              @csrf

              <label>Gambar Produk</label>
              <input type="file" name="gambar" accept="image/*" required>

              <label>Nama Produk</label>
              <input type="text" name="nama_produk" required>

              <label>Kategori</label>
              <select name="kategori" required>
                <option value="Paket Slice">Paket Slice</option>
                <option value="Paket Alat">Paket Alat</option>
              </select>

              <label>Stok</label>
              <input type="number" name="stok" required>

              <label>Deskripsi Singkat</label>
              <textarea name="deskripsi" required></textarea>

              <label>Harga Sewa/Hari</label>
              <input type="number" name="harga" required>

              <div class="popup-footer">
                <button type="button" class="btn btn-secondary" onclick="closePopup('popupTambah')">Batal</button>
                <button type="submit" class="btn btn-primary">Tambah Produk</button>
              </div>
            </form>
          </div>
        </div>


        <div class="popup" id="popupEdit">
          <div class="popup-content">
            <div class="popup-header"><h3>Edit Produk</h3></div>
            <form></form>
          </div>
        </div>

        <div class="popup popup-hapus" id="popupHapus">
          <div class="popup-content">
            <div class="popup-header"><h3>Konfirmasi Hapus Produk</h3></div>
            <p>Apakah kamu yakin ingin menghapus produk ini?</p>
            <div class="popup-footer" style="justify-content:center;">
              <button class="btn btn-secondary" onclick="closePopup('popupHapus')">Batal</button>
              <button class="btn btn-primary" onclick="confirmDelete()">Hapus</button>
            </div>
          </div>
        </div>

        <!-- === END OF ORIGINAL PRODUCT CONTENT === -->
      </div>
    </div>
  </main>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('active');
    }
  function openPopup(id){ document.getElementById(id).style.display='flex'; }
  function closePopup(id){ document.getElementById(id).style.display='none'; }

  // === DETAIL PRODUK ===
  function openDetail(id){
    const row = [...document.querySelectorAll('table tbody tr')]
      .find(r=>r.querySelector('td strong').innerText===id);
    if(!row) return;
    const cells = row.querySelectorAll('td');
    document.getElementById('detailID').innerText = cells[1].innerText;
    document.getElementById('detailNama').innerText = cells[2].innerText;
    document.getElementById('detailKategori').innerText = cells[3].innerText;
    document.getElementById('detailStok').innerText = cells[4].innerText;
    document.getElementById('detailDeskripsi').innerText = cells[5].innerText;
    document.getElementById('detailHarga').innerText = cells[6].innerText;
    document.getElementById('detailGambar').src = row.getAttribute('data-gambar');
    openPopup('popupDetail');
  }

  // === CHECK ALL ===
  document.getElementById('checkAll').addEventListener('change', function(){
    document.querySelectorAll('.rowCheck').forEach(c=>c.checked=this.checked);
  });

  // === HAPUS PRODUK ===
  let rowsToDelete = [];
  function triggerDelete(){
    rowsToDelete = [...document.querySelectorAll('.rowCheck:checked')].map(c=>c.closest('tr'));
    if(rowsToDelete.length===0){alert('Pilih produk yang ingin dihapus!'); return;}
    openPopup('popupHapus');
  }
  
  function confirmDelete() {
    const promises = rowsToDelete.map(row => {
      const id = row.querySelector('td strong').innerText;

      return fetch(`{{ url('/produk/delete') }}/${id}`, {
        method: 'DELETE',
        headers: { 
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json'
        }
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          row.remove();
        } else {
          alert(data.message || 'Gagal menghapus produk.');
        }
      })
      .catch(() => alert('Terjadi kesalahan koneksi.'));
    });

    // Setelah semua fetch selesai → tutup popup
    Promise.all(promises).then(() => {
      closePopup('popupHapus');
    });
  }


  // === FILTER (Kategori, Status, Pencarian) ===
  const kategoriSelect = document.querySelector('select[name="kategori"]');
  const statusSelect = document.querySelector('select[name="status"]');
  const searchInput = document.querySelector('input[placeholder="Cari Produk..."]');
  const resetBtn = document.getElementById('resetFilter');

  kategoriSelect.addEventListener('change', filterProduk);
  statusSelect.addEventListener('change', filterProduk);
  searchInput.addEventListener('input', filterProduk);
  resetBtn.addEventListener('click', resetFilter);

  function filterProduk() {
    const kategoriValue = kategoriSelect.value.toLowerCase();
    const statusValue = statusSelect.value.toLowerCase();
    const searchValue = searchInput.value.toLowerCase();

    const rows = document.querySelectorAll('table tbody tr');
    let visibleCount = 0;

    rows.forEach(row => {
      const kategori = row.children[3].innerText.toLowerCase();
      const status = row.querySelector('.status').innerText.toLowerCase().trim();
      const nama = row.children[2].innerText.toLowerCase();

      const matchKategori = (kategoriValue === '' || kategori === kategoriValue);
      const matchStatus = (statusValue === '' || status === statusValue);
      const matchSearch = (searchValue === '' || nama.includes(searchValue));

      const visible = matchKategori && matchStatus && matchSearch;
      row.style.display = visible ? '' : 'none';
      if (visible) visibleCount++;
    });

    updateEmptyRow(visibleCount);
  }


  function resetFilter() {
    // Reset semua nilai filter
    kategoriSelect.value = '';
    statusSelect.value = '';
    searchInput.value = '';

    // Tampilkan semua baris produk
    const rows = document.querySelectorAll('table tbody tr');
    rows.forEach(row => {
      row.style.display = '';
    });

    // Hapus baris "Tidak ada produk ditemukan" kalau ada
    const emptyRow = document.getElementById('emptyRow');
    if (emptyRow) {
      emptyRow.remove();
    }

    // Animasi kecil untuk icon reset
    resetBtn.style.transform = 'rotate(360deg)';
    setTimeout(() => {
      resetBtn.style.transform = 'rotate(0deg)';
    }, 400);
  }


  // Pastikan baris "Tidak ada produk ditemukan" hilang kalau tabel punya data
  document.addEventListener('DOMContentLoaded', () => {
    const tbody = document.querySelector('table tbody');
    const emptyRow = document.getElementById('emptyRow');

    // Cek apakah tabel berisi baris produk (yang punya <strong>)
    const hasProducts = [...tbody.querySelectorAll('tr')].some(
      tr => tr.querySelector('td strong')
    );

    // Jika ada produk, hapus pesan kosong
    if (hasProducts && emptyRow) {
      emptyRow.remove();
    }

    // Tambahan ekstra keamanan: jalankan ulang setelah 300ms
    // (kadang Blade render belum sepenuhnya selesai saat onload)
    setTimeout(() => {
      const emptyRowCheck = document.getElementById('emptyRow');
      const hasProductsNow = [...tbody.querySelectorAll('tr')].some(
        tr => tr.querySelector('td strong')
      );
      if (hasProductsNow && emptyRowCheck) {
        emptyRowCheck.remove();
      }
    }, 300);
  });


  function updateEmptyRow(visibleCount) {
    const tbody = document.querySelector('table tbody');
    const emptyRow = document.getElementById('emptyRow');

    // kalau ada produk yang tampil → pastikan baris kosong dihapus
    if (visibleCount > 0) {
      if (emptyRow) emptyRow.remove();
    } 
    // kalau tidak ada produk → tampilkan pesan
    else {
      if (!emptyRow) {
        const row = document.createElement('tr');
        row.id = 'emptyRow';
        row.innerHTML = `
          <td colspan="9" style="text-align:center; padding:20px; color:#888;">
            Tidak ada produk ditemukan
          </td>`;
        tbody.appendChild(row);
      }
    }
  }


  // === EDIT PRODUK ===
  const editIcon = document.getElementById('iconEdit');
  if (editIcon) {
    editIcon.addEventListener('click', () => {
      const selected = [...document.querySelectorAll('.rowCheck:checked')];
      if (selected.length === 0) { alert('Pilih produk yang ingin diedit!'); return; }
      if (selected.length > 1) { alert('Hanya bisa mengedit satu produk!'); return; }

      const row   = selected[0].closest('tr');
      const id    = row.querySelector('td strong').innerText;
      const cells = row.querySelectorAll('td');
      const popup = document.getElementById('popupEdit');
      const form  = popup.querySelector('form');

      form.innerHTML = `
        <label>Gambar Produk</label>
        <input type="file" name="gambar" id="editGambarProduk" accept="image/*">

        <label>Nama Produk</label>
        <input type="text" name="nama_produk" value="${cells[2].innerText}" required>

        <label>Kategori</label>
        <select name="kategori" required>
          <option value="Paket Slice" ${cells[3].innerText==='Paket Slice'?'selected':''}>Paket Slice</option>
          <option value="Paket Alat"  ${cells[3].innerText==='Paket Alat' ?'selected':''}>Paket Alat</option>
        </select>

        <label>Stok</label>
        <input type="number" name="stok" value="${cells[4].innerText}" required>

        <label>Deskripsi</label>
        <textarea name="deskripsi" required>${cells[5].innerText}</textarea>

        <label>Harga</label>
        <input type="number" name="harga" value="${cells[6].innerText.replace(/\D/g,'')}" required>

        <div class="popup-footer">
          <button type="button" class="btn btn-secondary" onclick="closePopup('popupEdit')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      `;

      form.onsubmit = async (ev) => {
        ev.preventDefault();

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const fd    = new FormData(form);

        // kalau user tidak ganti gambar, hapus field agar tidak memicu validasi file
        const fileInput = form.querySelector('input[name="gambar"]');
        if (!fileInput.files || fileInput.files.length === 0) {
          fd.delete('gambar');
        }

        // ✅ gunakan URL dengan prefix /admin
        const updateUrl = `{{ url('/admin/produk/update') }}/${id}`;

        try {
          const res = await fetch(updateUrl, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': token,
              // ✅ pastikan dianggap AJAX & minta JSON
              'X-Requested-With': 'XMLHttpRequest',
              'Accept': 'application/json'
            },
            body: fd
          });

          if (!res.ok) {
            const data = await res.json().catch(() => ({}));
            alert(data.message || 'Gagal menyimpan perubahan.');
            return;
          }

          // kalau controller balas JSON success
          const data = await res.json().catch(() => ({}));
          if (data && data.success) {
            location.reload();
          } else {
            // fallback: kalau ternyata balasannya bukan JSON tapi 200 (mis. redirect)
            location.reload();
          }
        } catch (e) {
          alert('Terjadi kesalahan koneksi.');
        }
      };

      openPopup('popupEdit');
    });
  }
  </script>


</body>
</html>