<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil Akun — Kebun Jollong</title>

  <style>
    :root{
      --green-700:#1b5e20;
      --green-600:#2e7d32;
      --green-500:#43a047;
      --green-100:#e9f6ee;
      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --shadow: 0 12px 34px rgba(0,0,0,.08);
      --radius: 18px;
      --danger:#dc2626;
    }

    *{ box-sizing:border-box; }
    html,body{
      margin:0; padding:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
      color:var(--text); background:#fff;
      height:100%;
    }
    a{ color:inherit; text-decoration:none; }
    .container{ width:min(1100px, 92%); margin:0 auto; }

    /* Topbar */
    .topbar{
      position:sticky; top:0; z-index:50;
      background:rgba(255,255,255,.88);
      backdrop-filter: blur(10px);
      border-bottom:1px solid var(--border);
    }
    .nav{
      display:flex; align-items:center; justify-content:space-between;
      padding:14px 0; gap:14px;
    }
    .brand{
      display:flex; align-items:center; gap:14px;
      min-width: 320px;
    }
    .brand img{
      width:120px; height:56px;
      object-fit:contain; display:block;
    }
    .brand .title{ display:flex; flex-direction:column; line-height:1.15; }
    .brand .title strong{ font-size:18px; font-weight:800; letter-spacing:.2px; }
    .brand .title span{ font-size:13px; color:var(--muted); }

    .btn{
      padding:10px 14px;
      border-radius:999px;
      font-size:14px;
      border:1px solid var(--border);
      background:#fff;
      cursor:pointer;
      transition:.15s ease;
      display:inline-flex; align-items:center; justify-content:center;
      gap:8px;
      white-space:nowrap;
    }
    .btn.primary{
      border-color:transparent;
      background: linear-gradient(135deg, var(--green-600), var(--green-500));
      color:#fff;
    }
    .btn.danger{
      border-color: rgba(220,38,38,.25);
      color: var(--danger);
      background:#fff;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 8px 18px rgba(0,0,0,.08); }

    /* Layout biar footer gak naik */
    body{
      display:flex;
      flex-direction:column;
      min-height:100vh;
    }

    /* Page */
    .page{
      flex:1;
      padding:26px 0 44px;
      background:
        radial-gradient(circle at 18% 10%, rgba(67,160,71,.14), transparent 40%),
        radial-gradient(circle at 78% 18%, rgba(46,125,50,.10), transparent 38%),
        linear-gradient(180deg, #fff, #fbfdfc);
    }

    .header{
      display:flex;
      align-items:flex-end;
      justify-content:space-between;
      gap:16px;
      margin-bottom:14px;
    }
    .header h1{
      margin:0;
      font-size:26px;
      font-weight:900;
      letter-spacing:.2px;
      position:relative;
      padding-bottom:10px;
    }
    .header h1::after{
      content:"";
      position:absolute; left:0; bottom:0;
      width:82px; height:4px; border-radius:999px;
      background: linear-gradient(90deg, var(--green-600), var(--green-500));
    }
    .header p{
      margin:0;
      color:var(--muted);
      font-size:14px;
      line-height:1.6;
      max-width:520px;
    }

    /* Cards */
    .grid{
      display:grid;
      grid-template-columns: 1fr; /* ✅ jadi 1 kolom aja */
      gap:18px;
      align-items:start;
    }
    .card{
      border:1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      background:#fff;
      indicates: none;
      overflow:hidden;
    }
    .cardHead{
      padding:16px 18px;
      border-bottom:1px solid var(--border);
      background: linear-gradient(180deg, rgba(233,246,238,.85), rgba(255,255,255,1));
      display:flex; align-items:center; justify-content:space-between; gap:12px;
    }
    .cardHead strong{ font-size:15px; font-weight:850; }
    .pill{
      display:inline-flex; align-items:center; gap:8px;
      padding:6px 10px;
      border-radius:999px;
      font-size:12px;
      background: var(--green-100);
      color: var(--green-700);
      border:1px solid rgba(46,125,50,.18);
      white-space:nowrap;
    }
    .cardBody{ padding:18px; }

    .profileRow{
      display:flex; align-items:center; gap:14px;
    }
    .avatar{
      width:56px; height:56px;
      border-radius:16px;
      border:1px solid rgba(46,125,50,.18);
      background: radial-gradient(circle at 30% 30%, rgba(67,160,71,.22), rgba(46,125,50,.08));
      display:flex; align-items:center; justify-content:center;
      font-weight:900;
      color:var(--green-700);
      letter-spacing:.4px;
      flex:0 0 auto;
    }
    .who strong{ display:block; font-size:18px; font-weight:900; }
    .who span{ display:block; color:var(--muted); font-size:13px; margin-top:2px; }

    .kv{
      margin-top:14px;
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:12px;
    }
    .kvItem{
      border:1px solid var(--border);
      border-radius:16px;
      padding:12px 12px;
      background:#fff;
    }
    .kvItem label{
      display:block;
      font-size:12px;
      color:var(--muted);
      margin-bottom:6px;
      font-weight:700;
    }
    .kvItem div{
      font-size:14px;
      font-weight:700;
      color:#111827;
      line-height:1.35;
      word-break:break-word;
    }

    .note{
      margin-top:12px;
      border:1px dashed rgba(46,125,50,.28);
      background: rgba(233,246,238,.55);
      border-radius:16px;
      padding:12px 12px;
      color:#0f3d17;
      font-size:13px;
      line-height:1.6;
    }

    /* ✅ tombol dipindah jadi satu box di dalam card identitas */
    .actionBox{
      margin-top:14px;
      border:1px solid rgba(46,125,50,.18);
      background: rgba(233,246,238,.40);
      border-radius:16px;
      padding:12px 12px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:12px;
      flex-wrap:wrap;
    }
    .actionBox .text{
      color:var(--muted);
      font-size:13px;
      line-height:1.55;
      max-width:640px;
    }
    .actionBox .actions{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      justify-content:flex-end;
      align-items:center;
    }
    .actionBox form{ margin:0; }

    footer{
      border-top:1px solid var(--border);
      padding:18px 0;
      color:var(--muted);
      font-size:13px;
      text-align:left;
    }

    @media (max-width: 920px){
      .brand{ min-width:auto; }
      .brand img{ width:54px; height:54px; }
      .brand .title strong{ font-size:16px; }
      .kv{ grid-template-columns: 1fr; }
      .actionBox{ align-items:flex-start; }
      .actionBox .actions{ justify-content:flex-start; width:100%; }
    }
  </style>
</head>

<body>
  @php
    $user = auth()->user();
    $nama = $user->name ?? 'Karyawan';
    $idPegawai = (string) ($user->id_pegawai ?? '');

    $karyawan = \App\Models\Karyawan::where('personnel_number', $idPegawai)->first();
    $divisi = $karyawan->division_name ?? '-';
    $status = $karyawan->employment_status ?? '-';

    $inisial = collect(explode(' ', trim($nama)))
      ->filter()
      ->take(2)
      ->map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)))
      ->implode('');
    if ($inisial === '') $inisial = 'KJ';
  @endphp

  <div class="topbar">
    <div class="container">
      <div class="nav">
        <a class="brand" href="{{ route('dashboard') }}">
          <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
          <div class="title">
            <strong>Kebun Jollong</strong>
            <span>PTPN I — Regional 3</span>
          </div>
        </a>

        <a class="btn" href="{{ route('dashboard') }}">Kembali</a>
      </div>
    </div>
  </div>

  <main class="page">
    <div class="container">
      <div class="header">
        <div>
          <h1>Profil Akun</h1>
          <p>Informasi dasar akun karyawan.</p>
        </div>
      </div>

      <div class="grid">
        <div class="card">
          <div class="cardHead">
            <strong>Identitas Karyawan</strong>
            <span class="pill">Akun Internal</span>
          </div>

          <div class="cardBody">
            <div class="profileRow">
              <div class="avatar">{{ $inisial }}</div>
              <div class="who">
                <strong>{{ $nama }}</strong>
                <span>ID Pegawai: <b>{{ $idPegawai !== '' ? $idPegawai : '-' }}</b></span>
              </div>
            </div>

            <div class="kv">
              <div class="kvItem">
                <label>Divisi</label>
                <div>{{ $divisi }}</div>
              </div>

              <div class="kvItem">
                <label>Status Karyawan</label>
                <div>{{ $status }}</div>
              </div>

              <div class="kvItem">
                <label>Username Login</label>
                <div>{{ $idPegawai !== '' ? $idPegawai : '-' }}</div>
              </div>

              <div class="kvItem">
                <label>Peran Sistem</label>
                <div>Karyawan</div>
              </div>
            </div>

            <div class="actionBox">
              <div class="text">
                Akses kembali ke dashboard atau keluar dari sistem.
              </div>
              <div class="actions">
                <a class="btn primary" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>

                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button class="btn danger" type="submit">Logout</button>
                </form>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <div class="container">
      © 2026 — Kebun Jollong (PTPN I Regional 3).
    </div>
  </footer>
</body>
</html>
