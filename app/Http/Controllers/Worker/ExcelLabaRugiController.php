<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use App\Models\PendapatanBiayaBulanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelLabaRugiController extends Controller
{
    public function export(Request $request)
    {
        $filterTahun = $request->filled('tahun') ? (int) $request->tahun : null;

        $q = PendapatanBiayaBulanan::query();
        if ($filterTahun) $q->where('tahun', $filterTahun);

        $raw = $q->get()
            ->groupBy(['tahun', 'bulan']);

        $tahunKeys = collect($raw->keys())->map(fn ($y) => (int) $y)->sortDesc()->values()->all();

        $bulanNama = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des',
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Laba Rugi');

        $colCount = 13;
        $lastCol = Coordinate::stringFromColumnIndex($colCount);

        $bThin = [
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

        $bold = ['font' => ['bold' => true]];
        $hdrFill = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD9D9D9'],
            ],
        ];
        $sumFill = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFFFF2A8'],
            ],
        ];

        $row = 1;

        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", 'Laporan Laba Rugi Agrowisata');
        $sheet->getStyle("A{$row}")->applyFromArray($bold + $left);
        $sheet->getStyle("A{$row}")->getFont()->setSize(14);
        $row++;

        $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
        $sheet->setCellValue("A{$row}", 'Dicetak: ' . Carbon::now()->format('d-m-Y H:i'));
        $sheet->getStyle("A{$row}")->applyFromArray($left);
        $row += 2;

        foreach ($tahunKeys as $tahun) {
            $sheet->mergeCells("A{$row}:{$lastCol}{$row}");
            $sheet->setCellValue("A{$row}", "Laporan Laba Rugi Agrowisata — Tahun {$tahun}");
            $sheet->getStyle("A{$row}")->applyFromArray($bold + $left);
            $sheet->getStyle("A{$row}")->getFont()->setSize(12);
            $row++;

            $r1 = $row;
            $r2 = $row + 1;

            $sheet->mergeCells("A{$r1}:A{$r2}");
            $sheet->setCellValue("A{$r1}", 'Bulan');

            $sheet->mergeCells("B{$r1}:E{$r1}");
            $sheet->setCellValue("B{$r1}", 'Pendapatan');

            $sheet->mergeCells("F{$r1}:I{$r1}");
            $sheet->setCellValue("F{$r1}", 'Biaya');

            $sheet->mergeCells("J{$r1}:M{$r1}");
            $sheet->setCellValue("J{$r1}", 'Laba Rugi');

            $sheet->setCellValue("B{$r2}", "Wahana & Pintu Masuk");
            $sheet->setCellValue("C{$r2}", "Resto");
            $sheet->setCellValue("D{$r2}", "Penginapan");
            $sheet->setCellValue("E{$r2}", "Jumlah");

            $sheet->setCellValue("F{$r2}", "Wahana & Pintu Masuk");
            $sheet->setCellValue("G{$r2}", "Resto");
            $sheet->setCellValue("H{$r2}", "Penginapan");
            $sheet->setCellValue("I{$r2}", "Jumlah");

            $sheet->setCellValue("J{$r2}", "Wahana & Pintu Masuk");
            $sheet->setCellValue("K{$r2}", "Resto");
            $sheet->setCellValue("L{$r2}", "Penginapan");
            $sheet->setCellValue("M{$r2}", "Jumlah");

            $sheet->getStyle("A{$r1}:{$lastCol}{$r2}")->applyFromArray($bold + $center + $hdrFill);
            $sheet->getRowDimension($r1)->setRowHeight(20);
            $sheet->getRowDimension($r2)->setRowHeight(30);

            $sheet->getStyle("E{$r1}:E{$r2}")->applyFromArray($sumFill);
            $sheet->getStyle("I{$r1}:I{$r2}")->applyFromArray($sumFill);
            $sheet->getStyle("M{$r1}:M{$r2}")->applyFromArray($sumFill);

            $row += 2;

            $startDataRow = $row;

            $totPW = 0; $totPR = 0; $totPP = 0;
            $totBW = 0; $totBR = 0; $totBP = 0;

            for ($bulan = 1; $bulan <= 12; $bulan++) {
                $items = $raw[$tahun][$bulan] ?? collect();

                $pW = (float) optional($items->firstWhere('kategori_id', 1))->pendapatan ?? 0;
                $pR = (float) optional($items->firstWhere('kategori_id', 2))->pendapatan ?? 0;
                $pP = (float) optional($items->firstWhere('kategori_id', 3))->pendapatan ?? 0;

                $bW = (float) optional($items->firstWhere('kategori_id', 1))->biaya ?? 0;
                $bR = (float) optional($items->firstWhere('kategori_id', 2))->biaya ?? 0;
                $bP = (float) optional($items->firstWhere('kategori_id', 3))->biaya ?? 0;

                $pJ = $pW + $pR + $pP;
                $bJ = $bW + $bR + $bP;

                $lW = $pW - $bW;
                $lR = $pR - $bR;
                $lP = $pP - $bP;
                $lJ = $pJ - $bJ;

                $totPW += $pW; $totPR += $pR; $totPP += $pP;
                $totBW += $bW; $totBR += $bR; $totBP += $bP;

                $sheet->setCellValue("A{$row}", $bulanNama[$bulan] ?? (string) $bulan);

                $sheet->setCellValue("B{$row}", $pW);
                $sheet->setCellValue("C{$row}", $pR);
                $sheet->setCellValue("D{$row}", $pP);
                $sheet->setCellValue("E{$row}", $pJ);

                $sheet->setCellValue("F{$row}", $bW);
                $sheet->setCellValue("G{$row}", $bR);
                $sheet->setCellValue("H{$row}", $bP);
                $sheet->setCellValue("I{$row}", $bJ);

                $sheet->setCellValue("J{$row}", $lW);
                $sheet->setCellValue("K{$row}", $lR);
                $sheet->setCellValue("L{$row}", $lP);
                $sheet->setCellValue("M{$row}", $lJ);

                $sheet->getStyle("A{$row}")->applyFromArray($center);
                $sheet->getStyle("B{$row}:M{$row}")->getNumberFormat()->setFormatCode('#,##0');
                $sheet->getStyle("B{$row}:M{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
                $sheet->getStyle("E{$row}")->applyFromArray($sumFill);
                $sheet->getStyle("I{$row}")->applyFromArray($sumFill);
                $sheet->getStyle("M{$row}")->applyFromArray($sumFill);

                $row++;
            }

            $totPJ = $totPW + $totPR + $totPP;
            $totBJ = $totBW + $totBR + $totBP;

            $totLW = $totPW - $totBW;
            $totLR = $totPR - $totBR;
            $totLP = $totPP - $totBP;
            $totLJ = $totPJ - $totBJ;

            $sheet->setCellValue("A{$row}", "Jumlah Keseluruhan");

            $sheet->setCellValue("B{$row}", $totPW);
            $sheet->setCellValue("C{$row}", $totPR);
            $sheet->setCellValue("D{$row}", $totPP);
            $sheet->setCellValue("E{$row}", $totPJ);

            $sheet->setCellValue("F{$row}", $totBW);
            $sheet->setCellValue("G{$row}", $totBR);
            $sheet->setCellValue("H{$row}", $totBP);
            $sheet->setCellValue("I{$row}", $totBJ);

            $sheet->setCellValue("J{$row}", $totLW);
            $sheet->setCellValue("K{$row}", $totLR);
            $sheet->setCellValue("L{$row}", $totLP);
            $sheet->setCellValue("M{$row}", $totLJ);

            $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray($bold);
            $sheet->getStyle("A{$row}")->applyFromArray($center);
            $sheet->getStyle("B{$row}:M{$row}")->getNumberFormat()->setFormatCode('#,##0');
            $sheet->getStyle("B{$row}:M{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

            $sheet->getStyle("E{$row}")->applyFromArray($sumFill);
            $sheet->getStyle("I{$row}")->applyFromArray($sumFill);
            $sheet->getStyle("M{$row}")->applyFromArray($sumFill);

            $endRow = $row;

            $sheet->getStyle("A{$r1}:{$lastCol}{$endRow}")->applyFromArray($bThin);

            $sheet->getColumnDimension('A')->setWidth(16);
            foreach (range('B', 'M') as $c) $sheet->getColumnDimension($c)->setWidth(18);

            $row += 2;
        }

        $filename = 'Laporan_Laba_Rugi' . ($filterTahun ? "_{$filterTahun}" : '') . '.xlsx';

        return response()->streamDownload(function () use ($spreadsheet) {
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        }, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}