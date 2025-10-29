<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Pembayaran | Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <!-- Tambahan Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
    body { background:#f5f6fa; display:flex; min-height:100vh; }


    /* Content */
    .content { flex:1; padding:30px 40px; }
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
    .icon-actions i {
  font-size:18px; /* tetap ukuran bawaan pembayaran */
  cursor:pointer;
  transition:0.3s;
  color:#751A25; /* samakan warna dengan halaman produk */
}
.icon-actions i:hover {
  transform:scale(1.1);
}
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

    /* Checkbox */
    th:first-child, td:first-child {
      text-align: center;
      width: 50px;
    }
    input[type="checkbox"] {
      transform: scale(1.2);
      cursor: pointer;
    }

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
    #popupTambah form { display:flex; flex-direction:column; gap:12px; }
    #popupTambah form input, #popupTambah form select, #popupTambah form textarea { width:100%; padding:10px 12px; border:1px solid #dcdcdc; border-radius:6px; font-size:14px; outline:none; background:#fff; }
    #popupTambah form textarea { min-height:80px; resize:vertical; }
    #popupTambah .popup-footer { display:flex; justify-content:flex-end; gap:10px; margin-top:10px; }
    #popupTambah .btn-primary { background:#751A25; color:#fff; } 
    #popupTambah .btn-primary:hover{background:#3d030a;}
    #popupTambah .btn-secondary { background:#fff; color:#751A25; border:1px solid #751A25; } 
    #popupTambah .btn-secondary:hover{background:#f4f0f0;}

.status-badge {
  padding: 6px 12px;
  border-radius: 6px;
  font-size: 13px;
  font-weight: 500;
  color: #751A25;
}
.status-badge.sukses { background-color: #D9FBE4; color: #1B5E20; }
.status-badge.pending { background-color: #FFE8C2; color: #BF360C; }
.status-badge.gagal { background-color: #F8D7DA; color: #C62828; }

/* === Popup Detail Pembayaran === */
#popupDetail .popup-content {
  border-top: 8px solid #751A25;
  border-radius: 12px;
  background: #fff;
  padding: 30px 35px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.15);
}

#popupDetail .popup-header h3 {
  color: #751A25;
  font-size: 20px;
  font-weight: 600;
}

#popupDetail table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

#popupDetail table td {
  padding: 8px 4px;
  font-size: 14px;
  color: #333;
  vertical-align: top;
}

#popupDetail table td:first-child {
  font-weight: 600;
  color: #751A25;
  width: 45%;
}

#popupDetail table tr:not(:last-child) td {
  border-bottom: 1px solid #eee;
  padding-bottom: 10px;
}

#popupDetail .popup-footer {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

#popupDetail .popup-footer .btn {
  border-radius: 8px;
  font-weight: 500;
  transition: 0.3s ease;
}

#popupDetail .btn-primary {
  background: #751A25;
  color: #fff;
}

#popupDetail .btn-primary:hover {
  background: #3d030a;
}

#popupDetail .btn-secondary {
  background: #f8f8f8;
  border: 1px solid #ccc;
  color: #555;
}

#popupDetail .btn-secondary[disabled] {
  opacity: 0.8;
  cursor: not-allowed;
}

  </style>
</head>

<body>
  {{-- 🔹 Sidebar + Topbar --}}
  @include('layouts.navbarAdmin')

  <!-- Main Content -->
  <main class="main-content">
    <div class="content">
      <div class="content-box">
        <div class="content-header">
          <h2>Manajemen Pembayaran</h2>
          <button class="btn btn-primary">Export Excel</button>
        </div>

        <div class="filters">
          <div class="filter-group">
            <select><option>Filter Tanggal</option></select>
            <select><option>Filter Status</option></select>
            <input type="text" placeholder="Cari Nama/ID...">
          </div>
          <div class="icon-actions">
            <i class="fa-solid fa-pen-to-square" title="Edit" id="iconEdit" ></i>
            <i class="fa-solid fa-trash" title="Hapus" id="iconDelete" onclick="triggerDelete()"></i>
          </div>
        </div>

        <table>
          <thead>
            <tr>
              <th><input type="checkbox" id="selectAll" title="Pilih semua"></th>
              <th>ID Pembayaran</th>
              <th>ID Transaksi</th>
              <th>Tanggal Pembayaran</th>
              <th>Nama</th>
              <th>Metode</th>
              <th>Total</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="checkbox" class="select-item"></td>
              <td>PAY001</td>
              <td>TRX001</td>
              <td>12/10/2025</td>
              <td>Zahra Poetri</td>
              <td>COD</td>
              <td>Rp250.000</td>
              <td><span class="status-badge sukses">Sudah Dibayar</span></td>
              <td><a onclick="openPopup('popupDetail')">Detail</a></td>
            </tr>
            <tr>
              <td><input type="checkbox" class="select-item"></td>
              <td>PAY002</td>
              <td>TRX002</td>
              <td>13/10/2025</td>
              <td>Nia Novela</td>
              <td>E-Wallet</td>
              <td>Rp400.000</td>
              <td><span class="status-badge pending">Pending</span></td>
              <td><a onclick="openPopup('popupDetail')">Detail</a></td>
            </tr>
            <tr>
              <td><input type="checkbox" class="select-item"></td>
              <td>PAY003</td>
              <td>TRX003</td>
              <td>14/10/2025</td>
              <td>Liya Khairunisa</td>
              <td>E-Wallet</td>
              <td>Rp125.000</td>
              <td><span class="status-badge gagal">Gagal</span></td>
              <td><a onclick="openPopup('popupDetail')">Detail</a></td>
            </tr>
          </tbody>
        </table>

      </div>
    </div>
  </main>

  <!-- POPUP DETAIL PEMBAYARAN -->
