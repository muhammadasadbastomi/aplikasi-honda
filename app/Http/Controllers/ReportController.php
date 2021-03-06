<?php

namespace App\Http\Controllers;


use PDF;
use Carbon\Carbon;
use App\Models\Rak;
use App\Models\Stok;
use App\Models\User;
use App\Models\Promo;
use App\Models\Retur;
use App\Models\Pembelian;
use App\Models\Penjualan;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->now = Carbon::now()->translatedFormat('d F Y');

        $this->ttdName = 'Averoes zulqornein';
    }
    public function kegiatanIndex()
    {
        return view('admin.report.kegiatanIndex');
    }
    public function userAll()
    {
        $data = User::latest()->get();
        $now = $this->now;
        $ttdName = $this->ttdName;
        $pdf = PDF::loadView('admin.user.report.userAll', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua User.pdf');
    }

    public function sparepartAll()
    {
        $data = Sparepart::latest()->get();
        $now = $this->now;
        $ttdName = $this->ttdName;
        $pdf = PDF::loadView('admin.sparepart.report.all', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua Sparepart.pdf');
    }

    public function rakAll()
    {
        $data = Rak::latest()->get();
        $now = $this->now;
        $ttdName = $this->ttdName;
        $pdf = PDF::loadView('admin.rak.report.all', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua Rak.pdf');
    }

    public function stokAll()
    {
        $data = Stok::latest()->get();
        $now = $this->now;
        $ttdName = $this->ttdName;
        $pdf = PDF::loadView('admin.stok.report.all', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua Stok.pdf');
    }

    public function stokLow()
    {
        $data = Stok::where('stok', '<', 5)->get();
        $now = $this->now;
        $ttdName = $this->ttdName;

        $pdf = PDF::loadView('admin.stok.report.low', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Stok Menipis.pdf');
    }

    public function pembelianAll()
    {
        $data = Pembelian::latest()->get();

        $data->map(function ($item) {
            $item['span'] = $item->pembelian_detail->count() + 1;
            return $item;
        });
        $now = $this->now;
        $ttdName = $this->ttdName;
        $pdf = PDF::loadView('admin.pembelian.report.all', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua Pembelian.pdf');
    }

    public function PembelianMonth(Request $request)
    {
        $ttdName = $this->ttdName;
        $now = $this->now;
        $year = $request->year;
        $month = $request->month;

        if (!$year) {
            $tanggalAwal = $request->tanggalAwal;
            $tanggalAkhir = $request->tanggalAkhir;
            $data = Pembelian::whereBetween('tanggalPembelian', [$tanggalAwal, $tanggalAkhir])->get();
            // dd($data);
            $data->map(function ($item) {
                $item['span'] = $item->pembelian_detail->count() + 1;
                $item->pembelian_detail->map(function ($i) {
                    $diskon = $i->diskon;
                    $harga = $i->hargaBeli * $i->jumlahSj;
                    if ($diskon) {
                        $diskonHarga = ($harga * $diskon) / 100;
                        $harga = $harga - $diskonHarga;
                    } else {
                        $diskon = 0;
                    }
                    $i['diskon'] = $diskon;
                    $i['harga'] = $harga;
                    return $i;
                });
                // dd($item->pembelian_detail);
                $item['harga'] = $item->pembelian_detail->sum('harga');
                return $item;
            });

            $pdf = PDF::loadView('admin.pembelian.report.pembelianMonth', ['data' => $data, 'now' => $now, 'year' => $year, 'tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir,]);
        } else {
            // $data = Pembelian::whereBetween('tanggalPembelian', [$tanggalAwal, $tanggalAkhir])->get();
            $data = Pembelian::whereYear('tanggalPembelian', '=', $request->year)->whereMonth('tanggalPembelian', '=', $request->month)->get();
            // dd($data);
            $data->map(function ($item) {
                $item['span'] = $item->pembelian_detail->count() + 1;
                $item->pembelian_detail->map(function ($i) {
                    $diskon = $i->diskon;
                    $harga = $i->hargaBeli * $i->jumlahSj;
                    if ($diskon) {
                        $diskonHarga = ($harga * $diskon) / 100;
                        $harga = $harga - $diskonHarga;
                    } else {
                        $diskon = 0;
                    }
                    $i['diskon'] = $diskon;
                    $i['harga'] = $harga;
                    return $i;
                });
                // dd($item->pembelian_detail);
                $item['harga'] = $item->pembelian_detail->sum('harga');
                return $item;
            });
            switch ($request->month) {
                case '01':
                    $month = 'Januari';
                    break;
                case '02':
                    $month = 'Februari';
                    break;
                case '03':
                    $month = 'Maret';
                    break;
                case '04':
                    $month = 'April';
                    break;
                case '05':
                    $month = 'Mei';
                    break;
                case '06':
                    $month = 'Juni';
                    break;
                case '07':
                    $month = 'Juli';
                    break;
                case '08':
                    $month = 'Agustus';
                    break;
                case '09':
                    $month = 'September';
                    break;
                case '10':
                    $month = 'Oktober';
                    break;
                case '11':
                    $month = 'November';
                    break;
                case '12':
                    $month = 'Desember';
                    break;

                default:
                    # code...
                    break;
            }
            $month = strToUpper($month);
            $pdf = PDF::loadView('admin.pembelian.report.all', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName, 'month' => $month, 'year' => $year]);
        }
        // dd($data);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Penerimaan Bulanan.pdf');
    }

    public function penjualanAll()
    {
        $data = Penjualan::latest()->get();

        $data->map(function ($item) {
            $item['span'] = $item->penjualan_detail->count() + 1;
            $item->penjualan_detail->map(function ($i) {
                $diskon = $i->diskon;
                $harga = $i->hargaJual * $i->jumlah;

                if ($diskon) {
                    $diskonHarga = ($harga * $diskon) / 100;
                    $harga = $harga - $diskonHarga;
                } else {
                    $diskon = 0;
                }
                $i['diskon'] = $diskon;
                $i['harga'] = $harga;
                return $i;
            });
            $item['total'] = $item->penjualan_detail->sum('harga');
            return $item;
        });
        // dd($data);
        $now = $this->now;
        $ttdName = $this->ttdName;
        $pdf = PDF::loadView('admin.penjualan.report.all', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua Penjualan.pdf');
    }

    public function penjualanOne($id)
    {
        $data = Penjualan::whereId($id)->get();

        $data->map(function ($item) {
            $item['span'] = $item->penjualan_detail->count() + 1;
            $item->penjualan_detail->map(function ($i) {
                $diskon = $i->diskon;
                $harga = $i->hargaJual * $i->jumlah;
                if ($diskon) {
                    $diskonHarga = ($harga * $diskon) / 100;
                    $harga = $harga - $diskonHarga;
                } else {
                    $diskon = 0;
                }
                $i['diskon'] = $diskon;
                $i['harga'] = $harga;
                return $i;
            });
            // dd($item->penjualan_detail);
            $item['harga'] = $item->penjualan_detail->sum('harga');
            return $item;
        });
        // dd($data);
        // dd($data->first()->penjualan_detail);
        $now = $this->now;
        $ttdName = $this->ttdName;
        $pdf = PDF::loadView('admin.penjualan.report.one', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Transaksi Penjualan.pdf');
    }



    public function kegiatanYear(Request $request)
    {
        $data = Kegiatan::whereYear('tanggal_kegiatan', '=', $request->year)->get();
        $now = $this->now;
        $year = $request->year;
        $pdf = PDF::loadView('admin.report.kegiatanYear', ['data' => $data, 'now' => $now, 'year' => $year]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Kegiatan Tahunan.pdf');
    }

    public function PenjualanMonth(Request $request)
    {
        // $data = Penjualan::whereYear('tanggalPenjualan', '=', $request->year)->whereMonth('tanggalPenjualan', '=', $request->month)->get();
        $ttdName = $this->ttdName;
        $year = $request->year;
        $month = $request->month;
        $now = $this->now;
        if (!$year) {
            $tanggalAwal = $request->tanggalAwal;
            $tanggalAkhir = $request->tanggalAkhir;
            $data = Penjualan::whereBetween('tanggalPenjualan', [$tanggalAwal, $tanggalAkhir])->get();
            // dd($data);
            $data->map(function ($item) {
                $item['span'] = $item->penjualan_detail->count() + 1;
                $item->penjualan_detail->map(function ($i) {
                    $diskon = $i->diskon;
                    $harga = $i->hargaJual * $i->jumlah;
                    if ($diskon) {
                        $diskonHarga = ($harga * $diskon) / 100;
                        $harga = $harga - $diskonHarga;
                    } else {
                        $diskon = 0;
                    }
                    $i['diskon'] = $diskon;
                    $i['harga'] = $harga;
                    return $i;
                });
                // dd($item->penjualan_detail);
                $item['harga'] = $item->penjualan_detail->sum('harga');
                return $item;
            });

            $pdf = PDF::loadView('admin.penjualan.report.penjualanMonth', ['data' => $data, 'now' => $now, 'year' => $year, 'tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir,]);
        } else {
            $data = Penjualan::whereYear('tanggalPenjualan', '=', $request->year)->whereMonth('tanggalPenjualan', '=', $request->month)->get();
            switch ($request->month) {
                case '01':
                    $month = 'Januari';
                    break;
                case '02':
                    $month = 'Februari';
                    break;
                case '03':
                    $month = 'Maret';
                    break;
                case '04':
                    $month = 'April';
                    break;
                case '05':
                    $month = 'Mei';
                    break;
                case '06':
                    $month = 'Juni';
                    break;
                case '07':
                    $month = 'Juli';
                    break;
                case '08':
                    $month = 'Agustus';
                    break;
                case '09':
                    $month = 'September';
                    break;
                case '10':
                    $month = 'Oktober';
                    break;
                case '11':
                    $month = 'November';
                    break;
                case '12':
                    $month = 'Desember';
                    break;

                default:
                    # code...
                    break;
            }
            $month = strToUpper($month);
            $data->map(function ($item) {
                $item['span'] = $item->penjualan_detail->count() + 1;
                $item->penjualan_detail->map(function ($i) {
                    $diskon = $i->diskon;
                    $harga = $i->hargaJual * $i->jumlah;

                    if ($diskon) {
                        $diskonHarga = ($harga * $diskon) / 100;
                        $harga = $harga - $diskonHarga;
                    } else {
                        $diskon = 0;
                    }
                    $i['diskon'] = $diskon;
                    $i['harga'] = $harga;
                    return $i;
                });
                $item['total'] = $item->penjualan_detail->sum('harga');
                return $item;
            });
            $pdf = PDF::loadView('admin.penjualan.report.all', ['data' => $data, 'now' => $now, 'ttdName' => $ttdName, 'year' => $year, 'month' => $month]);
            // $pdf = PDF::loadView('admin.penjualan.report.penjualanAll', ['data' => $data, 'now' => $now, 'year' => $year, 'tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir,]);
        }

        // dd($data);


        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Kegiatan Bulanan.pdf');
    }

    public function konflikIndex()
    {
        return view('admin.report.konflikIndex');
    }
    public function returAll()
    {
        $data = Retur::latest()->get();
        $now = $this->now;
        $pdf = PDF::loadView('admin.retur.report.all', ['data' => $data, 'now' => $now]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua Retur Barang.pdf');
    }

    public function promoAll()
    {
        $data = Promo::latest()->get();
        $now = $this->now;
        $pdf = PDF::loadView('admin.promo.report.all', ['data' => $data, 'now' => $now]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua Retur Barang.pdf');
    }

    public function PromoMonth(Request $request)
    {
        $ttdName = $this->ttdName;
        $year = $request->year;
        $month = $request->month;
        $now = $this->now;
        // $data = Penjualan::whereYear('tanggalPenjualan', '=', $request->year)->whereMonth('tanggalPenjualan', '=', $request->month)->get();
        $tanggalAwal = $request->tanggalAwal;
        $tanggalAkhir = $request->tanggalAkhir;
        // $data = Promo::whereBetween('tanggalMulai', [$tanggalAwal, $tanggalAkhir])->get();

        if (!$year) {
            $data = Promo::whereBetween('tanggalMulai', [$tanggalAwal, $tanggalAkhir])->get();
            $pdf = PDF::loadView('admin.promo.report.promoMonth', ['data' => $data, 'now' => $now, 'year' => $year, 'tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir,]);
        } else {
            $data = Promo::whereYear('tanggalMulai', '=', $request->year)->whereMonth('tanggalMulai', '=', $request->month)->get();
            switch ($request->month) {
                case '01':
                    $month = 'Januari';
                    break;
                case '02':
                    $month = 'Februari';
                    break;
                case '03':
                    $month = 'Maret';
                    break;
                case '04':
                    $month = 'April';
                    break;
                case '05':
                    $month = 'Mei';
                    break;
                case '06':
                    $month = 'Juni';
                    break;
                case '07':
                    $month = 'Juli';
                    break;
                case '08':
                    $month = 'Agustus';
                    break;
                case '09':
                    $month = 'September';
                    break;
                case '10':
                    $month = 'Oktober';
                    break;
                case '11':
                    $month = 'November';
                    break;
                case '12':
                    $month = 'Desember';
                    break;

                default:
                    # code...
                    break;
            }
            $month = strToUpper($month);
            $pdf = PDF::loadView('admin.promo.report.all', ['data' => $data, 'now' => $now, 'year' => $year, 'month' => $month]);
        }
        // dd($data);



        // $pdf = PDF::loadView('admin.promo.report.promoMonth', ['data' => $data, 'now' => $now, 'year' => $year, 'tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir,]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Promo Bulanan.pdf');
    }

    public function returMonth(Request $request)
    {
        $ttdName = $this->ttdName;
        $year = $request->year;
        $month = $request->month;
        $now = $this->now;

        // $data = Penjualan::whereYear('tanggalPenjualan', '=', $request->year)->whereMonth('tanggalPenjualan', '=', $request->month)->get();
        $tanggalAwal = $request->tanggalAwal;
        $tanggalAkhir = $request->tanggalAkhir;
        if (!$year) {
            $data = Retur::whereBetween('tanggalRetur', [$tanggalAwal, $tanggalAkhir])->get();
            $pdf = PDF::loadView('admin.retur.report.returMonth', ['data' => $data, 'now' => $now, 'year' => $year, 'tanggalAwal' => $tanggalAwal, 'tanggalAkhir' => $tanggalAkhir,]);
        } else {
            $data = Retur::whereYear('tanggalRetur', '=', $request->year)->whereMonth('tanggalRetur', '=', $request->month)->get();
            switch ($request->month) {
                case '01':
                    $month = 'Januari';
                    break;
                case '02':
                    $month = 'Februari';
                    break;
                case '03':
                    $month = 'Maret';
                    break;
                case '04':
                    $month = 'April';
                    break;
                case '05':
                    $month = 'Mei';
                    break;
                case '06':
                    $month = 'Juni';
                    break;
                case '07':
                    $month = 'Juli';
                    break;
                case '08':
                    $month = 'Agustus';
                    break;
                case '09':
                    $month = 'September';
                    break;
                case '10':
                    $month = 'Oktober';
                    break;
                case '11':
                    $month = 'November';
                    break;
                case '12':
                    $month = 'Desember';
                    break;

                default:
                    # code...
                    break;
            }
            $month = strToUpper($month);
            $pdf = PDF::loadView('admin.retur.report.all', ['data' => $data, 'now' => $now, 'year' => $year, 'month' => $month]);
        }
        // dd($data);


        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Kegiatan Bulanan.pdf');
    }

    public function konflikYear(Request $request)
    {
        $data = Konflik::whereYear('tanggal_konflik', '=', $request->year)->get();
        $now = $this->now;
        $year = $request->year;
        $pdf = PDF::loadView('admin.report.konflikYear', ['data' => $data, 'now' => $now, 'year' => $year]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Konflik Tahun.pdf');
    }

    public function konflikMonth(Request $request)
    {
        $data = Konflik::whereYear('tanggal_konflik', '=', $request->year)->whereMonth('tanggal_konflik', '=', $request->month)->get();
        $now = $this->now;
        $year = $request->year;
        switch ($request->month) {
            case '01':
                $month = 'Januari';
                break;
            case '02':
                $month = 'Februari';
                break;
            case '03':
                $month = 'Maret';
                break;
            case '04':
                $month = 'April';
                break;
            case '05':
                $month = 'Mei';
                break;
            case '06':
                $month = 'Juni';
                break;
            case '07':
                $month = 'Juli';
                break;
            case '08':
                $month = 'Agustus';
                break;
            case '09':
                $month = 'September';
                break;
            case '10':
                $month = 'Oktober';
                break;
            case '11':
                $month = 'November';
                break;
            case '12':
                $month = 'Desember';
                break;

            default:
                # code...
                break;
        }
        $month = strToUpper($month);
        $pdf = PDF::loadView('admin.report.konflikMonth', ['data' => $data, 'now' => $now, 'year' => $year, 'month' => $month]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Konflik Bulanan.pdf');
    }

    public function gangguanIndex()
    {
        return view('admin.report.gangguanIndex');
    }
    public function gangguanAll()
    {
        $data = Gangguan::latest()->get();
        $now = $this->now;
        $pdf = PDF::loadView('admin.report.gangguanAll', ['data' => $data, 'now' => $now]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua Gangguan.pdf');
    }

    public function gangguanYear(Request $request)
    {
        $data = Gangguan::whereYear('tanggal_gangguan', '=', $request->year)->get();
        $now = $this->now;
        $year = $request->year;
        $pdf = PDF::loadView('admin.report.gangguanYear', ['data' => $data, 'now' => $now, 'year' => $year]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Gangguan Tahun.pdf');
    }

    public function gangguanMonth(Request $request)
    {
        $data = Gangguan::whereYear('tanggal_gangguan', '=', $request->year)->whereMonth('tanggal_gangguan', '=', $request->month)->get();
        $now = $this->now;
        $year = $request->year;
        switch ($request->month) {
            case '01':
                $month = 'Januari';
                break;
            case '02':
                $month = 'Februari';
                break;
            case '03':
                $month = 'Maret';
                break;
            case '04':
                $month = 'April';
                break;
            case '05':
                $month = 'Mei';
                break;
            case '06':
                $month = 'Juni';
                break;
            case '07':
                $month = 'Juli';
                break;
            case '08':
                $month = 'Agustus';
                break;
            case '09':
                $month = 'September';
                break;
            case '10':
                $month = 'Oktober';
                break;
            case '11':
                $month = 'November';
                break;
            case '12':
                $month = 'Desember';
                break;

            default:
                # code...
                break;
        }
        $month = strToUpper($month);
        $pdf = PDF::loadView('admin.report.gangguanMonth', ['data' => $data, 'now' => $now, 'year' => $year, 'month' => $month]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Gangguan Bulanan.pdf');
    }
    public function kriminalIndex()
    {
        return view('admin.report.kriminalIndex');
    }
    public function kriminalAll()
    {
        $data = Kriminal::latest()->get();
        $now = $this->now;
        $pdf = PDF::loadView('admin.report.kriminalAll', ['data' => $data, 'now' => $now]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Semua Kriminal.pdf');
    }

    public function kriminalYear(Request $request)
    {
        $data = Kriminal::whereYear('tanggal_kejadian', '=', $request->year)->get();
        $now = $this->now;
        $year = $request->year;
        $pdf = PDF::loadView('admin.report.kriminalYear', ['data' => $data, 'now' => $now, 'year' => $year]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Kriminal Tahun.pdf');
    }

    public function kriminalMonth(Request $request)
    {
        $data = Kriminal::whereYear('tanggal_kejadian', '=', $request->year)->whereMonth('tanggal_kejadian', '=', $request->month)->get();
        $now = $this->now;
        $year = $request->year;
        switch ($request->month) {
            case '01':
                $month = 'Januari';
                break;
            case '02':
                $month = 'Februari';
                break;
            case '03':
                $month = 'Maret';
                break;
            case '04':
                $month = 'April';
                break;
            case '05':
                $month = 'Mei';
                break;
            case '06':
                $month = 'Juni';
                break;
            case '07':
                $month = 'Juli';
                break;
            case '08':
                $month = 'Agustus';
                break;
            case '09':
                $month = 'September';
                break;
            case '10':
                $month = 'Oktober';
                break;
            case '11':
                $month = 'November';
                break;
            case '12':
                $month = 'Desember';
                break;

            default:
                # code...
                break;
        }
        $month = strToUpper($month);
        $pdf = PDF::loadView('admin.report.kriminalMonth', ['data' => $data, 'now' => $now, 'year' => $year, 'month' => $month]);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Kriminal Bulanan.pdf');
    }

    public function grafik()
    {
        $now = $this->now;

        $konflik = Konflik::latest()->get()->count();
        $gangguan = Gangguan::latest()->get()->count();
        $kriminal = Kriminal::latest()->get()->count();
        return view('admin.report.grafik', compact('now', 'konflik', 'gangguan', 'kriminal'));
        // $pdf = PDF::loadView('admin.report.grafik', compact('now', 'konflik', 'gangguan', 'kriminal'));
        // $pdf->setPaper('a4', 'landscape');

        // return $pdf->stream('Laporan Grafik Kejadian.pdf');

    }

    public function petugas()
    {
        $now = $this->now;
        $data = Petugas::latest()->get();
        // return view('admin.report.grafik', compact('now', 'konflik', 'gangguan', 'kriminal'));
        $pdf = PDF::loadView('admin.report.petugas', compact('now', 'data'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Data Petugas.pdf');
    }

    public function camat()
    {
        $now = $this->now;
        $data = Camat::latest()->get();
        // return view('admin.report.grafik', compact('now', 'konflik', 'gangguan', 'kriminal'));
        $pdf = PDF::loadView('admin.report.camat', compact('now', 'data'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Data Camat.pdf');
    }

    public function kasi()
    {
        $now = $this->now;
        $data = Kasi::latest()->get();
        // return view('admin.report.grafik', compact('now', 'konflik', 'gangguan', 'kriminal'));
        $pdf = PDF::loadView('admin.report.kasi', compact('now', 'data'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Data Kasi.pdf');
    }

    public function jadwal()
    {
        $now = $this->now;
        $Senin = Jadwal::whereHari('Senin')->get();
        $Selasa = Jadwal::whereHari('Selasa')->get();
        $Rabu = Jadwal::whereHari('Rabu')->get();
        $Kamis = Jadwal::whereHari('Kamis')->get();
        $Jumat = Jadwal::whereHari('Jumat')->get();
        $data = Jadwal::latest()->get();
        $pdf = PDF::loadView('admin.report.jadwal-petugas', compact('now', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'data'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Data Jadwal Petugas.pdf');
    }

    public function suratIndex()
    {
        $petugas = Petugas::latest()->get();
        return view('admin.report.suratIndex', compact('petugas'));
    }
    public function surat(Request $request)
    {
        $now = $this->now;
        $data = Petugas::findOrFail($request->petugas_id);
        $pdf = PDF::loadView('admin.report.surat-tugas', compact('now', 'data'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('Laporan Surat Petugas.pdf');
    }

    public function pegawai()
    {
        $now = $this->now;
        $data = Pegawai::latest()->get();
        // return view('admin.report.grafik', compact('now', 'konflik', 'gangguan', 'kriminal'));
        $pdf = PDF::loadView('admin.report.pegawai', compact('now', 'data'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan Data Pegawai.pdf');
    }

    public function baKegiatan($id)
    {
        $now = $this->now;
        $data = Kegiatan::findOrFail($id);
        $pdf = PDF::loadView('admin.report.BA-kegiatan', compact('now', 'data'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('Berita acara kegiatan.pdf');
    }
    public function baGangguan($id)
    {
        $now = $this->now;
        $data = Gangguan::findOrFail($id);
        $pdf = PDF::loadView('admin.report.BA-gangguan', compact('now', 'data'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('Berita acara gangguan.pdf');
    }
    public function baKriminal($id)
    {
        $now = $this->now;
        $data = Kriminal::findOrFail($id);
        $pdf = PDF::loadView('admin.report.BA-kriminal', compact('now', 'data'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('Berita acara kriminal.pdf');
    }
    public function baKonflik($id)
    {
        $now = $this->now;
        $data = Konflik::findOrFail($id);
        $pdf = PDF::loadView('admin.report.BA-konflik', compact('now', 'data'));
        $pdf->setPaper('a4', 'potrait');

        return $pdf->stream('Berita acara konflik.pdf');
    }
}
