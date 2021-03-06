<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        h4,
        h2 {
            font-family: serif;
        }

        body {
            font-family: sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            text-align: center;
        }

        td {
            text-align: center;
        }

        br {
            margin-bottom: 5px !important;
        }

        .judul {
            text-align: center;
        }

        .header {
            margin-bottom: 0px;
            text-align: center;
            height: 110px;
            padding: 0px;
        }

        .pemko {
            width: 120px;
        }

        .logo {
            float: left;
            margin-right: 0px;
            width: 18%;
            padding: 0px;
            text-align: right;
        }

        .headtext {
            float: right;
            margin-left: 0px;
            width: 72%;
            padding-left: 0px;
            padding-right: 10%;
        }

        hr {
            margin-top: 10%;
            height: 3px;
            background-color: black;
            width: 100%;
        }

        .ttd {
            margin-left: 65%;
            text-align: center;
            text-transform: uppercase;
        }

        .text-right {
            text-align: right;
        }

        .isi {
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">
            <img class="pemko" src="ART.png">
        </div>
        <div class="headtext">
            <h2 style="margin:0px;">BENGKEL RESMI HONDA AHASS HAJI AS </h2>
            <h3 style="margin:0px;">KECAMATAN BANJARMASIN SELATAN </h3>
            <p style="margin:0px;">Kelayan Sel., Kec. Banjarmasin Sel., Kota Banjarmasin, Kalimantan Selatan 70111
            </p>
        </div>
        <br>
    </div>
    <div class="container">
        <hr style="margin-top:1px;">
        <div class="isi">
            <h2 style="text-align:center;">NOTA PENJUALAN</h2>
            <h5 style="text-align:left;">NAMA CUSTOMER &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp;:
                {{ strtoupper($data->first()->namaCustomer) }}
            </h5>
            <h5 style="text-align:left;">NO TRANSAKSI &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:
                {{ strtoupper($data->first()->noTransaksi) }}</h5>
            {{-- carbon\carbon::parse($d->tanggalPenjualan)->translatedFormat('d F Y') --}}
            <h5 style="text-align:left;">TANGGAL PENJUALAN &nbsp; :
                {{ strtoupper(carbon\carbon::parse($data->first()->tanggalPenjualan)->translatedFormat('d F Y')) }}
            </h5>

            <br>
            <table id="myTable" class="table table-bordered table-striped dataTable no-footer text-center"
                style="font-size: 12px !important; " role="grid" aria-describedby="myTable_info">
                <thead style="font-size:12px !important;">
                    <tr>
                        {{-- <th rowspan="2">No</th> --}}
                        <th></th>
                        <th></th>
                        {{-- <th>No Transaksi</th> --}}
                        <th colspan="2"></th>
                        <th rowspan="3">Harga</th>
                        <th rowspan="3">Diskon</th>
                        <th rowspan="3">Total Harga</th>
                        {{-- <th rowspan="{{ $data->sum('span') + 2 }}">Total Keseluruhan</th> --}}
                    </tr>
                    <tr>
                        <th>No</th>
                        <th>Part Number</th>
                        <th>Part Deskripsi</th>
                        <th>Qty SJ (PCS)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            {{-- <td rowspan="{{ $d->span }}">{{ $loop->iteration }}</td> --}}
                            {{-- <td>{{ carbon\carbon::parse($d->tanggalPenjualan)->translatedFormat('d F Y') }}</td> --}}
                            <td></td>
                            <td></td>
                            {{-- <td colspan="2">{{ $d->namaCustomer }}</td> --}}
                            <td colspan="2"></td>
                            @foreach ($d->penjualan_detail as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $d->sparepart->partNumber }}</td>
                            <td>{{ $d->sparepart->deskripsi }}</td>
                            <td>{{ $d->jumlah }}</td>
                            <td style="text-align: right;">@currency($d->hargaJual)</td>
                            {{-- @php
                                $diskon = $d->diskon;
                                $harga = $d->hargaJual * $d->jumlah;
                                if ($diskon) {
                                    $diskonHarga = ($harga * $diskon) / 100;
                                    $harga = $harga - $diskonHarga;
                                } else {
                                    $diskon = 0;
                                }
                            @endphp --}}
                            <td>
                                {{-- {{ $diskon }}% --}}
                                {{ $d->diskon }}%
                            </td>
                            {{-- <td style="text-align: right;">@currency($harga)</td> --}}
                            <td style="text-align: right;">@currency($d->harga)</td>


                        </tr>
                    @endforeach
                    {{-- <tr>
                        <td colspan="2">TOTAL HARGA</td>
                        <td colspan="2">@C</td>
                    </tr> --}}
                    {{-- <td colspan="8">Total Harga</td>
                    <td style="text-align: right;">@currency($data->sum('harga'))</td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h5 style="text-align:right; font-size:20px">TOTAL HARGA : @currency($data->sum('harga'))</h5>
            <br>
            <br>
            <div class="ttd">
                <p style="margin:0px"> Banjarmasin, {{ $now }}</p>
                {{-- <h6 style="margin:0px">Mengetahui</h6>
                <h5 style="margin:0px">Manager</h5>
                <br>
                <br>
                <h5 style="text-decoration:underline; margin:0px">{{$ttdName}}</h5> --}}
                {{-- <h5 style="margin:0px">NIP. 19710830 199101 1 002</h5> --}}
            </div>
        </div>
    </div>
</body>

</html>
