<?php

namespace App\Http\Controllers;

use App\Models\KasKeluar;
use App\Models\Transaction;
use App\Exports\KeuntunganExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KeuntunganController extends Controller
{
    public function export(Request $request)
    {
        $tahun = $request->post("tahun1",false);
        $bulan = $request->post("bulan1",false);
        $start = $request->post("start",false);
        $end = $request->post("end",false);
        $type = $request->post("type");

        if ($type === "excel") {
            $nama = empty($tahun) && empty($bulan) ? "allTime.xlsx" : $tahun.'-'. $bulan .'-'.'keuntungan.xlsx';
            return Excel::download(new KeuntunganExport($bulan,$tahun,$start,$end), $nama);
        }else{
            $nama = empty($tahun) && empty($bulan) ? "allTime.pdf" : $tahun.'-'. $bulan .'-'.'keuntungan.pdf';
            $query = Transaction::query();
            $query->when($start, function ($q,$start) { 
                return $q->whereDate('created_at',">=",$start);
            });
            $query->when($end, function ($q,$end) { 
                return $q->whereDate('created_at',"<=",$end);
            });
            $query->when($bulan, function ($q,$bulan) { 
                return $q->whereMonth('created_at', $bulan);
            });
            $query->when($tahun, function ($q,$tahun) { 
                return $q->whereYear('created_at', $tahun);
            });
            $keuntungan = $query->with(['food','user'])->paginate(10);
            $total = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum("total");
            $total_modal = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum('total_modal');
            $total_laba = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum('total_laba');
            $quantity = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum('quantity');
            // kas query
            $query_kas = KasKeluar::query();
            $query_kas->when($start, function ($q,$start) { 
                return $q->whereDate('created_at',">=",$start);
            });
            $query_kas->when($end, function ($q,$end) { 
                return $q->whereDate('created_at',"<=",$end);
            });
            $query_kas->when($bulan, function ($q,$bulan) { 
                return $q->whereMonth('created_at', $bulan);
            });
            $query_kas->when($tahun, function ($q,$tahun) { 
                return $q->whereYear('created_at', $tahun);
            });
            $kasKeluar = $query_kas->get();
            $jumlah_pembelian = $kasKeluar->sum('quantity');
            $total_pengeluaran = $kasKeluar->sum('total');
            $laba_bersih = $total_laba - $total_pengeluaran;
            $pdf = PDF::loadView('exports.pdf.keuntungan', compact("keuntungan","total","total_modal","total_laba","quantity","jumlah_pembelian","total_pengeluaran","laba_bersih"))->setPaper("a4","landscape");
            return $pdf->stream($nama);
        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // transaction query
        $query = Transaction::query();
        $query->when($request->get("bulan",false), function ($q, $bulan) { 
            return $q->whereMonth('created_at', $bulan);
        });
        $query->when($request->get("tahun",false), function ($q, $tahun) { 
            return $q->whereYear('created_at', $tahun);
        });
        $keuntungan = $query->with(['food','user'])->paginate(10);

        $total = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum("total");
        $total_modal = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum('total_modal');
        $total_laba = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum('total_laba');
        $quantity = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum('quantity');

        // kas query
        $query_kas = KasKeluar::query();
        $query_kas->when($request->get("bulan",false), function ($q, $bulan) { 
            return $q->whereMonth('created_at', $bulan);
        });
        $query_kas->when($request->get("tahun",false), function ($q, $tahun) { 
            return $q->whereYear('created_at', $tahun);
        });
        $kasKeluar = $query_kas->get();

        $jumlah_pembelian = $kasKeluar->sum('quantity');
        $total_pengeluaran = $kasKeluar->sum('total');
        $laba_bersih = $total_laba - $total_pengeluaran;

        $bulan = ['januari','februari','maret','april','mei','juli','juni','agustus','september','oktober','november','desember'];
        
        return view('keuntungan.index',compact("keuntungan","total","total_modal","total_laba","quantity","jumlah_pembelian","total_pengeluaran","laba_bersih","bulan"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
