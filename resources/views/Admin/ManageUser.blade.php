<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Kelola Pengguna — Kebun Jollong</title>

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
      --ok:#16a34a;
      --ok-soft: rgba(22,163,74,.10);
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

    .btn{
      padding:10px 14px; border-radius:999px; font-size:14px;
      border:1px solid var(--border); background:#fff;
      cursor:pointer; transition:.15s ease; white-space:nowrap;
      display:inline-flex; align-items:center; justify-content:center; gap:8px;
      user-select:none;
    }
    .btn.outline{
      background:#fff;
      border-color: rgba(46,125,50,.38);
      color: var(--green-800);
      font-weight:850;
    }
    .btn.ghost{
      background: var(--chip-bg);
      border-color: var(--chip-br);
      color: var(--green-800);
      font-weight:800;
    }
    .btn.danger{
      border-color: rgba(220,38,38,.25);
      color: var(--danger);
      background:#fff;
      font-weight:850;
    }
    .btn:hover{ transform: translateY(-1px); box-shadow: 0 10px 18px rgba(0,0,0,.10); }

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

    .alert{
      border-radius:16px;
      padding:10px 12px;
      font-size:13px;
      line-height:1.55;
      margin-bottom:12px;
      border:1px solid var(--border);
      background:#fff;
    }
    .alert.ok{
      border-color: rgba(22,163,74,.25);
      background: var(--ok-soft);
      color:#065f46;
    }
    .alert.err{
      border-color: rgba(220,38,38,.25);
      background: var(--danger-soft);
      color:#991b1b;
    }

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

    .tableWrap{ overflow:auto; border:1px solid var(--border); border-radius:18px; }
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
      z-index: 1;
      text-align:left;
      vertical-align: middle;
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
    tbody tr:hover td{ background: rgba(46,125,50,.04); }

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
    .badge.ok{
      border-color: rgba(22,163,74,.22);
      background: rgba(22,163,74,.08);
      color: var(--ok);
    }
    .muted{ color:var(--muted); }
    .wrap{ white-space:normal; line-height:1.55; }

    .rowActions{ display:flex; gap:10px; flex-wrap:wrap; align-items:center; }
    .rowActions form{ display:inline-flex; }

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
  </style>
</head>

<body>
  @php
    $nama = auth()->user()->name ?? 'Admin';
    $idPegawai = auth()->user()->id_pegawai ?? '-';
  @endphp

  <div class="topbar">
    <div class="nav">
      <a class="brand" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
        <div class="title">
          <strong>Kelola Pengguna</strong>
          <span>Kebun Jollong — PTPN I Regional 3</span>
        </div>
      </a>

      <div class="navRight">
        <a class="btn ghost" href="{{ route('admin.dashboard') }}">← Kembali ke Dashboard</a>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="card">
      <div class="cardHead">
        <div>
          <strong>Daftar Pengguna</strong>
          <div class="mini">Kelola status akun dan reset password ke default. Reset akan memaksa user ganti password saat login.</div>
        </div>
      </div>

      <div class="cardBody">

        @if (session('success'))
          <div class="alert ok">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div class="alert err">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
          <div class="alert err">
            <ul style="margin:0; padding-left:18px;">
              @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="GET" action="{{ route('admin.users.index') }}" class="filters">
          <div class="filterLeft">
            <div class="field">
              <label>Cari (ID / Nama)</label>
              <input type="text" name="q" value="{{ request('q') }}" placeholder="Contoh: 90xxxx / Syifa / ..." />
            </div>

            <div class="field">
              <label>Role</label>
              <select name="role">
                @php $role = request('role',''); @endphp
                <option value="" @selected($role==='')>Semua</option>
                <option value="admin" @selected($role==='admin')>admin</option>
                <option value="pegawai" @selected($role==='pegawai')>pegawai</option>
              </select>
            </div>

            <div class="field">
              <label>Status</label>
              @php $status = request('status',''); @endphp
              <select name="status">
                <option value="" @selected($status==='')>Semua</option>
                <option value="active" @selected($status==='active')>aktif</option>
                <option value="inactive" @selected($status==='inactive')>nonaktif</option>
              </select>
            </div>

            <div class="field">
              <label>Ganti Password</label>
              @php $mc = request('must_change',''); @endphp
              <select name="must_change">
                <option value="" @selected($mc==='')>Semua</option>
                <option value="yes" @selected($mc==='yes')>Belum</option>
                <option value="no" @selected($mc==='no')>Sudah</option>
              </select>
            </div>

            <div class="field">
              <label>Per Halaman</label>
              @php $pp = (int) request('per_page', 25); @endphp
              <select name="per_page">
                <option value="10" @selected($pp===10)>10</option>
                <option value="25" @selected($pp===25)>25</option>
                <option value="50" @selected($pp===50)>50</option>
                <option value="100" @selected($pp===100)>100</option>
              </select>
            </div>
          </div>

          <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center; justify-content:flex-end;">
            <button class="btn outline" type="submit">Terapkan Filter</button>
            <a class="btn" href="{{ route('admin.users.index') }}">Reset</a>
          </div>
        </form>

        <div class="tableWrap">
          <table>
            <thead>
              <tr>
                <th style="width:150px;">ID Pegawai</th>
                <th style="width:220px;">Nama</th>
                <th style="width:120px;">Role</th>
                <th style="width:140px;">Status</th>
                <th style="width:220px;">Divisi</th>
                <th style="width:180px;">Ganti Password</th>
                <th style="width:360px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $u)
                @php
                  $div = $u->karyawan->division_name ?? '-';
                  $isAdmin = (($u->role ?? 'pegawai') === 'admin');
                @endphp
                <tr>
                  <td><strong>{{ $u->id_pegawai }}</strong></td>
                  <td class="wrap">{{ $u->name ?? '-' }}</td>
                  <td><span class="badge navy">{{ $u->role ?? 'pegawai' }}</span></td>
                  <td>
                    @if(($u->is_active ?? true) === true)
                      <span class="badge ok">AKTIF</span>
                    @else
                      <span class="badge danger">NONAKTIF</span>
                    @endif
                  </td>
                  <td class="wrap">{{ $div }}</td>
                  <td>
                    @if($isAdmin)
                      <span class="muted" style="font-weight:900;">-</span>
                    @else
                      @if(($u->must_change_password ?? false) === true)
                        <span class="badge danger">BELUM</span>
                      @else
                        <span class="badge ok">SUDAH</span>
                      @endif
                    @endif
                  </td>
                  <td>
                    @if($isAdmin)
                      <span class="muted" style="font-weight:900;">-</span>
                    @else
                      <div class="rowActions">
                        <form method="POST" action="{{ route('admin.users.toggleActive', $u) }}">
                          @csrf
                          <button class="btn {{ ($u->is_active ?? true) ? 'danger' : 'outline' }}" type="submit">
                            {{ ($u->is_active ?? true) ? 'Nonaktifkan' : 'Aktifkan' }}
                          </button>
                        </form>

                        <form method="POST" action="{{ route('admin.users.resetPassword', $u) }}">
                          @csrf
                          <button class="btn outline" type="submit">Reset Password Default</button>
                        </form>
                      </div>
                      <div class="muted" style="font-size:12px; margin-top:6px;">
                        Reset Password akan membuat user login dengan password default (Jollong@12345).
                      </div>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="muted" style="text-align:center;">Belum ada data pengguna.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="pagination">
          <div class="pagerInfo">
            Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} dari {{ $users->total() ?? 0 }} data
          </div>
          <div>
            {{ $users->appends(request()->query())->links() }}
          </div>
        </div>

      </div>
    </div>
  </div>
</body>
</html>
