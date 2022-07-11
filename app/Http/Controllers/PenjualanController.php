<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\Promo;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Penjualan::latest()->get()->sortByDesc('tanggalPenjualan');


        return view('admin.penjualan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $date = Carbon::now()->format('Ym');
        $noTransaksi = 'SP' . random_int(100000, 999999) . $date;
        $sparepart = Sparepart::with('stok')->whereRelation('stok', 'stok', '>', 0)->get();

        $sparepart->map(function ($item) {
            $now = Carbon::today()->format('Y-m-d');
            $item['jumlahStok'] = $item->stok->stok;
            $item['hargaJual'] = $item->stok->hargaJual;

            $promo = Promo::whereSparepartId($item->id)->where('tanggalMulai', '<=', $now)->where('tanggalSelesai', '>=', $now)->first();

            if ($promo) {
                // if($now->between($promo->tanggalMulai, $promo->tanggalSelesai))
                // {
                $item['diskon'] = $promo->diskon;

                // }
            }
            return $item;
        });
        // dd($sparepart);

        $penjualanDetail = PenjualanDetail::whereNull('penjualan_id')->latest()->get();
        $penjualanDetail->map(function ($item) {
            $diskon = $item->diskon;
            $harga = $item->hargaJual * $item->jumlah;
            if ($diskon) {
                $diskonHarga = $harga * $diskon / 100;
                $harga = $harga - $diskonHarga;
            } else {
                $item['diskon'] = 0;
            }
            $item['hargaTotal'] = $harga;

            return $item;
        });
        return view('admin.penjualan.create', compact('noTransaksi', 'sparepart', 'penjualanDetail'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $penjualan = Penjualan::create($request->all());

        $penjualanDetail = PenjualanDetail::whereNull('penjualan_id')->get();

        foreach ($penjualanDetail as $d) {
            $d->penjualan_id = $penjualan->id;
            $d->update();
        }
        return redirect()->route('admin.penjualan.index')->withSuccess('Data berhasil disimpan');
        // return redirect()->route('admin.penjualanDetail.create', $penjualan->id)->withSuccess('Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        $penjualanDetail = $penjualan->penjualan_detail->map(function ($item) {
            $diskon = $item->diskon;
            $harga = $item->hargaJual * $item->jumlah;
            if ($diskon) {
                $diskonHarga = $harga * $diskon / 100;
                $harga = $harga - $diskonHarga;
            } else {
                $item['diskon'] = 0;
            }
            $item['hargaTotal'] = $harga;

            return $item;
        });
        return view('admin.penjualanDetail.index', compact('penjualan', 'penjualanDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        return view('admin.penjualan.edit', compact('penjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        $penjualan->update($request->all());
        return redirect()->route('admin.penjualan.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        try {
            $penjualan->delete();
            return back()->withSuccess('Data berhasil dihapus');
        } catch (Exception $exception) {
            return back()->withErrors('Data gagal dihapus');
        }
    }
}
