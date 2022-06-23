<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Rak;
use App\Models\Stok;
use App\Models\Promo;
use App\Models\Penjualan;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use App\Models\PenjualanDetail;

class PenjualanDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $data = PenjualanDetail::all();

    //     return view('admin.penjualanDetail.index',compact('data'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $penjualan =  Penjualan::findOrFail($id);
        $sparepart = Sparepart::with('stok')->whereRelation('stok','stok', '>', 0)->get();

        
        // dd($now);
        $sparepart->map(function($item){
            $now = Carbon::today()->format('Y-m-d');
            $item['jumlahStok'] = $item->stok->stok;
            $item['hargaJual'] = $item->stok->hargaJual;
            // $tanggalMulai = Carbon::parse($item->tanggalMulai)->format('Y-m-d');
            // $tanggalSelesai = Carbon::parse($item->tanggalSelesai)->format('Y-m-d');
            // dd($now,$tanggalMulai);
            // $tanggalSelesai = Carbon::parse($item->tanggalSelesai);
            $promo = Promo::whereSparepartId($item->id)->where('tanggalMulai','<=',$now)->where('tanggalSelesai','>=',$now)->first();
            // dd($promo->tanggalMulai);
            // $promo = Promo::whereSparepartId($item->id)->where(['tanggalMulai' >= $now])->first();
            if($promo){
                // if($now->between($promo->tanggalMulai, $promo->tanggalSelesai))
                // {
                    $item['diskon'] = $promo->diskon;

                // }
            }
            return $item;
        });
        // dd($sparepart);
        // $ = Carbon::now(/ $ = Carbon::now()->format('Ym');
        // $noTransaksi = 'RC'.random_int(100000, 999999).$date;
        return view('admin.penjualanDetail.create',compact('penjualan','sparepart'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();;
        $stok = Stok::whereSparepartId($request->sparepart_id)->first();
        if($stok->stok < $request->jumlah)
        {
            return back()->withWarning('Stok tidak mencukupi');
        }else{

            $penjualanDetail = PenjualanDetail::create($input);
                $stok->stok = $stok->stok - $penjualanDetail->jumlah;
                $stok->update();
        }


        return redirect()->route('admin.penjualan.show',$penjualanDetail->penjualan_id)->withSuccess('Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PenjualanDetail $penjualanDetail)
    {
        return view('admin.penjualanDetail.index',compact('penjualanDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PenjualanDetail $penjualanDetail)
    {
        $sparepart = Sparepart::with('stok')->whereRelation('stok','stok', '>', 0)->get();

        $sparepart->map(function($item){
            $now = Carbon::today()->format('Y-m-d');
            $item['jumlahStok'] = $item->stok->stok;
            $item['hargaJual'] = $item->stok->hargaJual;

            $promo = Promo::whereSparepartId($item->id)->where('tanggalMulai','<=',$now)->where('tanggalSelesai','>=',$now)->first();

            if($promo){
                // if($now->between($promo->tanggalMulai, $promo->tanggalSelesai))
                // {
                    $item['diskon'] = $promo->diskon;

                // }
            }
            return $item;
        });
        return view('admin.penjualanDetail.edit',compact('penjualanDetail','sparepart'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PenjualanDetail $penjualanDetail)
    {
        $stok = Stok::whereSparepartId($penjualanDetail->sparepart_id)->first();

        // if($stok->stok < $request->jumlah)
        // {
        //     return back()->withWarning('Stok tidak mencukupi');
        // }else{

        //     $penjualanDetail = PenjualanDetail::update($request->all());
        //         $stok->stok = $stok->stok - $penjualanDetail->jumlah;
        //         $stok->update();
        // }
        $jumlahOld = $penjualanDetail->jumlahSj;
        $jumlahNew = $request->jumlahSj;
        if ($jumlahNew < $jumlahOld){
            $diff = $jumlahOld - $jumlahNew;
            $stok->stok = $stok->stok - $diff;
        }else if($jumlahNew > $jumlahOld){
            $diff = $jumlahNew - $jumlahOld;
            $stok->stok = $stok->stok + $diff;
        }
            $stok->hargaJual = $request->hargaJual;
            $stok->update();

        $penjualanDetail->update($request->all());
        // dd($penjualanDetail);
        return redirect()->route('admin.penjualan.show',$penjualanDetail->penjualan_id)->withSuccess('Data berhasil diubah');
        // return redirect()->route('admin.penjualanDetail.index')->withSuccess('Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PenjualanDetail  $penjualanDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(PenjualanDetail $penjualanDetail)
    {
        try {
            $penjualanDetail->delete();
            return back()->withSuccess('Data berhasil dihapus');
        } catch (Exception $exception) {
            return back()->withErrors('Data gagal dihapus');
        }
    }
}
