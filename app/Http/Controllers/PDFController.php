<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;

class PDFController extends Controller
{
    public function cetakPDF($id)
    {
        $laporan = Laporan::where('id_laporan', $id)->firstOrFail();

        $data = [
            'laporan' => $laporan,
            'sekolah' => [
                'nama' => 'SMK Negeri Contoh',
                'alamat' => 'Jl. Pendidikan No.123, Jakarta',
                'logo' => public_path('images/logo-sekolah.png'),
            ],
        ];

        $pdf = Pdf::loadView('pdf.laporanPdf', $data);
        return $pdf->download('laporan-' . $laporan->id_laporan . '.pdf');
    }
}
