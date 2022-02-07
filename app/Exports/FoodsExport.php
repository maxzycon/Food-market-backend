<?php

namespace App\Exports;

use App\Models\Food;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class FoodsExport implements FromView
{
    /**
    * @return \Illuminate\Support\View
    */
    public function view() :View
    {
        $food = Food::select('id','name','price','modal','laba','rate','types')->withCount([
            'transaction AS transaction_sum_quantity' => function ($query) {
                $query->select(\DB::raw("SUM(quantity) as paidsum"))->whereIN('status', ['ON_DELIVERY','DELIVERED']);
            }
            ])->orderBy("transaction_sum_quantity","desc")->get();
        return view("exports.excel.food",compact("food"));
    }   
}
