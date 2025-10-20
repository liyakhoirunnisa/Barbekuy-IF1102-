<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Produk | Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
    body { background:#f5f6fa; display:flex; min-height:100vh; }

   /* === SIDEBAR === */
.sidebar { width: 240px; background: #751A25; color: #fff; display: flex; flex-direction: column; align-items: center; padding-top: 20px; }
.logo { height: 110px; display: flex; align-items: center; justify-content: center; background: #751A25; }
.logo img { width: 190px; height: auto; object-fit: contain; position: relative; top: -18px; }
.menu { width: 100%; margin-top: -3px; }
.menu-item { display: flex; align-items: center; gap: 12px; padding: 14px 26px; color: #fff; font-size: 14px; text-decoration: none; transition: 0.3s; }
.menu-item img { width: 20px; height: 20px; object-fit: contain; filter: brightness(0) invert(1); }
.menu-item:hover, .menu-item.active { background: rgba(255,255,255,0.15); border-radius: 10px; }
.notif { background: #fff; color: #751A25; font-size: 11px; padding: 2px 8px; border-radius: 12px; margin-left: auto; font-weight: 600; }

    /* === MAIN & TOPBAR === */
    .main-content { flex:1; display:flex; flex-direction:column; height:100vh; overflow:hidden; }
    .topbar { height:110px; background:#751A25; display:flex; align-items:center; justify-content:flex-end; padding:0 40px; box-shadow:0 2px 5px rgba(0,0,0,0.1); gap:25px; }
    .topbar a { display:flex; align-items:center; justify-content:center; height:55px; }
    .topbar a img { width:28px; height:28px; filter:brightness(0) invert(1); cursor:pointer; transition:0.3s; position:relative; top:2px; }
    .topbar a img:hover { transform:scale(1.1); }
    .profile { height:55px; display:flex; align-items:center; gap:10px; background:#fff; color:#751A25; padding:6px 14px; border-radius:30px; font-weight:500; }
    .avatar { background:#751A25; color:#fff; width:32px; height:32px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:600; }
    .content-box { background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.05); padding:28px; }
    .content-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:25px; }
    .content-header h2 { font-size:20px; font-weight:600; color:#333; }
    .header-actions { display:flex; gap:10px; }
    .btn { border:none; padding:9px 16px; border-radius:6px; font-size:14px; cursor:pointer; font-weight:500; transition:0.3s; }
    .btn-primary { background:#751A25; color:#fff; } 
    .btn-primary:hover{background:#3d030a;}
    .btn-secondary { background:#fff; border:1px solid #ccc; color:#333; }

    /* Filter */
    .filters { display:flex; justify-content:space-between; align-items:center; gap:10px; margin-bottom:25px; }
    .filter-group { display:flex; gap:10px; flex:1; }
    .filters select, .filters input { padding:9px 12px; border-radius:6px; border:1px solid #dcdcdc; font-size:13px; outline:none; background:#fff; }
    .filters input { flex:1; }
    .icon-actions { display:flex; gap:12px; }
    .icon-actions img { width:24px; cursor:pointer; transition:0.3s; }
    .icon-actions img:hover { transform:scale(1.1); }

    /* Table */
    table { width:100%; border-collapse:collapse; }
    th, td { text-align:left; padding:12px 10px; border-bottom:1px solid #eee; font-size:14px; }
    th { color:#555; font-weight:500; }
    td strong { color:#000; }
    .status { padding:4px 10px; border-radius:6px; font-size:12px; font-weight:500; display:inline-block; }
    .status.active { background:#d2f7d0; color:#2e7d32; }
    .status.inactive { background:#f9d2d0; color:#b71c1c; }
    td a { color:#751A25; text-decoration:none; font-weight:500; cursor:pointer; }
    td a:hover { text-decoration:underline; }
    table tbody tr { transition: background-color 0.2s ease, transform 0.1s ease; cursor:pointer; }
    table tbody tr:hover { background-color: rgba(211, 47, 47, 0.15); transform: scale(1.01); }

    /* Popup umum */
    .popup { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.6); justify-content:center; align-items:center; z-index:999; }
    .popup-content { background:#fff; border-radius:12px; width:600px; max-width:90%; padding:25px 30px; box-shadow:0 4px 15px rgba(0,0,0,0.2); animation:fadeIn 0.3s ease; }
    @keyframes fadeIn { from{opacity:0; transform:scale(0.9);} to{opacity:1; transform:scale(1);} }
    .popup-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; }
    .popup-header h3 { font-size:18px; color:#751A25; }
    .close-btn { background:none; border:none; font-size:20px; cursor:pointer; color:#751A25; }
    .popup-footer { margin-top:15px; display:flex; justify-content:flex-end; gap:10px; }

    /* Popup Hapus */
    .popup-hapus .popup-content { border-top:8px solid #751A25; text-align:center; padding:30px 20px; }
    .popup-hapus h3 { color:#751A25; font-size:20px; margin-bottom:10px; }
    .popup-hapus p { color:#444; margin-bottom:20px; }
    .popup-hapus .btn-primary { background:#751A25; } 
    .popup-hapus .btn-primary:hover{background:#3d030a;}

    /* Popup Edit */
    #popupEdit .popup-content form { display:flex; flex-direction:column; gap:15px; }
    #popupEdit .popup-content form input, #popupEdit .popup-content form select, #popupEdit .popup-content form textarea { width:100%; padding:10px 12px; border:1px solid #dcdcdc; border-radius:6px; font-size:14px; outline:none; background:#fff; }
    #popupEdit .popup-content form textarea { min-height:80px; resize:vertical; }
    #popupEdit .popup-footer { justify-content:flex-end; gap:10px; margin-top:10px; }

    /* Popup Tambah */
    #popupTambah .popup-content { background:#fff; border-radius:12px; width:500px; max-width:90%; padding:25px 30px; display:flex; flex-direction:column; gap:15px; }
    #popupTambah .popup-header h3 { color:#751A25; font-size:18px; font-weight:600; }
    #popupTambah .label {color:#767676; font-size:14px}
    #popupTambah form { display:flex; flex-direction:column; gap:12px; }
    #popupTambah form input, #popupTambah form select, #popupTambah form textarea { width:100%; padding:10px 12px; border:1px solid #dcdcdc; border-radius:6px; font-size:14px; outline:none; background:#fff; }
    #popupTambah form textarea { min-height:80px; resize:vertical; }
    #popupTambah .popup-footer { display:flex; justify-content:flex-end; gap:10px; margin-top:10px; }
    #popupTambah .btn-primary { background:#751A25; color:#fff; } 
    #popupTambah .btn-primary:hover{background:#3d030a;}
    #popupTambah .btn-secondary { background:#fff; color:#751A25; border:1px solid #751A25; } 
    #popupTambah .btn-secondary:hover{background:#f4f0f0;}

    /* === SAMAKAN DENGAN HALAMAN TRANSAKSI === */
.sidebar {
  width: 240px;
  background: #751A25;
  color: #fff;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-top: 20px;
}

.logo {
  height: 110px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #751A25;
}

.menu {
  width: 100%;
  margin-top: -3px; /* agar sejajar seperti di transaksi */
}

.main-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  height: 100vh;
  overflow: hidden;
}

.topbar {
  height: 110px;
  background: #751A25;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 0 40px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
  gap: 25px;
}

.content {
  flex: 1;
  padding: 30px 40px;
}

.content-box {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  padding: 28px;
}

  </style>
</head>
<body>
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="logo"><img src="{{ asset('images/logoputih.png') }}" alt="Logo Barbekuy"></div>
    <div class="menu">
      <a href="{{ route('beranda') }}" class="menu-item"><img src="{{ asset('images/beranda.png') }}"> Beranda</a>
      <a href="{{ route('transaksi') }}" class="menu-item"><img src="{{ asset('images/transaksi.png') }}"> Transaksi</a>
      <a href="#" class="menu-item active"><img src="{{ asset('images/produk.png') }}"> Produk</a>
      <a href="{{ route('pembayaran') }}" class="menu-item"><img src="{{ asset('images/pembayaran.png') }}"> Pembayaran</a>
      <a href="{{ route('pesan') }}" class="menu-item"><img src="{{ asset('images/chat.png') }}"> Pesan</a>
      <a href="{{ route('pengaturan') }}" class="menu-item"><img src="{{ asset('images/settings.png') }}"> Pengaturan</a>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main-content">
    <div class="topbar">
      <a href="{{ route('notifikasi') }}"><img src="{{ asset('images/bell.png') }}" alt="Notifikasi"></a>
      <div class="profile"><div class="avatar">A</div><span>Admin Barbekuy</span></div>
    </div>

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
            <select><option>Filter Kategori</option></select>
            <select><option>Filter Status</option></select>
            <input type="text" placeholder="Cari Produk...">
          </div>
          <div class="icon-actions">
            <img src="{{ asset('images/icon-edit.png') }}" alt="Edit">
            <img src="{{ asset('images/icon-delete.png') }}" alt="Hapus" onclick="triggerDelete()">
          </div>
        </div>

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
            <tr>
              <td><input type="checkbox" class="rowCheck"></td>
              <td><strong>PR001</strong></td>
              <td>Paket Slice Ber-2</td>
              <td>Paket</td>
              <td>3</td>
              <td>Satu set paket ini berisi 1 paket...</td>
              <td>Rp125.000</td>
              <td><span class="status active">Aktif</span></td>
              <td><a onclick="openDetail('PR001')">Detail</a></td>
            </tr>
            <tr>
              <td><input type="checkbox" class="rowCheck"></td>
              <td><strong>PR002</strong></td>
              <td>Grill Gas 1 Tungku</td>
              <td>Non Paket</td>
              <td>2</td>
              <td>Alat grill yang memiliki 1 tungku...</td>
              <td>Rp45.000</td>
              <td><span class="status inactive">Tidak Aktif</span></td>
              <td><a onclick="openDetail('PR002')">Detail</a></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>

  <!-- POPUPS (Detail, Tambah, Edit, Hapus) -->
  <div class="popup" id="popupDetail">
    <div class="popup-content">
      <div class="popup-header">
        <h3>Detail Produk</h3>
        <button class="close-btn" onclick="closePopup('popupDetail')">&times;</button>
      </div>
      <img id="detailGambar" src="" alt="Gambar Produk" style="width:180px; height:180px; align-items: center; object-fit:cover; border-radius:10px;  margin: 0 auto 15px auto; /* ini yang bikin gambarnya pas di tengah */; display:block; border:1px solid #ccc;">
      <p><b>ID Produk:</b> <span id="detailID"></span></p>
      <p><b>Nama Produk:</b> <span id="detailNama"></span></p>
      <p><b>Kategori:</b> <span id="detailKategori"></span></p>
      <p><b>Stok:</b> <span id="detailStok"></span></p>
      <p><b>Deskripsi:</b> <span id="detailDeskripsi"></span></p>
      <p><b>Harga:</b> <span id="detailHarga"></span>/hari</p>
    </div>
  </div>

  <div class="popup" id="popupTambah">
    <div class="popup-content">
      <div class="popup-header"><h3>Tambah Produk</h3></div>
      <form>
        <label>Gambar Produk</label>
        <input type="file" id="gambarProduk" accept="image/*" onchange="previewImage(event)">
        <img id="previewGambar" src="" alt="Preview Gambar" style="width:100%; max-height:180px; object-fit:cover; border-radius:8px; display:none; border:1px solid #ccc; padding:4px;">
        <input type="text" placeholder="Nama Produk" required>
        <select><option>Paket</option><option>Non Paket</option></select>
        <input type="number" placeholder="Stok" required>
        <textarea placeholder="Deskripsi Singkat" required></textarea>
        <input type="text" placeholder="Harga Sewa/Hari" required>
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

<script>
  // Simpan semua gambar produk
  let produkImages = {
    "PR001": "{{ asset('images/paket ber4 xtra.png') }}",
    "PR002": "{{ asset('images/paket ber6 xtra.png') }}"
  };

  function openPopup(id){document.getElementById(id).style.display='flex';}
  function closePopup(id){document.getElementById(id).style.display='none';}

  // DETAIL PRODUK
  function openDetail(id){
    const row = [...document.querySelectorAll('tbody tr')].find(r=>r.querySelector('td strong').innerText===id);
    if(!row) return;
    const cells = row.querySelectorAll('td');
    document.getElementById('detailID').innerText = cells[1].innerText;
    document.getElementById('detailNama').innerText = cells[2].innerText;
    document.getElementById('detailKategori').innerText = cells[3].innerText;
    document.getElementById('detailStok').innerText = cells[4].innerText;
    document.getElementById('detailDeskripsi').innerText = cells[5].innerText;
    document.getElementById('detailHarga').innerText = cells[6].innerText;
    document.getElementById('detailGambar').src = produkImages[id] || '{{ asset('images/default-produk.jpg') }}';
    openPopup('popupDetail');
  }

  // CHECK ALL
  document.getElementById('checkAll').addEventListener('change', function(){
    document.querySelectorAll('.rowCheck').forEach(c=>c.checked=this.checked);
  });

  // HAPUS PRODUK
  let rowsToDelete = [];
  function triggerDelete(){
    rowsToDelete = [...document.querySelectorAll('.rowCheck:checked')].map(c=>c.closest('tr'));
    if(rowsToDelete.length===0){alert('Pilih produk yang ingin dihapus!'); return;}
    openPopup('popupHapus');
  }
  function confirmDelete(){
    rowsToDelete.forEach(row=>{
      const id = row.querySelector('td strong').innerText;
      delete produkImages[id]; // hapus gambar
      row.remove();
    });
    closePopup('popupHapus');
  }

  // PREVIEW GAMBAR TAMBAH
  function previewImage(event){
    const img=document.getElementById('previewGambar');
    const file=event.target.files[0];
    if(file){
      const reader=new FileReader();
      reader.onload=e=>{
        img.src=e.target.result; img.style.display='block';
      };
      reader.readAsDataURL(file);
    }
  }

  // TAMBAH PRODUK
  document.querySelector('#popupTambah form').onsubmit = e=>{
    e.preventDefault();
    const form=e.target;
    const file=form.querySelector('#gambarProduk').files[0];
    const nama=form.querySelector('input[placeholder="Nama Produk"]').value;
    const kategori=form.querySelector('select').value;
    const stok=form.querySelector('input[placeholder="Stok"]').value;
    const deskripsi=form.querySelector('textarea').value;
    const harga=form.querySelector('input[placeholder="Harga Sewa/Hari"]').value;
    if(!file) return alert('Pilih gambar produk terlebih dahulu!');
    const reader=new FileReader();
    reader.onload=e2=>{
      const tbody=document.querySelector('table tbody');
      const idProduk='PR'+String(tbody.rows.length+1).padStart(3,'0');
      const row=document.createElement('tr');
      row.innerHTML=`
        <td><input type='checkbox' class='rowCheck'></td>
        <td><strong>${idProduk}</strong></td>
        <td>${nama}</td>
        <td>${kategori}</td>
        <td>${stok}</td>
        <td>${deskripsi}</td>
        <td>${harga}</td>
        <td><span class='status active'>Aktif</span></td>
        <td><a onclick="openDetail('${idProduk}')">Detail</a></td>
      `;
      tbody.appendChild(row);
      produkImages[idProduk]=e2.target.result;
      form.reset();
      document.getElementById('previewGambar').style.display='none';
      closePopup('popupTambah');
    };
    reader.readAsDataURL(file);
  };

  // EDIT PRODUK
  const editIcon=document.querySelector('.icon-actions img[alt="Edit"]');
  if(editIcon){
    editIcon.addEventListener('click', ()=>{
      const selected=[...document.querySelectorAll('.rowCheck:checked')];
      if(selected.length===0){alert('Pilih produk yang ingin diedit!'); return;}
      if(selected.length>1){alert('Hanya bisa mengedit satu produk!'); return;}
      const row=selected[0].closest('tr');
      const id=row.querySelector('td strong').innerText;
      const cells=row.querySelectorAll('td');
      const popup=document.getElementById('popupEdit');
      const form=popup.querySelector('form');
      form.innerHTML=`
        <label>Gambar Produk</label>
        <input type="file" id="editGambarProduk" accept="image/*">
        <img id="previewEditGambar" src="${produkImages[id]}" style="width:180px; height:180px; align-items: center; object-fit:cover; border-radius:10px;  margin: 0 auto 15px auto; /* ini yang bikin gambarnya pas di tengah */; display:block; border:1px solid #ccc;">
        <input type="text" placeholder="Nama Produk" value="${cells[2].innerText}">
        <select>
          <option ${cells[3].innerText==='Paket'?'selected':''}>Paket</option>
          <option ${cells[3].innerText==='Non Paket'?'selected':''}>Non Paket</option>
        </select>
        <input type="number" placeholder="Stok" value="${cells[4].innerText}">
        <textarea placeholder="Deskripsi">${cells[5].innerText}</textarea>
        <input type="text" placeholder="Harga Sewa/Hari" value="${cells[6].innerText}">
        <div class="popup-footer">
          <button type="button" class="btn btn-secondary" onclick="closePopup('popupEdit')">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      `;

      const fileInput=form.querySelector('#editGambarProduk');
      const preview=form.querySelector('#previewEditGambar');
      fileInput.addEventListener('change', e=>{
        const f=e.target.files[0];
        if(f){
          const reader=new FileReader();
          reader.onload=ev=>{
            preview.src=ev.target.result;
            produkImages[id]=ev.target.result;
          };
          reader.readAsDataURL(f);
        }
      });

      form.onsubmit=ev=>{
        ev.preventDefault();
        cells[2].innerText=form.querySelector('input[placeholder="Nama Produk"]').value;
        cells[3].innerText=form.querySelector('select').value;
        cells[4].innerText=form.querySelector('input[placeholder="Stok"]').value;
        cells[5].innerText=form.querySelector('textarea').value;
        cells[6].innerText=form.querySelector('input[placeholder="Harga Sewa/Hari"]').value;
        closePopup('popupEdit');
      };

      openPopup('popupEdit');
    });
  }
</script>
</body>
</html>
