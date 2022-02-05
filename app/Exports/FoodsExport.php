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
        $food = Food::select('id','name','price','modal','laba','rate','types')->withSum("transaction",'quantity')->get();
        return view("exports.excel.food",compact("food"));
    }   
}
