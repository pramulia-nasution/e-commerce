@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li> <a href="#"><i class="fa fa-database"></i>Katalog</a></li>
    <li class="active"><i class="fa {{$icon}}"></i> {{$title}}</li>
@endsection

@section('css')
<link rel="stylesheet" href="/assets-admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<style>
    .help-block {
        font-size: 11px;
        margin-bottom: 0;
    }

</style>
@endsection

@section('content')
    <div class="col-xs-12">
        <x-box class="box-info" title="{{$desc}}"> 
        @if(count($errors) > 0)
            <ul>
                @foreach($errors->all() as $error)
                <li style="color:red">{{$error}}</li>
                @endforeach
            </ul>
        @endif
            <form enctype="multipart/form-data" class="form-validate" action="{{route('admin.coupon.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="code" class="control-label">Kode Kupon<span style="color:red">*</span></label>
                            <input type="text" class="form-control field-validate" autocomplete="off" value="{{old('code')}}" name="code">
                            <span class="help-block">Kode yang diinput pembeli untuk mendapat potongan harga</span>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Deskripsi Kupon</label>
                            <textarea name="description"class="form-control" rows="1">{{old('description')}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Jumlah Kupon</label>
                             <input type="text" name="coupon_total" onkeypress="return err(this)" value="{{old('coupon_total')}}" class="form-control">
                             <span class="help-block">jumlah kupon tersedia,kosongkan jika tidak ada batasan jumlah</span>
                        </div>
                        <div class="form-group">
                            <label for="expired_date" class="control-label">Tanggal Kadaluarsa<span style="color:red">*</span></label>
                            <input type="text" name="expired_date" autocomplete="off" readonly value="{{old('expired_date')}}" class="form-control datepicker field-validate">
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div class="form-group">
                            <label for="type" class="control-label">Tipe Kupon</label>
                            <select id="type" name="type" class="form-control">
                                <option value="fixed_total">Potongan dalam harga</option>
                                <option value="percent">Potongan dalam persen (%)</option>
                            </select>
                            <span class="help-block">Jenis kupon menentukan jumlah potogan</span>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="control-label">Jumlah Potongan<span style="color:red">*</span></label>
                            <input type="text" name="amount" autocomplete="off" onkeypress="return err(this)" value="{{old('amount')}}" class="form-control field-validate">
                            <span id="help-amount" class="help-block">Input berupa bilangan bulat dalam rupiah</span>
                        </div>
                        <div class="maks-amount" style="display: none">
                            <div class="form-group">
                                <label for="max_amount" class="control-label">Maksimum Potongan</label>
                                <input type="text" name="max_amount" autocomplete="off" onkeypress="return err(this)" value="{{old('max_amount')}}" class="form-control">
                                <span  class="help-block">maksimum potongan harga ketika dalam persen, kosongkan jika tanpa nilai maksimum</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="min_amount" class="control-label">Minimum Total Belanja</label>
                            <input type="text" name="min_amount" autocomplete="off" onkeypress="return err(this)" value="{{old('min_amount')}}" class="form-control">
                            <span  class="help-block">total harga yang ada di keranjang belanja sebelum kupon berlaku, kosongkan jika tanpa minimum belanja</span>
                        </div>
                        <div class="form-group">
                            <label for="limit" class="control-label">Batas penggunaan kupon per pengguna</label>
                            <select id="limit" class="form-control" name="limit">
                                <option value="0">Tak terbatas</option>
                                <option value="1">Ada batasan</option>
                            </select>
                            <span  class="help-block">total penggunaan kupon dengan kode yang sama untuk setiap pengguna</span>
                        </div>
                        <div class="user-limit" style="display: none">
                            <div class="form-group">
                                <label for="user_limit" class="control-label">Jumlah kupon per pengguna<span style="color:red">*</span></label>
                                <input type="text" id="user_limit" name="user_limit" autocomplete="off" onkeypress="return err(this)" value="{{old('user_limit') ?? 0}}" class="form-control">
                                <span  class="help-block">jumlah kupon yang dapat dipakai pengguna dengan kode yang sama</span>
                            </div>
                        </div>
                    </div>
                </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </x-box>
    </div>
@endsection

@section('js')
<script src="/assets-admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script>
    $(function (){
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            startDate: new Date(),
        })
    })
</script>
@endsection