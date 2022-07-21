<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Retur;
use App\Models\Penjualan;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Retur::latest()->get();


        return view('admin.retur.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sparepart = Sparepart::latest()->get();
        $penjualan = Penjualan::all();
        return view('admin.retur.create', compact('sparepart', 'penjualan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        // Retur::create($request->all());

        $input = $req->all();
        if ($req->file) {
            $name = $req->file('file')->getClientOriginalName();

            $req->file('file')->storeAs('public/retur', $name);
            $input['file'] = $name;
        }
        // dd($input);
        $data = Retur::create($input);

        return redirect()->route('admin.retur.index')->withSuccess('Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function show(Retur $retur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function edit(Retur $retur)
    {
        $sparepart = Sparepart::latest()->get();
        return view('admin.retur.edit', compact('retur', 'sparepart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, Retur $retur)
    {
        // $retur->update($request->all());
        $input =  $req->all();
        if ($req->file) {
            $name = $req->file('file')->getClientOriginalName();

            $req->file('file')->storeAs('public/retur', $name);
            $input['file'] = $name;
        }

        $retur->update($input);
        return redirect()->route('admin.retur.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Retur  $retur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Retur $retur)
    {
        try {
            $retur->delete();
            return back()->withSuccess('Data berhasil dihapus');
        } catch (Exception $exception) {
            return back()->withErrors('Data gagal dihapus');
        }
    }
}
