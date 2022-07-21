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
                    <li class="breadcrumb-item active" aria-current="page">Data Retur</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase">Edit Data Retur</h6>
    <hr>
    <div class="card">
        <form action="{{ route('admin.retur.update', $retur->id) }}" method="post" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                @method('put')
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile"  class="form-label">Nomor Transaksi</label>
                        <select name="noTransaksi" id="notransaksi" class="select2 form-select form-select-sm mb-3 select2" required>
                            @foreach ($penjualan as $d)
                            <option value="{{ $d->noTransaksi }}" data-tanggal="{{ $d->tanggalPenjualan }}" {{ $d->noTransaksi == $retur->noTransaksi ? 'selected' :''}}>{{ $d->noTransaksi }}</option>
                            @endforeach
                            

                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Tanggal Transaksi</label>
                        <input class="form-control form-control-sm mb-3" id="tanggal"  type="date" name="tanggalTransaksi"
                            placeholder="Tanggal Transaksi" value="{{ $retur->tanggalTransaksi }}" aria-label="default input example" required readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" id="tanggalRetur" class="form-label">Tanggal Retur</label>
                        <input class="form-control form-control-sm mb-3" type="date" name="tanggalRetur"
                            placeholder="Tanggal Transaksi" value="{{ $retur->tanggalRetur }}" aria-label="default input example" required>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Jenis Retur</label>
                        <select name="jenisRetur" id="jenisRetur" class="form-select form-select-sm mb-3 select2" required>
                            <option value="">Pilih Jenis Retur</option>
                            <option value="Pembelian" {{ $retur->jenisRetur == 'Pembelian' ? 'selected' : '' }}>Pembelian
                            </option>
                            <option value="Penjualan" {{ $retur->jenisRetur == 'Pembelian' ? 'selected' : '' }}>Penjualan
                            </option>

                        </select>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Sparepart</label>
                        <select name="sparepart_id" id="sparepart_id" class="form-select form-select-sm mb-3 select2"
                            required>
                            <option value="">Pilih Sparepart</option>
                            @foreach ($sparepart as $d)
                                <option value="{{ $d->id }}" data-harga="{{ $d->hargaJual }}"
                                    {{ $d->id == $retur->sparepart_id ? 'selected' : '' }}>
                                    {{ $d->partNumber }} - {{ $d->deskripsi }}

                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Jumlah Retur</label>
                        <input class="form-control form-control-sm mb-3" type="text" value="{{ $retur->jumlahRetur }}"
                            name="jumlahRetur" placeholder="Jumlah Retur" aria-label="default input example" required>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col">
                        <label for="formFile" class="form-label">Foto Barang Retur (Upload jika ingin mengubah)</label>
                        <input class="form-control form-control-sm mb-3" type="file" name="file"
                            placeholder="Jumlah Retur" aria-label="default input example">
                    </div>
                </div>
            </div>


            <div class="card-footer text-end">
                <button type="submit" class="btn btn-primary px-3 radius-30"><i class="bi bi-save2-fill"></i>
                    Simpan</button>
                <a href="{{ route('admin.retur.index') }}" class="btn btn-danger px-3 radius-30"><i
                        class="bi bi-backspace-fill"></i> Batal</a>
            </div>

        </form>
    </div>
@endsection
@push('script')
    <script>
           $(document).ready(function() {
            $('#notransaksi').change(function(){
                // const tanggal = $(this).data('tanggal');
                let tanggal = $("#notransaksi").find(':selected').data('tanggal')
                $('#tanggal').val(tanggal)
                // alert(tanggal)
            });
        });
    </script>
@endpush
