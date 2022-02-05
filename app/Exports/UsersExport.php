<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;


class UsersExport implements FromView
{
    use Exportable;

    public function __construct($roles=null)
    {
        $this->roles = $roles;
    }

    public function view() :View
    {
        $query = User::query()->withSum("transaction","total");
        if (empty($this->roles)) {
            $query->orderBy('transaction_sum_total','desc');
            $user = $query->get();
            return view("exports.excel.user",compact("user"));
        }
        
        $query->when($this->roles,function($q,$roles)
        {
            return $q->where("roles",strtoupper($roles));
        });

        $query->orderBy('transaction_sum_total','desc');
        $user = $query->get();
        return view("exports.excel.user",compact("user"));
    }
}
