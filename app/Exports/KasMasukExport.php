<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;

class KasMasukExport implements FromView
{
    use Exportable;
    public function __construct($start=false,$end=false) {
        $this->start = $start;
        $this->end = $end;
    }


    public function view():View
    {
        $query = Transaction::query();
        $query->join('food', 'transactions.food_id', '=', 'food.id')
              ->join('users', 'transactions.user_id', '=', 'users.id')
              ->orderBy("transactions.total_laba","desc")
              ->select(['transactions.id','food.name','users.email','quantity','food_price','total_modal','total_laba','total','status']);

        $query->when($this->start, function($q)
        {
            return $q->whereDate("transactions.created_at",">=",$this->start);
        });

        $query->when($this->end, function($q)
        {
            return $q->whereDate("transactions.created_at","<=",$this->end);
        });

        $kasmasuk = $query->get();
        $total = $kasmasuk->whereIn("status",['ON_DELIVERY','DELIVERED'])->sum("total");
        $start = $this->start;
        $end = $this->end;
        return view("exports.excel.kasmasuk",compact("kasmasuk","total",'start','end'));
    }
}
