<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Wajib Ganti Password — Kebun Jollong</title>
  <style>
    :root{
      --green-700:#1b5e20;
      --green-600:#2e7d32;
      --green-500:#43a047;
      --green-100:#e9f6ee;
      --text:#1f2937;
      --muted:#6b7280;
      --border:#e5e7eb;
      --shadow: 0 10px 30px rgba(0,0,0,.08);
      --radius: 18px;
      --danger:#dc2626;
    }
    *{ box-sizing:border-box; }
    html,body{
      margin:0; padding:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
      color:var(--text); background:#fff;
    }
    a{ color:inherit; text-decoration:none; }
    .container{ width:min(1200px, 92%); margin:0 auto; }

    .topbar{
      position:sticky; top:0; z-index:50;
      background:rgba(255,255,255,.86);
      backdrop-filter: blur(10px);
      border-bottom:1px solid var(--border);
    }
    .nav{
      display:flex; align-items:center; justify-content:space-between;
      padding:14px 0; gap:14px;
    }
    .brand{
      display:flex; align-items:center; gap:14px;
      min-width:320px;
    }
    .brand img{
      width:130px; height:60px;
      object-fit:contain; display:block;
    }
    .brand .title{ display:flex; flex-direction:column; line-height:1.15; }
    .brand .title strong{ font-size:20px; font-weight:700; letter-spacing:.2px; }
    .brand .title span{ font-size:14px; color:var(--muted); }

    .btn{
      padding:10px 14px; border-radius:999px; font-size:14px;
      border:1px solid var(--border); background:#fff;
      cursor:pointer; transition:.15s ease; white-space:nowrap;
      display:inline-flex; align-items:center; justify-content:center;
    }
    .btn.primary{
      border-color: transparent;
      background: linear-gradient(135deg, var(--green-600), var(--green-500));
      color:#fff;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 8px 18px rgba(0,0,0,.08); }

    .page{
      min-height: calc(100vh - 78px);
      display:grid;
      place-items:center;
      padding:28px 0 40px;
      background:
        radial-gradient(circle at 18% 10%, rgba(67,160,71,.18), transparent 40%),
        radial-gradient(circle at 78% 18%, rgba(46,125,50,.14), transparent 38%),
        linear-gradient(180deg, #fff, #fbfdfc);
    }

    .card{
      width:min(580px, 100%);
      border:1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      background:#fff;
      overflow:hidden;
    }
    .cardHead{
      padding:18px;
      border-bottom:1px solid var(--border);
      background: linear-gradient(180deg, rgba(233,246,238,.8), rgba(255,255,255,1));
    }
    .pill{
      display:inline-flex; align-items:center; gap:8px;
      padding:6px 10px; border-radius:999px; font-size:12px;
      background: var(--green-100); color: var(--green-700);
      border:1px solid rgba(46,125,50,.18);
      margin-bottom:10px;
    }
    .cardHead h1{ margin:0 0 6px; font-size:22px; color:var(--text); }
    .cardHead p{ margin:0; color:var(--muted); font-size:13px; line-height:1.6; }
    .cardBody{ padding:18px; }

    .field{ margin-bottom:12px; }
    label{
      display:block;
      font-size:13px;
      margin-bottom:6px;
      color:var(--text);
      font-weight:600;
    }
    input{
      width:100%;
      padding:12px 12px;
      border:1px solid var(--border);
      border-radius:14px;
      font-size:14px;
      outline:none;
      transition:.15s ease;
      background:#fff;
    }
    input:focus{
      border-color: rgba(46,125,50,.45);
      box-shadow: 0 0 0 4px rgba(46,125,50,.12);
    }

    .pwWrap{ position:relative; }
    .pwWrap input{ padding-right:54px; }
    .pwToggle{
      position:absolute;
      right:10px;
      top:50%;
      transform: translateY(-50%);
      width:40px; height:40px;
      border-radius:14px;
      border:1px solid var(--border);
      background:#fff;
      cursor:pointer;
      display:flex; align-items:center; justify-content:center;
      transition:.15s ease;
      color:var(--muted);
      user-select:none;
    }
    .pwToggle:hover{
      background: var(--green-100);
      color: var(--green-700);
      border-color: rgba(46,125,50,.22);
    }
    .pwToggle svg{ width:18px; height:18px; display:block; }

    .actions{ display:flex; gap:10px; flex-wrap:wrap; margin-top:6px; }
    .actions .btn{ flex:1; }

    .errorBox{
      border:1px solid rgba(220,38,38,.25);
      background: rgba(220,38,38,.06);
      border-radius:14px;
      padding:10px 12px;
      margin-bottom:12px;
      color:#991b1b;
      font-size:13px;
      line-height:1.5;
    }
    .successBox{
      border:1px solid rgba(16,185,129,.25);
      background: rgba(16,185,129,.08);
      border-radius:14px;
      padding:10px 12px;
      margin-bottom:12px;
      color:#065f46;
      font-size:13px;
      line-height:1.5;
    }

    footer{
      padding:18px 0;
      color:var(--muted);
      font-size:13px;
      text-align:center;
    }

    @media (max-width: 560px){
      .brand{ min-width:auto; }
      .brand img{ width:52px; height:52px; }
      .brand .title strong{ font-size:18px; }
      .brand .title span{ font-size:13px; }
      .actions .btn{ flex: 1 1 100%; }
    }
  </style>
</head>

<body>
  <div class="topbar">
    <div class="container">
      <div class="nav">
        <a class="brand" href="{{ route('dashboardPublic') }}">
          <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
          <div class="title">
            <strong>Kebun Jollong</strong>
            <span>PTPN I — Regional 3</span>
          </div>
        </a>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button class="btn" type="submit">Keluar</button>
        </form>
      </div>
    </div>
  </div>

  <main class="page">
    <div class="card">
      <div class="cardHead">
        <div class="pill">Wajib Ganti Password</div>
        <h1>Perbarui Password Kamu</h1>
        <p>Ini hanya sekali. Setelah berhasil, kamu bisa akses sistem seperti biasa.</p>
      </div>

      <div class="cardBody">
        @if (session('success'))
          <div class="successBox">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
          <div class="errorBox">
            <ul style="margin:0; padding-left:18px;">
              @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('password.change.save') }}">
          @csrf

          <div class="field">
            <label for="current_password">Password Saat Ini</label>
            <div class="pwWrap">
              <input id="current_password" type="password" name="current_password" required autocomplete="current-password" placeholder="••••••••" />
              <button class="pwToggle" type="button" data-toggle="current_password" aria-label="Tampilkan password" aria-pressed="false">
                <svg data-eye-open viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                  <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/>
                </svg>
                <svg data-eye-off viewBox="0 0 24 24" fill="none" aria-hidden="true" style="display:none;">
                  <path d="M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  <path d="M10.58 10.58A3 3 0 0 0 12 15a3 3 0 0 0 2.42-4.42" stroke="currentColor" stroke-width="2"/>
                  <path d="M9.9 5.1A10.2 10.2 0 0 1 12 5c6.5 0 10 7 10 7a18.7 18.7 0 0 1-3.06 4.23" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                  <path d="M6.11 6.11C3.38 8.16 2 12 2 12s3.5 7 10 7c1.4 0 2.67-.23 3.8-.63" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>
          </div>

          <div class="field">
            <label for="password">Password Baru</label>
            <div class="pwWrap">
              <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
              <button class="pwToggle" type="button" data-toggle="password" aria-label="Tampilkan password" aria-pressed="false">
                <svg data-eye-open viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                  <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/>
                </svg>
                <svg data-eye-off viewBox="0 0 24 24" fill="none" aria-hidden="true" style="display:none;">
                  <path d="M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  <path d="M10.58 10.58A3 3 0 0 0 12 15a3 3 0 0 0 2.42-4.42" stroke="currentColor" stroke-width="2"/>
                  <path d="M9.9 5.1A10.2 10.2 0 0 1 12 5c6.5 0 10 7 10 7a18.7 18.7 0 0 1-3.06 4.23" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                  <path d="M6.11 6.11C3.38 8.16 2 12 2 12s3.5 7 10 7c1.4 0 2.67-.23 3.8-.63" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>
          </div>

          <div class="field">
            <label for="password_confirmation">Konfirmasi Password Baru</label>
            <div class="pwWrap">
              <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password baru" />
              <button class="pwToggle" type="button" data-toggle="password_confirmation" aria-label="Tampilkan password" aria-pressed="false">
                <svg data-eye-open viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                  <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/>
                </svg>
                <svg data-eye-off viewBox="0 0 24 24" fill="none" aria-hidden="true" style="display:none;">
                  <path d="M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  <path d="M10.58 10.58A3 3 0 0 0 12 15a3 3 0 0 0 2.42-4.42" stroke="currentColor" stroke-width="2"/>
                  <path d="M9.9 5.1A10.2 10.2 0 0 1 12 5c6.5 0 10 7 10 7a18.7 18.7 0 0 1-3.06 4.23" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                  <path d="M6.11 6.11C3.38 8.16 2 12 2 12s3.5 7 10 7c1.4 0 2.67-.23 3.8-.63" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>
          </div>

          <div class="actions">
            <button class="btn primary" type="submit">Simpan Password Baru</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <footer>
    © 2026 — Kebun Jollong (PTPN I Regional 3).
  </footer>

  <script>
    document.querySelectorAll('.pwToggle').forEach(btn => {
      btn.addEventListener('click', () => {
        const inputId = btn.getAttribute('data-toggle');
        const input = document.getElementById(inputId);
        if (!input) return;

        const isHidden = input.getAttribute('type') === 'password';
        input.setAttribute('type', isHidden ? 'text' : 'password');

        btn.setAttribute('aria-pressed', String(isHidden));
        btn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');

        const eyeOpen = btn.querySelector('[data-eye-open]');
        const eyeOff  = btn.querySelector('[data-eye-off]');
        if (eyeOpen && eyeOff) {
          eyeOpen.style.display = isHidden ? 'none' : 'block';
          eyeOff.style.display  = isHidden ? 'block' : 'none';
        }
      });
    });
  </script>
</body>
</html>
