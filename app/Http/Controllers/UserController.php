<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class UserController extends Controller
{
    /**
     * Download pdf & excel file.
     */

    public function export(Request $request)
    {
        $roles = $request->post("roles1",false);
        $type = $request->post("type");
        if ($type === "excel") {
            if (!empty($roles)) {
                return Excel::download(new UsersExport($roles),strtolower($roles)."-".date("d-m-Y").".xlsx");
            }
            return Excel::download((new UsersExport),"all-".date("d-m-Y").".xlsx");
        }else{
            $nama = "user-pdf-".date("d-m-Y").".pdf";
            $query = User::query()->withSum("transaction","total");
            $query->when($roles,function($q,$roles)
            {
                $nama = "all-pdf-".date("d-m-Y").".pdf";
                return $q->where("roles",strtoupper($roles));
            });
            $user = $query->orderBy("transaction_sum_total","desc")->get();
            $pdf = PDF::loadView('exports.pdf.user', compact("user","roles"))->setPaper("a4","landscape");
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
        //untuk memunculkan listing atau data default

        $query = User::query();
        $query->when($request->get("roles",false), function ($q, $roles) { 
            return $q->where('roles', strtoupper($roles));
        });
        $query->when($request->get("name",false), function ($q, $name) { 
            return $q->where('name','like', "%{$name}%");
        });
        $user = $query->withSum("transaction","total")->paginate(10);
        return view('users.index', compact("user"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('users.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {


        $data = $request->all();
        $data['profile_photo_path'] = $request->file('profile_photo_path')->store('assets/user', 'public');
        $data['password'] = Hash::make($request->password);
        $data['current_team_id'] = 1;

        User::create($data);

        return redirect()->route('users.index')->with('success', 'User Berhasil Ditambahkan!!');

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
    public function edit(User $user)
    {
        //
        return view('users.edit',[
        'item' => $user
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        //
        $data = $request->all();

        if ($request->file('profile_photo_path')) {
        $data['profile_photo_path'] = $request->file('profile_photo_path')->store('assets/user', 'public');
        }
        $data['password'] = Hash::make($request->password);
        // dd($data);
        $user->update($data);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index');
        //
    }
}