<div class="popup" id="popupDetail">
  <div class="popup-content" style="max-width:450px;">
    <div class="popup-header">
      <h3>Detail Pembayaran</h3>
      <button class="close-btn" onclick="closePopup('popupDetail')">&times;</button>
    </div>
    <table style="width:100%; border-collapse:collapse;">
      <tr><td><strong>ID Pembayaran:</strong></td><td>PAY001</td></tr>
      <tr><td><strong>ID Transaksi:</strong></td><td>TRX001</td></tr>
      <tr><td><strong>Tanggal Pembayaran:</strong></td><td>12/10/2025</td></tr>
      <tr><td><strong>Nama:</strong></td><td>Zahra Poetri</td></tr>
      <tr><td><strong>Metode Pembayaran:</strong></td><td>COD</td></tr>
      <tr><td><strong>Subtotal Pesanan:</strong></td><td>Rp245.000</td></tr>
      <tr><td><strong>Biaya Layanan:</strong></td><td>Rp5.000</td></tr>
      <tr><td><strong>Total Pembayaran:</strong></td><td>Rp250.000</td></tr>
      <tr><td><strong>Status Pembayaran:</strong></td><td>Sudah Dibayar</td></tr>
    </table>

    <div class="popup-footer" style="margin-top:20px; flex-direction:column; gap:10px;">
      <button class="btn btn-secondary" disabled style="width:100%;">Pembayaran diterima dan diverifikasi</button>
      <button class="btn btn-primary" style="width:100%; display:flex; align-items:center; justify-content:center; gap:8px;">
        <img src="{{ asset('images/bukti.png') }}" style="width:18px;"> Bukti Pembayaran
      </button>
    </div>
  </div>
</div>

<!-- POPUP EDIT PEMBAYARAN -->
<div class="popup" id="popupEdit">
  <div class="popup-content" style="max-width:500px;">
    <div class="popup-header">
      <h3>Edit Data Pembayaran</h3>
    </div>
    <form id="formEditPembayaran">
      <label>ID Pembayaran</label>
      <input type="text" id="edit_id_pembayaran" value="PAY001" disabled>

      <label>ID Transaksi</label>
      <input type="text" id="edit_id_transaksi" value="TRX001" disabled>

      <label>Nama</label>
      <input type="text" id="edit_nama" value="Zahra Poetri">

      <label>Metode Pembayaran</label>
      <select id="edit_metode">
        <option>COD</option>
        <option>E-Wallet</option>
        <option>Transfer Bank</option>
      </select>

      <label>Status Pembayaran</label>
      <select id="edit_status">
        <option>Sudah Dibayar</option>
        <option>Pending</option>
        <option>Gagal</option>
      </select>

      <div class="popup-footer">
        <button type="button" class="btn btn-secondary" onclick="closePopup('popupEdit')">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<!-- POPUP HAPUS PEMBAYARAN -->
<div class="popup popup-hapus" id="popupHapus">
  <div class="popup-content" style="max-width:400px;">
    <h3>Hapus Data Pembayaran</h3>
    <p>Apakah kamu yakin ingin menghapus data pembayaran <strong id="hapusTarget">PAY001</strong> ini?</p>
    <div class="popup-footer" style="justify-content:center;">
      <button class="btn btn-secondary" onclick="closePopup('popupHapus')">Batal</button>
      <button class="btn btn-primary" id="confirmDeleteBtn">Hapus</button>
    </div>
  </div>
</div>

