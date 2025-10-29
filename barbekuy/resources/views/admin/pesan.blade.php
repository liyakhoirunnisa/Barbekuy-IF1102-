<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Barbekuy - Pesan (Admin)</title>
  <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
   <!-- Tambahan Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * { margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
    body { background:#f5f6fa; display:flex; min-height:100vh; }

    /* === SIDEBAR === */
    .sidebar {
      width:240px;
      background:#751A25;
      color:#fff;
      display:flex;
      flex-direction:column;
      align-items:center;
      padding-top:20px;
    }
    .logo {
      height:110px;
      display:flex;
      align-items:center;
      justify-content:center;
      background:#751A25;
    }
    .logo img {
      width:190px;
      height:auto;
      object-fit:contain;
      position:relative;
      top:-18px;
    }
    .menu {
      width:100%;
      margin-top:-3px;
    }
    .menu-item {
      display:flex;
      align-items:center;
      gap:12px;
      padding:14px 26px;
      color:#fff;
      font-size:14px;
      text-decoration:none;
      transition:0.3s;
    }
    .menu-item i {
      font-size:18px;
      width:20px;
      text-align:center;
    }
    .menu-item:hover,
    .menu-item.active {
      background:rgba(255,255,255,0.15);
      border-radius:10px;
    }
    .notif {
      background:#fff;
      color:#751A25;
      font-size:11px;
      padding:2px 8px;
      border-radius:12px;
      margin-left:auto;
      font-weight:600;
    }

    /* === MAIN & TOPBAR === */
    .main-content { flex:1; display:flex; flex-direction:column; height:100vh; overflow:hidden; }
    .topbar {
      height:110px;
      background:#751A25;
      display:flex;
      align-items:center;
      justify-content:flex-end;
      padding:0 40px;
      box-shadow:0 2px 5px rgba(0,0,0,0.1);
      gap:25px;
    }
    .topbar a { display:flex; align-items:center; justify-content:center; height:55px; position:relative; }
    .topbar a i {
      font-size:22px;
      color:#fff;
      cursor:pointer;
      transition:0.3s;
      position:relative;
      top:2px;
    }
    .topbar a i:hover { transform:scale(1.1); }
    .badgeNotif {
      position:absolute;
      top:5px;
      right:8px;
      background:red;
      color:#fff;
      font-size:11px;
      padding:2px 6px;
      border-radius:50%;
    }
    .profile {
      height:55px;
      display:flex;
      align-items:center;
      gap:10px;
      background:#fff;
      color:#751A25;
      padding:6px 14px;
      border-radius:30px;
      font-weight:500;
    }
    .avatar {
      background:#751A25;
      color:#fff;
      width:32px;
      height:32px;
      border-radius:50%;
      display:flex;
      align-items:center;
      justify-content:center;
      font-weight:600;
    }

    /* === CHAT AREA === */
    .content {
      flex:1;
      display:flex;
      gap:28px;
      padding:30px 40px;
      height:calc(100vh - 110px);
      box-sizing:border-box;
    }

    .list-panel {
      width:360px;
      background:#fff;
      border-radius:12px;
      padding:18px;
      box-shadow:0 6px 18px rgba(0,0,0,0.06);
      display:flex;
      flex-direction:column;
      gap:12px;
      height:100%;
      overflow:hidden;
    }

    .search { display:flex; align-items:center; gap:10px; background:#f4f0f0; padding:10px; border-radius:10px; }
    .search input { border:0; background:transparent; outline:none; width:100%; font-size:14px; color:#7f8a93; }

    .contacts { overflow-y:auto; flex:1; max-height:calc(100% - 80px); padding-right:6px; }
    .contact { display:flex; gap:12px; padding:12px; border-radius:8px; align-items:center; cursor:pointer; border-bottom:1px solid #f1f3f5; }
    .contact:hover { background:#fbfbfc; }
    .contact.active { background:#fff; box-shadow:0 2px 8px rgba(16,24,32,0.04); }
    .contact .thumb { width:48px; height:48px; border-radius:50%; background:#eceff1; display:grid; place-items:center; color:#656d72; font-weight:600; }
    .contact .meta { flex:1; }
    .contact .meta .name { font-weight:600; }
    .contact .meta .last { font-size:13px; color:#7f8a93; margin-top:6px; }
    .badge { background:#c0392b; color:#fff; padding:4px 8px; border-radius:12px; font-weight:600; font-size:12px; }

    .chat-panel {
      flex:1;
      background:#fff;
      border-radius:12px;
      box-shadow:0 6px 18px rgba(0,0,0,0.06);
      padding:22px;
      display:flex;
      flex-direction:column;
      height:100%;
      overflow:hidden;
    }

    .chat-header { display:flex; align-items:center; gap:14px; padding-bottom:8px; border-bottom:1px solid #f1f3f5; margin-bottom:12px; }
    .chat-header .profile { display:flex; gap:14px; align-items:center; background:transparent; color:inherit; }
    .chat-header .profile .thumb { width:64px; height:64px; border-radius:50%; background:#eaeff1; display:grid; place-items:center; font-weight:700; }
    .chat-header h3 { margin:0; font-size:20px; }
    .chat-header .meta { color:#7f8a93; font-size:13px; }

    .messages { flex:1; overflow-y:auto; padding:10px 6px 18px 6px; display:flex; flex-direction:column; gap:18px; }
    .msg-row { display:flex; gap:12px; align-items:flex-end; }
    .msg-row.system { justify-content:center; color:#7f8a93; font-size:13px; }
    .msg.user { background:#751A25; color:#fff; padding:12px 14px; border-radius:12px; border-bottom-left-radius:3px; max-width:70%; box-shadow:0 4px 10px rgba(0,0,0,0.06); }
    .msg.user .time { display:block; font-size:11px; opacity:0.85; margin-top:6px; color:rgba(255,255,255,0.85); }
    .user-row { justify-content:flex-start; }
    .user-row .avatar-mini { width:40px; height:40px; border-radius:50%; background:#e6e7e8; display:grid; place-items:center; color:#333; font-weight:700; }
    .msg.admin { background:transparent; border:2px solid #751A25; padding:14px; border-radius:12px; max-width:70%; }
    .admin-row { justify-content:flex-end; align-items:flex-end; }
    .admin-avatar { width:40px; height:40px; border-radius:50%; background:#e6e7e8; display:grid; place-items:center; color:#333; font-weight:700; }

    .composer {
      margin-top:auto;
      display:flex;
      align-items:center;
      gap:12px;
      padding:12px;
      border-top:1px solid #f1f3f5;
      background:linear-gradient(180deg, rgba(255,255,255,0.7), rgba(255,255,255,0.9));
      border-radius:0 0 12px 12px;
    }
    .composer input { flex:1; border:1px solid #eef1f3; padding:12px 14px; border-radius:8px; outline:none; font-size:14px; }
    .composer .send { background:#751A25; color:#fff; padding:10px 14px; border-radius:10px; border:0; cursor:pointer; display:inline-flex; align-items:center; gap:8px; }
    .composer .emoji { font-size:20px; opacity:0.6; }
  </style>
</head>
<body>
  <aside class="sidebar">
    <div class="logo"><img src="{{ asset('images/logoputih.png') }}" alt="Logo Barbekuy"></div>
    <div class="menu">
      <a href="{{ route('admin.beranda') }}" class="menu-item"><i class="fa-solid fa-house"></i> Beranda</a>
      <a href="{{ route('admin.transaksi') }}" class="menu-item"><i class="fa-solid fa-money-check-dollar"></i> Transaksi</a>
      <a href="{{ route('admin.produk') }}" class="menu-item"><i class="fa-solid fa-box"></i> Produk</a>
      <a href="{{ route('admin.pembayaran') }}" class="menu-item"><i class="fa-solid fa-credit-card"></i> Pembayaran</a>
      <a href="{{ route('admin.pesan') }}" class="menu-item active"><i class="fa-solid fa-comments"></i> Pesan</a>
      <a href="{{ route('admin.pengaturan') }}" class="menu-item"><i class="fa-solid fa-gear"></i> Pengaturan</a>
    </div>
  </aside>

  <main class="main-content">
    <div class="topbar">
      <a href="{{ route('notifikasi') }}">
        <i class="fa-solid fa-bell"></i>
        <span class="badgeNotif">2</span>
      </a>
      <div class="profile"><div class="avatar">A</div><span>Admin Barbekuy</span></div>
    </div>

    <div class="content">
      <!-- Panel Kontak -->
      <aside class="list-panel">
        <div class="search"><input type="text" placeholder="Cari pelanggan..." /></div>
        <div class="contacts" id="contacts">
          <div class="contact active" data-name="Zahra Poetri">
            <div class="thumb">ZP</div>
            <div class="meta"><div class="name">Zahra Poetri</div><div class="last">Mau tanya, alat grill portable...</div></div>
            <div style="text-align:right"><div style="font-size:12px;color:#7f8a93">09:21</div><div class="badge">2</div></div>
          </div>

          <div class="contact" data-name="Dimas Aditya">
            <div class="thumb">DA</div>
            <div class="meta"><div class="name">Dimas Aditya</div><div class="last">Gas ready stock kah bang?</div></div>
            <div style="text-align:right"><div style="font-size:12px;color:#7f8a93">08:54</div></div>
          </div>

          <div class="contact" data-name="Rina Putri">
            <div class="thumb">RP</div>
            <div class="meta"><div class="name">Rina Putri</div><div class="last">Ongkir ke Cimahi berapa ya?</div></div>
            <div style="text-align:right"><div style="font-size:12px;color:#7f8a93">10:10</div><div class="badge">1</div></div>
          </div>

          <div class="contact" data-name="Kevin Gunawan">
            <div class="thumb">KG</div>
            <div class="meta"><div class="name">Kevin Gunawan</div><div class="last">Terima kasih kak produknya...</div></div>
            <div style="text-align:right"><div style="font-size:12px;color:#7f8a93">Kemarin</div></div>
          </div>

          <div class="contact" data-name="Maya Lestari">
            <div class="thumb">ML</div>
            <div class="meta"><div class="name">Maya Lestari</div><div class="last">Apakah bisa sewa harian?</div></div>
            <div style="text-align:right"><div style="font-size:12px;color:#7f8a93">Kemarin</div></div>
          </div>

          <div class="contact" data-name="Bima Prasetyo">
            <div class="thumb">BP</div>
            <div class="meta"><div class="name">Bima Prasetyo</div><div class="last">Saya sudah bayar ya kak...</div></div>
            <div style="text-align:right"><div style="font-size:12px;color:#7f8a93">2 hari lalu</div></div>
          </div>
        </div>
      </aside>

      <!-- Panel Chat -->
      <section class="chat-panel">
        <div class="chat-header">
          <div class="profile"><div class="thumb">ZP</div><div><h3>Zahra Poetri</h3><div class="meta">16 Oktober</div></div></div>
        </div>

        <div class="messages" id="messages">
          <div class="msg-row system"><small>16 Oktober</small></div>
          <div class="msg-row user-row"><div class="avatar-mini">ZP</div><div class="msg user">Hallo, permisi kak.<span class="time">09:20</span></div></div>
          <div class="msg-row user-row"><div class="avatar-mini">ZP</div><div class="msg user">Mau tanya, alat grill portable ukuran sedang masih tersedia?<span class="time">09:21</span></div></div>
          <div class="msg-row admin-row"><div class="msg admin">Masih tersedia kak!<span class="time" style="display:block;margin-top:8px;color:#7f8a93;font-size:12px">09:23</span></div><div class="admin-avatar">A</div></div>
        </div>

        <div class="composer">
          <div class="emoji">😊</div>
          <input id="inputMsg" placeholder="Tuliskan pesan..." />
          <button class="send" id="btnSend">Kirim</button>
        </div>
      </section>
    </div>
  </main>

  <script>
    const btn = document.getElementById('btnSend');
    const input = document.getElementById('inputMsg');
    const messages = document.getElementById('messages');
    const contacts = document.querySelectorAll('.contact');

    function scrollToBottom() { messages.scrollTop = messages.scrollHeight; }
    setTimeout(scrollToBottom, 50);

    btn.addEventListener('click', () => {
      const text = input.value.trim();
      if(!text) return;
      const row = document.createElement('div');
      row.className = 'msg-row admin-row';
      const bubble = document.createElement('div');
      bubble.className = 'msg admin';
      bubble.innerHTML = text + `<span class="time" style="display:block;margin-top:8px;color:#7f8a93;font-size:12px">${new Date().toLocaleTimeString([], {hour:'2-digit',minute:'2-digit'})}</span>`;
      const avatar = document.createElement('div');
      avatar.className = 'admin-avatar';
      avatar.textContent = 'A';
      row.appendChild(bubble);
      row.appendChild(avatar);
      messages.appendChild(row);
      input.value = '';
      scrollToBottom();
    });

    // Ganti kontak aktif saat diklik
    contacts.forEach(c => {
      c.addEventListener('click', () => {
        document.querySelectorAll('.contact').forEach(el => el.classList.remove('active'));
        c.classList.add('active');
      });
    });
  </script>
  <script>
  const chatPanel = document.querySelector('.chat-panel');
  const chatHeader = chatPanel.querySelector('.chat-header');
  const chatMessages = chatPanel.querySelector('.messages');

  // Data contoh untuk setiap customer
  const chatData = {
    "Zahra Poetri": [
      { sender: "user", name: "ZP", text: "Hallo, permisi kak.", time: "09:20" },
      { sender: "user", name: "ZP", text: "Mau tanya, alat grill portable ukuran sedang masih tersedia?", time: "09:21" },
      { sender: "admin", name: "A", text: "Masih tersedia kak!", time: "09:23" }
    ],
    "Dimas Aditya": [
      { sender: "user", name: "DA", text: "Gas ready stock kah bang?", time: "08:54" },
      { sender: "admin", name: "A", text: "Ready kak, mau order berapa set?", time: "08:56" }
    ],
    "Rina Putri": [
      { sender: "user", name: "RP", text: "Ongkir ke Cimahi berapa ya?", time: "10:10" },
      { sender: "admin", name: "A", text: "Sekitar 15 ribu kak via J&T.", time: "10:12" }
    ],
    "Kevin Gunawan": [
      { sender: "user", name: "KG", text: "Terima kasih kak produknya cepat sampai!", time: "Kemarin" },
      { sender: "admin", name: "A", text: "Sama-sama kak Kevin 😊", time: "Kemarin" }
    ],
    "Maya Lestari": [
      { sender: "user", name: "ML", text: "Apakah bisa sewa harian?", time: "Kemarin" },
      { sender: "admin", name: "A", text: "Bisa kak, minimal 1 hari yaa.", time: "Kemarin" }
    ],
    "Bima Prasetyo": [
      { sender: "user", name: "BP", text: "Saya sudah bayar ya kak...", time: "2 hari lalu" },
      { sender: "admin", name: "A", text: "Baik kak, kami cek dulu ya 😊", time: "2 hari lalu" }
    ]
  };

  contacts.forEach(c => {
    c.addEventListener('click', () => {
      document.querySelectorAll('.contact').forEach(el => el.classList.remove('active'));
      c.classList.add('active');

      const name = c.dataset.name;
      const data = chatData[name] || [];

      // Ganti header
      chatHeader.innerHTML = `
        <div class="profile">
          <div class="thumb">${name.split(' ').map(n => n[0]).join('').substring(0,2)}</div>
          <div>
            <h3>${name}</h3>
            <div class="meta">${new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long' })}</div>
          </div>
        </div>
      `;

      // Ganti isi chat
      chatMessages.innerHTML = '';
      chatMessages.innerHTML += `<div class="msg-row system"><small>${new Date().toLocaleDateString('id-ID', { day: 'numeric', month: 'long' })}</small></div>`;
      data.forEach(msg => {
        if (msg.sender === "user") {
          chatMessages.innerHTML += `
            <div class="msg-row user-row">
              <div class="avatar-mini">${msg.name}</div>
              <div class="msg user">${msg.text}<span class="time">${msg.time}</span></div>
            </div>
          `;
        } else {
          chatMessages.innerHTML += `
            <div class="msg-row admin-row">
              <div class="msg admin">${msg.text}<span class="time" style="display:block;margin-top:8px;color:#7f8a93;font-size:12px">${msg.time}</span></div>
              <div class="admin-avatar">A</div>
            </div>
          `;
        }
      });
      scrollToBottom();
    });
  });
</script>
</body>
</html>
