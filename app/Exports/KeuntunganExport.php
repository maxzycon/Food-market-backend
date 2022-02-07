<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use App\Models\Transaction;
use App\Models\KasKeluar;

class KeuntunganExport implements FromView
{
    // use Exportable;
    protected $bulan,$tahun;

    public function __construct($bulan = false,$tahun = false,$start=false,$end=false)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->start = $start;
        $this->end = $end;
    }

    public function view():View
    {
        $query = Transaction::query();
        
        $query->when($this->start, function ($q) { 
            return $q->whereDate('created_at',">=",$this->start);
        });

        $query->when($this->end, function ($q) { 
            return $q->whereDate('created_at',"<=",$this->end);
        });

        $query->when($this->bulan, function ($q) { 
            return $q->whereMonth('created_at', $this->bulan);
        });
        $query->when($this->tahun, function ($q) { 
            return $q->whereYear('created_at', $this->tahun);
        });

        $keuntungan = $query->with(['food','user'])->paginate(10);

        $total = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum("total");
        $total_modal = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum('total_modal');
        $total_laba = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum('total_laba');
        $quantity = $keuntungan->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum('quantity');

        // kas query
        $query_kas = KasKeluar::query();
        
        $query_kas->when($this->start, function ($q) { 
            return $q->whereDate('created_at',">=",$this->start);
        });

        $query_kas->when($this->end, function ($q) { 
            return $q->whereDate('created_at',"<=",$this->end);
        });

        $query_kas->when(!empty($this->bulan) ?? $this->bulan, function ($q) { 
            return $q->whereMonth('created_at', $this->bulan);
        });
        
        $query_kas->when(!empty($this->tahun) ?? $this->tahun, function ($q) { 
            return $q->whereYear('created_at', $this->tahun);
        });

        $kasKeluar = $query_kas->get();
        $jumlah_pembelian = $kasKeluar->sum('quantity');
        $total_pengeluaran = $kasKeluar->sum('total');
        $laba_bersih = $total_laba - $total_pengeluaran;
        $bulan =$this->bulan;
        $tahun =$this->tahun;
        $start =$this->start;
        $end =$this->end;
        return view('exports.excel.keuntungan',compact("bulan","tahun","start","end","keuntungan","total","total_modal","total_laba","quantity","jumlah_pembelian","total_pengeluaran","laba_bersih"));
    }
}
