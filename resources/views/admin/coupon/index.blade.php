@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li> <a href="#"><i class="fa fa-database"></i>Katalog</a></li>
    <li class="active"><i class="fa {{$icon}}"></i> {{$title}}</li>
@endsection

@section('content')
    <div class="col-xs-12">
        @include('admin.partials.flash-message')
        <x-box class="box-info" title="{{$desc}}">
            <div style="margin-bottom: 20px;">
                <a href="{{route('admin.coupon.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <th>ID</th>
                        <th>Kode Kupon</th>
                        <th>Jumlah Kupon</th>
                        <th>Tipe</th>
                        <th>Jumlah Potongan</th>
                        <th>Deskripsi</th>
                        <th>Kadaluarsa</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
        </x-box>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var tabel;
        $(document).ready(function (e){
            tabel = $('.table').DataTable({
                language:{
                    "url": "/indonesia.json"
                } ,
                processing:true,
                serverSide:true,
                order: [[ 0, "desc" ]],
                ajax:"{{route('admin.coupon.index')}}",
                columns: [
                    {data:'id'},
                    {data:'code'},
                    {data:'coupon_total'},
                    {data:'type'},
                    {data:'amount'},
                    {data:'description'},
                    {data:'expired_date'},
                    {data:'action',orderable:false,searchable:false}
                ]
            });
        })
    </script>
@endsection