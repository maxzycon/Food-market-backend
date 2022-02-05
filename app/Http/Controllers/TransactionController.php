<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
     /**
     * Download pdf & excel file.
     *
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function export(Request $request)
    {
        $status = $request->post("status",false);
        $type = $request->post("type");
        if ($type === "excel") {
            if ($status) {
                return (new TransactionsExport)->forStatus($status)->download($status."-".date("d-m-Y").".xlsx");
            }
            return (new TransactionsExport)->download("allStatus-".date("d-m-Y").".xlsx");
        }else{
            $nama = "user-pdf-".date("d-m-Y").".pdf";
            $query = Transaction::query();
            $query->join('food', 'transactions.food_id', '=', 'food.id')
                  ->join('users', 'transactions.user_id', '=', 'users.id')
                  ->select(['transactions.id','food.name','users.email','quantity','food_price','total_modal','total_laba','total','status']);

            $query->when($status, function ($q, $status) { 
                $nama = $status."-pdf-".date("d-m-Y").".pdf";
                return $q->where('status',$status);
            });

            $transaction = $query->get();
            $pdf = PDF::loadView('exports.pdf.transaction', compact("transaction","status"))->setPaper("a4","landscape");
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
        $query = Transaction::query()
                            ->join("food","transactions.food_id","=","food.id")
                            ->join("users","transactions.user_id","=","users.id")
                            ->select(['transactions.id','food.name','users.email','quantity','food_price','total_modal','total_laba','total','status']);
        $query->when($request->get("name",false), function ($q, $name) { 
            return $q->where('food.name', 'like',"%{$name}%");
        });
        $query->when($request->get("type",false), function ($q, $type) { 
            return $q->where('status',$type);
        });
        $transaction = $query->paginate(10);
        return view('transactions.index',compact("transaction"));
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
    public function show(Transaction $transaction)
    {
        //
        return view('transactions.detail',[
        'item' => $transaction
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
    public function destroy(Transaction $transaction)
    {
        //
        $transaction->delete();

        return redirect()->route('transactions.index');
        }

        /**
        * @param Request $request
        * @param $id
        * @param $status
        * @return \Illuminate\Http\RedirectResponse
        */
        public function changeStatus(Request $request, $id, $status)
        {
        $transaction = Transaction::findOrFail($id);

        $transaction->status = $status;
        $transaction->save();

        return redirect()->route('transactions.show', $id);
}
}
