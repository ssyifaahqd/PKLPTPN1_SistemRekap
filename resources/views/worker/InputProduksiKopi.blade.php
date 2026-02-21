<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Produksi Kopi — Kebun Jollong</title>

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
    .brand{ display:flex; align-items:center; gap:12px; min-width:240px; }
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
      background:#fff;
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
      background:#fff;
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
      max-width: 820px;
    }
    .cardBody{ padding:16px 18px 18px; }

    .row{ display:flex; gap:12px; flex-wrap:wrap; align-items:flex-end; }
    .field{ display:flex; flex-direction:column; gap:6px; min-width:180px; flex:1; }
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
      display:flex; align-items:flex-start; justify-content:space-between;
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

    .tableWrap{ overflow:auto; }
    table{
      width:100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 980px;
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
      text-align:center;
      white-space:nowrap;
    }
    th:last-child, td:last-child{ border-right:0; }
    th{
      color:var(--green-900);
      font-size:12px;
      font-weight:950;
      letter-spacing:.12em;
      text-transform: uppercase;
      text-align:center !important;
    }

    td.num, th.num{ text-align:center !important; font-variant-numeric: tabular-nums; }

    tbody tr:hover td{ background: rgba(46,125,50,.04); }

    .actions{
      display:flex;
      gap:10px;
      justify-content:center;
      flex-wrap:wrap;
      align-items:center;
    }
    details summary{
      cursor:pointer;
      color:var(--green-900);
      font-weight:950;
      list-style:none;
      user-select:none;
      text-align:center;
    }
    details summary::-webkit-details-marker{ display:none; }
    details{
      border:1px solid var(--border);
      border-radius:14px;
      padding:10px 12px;
      background:#fff;
      text-align:center;
    }
    .editBox{
      margin-top:10px;
      padding-top:10px;
      border-top:1px dashed rgba(229,231,235,.9);
      text-align:left;
    }

    @media (max-width: 980px){
      .brand img{ width:110px; height:52px; }
      .formGrid{ grid-template-columns: 1fr; }
      .cols2{ grid-template-columns: 1fr; }
      .field{ min-width: 100%; flex: unset; }
      .btn{ width:auto; }
    }
  </style>
</head>

