<?php

namespace App\Exports;

use App\Models\KasKeluar;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;

class KasKeluarExport implements FromView
{
    use Exportable;

    public function forType($type = false)
    {
        $this->type = $type;   
        return $this;
    }

    public function RangeData($start = false,$to = false)
    {
        $this->start = $start;   
        $this->to = $to;   
        return $this;
    }

    /**
    * @return \Illuminate\Support\view
    */
    public function view() :View
    {
        $query = KasKeluar::query()->select(['id','name','jenis_pengeluaran','supplier','tanggal','quantity','harga','total']);
        if (empty($this->type) && empty($this->start) && empty($this->to)) {
            $kaskeluar = $query->get();
            return view("exports.excel.kaskeluar",compact("kaskeluar"));
        }
        $query->when($this->start,function($q)
        {
            return $q->whereDate("tanggal",">=",$this->start);
        });

        $query->when($this->to,function($q)
        {
            return $q->whereDate("tanggal","<=",$this->to);
        });

        $query->when($this->type,function($q,$type)
        {
            return $q->where("jenis_pengeluaran",$this->type);
        });
        $kaskeluar = $query->get();
        $start = $this->start;
        $end = $this->to;
        return view("exports.excel.kaskeluar",compact("kaskeluar","start","end"));
    }
}
