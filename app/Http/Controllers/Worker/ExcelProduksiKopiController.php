<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\ProduksiKopi;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelProduksiKopiController extends Controller
{
    public function export(Request $request)
    {
       
        if ($request->filled('tahun')) {
            $yearFrom = $yearTo = (int) $request->tahun;
        } else {
            $yearFrom = $request->filled('tahun_dari') ? (int) $request->tahun_dari : 2017;
            $yearTo = $request->filled('tahun_sampai') ? (int) $request->tahun_sampai : 2025;
        }

        if ($yearFrom > $yearTo) {
            [$yearFrom, $yearTo] = [$yearTo, $yearFrom];
        }

        $years = range($yearFrom, $yearTo);

        $rows = ProduksiKopi::query()
            ->when($yearFrom === $yearTo, function ($q) use ($yearFrom) {
                $q->where('tahun_laporan', $yearFrom);
            }, function ($q) use ($yearFrom, $yearTo) {
                $q->whereBetween('tahun_laporan', [$yearFrom, $yearTo]);
            })
            ->get(['tahun_laporan', 'tahun_tanam', 'luas_ha', 'produksi_kering_kg']);

        $tahunTanamList = $rows->pluck('tahun_tanam')->filter()->unique()->sort()->values()->all();

        $map = [];
        foreach ($years as $y) $map[$y] = [];
        foreach ($rows as $r) {
            $y = (int) $r->tahun_laporan;
            if (!isset($map[$y])) continue;

            $tt = (int) $r->tahun_tanam;
            $luas = (float) ($r->luas_ha ?? 0);
            $prod = (float) ($r->produksi_kering_kg ?? 0);

            if (!isset($map[$y][$tt])) $map[$y][$tt] = ['luas' => 0.0, 'prod' => 0.0];
            $map[$y][$tt]['luas'] += $luas;
            $map[$y][$tt]['prod'] += $prod;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Produksi Kopi');

        $colsPerYear = 4;
        $totalCols = count($years) * $colsPerYear;
        $lastCol = Coordinate::stringFromColumnIndex($totalCols);

        $bAllThin = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $center = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $left = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $right = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_RIGHT,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];

        $bold = ['font' => ['bold' => true]];

        $fillBlue = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFBFD3EA'],
            ],
        ];
        $fillPink = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFE7B8B8'],
            ],
        ];
        $fillGray = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFC9C9C9'],
            ],
        ];
        $fillCyan = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD8EEF4'],
            ],
        ];
        $fillYellow = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFFF00'],
            ],
        ];

        $row = 1;

        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", 'DATA PRODUKSI KOPI PER TAHUN TANAM');
        $sheet->getStyle("A{$row}")->applyFromArray($bold + $left);
        $sheet->getStyle("A{$row}")->getFont()->setSize(14);
        $row++;

        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", 'KEBUN JOLLONG');
        $sheet->getStyle("A{$row}")->applyFromArray($bold + $left);
        $sheet->getStyle("A{$row}")->getFont()->setSize(13);
        $row++;

        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", "TAHUN {$yearFrom}-{$yearTo}");
        $sheet->getStyle("A{$row}")->applyFromArray($bold + $left);
        $sheet->getStyle("A{$row}")->getFont()->setSize(12);
        $row += 2;

        $yearHeaderRow = $row;
        $subHeaderRow = $row + 1;

        $palette = [$fillBlue, $fillPink, $fillGray, $fillBlue, $fillPink, $fillGray, $fillBlue, $fillPink, $fillGray];

        foreach ($years as $i => $y) {
            $startColIdx = ($i * $colsPerYear) + 1;
            $endColIdx = $startColIdx + $colsPerYear - 1;

            $startCol = Coordinate::stringFromColumnIndex($startColIdx);
            $endCol = Coordinate::stringFromColumnIndex($endColIdx);

            $sheet->mergeCells("{$startCol}{$yearHeaderRow}:{$endCol}{$yearHeaderRow}");
            $sheet->setCellValue("{$startCol}{$yearHeaderRow}", (string) $y);

            $sheet->setCellValue("{$startCol}{$subHeaderRow}", "Tahun\nTanam");
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($startColIdx + 1) . $subHeaderRow, "Luas Ha");
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($startColIdx + 2) . $subHeaderRow, "Produksi\nKering (kg)");
            $sheet->setCellValue(Coordinate::stringFromColumnIndex($startColIdx + 3) . $subHeaderRow, "kg/ha");

            $fill = $palette[$i % count($palette)];
            $sheet->getStyle("{$startCol}{$yearHeaderRow}:{$endCol}{$yearHeaderRow}")->applyFromArray($bold + $center + $fill);
            $sheet->getStyle("{$startCol}{$subHeaderRow}:{$endCol}{$subHeaderRow}")->applyFromArray($bold + $center + $fill);
        }

        $sheet->getRowDimension($yearHeaderRow)->setRowHeight(20);
        $sheet->getRowDimension($subHeaderRow)->setRowHeight(38);

        $row += 2;
        $dataStartRow = $row;

        foreach ($tahunTanamList as $tt) {
            foreach ($years as $i => $y) {
                $startColIdx = ($i * $colsPerYear) + 1;

                $colTT = Coordinate::stringFromColumnIndex($startColIdx);
                $colL = Coordinate::stringFromColumnIndex($startColIdx + 1);
                $colP = Coordinate::stringFromColumnIndex($startColIdx + 2);
                $colK = Coordinate::stringFromColumnIndex($startColIdx + 3);

                $luas = $map[$y][$tt]['luas'] ?? 0;
                $prod = $map[$y][$tt]['prod'] ?? 0;

                $sheet->setCellValue("{$colTT}{$row}", $tt ?: '');
                $sheet->setCellValue("{$colL}{$row}", $luas ?: 0);
                $sheet->setCellValue("{$colP}{$row}", $prod ?: 0);

                $sheet->setCellValue("{$colK}{$row}", "=IF({$colL}{$row}>0,ROUND({$colP}{$row}/{$colL}{$row},0),\"\")");

                $sheet->getStyle("{$colTT}{$row}")->applyFromArray($center);
                $sheet->getStyle("{$colK}{$row}")->applyFromArray($center);

                $sheet->getStyle("{$colL}{$row}")->applyFromArray($right + $fillCyan);
                $sheet->getStyle("{$colP}{$row}")->applyFromArray($right + $fillCyan);

                $sheet->getStyle("{$colL}{$row}")->getNumberFormat()->setFormatCode('0.00');
                $sheet->getStyle("{$colP}{$row}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("{$colK}{$row}")->getNumberFormat()->setFormatCode('0');
            }
            $row++;
        }

        $totalRow = $row;

        foreach ($years as $i => $y) {
            $startColIdx = ($i * $colsPerYear) + 1;

            $colTT = Coordinate::stringFromColumnIndex($startColIdx);
            $colL = Coordinate::stringFromColumnIndex($startColIdx + 1);
            $colP = Coordinate::stringFromColumnIndex($startColIdx + 2);
            $colK = Coordinate::stringFromColumnIndex($startColIdx + 3);

            $sheet->setCellValue("{$colTT}{$totalRow}", "Jumlah");

            $luasStart = $dataStartRow;
            $luasEnd = $totalRow - 1;

            $sheet->setCellValue("{$colL}{$totalRow}", "=SUM({$colL}{$luasStart}:{$colL}{$luasEnd})");
            $sheet->setCellValue("{$colP}{$totalRow}", "=SUM({$colP}{$luasStart}:{$colP}{$luasEnd})");
            $sheet->setCellValue("{$colK}{$totalRow}", "=IF({$colL}{$totalRow}>0,ROUND({$colP}{$totalRow}/{$colL}{$totalRow},0),\"\")");

            $sheet->getStyle("{$colTT}{$totalRow}")->applyFromArray($bold + $center);
            $sheet->getStyle("{$colL}{$totalRow}")->applyFromArray($bold + $right);
            $sheet->getStyle("{$colP}{$totalRow}")->applyFromArray($bold + $right + $fillYellow);
            $sheet->getStyle("{$colK}{$totalRow}")->applyFromArray($bold + $center);

            $sheet->getStyle("{$colL}{$totalRow}")->getNumberFormat()->setFormatCode('0.00');
            $sheet->getStyle("{$colP}{$totalRow}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("{$colK}{$totalRow}")->getNumberFormat()->setFormatCode('0');
        }

        $sheet->getStyle("A{$yearHeaderRow}:{$lastCol}{$totalRow}")->applyFromArray($bAllThin);

        for ($c = 1; $c <= $totalCols; $c++) {
            $col = Coordinate::stringFromColumnIndex($c);
            $mod = ($c - 1) % 4;
            if ($mod === 0) $sheet->getColumnDimension($col)->setWidth(12);
            if ($mod === 1) $sheet->getColumnDimension($col)->setWidth(10);
            if ($mod === 2) $sheet->getColumnDimension($col)->setWidth(16);
            if ($mod === 3) $sheet->getColumnDimension($col)->setWidth(8);
        }

        $sheet->getStyle("A{$yearHeaderRow}:{$lastCol}{$subHeaderRow}")->applyFromArray($center);
        $sheet->getStyle("A{$dataStartRow}:{$lastCol}{$totalRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        $filename = "DATA_PRODUKSI_KOPI_{$yearFrom}_{$yearTo}.xlsx";

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}