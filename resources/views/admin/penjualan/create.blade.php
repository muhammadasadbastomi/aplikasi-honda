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
                    <li class="breadcrumb-item active" aria-current="page">Data penjualan</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">Tambah Data penjualan</h6>
    <hr>
    <div class="card">
        <form action="{{ route('admin.penjualan.store') }}" method="post" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                <div class="mb-3">
                    <label for="formFile" class="form-label">No Transaksi</label>
                    <input class="form-control form-control-sm mb-3" type="text" name="noTransaksi"
                        value="{{ $noTransaksi }}" placeholder="No Transaksi" aria-label="default input example" required
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Tanggal penjualan</label>
                    <input class="form-control form-control-sm mb-3" type="date" name="tanggalPenjualan"
                        placeholder="Tanggal penjualan" aria-label="default input example" required>
                </div>
                <div class="mb-3">
                    <label for="formFile" class="form-label">Nama Customer</label>
                    <input class="form-control form-control-sm mb-3" type="text" name="namaCustomer"
                        placeholder="Nama Customer" aria-label="default input example" required>
                </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary px-3 radius-30"><i class="bi bi-save2-fill"></i>
                    Simpan</button>
                <a href="{{ route('admin.penjualan.index') }}" class="btn btn-danger px-3 radius-30"><i
                        class="bi bi-backspace-fill"></i> Batal</a>
            </div>

        </form>
    </div>
    <h6 class="mb-0 text-uppercase">Tambah Data Detail Penjualan</h6>
    <hr>
    <div class="card">
        <form action="{{ route('admin.penjualanDetail.store') }}" method="post" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                {{-- <input type="hidden" value="{{ $penjualan->id }}" name="penjualan_id" required readonly> --}}
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Sparepart</label>
                        <select name="sparepart_id" id="sparepart_id" class="form-select form-select-sm mb-3 select2"
                            required>
                            <option value="">Pilih Sparepart</option>
                            @foreach ($sparepart as $d)
                                <option value="{{ $d->id }}" data-harga="{{ $d->hargaJual }}"
                                    data-diskon="{{ $d->diskon }}">{{ $d->partNumber }} - {{ $d->deskripsi }} | Stok
                                    :
                                    {{ $d->jumlahStok }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Jumlah (PCS)</label>
                        <input class="form-control form-control-sm mb-3" type="number" name="jumlah"
                            placeholder="Jumlah (PCS)" aria-label="default input example" required>
                    </div>
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Harga Jual/Pcs</label>
                        <input class="form-control form-control-sm mb-3" type="number" id="hargaJual" name="hargaJual"
                            placeholder="Harga Jual/Pcs" aria-label="default input example" required readonly>
                    </div>
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Diskon %</label>
                        <input class="form-control form-control-sm mb-3" type="number" id="diskon" name="diskon"
                            placeholder="%" aria-label="default input example">
                    </div>
            </div>
            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary px-3 radius-30"><i class="bi  bi-file-plus-fill"></i> Tambah</button>
                {{-- <a href="{{ route('admin.penjualan.show', $penjualan->id) }}" class="btn btn-danger px-3 radius-30"><i
                        class="bi bi-backspace-fill"></i> Batal</a> --}}
            </div>

        </form>
    </div>

    <h6 class="mb-0 text-uppercase">Data Detail Penjualan </h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example" class="table table-striped table-bordered dataTable text-center"
                                style="width: 100%;" role="grid" aria-describedby="example_info">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Part Number</th>
                                        <th>Part Deskripsi</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Total Harga</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($penjualanDetail as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->sparepart->partNumber }}</td>
                                            <td>{{ $d->sparepart->deskripsi }}</td>
                                            <td>{{ $d->jumlah }}</td>
                                            <td>@currency($d->hargaJual)</td>
                                            <td>{{ $d->diskon }}%</td>
                                            <td>@currency($d->hargaTotal)</td>
                                            <td>
                                                <div class="btn-group">
                                                    {{-- <a href="{{ route('admin.penjualanDetail.edit', $d->id) }}"
                                                        class="btn btn-primary"><i class="bi bi-pencil-square"></i></a> --}}
                                                    <button type="button" class="btn btn-danger destroy"
                                                        data-bs-toggle="modal"
                                                        data-route="{{ route('admin.penjualanDetail.destroy', $d->id) }}"
                                                        data-bs-target="#destroyModal"><i
                                                            class="bi bi-trash-fill"></i></button>
                                                    {{-- <a href="{{route('admin.penjualanDetail.destroy',$d->id)}}" class="btn btn-primary"><i class="bi bi-trash-fill"></i></a> --}}
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
        $("#sparepart_id").change(function() {
            // alert('tes')
            hargaJual = $(this).find(':selected').data('harga')
            // alert(hargaJual)

            $('#hargaJual').val(hargaJual);

            diskon = $(this).find(':selected').data('diskon')

            if (diskon > 0) {
                $('#diskon').val(diskon);
                $('#diskon').prop('readonly', true);
            } else {
                $('#diskon').val('');
                $('#diskon').prop('readonly', false);
            }
        });
    </script>
@endpush
