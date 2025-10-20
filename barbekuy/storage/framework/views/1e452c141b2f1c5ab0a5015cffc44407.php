<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Chat — Barbekuy</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    :root {
      --maroon: #6b0f1a;
      --maroon-700: #7a0f19;
    }
    .bubble-admin {
      background: var(--maroon);
      color: #fff;
    } /* admin kiri merah */
    .bubble-cust {
      background: #fff;
      color: #1f2937;
      border: 1px solid #e5e7eb;
    } /* customer kanan putih */
    .scroll-slim::-webkit-scrollbar { width: 8px; }
    .scroll-slim::-webkit-scrollbar-thumb {
      background: #e5e7eb;
      border-radius: 9999px;
    }
  </style>
</head>

<body class="bg-gray-100 min-h-screen">

  <!-- HEADER -->
  <header class="bg-[var(--maroon)] text-white">
    <div class="max-w-6xl mx-auto px-4 py-4 flex items-center gap-3">
      <!-- Tombol Kembali ke Beranda -->
      <a href="<?php echo e(url('/beranda')); ?>"
         class="shrink-0 h-9 w-9 grid place-items-center rounded-full bg-white/15 hover:bg-white/25"
         title="Kembali ke Beranda">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>

      <!-- Info Chat -->
      <div class="flex items-center gap-3">
        <div class="h-9 w-9 rounded-full bg-white/20 grid place-items-center text-xs font-semibold">
          BBQ
        </div>
        <div>
          <div class="font-semibold leading-tight">Barbekuy Support</div>
          <div class="text-xs opacity-80 -mt-0.5">Customer Chat</div>
        </div>
      </div>

      <div class="ml-auto text-sm opacity-90">
        Hi, <?php echo e($customerName ?? 'User'); ?>

      </div>
    </div>
  </header>

  <!-- MAIN CONTENT -->
  <main class="max-w-6xl mx-auto px-4 py-6">
    <div class="bg-white rounded-2xl shadow overflow-hidden">

      <!-- Header Chat -->
      <div class="px-6 py-4 border-b flex items-center gap-3">
        <div class="h-10 w-10 rounded-full bg-gray-200 grid place-items-center font-semibold text-gray-700">
          A
        </div>
        <div>
          <div class="font-semibold text-gray-900">Admin Barbekuy</div>
          <div class="text-xs text-gray-500"><?php echo e(now()->translatedFormat('d F')); ?></div>
        </div>
        <div class="ml-auto flex gap-2 text-gray-400">
          <button title="Tambah" class="px-2 py-1 hover:text-gray-600">＋</button>
          <button title="Menu" class="px-2 py-1 hover:text-gray-600">≡</button>
        </div>
      </div>

      <!-- MESSAGES -->
      <div class="bg-gray-50 h-[62vh] overflow-y-auto scroll-slim p-6 space-y-3">
        <!-- CUSTOMER (kanan) -->
        <div class="max-w-xl ml-auto text-right">
          <div class="text-xs text-gray-400 mb-1">09:20</div>
          <div class="inline-block bubble-cust px-4 py-3 rounded-2xl rounded-br-sm shadow-sm">
            Hallo, permisi kak.
          </div>
        </div>

        <!-- CUSTOMER (kanan) -->
        <div class="max-w-xl ml-auto text-right">
          <div class="text-xs text-gray-400 mb-1">09:21</div>
          <div class="inline-block bubble-cust px-4 py-3 rounded-2xl rounded-br-sm shadow-sm">
            Mau tanya, alat grill portable yang ukuran sedang masih tersedia gak ya buat tanggal 20 Oktober?
            Soalnya mau dipakai buat acara BBQ di rumah.
          </div>
        </div>

        <!-- ADMIN (kiri) -->
        <div class="max-w-xl">
          <div class="text-xs text-gray-400 mb-1">09:23</div>
          <div class="inline-block bubble-admin px-4 py-3 rounded-2xl rounded-bl-sm shadow-sm">
            Hallo kak, terima kasih telah menghubungi kami.
            Untuk alat grillnya masih ada di tanggal 20 ya kak.
          </div>
        </div>

        <!-- CUSTOMER (kanan) -->
        <div class="max-w-xl ml-auto text-right">
          <div class="text-xs text-gray-400 mb-1">09:24</div>
          <div class="inline-block bubble-cust px-4 py-3 rounded-2xl rounded-br-sm shadow-sm">
            Oke kak, saya pesan 1 ya 🙏
          </div>
        </div>
      </div>

      <!-- INPUT / COMPOSER -->
      <div class="p-5 border-t bg-gray-50">
        <form method="POST" action="<?php echo e(route('chat.send')); ?>" class="flex items-center gap-3">
          <?php echo csrf_field(); ?>

          <!-- Emoji -->
          <button type="button" title="Emoji"
                  class="h-11 w-11 grid place-items-center rounded-full bg-white border border-gray-200
                         hover:bg-gray-100 shadow-sm">
            <span class="text-xl leading-none">😊</span>
          </button>

          <!-- Input Pesan -->
          <div class="flex-1 relative">
            <input name="body"
                   class="w-full rounded-xl border border-gray-300 px-5 py-3 pr-14 text-gray-700
                          focus:outline-none focus:ring-2 focus:ring-[var(--maroon)]"
                   placeholder="Tuliskan pesan..." required />
          </div>

          <!-- Upload Gambar -->
          <button type="button" title="Unggah gambar"
                  class="h-11 w-11 grid place-items-center rounded-xl bg-white border border-gray-200
                         hover:bg-gray-100 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
              <path d="M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2zm0 2v8l3.5-3.5a1 1 0 0 1 1.5.1L13 14l2.5-2.5a1 1 0 0 1 1.5.1L19 14V6H5zm4 1.75A1.75 1.75 0 1 0 10.75 11 1.75 1.75 0 0 0 9 7.75z"/>
            </svg>
          </button>

          <!-- Tombol Kirim -->
          <button type="submit"
                  class="px-5 h-11 rounded-xl bg-[var(--maroon)] hover:bg-[var(--maroon-700)]
                         text-white font-medium shadow-sm">
            Kirim
          </button>
        </form>

        <?php $__errorArgs = ['body'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

    </div>
  </main>
</body>
</html><?php /**PATH D:\barbekuy\resources\views/chat.blade.php ENDPATH**/ ?>