<body>
  <div class="topbar">
    <div class="nav">
      <a class="brand" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
        <div class="title">
          <strong>Modul Produksi Kopi</strong>
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
          <h1>Produksi Kopi</h1>
          <p>Tambah, edit, dan hapus data produksi. Filter per tahun laporan untuk melihat rekap, produktivitas, dan detail per tahun tanam.</p>
        </div>
      </div>
    </div>

    @if(session('success'))
      <div class="alert">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="cardHead">
        <div>
          <strong>Input Data Produksi</strong>
          <div class="mini">Nilai <b>kg/ha</b> dihitung otomatis dari <b>produksi_kering_kg / luas_ha</b>. Disarankan pakai titik untuk desimal (contoh: 17.01).</div>
        </div>
        <div class="chip">Satuan: ha & kg</div>
      </div>

      <div class="cardBody">
        <form method="POST" action="{{ route('worker.produksi_kopi.store') }}">
          @csrf

          <div class="formGrid">
            <div class="panel">
              <div class="panelHead">
                <strong>Periode Pelaporan</strong>
                <span class="chip">Wajib</span>
              </div>

              <div class="cols2">
                <div class="field">
                  <label>Tahun Laporan</label>
                  <input
                    name="tahun_laporan"
                    value="{{ $tahun ?? '' }}"
                    placeholder="Contoh: 2026"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    required
                  />
                  <div class="help">Masukkan tahun laporan produksi kopi.</div>
                </div>

                <div class="field">
                  <label>Tahun Tanam</label>
                  <input
                    name="tahun_tanam"
                    placeholder="Contoh: 2012"
                    inputmode="numeric"
                    pattern="[0-9]*"
                    required
                  />
                  <div class="help">Tahun tanam kebun untuk baris data ini.</div>
                </div>
              </div>

              <div class="sectionLabel">Catatan</div>
              <div class="help" style="color:var(--muted); font-size:13px;">
                Jika data sudah ada dan perlu koreksi, gunakan <b>Edit</b> pada tabel di bawah.
              </div>
            </div>

            <div class="panel">
              <div class="panelHead">
                <strong>Nilai Produksi</strong>
                <span class="chip">Angka</span>
              </div>

              <div class="sectionLabel">Luas & Produksi</div>
              <div class="cols2">
                <div class="field">
                  <label>Luas (ha)</label>
                  <input name="luas_ha" placeholder="Contoh: 17.01" inputmode="decimal" required />
                  <div class="help">Masukkan luas tanah (ha).</div>
                </div>

                <div class="field">
                  <label>Produksi Kering (kg)</label>
                  <input name="produksi_kering_kg" placeholder="Contoh: 7899" inputmode="decimal" pattern="[0-9]*" required />
                  <div class="help">Masukkan total produksi kering (kg).</div>
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
          <div class="mini">Filter tahun mengikuti data yang ada di database. Pilih “Semua Tahun” untuk menampilkan seluruh data.</div>
        </div>
      </div>
      <div class="cardBody">
        <form method="GET" action="{{ route('worker.produksi_kopi.index') }}" class="row">
          <div class="field" style="max-width:340px;">
            <label for="tahun">Tahun Laporan</label>
            <select id="tahun" name="tahun">
              <option value="">Semua Tahun</option>
              @foreach($tahunList as $y)
                <option value="{{ $y }}" @selected((string)$tahun === (string)$y)>{{ $y }}</option>
              @endforeach
            </select>
          </div>

          {{-- tombol: Terapkan + Export Excel (sebaris) --}}
          <div class="field" style="max-width:420px; flex:unset;">
            <label>&nbsp;</label>
            <div style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
              <button class="btn primary" type="submit">Terapkan</button>

              <a class="btn outline"
                 href="{{ route('worker.export.produksi_kopi', request()->only(['tahun'])) }}">
                Export PDF
              </a>
              <a class="btn outline"
                 href="{{ route('worker.excel.produksi_kopi', request()->only(['tahun'])) }}">
                Export Excel
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

    @forelse($grouped as $tahunLaporan => $rows)
      @php
        $sumHa = (float) $rows->sum('luas_ha');
        $sumKg = (float) $rows->sum('produksi_kering_kg');
        $kgha  = $sumHa > 0 ? ($sumKg / $sumHa) : 0;
      @endphp

      <div class="card">
        <div class="yearHead">
          <div>
            <strong>Tahun Laporan: {{ $tahunLaporan }}</strong>
            <div class="mini">Ringkasan total untuk tahun laporan yang tampil.</div>
          </div>

          <div class="kpis">
            <div class="kpi">
              <span>Total Luas</span>
              <strong>{{ number_format($sumHa, 2, ',', '.') }} ha</strong>
            </div>
            <div class="kpi">
              <span>Total Produksi</span>
              <strong>{{ number_format($sumKg, 0, ',', '.') }} kg</strong>
            </div>
            <div class="kpi">
              <span>Rata-rata</span>
              <strong>{{ number_format($kgha, 2, ',', '.') }} kg/ha</strong>
            </div>
          </div>
        </div>

        <div class="tableWrap">
          <table>
            <thead>
              <tr>
                <th>Tahun Tanam</th>
                <th class="num">Luas (ha)</th>
                <th class="num">Produksi Kering (kg)</th>
                <th class="num">kg/ha</th>
                <th class="num">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($rows as $r)
                <tr>
                  <td>{{ $r->tahun_tanam }}</td>
                  <td class="num">{{ number_format((float)$r->luas_ha, 2, ',', '.') }}</td>
                  <td class="num">{{ number_format((float)$r->produksi_kering_kg, 0, ',', '.') }}</td>
                  <td class="num">{{ $r->kg_per_ha === null ? '-' : number_format((float)$r->kg_per_ha, 2, ',', '.') }}</td>

                  <td class="num">
                    <div class="actions">
                      <details>
                        <summary>Edit</summary>
                        <div class="editBox">
                          <form method="POST" action="{{ route('worker.produksi_kopi.update', $r->id) }}" class="row">
                            @csrf
                            @method('PUT')

                            <div class="field" style="max-width:220px;">
                              <label>Tahun Laporan</label>
                              <input name="tahun_laporan" value="{{ $r->tahun_laporan }}" inputmode="numeric" pattern="[0-9]*" required />
                            </div>
                            <div class="field" style="max-width:220px;">
                              <label>Tahun Tanam</label>
                              <input name="tahun_tanam" value="{{ $r->tahun_tanam }}" inputmode="numeric" pattern="[0-9]*" required />
                            </div>
                            <div class="field" style="max-width:240px;">
                              <label>Luas (ha)</label>
                              <input name="luas_ha" value="{{ $r->luas_ha }}" inputmode="decimal" required />
                            </div>
                            <div class="field" style="max-width:280px;">
                              <label>Produksi Kering (kg)</label>
                              <input name="produksi_kering_kg" value="{{ rtrim(rtrim(number_format((float)$r->produksi_kering_kg, 2, '.', ''), '0'), '.') }}" inputmode="decimal" step="0.01" required/>

                            </div>

                            <div class="field" style="max-width:180px; flex:unset;">
                              <label>&nbsp;</label>
                              <button class="btn primary" type="submit">Update</button>
                            </div>
                          </form>
                        </div>
                      </details>

                      <form method="POST"
                            action="{{ route('worker.produksi_kopi.destroy', $r->id) }}"
                            onsubmit="return confirm('Yakin hapus data ini?')">
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
          Belum ada data produksi kopi.
        </div>
      </div>
    @endforelse

  </div>
</body>
</html>
