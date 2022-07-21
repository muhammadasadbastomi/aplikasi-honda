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
            <h2 style="text-align:center;">LAPORAN OMSET PENJUALAN BULAN 
            </h2>
            <p style="text-align:center;">{{ strToUpper(carbon\carbon::parse($tanggalAwal )->translatedFormat('d F Y').' - '.carbon\carbon::parse($tanggalAkhir)->translatedFormat('d F Y')) }}</p>
            <br>
            <table id="myTable" class="table table-bordered table-striped dataTable no-footer text-center"
                style="font-size: 12px !important; " role="grid" aria-describedby="myTable_info">
                <thead style="font-size:12px !important;">
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Tanggal Penjualan</th>
                        <th rowspan="2">No Transaksi</th>
                        <th colspan="2" rowspan="2">Nama Customer</th>
                        {{-- <th rowspan="2">Harga</th> --}}
                        {{-- <th rowspan="2">Diskon</th> --}}
                        <th rowspan="2">Total Harga</th>
                    </tr>
                    <tr>
                        {{-- <th>No</th>
                        <th>Part Number</th> --}}
                        {{-- <th>Part Deskripsi</th>
                        <th>Qty SJ (PCS)</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ carbon\carbon::parse($d->tanggalPenjualan)->translatedFormat('d F Y') }}</td>
                            <td>{{ $d->noTransaksi }}</td>
                            <td colspan="2">{{ $d->namaCustomer }}</td>
                            {{-- <td colspan="4"></td> --}}
                            <td>@currency($d->harga)</td>
                            {{-- @foreach ($d->penjualan_detail as $dd) --}}
                        {{-- <tr> --}}
                            {{-- <td>{{ $loop->iteration }}</td> --}}
                            {{-- <td>{{ $dd->sparepart->partNumber }}</td>
                            <td>{{ $dd->sparepart->deskripsi }}</td>
                            <td>{{ $dd->jumlah }}</td>
                            <td>@currency($dd->hargaJual)</td> --}}
                            {{-- @php
                                $ddiskon = $dd->diskon;
                                $harga = $dd->hargaJual * $dd->jumlah;
                                if ($ddiskon) {
                                    $ddiskonHarga = ($harga * $ddiskon) / 100;
                                    $harga = $harga - $ddiskonHarga;
                                } else {
                                    $ddiskon = 0;
                                }
                            @endphp --}}
                            {{-- <td> --}}
                                {{-- {{ $ddiskon }}% --}}
                                {{-- {{ $dd->diskon }}% --}}
                            {{-- </td> --}}
                            {{-- <td>@currency($harga)</td> --}}
                            


                        {{-- </tr> --}}
                    {{-- @endforeach --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <h5 style="text-align: right; font-size:20px;">TOTAL OMSET PENJUALAN : @currency($data->sum('harga'))</h5>
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
