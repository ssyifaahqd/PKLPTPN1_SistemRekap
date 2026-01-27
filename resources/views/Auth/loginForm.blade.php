<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — Kebun Jollong</title>
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

    .meta{
      margin:8px 0 14px;
      display:flex;
      flex-direction:column;
      gap:8px;
    }
    .check{
      display:inline-flex;
      align-items:center;
      gap:10px;
      font-size:13px;
      color:var(--muted);
      line-height:1;
      user-select:none;
    }
    .check input{
      width:16px;
      height:16px;
      margin:0;
      transform: translateY(1px);
    }

    .actions{ display:flex; gap:10px; flex-wrap:wrap; }
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

        <a class="btn" href="{{ route('dashboardPublic') }}">Kembali</a>
      </div>
    </div>
  </div>

  <main class="page">
    <div class="card">
      <div class="cardHead">
        <div class="pill">Akses Sistem</div>
        <h1>Login</h1>
        <p>Masukkan <b>ID Pegawai</b> dan password untuk masuk ke sistem rekapitulasi.</p>
      </div>

      <div class="cardBody">
        @if (session('success'))
          <div class="successBox">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
          <div class="errorBox">
            <ul style="margin:0; padding-left:18px;">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
          @csrf

          <div class="field">
            <label for="id_pegawai">ID Pegawai (Personnel Number)</label>
            <input
              id="id_pegawai"
              type="text"
              name="id_pegawai"
              value="{{ old('id_pegawai') }}"
              required
              autocomplete="username"
              inputmode="numeric"
              placeholder="90xxxxxx"
            />
          </div>

          <div class="field">
            <label for="password">Password</label>
            <div class="pwWrap">
              <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
              />

              <button class="pwToggle" type="button" id="pwToggle" aria-label="Tampilkan password" aria-pressed="false">
                <svg id="eyeOpen" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                  <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                  <path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" stroke="currentColor" stroke-width="2"/>
                </svg>
                <svg id="eyeOff" viewBox="0 0 24 24" fill="none" aria-hidden="true" style="display:none;">
                  <path d="M3 3l18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                  <path d="M10.58 10.58A3 3 0 0 0 12 15a3 3 0 0 0 2.42-4.42" stroke="currentColor" stroke-width="2"/>
                  <path d="M9.9 5.1A10.2 10.2 0 0 1 12 5c6.5 0 10 7 10 7a18.7 18.7 0 0 1-3.06 4.23" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                  <path d="M6.11 6.11C3.38 8.16 2 12 2 12s3.5 7 10 7c1.4 0 2.67-.23 3.8-.63" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>
          </div>

          <div class="meta">
            <label class="check">
              <input type="checkbox" name="remember" />
              Ingat saya
            </label>
          </div>

          <div class="actions">
            <button class="btn primary" type="submit">Masuk</button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <footer>
    © 2026 — Kebun Jollong (PTPN I Regional 3).
  </footer>

  <script>
    const pwInput = document.getElementById('password');
    const toggle = document.getElementById('pwToggle');
    const eyeOpen = document.getElementById('eyeOpen');
    const eyeOff = document.getElementById('eyeOff');

    toggle?.addEventListener('click', () => {
      const isHidden = pwInput.getAttribute('type') === 'password';
      pwInput.setAttribute('type', isHidden ? 'text' : 'password');

      toggle.setAttribute('aria-pressed', String(isHidden));
      toggle.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');

      eyeOpen.style.display = isHidden ? 'none' : 'block';
      eyeOff.style.display = isHidden ? 'block' : 'none';
    });
  </script>
</body>
</html>
