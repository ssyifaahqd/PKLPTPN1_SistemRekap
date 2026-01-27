<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Laba Rugi — Kebun Jollong</title>

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

      --shadow: 0 10px 30px rgba(0,0,0,.08);
      --radius: 18px;

      --danger:#dc2626;
      --danger-soft: rgba(220,38,38,.10);
      --warn:#f59e0b;

      --chip-bg:#eef6f0;
      --chip-br:rgba(27,94,32,.18);
    }

    *{ box-sizing:border-box; }
    html,body{
      margin:0; padding:0;
      font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial;
      color:var(--text);
      background:var(--bg);
      min-height:100vh;
    }
    a{ color:inherit; text-decoration:none; }
    .container{ width:min(1180px, 92%); margin:0 auto; padding:18px 0 64px; }

    .topbar{
      position:sticky; top:0; z-index:50;
      background:rgba(255,255,255,.92);
      backdrop-filter: blur(10px);
      border-bottom:1px solid var(--border);
    }
    .nav{
      width:min(1180px, 92%);
      margin:0 auto;
      display:flex; align-items:center; justify-content:space-between;
      gap:14px;
      padding:12px 0;
    }
    .brand{ display:flex; align-items:center; gap:12px; min-width: 240px; }
    .brand img{ width:120px; height:56px; object-fit:contain; display:block; }
    .brand .title{ line-height:1.15; display:flex; flex-direction:column; }
    .brand .title strong{ font-size:18px; font-weight:900; letter-spacing:.2px; }
    .brand .title span{ font-size:13px; color:var(--muted); }

    .navRight{ display:flex; align-items:center; gap:10px; }

    .btn{
      padding:10px 14px; border-radius:999px; font-size:14px;
      border:1px solid var(--border); background:#fff;
      cursor:pointer; transition:.15s ease; white-space:nowrap;
      display:inline-flex; align-items:center; justify-content:center; gap:8px;
    }
    .btn.primary{
      border-color: transparent;
      background: linear-gradient(135deg, var(--green-800), var(--green-500));
      color:#fff;
    }
    .btn.ghost{
      background: var(--chip-bg);
      border-color: var(--chip-br);
      color: var(--green-800);
      font-weight:700;
    }

    /* ✅ tambahan tombol outline biar sama kayak Produksi Kopi */
    .btn.outline{
      background:#fff;
      border-color: rgba(46,125,50,.38);
      color: var(--green-800);
      font-weight:850;
    }
    .btn.outline:hover{
      background: rgba(46,125,50,.08);
      border-color: rgba(46,125,50,.55);
    }

    .btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(0,0,0,.10); }
    .btn.danger{
      border-color: rgba(220,38,38,.30);
      color: var(--danger);
      background: #fff;
    }

    .hero{
      margin-top:16px;
      border-radius: 22px;
      overflow:hidden;
      box-shadow: var(--shadow);
      border:1px solid var(--border);
      position:relative;
      background:#fff;
    }
    .heroMedia{
      height: clamp(160px, 22vw, 230px);
      background:
        linear-gradient(180deg, rgba(0,0,0,.55) 0%, rgba(0,0,0,.18) 70%, rgba(0,0,0,.10) 100%),
        url("{{ asset('img/Petik Kopi.jpg') }}") center/cover no-repeat;
    }
    .heroInner{
      position:absolute; inset:0;
      display:flex; align-items:flex-end; justify-content:space-between;
      gap:14px;
      padding:18px 18px 16px;
      color:#fff;
    }
    .heroTitle h1{
      margin:0;
      font-size: clamp(22px, 2.6vw, 34px);
      font-weight:900;
      letter-spacing:.2px;
      text-shadow: 0 10px 26px rgba(0,0,0,.35);
    }
    .heroTitle p{
      margin:6px 0 0;
      font-size:14px;
      line-height:1.65;
      opacity:.95;
      max-width: 860px;
      text-shadow: 0 8px 18px rgba(0,0,0,.30);
    }

    .card{
      border:1px solid var(--border);
      border-radius: 22px;
      box-shadow: var(--shadow);
      background: #ffffff;
      overflow:hidden;
      margin-top:16px;
    }
    .cardHead{
      padding:16px 18px 12px;
      display:flex;
      align-items:flex-start;
      justify-content:space-between;
      gap:12px;
      border-bottom:1px solid rgba(229,231,235,.9);
      background: linear-gradient(180deg, rgba(233,246,238,.55), rgba(255,255,255,0));
    }
    .cardHead strong{
      display:block;
      font-size:16px;
      font-weight:950;
      color:var(--green-900);
      letter-spacing:.2px;
    }
    .cardHead .mini{
      margin-top:6px;
      color:var(--muted);
      font-size:13px;
      line-height:1.6;
      max-width: 780px;
    }
    .cardBody{ padding:16px 18px 18px; }

    .row{ display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; }
    .field{ display:flex; flex-direction:column; gap:6px; min-width: 180px; flex: 1; }
    label{ font-size:13px; color:var(--muted); font-weight:800; }

    input, select{
      width:100%;
      padding:11px 12px;
      border:1px solid var(--border);
      border-radius:14px;
      font-size:14px;
      outline:none;
      transition:.15s ease;
      background:#fff;
    }
    input::placeholder{ color:#9ca3af; }
    input:focus, select:focus{
      border-color: rgba(46,125,50,.45);
      box-shadow: 0 0 0 4px rgba(46,125,50,.12);
    }

    .help{
      margin-top:4px;
      font-size:12px;
      color:#9ca3af;
      line-height:1.45;
    }

    .alert{
      padding:12px 14px;
      border-radius:16px;
      border:1px solid rgba(22,163,74,.18);
      background: rgba(22,163,74,.06);
      margin-top:14px;
    }

    .formGrid{
      display:grid;
      grid-template-columns: 1.15fr 1fr;
      gap:14px;
      align-items:start;
    }
    .panel{
      border:1px solid rgba(229,231,235,.9);
      border-radius: 18px;
      padding:14px;
      background:#fff;
    }
    .panelHead{
      display:flex; align-items:center; justify-content:space-between; gap:10px;
      margin-bottom:12px;
    }
    .panelHead strong{
      font-size:14px;
      font-weight:950;
      color:var(--green-900);
      letter-spacing:.15px;
    }
    .chip{
      display:inline-flex; align-items:center; gap:8px;
      padding:7px 10px;
      border-radius:999px;
      border:1px solid var(--chip-br);
      background: var(--chip-bg);
      color: var(--green-900);
      font-size:12px;
      font-weight:800;
      white-space:nowrap;
    }

    .cols2{
      display:grid;
      grid-template-columns: 1fr 1fr;
      gap:12px;
    }

    .sectionLabel{
      display:flex; align-items:center; gap:10px;
      margin:10px 0 8px;
      color:var(--muted);
      font-size:12px;
      font-weight:900;
      text-transform: uppercase;
      letter-spacing:.12em;
    }
    .sectionLabel::after{
      content:"";
      height:1px;
      background: rgba(229,231,235,.95);
      flex:1;
    }

    .stickyActions{
      display:flex;
      justify-content:flex-end;
      gap:10px;
      padding-top:12px;
      margin-top:10px;
      border-top:1px dashed rgba(229,231,235,.95);
    }

    .yearHead{
      display:flex; align-items:center; justify-content:space-between;
      gap:12px;
      padding:14px 16px;
      background: var(--green-100);
      border-bottom:1px solid rgba(229,231,235,.9);
    }
    .yearHead strong{
      font-size:16px;
      color:var(--green-900);
      font-weight:950;
    }
    .yearHead .mini{
      margin-top:6px;
      font-size:13px;
      color:var(--muted);
      line-height:1.55;
    }
    .kpis{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      justify-content:flex-end;
      align-items:center;
    }
    .kpi{
      padding:10px 12px;
      border-radius:16px;
      border:1px solid rgba(229,231,235,.95);
      background:#fff;
      min-width: 170px;
    }
    .kpi span{ display:block; font-size:12px; color:var(--muted); font-weight:800; }
    .kpi strong{ display:block; margin-top:4px; font-size:14px; font-weight:950; color:var(--green-900); }
    .kpi.negative strong{ color: var(--danger); }

    .tableWrap{ overflow:auto; }
    table{
      width:100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 1080px;
      background:#fff;
    }
    thead th{
      position: sticky;
      top: 0;
      background: var(--green-100);
      z-index: 1;
      text-align:center !important;
      vertical-align: middle;
    }
    th, td{
      padding:11px 12px;
      font-size:14px;
      border-bottom:1px solid var(--border);
      border-right:1px solid var(--border);
      vertical-align: middle;
      text-align:left;
      white-space:nowrap;
    }
    th:last-child, td:last-child{ border-right:0; }
    th{
      color:var(--green-900);
      font-size:12px;
      font-weight:950;
      letter-spacing:.12em;
      text-transform: uppercase;
    }

    th.num{ text-align:center !important; }
    td.num{ text-align:right; font-variant-numeric: tabular-nums; }

    tbody tr:hover td{ background: rgba(46,125,50,.04); }

    .actions{ display:flex; gap:10px; justify-content:flex-start; flex-wrap:wrap; align-items:center; }
    details summary{
      cursor:pointer;
      color:var(--green-900);
      font-weight:950;
      list-style:none;
      user-select:none;
    }
    details summary::-webkit-details-marker{ display:none; }
    details{
      border:1px solid var(--border);
      border-radius:14px;
      padding:10px 12px;
      background:#fff;
    }
    .editBox{
      margin-top:10px;
      padding-top:10px;
      border-top:1px dashed rgba(229,231,235,.9);
    }

    @media (max-width: 980px){
      .brand img{ width:110px; height:52px; }
      .formGrid{ grid-template-columns: 1fr; }
      .cols2{ grid-template-columns: 1fr; }
      .field{ min-width: 100%; flex: unset; }
    }
  </style>
</head>

<body>
  @php
    $bulanNama = [
      1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
      7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'
    ];
    $fmt = fn($n) => number_format((float)$n, 0, ',', '.');

    $filterTahun = request('tahun');
    $filterBulan = request('bulan');
  @endphp

  <div class="topbar">
    <div class="nav">
      <a class="brand" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
        <div class="title">
          <strong>Modul Laba Rugi</strong>
          <span>Kebun Jollong — PTPN I Regional 3</span>
        </div>
      </a>

      <div class="navRight">
        <a class="btn ghost" href="{{ route('dashboard') }}">← Kembali ke Dashboard</a>
      </div>
    </div>
  </div>

  <div class="container">

    <div class="hero">
      <div class="heroMedia"></div>
      <div class="heroInner">
        <div class="heroTitle">
          <h1>Laba Rugi Bulanan</h1>
          <p>Input dan evaluasi pendapatan & biaya per bulan untuk 3 kategori (Wahana, Resto, Penginapan). Data ditampilkan rapi seperti format pivot Excel.</p>
        </div>
      </div>
    </div>

    @if(session('success'))
      <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="cardHead">
        <div>
          <strong>Input Data Laba Rugi</strong>
          <div class="mini">Sistem menyimpan <b>3 kategori keuangan</b> per bulan. Disarankan isi angka tanpa titik/koma.</div>
        </div>
        <div class="chip">Format: Rupiah (IDR)</div>
      </div>

      <div class="cardBody">
        <form method="POST" action="{{ route('worker.laba_rugi.store') }}">
          @csrf

          <div class="formGrid">
            <div class="panel">
              <div class="panelHead">
                <strong>Periode Pelaporan</strong>
                <span class="chip">Wajib diisi</span>
              </div>

              <div class="cols2">
                <div class="field">
                  <label>Tahun</label>
                  <input
                    name="tahun"
                    value="{{ request('tahun') ?? '' }}"
                    placeholder="Contoh: 2025"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    required
                  />
                  <div class="help">Masukkan tahun laporan data laba rugi.</div>
                </div>

                <div class="field">
                  <label>Bulan</label>
                  <select name="bulan" required>
                    <option value="">Pilih Bulan</option>
                    @foreach($bulanList as $k => $v)
                      <option value="{{ $k }}">{{ $v }}</option>
                    @endforeach
                  </select>
                  <div class="help">Pilih bulan laporan yang diinput.</div>
                </div>
              </div>

              <div class="sectionLabel">Catatan</div>
              <div class="help" style="color:var(--muted); font-size:13px;">
                Pastikan data bulan yang sama tidak double. Jika perlu koreksi, gunakan tombol <b>Edit</b> pada tabel di bawah.
              </div>
            </div>

            <div class="panel">
              <div class="panelHead">
                <strong>Nilai Pendapatan & Biaya</strong>
                <span class="chip">3 kategori</span>
              </div>

              <div class="sectionLabel">Pendapatan</div>
              <div class="cols2">
                <div class="field">
                  <label>Pendapatan Wahana & Pintu Masuk</label>
                  <input name="pend_wahana" placeholder="Contoh: 69562000" inputmode="numeric" pattern="[0-9]*" required />
                </div>
                <div class="field">
                  <label>Pendapatan Resto</label>
                  <input name="pend_resto" placeholder="Contoh: 78176000" inputmode="numeric" pattern="[0-9]*" required />
                </div>
                <div class="field">
                  <label>Pendapatan Penginapan</label>
                  <input name="pend_inap" placeholder="Contoh: 9250000" inputmode="numeric" pattern="[0-9]*" required />
                </div>
              </div>

              <div class="sectionLabel">Biaya</div>
              <div class="cols2">
                <div class="field">
                  <label>Biaya Wahana & Pintu Masuk</label>
                  <input name="biaya_wahana" placeholder="Contoh: 51077095" inputmode="numeric" pattern="[0-9]*" required />
                </div>
                <div class="field">
                  <label>Biaya Resto</label>
                  <input name="biaya_resto" placeholder="Contoh: 42482000" inputmode="numeric" pattern="[0-9]*" required />
                </div>
                <div class="field">
                  <label>Biaya Penginapan</label>
                  <input name="biaya_inap" placeholder="Contoh: 9177000" inputmode="numeric" pattern="[0-9]*" required />
                </div>
              </div>

              <div class="stickyActions">
                <button class="btn primary" type="submit">Simpan Data</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="cardHead">
        <div>
          <strong>Filter Data</strong>
          <div class="mini">Gunakan filter untuk fokus per tahun/bulan. Pilih “Semua” untuk menampilkan seluruh data.</div>
        </div>
      </div>
      <div class="cardBody">
        <form method="GET" action="{{ route('worker.laba_rugi.index') }}" class="row">
          <div class="field" style="max-width:320px;">
            <label>Tahun</label>
            <select name="tahun">
              <option value="">Semua Tahun</option>
              @foreach($tahunList as $y)
                <option value="{{ $y }}" @selected((string)$filterTahun === (string)$y)>{{ $y }}</option>
              @endforeach
            </select>
          </div>

          <div class="field" style="max-width:320px;">
            <label>Bulan</label>
            <select name="bulan">
              <option value="">Semua Bulan</option>
              @foreach($bulanList as $k => $v)
                <option value="{{ $k }}" @selected((string)$filterBulan === (string)$k)>{{ $v }}</option>
              @endforeach
            </select>
          </div>

          <!-- ✅ tombol: Terapkan + Export PDF (sebaris, sama kayak Produksi Kopi) -->
          <div class="field" style="max-width:420px; flex:unset;">
            <label>&nbsp;</label>
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
              <button class="btn primary" type="submit">Terapkan</button>

              <a class="btn outline"
                 href="{{ route('worker.export.laba_rugi', request()->only(['tahun','bulan'])) }}">
                Export PDF
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

    @forelse($grouped as $tahunKey => $rows)
      @php
        $sumPend = 0; $sumBiaya = 0;
        foreach ($rows as $r) {
          $pW = $r['pend'][1] ?? 0; $pR = $r['pend'][2] ?? 0; $pP = $r['pend'][3] ?? 0;
          $bW = $r['biaya'][1] ?? 0; $bR = $r['biaya'][2] ?? 0; $bP = $r['biaya'][3] ?? 0;
          $sumPend += ($pW + $pR + $pP);
          $sumBiaya += ($bW + $bR + $bP);
        }
        $sumLR = $sumPend - $sumBiaya;

        $judulCard = "Tahun {$tahunKey}";
        if (!empty($filterBulan) && isset($bulanNama[(int)$filterBulan])) {
          $judulCard .= " — Bulan: ".$bulanNama[(int)$filterBulan];
        }
      @endphp

      <div class="card">
        <div class="yearHead">
          <div>
            <strong>{{ $judulCard }}</strong>
            <div class="mini">Ringkasan total untuk periode yang tampil.</div>
          </div>

          <div class="kpis">
            <div class="kpi">
              <span>Total Pendapatan</span>
              <strong>Rp {{ $fmt($sumPend) }}</strong>
            </div>
            <div class="kpi">
              <span>Total Biaya</span>
              <strong>Rp {{ $fmt($sumBiaya) }}</strong>
            </div>
            <div class="kpi {{ $sumLR < 0 ? 'negative' : '' }}">
              <span>Laba/Rugi</span>
              <strong>Rp {{ $fmt($sumLR) }}</strong>
            </div>
          </div>
        </div>

        <div class="tableWrap">
          <table>
            <thead>
              <tr>
                <th rowspan="2">Bulan</th>
                <th colspan="4">Pendapatan</th>
                <th colspan="4">Biaya</th>
                <th colspan="4">Laba Rugi</th>
                <th rowspan="2" class="num">Aksi</th>
              </tr>
              <tr>
                <th class="num">Wahana & Pintu Masuk</th><th class="num">Resto</th><th class="num">Penginapan</th><th class="num">Jumlah</th>
                <th class="num">Wahana & Pintu Masuk</th><th class="num">Resto</th><th class="num">Penginapan</th><th class="num">Jumlah</th>
                <th class="num">Wahana & Pintu Masuk</th><th class="num">Resto</th><th class="num">Penginapan</th><th class="num">Jumlah</th>
              </tr>
            </thead>

            <tbody>
              @foreach($rows as $r)
                @php
                  $pW = (float)($r['pend'][1] ?? 0); $pR = (float)($r['pend'][2] ?? 0); $pP = (float)($r['pend'][3] ?? 0);
                  $bW = (float)($r['biaya'][1] ?? 0); $bR = (float)($r['biaya'][2] ?? 0); $bP = (float)($r['biaya'][3] ?? 0);

                  $pJ = $pW+$pR+$pP;
                  $bJ = $bW+$bR+$bP;

                  $lW = $pW-$bW; $lR=$pR-$bR; $lP=$pP-$bP;
                  $lJ = $pJ-$bJ;
                @endphp

                <tr>
                  <td>{{ $bulanNama[$r['bulan']] ?? $r['bulan'] }}</td>

                  <td class="num">Rp {{ $fmt($pW) }}</td>
                  <td class="num">Rp {{ $fmt($pR) }}</td>
                  <td class="num">Rp {{ $fmt($pP) }}</td>
                  <td class="num">Rp {{ $fmt($pJ) }}</td>

                  <td class="num">Rp {{ $fmt($bW) }}</td>
                  <td class="num">Rp {{ $fmt($bR) }}</td>
                  <td class="num">Rp {{ $fmt($bP) }}</td>
                  <td class="num">Rp {{ $fmt($bJ) }}</td>

                  <td class="num">Rp {{ $fmt($lW) }}</td>
                  <td class="num">Rp {{ $fmt($lR) }}</td>
                  <td class="num">Rp {{ $fmt($lP) }}</td>
                  <td class="num">Rp {{ $fmt($lJ) }}</td>

                  <td class="num">
                    <div class="actions">
                      <details>
                        <summary>Edit</summary>
                        <div class="editBox">
                          <form method="POST" action="{{ route('worker.laba_rugi.update', ['tahun'=>$r['tahun'], 'bulan'=>$r['bulan']]) }}" class="row">
                            @csrf
                            @method('PUT')

                            <div class="field" style="max-width:240px;">
                              <label>Pendapatan Wahana & Pintu Masuk</label>
                              <input name="pend_wahana" value="{{ $pW }}" inputmode="numeric" pattern="[0-9]*" required />
                            </div>
                            <div class="field" style="max-width:240px;">
                              <label>Pendapatan Resto</label>
                              <input name="pend_resto" value="{{ $pR }}" inputmode="numeric" pattern="[0-9]*" required />
                            </div>
                            <div class="field" style="max-width:240px;">
                              <label>Pendapatan Penginapan</label>
                              <input name="pend_inap" value="{{ $pP }}" inputmode="numeric" pattern="[0-9]*" required />
                            </div>

                            <div class="field" style="max-width:240px;">
                              <label>Biaya Wahana</label>
                              <input name="biaya_wahana" value="{{ $bW }}" inputmode="numeric" pattern="[0-9]*" required />
                            </div>
                            <div class="field" style="max-width:240px;">
                              <label>Biaya Resto</label>
                              <input name="biaya_resto" value="{{ $bR }}" inputmode="numeric" pattern="[0-9]*" required />
                            </div>
                            <div class="field" style="max-width:240px;">
                              <label>Biaya Penginapan</label>
                              <input name="biaya_inap" value="{{ $bP }}" inputmode="numeric" pattern="[0-9]*" required />
                            </div>

                            <div class="field" style="max-width:180px; flex:unset;">
                              <label>&nbsp;</label>
                              <button class="btn primary" type="submit">Update</button>
                            </div>
                          </form>
                        </div>
                      </details>

                      <form method="POST"
                            action="{{ route('worker.laba_rugi.destroy', ['tahun'=>$r['tahun'], 'bulan'=>$r['bulan']]) }}"
                            onsubmit="return confirm('Yakin hapus data bulan ini? (akan menghapus 3 kategori)')">
                        @csrf
                        @method('DELETE')
                        <button class="btn danger" type="submit">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    @empty
      <div class="card">
        <div class="cardBody" style="color:var(--muted); text-align:center;">
          Belum ada data laba rugi.
        </div>
      </div>
    @endforelse

  </div>
</body>
</html>
