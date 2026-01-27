<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProduksiKopi;

class ExportProduksiKopiController extends Controller
{
    public function produksiKopi(Request $request)
    {
        $tahun = $request->get('tahun'); // kalau kosong: semua tahun

        $query = ProduksiKopi::query()
            ->selectRaw('tahun_laporan, tahun_tanam, SUM(luas_ha) AS luas_ha, SUM(produksi_kering_kg) AS produksi_kering_kg')
            ->groupBy('tahun_laporan', 'tahun_tanam')
            ->orderBy('tahun_laporan')
            ->orderBy('tahun_tanam');

        if (!empty($tahun)) {
            $query->where('tahun_laporan', (int)$tahun);
        }

        $rows = $query->get();

        $totalLuas = (float)$rows->sum('luas_ha');
        $totalProd = (float)$rows->sum('produksi_kering_kg');
        $totalKgHa = $totalLuas > 0 ? ($totalProd / $totalLuas) : 0;

        $judul = !empty($tahun)
            ? "Laporan Produksi Kopi — Tahun Laporan: ".(int)$tahun
            : "Laporan Produksi Kopi — Semua Tahun Laporan";

        $html = $this->buildHtml($judul, $rows, !empty($tahun), $totalLuas, $totalProd, $totalKgHa);

        return response($html)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    private function buildHtml(string $judul, $rows, bool $singleYear, float $totalLuas, float $totalProd, float $totalKgHa): string
    {
        $css = "
        <style>
          @page { size: A4 landscape; margin: 14mm; }
          * { box-sizing: border-box; }
          body { font-family: Arial, sans-serif; color:#111; }
          .top { display:flex; align-items:flex-start; justify-content:space-between; gap:12px; margin-bottom:12px; }
          h1 { font-size:16px; margin:0 0 4px; }
          .meta { font-size:12px; color:#444; }
          .hint { font-size:12px; color:#666; text-align:right; }
          table { width:100%; border-collapse:collapse; font-size:12px; }
          th, td { border:1px solid #000; padding:6px 8px; }
          th { background:#e9f6ee; font-weight:700; text-transform:uppercase; letter-spacing:.04em; }
          td.center { text-align:center; }
          td.right { text-align:right; }
          tr.total td { background:#fff3a0; font-weight:700; }
          .btnprint { margin:10px 0 12px; display:inline-block; padding:8px 12px; border:1px solid #111; border-radius:8px; font-size:12px; cursor:pointer; background:#fff; }
          @media print { .btnprint, .hint { display:none; } }
        </style>
        ";

        $btn = "<button class='btnprint' onclick='window.print()'>Cetak / Save as PDF</button>";

        $headCols = $singleYear
            ? "<tr>
                 <th style='width:18%'>Tahun Tanam</th>
                 <th style='width:22%'>Luas (ha)</th>
                 <th style='width:30%'>Produksi Kering (kg)</th>
                 <th style='width:20%'>kg/ha</th>
               </tr>"
            : "<tr>
                 <th style='width:16%'>Tahun Laporan</th>
                 <th style='width:16%'>Tahun Tanam</th>
                 <th style='width:22%'>Luas (ha)</th>
                 <th style='width:26%'>Produksi Kering (kg)</th>
                 <th style='width:20%'>kg/ha</th>
               </tr>";

        $bodyRows = "";
        foreach ($rows as $r) {
            $luas = (float)$r->luas_ha;
            $prod = (float)$r->produksi_kering_kg;
            $kgha = $luas > 0 ? ($prod / $luas) : 0;

            if ($singleYear) {
                $bodyRows .= "<tr>
                    <td class='center'>".(int)$r->tahun_tanam."</td>
                    <td class='right'>".number_format($luas, 2, ',', '.')."</td>
                    <td class='right'>".number_format($prod, 0, ',', '.')."</td>
                    <td class='right'>".number_format($kgha, 2, ',', '.')."</td>
                </tr>";
            } else {
                $bodyRows .= "<tr>
                    <td class='center'>".(int)$r->tahun_laporan."</td>
                    <td class='center'>".(int)$r->tahun_tanam."</td>
                    <td class='right'>".number_format($luas, 2, ',', '.')."</td>
                    <td class='right'>".number_format($prod, 0, ',', '.')."</td>
                    <td class='right'>".number_format($kgha, 2, ',', '.')."</td>
                </tr>";
            }
        }

        $totalRow = $singleYear
            ? "<tr class='total'>
                 <td class='center'>TOTAL</td>
                 <td class='right'>".number_format($totalLuas, 2, ',', '.')."</td>
                 <td class='right'>".number_format($totalProd, 0, ',', '.')."</td>
                 <td class='right'>".number_format($totalKgHa, 2, ',', '.')."</td>
               </tr>"
            : "<tr class='total'>
                 <td class='center'>TOTAL</td>
                 <td class='center'>-</td>
                 <td class='right'>".number_format($totalLuas, 2, ',', '.')."</td>
                 <td class='right'>".number_format($totalProd, 0, ',', '.')."</td>
                 <td class='right'>".number_format($totalKgHa, 2, ',', '.')."</td>
               </tr>";

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

  <table>
    <thead>{$headCols}</thead>
    <tbody>
      {$bodyRows}
      {$totalRow}
    </tbody>
  </table>
</body>
</html>";
    }
}
