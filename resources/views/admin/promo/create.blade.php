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
                    <li class="breadcrumb-item active" aria-current="page">Data Promo</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">Tambah Data Promo</h6>
    <hr>
    <div class="card">
        <form action="{{ route('admin.promo.store') }}" method="post" enctype="multipart/form-data">
            <div class="card-body">
                @csrf

                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Sparepart</label>
                        <select name="sparepart_id" id="sparepart_id" class="form-select form-select-sm mb-3 select2"
                            required>
                            <option value="">Pilih Sparepart</option>
                            @foreach ($sparepart as $d)
                                <option value="{{ $d->id }}" data-harga="{{ $d->hargaJual }}">
                                    {{ $d->partNumber }} - {{ $d->deskripsi }} | Stok : {{ $d->jumlahStok }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Judul</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="judul" placeholder="Judul"
                            aria-label="default input example" required>
                    </div>

                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Tanggal Mulai</label>
                        <input class="form-control form-control-sm mb-3" type="date" name="tanggalMulai"
                            placeholder="Tanggal Mulai" aria-label="default input example" required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Tanggal Selesai</label>
                        <input class="form-control form-control-sm mb-3" type="date" name="tanggalSelesai"
                            placeholder="Tanggal Selesai" aria-label="default input example" required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Jumlah Diskon (%)</label>
                        <input class="form-control form-control-sm mb-3" type="text" name="diskon"
                            placeholder="Jumlah Diskon" aria-label="default input example" required>
                    </div>
                </div>

            </div>

            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary px-3 radius-30"><i class="bi bi-save2-fill"></i>
                    Simpan</button>
                <a href="{{ route('admin.promo.index') }}" class="btn btn-danger px-3 radius-30"><i
                        class="bi bi-backspace-fill"></i> Batal</a>
            </div>

        </form>
    </div>
@endsection
