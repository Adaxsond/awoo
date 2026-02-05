<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
       
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        if ($request->status) {
            if ($request->status === 'telat') {
                $query->where('status', 'dipinjam')
                      ->whereDate('tanggal_jatuh_tempo', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        $peminjaman = $query->latest()->get();

        return view('laporan.laporanindex', compact('peminjaman'));
    }

    public function downloadPdf(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('tanggal_pinjam', [$request->from, $request->to]);
        }

        if ($request->status) {
            if ($request->status === 'telat') {
                $query->where('status', 'dipinjam')
                      ->whereDate('tanggal_jatuh_tempo', '<', now());
            } else {
                $query->where('status', $request->status);
            }
        }

        $peminjaman = $query->latest()->get();

        $pdf = Pdf::loadView('laporan.laporanpdf', compact('peminjaman'));
        return $pdf->download('laporan-peminjaman.pdf');
    }
}
