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
                    <li class="breadcrumb-item active" aria-current="page">Data Stok</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            {{-- <a href="{{route('admin.stok.create')}}" class="btn btn-primary px-3 radius-30">Tambah Data</a> --}}
            <div class="btn-group">
                <button type="button" class="btn btn-primary px-3 radius-30"><span><i
                            class="glyphicon glyphicon-print"></i></span> Cetak</button>
                <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown"> <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end" px-3 radius-30>
                    <a class="dropdown-item" href="{{ route('admin.report.stokAll') }}" target="_blank">Cetak
                        Keseluruhan</a>
                    <a class="dropdown-item" href="{{ route('admin.report.stokLow') }}" target="_blank">Cetak Stok
                        Menipis</a>
                </div>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">Data Stok</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div id="example_wrapper" style="font-size: 12px; font-family: tahoma;"
                    class="dataTables_wrapper dt-bootstrap5">
                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example" class="table table-striped table-bordered dataTable text-center"
                                style="width: 100%;" role="grid" aria-describedby="example_info">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Gudang</th>
                                        <th>Part Number</th>
                                        <th>Nama Part</th>
                                        <th>Stok</th>
                                        <th>Harga Jual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->rak->gudang }}</td>
                                            <td>{{ $d->sparepart->partNumber }}</td>
                                            <td>{{ $d->sparepart->deskripsi }}</td>
                                            <td>{{ $d->stok }}</td>
                                            <td style="text-align: right;">@currency($d->hargaJual)</td>
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
