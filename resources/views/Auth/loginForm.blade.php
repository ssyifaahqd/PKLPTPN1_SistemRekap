<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login — Kebun Jollong</title>
  <style>
    :root{
      --green-900:#123a16;
      --green-800:#174a1a;
      --green-700:#1b5e20;
      --green-600:#2e7d32;
      --green-500:#43a047;
      --green-100:#e9f6ee;

      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;

      --shadow: 0 18px 40px rgba(0,0,0,.12);
      --radius: 22px;
    }

    *{ box-sizing:border-box; }
    html,body{
      margin:0; padding:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
      color:var(--text);
      background:#fff;
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
      display:flex; align-items:center;
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
    .brand .title strong{ font-size:20px; font-weight:800; letter-spacing:.2px; }
    .brand .title span{ font-size:14px; color:var(--muted); }

    .page{
      min-height: calc(100vh - 78px);
      display:grid;
      place-items:center;
      padding:22px 0 34px;
      background:
        radial-gradient(circle at 20% 10%, rgba(67,160,71,.14), transparent 45%),
        radial-gradient(circle at 80% 18%, rgba(46,125,50,.10), transparent 42%),
        linear-gradient(180deg, #fff, #fbfdfc);
    }

    .shell{
      width:min(1100px, 100%);
      border:1px solid var(--border);
      border-radius: var(--radius);
      overflow:hidden;
      box-shadow: var(--shadow);
      background:#fff;
      display:grid;
      grid-template-columns: 1.05fr .95fr;
      min-height: 620px;
    }

    .media{
      position:relative;
      background: url("{{ asset('img/Petik Kopi.jpg') }}") center/cover no-repeat;
    }

    .media::after{
      content:"";
      position:absolute;
      inset:0;
      background: linear-gradient(90deg, rgba(0,0,0,.05), rgba(0,0,0,.35));
      pointer-events:none;
    }

    .mediaInner{
      position:absolute;
      inset:0;
      padding:26px;
      display:flex;
      flex-direction:column;
      justify-content:space-between;
      color:#fff;
      z-index:1;
    }

    .mediaBadge{
      display:inline-flex;
      align-items:center;
      gap:10px;
      padding:10px 12px;
      border-radius:999px;
      border:1px solid rgba(255,255,255,.22);
      background: rgba(0,0,0,.25);
      backdrop-filter: blur(10px);
      width:max-content;
    }
    .dot{
      width:10px; height:10px; border-radius:50%;
      background: #fff;
      box-shadow: 0 0 0 4px rgba(255,255,255,.14);
    }
    .mediaBadge b{ font-weight:800; }
    .mediaBadge span{ opacity:.92; font-size:13px; }

    .mediaCopy h2{
      margin:0 0 8px;
      font-size:34px;
      line-height:1.05;
      letter-spacing:.2px;
      text-shadow: 0 10px 22px rgba(0,0,0,.28);
    }
    .mediaCopy p{
      margin:0;
      font-size:14px;
      line-height:1.6;
      opacity:.95;
      max-width: 440px;
      text-shadow: 0 10px 22px rgba(0,0,0,.24);
    }

    .panel{
      padding:28px;
      display:flex;
      flex-direction:column;
      justify-content:center;
      background:
        radial-gradient(circle at 30% 0%, rgba(233,246,238,.70), transparent 55%),
        linear-gradient(180deg, #ffffff, #fbfdfc);
    }

    .pill{
      display:inline-flex; align-items:center; gap:8px;
      padding:7px 11px; border-radius:999px; font-size:12px;
      background: var(--green-100); color: var(--green-700);
      border:1px solid rgba(46,125,50,.18);
      width:max-content;
      margin-bottom:10px;
    }

    .panel h1{
      margin:10px 0 6px;
      font-size:30px;
      letter-spacing:.2px;
    }
    .panel p{
      margin:0 0 18px;
      color:var(--muted);
      font-size:13px;
      line-height:1.6;
    }

    .errorBox{
      border:1px solid rgba(220,38,38,.25);
      background: rgba(220,38,38,.06);
      border-radius:16px;
      padding:10px 12px;
      margin-bottom:12px;
      color:#991b1b;
      font-size:13px;
      line-height:1.5;
    }
    .successBox{
      border:1px solid rgba(16,185,129,.25);
      background: rgba(16,185,129,.08);
      border-radius:16px;
      padding:10px 12px;
      margin-bottom:12px;
      color:#065f46;
      font-size:13px;
      line-height:1.5;
    }

    .field{ margin-bottom:12px; }
    label{
      display:block;
      font-size:13px;
      margin-bottom:6px;
      color:var(--text);
      font-weight:800;
    }

    input{
      width:100%;
      padding:12px 12px;
      border:1px solid var(--border);
      border-radius:16px;
      font-size:14px;
      outline:none;
      transition:.15s ease;
      background:#fff;
    }
    input:focus{
      border-color: rgba(46,125,50,.50);
      box-shadow: 0 0 0 4px rgba(46,125,50,.14);
    }

    .pwWrap{ position:relative; }
    .pwWrap input{ padding-right:56px; }

    .pwToggle{
      position:absolute;
      right:8px;
      top:50%;
      transform: translateY(-50%);
      width:44px; height:44px;
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
      margin:10px 0 16px;
      display:flex;
      align-items:center;
      gap:12px;
      flex-wrap:wrap;
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

    .cta{
      width:100%;
      border:0;
      padding:12px 14px;
      border-radius: 999px;
      font-size:14px;
      font-weight:900;
      cursor:pointer;
      transition:.15s ease;
      color:#fff;
      background: linear-gradient(135deg, var(--green-700), var(--green-500));
      box-shadow: 0 14px 26px rgba(27,94,32,.20);
    }
    .cta:hover{
      transform: translateY(-1px);
      box-shadow: 0 18px 34px rgba(27,94,32,.26);
    }

    footer{
      padding:18px 0;
      color:var(--muted);
      font-size:13px;
      text-align:center;
    }

    @media (max-width: 980px){
      .shell{ grid-template-columns: 1fr; min-height:auto; }
      .media{ min-height: 320px; }
      .panel{ padding:22px; }
      .brand{ min-width:auto; }
      .media::after{ background: linear-gradient(180deg, rgba(0,0,0,.08), rgba(0,0,0,.35)); }
    }

    @media (max-width: 560px){
      .brand img{ width:52px; height:52px; }
      .brand .title strong{ font-size:18px; }
      .brand .title span{ font-size:13px; }
      .mediaInner{ padding:18px; }
      .mediaCopy h2{ font-size:26px; }
      .panel h1{ font-size:26px; }
    }
  </style>
</head>

<body>
  <div class="topbar">
    <div class="container">
      <div class="nav">
        <div class="brand">
          <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
          <div class="title">
            <strong>Kebun Jollong</strong>
            <span>PTPN I — Regional 3</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <main class="page">
    <section class="shell">
      <aside class="media">
        <div class="mediaInner">
          <div class="mediaBadge">
            <span class="dot"></span>
            <div style="display:flex;flex-direction:column;gap:2px;">
              <b>Kebun Jollong</b>
              <span>Rekapitulasi & Monitoring</span>
            </div>
          </div>

          <div class="mediaCopy">
            <h2>Sistem Rekapitulasi Kebun Jollong</h2>
            <p>Portal informasi dan ringkasan rekap Kebun Jollong.</p>
          </div>
        </div>
      </aside>

      <div class="panel">
        <div class="pill">Akses Sistem</div>

        <h1>Login</h1>
        <p>Masukkan <b>ID Pegawai</b> dan password untuk masuk ke sistem rekapitulasi.</p>

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

          <button class="cta" type="submit">Masuk</button>

        </form>
      </div>
    </section>
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
