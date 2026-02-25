<!doctype html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Input Data Karyawan — Kebun Jollong</title>

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

    .navRight{ display:flex; align-items:center; gap:10px; flex-wrap:wrap; justify-content:flex-end; }

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
    .btn.icon{
      padding:9px 10px;
      border-radius:12px;
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
      max-width: 860px;
    }
    .cardBody{ padding:16px 18px 18px; }

    .alert{
      padding:12px 14px;
      border-radius:16px;
      border:1px solid rgba(22,163,74,.18);
      background: rgba(22,163,74,.06);
      margin-top:14px;
    }
    .alert.danger{
      border-color: rgba(220,38,38,.25);
      background: rgba(220,38,38,.06);
      color: var(--danger);
    }

    .formGrid{
      display:grid;
      grid-template-columns: 1fr;
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
    input[readonly]{ background:#f3f4f6; color:#111827; }

    .stickyActions{
      display:flex;
      justify-content:flex-end;
      gap:10px;
      padding-top:12px;
      margin-top:10px;
      border-top:1px dashed rgba(229,231,235,.95);
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
      min-width: 1040px;
      background:#fff;
    }
    thead th{
      position: sticky;
      top: 0;
      background: var(--green-100);
      z-index: 2;
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
      background: rgba(232,238,252,.8);
      color: #1e3a8a;
    }

    .actions{
      display:flex;
      gap:8px;
      justify-content:center;
      flex-wrap:wrap;
    }

    .modalOverlay{
      position:fixed;
      inset:0;
      background: rgba(0,0,0,.40);
      display:none;
      align-items:center;
      justify-content:center;
      padding:18px;
      z-index:1000;
    }
    .modalOverlay.open{ display:flex; }
    .modal{
      width:min(680px, 96vw);
      border-radius: 18px;
      background:#fff;
      border:1px solid var(--border);
      box-shadow: var(--shadow);
      overflow:hidden;
    }
    .modalHead{
      padding:14px 16px;
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:10px;
      border-bottom:1px solid var(--border);
      background: linear-gradient(180deg, rgba(233,246,238,.55), rgba(255,255,255,0));
    }
    .modalHead strong{ font-size:14px; font-weight:950; color:var(--green-900); }
    .modalBody{ padding:14px 16px 16px; }
    .modalFoot{
      padding:12px 16px 16px;
      border-top:1px dashed rgba(229,231,235,.95);
      display:flex;
      justify-content:flex-end;
      gap:10px;
      flex-wrap:wrap;
    }

    @media (max-width: 980px){
      .brand img{ width:110px; height:52px; }
      .field{ min-width: 100%; flex: unset; }
      table{ min-width: 980px; }
    }
  </style>
</head>

<body>
  @php
    $nama = auth()->user()->name ?? 'Admin';
    $idPegawai = auth()->user()->id_pegawai ?? '-';

    $karyawanList = $karyawanList ?? collect();
    if (!($karyawanList instanceof \Illuminate\Support\Collection)) {
      $karyawanList = collect($karyawanList);
    }
  @endphp

  <div class="topbar">
    <div class="nav">
      <a class="brand" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('img/Logo PTPN1.png') }}" alt="Logo PTPN I" />
        <div class="title">
          <strong>Input Data Karyawan</strong>
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
          <h1>Input Karyawan Baru</h1>
          <p>Tambah data karyawan tanpa masuk database manual. Setelah tersimpan, data langsung muncul di tabel bawah.</p>
        </div>
      </div>
    </div>

    @if(session('success'))
      <div class="alert">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert danger">
        <strong style="display:block; margin-bottom:6px;">Gagal menyimpan</strong>
        <div style="color:var(--muted); font-size:13px; line-height:1.6;">
          @foreach($errors->all() as $e)
            <div>• {{ $e }}</div>
          @endforeach
        </div>
      </div>
    @endif

    <div class="card">
      <div class="cardHead">
        <div>
          <strong>Form Input Karyawan</strong>
          <div class="mini">Isi data sesuai personel perusahaan. Nomor pegawai harus unik. Disarankan format numerik.</div>
        </div>
        <div class="chip">Wajib: Personnel Number & Nama</div>
      </div>

      <div class="cardBody">
        <form method="POST" action="{{ route('admin.karyawan.store') }}">
          @csrf

          <div class="formGrid">
            <div class="panel">
              <div class="panelHead">
                <strong>Identitas</strong>
                <span class="badge navy">Karyawan</span>
              </div>

              <div class="row">
                <div class="field" style="max-width:360px;">
                  <label>Personnel Number</label>
                  <input name="personnel_number" value="{{ old('personnel_number') }}" placeholder="Contoh: 240000123" inputmode="numeric" required />
                </div>

                <div class="field">
                  <label>Nama</label>
                  <input name="name" value="{{ old('name') }}" placeholder="Nama karyawan" required />
                </div>
              </div>

              <div class="row" style="margin-top:10px;">
                <div class="field" style="max-width:360px;">
                  <label>Status Kepegawaian</label>
                  <select disabled>
                    <option selected>Active</option>
                  </select>
                  <input type="hidden" name="employment_status" value="Active" />
                </div>

                <div class="field">
                  <label>Divisi</label>
                  <input name="division_name" value="{{ old('division_name') }}" placeholder="Contoh: Produksi / Keuangan / Afdeling" />
                </div>
              </div>

              <div class="stickyActions">
                <button class="btn primary" type="submit">Simpan Karyawan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="cardHead">
        <div>
          <strong>Data Karyawan</strong>
          <div class="mini">Tabel menampilkan semua data karyawan yang tersimpan.</div>
        </div>
        <div class="chip">Total: {{ $karyawanList->count() }}</div>
      </div>

      <div class="cardBody">
        <div class="tableWrap">
          <table>
            <thead>
              <tr>
                <th>Personnel Number</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Divisi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($karyawanList as $k)
                <tr data-personnel="{{ $k->personnel_number }}" data-name="{{ e($k->name) }}" data-division="{{ e($k->division_name ?? '') }}">
                  <td><span class="badge">{{ $k->personnel_number }}</span></td>
                  <td style="text-align:left; white-space:normal;"><strong>{{ $k->name }}</strong></td>
                  <td><span class="badge navy">{{ $k->employment_status ?? 'Active' }}</span></td>
                  <td style="text-align:left; white-space:normal;">{{ $k->division_name ?? '-' }}</td>
                  <td>
                    <div class="actions">
                      <button class="btn icon outline" type="button" data-edit>Edit</button>

                      <form method="POST" action="{{ route('admin.karyawan.destroy', $k->personnel_number) }}" onsubmit="return confirm('Hapus karyawan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn icon danger" type="submit">Hapus</button>
                      </form>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5" style="color:var(--muted); text-align:center;">Belum ada data karyawan.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="modalOverlay" id="editModal" aria-hidden="true">
    <div class="modal" role="dialog" aria-modal="true" aria-labelledby="editTitle">
      <div class="modalHead">
        <strong id="editTitle">Edit Karyawan</strong>
        <button class="btn icon" type="button" id="closeModal">✕</button>
      </div>

      <form method="POST" id="editForm">
        @csrf
        @method('PUT')

        <div class="modalBody">
          <div class="row">
            <div class="field" style="max-width:360px;">
              <label>Personnel Number</label>
              <input id="editPersonnel" readonly />
              <input type="hidden" name="personnel_number" id="editPersonnelHidden" />
            </div>
            <div class="field">
              <label>Nama</label>
              <input name="name" id="editName" required />
            </div>
          </div>

          <div class="row" style="margin-top:10px;">
            <div class="field" style="max-width:360px;">
              <label>Status Kepegawaian</label>
              <select disabled>
                <option selected>Active</option>
              </select>
              <input type="hidden" name="employment_status" value="Active" />
            </div>

            <div class="field">
              <label>Divisi</label>
              <input name="division_name" id="editDivision" />
            </div>
          </div>
        </div>

        <div class="modalFoot">
          <button class="btn" type="button" id="cancelModal">Batal</button>
          <button class="btn primary" type="submit">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const modal = document.getElementById('editModal');
    const closeBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelModal');
    const editForm = document.getElementById('editForm');

    const editPersonnel = document.getElementById('editPersonnel');
    const editPersonnelHidden = document.getElementById('editPersonnelHidden');
    const editName = document.getElementById('editName');
    const editDivision = document.getElementById('editDivision');

    function openModal(){
      modal.classList.add('open');
      modal.setAttribute('aria-hidden','false');
    }
    function closeModal(){
      modal.classList.remove('open');
      modal.setAttribute('aria-hidden','true');
    }

    document.querySelectorAll('[data-edit]').forEach(btn => {
      btn.addEventListener('click', () => {
        const tr = btn.closest('tr');
        if(!tr) return;

        const personnel = tr.getAttribute('data-personnel') || '';
        const name = tr.getAttribute('data-name') || '';
        const division = tr.getAttribute('data-division') || '';

        editPersonnel.value = personnel;
        editPersonnelHidden.value = personnel;
        editName.value = name;
        editDivision.value = division;

        editForm.action = `{{ route('admin.karyawan.update', ['personnel_number' => '__PN__']) }}`.replace('__PN__', encodeURIComponent(personnel));
        openModal();
      });
    });

    closeBtn.addEventListener('click', closeModal);
    cancelBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (e) => { if(e.target === modal) closeModal(); });
    document.addEventListener('keydown', (e) => { if(e.key === 'Escape') closeModal(); });
  </script>
</body>
</html>