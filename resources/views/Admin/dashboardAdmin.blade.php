<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin — Kebun Jollong</title>

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

    .card{
      border:1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      background:#fff;
      overflow:hidden;
    }
    .cardBody{ padding:18px; }

    .summaryHead{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:14px;
      margin-bottom:14px;
    }
    .summaryTitle{
      font-weight:900;
      font-size:18px;
      margin:0;
    }
    .summaryDate{
      font-size:13px;
      color:var(--muted);
      white-space:nowrap;
    }

    .stats{
      display:grid;
      grid-template-columns: repeat(3, 1fr);
      gap:14px;
      margin-top:6px;
    }

    .stat{
      position:relative;
      border:1px solid var(--border);
      border-radius:16px;
      background:#fff;
      padding:16px 16px 16px 18px;
      overflow:hidden;
      min-height:108px;
    }
    .stat::before{
      content:"";
      position:absolute;
      left:0; top:0; bottom:0;
      width:6px;
      background: linear-gradient(180deg, var(--green-700), var(--green-500));
      border-top-left-radius:16px;
      border-bottom-left-radius:16px;
    }

    .stat .num{
      font-size:34px;
      font-weight:900;
      letter-spacing:.2px;
      color:var(--green-700);
      line-height:1.1;
      margin:0 0 8px 0;
    }
    .stat .label{
      font-size:14px;
      font-weight:850;
      color:var(--gray-900);
      margin:0 0 6px 0;
    }
    .stat .desc{
      font-size:13px;
      color:var(--muted);
      margin:0;
      line-height:1.6;
    }

    .quickGrid{ display:grid; grid-template-columns: repeat(3, 1fr); gap:18px; }

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
    .quickText .muted{ line-height:1.7; color:var(--muted); }
    .quickActions{ margin-top:14px; display:flex; gap:10px; flex-wrap:wrap; }

    .tableWrap{
      margin-top:14px;
      border:1px solid var(--border);
      border-radius:16px;
      overflow:hidden;
      background:#fff;
    }
    table{ width:100%; border-collapse:collapse; }
    th,td{ padding:12px 12px; border-bottom:1px solid var(--grid); font-size:14px; text-align:left; }
    th{
      background: var(--green-100);
      color: var(--green-700);
      font-weight:900;
      letter-spacing:.10em;
      text-transform: uppercase;
      font-size:12px;
    }
    tr:hover td{ background: #fbfdfc; }

    .badge{
      display:inline-flex; align-items:center; justify-content:center;
      padding:6px 10px; border-radius:999px;
      font-size:12px; font-weight:800;
      border:1px solid rgba(46,125,50,.22);
      background: var(--green-100);
      color: var(--green-700);
      white-space:nowrap;
    }
    .badge.navy{
      border-color: rgba(30,58,138,.25);
      background: var(--navy-100);
      color: var(--navy-700);
    }

    footer{ border-top:1px solid var(--border); padding:22px 0; color:var(--muted); font-size:13px; }

    @media (max-width: 920px){
      .brand{ min-width:auto; }
      .brand img{ width:52px; height:52px; }
      .brand .title strong{ font-size:18px; }
      .brand .title span{ font-size:13px; }

      .cta{ display:none; }
      .navlinks{ display:none; }
      .hamburger{ display:block; }

      .stats{ grid-template-columns: 1fr; }
      .quickGrid{ grid-template-columns: 1fr; }
      .summaryHead{ align-items:flex-start; flex-direction:column; }
      .summaryDate{ margin-top:-6px; }
    }
  </style>
</head>

<body>
  @php
    $nama = auth()->user()->name ?? 'Admin';
    $idPegawai = auth()->user()->id_pegawai ?? '-';

    $adminStats = $adminStats ?? [
      'total_users' => 0,
      'total_karyawan' => 0,
      'logs_today' => 0,
    ];

    $recentLogs = $recentLogs ?? collect();
    if (!($recentLogs instanceof \Illuminate\Support\Collection)) {
      $recentLogs = collect($recentLogs);
    }

    $todayLabel = now()->translatedFormat('d F Y');
  @endphp

  <div class="topbar">
    <div class="container">
      <div class="nav">
        <a class="brand" href="{{ route('admin.dashboard') }}">
          <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
          <div class="title">
            <strong>Dashboard Admin</strong>
            <span>Kebun Jollong — PTPN I Regional 3</span>
          </div>
        </a>

        <div class="navRight">
          <nav class="navlinks" aria-label="Navigasi">
            <a href="#ringkasan">Ringkasan</a>
            <a href="#menu">Menu Admin</a>
            <a href="#aktivitas">Aktivitas</a>
          </nav>

          <div class="cta">
            <div class="dropdown" id="akunDropdown">
              <div class="dropbtn" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
                {{ $nama }} <span class="caret"></span>
              </div>
              <div class="menu" role="menu" aria-label="Menu Akun">
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
        <a href="#menu">Menu Admin</a>
        <a href="#aktivitas">Aktivitas</a>
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
              • Admin ID: <strong>{{ $idPegawai }}</strong>
            </div>
            <h1>SELAMAT DATANG, {{ $nama }}</h1>
            <p>Panel Admin untuk kelola data karyawan dan pengguna sistem serta pemantauan aktivitas sistem.</p>
          </div>
        </div>

        <div class="tabs" aria-label="Navigasi cepat">
          <a class="tab active" href="#ringkasan">Ringkasan</a>
          <a class="tab" href="#menu">Menu Admin</a>
          <a class="tab" href="#aktivitas">Aktivitas</a>
        </div>
      </div>
    </div>
  </div>

  <section id="ringkasan" class="section" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Ringkasan Hari Ini</h2></div>
        <p>Pantau kondisi sistem secara cepat per {{ $todayLabel }}.</p>
      </div>

      <div class="card">
        <div class="cardBody">
          <div class="summaryHead">
            <div class="summaryTitle">Ringkasan Hari Ini</div>
            <div class="summaryDate">{{ $todayLabel }}</div>
          </div>

          <div class="stats">
            <div class="stat">
              <div class="num">{{ number_format((int)$adminStats['total_users'], 0, ',', '.') }}</div>
              <div class="label">Total User</div>
              <div class="desc">Akun aktif di sistem</div>
            </div>

            <div class="stat">
              <div class="num">{{ number_format((int)$adminStats['total_karyawan'], 0, ',', '.') }}</div>
              <div class="label">Total Karyawan</div>
              <div class="desc">Data karyawan Kebun Jollong</div>
            </div>

            <div class="stat">
              <div class="num">{{ number_format((int)$adminStats['logs_today'], 0, ',', '.') }}</div>
              <div class="label">Aktivitas Hari Ini</div>
              <div class="desc">Log sistem tercatat</div>
            </div>
          </div>

          <div style="margin-top:14px; display:flex; gap:10px; flex-wrap:wrap;">
            <span class="chip">Tanggal: {{ $todayLabel }}</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="menu" class="section" style="background:#fbfdfc;" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Menu Admin</h2></div>
        <p>Akses cepat untuk fungsi utama admin sistem.</p>
      </div>

      <div class="quickGrid">
        <a class="quickCard" href="{{ route('admin.karyawan.create') }}">
          <div class="quickBody">
            <div class="iconBadge" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="quickText">
              <strong>Kelola Data Karyawan</strong>
              <div class="muted">Kelola data karyawan melalui panel admin.</div>
              <div class="quickActions">
                <span class="btn primary">Kelola Data Karyawan</span>
              </div>
            </div>
          </div>
        </a>

        <a class="quickCard" href="{{ route('admin.activity_logs.index') }}">
          <div class="quickBody">
            <div class="iconBadge" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M12 8v5l3 2" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" stroke="currentColor" stroke-width="2.2"/>
              </svg>
            </div>
            <div class="quickText">
              <strong>Aktivitas Karyawan</strong>
              <div class="muted">Lihat log aktivitas karyawan dan perubahan data terbaru.</div>
              <div class="quickActions">
                <span class="btn primary">Lihat Aktivitas</span>
              </div>
            </div>
          </div>
        </a>

        <a class="quickCard" href="{{ route('admin.users.index') }}">
          <div class="quickBody">
            <div class="iconBadge" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none">
                <path d="M16 11a4 4 0 1 0-8 0 4 4 0 0 0 8 0Z" stroke="currentColor" stroke-width="2.2"/>
                <path d="M4 20c1.7-3.2 4.5-5 8-5s6.3 1.8 8 5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="quickText">
              <strong>Kelola Pengguna</strong>
              <div class="muted">Kelola akun: aktif/nonaktif, reset password, dan status penggantian password.</div>
              <div class="quickActions">
                <span class="btn primary">Kelola Pengguna</span>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </section>

  <section id="aktivitas" class="section" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Aktivitas Terbaru</h2></div>
        <p>Log aktivitas terbaru di Sistem Rekapitulasi Kebun Jollong.</p>
      </div>

      <div class="card">
        <div class="cardBody">
          <div class="tableWrap">
            <table>
              <thead>
                <tr>
                  <th>Waktu</th>
                  <th>Karyawan</th>
                  <th>Aksi</th>
                  <th>Modul</th>
                  <th>Keterangan</th>
                  <th>IP Address</th>
                </tr>
              </thead>
              <tbody>
                @forelse($recentLogs as $log)
                  @php
                    $waktu = $log->created_at ? $log->created_at->format('d/m/Y H:i') : '-';
                    $karyawanNama = $log->karyawan->name ?? $log->user->name ?? '-';
                    $karyawanId = $log->karyawan_id ?? null;
                    $aksi = $log->action ?? '-';
                    $modul = $log->module ?? '-';
                    $ket = $log->description ?? '-';
                    $ip = $log->ip_address ?? '-';
                  @endphp
                  <tr>
                    <td>{{ $waktu }}</td>
                    <td>
                      <div style="display:flex; flex-direction:column; gap:3px;">
                        <strong>{{ $karyawanNama }}</strong>
                        <span style="font-size:12px; color:var(--muted);">
                          {{ $karyawanId ? ('ID: '.$karyawanId) : '' }}
                        </span>
                      </div>
                    </td>
                    <td><span class="badge">{{ strtoupper($aksi) }}</span></td>
                    <td><span class="badge navy">{{ $modul }}</span></td>
                    <td>{{ $ket }}</td>
                    <td style="color:var(--muted);">{{ $ip }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" style="color:var(--muted);">Belum ada aktivitas tercatat.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="container">
      © 2026 — Kebun Jollong (PTPN I Regional 3).
    </div>
  </footer>

  <script>
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
  </script>
</body>
</html>
