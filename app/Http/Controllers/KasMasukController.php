<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Exports\KasMasukExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KasMasukController extends Controller
{
    public function export(Request $request)
    {
        $type = $request->post("type");
        $start = $request->post("start",false);
        $end = $request->post("end",false);

        if ($type === "excel") {
            return (new KasMasukExport($start,$end))->download("KasMasuk-".date("d-m-Y").".xlsx");
        }else{
            $query = Transaction::query();
            $query->join('food', 'transactions.food_id', '=', 'food.id')
                  ->join('users', 'transactions.user_id', '=', 'users.id')
                  ->orderBy("transactions.total_laba","desc")
                  ->select(['transactions.id','food.name','users.email','quantity','food_price','total_modal','total_laba','total','status']);
            $query->when($start, function($q,$start)
            {
                return $q->whereDate("transactions.created_at",">=",$start);
            });
    
            $query->when($end, function($q,$end)
            {
                return $q->whereDate("transactions.created_at","<=",$end);
            });
            $kasmasuk = $query->get();
            $total = $kasmasuk->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum("total");
            $pdf = PDF::loadView("exports.pdf.kasmasuk",compact("kasmasuk","total","start","end"))->setPaper("a4","landscape");
            return $pdf->stream("KasMasuk-".date("d-m-Y").".pdf");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Transaction::query();
        $query->when($request->get("name",false), function ($q, $name) { 
            return $q->where('user.name', 'like',"%{$name}%");
        });
        
        $query->when($request->get("type",false), function ($q, $type) { 
            return $q->where('status',$type);
        });

        $query->when($request->get("start",false), function ($q) { 
            return $q->whereDate('created_at','>=', request()->get("start"));
        });

        $query->when($request->get("end",false), function ($q) { 
            return $q->whereDate('created_at','<=', request()->get("end"));
        });

        $kasmasuk = $query->with(['food','user'])->paginate(10);
        return view('kasmasuk.index',compact("kasmasuk"));
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
    public function show(Transaction $kasmasuk)
    {
        //
        return view('kasmasuk.detail',[
        'item' => $kasmasuk
        ]);
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
