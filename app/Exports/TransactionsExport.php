<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class TransactionsExport implements FromView
{
    use Exportable;

    public function forStatus(String $status)
    {
        $this->status = $status ?? false;
        return $this;
    }

    public function view():View
    {
        $query = Transaction::query();
        $query->join('food', 'transactions.food_id', '=', 'food.id')
              ->join('users', 'transactions.user_id', '=', 'users.id')
              ->select(['transactions.id','food.name','users.email','quantity','food_price','total_modal','total_laba','total','status']);
        if (empty($this->status)) {
            $transaction = $query->get();
            return view("exports.excel.transaction",compact("transaction"));
        }
        $query->when($this->status, function ($q, $status) { 
            return $q->where('status',$status);
        });
        $transaction = $query->get();
        return view("exports.excel.transaction",compact("transaction"));
    }
}
