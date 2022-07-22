@extends('layouts.admin')
@section('content')
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Admin</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Penerimaan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">Tambah Data Penerimaan</h6>
    <hr>
    <div class="card">
        <form action="{{ route('admin.pembelian.store') }}" method="post" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                <div class="mb-3">
                    <label for="formFile" class="form-label">No Transaksi</label>
                    <input class="form-control form-control-sm mb-3" type="text" name="noTransaksi"
                        value="{{ $noTransaksi }}" placeholder="No Transaksi" aria-label="default input example" required
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Tanggal Penerimaan</label>
                    <input class="form-control form-control-sm mb-3" type="date" name="tanggalPembelian"
                        placeholder="Tanggal Penerimaan" aria-label="default input example" required>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">no Faktur</label>
                    <input class="form-control form-control-sm mb-3" type="text" name="noFaktur" placeholder="no Faktur"
                        aria-label="default input example" required>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary px-3 radius-30"><i class="bi bi-save2-fill"></i>
                    Simpan</button>
                <a href="{{ route('admin.pembelian.index') }}" class="btn btn-danger px-3 radius-30"><i
                        class="bi bi-backspace-fill"></i> Batal</a>
            </div>

        </form>
    </div>


    <h6 class="mb-0 text-uppercase">Tambah Data Detail Penerimaan</h6>
    <hr>
    <div class="card">
        <form action="{{ route('admin.pembelianDetail.store') }}" method="post" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                {{-- <input type="hidden" value="{{ $pembelian->id }}" name="pembelian_id" required readonly> --}}
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Sparepart</label>
                        <select name="sparepart_id" id="sparepart_id" class="form-select form-select-sm mb-3 select2"
                            required>
                            <option value="">Pilih Sparepart</option>
                            @foreach ($sparepart as $d)
                                <option value="{{ $d->id }}" data-beli="{{ $d->hargaPokok }}"
                                    data-harga="{{ $d->hargaJual }}">{{ $d->partNumber }} - {{ $d->deskripsi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Rak</label>
                        <select name="rak_id" id="" class="form-select form-select-sm mb-3 select2" required>
                            <option value="">Pilih Rak</option>
                            @foreach ($rak as $d)
                                <option value="{{ $d->id }}">{{ $d->kodeLokasi }} - {{ $d->gudang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Harga Beli/Pcs</label>
                        <input class="form-control form-control-sm mb-3" type="number" name="hargaBeli" id="hargaBeli"
                            placeholder="Harga Beli/Pcs" aria-label="default input example" required readonly>
                    </div>
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Quantity</label>
                        <input class="form-control form-control-sm mb-3" type="number" name="jumlahSj"
                            placeholder="Quantity" aria-label="default input example" required>
                    </div>
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Harga Jual/Pcs (+ 25% dari harga beli)</label>
                        <input class="form-control form-control-sm mb-3" type="number" name="hargaJual" id="hargaJual"
                            placeholder="Harga Jual/Pcs" aria-label="default input example" required readonly>
                    </div>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary  radius-30"><i class="bi bi-file-plus-fill"></i>
                </button>
                {{-- <a href="{{ route('admin.pembelian.show', $pembelian->id) }}" class="btn btn-danger px-3 radius-30"><i
                        class="bi bi-backspace-fill"></i> Batal</a> --}}
            </div>

        </form>
    </div>
    <h6 class="mb-0 text-uppercase">Data Detail Penerimaan</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example" style="font-size: 11px; font-family: tahoma; width: 100%;"
                                class="table table-striped table-bordered dataTable text-center" role="grid"
                                aria-describedby="example_info">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Part Number</th>
                                        <th>Part Deskripsi</th>
                                        <th>Qty SJ (PCS)</th>
                                        <th>Jumlah RFS</th>
                                        <th>Rak</th>
                                        <th>Harga Beli/Pcs</th>
                                        <th>Total Harga Netto</th>
                                        <th>Harga Jual/Pcs (+ 20% dari harga beli)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pembelianDetail as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->sparepart->partNumber }}</td>
                                            <td>{{ $d->sparepart->deskripsi }}</td>
                                            <td>{{ $d->jumlahSj }}</td>
                                            <td>{{ $d->jumlahRfs }}</td>
                                            <td>{{ $d->rak->kodeLokasi }}</td>
                                            <td class="text-end">@currency($d->sparepart->hargaPokok)</td>
                                            <td class="text-end">@currency($d->totalHarga)</td>
                                            <td class="text-end">@currency($d->hargaJual)</td>
                                            <td>
                                                <div class="btn-group">
                                                    {{-- <a href="{{ route('admin.pembelianDetail.edit', $d->id) }}"
                                                        class="btn btn-primary"><i class="bi bi-pencil-square"></i></a> --}}
                                                    <button type="button" class="btn btn-danger destroy"
                                                        data-bs-toggle="modal"
                                                        data-route="{{ route('admin.pembelianDetail.destroy', $d->id) }}"
                                                        data-bs-target="#destroyModal"><i
                                                            class="bi bi-trash-fill"></i></button>
                                                    {{-- <a href="{{route('admin.pembelianDetail.destroy',$d->id)}}" class="btn btn-primary"><i class="bi bi-trash-fill"></i></a> --}}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.modal.destroy')
@endsection

@push('script')
    <script>
        $('#sparepart_id').change(function() {
            let harga = $("#sparepart_id").find(':selected').data('harga')
            let beli = $("#sparepart_id").find(':selected').data('beli')

            $('#hargaJual').val(harga)
            $('#hargaBeli').val(beli)
        });
    </script>
@endpush
