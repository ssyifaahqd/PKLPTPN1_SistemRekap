<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendapatanBiayaBulanan;

class ExportLabaRugiController extends Controller
{
    public function labaRugi(Request $request)
    {
        $tahunParam = $request->get('tahun', null);
        $bulan = $request->filled('bulan') ? (int) $request->get('bulan') : null;

        if ($bulan !== null && ($bulan < 1 || $bulan > 12)) {
            $bulan = null;
        }

        $kategoriMap = [
            1 => 'wahana',
            2 => 'resto',
            3 => 'penginapan',
        ];

        $bulanMap = [
            1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
            7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des'
        ];

        $isAllYears = !$request->filled('tahun')
            || $tahunParam === null
            || $tahunParam === ''
            || in_array(strtolower((string) $tahunParam), ['all', 'semua', 'semua tahun', 'semuatahun'], true)
            || !is_numeric($tahunParam);

        if ($isAllYears) {
            $years = PendapatanBiayaBulanan::query()
                ->select('tahun')
                ->distinct()
                ->orderByDesc('tahun')
                ->pluck('tahun')
                ->map(fn($y) => (int) $y)
                ->values()
                ->all();

            if (empty($years)) {
                $years = [(int) now()->year];
            }
        } else {
            $years = [(int) $tahunParam];
        }

        $q = PendapatanBiayaBulanan::query()->whereIn('tahun', $years);
        if ($bulan !== null) $q->where('bulan', $bulan);

        $raw = $q->get(['tahun', 'bulan', 'kategori_id', 'pendapatan', 'biaya']);

        $monthsToShow = $bulan !== null ? [$bulan] : range(1, 12);

        $dataByYear = [];
        foreach ($years as $y) {
            $rows = [];
            foreach ($monthsToShow as $m) {
                $rows[$m] = [
                    'bulan_label' => $bulanMap[$m],
                    'pendapatan'  => ['wahana'=>0,'resto'=>0,'penginapan'=>0,'jumlah'=>0],
                    'biaya'       => ['wahana'=>0,'resto'=>0,'penginapan'=>0,'jumlah'=>0],
                    'laba'        => ['wahana'=>0,'resto'=>0,'penginapan'=>0,'jumlah'=>0],
                ];
            }

            $tot = [
                'pendapatan' => ['wahana'=>0,'resto'=>0,'penginapan'=>0,'jumlah'=>0],
                'biaya'      => ['wahana'=>0,'resto'=>0,'penginapan'=>0,'jumlah'=>0],
                'laba'       => ['wahana'=>0,'resto'=>0,'penginapan'=>0,'jumlah'=>0],
            ];

            $dataByYear[$y] = [
                'rows' => $rows,
                'tot'  => $tot,
            ];
        }

        foreach ($raw as $r) {
            $y = (int) $r->tahun;
            $m = (int) $r->bulan;
            if (!isset($dataByYear[$y])) continue;
            if (!isset($dataByYear[$y]['rows'][$m])) continue;

            $key = $kategoriMap[(int) $r->kategori_id] ?? null;
            if (!$key) continue;

            $dataByYear[$y]['rows'][$m]['pendapatan'][$key] += (float) ($r->pendapatan ?? 0);
            $dataByYear[$y]['rows'][$m]['biaya'][$key]      += (float) ($r->biaya ?? 0);
        }

        foreach ($years as $y) {
            foreach ($monthsToShow as $m) {
                $p = &$dataByYear[$y]['rows'][$m]['pendapatan'];
                $b = &$dataByYear[$y]['rows'][$m]['biaya'];

                $p['jumlah'] = $p['wahana'] + $p['resto'] + $p['penginapan'];
                $b['jumlah'] = $b['wahana'] + $b['resto'] + $b['penginapan'];

                $dataByYear[$y]['rows'][$m]['laba']['wahana']     = $p['wahana'] - $b['wahana'];
                $dataByYear[$y]['rows'][$m]['laba']['resto']      = $p['resto'] - $b['resto'];
                $dataByYear[$y]['rows'][$m]['laba']['penginapan'] = $p['penginapan'] - $b['penginapan'];
                $dataByYear[$y]['rows'][$m]['laba']['jumlah']     = $p['jumlah'] - $b['jumlah'];

                foreach (['wahana','resto','penginapan','jumlah'] as $k) {
                    $dataByYear[$y]['tot']['pendapatan'][$k] += $p[$k];
                    $dataByYear[$y]['tot']['biaya'][$k]      += $b[$k];
                    $dataByYear[$y]['tot']['laba'][$k]       += $dataByYear[$y]['rows'][$m]['laba'][$k];
                }
            }
        }

        $judul = $bulan !== null
            ? "Laporan Laba Rugi — {$bulanMap[$bulan]}"
            : "Laporan Laba Rugi";

        $html = $this->buildHtml($judul, $bulan, $dataByYear);

        return response($html)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    private function rupiah(float $n): string
    {
        return number_format($n, 0, ',', '.');
    }

    private function buildHtml(string $judul, ?int $bulan, array $dataByYear): string
    {
        $css = "
        <style>
          @page { size: A4 landscape; margin: 12mm; }
          * { box-sizing: border-box; }
          body { font-family: Arial, sans-serif; color:#111; }

          .top { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; margin-bottom:10px; }
          h1 { font-size:16px; margin:0 0 4px; }
          h2 { font-size:14px; margin:14px 0 8px; }
          .meta { font-size:12px; color:#444; }
          .hint { font-size:12px; color:#666; text-align:right; }
          .btnprint { margin:10px 0 10px; display:inline-block; padding:8px 12px; border:1px solid #111; border-radius:8px; font-size:12px; cursor:pointer; background:#fff; }
          @media print { .btnprint, .hint { display:none; } }

          table { width:100%; border-collapse:collapse; font-size:12px; margin-bottom:10px; }
          th, td { border:1px solid #000; padding:6px 8px; }
          th { font-weight:700; text-align:center; vertical-align:middle; }
          td { vertical-align:middle; }
          td.center { text-align:center; }
          td.right  { text-align:right; }

          .sumcol { background:#fff3a0; font-weight:700; }
          .totalrow td { font-weight:700; }
          .totalrow .sumcol { background:#fff3a0; }

          .pagebreak { page-break-before: always; }
        </style>
        ";

        $btn = "<button class='btnprint' onclick='window.print()'>Cetak / Save as PDF</button>";

        $thead = "
        <thead>
          <tr>
            <th rowspan='2' style='width:9%'>Bulan</th>
            <th colspan='4'>Pendapatan</th>
            <th colspan='4'>Biaya</th>
            <th colspan='4'>Laba Rugi</th>
          </tr>
          <tr>
            <th style='width:8%'>Wahana &amp; Pintu Masuk</th>
            <th style='width:8%'>Resto</th>
            <th style='width:8%'>Penginapan</th>
            <th class='sumcol' style='width:8%'>Jumlah</th>

            <th style='width:8%'>Wahana &amp; Pintu Masuk</th>
            <th style='width:8%'>Resto</th>
            <th style='width:8%'>Penginapan</th>
            <th class='sumcol' style='width:8%'>Jumlah</th>

            <th style='width:8%'>Wahana &amp; Pintu Masuk</th>
            <th style='width:8%'>Resto</th>
            <th style='width:8%'>Penginapan</th>
            <th class='sumcol' style='width:8%'>Jumlah</th>
          </tr>
        </thead>";

        $sections = "";
        $i = 0;

        foreach ($dataByYear as $tahun => $pack) {
            $rows = $pack['rows'];
            $tot  = $pack['tot'];

            $subjudul = $bulan !== null
                ? "{$judul} {$tahun}"
                : "{$judul} — Tahun {$tahun}";

            $wrapClass = $i === 0 ? "" : "pagebreak";
            $sections .= "<div class='{$wrapClass}'>
              <h2>{$subjudul}</h2>

              <table>
                {$thead}
                <tbody>";

            foreach ($rows as $r) {
                $p = $r['pendapatan'];
                $b = $r['biaya'];
                $l = $r['laba'];

                $sections .= "<tr>
                  <td class='center'>{$r['bulan_label']}</td>

                  <td class='right'>{$this->rupiah($p['wahana'])}</td>
                  <td class='right'>{$this->rupiah($p['resto'])}</td>
                  <td class='right'>{$this->rupiah($p['penginapan'])}</td>
                  <td class='right sumcol'>{$this->rupiah($p['jumlah'])}</td>

                  <td class='right'>{$this->rupiah($b['wahana'])}</td>
                  <td class='right'>{$this->rupiah($b['resto'])}</td>
                  <td class='right'>{$this->rupiah($b['penginapan'])}</td>
                  <td class='right sumcol'>{$this->rupiah($b['jumlah'])}</td>

                  <td class='right'>{$this->rupiah($l['wahana'])}</td>
                  <td class='right'>{$this->rupiah($l['resto'])}</td>
                  <td class='right'>{$this->rupiah($l['penginapan'])}</td>
                  <td class='right sumcol'>{$this->rupiah($l['jumlah'])}</td>
                </tr>";
            }

            $sections .= "<tr class='totalrow'>
              <td class='center'>Jumlah Keseluruhan</td>

              <td class='right'>{$this->rupiah($tot['pendapatan']['wahana'])}</td>
              <td class='right'>{$this->rupiah($tot['pendapatan']['resto'])}</td>
              <td class='right'>{$this->rupiah($tot['pendapatan']['penginapan'])}</td>
              <td class='right sumcol'>{$this->rupiah($tot['pendapatan']['jumlah'])}</td>

              <td class='right'>{$this->rupiah($tot['biaya']['wahana'])}</td>
              <td class='right'>{$this->rupiah($tot['biaya']['resto'])}</td>
              <td class='right'>{$this->rupiah($tot['biaya']['penginapan'])}</td>
              <td class='right sumcol'>{$this->rupiah($tot['biaya']['jumlah'])}</td>

              <td class='right'>{$this->rupiah($tot['laba']['wahana'])}</td>
              <td class='right'>{$this->rupiah($tot['laba']['resto'])}</td>
              <td class='right'>{$this->rupiah($tot['laba']['penginapan'])}</td>
              <td class='right sumcol'>{$this->rupiah($tot['laba']['jumlah'])}</td>
            </tr>";

            $sections .= "</tbody></table></div>";

            $i++;
        }

        return "<!doctype html>
<html lang='id'>
<head>
<meta charset='UTF-8' />
<meta name='viewport' content='width=device-width, initial-scale=1.0' />
<title>{$judul}</title>
{$css}
</head>
<body>
  <div class='top'>
    <div>
      <h1>{$judul}</h1>
      <div class='meta'>Dicetak: ".now()->format('d-m-Y H:i')."</div>
      {$btn}
    </div>
    <div class='hint'>Tips: Ctrl+P → Destination: Save as PDF</div>
  </div>

  {$sections}
</body>
</html>";
    }
}
