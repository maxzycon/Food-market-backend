<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodRequest;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\FoodsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;


class FoodController extends Controller
{
     /**
     * Download pdf file.
     *
     * @return Barryvdh\DomPDF\Facade\Pdf
     */

    public function pdf()
    {
        $food = Food::select('id','name','price','modal','laba','rate','types')->withCount([
        'transaction AS transaction_sum_quantity' => function ($query) {
            $query->select(\DB::raw("SUM(quantity) as paidsum"))->whereIN('status', ['ON_DELIVERY','DELIVERED']);
        }
        ])->orderBy("transaction_sum_quantity","desc")->get();
        $pdf = PDF::loadView('exports.pdf.food', compact("food"))->setPaper("a4","landscape");
        return $pdf->stream("food-pdf-".date("d-m-Y").".pdf");
    }
    
    /**
     * Download excel file.
     *
     * @return Maatwebsite\Excel\Facades\Excel
     */

    public function excel(Request $request)
    {
        return Excel::download(new FoodsExport,"food-excel-".date("d-m-Y").".xlsx");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Food::query();
        $query->when($request->get("name",false), function ($q, $name) { 
            return $q->where('name', 'like',"%{$name}%");
        });
        $query->when($request->get("type",false), function ($q, $type) { 
            return $q->where('types','like', "%{$type}%");
        });
        $food = $query->withCount([
        'transaction AS transaction_sum_quantity' => function ($query) {
            $query->select(\DB::raw("SUM(quantity) as paidsum"))->whereIN('status', ['ON_DELIVERY','DELIVERED']);
        }
        ])->orderBy("transaction_sum_quantity","desc")->paginate(10);
        return view('food.index',compact("food"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('food.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FoodRequest $request)
    {
        //
        $data = $request->all();
        $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');
        $data['password'] = Hash::make($request->password);
        $a = $request['price'];
        $b = $request['modal'];
        $data['laba'] = $a-$b;

        Food::create($data);

        return redirect()->route('food.index')->with('success', 'User Berhasil Ditambahkan!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        //
        return view('food.show',[
        'item' => $food
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        //
        return view('food.edit',[
        'item' => $food
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
        //
        $data = $request->all();

        if ($request->file('picturePath')) {
        $data['picturePath'] = $request->file('picturePath')->store('assets/food', 'public');
        }
        $data['password'] = Hash::make($request->password);
        $a = $request['price'];
        $b = $request['modal'];
        $data['laba'] = $a-$b;
        $food->update($data);

        return redirect()->route('food.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->route('food.index');
    }
}
