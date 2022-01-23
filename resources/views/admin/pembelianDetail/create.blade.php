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
                <li class="breadcrumb-item active" aria-current="page">Data Detail Penerimaan</li>
            </ol>
        </nav>
    </div>
</div>
<!--end breadcrumb-->
<h6 class="mb-0 text-uppercase">Tambah Data Detail Penerimaan</h6>
<hr>
<div class="card">
    <form action="{{route('admin.pembelianDetail.store')}}" method="post" enctype="multipart/form-data">
    <div class="card-body">
            @csrf
        <input type="hidden" value="{{$pembelian->id}}" name="pembelian_id" required readonly>
        <div class="row">
            <div class="mb-3 col">
                <label for="formFile" class="form-label">Sparepart</label>
                <select name="sparepart_id" id="sparepart_id" class="form-select form-select-sm mb-3 select2" required>
                    <option value="">Pilih Sparepart</option>
                    @foreach ($sparepart as $d)
                    <option value="{{$d->id}}" data-beli="{{$d->hargaPokok}}" data-harga="{{$d->hargaJual}}">{{$d->partNumber}} - {{$d->deskripsi}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3 col">
                <label for="formFile" class="form-label">Rak</label>
                <select name="rak_id" id="" class="form-select form-select-sm mb-3 select2" required>
                    <option value="">Pilih Rak</option>
                    @foreach ($rak as $d)
                    <option value="{{$d->id}}">{{$d->kodeLokasi}} - {{$d->gudang}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label for="formFile" class="form-label">Harga Beli/Pcs</label>
                <input class="form-control form-control-sm mb-3" type="number" name="hargaBeli" id="hargaBeli" placeholder="Harga Beli/Pcs" aria-label="default input example" required readonly>
            </div>
            <div class="mb-3 col">
                <label for="formFile" class="form-label">Quantity</label>
                <input class="form-control form-control-sm mb-3" type="number" name="jumlahSj" placeholder="Quantity" aria-label="default input example" required>
            </div>
            <div class="mb-3 col">
                <label for="formFile" class="form-label">Harga Jual/Pcs (+ 20% dari harga beli)</label>
                <input class="form-control form-control-sm mb-3" type="number" name="hargaJual" id="hargaJual" placeholder="Harga Jual/Pcs" aria-label="default input example" required readonly>
            </div>
        </div>
    </div>
    
    <div class="card-footer text-end">
        <button type="submit" class="btn btn-primary px-3 radius-30"><i class="bi bi-save2-fill"></i> Simpan</button>
        <a href="{{route('admin.pembelian.show',$pembelian->id)}}" class="btn btn-danger px-3 radius-30"><i class="bi bi-backspace-fill"></i> Batal</a>
    </div>
    
</form>
</div>
@endsection
@push('script')
    <script>
        $('#sparepart_id').change(function(){
        let harga = $("#sparepart_id").find(':selected').data('harga')
        let beli = $("#sparepart_id").find(':selected').data('beli')

        $('#hargaJual').val(harga)
        $('#hargaBeli').val(beli)
        });
    </script>
@endpush