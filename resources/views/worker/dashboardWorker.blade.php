<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Karyawan — Kebun Jollong</title>

  <style>
    :root{
      --green-700:#1b5e20;
      --green-600:#2e7d32;
      --green-500:#43a047;
      --green-100:#e9f6ee;

      --navy-700:#1e3a8a;
      --navy-100:#e8eefc;

      --gray-900:#111827;
      --gray-700:#374151;
      --muted:#6b7280;

      --border:#e5e7eb;
      --grid:#e5e7eb;

      --shadow: 0 10px 30px rgba(0,0,0,.08);
      --radius: 18px;

      --danger:#dc2626;
      --warn:#f59e0b;
      --ok:#16a34a;
    }

    *{ box-sizing:border-box; }
    html,body{ margin:0; padding:0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial; color:var(--gray-900); background:#fff; }
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

    .brand{ display:flex; align-items:center; gap:14px; min-width: 320px; }
    .brand img{ width:130px; height:60px; object-fit:contain; display:block; }
    .brand .title{ display:flex; flex-direction:column; line-height:1.15; }
    .brand .title strong{ font-size:20px; font-weight:750; letter-spacing:.2px; }
    .brand .title span{ font-size:14px; color:var(--muted); }

    .navRight{
      margin-left:auto;
      display:flex; align-items:center;
      gap:10px;
    }

    .navlinks{
      display:flex; align-items:center; gap:8px;
      font-size:14px; flex-wrap:wrap; justify-content:flex-end;
    }
    .navlinks a{ padding:8px 10px; border-radius:999px; transition:.15s ease; }
    .navlinks a:hover{ background:var(--green-100); color:var(--green-700); }

    .cta{ display:flex; align-items:center; gap:10px; }

    .btn{
      padding:10px 14px; border-radius:999px; font-size:14px;
      border:1px solid var(--border); background:#fff;
      cursor:pointer; transition:.15s ease; white-space:nowrap;
      display:inline-flex; align-items:center; justify-content:center; gap:8px;
    }
    .btn.primary{
      border-color: transparent;
      background: linear-gradient(135deg, var(--green-700), var(--green-500));
      color:#fff;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 8px 18px rgba(0,0,0,.08); }
    .btn.danger{
      border-color: rgba(220,38,38,.25);
      color: var(--danger);
      background:#fff;
    }

    .chip{
      padding:10px 14px;
      border-radius:999px;
      font-size:14px;
      border:1px solid rgba(46,125,50,.22);
      background: var(--green-100);
      color: var(--green-700);
      font-weight:650;
      display:inline-flex; align-items:center; justify-content:center;
      white-space:nowrap;
    }

    .dropdown{ position:relative; }
    .dropbtn{
      display:flex; align-items:center; gap:8px;
      cursor:pointer; padding:8px 10px;
      border-radius:999px; user-select:none;
      border:1px solid var(--border);
      background:#fff;
      transition:.15s ease;
      font-size:14px;
    }
    .dropbtn:hover{ background:var(--green-100); color:var(--green-700); border-color: rgba(46,125,50,.22); }
    .caret{
      width:10px; height:10px; display:inline-block;
      border-right:2px solid currentColor;
      border-bottom:2px solid currentColor;
      transform: rotate(45deg);
      margin-top:-2px; opacity:.8;
    }
    .menu{
      position:absolute; right:0; top:46px;
      width:220px; background:#fff;
      border:1px solid var(--border);
      border-radius:14px; box-shadow: var(--shadow);
      padding:8px; display:none;
    }
    .menu a, .menu button{
      display:block; width:100%;
      padding:10px 12px;
      border-radius:12px; font-size:14px;
      color:var(--gray-900);
      text-align:left;
      background:#fff;
      border:0;
      cursor:pointer;
    }
    .menu a:hover, .menu button:hover{ background:var(--green-100); color:var(--green-700); }
    .dropdown.open .menu{ display:block; }

    .hamburger{
      display:none; border:1px solid var(--border);
      background:#fff; border-radius:12px; padding:10px 12px; cursor:pointer;
    }
    .mobileMenu{ display:none; padding: 0 0 14px; }
    .mobileMenu.open{ display:block; }
    .mobileMenu a{
      display:block; padding:10px 8px;
      border-bottom:1px solid var(--border); font-size:14px;
    }

    .hero{ padding:22px 0 10px; }
    .heroCard{
      border-radius: var(--radius); overflow:hidden;
      box-shadow: var(--shadow); border:1px solid var(--border);
    }
    .heroMedia{
      position:relative;
      height: clamp(240px, 34vw, 360px);
      background:
        linear-gradient(180deg, rgba(0,0,0,.58) 0%, rgba(0,0,0,.18) 65%, rgba(0,0,0,.10) 100%),
        url("{{ asset('img/Petik Kopi.jpg') }}") center/cover no-repeat;
    }
    .heroContent{
      position:absolute; left:24px; bottom:18px;
      color:#fff; max-width:900px;
    }
    .heroContent h1{
      margin:0 0 8px;
      font-size: clamp(26px, 3.2vw, 40px);
      text-shadow: 0 6px 24px rgba(0,0,0,.45);
      font-weight:800;
      letter-spacing:.2px;
    }
    .heroContent p{
      margin:0;
      font-size:14px;
      opacity:.96;
      line-height:1.7;
      text-shadow: 0 4px 16px rgba(0,0,0,.35);
      max-width: 760px;
    }
    .pill{
      display:inline-flex; align-items:center; gap:8px;
      padding:6px 10px; border-radius:999px; font-size:12px;
      background: rgba(255,255,255,.18);
      border:1px solid rgba(255,255,255,.28);
      color:#fff;
      margin-bottom:10px;
      backdrop-filter: blur(6px);
    }

    .tabs{
      display:flex; gap:10px;
      padding:14px 18px; background:#fff;
      flex-wrap:wrap;
    }
    .tab{
      padding:10px 14px;
      border-radius:999px;
      border:1px solid var(--border);
      font-size:14px;
      color:var(--muted);
      transition:.15s ease;
      cursor:pointer;
      user-select:none;
    }
    .tab:hover{ background: var(--green-100); color: var(--green-700); border-color: rgba(46,125,50,.22); }
    .tab.active{ color:var(--green-700); border-color: rgba(46,125,50,.35); background: var(--green-100); font-weight:700; }

    .section{ padding:34px 0; }
    .sectionHeader{
      display:flex; align-items:flex-end; justify-content:space-between;
      gap:20px; margin-bottom:14px;
    }
    .sectionHeader h2{
      margin:0; font-size:24px;
      position:relative; padding-bottom:10px;
      font-weight:800;
    }
    .sectionHeader h2::after{
      content:""; position:absolute; left:0; bottom:0;
      width:76px; height:4px; border-radius:999px;
      background: linear-gradient(90deg, var(--green-700), var(--green-500));
    }
    .sectionHeader p{
      margin:0; color:var(--muted);
      font-size:14px; max-width:620px; line-height:1.7;
    }

    .grid{ display:grid; grid-template-columns: 1fr 1fr; gap:18px; align-items:start; }

    .card{
      border:1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      background:#fff;
      overflow:hidden;
    }
    .cardBody{ padding:18px; }
    .muted{ color:var(--muted); }

    .filters{
      display:flex; gap:10px; flex-wrap:wrap;
      align-items:flex-end;
      margin:10px 0 8px;
    }
    .field{
      display:flex; flex-direction:column; gap:6px;
      min-width: 220px;
    }
    label{ font-size:13px; color:var(--muted); font-weight:650; }
    input, select{
      width:100%;
      padding:10px 12px;
      border:1px solid var(--border);
      border-radius:14px;
      font-size:14px;
      outline:none;
      transition:.15s ease;
      background:#fff;
    }
    input:focus, select:focus{
      border-color: rgba(46,125,50,.45);
      box-shadow: 0 0 0 4px rgba(46,125,50,.12);
    }

    .stats{ display:grid; grid-template-columns: repeat(3, 1fr); gap:12px; margin-top:14px; }
    .stat{ border:1px solid var(--border); border-radius:16px; padding:14px; background:#fff; }
    .stat strong{ display:block; font-size:18px; color:var(--green-700); }
    .stat .meta{ margin-top:8px; display:flex; flex-direction:column; gap:4px; }
    .stat .meta .label{ color:var(--muted); font-size:13px; line-height:1.5; }
    .stat .meta .value{ color:var(--gray-700); font-weight:700; font-size:13px; line-height:1.5; }

    .chartWrap{
      margin-top:14px;
      border:1px solid var(--border);
      border-radius:16px;
      padding:12px;
      background:#fff;
    }
    .chartTitle{
      display:flex; align-items:center; justify-content:space-between;
      gap:10px;
      margin-bottom:10px;
    }
    .chartTitle strong{ font-size:14px; }
    .chartTitle span{ font-size:13px; color:var(--muted); }

    .quickGrid{ display:grid; grid-template-columns: 1fr 1fr; gap:18px; }
    .quickCard{
      border:1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      background:#fff;
      overflow:hidden;
      transition:.15s ease;
    }
    .quickCard:hover{ transform: translateY(-1px); box-shadow: 0 14px 34px rgba(0,0,0,.10); }
    .quickBody{ padding:18px; display:flex; gap:14px; align-items:flex-start; }
    .iconBadge{
      width:52px; height:52px; border-radius:16px;
      display:flex; align-items:center; justify-content:center;
      border:1px solid rgba(46,125,50,.18);
      background: linear-gradient(180deg, rgba(46,125,50,.12), rgba(46,125,50,.06));
      flex: 0 0 auto;
    }
    .iconBadge svg{ width:26px; height:26px; color: var(--green-700); }
    .quickText strong{ display:block; font-size:16px; margin-bottom:6px; }
    .quickText .muted{ line-height:1.7; }
    .quickActions{ margin-top:14px; display:flex; gap:10px; flex-wrap:wrap; }

    footer{ border-top:1px solid var(--border); padding:22px 0; color:var(--muted); font-size:13px; }

    @media (max-width: 920px){
      .grid{ grid-template-columns: 1fr; }
      .brand{ min-width:auto; }
      .brand img{ width:52px; height:52px; }
      .brand .title strong{ font-size:18px; }
      .brand .title span{ font-size:13px; }

      .cta{ display:none; }
      .navlinks{ display:none; }
      .hamburger{ display:block; }

      .stats{ grid-template-columns: 1fr; }
      .field{ min-width: 100%; }

      .quickGrid{ grid-template-columns: 1fr; }
    }
  </style>
</head>

<body>
  @php
    $periode = $periode ?? request('periode', now()->format('Y-m'));
    try {
      [$pYear, $pMonth] = explode('-', $periode);
      $pYear = (int)$pYear;
      $pMonth = (int)$pMonth;
    } catch (\Throwable $e) {
      $pYear = (int)now()->format('Y');
      $pMonth = (int)now()->format('m');
      $periode = now()->format('Y-m');
    }

    $tahun = $tahun ?? (int) request('tahun', now()->format('Y'));

    $nama = auth()->user()->name ?? 'Karyawan';
    $idPegawai = auth()->user()->id_pegawai ?? '-';

    $summaryLR = $summaryLR ?? [
      'pendapatan' => ['realisasi'=>0,'anggaran'=>0,'persen'=>null],
      'pengeluaran'=> ['realisasi'=>0,'anggaran'=>0,'persen'=>null],
      'laba_rugi'  => ['realisasi'=>0,'anggaran'=>0,'persen'=>null],
    ];

    $summaryProd = $summaryProd ?? ['total_kg'=>0,'total_ha'=>0,'kgha'=>0];

    $chartLabaRugiSafe = isset($chartLabaRugi) ? $chartLabaRugi : ['labels'=>[],'pendapatan'=>[],'pengeluaran'=>[],'laba'=>[]];
    $chartProduksiSafe = isset($chartProduksi) ? $chartProduksi : ['labels'=>[],'kg'=>[],'ha'=>[],'kgha'=>[]];

    $lrYears = $lrYears ?? [];
    if (!is_array($lrYears)) $lrYears = (array) $lrYears;
    $lrYears = array_values(array_filter(array_map('intval', $lrYears)));

    $periodeLabel = \Carbon\Carbon::createFromDate($pYear, $pMonth, 1)->translatedFormat('F Y');

    function rp($n){ return 'Rp ' . number_format((float)$n, 0, ',', '.'); }
    function num($n){ return number_format((float)$n, 0, ',', '.'); }
  @endphp

  <div class="topbar">
    <div class="container">
      <div class="nav">
        <a class="brand" href="{{ route('dashboard') }}">
          <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
          <div class="title">
            <strong>Dashboard Karyawan</strong>
            <span>Kebun Jollong — PTPN I Regional 3</span>
          </div>
        </a>

        <div class="navRight">
          <nav class="navlinks" aria-label="Navigasi">
            <a href="#ringkasan">Ringkasan</a>
            <a href="#pengelolaan">Kelola Data</a>
          </nav>

          <div class="cta">
            <div class="dropdown" id="akunDropdown">
              <div class="dropbtn" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
                {{ $nama }} <span class="caret"></span>
              </div>
              <div class="menu" role="menu" aria-label="Menu Akun">
                <a href="{{ route('worker.profil') }}" role="menuitem">Profil Akun</a>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" role="menuitem">Logout</button>
                </form>
              </div>
            </div>
          </div>

          <button class="hamburger" id="hamburger">Menu</button>
        </div>
      </div>

      <div class="mobileMenu" id="mobileMenu">
        <a href="#ringkasan">Ringkasan</a>
        <a href="#pengelolaan">Kelola Data</a>
        <a href="{{ route('worker.profil') }}">Profil Akun</a>
        <form method="POST" action="{{ route('logout') }}" style="margin:10px 0 0;">
          @csrf
          <button class="btn danger" style="width:100%; justify-content:center;" type="submit">Logout</button>
        </form>
      </div>
    </div>
  </div>

  <div class="hero">
    <div class="container">
      <div class="heroCard">
        <div class="heroMedia">
          <div class="heroContent">
            <div class="pill">
              • ID Pegawai: <strong>{{ $idPegawai }}</strong>
            </div>
            <h1>SELAMAT DATANG, {{ $nama }} </h1>
            <p>Portal Informasi dan Sistem Rekapitulasi Internal PTPN I Regional 3 Kebun Jollong</p>
          </div>
        </div>

        <div class="tabs" aria-label="Navigasi cepat">
          <a class="tab active" href="#ringkasan">Ringkasan</a>
          <a class="tab" href="#pengelolaan">Kelola Data</a>
        </div>
      </div>
    </div>
  </div>

  <section id="ringkasan" class="section" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Ringkasan Periode</h2></div>
      </div>

      <div class="card">
        <div class="cardBody">
          <form method="GET" action="{{ route('dashboard') }}" class="filters">
            <div class="field">
              <label for="periode_bulan">Bulan Laba Rugi</label>
              <select id="periode_bulan">
                @for($m=1;$m<=12;$m++)
                  <option value="{{ str_pad($m,2,'0',STR_PAD_LEFT) }}" @selected($pMonth === $m)>
                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                  </option>
                @endfor
              </select>
            </div>

            <div class="field">
              <label for="periode_tahun">Tahun Laba Rugi</label>
              <select id="periode_tahun">
                @if(count($lrYears))
                  @foreach($lrYears as $y)
                    <option value="{{ $y }}" @selected($pYear === (int)$y)>{{ $y }}</option>
                  @endforeach
                @else
                  @php
                    $yrMax = now()->year;
                    $yrMin = $yrMax - 10;
                  @endphp
                  @for($y=$yrMax; $y>=$yrMin; $y--)
                    <option value="{{ $y }}" @selected($pYear === $y)>{{ $y }}</option>
                  @endfor
                @endif
              </select>
            </div>

            <input type="hidden" name="periode" id="periodeHidden" value="{{ $periode }}"/>

            <div class="field">
              <label for="tahun">Tahun Produksi Kopi</label>
              <select id="tahun" name="tahun">
                @php
                  $maxY = now()->year;
                  $minY = 2017;
                @endphp
                @for ($y = $maxY; $y >= $minY; $y--)
                  <option value="{{ $y }}" @selected((int)$tahun === (int)$y)>{{ $y }}</option>
                @endfor
              </select>
            </div>

            <div class="field" style="min-width:160px;">
              <label>&nbsp;</label>
              <button class="btn primary" type="submit">Terapkan</button>
            </div>
          </form>
        </div>
      </div>

      <div class="grid" style="margin-top:18px;">
        <div class="card">
          <div class="cardBody">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
              <div>
                <strong style="display:block; font-size:16px;">Ringkasan Laba Rugi Agrowisata</strong>
                <span class="muted" style="font-size:13px;">Periode {{ $periodeLabel }}</span>
              </div>
            </div>

            @php
              $pendReal = (float)($summaryLR['pendapatan']['realisasi'] ?? 0);
              $pengReal = (float)($summaryLR['pengeluaran']['realisasi'] ?? 0);
              $lrReal   = (float)($summaryLR['laba_rugi']['realisasi'] ?? 0);
            @endphp

            <div class="stats">
              <div class="stat">
                <strong>{{ rp($pendReal) }}</strong>
                <div class="meta">
                  <div class="label">Pendapatan</div>
                  <div class="value">Realisasi periode {{ $periodeLabel }}</div>
                </div>
              </div>

              <div class="stat">
                <strong>{{ rp($pengReal) }}</strong>
                <div class="meta">
                  <div class="label">Pengeluaran</div>
                  <div class="value">Realisasi periode {{ $periodeLabel }}</div>
                </div>
              </div>

              <div class="stat">
                <strong>{{ rp($lrReal) }}</strong>
                <div class="meta">
                  <div class="label">Laba/Rugi</div>
                  <div class="value">
                    Status:
                    <span style="font-weight:900; color:{{ $lrReal >= 0 ? 'var(--ok)' : 'var(--danger)' }};">
                      {{ $lrReal >= 0 ? 'Surplus' : 'Defisit' }}
                    </span>
                    • {{ $periodeLabel }}
                  </div>
                </div>
              </div>
            </div>

            <div class="chartWrap">
              <div class="chartTitle">
                <strong>Grafik Laba/Rugi</strong>
                <span>Pendapatan vs Pengeluaran vs Laba/Rugi</span>
              </div>
              <canvas id="chartLabaRugi" height="110"></canvas>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="cardBody">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
              <div>
                <strong style="display:block; font-size:16px;">Ringkasan Produksi Kopi</strong>
                <span class="muted" style="font-size:13px;">Tahun {{ $tahun }}</span>
              </div>
            </div>

            <div class="stats">
              <div class="stat">
                <strong>{{ num($summaryProd['total_kg']) }} kg</strong>
                <div class="meta">
                  <div class="label">Total produksi kering</div>
                  <div class="value">Akumulasi tahun {{ $tahun }}</div>
                </div>
              </div>

              <div class="stat">
                <strong>{{ num($summaryProd['total_ha']) }} ha</strong>
                <div class="meta">
                  <div class="label">Total luas terlapor</div>
                  <div class="value">Akumulasi tahun {{ $tahun }}</div>
                </div>
              </div>

              <div class="stat">
                <strong>{{ number_format((float)$summaryProd['kgha'], 2, ',', '.') }} kg/ha</strong>
                <div class="meta">
                  <div class="label">Produktivitas rata-rata</div>
                  <div class="value">Kg per hektar • tahun {{ $tahun }}</div>
                </div>
              </div>
            </div>

            <div class="chartWrap">
              <div class="chartTitle">
                <strong>Grafik Produksi</strong>
                <span>Produksi (kg) & Produktivitas (kg/ha)</span>
              </div>
              <canvas id="chartProduksi" height="110"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="pengelolaan" class="section" style="background:#fbfdfc;" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Kelola Data</h2></div>
        <p>Masuk ke modul pengelolaan data. Export Excel tersedia di dalam modul pada halaman laporan/rekap.</p>
      </div>

      <div class="quickGrid">
        <a class="quickCard" href="{{ route('worker.laba_rugi.index', ['periode' => $periode]) }}">
          <div class="quickBody">
            <div class="iconBadge" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="quickText">
              <strong>Kelola Laba Rugi Agrowisata</strong>
              <div class="muted">
                Input pendapatan/biaya, persediaan, dan review kinerja periode berjalan.
              </div>
              <div class="quickActions">
                <span class="btn primary">Kelola Laba Rugi</span>
                <span class="chip" aria-label="Periode terpilih">Periode: {{ $periode }}</span>
              </div>
            </div>
          </div>
        </a>

        <a class="quickCard" href="{{ url('/produksi-kopi?tahun='.$tahun) }}">
          <div class="quickBody">
            <div class="iconBadge" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M6 18c6.5 0 12-5.5 12-12 0 0-5.5 0-9 3.5C6.5 12 6 15 6 18Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                <path d="M6 18c0-4 2-7 6-9" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="quickText">
              <strong>Kelola Produksi Kopi</strong>
              <div class="muted">
                Input produksi per tahun tanam, pantau rekap, dan produktivitas tahunan.
              </div>
              <div class="quickActions">
                <span class="btn primary">Kelola Produksi</span>
                <span class="chip" aria-label="Tahun terpilih">Tahun: {{ $tahun }}</span>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      © 2026 — Kebun Jollong (PTPN I Regional 3).
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const selBulan = document.getElementById('periode_bulan');
    const selTahun = document.getElementById('periode_tahun');
    const periodeHidden = document.getElementById('periodeHidden');
    function syncPeriode(){
      if(!selBulan || !selTahun || !periodeHidden) return;
      periodeHidden.value = `${selTahun.value}-${selBulan.value}`;
    }
    selBulan?.addEventListener('change', syncPeriode);
    selTahun?.addEventListener('change', syncPeriode);
    syncPeriode();

    const dd = document.getElementById("akunDropdown");
    const dropBtn = dd?.querySelector(".dropbtn");
    function closeDropdown(){
      if(!dd) return;
      dd.classList.remove("open");
      dropBtn?.setAttribute("aria-expanded","false");
    }
    dropBtn?.addEventListener("click", () => {
      dd.classList.toggle("open");
      dropBtn.setAttribute("aria-expanded", dd.classList.contains("open") ? "true" : "false");
    });
    document.addEventListener("click", (e) => {
      if(!dd) return;
      if(!dd.contains(e.target)) closeDropdown();
    });

    const hamburger = document.getElementById("hamburger");
    const mobileMenu = document.getElementById("mobileMenu");
    hamburger?.addEventListener("click", () => mobileMenu.classList.toggle("open"));

    const tabLinks = Array.from(document.querySelectorAll(".tabs .tab"));
    const sectionIdsForTabs = tabLinks.map(a => a.getAttribute("href")).filter(Boolean);

    function setActiveTab(hash){
      tabLinks.forEach(t => t.classList.remove("active"));
      const target = tabLinks.find(t => t.getAttribute("href") === hash);
      if(target) target.classList.add("active");
    }

    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener("click", (e) => {
        const href = a.getAttribute("href");
        if(!href || href === "#") return;
        const el = document.querySelector(href);
        if(!el) return;

        e.preventDefault();
        mobileMenu?.classList.remove("open");
        if(a.classList.contains("tab")) setActiveTab(href);

        el.scrollIntoView({ behavior: "smooth", block: "start" });
        history.replaceState(null, "", href);
      });
    });

    const sections = Array.from(document.querySelectorAll("[data-section]"));
    function getCurrentSectionId() {
      const offset = 120;
      for (const sec of sections) {
        const id = "#" + sec.id;
        if (!sectionIdsForTabs.includes(id)) continue;
        const r = sec.getBoundingClientRect();
        if (r.top <= offset && r.bottom > offset) return id;
      }
      return null;
    }

    let ticking = false;
    window.addEventListener("scroll", () => {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(() => {
        const id = getCurrentSectionId();
        if (id) {
          setActiveTab(id);
          history.replaceState(null, "", id);
        }
        ticking = false;
      });
    });

    window.addEventListener("load", () => {
      const id = location.hash && sectionIdsForTabs.includes(location.hash)
        ? location.hash
        : getCurrentSectionId();
      if (id) setActiveTab(id);
    });

    const chartLabaRugiData = @json($chartLabaRugiSafe);
    const chartProduksiData = @json($chartProduksiSafe);

    const PALET = {
      green: '#1B5E20',
      navy:  '#1E3A8A',
      gray:  '#4B5563',
      grid:  '#E5E7EB',
      tick:  '#6B7280',
      bgGreen: 'rgba(27,94,32,.10)',
      bgNavy:  'rgba(30,58,138,.10)',
      bgGray:  'rgba(75,85,99,.10)',
    };

    const rupiahTick = (v) => 'Rp ' + new Intl.NumberFormat('id-ID').format(v);

    const ctxLR = document.getElementById('chartLabaRugi');
    if (ctxLR) {
      new Chart(ctxLR, {
        type: 'line',
        data: {
          labels: chartLabaRugiData.labels || [],
          datasets: [
            {
              label: 'Pendapatan',
              data: chartLabaRugiData.pendapatan || [],
              borderColor: PALET.green,
              backgroundColor: PALET.bgGreen,
              pointBackgroundColor: PALET.green,
              pointBorderColor: PALET.green,
              borderWidth: 2.5,
              pointRadius: 2.5,
              tension: 0.25,
              fill: false
            },
            {
              label: 'Pengeluaran',
              data: chartLabaRugiData.pengeluaran || [],
              borderColor: PALET.navy,
              backgroundColor: PALET.bgNavy,
              pointBackgroundColor: PALET.navy,
              pointBorderColor: PALET.navy,
              borderWidth: 2.5,
              pointRadius: 2.5,
              tension: 0.25,
              fill: false
            },
            {
              label: 'Laba/Rugi',
              data: chartLabaRugiData.laba || [],
              borderColor: PALET.gray,
              backgroundColor: PALET.bgGray,
              pointBackgroundColor: PALET.gray,
              pointBorderColor: PALET.gray,
              borderWidth: 2.5,
              pointRadius: 2.5,
              tension: 0.25,
              fill: false,
              borderDash: [6, 4]
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              labels: { color: PALET.tick, boxWidth: 14, boxHeight: 10 }
            },
            tooltip: {
              callbacks: {
                label: (ctx) => `${ctx.dataset.label}: ${rupiahTick(ctx.parsed.y)}`
              }
            }
          },
          scales: {
            x: { ticks: { color: PALET.tick }, grid: { color: PALET.grid } },
            y: { ticks: { color: PALET.tick, callback: rupiahTick }, grid: { color: PALET.grid } }
          }
        }
      });
    }

    const ctxP = document.getElementById('chartProduksi');
    if (ctxP) {
      new Chart(ctxP, {
        type: 'bar',
        data: {
          labels: chartProduksiData.labels || [],
          datasets: [
            {
              label: 'Produksi (kg)',
              data: chartProduksiData.kg || [],
              backgroundColor: 'rgba(27,94,32,.55)',
              borderColor: PALET.green,
              borderWidth: 1.5,
              borderRadius: 6
            },
            {
              label: 'Produktivitas (kg/ha)',
              data: chartProduksiData.kgha || [],
              backgroundColor: 'rgba(30,58,138,.45)',
              borderColor: PALET.navy,
              borderWidth: 1.5,
              borderRadius: 6
            }
          ]
        },
        options: {
          responsive: true,
          plugins: {
            legend: {
              position: 'bottom',
              labels: { color: PALET.tick, boxWidth: 14, boxHeight: 10 }
            },
            tooltip: {
              callbacks: {
                label: (ctx) => `${ctx.dataset.label}: ${new Intl.NumberFormat('id-ID').format(ctx.parsed.y)}`
              }
            }
          },
          scales: {
            x: { ticks: { color: PALET.tick }, grid: { color: PALET.grid } },
            y: { ticks: { color: PALET.tick }, grid: { color: PALET.grid } }
          }
        }
      });
    }
  </script>
</body>
</html>
