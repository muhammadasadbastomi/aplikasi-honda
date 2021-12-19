<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Rak;
use App\Models\Pembelian;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\PembelianDetail;

class PembelianDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $data = PembelianDetail::all();

    //     return view('admin.pembelianDetail.index',compact('data'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pembelian =  Pembelian::findOrFail($id);
        $sparepart = Sparepart::all();
        $rak = Rak::all();
        // $date = Carbon::now()->format('Ym');
        // $noTransaksi = 'RC'.random_int(100000, 999999).$date;
        return view('admin.pembelianDetail.create',compact('pembelian','sparepart','rak'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['jumlahRfs'] = $request->jumlahSj;
        $pembelianDetail = PembelianDetail::create($input);
        return redirect()->route('admin.pembelian.show',$pembelianDetail->pembelian_id)->withSuccess('Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PembelianDetail $pembelianDetail)
    {
        return view('admin.pembelianDetail.index',compact('pembelianDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PembelianDetail $pembelianDetail)
    {
        return view('admin.pembelianDetail.edit',compact('pembelianDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PembelianDetail $pembelianDetail)
    {
        $pembelianDetail->update($request->all());
        return redirect()->route('admin.pembelianDetail.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PembelianDetail  $pembelianDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(PembelianDetail $pembelianDetail)
    {
        try {
            $pembelianDetail->delete();
            return back()->withSuccess('Data berhasil dihapus');
        } catch (Exception $exception) {
            return notify()->warning($exception->getMessage());
        }
    }
}
