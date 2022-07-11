<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Rak;
use App\Models\Pembelian;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\PembelianDetail;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Pembelian::latest()->get()->sortByDesc('tanggalPembelian');

        return view('admin.pembelian.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $date = Carbon::now()->format('Ym');
        $noTransaksi = 'RC' . random_int(100000, 999999) . $date;
        $sparepart = Sparepart::latest()->get();
        $sparepart->map(function ($item) {
            $value = $item->hargaPokok * 25 / 100;
            $item['hargaJual'] = $item->hargaPokok + $value;
            return $item;
        });
        $rak = Rak::latest()->get();


        $pembelianDetail = PembelianDetail::whereNull('pembelian_id')->latest()->get();
        $pembelianDetail->map(function ($item) {
            $item['totalHarga'] = $item->hargaBeli * $item->jumlahSj;

            $item['hargaJual'] = $item->sparepart->stok->hargaJual;

            return $item;
        });
        return view('admin.pembelian.create', compact('noTransaksi', 'sparepart', 'rak', 'pembelianDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pembelian = Pembelian::create($request->all());
        $pembelianDetail = PembelianDetail::whereNull('pembelian_id')->get();

        foreach ($pembelianDetail as $d) {
            $d->pembelian_id = $pembelian->id;
            $d->update();
        }

        // return redirect()->route('admin.pembelian.show', $pembelian->id)->withSuccess('Data berhasil disimpan');
        return redirect()->route('admin.pembelian.index', $pembelian->id)->withSuccess('Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        $pembelianDetail = $pembelian->pembelian_detail->map(function ($item) {
            $item['totalHarga'] = $item->hargaBeli * $item->jumlahSj;

            $item['hargaJual'] = $item->sparepart->stok->hargaJual;

            return $item;
        });
        return view('admin.pembelianDetail.index', compact('pembelian', 'pembelianDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        return view('admin.pembelian.edit', compact('pembelian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        $pembelian->update($request->all());
        return redirect()->route('admin.pembelian.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        try {
            $pembelian->delete();
            return back()->withSuccess('Data berhasil dihapus');
        } catch (Exception $exception) {
            return back()->withErrors('Data gagal dihapus');
        }
    }
}
