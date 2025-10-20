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
    }

    /* Navbar */
    .navbar {
      background-color: #fff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .navbar-brand img {
      height: 45px;
    }

    .nav-link {
      color: #1a1a1a !important;
      font-weight: 500;
    }

    .nav-link:hover {
      color: #751A25 !important;
    }

    /* === CART ICON (disamakan dengan halaman keranjang kosong & didekatkan) === */
    .cart-link {
      position: relative;
      color: #800000 !important;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
    }

    .cart-link i {
      font-size: 1.5rem;
      color: #800000;
      transition: 0.3s;
    }

    .cart-link:hover i {
      color: #a00000;
    }

    .cart-count {
      position: absolute;
      top: -4px;
      right: -7px;
      background-color: #800000;
      color: white;
      border-radius: 50%;
      font-size: 0.7rem;
      width: 16px;
      height: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .cart-container {
      padding: 50px 0;
      min-height: 75vh;
    }

    .cart-item {
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #eaeaea;
      padding: 25px 0;
    }

    .cart-item img {
      width: 120px;
      border-radius: 12px;
      object-fit: cover;
    }

    .cart-item-details {
      flex: 1;
      margin-left: 20px;
    }

    .cart-item-title {
      font-weight: 600;
      font-size: 1rem;
      color: #1a1a1a;
    }

    .cart-item-info {
      font-size: 0.9rem;
      color: #666;
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 3px;
    }

    .cart-item-info i {
      color: #751A25;
    }

    .cart-item-price {
      font-weight: 700;
      font-size: 1.1rem;
      color: #751A25;
      text-align: right;
      min-width: 130px;
    }

    .qty-control {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-right: 20px;
    }

    .qty-control button {
      background: none;
      border: none;
      font-size: 1.3rem;
      color: #777;
      transition: 0.2s;
    }

    .qty-control button:hover {
      color: #751A25;
    }

    .qty-control input {
      width: 30px;
      text-align: center;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 0.9rem;
    }

    .checkbox {
      accent-color: #751A25;
      margin-right: 10px;
    }

    /* Total Section */
    .total-section {
      background-color: #fafafa;
      border-radius: 16px;
      padding: 25px 35px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      margin-top: 40px;
      font-size: 1.2rem;
      box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .btn-primary-custom {
      background-color: #751A25;
      color: #fff;
      border: none;
      border-radius: 8px;
      transition: 0.3s;
      font-weight: 600;
    }

    .btn-primary-custom:hover {
      background-color: #a00000;
    }

    @media (max-width: 768px) {
      .cart-item {
        flex-direction: column;
        align-items: flex-start;
      }

      .cart-item-price {
        text-align: left;
        margin-top: 10px;
      }

      .total-section {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
      }
    }
  </style>
</head>
<body>
  {{-- Navbar --}}
  @include('layouts.navbar')

  {{-- ISI KERANJANG --}}
  <section class="cart-container container">
    {{-- Item 1 --}}
    <div class="cart-item">
      <input type="checkbox" class="checkbox">
      <img src="{{ asset('images/ber4extra.png') }}" alt="Paket Slice Ber-4 Xtra">
      <div class="cart-item-details">
        <div class="cart-item-title">Paket Slice Ber-4 Xtra</div>
        <div class="cart-item-info">
          <span><i class="bi bi-calendar"></i> Tanggal 6–7 Okt 2025</span>
          <span><i class="bi bi-check-circle"></i> Tersedia</span>
        </div>
      </div>
      <div class="qty-control">
        <button class="decrease">−</button>
        <input type="text" value="1" readonly>
        <button class="increase">+</button>
      </div>
      <div class="cart-item-price">Rp245.000</div>
    </div>

    {{-- Item 2 --}}
    <div class="cart-item">
      <input type="checkbox" class="checkbox">
      <img src="{{ asset('images/ber6extra.png') }}" alt="Paket Slice Ber-6 Xtra">
      <div class="cart-item-details">
        <div class="cart-item-title">Paket Slice Ber-6 Xtra</div>
        <div class="cart-item-info">
          <span><i class="bi bi-calendar"></i> Tanggal 10–11 Okt 2025</span>
          <span><i class="bi bi-check-circle"></i> Tersedia</span>
        </div>
      </div>
      <div class="qty-control">
        <button class="decrease">−</button>
        <input type="text" value="1" readonly>
        <button class="increase">+</button>
      </div>
      <div class="cart-item-price">Rp345.000</div>
    </div>

    {{-- Item 3 --}}
    <div class="cart-item">
      <input type="checkbox" class="checkbox">
      <img src="{{ asset('images/ber10extra.png') }}" alt="Paket Slice Ber-10 Xtra">
      <div class="cart-item-details">
        <div class="cart-item-title">Paket Slice Ber-10 Xtra</div>
        <div class="cart-item-info">
          <span><i class="bi bi-calendar"></i> Tanggal 15–16 Okt 2025</span>
          <span><i class="bi bi-check-circle"></i> Tersedia</span>
        </div>
      </div>
      <div class="qty-control">
        <button class="decrease">−</button>
        <input type="text" value="1" readonly>
        <button class="increase">+</button>
      </div>
      <div class="cart-item-price">Rp525.000</div>
    </div>

    {{-- Total --}}
    <div class="total-section">
      <span>Total Pembayaran</span>
      <div class="d-flex align-items-center gap-3">
        <span id="totalHarga">Rp0</span>
        <a href="#" class="btn btn-primary-custom px-4 py-2">Checkout</a>
      </div>
    </div>
  </section>

  {{-- Script --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelectorAll('.cart-item').forEach(item => {
      const decreaseBtn = item.querySelector('.decrease');
      const increaseBtn = item.querySelector('.increase');
      const qtyInput = item.querySelector('input[type="text"]');
      const checkbox = item.querySelector('.checkbox');
      const priceText = item.querySelector('.cart-item-price').innerText.replace(/[^\d]/g, '');
      const price = parseInt(priceText);

      qtyInput.value = 1;

      function updateTotal() {
        let total = 0;
        document.querySelectorAll('.cart-item').forEach(ci => {
          const cb = ci.querySelector('.checkbox');
          const qty = parseInt(ci.querySelector('input[type="text"]').value);
          const p = parseInt(ci.querySelector('.cart-item-price').innerText.replace(/[^\d]/g, ''));
          if (cb.checked) total += p * qty;
        });
        document.getElementById('totalHarga').innerText = `Rp${total.toLocaleString('id-ID')}`;
      }

      decreaseBtn.addEventListener('click', () => {
        let qty = parseInt(qtyInput.value);
        if (qty > 1) {
          qty--;
          qtyInput.value = qty;
          updateTotal();
        }
      });

      increaseBtn.addEventListener('click', () => {
        let qty = parseInt(qtyInput.value);
        qty++;
        qtyInput.value = qty;
        updateTotal();
      });

      checkbox.addEventListener('change', updateTotal);
    });
  </script>
</body>
</html>
