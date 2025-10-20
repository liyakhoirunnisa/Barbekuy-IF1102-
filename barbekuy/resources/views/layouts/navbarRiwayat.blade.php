<div class="tabs">
    <a href="/riwayatSemua" class="{{ request()->is('riwayatSemua') ? 'active' : '' }}">Semua</a>
    <a href="/riwayatProses" class="{{ request()->is('riwayatProses') ? 'active' : '' }}">Sedang Proses</a>
    <a href="/riwayatSelesai" class="{{ request()->is('riwayatSelesai') ? 'active' : '' }}">Selesai</a>
    <a href="/riwayatBatal" class="{{ request()->is('riwayatBatal') ? 'active' : '' }}">Dibatalkan</a>
</div>
