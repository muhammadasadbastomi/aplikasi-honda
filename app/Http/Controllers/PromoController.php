<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Promo;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Promo::latest()->get();


        return view('admin.promo.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sparepart = Sparepart::with('stok')->whereHas('stok')->latest()->get();
        $sparepart->map(function ($item) {

            $item['jumlahStok'] = $item->stok->stok;

            return $item;
        });
        return view('admin.promo.create', compact('sparepart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Promo::create($request->all());

        return redirect()->route('admin.promo.index')->withSuccess('Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function show(Promo $promo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function edit(Promo $promo)
    {
        $sparepart = Sparepart::latest()->get();
        $sparepart->map(function ($item) {

            $item['jumlahStok'] = $item->stok->stok;

            return $item;
        });
        return view('admin.promo.edit', compact('promo', 'sparepart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Promo $promo)
    {
        $promo->update($request->all());
        return redirect()->route('admin.promo.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promo  $promo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promo $promo)
    {
        try {
            $promo->delete();
            return back()->withSuccess('Data berhasil dihapus');
        } catch (Exception $exception) {
            return back()->withErrors('Data gagal dihapus');
        }
    }
}
