@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li> <a href="#"><i class="fa fa-database"></i>Katalog</a></li>
    <li class="active"><i class="fa {{$icon}}"></i> {{$title}}</li>
@endsection

@section('content')
    <div class="col-xs-12">
        @include('admin.partials.flash-message')
        <x-box class="box-info" title="{{$desc}}">
            <div class="table-responsive">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <th>ID</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Status Stok</th>
                        <th>Perubahan Terakhir (WIB)</th>
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
        var id = "{{$id}}";
        $(document).ready(function (e){
            tabel = $('.table').DataTable({
                language:{
                    "url": "/indonesia.json"
                } ,
                processing:true,
                serverSide:true,
                order: [[ 0, "desc" ]],
                ajax:"{{URL::to('admin/katalog/inventory')}}"+'/'+id,
                columns: [
                    {data:'product_id'},
                    {data:'product.name'},
                    {data:'stock'},
                    {data:'status',orderable:false,searchable:false},
                    {data:'updated_at'},
                    {data:'action',orderable:false,searchable:false}
                ]
            });
        })
    </script>
@endsection