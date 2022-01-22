@extends('layouts.admin')
@section('content')
<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Admin</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="{{route('admin.index')}}"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Data Detail penjualan</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase">Tambah Data Detail Penjualan</h6>
<hr>
<div class="card">
    <form action="{{route('admin.penjualanDetail.store')}}" method="post" enctype="multipart/form-data">
    <div class="card-body">
            @csrf
        <input type="hidden" value="{{$penjualan->id}}" name="penjualan_id" required readonly>
        <div class="row">
            <div class="mb-3 col">
                <label for="formFile" class="form-label">Sparepart</label>
                <select name="sparepart_id" id="sparepart_id" class="form-select form-select-sm mb-3 select2" required>
                    @foreach ($sparepart as $d)
                    <option value="">Pilih Sparepart</option>
                    <option value="{{$d->id}}" data-harga="{{$d->hargaJual}}">{{$d->partNumber}} - {{$d->deskripsi}} | Stok : {{$d->jumlahStok}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label for="formFile" class="form-label">Jumlah (PCS)</label>
                <input class="form-control form-control-sm mb-3" type="number" name="jumlah" placeholder="Jumlah (PCS)" aria-label="default input example" required>
            </div>
            <div class="mb-3 col">
                <label for="formFile" class="form-label">Harga Jual/Pcs</label>
                <input class="form-control form-control-sm mb-3" type="number" id="hargaJual" name="hargaJual" placeholder="Harga Jual/Pcs" aria-label="default input example" required readonly>
            </div>
            <div class="mb-3 col">
                <label for="formFile" class="form-label">Diskon %</label>
                <input class="form-control form-control-sm mb-3" type="number" name="diskon" placeholder="%" aria-label="default input example" >
            </div>
        </div>
    </div>
    
    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary px-3 radius-30"><i class="bi bi-save2-fill"></i> Simpan</button>
        <a href="{{route('admin.penjualan.show',$penjualan->id)}}" class="btn btn-danger px-3 radius-30"><i class="bi bi-backspace-fill"></i> Batal</a>
    </div>
    
</form>
</div>
@endsection
@section('script')
    <script>
        $( "#sparepart_id" ).change(function() {
            hargaJual = $(this).find(':selected').data('harga')

            $('#hargaJual').val(hargaJual);
        });
    </script>
@endsection