<script>
  // tetap pertahankan fungsi open/close popup
  function openPopup(id){ document.getElementById(id).style.display='flex'; }
  function closePopup(id){ document.getElementById(id).style.display='none'; }

  // helper: ambil baris yang dicentang
  function getSelectedRows(){
    return Array.from(document.querySelectorAll('.select-item')).filter(chk=>chk.checked).map(chk=>chk.closest('tr'));
  }

  // helper: ambil ID pembayaran dari baris <td> pertama setelah checkbox
  function getIdFromRow(row){
    // kolom: 0=checkbox, 1=ID Pembayaran
    const cells = row.querySelectorAll('td');
    return cells[1].innerText.trim();
  }

  document.addEventListener('DOMContentLoaded', function(){
    // select all behavior
    const selectAll = document.getElementById('selectAll');
    const items = document.querySelectorAll('.select-item');

    if(selectAll){
      selectAll.addEventListener('change', () => {
        items.forEach(chk => chk.checked = selectAll.checked);
      });
    }

    // ikon edit & delete di atas filter
const editIcon = document.getElementById('iconEdit');
const deleteIcon = document.getElementById('iconDelete');


    if(editIcon){
      editIcon.addEventListener('click', function(){
        const selected = getSelectedRows();
        if(selected.length === 0){
          alert('Pilih data pembayaran yang ingin diedit!');
          return;
        }
        if(selected.length > 1){
          alert('Hanya bisa mengedit satu data sekaligus!');
          return;
        }
        // satu item dipilih -> isi popup edit dengan data dari baris
        const row = selected[0];
        const cells = row.querySelectorAll('td');
        // cells[1] = ID Pembayaran, cells[2] = ID Transaksi, cells[4] = Nama, cells[5] = Metode, cells[6] = Total, cells[7] = Status
        const idPembayaran = cells[1].innerText.trim();
        const idTransaksi = cells[2].innerText.trim();
        const nama = cells[4].innerText.trim();
        const metode = cells[5].innerText.trim();
        const statusText = cells[7].innerText.trim();

        // Set nilai ke form edit (elemen ada di popupEdit)
        const elIdPembayaran = document.getElementById('edit_id_pembayaran');
        const elIdTransaksi = document.getElementById('edit_id_transaksi');
        const elNama = document.getElementById('edit_nama');
        const elMetode = document.getElementById('edit_metode');
        const elStatus = document.getElementById('edit_status');

        if(elIdPembayaran) elIdPembayaran.value = idPembayaran;
        if(elIdTransaksi) elIdTransaksi.value = idTransaksi;
        if(elNama) elNama.value = nama;
        if(elMetode){
          // pilih opsi metode jika ada, fallback ke opsi pertama
          const opt = Array.from(elMetode.options).find(o => o.text === metode);
          if(opt) elMetode.value = opt.value;
        }
        if(elStatus){
          const optS = Array.from(elStatus.options).find(o => o.text.toLowerCase().includes(statusText.toLowerCase()));
          if(optS) elStatus.value = optS.value;
        }

        openPopup('popupEdit');
      });
    }

    if(deleteIcon){
      deleteIcon.addEventListener('click', function(){
        const selected = getSelectedRows();
        if(selected.length === 0){
          alert('Pilih data pembayaran yang ingin dihapus!');
          return;
        }
        // kumpulkan id pembayaran untuk ditampilkan di popup
        const ids = selected.map(r => getIdFromRow(r));
        const targetEl = document.getElementById('hapusTarget');
        if(targetEl){
          targetEl.innerText = ids.join(', ');
        }
        // set behavior tombol konfirmasi hapus: hapus baris yang dipilih
        const confirmBtn = document.getElementById('confirmDeleteBtn');
        if(confirmBtn){
          // hapus handler sebelumnya (jika ada) agar tidak menumpuk
          confirmBtn.replaceWith(confirmBtn.cloneNode(true));
        }
        const newConfirm = document.getElementById('confirmDeleteBtn');
        newConfirm.addEventListener('click', function(){
          // hapus baris
          selected.forEach(r => r.remove());
          closePopup('popupHapus');
        });
        openPopup('popupHapus');
      });
    }

    // submit form edit: update tampilan tabel sesuai nilai baru
    const formEdit = document.getElementById('formEditPembayaran');
    if(formEdit){
      formEdit.addEventListener('submit', function(e){
        e.preventDefault();
        // cari baris yang dipilih
        const selected = getSelectedRows();
        if(selected.length !== 1){
          alert('Tidak ada baris yang valid untuk disimpan.');
          closePopup('popupEdit');
          return;
        }
        const row = selected[0];
        const cells = row.querySelectorAll('td');
        // update cells sesuai input form
        const newNama = document.getElementById('edit_nama').value;
        const newMetode = document.getElementById('edit_metode').value;
        const newStatus = document.getElementById('edit_status').value;

        // cells positions: 0=checkbox,1=idPembayaran,2=idTransaksi,3=tanggal,4=nama,5=metode,6=total,7=status,8=aksi
        cells[4].innerText = newNama;
        cells[5].innerText = newMetode;
        // update status badge (simple replacement)
        const statusCell = cells[7];
        statusCell.innerHTML = '<span class="status-badge">' + newStatus + '</span>';
        closePopup('popupEdit');
      });
    }
  });
</script>

</body>
</html>
