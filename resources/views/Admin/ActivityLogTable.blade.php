<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aktivitas Karyawan — Kebun Jollong</title>

  <style>
    :root{
      --green-900:#123a16;
      --green-800:#174a1a;
      --green-700:#1b5e20;
      --green-600:#2e7d32;
      --green-500:#43a047;
      --green-100:#e9f6ee;

      --navy-700:#1e3a8a;
      --navy-100:#e8eefc;

      --text:#111827;
      --muted:#6b7280;
      --border:#e5e7eb;
      --bg:#f7faf8;

      --shadow: 0 10px 30px rgba(0,0,0,.08);

      --chip-bg:#eef6f0;
      --chip-br:rgba(27,94,32,.18);

      --danger:#dc2626;
      --danger-soft: rgba(220,38,38,.10);
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
    .navRight{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; justify-content:flex-end; }

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

    .btn{
      padding:10px 14px; border-radius:999px; font-size:14px;
      border:1px solid var(--border); background:#fff;
      cursor:pointer; transition:.15s ease; white-space:nowrap;
      display:inline-flex; align-items:center; justify-content:center; gap:8px;
    }
    .btn.ghost{
      background: var(--chip-bg);
      border-color: var(--chip-br);
      color: var(--green-800);
      font-weight:800;
    }
    .btn.outline{
      background:#fff;
      border-color: rgba(46,125,50,.38);
      color: var(--green-800);
      font-weight:850;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(0,0,0,.10); }

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
      height: clamp(150px, 20vw, 210px);
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
      font-size: clamp(22px, 2.4vw, 32px);
      font-weight:950;
      letter-spacing:.2px;
      text-shadow: 0 10px 26px rgba(0,0,0,.35);
    }
    .heroTitle p{
      margin:6px 0 0;
      font-size:14px;
      line-height:1.65;
      opacity:.95;
      max-width: 900px;
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
      max-width: 920px;
    }
    .cardBody{ padding:16px 18px 18px; }

    .filters{
      display:flex;
      gap:10px;
      flex-wrap:wrap;
      align-items:end;
      justify-content:space-between;
      margin-bottom:12px;
    }
    .filterLeft{
      display:flex; gap:10px; flex-wrap:wrap; align-items:end;
    }
    .field{ display:flex; flex-direction:column; gap:6px; min-width:180px; }
    label{ font-size:13px; color:var(--muted); font-weight:850; }
    input, select{
      padding:11px 12px;
      border:1px solid var(--border);
      border-radius:14px;
      font-size:14px;
      outline:none;
      transition:.15s ease;
      background:#fff;
      min-width: 220px;
    }
    input:focus, select:focus{
      border-color: rgba(46,125,50,.45);
      box-shadow: 0 0 0 4px rgba(46,125,50,.12);
    }

    .tableWrap{
      overflow:auto;
      border:1px solid var(--border);
      border-radius:18px;
      background:#fff;
    }
    table{
      width:100%;
      border-collapse: separate;
      border-spacing: 0;
      min-width: 1100px;
      background:#fff;
    }
    thead th{
      position: sticky;
      top: 0;
      background: var(--green-100);
      z-index: 2;
      text-align:left;
      vertical-align: middle;
      border-top:0;
    }
    th, td{
      padding:11px 12px;
      font-size:14px;
      border-bottom:1px solid var(--border);
      border-right:1px solid var(--border);
      vertical-align: top;
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
    thead th:first-child{ border-top-left-radius:16px; }
    thead th:last-child{ border-top-right-radius:16px; }
    tbody tr:hover td{ background: rgba(46,125,50,.04); }
    tbody tr:last-child td{ border-bottom:0; }

    .badge{
      display:inline-flex; align-items:center; justify-content:center;
      padding:6px 10px; border-radius:999px;
      font-size:12px; font-weight:900;
      border:1px solid rgba(27,94,32,.18);
      background: var(--chip-bg);
      color: var(--green-900);
      white-space:nowrap;
    }
    .badge.navy{
      border-color: rgba(30,58,138,.18);
      background: rgba(232,238,252,.85);
      color: #1e3a8a;
    }
    .badge.danger{
      border-color: rgba(220,38,38,.22);
      background: rgba(220,38,38,.08);
      color: var(--danger);
    }
    .muted{ color:var(--muted); }
    .wrap{ white-space:normal; line-height:1.55; }

    .pagination{
      margin-top:14px;
      display:flex;
      justify-content:space-between;
      align-items:center;
      gap:12px;
      flex-wrap:wrap;
    }
    .pagerInfo{ color:var(--muted); font-size:13px; }

    .pagination nav[aria-label="Pagination Navigation"] svg{
      width:18px;
      height:18px;
    }
    .pagination nav[aria-label="Pagination Navigation"] > div:nth-child(1){
      display:none;
    }
    .pagination nav[aria-label="Pagination Navigation"] > div:nth-child(2){
      display:flex;
      align-items:center;
      justify-content:flex-end;
      gap:10px;
      flex-wrap:wrap;
      width:100%;
    }
    .pagination nav[aria-label="Pagination Navigation"] > div:nth-child(2) > div:first-child{
      display:none;
    }
    .pagination nav[aria-label="Pagination Navigation"] a,
    .pagination nav[aria-label="Pagination Navigation"] span{
      display:inline-flex;
      align-items:center;
      justify-content:center;
      gap:8px;
      padding:8px 12px;
      border:1px solid var(--border);
      border-radius:999px;
      background:#fff;
      font-size:13px;
      line-height:1;
    }
    .pagination nav[aria-label="Pagination Navigation"] a:hover{
      background: rgba(46,125,50,.06);
      border-color: rgba(46,125,50,.22);
    }
    .pagination nav[aria-label="Pagination Navigation"] span[aria-current="page"]{
      background: var(--green-100);
      border-color: rgba(46,125,50,.22);
      color: var(--green-900);
      font-weight:900;
    }
    .pagination nav[aria-label="Pagination Navigation"] span[aria-disabled="true"]{
      opacity:.55;
    }

    @media (max-width: 980px){
      .brand img{ width:110px; height:52px; }
      input, select{ min-width: 200px; }
      table{ min-width: 980px; }
    }
  </style>
</head>

<body>
  @php
    $nama = auth()->user()->name ?? 'Admin';
    $idPegawai = auth()->user()->id_pegawai ?? '-';

    $logs = $logs ?? ($activityLogs ?? collect());
  @endphp

  <div class="topbar">
    <div class="nav">
      <a class="brand" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
        <div class="title">
          <strong>Aktivitas Karyawan</strong>
          <span>Kebun Jollong — PTPN I Regional 3</span>
        </div>
      </a>

      <div class="navRight">
        <a class="btn ghost" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="hero">
      <div class="heroMedia"></div>
      <div class="heroInner">
        <div class="heroTitle">
          <h1>Lihat Aktivitas</h1>
          <p>Halaman ini hanya untuk membaca log login/logout dan perubahan data. Tidak ada aksi edit/hapus dari sini.</p>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="cardHead">
        <div>
          <strong>Activity Logs</strong>
          <div class="mini">Gunakan filter untuk mempermudah pencarian. Data diurutkan dari yang terbaru.</div>
        </div>
      </div>

      <div class="cardBody">

        <form method="GET" action="{{ route('admin.activity_logs.index') }}" class="filters">
          <div class="filterLeft">

            <div class="field">
              <label>Modul</label>
              <input type="text" name="module" value="{{ request('module') }}" placeholder="Contoh: Karyawan" />
            </div>

            <div class="field">
              <label>Aksi</label>
              <select name="action">
                @php $a = request('action', ''); @endphp
                <option value="" @selected($a==='')>Semua</option>
                <option value="create" @selected($a==='create')>create</option>
                <option value="update" @selected($a==='update')>update</option>
                <option value="delete" @selected($a==='delete')>delete</option>
              </select>
            </div>

            <div class="field">
              <label>Per Halaman</label>
              <select name="per_page">
                @php $pp = (int) request('per_page', 25); @endphp
                <option value="10" @selected($pp===10)>10</option>
                <option value="25" @selected($pp===25)>25</option>
                <option value="50" @selected($pp===50)>50</option>
                <option value="100" @selected($pp===100)>100</option>
              </select>
            </div>
          </div>

          <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; justify-content:flex-end;">
            <button class="btn outline" type="submit">Terapkan Filter</button>
            <a class="btn" href="{{ route('admin.activity_logs.index') }}">Reset</a>
          </div>
        </form>

        <div class="tableWrap">
          <table>
            <thead>
              <tr>
                <th style="width:170px;">Waktu</th>
                <th style="width:120px;">Aksi</th>
                <th style="width:170px;">Modul</th>
                <th style="width:180px;">Karyawan</th>
                <th>Keterangan</th>
                <th style="width:120px;">IP Address</th>
              </tr>
            </thead>
            <tbody>
              @forelse($logs as $log)
                @php
                  $userName = $log->user->name ?? ($log->user_id ? ('User#'.$log->user_id) : '-');
                  $act = (string)($log->action ?? '-');
                  $actClass = 'badge navy';
                  if ($act === 'delete') $actClass = 'badge danger';
                  if ($act === 'create') $actClass = 'badge';
                  if ($act === 'update') $actClass = 'badge navy';
                  if ($act === 'login' || $act === 'logout') $actClass = 'badge';
                @endphp
                <tr>
                  <td class="muted">{{ optional($log->created_at)->format('d M Y • H:i:s') ?? '-' }}</td>
                  <td><span class="{{ $actClass }}">{{ $act }}</span></td>
                  <td><span class="badge">{{ $log->module ?? '-' }}</span></td>
                  <td class="wrap">
                    <strong>{{ $userName }}</strong>
                    <div class="muted" style="font-size:12px; margin-top:2px;">
                      {{ $log->user_id ? 'ID: '.$log->user_id : '' }}
                    </div>
                  </td>
                  <td class="wrap">
                    <strong>{{ $log->description ?? '-' }}</strong>
                    @if(!empty($log->record_id))
                      <div class="muted" style="font-size:12px; margin-top:2px;">Record ID: {{ $log->record_id }}</div>
                    @endif
                  </td>
                  <td class="muted">{{ $log->ip_address ?? '-' }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="muted" style="text-align:center;">Belum ada aktivitas.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="pagination">
          <div class="pagerInfo">
            @if($logs instanceof \Illuminate\Pagination\LengthAwarePaginator || $logs instanceof \Illuminate\Pagination\Paginator)
              Menampilkan {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() ?? 0 }} data
            @else
              Total: {{ is_countable($logs) ? count($logs) : 0 }} data
            @endif
          </div>

          <div>
            @if($logs instanceof \Illuminate\Pagination\LengthAwarePaginator || $logs instanceof \Illuminate\Pagination\Paginator)
              {{ $logs->appends(request()->query())->links() }}
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>
