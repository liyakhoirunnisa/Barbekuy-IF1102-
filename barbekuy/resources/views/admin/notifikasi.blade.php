<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Notifikasi | Barbekuy</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #f5f6fa;
      display: flex;
      min-height: 100vh;
    }

    /* === CONTENT === */
    .content {
      flex: 1;
      padding: 30px 40px;
      overflow-y: auto;
    }

    .content-box {
      background: #fff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
      padding: 28px;
    }

    .content-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .content-header h2 {
      font-size: 20px;
      font-weight: 600;
      color: #751A25;
    }

    /* Notifikasi Section */
    .notif-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      gap: 12px;
    }

    .notif-actions select {
      padding: 8px 12px;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 13px;
      outline: none;
      background: #fff;
    }

    .notif-actions .filter-right {
      color: #751A25;
      border: 1px solid #751A25;
      background: #fff;
    }

    .notif-section {
      margin-bottom: 25px;
    }

    .notif-section h4 {
      font-size: 15px;
      margin-bottom: 12px;
      color: #751A25;
      font-weight: 600;
    }

    .notif-item {
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
      padding: 14px 20px;
      display: grid;
      grid-template-columns: 1fr 130px 100px;
      align-items: center;
      margin-bottom: 10px;
      transition: 0.2s;
      column-gap: 30px;
    }

    .notif-item:hover {
      background: #f8f8f8;
    }

    .notif-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .notif-left input[type="checkbox"] {
      transform: scale(1.2);
      cursor: pointer;
    }

    .notif-message {
      font-size: 14px;
      color: #333;
    }

    .notif-message b {
      color: #751A25;
    }

    .notif-time {
      font-size: 13px;
      color: gray;
      text-align: right;
      margin-right: 10px;
    }

    .notif-status {
      font-size: 13px;
      font-weight: 500;
      text-align: right;
      min-width: 90px;
      cursor: pointer;
    }

    .notif-status.baca {
      color: gray;
    }

    .notif-status.belum {
      color: #751A25;
    }

    /* Popup */
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.4);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 999;
    }

    .popup-box {
      background: #fff;
      border-radius: 16px;
      width: 380px;
      padding: 30px 28px;
      text-align: center;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
      animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .popup-box h3 {
      color: #751A25;
      font-size: 18px;
      margin-bottom: 12px;
      font-weight: 600;
    }

    .popup-box p {
      color: #555;
      font-size: 14px;
      margin-bottom: 25px;
    }

    .popup-buttons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .popup-buttons button {
      border: none;
      padding: 8px 20px;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn-cancel {
      background: #fff;
      color: #751A25;
      border: 1px solid #751A25;
    }

    .btn-cancel:hover {
      background: #f4f4f4;
    }

    .btn-delete {
      background: #751A25;
      color: #fff;
    }

    .btn-delete:hover {
      opacity: 0.9;
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
          <h2>Notifikasi</h2>
        </div>

        {{-- Actions bar --}}
        <div class="notif-actions">
          {{-- Left: select aksi --}}
          <select id="notif-action">
            <option value="">Pilih</option>
            <option value="read-all">Tandai semua dibaca</option>
            <option value="hapus">Hapus</option>
          </select>

          {{-- Right: filter --}}
          <form method="GET" action="{{ route('admin.notifikasi.index') }}">
            <select class="filter-right" name="filter" onchange="this.form.submit()">
              <option value="all" {{ ($filter??'all')==='all' ? 'selected' : '' }}>Semua</option>
              <option value="unread" {{ ($filter??'')==='unread' ? 'selected' : '' }}>Belum dibaca</option>
              <option value="read" {{ ($filter??'')==='read' ? 'selected' : '' }}>Sudah dibaca</option>
            </select>
          </form>
        </div>

        {{-- ================== List dinamis dengan grouping ================== --}}
        @php
        use Carbon\Carbon;
        $today = $notifications->filter(fn($n) => optional($n->created_at)->isToday());
        $yesterday = $notifications->filter(fn($n) => optional($n->created_at)->isYesterday());
        $earlier = $notifications->filter(fn($n) => $n->created_at && !$n->created_at->isToday() && !$n->created_at->isYesterday());
        @endphp

        {{-- Hari ini --}}
        @if($today->count())
        <div class="notif-section">
          <h4>Hari ini</h4>
          @foreach($today as $n)
          @php
          $data = $n->data ?? [];
          $pesan = $data['pesan'] ?? 'Ada aktivitas baru';
          $waktu = optional($n->created_at)->diffForHumans();
          $unread = is_null($n->read_at);
          @endphp
          @php
          // URL tujuan ke halaman Transaksi (pakai query ?order=ID untuk highlight/filternya)
          $toUrl = route('admin.transaksi') . '?order=' . urlencode($data['id_pesanan'] ?? '');
          $readUrl = route('admin.notifikasi.read', $n->id);
          @endphp

          <div class="notif-item"
            data-read-url="{{ $readUrl }}"
            data-to-url="{{ $toUrl }}"
            style="cursor:pointer">
            <div class="notif-left">
              {{-- cegah klik checkbox ikut redirect --}}
              <input type="checkbox" class="chk" value="{{ $n->id }}" onclick="event.stopPropagation()">
              <div class="notif-message">
                @php $nama = $data['nama_pengguna'] ?? 'Pelanggan'; @endphp
                <b>{{ $nama }}</b> melakukan pemesanan
                @if(!empty($data['id_pesanan'])) <b>#{{ $data['id_pesanan'] }}</b>@endif
              </div>
            </div>
            <div class="notif-time">{{ $waktu }}</div>

            {{-- tombol status tetap ada, tapi jangan ikut trigger redirect --}}
            <div class="notif-status {{ $unread ? 'belum' : 'baca' }}" style="text-align:right" onclick="event.stopPropagation()">
              <form method="POST" action="{{ route('admin.notifikasi.read',$n->id) }}" onclick="event.stopPropagation()">
                @csrf
                <button type="submit" style="all:unset;cursor:pointer">{{ $unread ? 'Belum dibaca' : 'Baca' }}</button>
              </form>
            </div>
          </div>
          @endforeach
        </div>
        @endif

        {{-- Kemarin --}}
        @if($yesterday->count())
        <div class="notif-section">
          <h4>Kemarin</h4>
          @foreach($yesterday as $n)
          @php
          $data = $n->data ?? [];
          $pesan = $data['pesan'] ?? 'Ada aktivitas baru';
          $waktu = optional($n->created_at)->diffForHumans();
          $unread = is_null($n->read_at);
          @endphp
          @php
          // URL tujuan ke halaman Transaksi (pakai query ?order=ID untuk highlight/filternya)
          $toUrl = route('admin.transaksi') . '?order=' . urlencode($data['id_pesanan'] ?? '');
          $readUrl = route('admin.notifikasi.read', $n->id);
          @endphp

          <div class="notif-item"
            data-read-url="{{ $readUrl }}"
            data-to-url="{{ $toUrl }}"
            style="cursor:pointer">
            <div class="notif-left">
              {{-- cegah klik checkbox ikut redirect --}}
              <input type="checkbox" class="chk" value="{{ $n->id }}" onclick="event.stopPropagation()">
              <div class="notif-message">
                @php $nama = $data['nama_pengguna'] ?? 'Pelanggan'; @endphp
                <b>{{ $nama }}</b> melakukan pemesanan
                @if(!empty($data['id_pesanan'])) <b>#{{ $data['id_pesanan'] }}</b>@endif
              </div>
            </div>
            <div class="notif-time">{{ $waktu }}</div>

            {{-- tombol status tetap ada, tapi jangan ikut trigger redirect --}}
            <div class="notif-status {{ $unread ? 'belum' : 'baca' }}" style="text-align:right" onclick="event.stopPropagation()">
              <form method="POST" action="{{ route('admin.notifikasi.read',$n->id) }}" onclick="event.stopPropagation()">
                @csrf
                <button type="submit" style="all:unset;cursor:pointer">{{ $unread ? 'Belum dibaca' : 'Baca' }}</button>
              </form>
            </div>
          </div>
          @endforeach
        </div>
        @endif

        {{-- Lebih lama --}}
        @if($earlier->count())
        <div class="notif-section">
          <h4>Sebelumnya</h4>
          @foreach($earlier as $n)
          @php
          $data = $n->data ?? [];
          $pesan = $data['pesan'] ?? 'Ada aktivitas baru';
          // tampilkan tanggal + jam untuk yang lama
          $waktu = optional($n->created_at)->translatedFormat('d M Y, H:i');
          $unread = is_null($n->read_at);
          @endphp
          @php
          // URL tujuan ke halaman Transaksi (pakai query ?order=ID untuk highlight/filternya)
          $toUrl = route('admin.transaksi') . '?order=' . urlencode($data['id_pesanan'] ?? '');
          $readUrl = route('admin.notifikasi.read', $n->id);
          @endphp

          <div class="notif-item"
            data-read-url="{{ $readUrl }}"
            data-to-url="{{ $toUrl }}"
            style="cursor:pointer">
            <div class="notif-left">
              {{-- cegah klik checkbox ikut redirect --}}
              <input type="checkbox" class="chk" value="{{ $n->id }}" onclick="event.stopPropagation()">
              <div class="notif-message">
                @php $nama = $data['nama_pengguna'] ?? 'Pelanggan'; @endphp
                <b>{{ $nama }}</b> melakukan pemesanan
                @if(!empty($data['id_pesanan'])) <b>#{{ $data['id_pesanan'] }}</b>@endif
              </div>
            </div>
            <div class="notif-time">{{ $waktu }}</div>

            {{-- tombol status tetap ada, tapi jangan ikut trigger redirect --}}
            <div class="notif-status {{ $unread ? 'belum' : 'baca' }}" style="text-align:right" onclick="event.stopPropagation()">
              <form method="POST" action="{{ route('admin.notifikasi.read',$n->id) }}" onclick="event.stopPropagation()">
                @csrf
                <button type="submit" style="all:unset;cursor:pointer">{{ $unread ? 'Belum dibaca' : 'Baca' }}</button>
              </form>
            </div>
          </div>

          @endforeach
        </div>
        @endif

        {{-- Jika kosong total --}}
        @if(!$today->count() && !$yesterday->count() && !$earlier->count())
        <p style="color:#777">Belum ada notifikasi.</p>
        @endif

        {{-- Pagination --}}
        <div style="margin-top:12px">{{ $notifications->withQueryString()->links() }}</div>
      </div>
    </div>
  </main>

  <!-- Popup Konfirmasi -->
  <div class="popup-overlay" id="popupHapus">
    <div class="popup-box">
      <h3>Hapus Notifikasi?</h3>
      <p>Apakah Anda yakin ingin menghapus notifikasi yang dipilih?</p>
      <div class="popup-buttons">
        <button class="btn-cancel" onclick="closePopup()">Batal</button>
        <form id="bulkDeleteForm" method="POST" action="{{ route('admin.notifikasi.bulkDestroy') }}">
          @csrf @method('DELETE')
          <div id="bulkIds"></div>
          <button class="btn-delete" type="submit">Hapus</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Form tandai semua dibaca (disembunyikan) --}}
  <form id="formReadAll" method="POST" action="{{ route('admin.notifikasi.readAll') }}" style="display:none;">
    @csrf
  </form>

  <script>
    // Ambil CSRF token dari meta
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;

    // Klik satu baris notif -> POST mark-as-read -> redirect ke Transaksi
    document.querySelectorAll('.notif-item').forEach(row => {
      row.addEventListener('click', async () => {
        const readUrl = row.dataset.readUrl;
        const toUrl = row.dataset.toUrl;

        if (!toUrl) return;

        // tandai dibaca (silent fail jika error)
        if (readUrl && CSRF) {
          try {
            await fetch(readUrl, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': CSRF
              }
            });
          } catch (e) {
            /* abaikan error */ }
        }

        // redirect ke halaman transaksi (dengan ?order=xxx)
        window.location.href = toUrl;
      });
    });
    const selectAction = document.getElementById("notif-action");
    const popup = document.getElementById("popupHapus");
    const bulkIds = document.getElementById("bulkIds");

    selectAction.addEventListener("change", function() {
      if (this.value === "hapus") {
        // kumpulkan id terpilih
        const ids = Array.from(document.querySelectorAll(".chk:checked")).map(c => c.value);
        if (!ids.length) {
          alert("Pilih notifikasi yang ingin dihapus.");
          this.value = "";
          return;
        }
        // isi hidden inputs
        bulkIds.innerHTML = "";
        ids.forEach(id => {
          const inp = document.createElement("input");
          inp.type = "hidden";
          inp.name = "ids[]";
          inp.value = id;
          bulkIds.appendChild(inp);
        });
        popup.style.display = "flex";
        this.value = "";
      } else if (this.value === "read-all") {
        document.getElementById("formReadAll").submit();
        this.value = "";
      }
    });

    function closePopup() {
      popup.style.display = "none";
    }
  </script>
</body>

</html>