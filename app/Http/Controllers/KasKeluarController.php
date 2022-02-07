<?php

namespace App\Http\Controllers;

use App\Exports\KasKeluarExport;
use App\Http\Requests\KasKeluarRequest;
use App\Models\KasKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KasKeluarController extends Controller
{
    public function export(Request $request)
    {
        $type = $request->post("type1");
        $typeE = $request->post("type2");
        
        $start = $request->post("start",false);
        $end = $request->post("end",false);

        if ($typeE === "excel") {
            if ($type) {
                return (new KasKeluarExport)->forType($type)->download('KasKeluar-'.$type."-".date("d-m-Y").".xlsx");
            }
            if ($typeE && $start || $end ) {
                return (new KasKeluarExport)->forType($type)->RangeData($start,$end)->download('KasKeluar-'.$type."-".date("d-m-Y").".xlsx");
            }
            return (new KasKeluarExport)->download("KasKeluar-allType-".date("d-m-Y").".xlsx");
        }else{
            $nama = 'KasKeluar-'."all-".date("d-m-Y").".pdf";
            $query = KasKeluar::query()->select(['id','name','jenis_pengeluaran','supplier','tanggal','quantity','harga','total']);
            
            $query->when($type,function($q,$type)
            {
                $nama = 'KasKeluar-'.$type."-".date("d-m-Y").".pdf";
                return $q->where("jenis_pengeluaran",$type);
            });

            $query->when($start, function ($q) { 
                return $q->whereDate('tanggal','>=', request()->post("start"));
            });

            $query->when($end, function ($q) { 
                return $q->whereDate('tanggal','<=',  request()->post("end"));
            });

            $query->when($type,function($q,$type)
            {
                $nama = 'KasKeluar-'.$type."-".date("d-m-Y").".pdf";
                return $q->where("jenis_pengeluaran",$type);
            });
            $kaskeluar = $query->get();
            $pdf = PDF::loadView('exports.pdf.kaskeluar', compact("kaskeluar","type","start","end"))->setPaper("a4","landscape");
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
        $query = KasKeluar::query();
        $query->when($request->get("name",false), function ($q, $name) { 
            return $q->where('name', 'like',"%{$name}%");
        });
        $query->when($request->get("type",false), function ($q, $type) { 
            return $q->where('jenis_pengeluaran',$type);
        });

        $query->when($request->get("start",false), function ($q,$start) { 
            return $q->whereDate('tanggal','>=', $start);
        });

        $query->when($request->get("end",false), function ($q,$end) { 
            return $q->whereDate('tanggal','<=',  $end);
        });

        $kaskeluar = $query->paginate(10);
        return view('kaskeluar.index', compact("kaskeluar"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('kaskeluar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(KasKeluarRequest $request)
    {
        //
         $data = $request->all();
        //  $a = $request['price'];
        //  $b = $request['modal'];
        //  $data['laba'] = $a-$b;

         KasKeluar::create($data);

         return redirect()->route('kaskeluar.index')->with('success', 'Data Berhasil Ditambahkan!!');
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
    public function edit(KasKeluar $kaskeluar)
    {
        //
        return view('kaskeluar.edit',[
        'item' => $kaskeluar
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KasKeluar $kaskeluar)
    {
        //
        $data = $request->all();

       
        $kaskeluar->update($data);

        return redirect()->route('kaskeluar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(KasKeluar $kaskeluar)
    {
        //
        $kaskeluar->delete();

        return redirect()->route('kaskeluar.index');
    }
}
