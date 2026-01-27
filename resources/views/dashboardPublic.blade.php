<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kebun Jollong — PTPN I Regional 3</title>

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
      --bg:#f7faf8;

      --shadow: 0 10px 26px rgba(0,0,0,.06);
      --shadow-soft: 0 6px 18px rgba(0,0,0,.06);
      --radius: 18px;

      --focus: rgba(46,125,50,.35);
    }

    *{ box-sizing:border-box; }
    html,body{ margin:0; padding:0; font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial; color:var(--text); background:#fff; }
    a{ color:inherit; text-decoration:none; }
    img{ max-width:100%; height:auto; display:block; }

    .container{ width:min(1120px, 92%); margin:0 auto; }

    .topbar{
      position:sticky; top:0; z-index:50;
      background:rgba(255,255,255,.84);
      backdrop-filter: blur(10px);
      border-bottom:1px solid var(--border);
    }
    .nav{
      display:flex; align-items:center; justify-content:space-between;
      padding:12px 0; gap:14px;
    }

    .brand{
      display:flex; align-items:center; gap:12px;
      min-width: 220px;
    }
    .brand img{
      width:120px; height:44px;
      object-fit:contain;
    }
    .brand .title{ display:flex; flex-direction:column; line-height:1.12; }
    .brand .title strong{ font-size:18px; font-weight:800; letter-spacing:.2px; }
    .brand .title span{ font-size:13px; color:var(--muted); margin-top:2px; }

    .navRight{
      display:flex;
      align-items:center;
      justify-content:flex-end;
      gap:12px;
    }

    .navlinks{
      display:flex; align-items:center;
      gap:6px;
      font-size:14px;
      justify-content:flex-end;
    }
    .navlinks a{
      padding:8px 10px; border-radius:999px;
      transition: .15s ease;
      color:#1f2937;
    }
    .navlinks a:hover{
      background: var(--green-100);
      color: var(--green-700);
    }

    .cta{ display:flex; align-items:center; gap:10px; }
    .btn{
      padding:10px 14px; border-radius:999px; font-size:14px;
      border:1px solid var(--border); background:#fff;
      cursor:pointer; transition:.15s ease; white-space:nowrap;
      display:inline-flex; align-items:center; justify-content:center;
    }
    .btn.primary{
      border-color: transparent;
      background: linear-gradient(135deg, var(--green-700), var(--green-500));
      color:#fff;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: var(--shadow-soft); }

    .hamburger{
      display:none;
      border:1px solid var(--border);
      background:#fff;
      border-radius:14px;
      padding:10px 12px;
      cursor:pointer;
    }

    .drawerBackdrop{
      position:fixed; inset:0;
      background: rgba(0,0,0,.35);
      opacity:0; pointer-events:none;
      transition:.18s ease;
      z-index:60;
    }
    .drawerBackdrop.open{ opacity:1; pointer-events:auto; }
    .drawer{
      position:fixed; top:0; right:0; height:100%; width:min(360px, 86vw);
      background:#fff;
      border-left:1px solid var(--border);
      transform: translateX(100%);
      transition:.22s ease;
      z-index:70;
      padding:14px;
      display:flex; flex-direction:column;
      gap:10px;
    }
    .drawer.open{ transform: translateX(0); }
    .drawerHeader{
      display:flex; align-items:center; justify-content:space-between;
      padding:6px 2px 10px;
      border-bottom:1px solid var(--border);
    }
    .drawerHeader strong{ font-size:14px; }
    .drawer a{
      display:flex; align-items:center;
      padding:12px 12px;
      border:1px solid var(--border);
      border-radius:14px;
      font-size:14px;
      background:#fff;
    }
    .drawer a:hover{ background: var(--green-100); border-color: rgba(46,125,50,.22); color: var(--green-700); }

    .hero{ padding:18px 0 10px; background: linear-gradient(180deg, #fff, var(--bg)); }
    .heroCard{
      border-radius: var(--radius);
      overflow:hidden;
      box-shadow: var(--shadow);
      border:1px solid var(--border);
      background:#fff;
    }
    .heroMedia{
      position:relative;
      height: clamp(280px, 42vw, 520px);
      background:
        radial-gradient(circle at 20% 20%, rgba(67,160,71,.18), transparent 40%),
        linear-gradient(180deg, rgba(0,0,0,.55) 0%, rgba(0,0,0,.22) 55%, rgba(0,0,0,.08) 100%),
        url("img/Petik Kopi.jpg") center/cover no-repeat;
    }
    .heroContent{
      position:absolute; left:22px; right:22px; bottom:20px;
      color:#fff;
      max-width: 820px;
    }
    .heroContent h1{
      margin:0 0 8px;
      font-size: clamp(28px, 3.8vw, 50px);
      line-height:1.08;
      text-shadow: 0 10px 30px rgba(0,0,0,.35);
      letter-spacing:.2px;
    }
    .heroContent p{
      margin:0;
      font-size:14px;
      line-height:1.65;
      opacity:.95;
      text-shadow: 0 8px 22px rgba(0,0,0,.28);
      max-width: 720px;
    }

    .tabs{
      display:flex; gap:8px;
      padding:12px 14px;
      background:#fff;
      flex-wrap:wrap;
      border-top:1px solid var(--border);
    }
    .tab{
      padding:9px 12px;
      border-radius:999px;
      border:1px solid var(--border);
      font-size:14px;
      color:var(--muted);
      transition:.15s ease;
      cursor:pointer;
      user-select:none;
      background:#fff;
    }
    .tab:hover{
      background: var(--green-100);
      color: var(--green-700);
      border-color: rgba(46,125,50,.22);
    }
    .tab.active{
      color:var(--green-700);
      border-color: rgba(46,125,50,.35);
      background: var(--green-100);
      font-weight:700;
    }

    .section{ padding:34px 0; scroll-margin-top: 110px; }
    .sectionAlt{ background:#fbfdfc; }
    .sectionHeader{
      display:flex; align-items:flex-end; justify-content:space-between;
      gap:18px; margin-bottom:14px;
    }
    .sectionHeader h2{
      margin:0;
      font-size:24px;
      letter-spacing:.2px;
      position:relative;
      padding-bottom:10px;
    }
    .sectionHeader h2::after{
      content:""; position:absolute; left:0; bottom:0;
      width:74px; height:4px; border-radius:999px;
      background: linear-gradient(90deg, var(--green-700), var(--green-500));
    }
    .sectionHeader p{
      margin:0;
      color:var(--muted);
      font-size:14px;
      max-width:560px;
      line-height:1.6;
      text-align:left;
    }

    .grid{
      display:grid;
      grid-template-columns: 1.35fr .85fr;
      gap:18px;
      align-items:stretch;
    }

    .card{
      border:1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      background:#fff;
      overflow:hidden;
      height:100%;
    }
    .cardBody{
      padding:18px;
      height:100%;
      display:flex;
      flex-direction:column;
    }

    .pill{
      display:inline-flex; align-items:center; gap:8px;
      padding:6px 10px; border-radius:999px; font-size:12px;
      background: var(--green-100);
      color: var(--green-700);
      border:1px solid rgba(46,125,50,.18);
      margin-bottom:10px;
      font-weight:600;
      width:max-content;
    }
    .muted{ color:var(--muted); }

    .list{ display:grid; gap:10px; margin-top:12px; }
    .listItem{
      display:flex; gap:10px; padding:12px 12px;
      border-radius:14px;
      border:1px solid var(--border);
      background:#fff;
    }
    .dot{
      width:10px; height:10px; border-radius:999px;
      background: var(--green-600);
      margin-top:6px; flex:0 0 auto;
      box-shadow: 0 0 0 3px rgba(67,160,71,.12);
    }

    .stats{ display:grid; grid-template-columns: repeat(3, 1fr); gap:12px; margin-top:14px; }
    .stat{
      border:1px solid var(--border);
      border-radius:16px;
      padding:14px;
      background:#fff;
    }
    .stat strong{ display:block; font-size:17px; color:var(--green-700); }
    .stat span{ display:block; margin-top:4px; color:var(--muted); font-size:13px; }

    .mapCard{
      height:100%;
      min-height:280px;
      border-radius: var(--radius);
      overflow:hidden;
      border:1px solid var(--border);
      box-shadow: var(--shadow);
      background:#fff;
    }
    .mapCard iframe{
      width:100%;
      height:100%;
      border:0;
      display:block;
    }

    .productWrap{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:18px;
      align-items:stretch;
    }

    .productMedia{
      border:1px solid var(--border);
      border-radius:16px;
      overflow:hidden;
      background:#fff;
      box-shadow: var(--shadow);
      transition:.15s ease;
      display:block;
    }
    .productMedia:hover{ transform: translateY(-2px); box-shadow: var(--shadow-soft); }

    .productMedia img{
      width:100%;
      height:320px;
      object-fit:cover;
      display:block;
    }
    .productCap{
      padding:12px 14px;
      font-size:14px;
      color:var(--muted);
      border-top:1px solid var(--border);
      background:#fff;
    }
    .productCap strong{
      display:block;
      color:#111827;
      font-size:18px;
      font-weight:800;
      margin-bottom:6px;
      letter-spacing:.2px;
    }
    .productCap .meta{
      font-size:13px;
      line-height:1.6;
      color:var(--muted);
    }

    .productInfo{
      border:1px solid var(--border);
      border-radius: var(--radius);
      overflow:hidden;
      background:#fff;
      box-shadow: var(--shadow);
      height:100%;
    }
    .productInfo .cardBody{ padding:18px; }
    .productTitle{
      margin:0 0 8px;
      font-size:20px;
      font-weight:800;
      letter-spacing:.2px;
    }

    .galleryGrid{
      display:grid;
      grid-template-columns: repeat(3, 1fr);
      gap:12px;
      margin-top:14px;
    }
    .gItem{
      border:1px solid var(--border);
      border-radius:16px;
      overflow:hidden;
      background:#fff;
      box-shadow: var(--shadow);
      transition:.15s ease;
    }
    .gItem:hover{ transform: translateY(-2px); box-shadow: var(--shadow-soft); }
    .gItem img{
      width:100%;
      height:170px;
      object-fit:cover;
    }
    .gCap{
      padding:10px 12px;
      font-size:13px;
      color:var(--muted);
    }

    footer{
      border-top:1px solid var(--border);
      padding:22px 0;
      color:var(--muted);
      font-size:13px;
      background:#fff;
    }
    .listItem a:hover{ text-decoration:underline; color: var(--green-700); }

    :focus-visible{ outline: 3px solid var(--focus); outline-offset: 2px; border-radius: 12px; }

    .flowWrap{
      margin-top:10px;
      flex: 1 1 auto;
      min-height: 0;
      border:1px solid rgba(46,125,50,.18);
      border-radius:16px;
      background:
        radial-gradient(circle at 30% 20%, rgba(67,160,71,.12), transparent 55%),
        linear-gradient(180deg, rgba(46,125,50,.08), rgba(255,255,255,0)),
        #f8fafc;
      padding:14px;
      overflow:auto;
      max-height: 320px;
    }
    .flow{
      display:grid;
      gap:12px;
    }
    .flowItem{
      display:flex;
      gap:14px;
      align-items:flex-start;
      padding:14px 14px;
      border-radius:16px;
      background:#fff;
      border:1px solid var(--border);
    }
    .flowIcon{
      width:38px; height:38px;
      border-radius:12px;
      display:flex; align-items:center; justify-content:center;
      font-weight:800;
      font-size:14px;
      color:var(--green-700);
      background: var(--green-100);
      border:1px solid rgba(46,125,50,.18);
      flex:0 0 auto;
    }
    .flowText strong{ display:block; font-size:15px; }
    .flowText .muted{ font-size:13.5px; line-height:1.6; }

    @media (prefers-reduced-motion: reduce){
      *{ scroll-behavior:auto !important; transition:none !important; animation:none !important; }
    }

    @media (max-width: 980px){
      .grid{ grid-template-columns: 1fr; }
      .stats{ grid-template-columns: 1fr; }
      .galleryGrid{ grid-template-columns: repeat(2, 1fr); }
      .productWrap{ grid-template-columns: 1fr; }
      .productMedia img{ height:340px; }
      .flowWrap{ max-height: 280px; }
    }

    @media (max-width: 820px){
      .navRight{ display:none; }
      .hamburger{ display:block; }
      .brand img{ width:110px; height:42px; }
      .sectionHeader{ flex-direction:column; align-items:flex-start; }
      .sectionHeader p{ max-width:100%; }
      .galleryGrid{ grid-template-columns: 1fr; }
      .gItem img{ height:210px; }
      .productMedia img{ height:360px; }
    }
  </style>
</head>

<body>
  <div class="topbar">
    <div class="container">
      <div class="nav">
        <a class="brand" href="#top" aria-label="Kembali ke atas">
          <img src="img/Logo PTPN1.png" alt="Logo PTPN I" />
          <div class="title">
            <strong>Kebun Jollong</strong>
            <span>PTPN I — Regional 3</span>
          </div>
        </a>

        <div class="navRight">
          <nav class="navlinks" aria-label="Navigasi">
            <a href="#profil">Profil</a>
            <a href="#produk-unggulan">Produk Unggulan</a>
            <a href="#produksi">Informasi Produksi Kopi</a>
            <a href="#agrowisata">Agrowisata</a>
            <a href="#galeri">Galeri</a>
          </nav>

          <div class="cta">
            <a class="btn primary" href="{{ route('login') }}">Login</a>
          </div>
        </div>

        <button class="hamburger" id="hamburger" aria-label="Buka menu" type="button">Menu</button>
      </div>
    </div>
  </div>

  <div class="drawerBackdrop" id="drawerBackdrop" aria-hidden="true"></div>
  <aside class="drawer" id="drawer" aria-label="Menu mobile">
    <div class="drawerHeader">
      <strong>Navigasi</strong>
      <button class="btn" id="drawerClose" type="button" aria-label="Tutup menu">Tutup</button>
    </div>
    <a href="#profil">Profil</a>
    <a href="#produk-unggulan">Produk Unggulan</a>
    <a href="#produksi">Informasi Produksi Kopi</a>
    <a href="#agrowisata">Agrowisata</a>
    <a href="#galeri">Galeri</a>
    <a class="btn primary" style="border-radius:14px;" href="{{ route('login') }}">Login</a>
  </aside>

  <div id="top" class="hero">
    <div class="container">
      <div class="heroCard">
        <div class="heroMedia">
          <div class="heroContent">
            <h1>Sistem Rekapitulasi Kebun Jollong</h1>
            <p>Portal informasi dan ringkasan rekap Kebun Jollong (PTPN I — Regional 3).</p>
          </div>
        </div>

        <div class="tabs" aria-label="Navigasi cepat">
          <a class="tab active" href="#profil">Profil</a>
          <a class="tab" href="#produk-unggulan">Produk Unggulan</a>
          <a class="tab" href="#produksi">Informasi Produksi Kopi</a>
          <a class="tab" href="#agrowisata">Agrowisata</a>
          <a class="tab" href="#galeri">Galeri</a>
        </div>
      </div>
    </div>
  </div>

  <section id="profil" class="section" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Profil Kebun</h2></div>
      </div>

      <div class="grid">
        <div class="card">
          <div class="cardBody">
            <div class="pill">Ringkasan</div>
            <h3 style="margin:0 0 8px;">Kebun Jollong — PTPN I Regional 3</h3>
            <div class="muted" style="line-height:1.75;">
              Kebun Jollong merupakan unit usaha PTPN I Regional 3 yang berlokasi di kawasan lereng Gunung Muria pada ketinggian ±700 meter di atas permukaan laut. Terletak di Desa Sitiluhur, Kecamatan Gembong, Kabupaten Pati, Jawa Tengah, Kebun Jollong mengelola kegiatan perkebunan dan pengolahan kopi sekaligus mengembangkan potensi agrowisata berbasis edukasi dan lingkungan. Dengan kondisi alam yang sejuk dan asri, Kebun Jollong berkomitmen mendukung produktivitas, mutu hasil perkebunan, serta pengelolaan berkelanjutan.
            </div>

            <div class="stats">
              <div class="stat"><strong>530.69 ha</strong><span>Luas Areal</span></div>
              <div class="stat"><strong>Kopi</strong><span>Komoditas Utama</span></div>
              <div class="stat"><strong>Pati, Jawa Tengah</strong><span>Lokasi (Kab/Prov)</span></div>
            </div>

            <div class="list">
              <div class="listItem">
                <span class="dot"></span>
                <div><strong>Unit Operasional</strong><br/><span class="muted">Afdeling/Unit (Tanaman, Teknik, Agro Wisata), Pabrik, Gudang</span></div>
              </div>
              <div class="listItem">
                <span class="dot"></span>
                <div><strong>Fokus</strong><br/><span class="muted">Produktivitas • Mutu • K3 • Agrowisata • Digitalisasi</span></div>
              </div>
            </div>
          </div>
        </div>

        <div class="mapCard" aria-label="Peta lokasi Kebun Jollong">
          <iframe
            src="https://www.google.com/maps?q=PTPN%209%20Kebun%20Jollong%2C%20Sitiluhur%2C%20Gembong%2C%20Kabupaten%20Pati%2C%20Jawa%20Tengah&output=embed"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
  </section>

  <section id="produk-unggulan" class="section sectionAlt" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Produk Unggulan</h2></div>
      </div>

      <div class="productWrap">
        <div class="productMedia">
          <img src="img/Kopi Bubuk Jollong.jpeg" alt="Kopi Jollong - Kopi Bubuk Robusta">
          <div class="productCap">
            <strong>Kopi Jollong — Kopi Bubuk Robusta</strong>
            <div class="meta">100% Robusta</div>
          </div>
        </div>

        <div class="productInfo">
          <div class="cardBody">
            <div class="pill">Produk</div>
            <h3 class="productTitle">Kopi Jollong — Kopi Bubuk Robusta</h3>
            <div class="muted" style="line-height:1.75;">
              Kopi Jollong merupakan produk unggulan berbahan baku 100% biji kopi Robusta asli pilihan yang diolah melalui proses terstandar untuk menjaga mutu dan konsistensi kualitas. Memiliki karakter rasa kuat, aroma khas, serta ampas yang halus, Kopi Jollong mencerminkan komitmen terhadap kualitas, keaslian, dan keberlanjutan produk perkebunan nasional.
            </div>

            <div class="muted" style="margin-top:12px; line-height:1.75;">
              Kemasan: Pouch foil berziplock yang kedap udara untuk menjaga kesegaran, aroma, dan kualitas kopi.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="produksi" class="section" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Informasi Produksi Kopi</h2></div>
      </div>

      <div class="grid">
        <div class="card">
          <div class="cardBody">
            <div class="pill">Ringkasan Publik</div>
            <h3 style="margin:0 0 8px;">Pengelolaan Kopi Robusta Kebun Jollong</h3>

            <div class="muted" style="line-height:1.75;">
              Kebun Jollong berfokus pada komoditas <strong>Kopi Robusta</strong> yang dikelola sesuai karakteristik agroklimat setempat untuk menjaga mutu, konsistensi, dan keberlanjutan produksi.
            </div>

            <div class="list" style="margin-top:14px;">
              <div class="listItem">
                <span class="dot"></span>
                <div>
                  <strong>Kesesuaian Lahan</strong><br/>
                  <span class="muted">Robusta cocok pada ketinggian 650–900 mdpl dengan suhu dan lingkungan yang mendukung pertumbuhan optimal di wilayah Jollong.</span>
                </div>
              </div>

              <div class="listItem">
                <span class="dot"></span>
                <div>
                  <strong>Klon Unggulan</strong><br/>
                  <span class="muted">Beberapa klon yang dibudidayakan meliputi BP308, BP234, BP358, BP409, SA237, dan klon lainnya.</span>
                </div>
              </div>

              <div class="listItem">
                <span class="dot"></span>
                <div>
                  <strong>Produksi Rata-rata</strong><br/>
                  <span class="muted">Produksi rata-rata sekitar <strong>66.131 ton per tahun.</strong> </span>
                </div>
              </div>

              <div class="listItem">
                <span class="dot"></span>
                <div>
                  <strong>Pengolahan & Mutu</strong><br/>
                  <span class="muted">Pengolahan melalui <em>dry process</em> dan <em>wet process</em>. Mutu dikelompokkan berdasarkan grade serta ukuran biji (besar/sedang/kecil) untuk menjaga konsistensi.</span>
                </div>
              </div>
            </div>

            <div class="muted" style="margin-top:12px; font-size:13px; line-height:1.6;">
              Keterangan: Detail operasional dikelola dalam sistem internal sesuai kewenangan.
            </div>
          </div>
        </div>

        <div class="card">
          <div class="cardBody">
            <div class="pill">Edukasi</div>
            <h3 style="margin:0 0 8px;">Siklus Produksi Kopi</h3>
            <div class="muted" style="line-height:1.75;">
              Ilustrasi tahapan pengelolaan kopi dari kebun hingga produk siap didistribusikan.
            </div>

            <div class="flowWrap" aria-label="Siklus produksi kopi">
              <div class="flow">
                <div class="flowItem">
                  <div class="flowIcon">1</div>
                  <div class="flowText">
                    <strong>Panen</strong>
                    <div class="muted">Pemilihan buah matang sesuai standar mutu.</div>
                  </div>
                </div>

                <div class="flowItem">
                  <div class="flowIcon">2</div>
                  <div class="flowText">
                    <strong>Pascapanen</strong>
                    <div class="muted">Sortasi, pengeringan, dan penanganan awal.</div>
                  </div>
                </div>

                <div class="flowItem">
                  <div class="flowIcon">3</div>
                  <div class="flowText">
                    <strong>Pengolahan</strong>
                    <div class="muted">Proses sesuai prosedur untuk menjaga karakter rasa.</div>
                  </div>
                </div>

                <div class="flowItem">
                  <div class="flowIcon">4</div>
                  <div class="flowText">
                    <strong>Pengemasan</strong>
                    <div class="muted">Pouch foil berziplock untuk menjaga kesegaran & aroma.</div>
                  </div>
                </div>

                <div class="flowItem">
                  <div class="flowIcon">5</div>
                  <div class="flowText">
                    <strong>Distribusi</strong>
                    <div class="muted">Produk siap dipasarkan dan dinikmati konsumen.</div>
                  </div>
                </div>

                <div class="flowItem">
                  <div class="flowIcon">6</div>
                  <div class="flowText">
                    <strong>Pengendalian Mutu</strong>
                    <div class="muted">Pemeriksaan mutu untuk menjaga konsistensi produk.</div>
                  </div>
                </div>

                <div class="flowItem">
                  <div class="flowIcon">7</div>
                  <div class="flowText">
                    <strong>Pelayanan Pelanggan</strong>
                    <div class="muted">Dukungan informasi produk dan masukan konsumen.</div>
                  </div>
                </div>
              </div>
            </div>

            <div class="muted" style="margin-top:12px; font-size:13px; line-height:1.6;">
              Catatan: Tahapan bersifat informatif dan dapat menyesuaikan kebutuhan operasional.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="agrowisata" class="section" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Agrowisata</h2></div>
        <p>Informasi layanan agrowisata dan akses reservasi untuk pengunjung.</p>
      </div>

      <div class="card">
        <div class="cardBody">
          <div class="pill">Destinasi</div>
          <h3 style="margin:0 0 8px;">Agrowisata Kebun Jollong</h3>
          <div class="muted" style="line-height:1.75;">
            Agrowisata Kebun Jollong menghadirkan suasana alam yang sejuk dengan berbagai wahana rekreasi, seperti outbound, flying fox, rumah balon, dan kolam terapi ikan. Destinasi unggulan meliputi Bukit Naga, Air Terjun Grenjengan, serta area Bubaan Hills yang menyediakan camping ground, outbound, dan wisata edukasi berbasis alam.
          </div>

          <div class="list">
            <div class="listItem">
              <span class="dot"></span>
              <div><strong>Jam Operasional</strong><br/><span class="muted">Sen–Min: 07.00–17.00 WIB</span></div>
            </div>

            <div class="listItem">
              <span class="dot"></span>
              <div>
                <strong>Reservasi dan PriceList</strong><br/>
                <a href="https://linktr.ee/wisataagrojollong" target="_blank" rel="noopener" class="muted">linktr.ee/wisataagrojollong</a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <section id="galeri" class="section sectionAlt" data-section>
    <div class="container">
      <div class="sectionHeader">
        <div><h2>Galeri Kegiatan</h2></div>
        <p>Dokumentasi kegiatan kebun dan agrowisata.</p>
      </div>

      <div class="galleryGrid">
        <div class="gItem">
          <img src="img/Kegiatan Panen Kopi.png" alt="Kegiatan panen kopi">
          <div class="gCap">Kegiatan panen kopi</div>
        </div>
        <div class="gItem">
          <img src="img/Tradisi Wiwit Panen Raya.jpg" alt="Tradisi Wiwit Panen Raya">
          <div class="gCap">Tradisi Wiwit Panen Raya</div>
        </div>
        <div class="gItem">
          <img src="img/Pengolahan Kopi.png" alt="Pascapanen / pengolahan">
          <div class="gCap">Pascapanen / pengolahan</div>
        </div>
        <div class="gItem">
          <img src="img/Garden Valey.png" alt="Agrowisata Jollong">
          <div class="gCap">Agrowisata Jollong</div>
        </div>
        <div class="gItem">
          <img src="img/Bubaan Hills.png" alt="Bubaan Hills">
          <div class="gCap">Bubaan Hills</div>
        </div>
        <div class="gItem">
          <img src="img/Wisata Edukasi.png" alt="Wisata Edukasi">
          <div class="gCap">Wisata Edukasi</div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="container" id="kontak">
      © 2026 — Kebun Jollong (PTPN I Regional 3).
    </div>
  </footer>

  <script>
    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    const tabLinks = Array.from(document.querySelectorAll(".tabs .tab"));
    const sectionIdsForTabs = tabLinks.map(a => a.getAttribute("href")).filter(Boolean);

    function setActiveTab(hash){
      tabLinks.forEach(t => t.classList.remove("active"));
      const target = tabLinks.find(t => t.getAttribute("href") === hash);
      if(target) target.classList.add("active");
    }

    const hamburger = document.getElementById("hamburger");
    const drawer = document.getElementById("drawer");
    const drawerBackdrop = document.getElementById("drawerBackdrop");
    const drawerClose = document.getElementById("drawerClose");

    function openDrawer(){
      drawer.classList.add("open");
      drawerBackdrop.classList.add("open");
      drawerBackdrop.setAttribute("aria-hidden", "false");
      document.body.style.overflow = "hidden";
    }
    function closeDrawer(){
      drawer.classList.remove("open");
      drawerBackdrop.classList.remove("open");
      drawerBackdrop.setAttribute("aria-hidden", "true");
      document.body.style.overflow = "";
    }

    hamburger?.addEventListener("click", openDrawer);
    drawerBackdrop?.addEventListener("click", closeDrawer);
    drawerClose?.addEventListener("click", closeDrawer);

    document.querySelectorAll('a[href^="#"]').forEach(a => {
      a.addEventListener("click", (e) => {
        const href = a.getAttribute("href");
        if(!href || href === "#") return;

        const el = document.querySelector(href);
        if(!el) return;

        closeDrawer();

        e.preventDefault();
        if(a.classList.contains("tab")) setActiveTab(href);

        el.scrollIntoView({ behavior: prefersReducedMotion ? "auto" : "smooth", block: "start" });
        history.pushState(null, "", href);
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
      return sectionIdsForTabs[0] || "#profil";
    }

    let ticking = false;
    let lastId = null;
    window.addEventListener("scroll", () => {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(() => {
        const id = getCurrentSectionId();
        if (id && id !== lastId) {
          setActiveTab(id);
          lastId = id;
        }
        ticking = false;
      });
    });

    window.addEventListener("load", () => {
      if(location.hash && sectionIdsForTabs.includes(location.hash)){
        setActiveTab(location.hash);
        lastId = location.hash;
        return;
      }
      const id = getCurrentSectionId();
      setActiveTab(id);
      lastId = id;
    });
  </script>
</body>
</html>
