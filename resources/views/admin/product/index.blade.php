@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li> <a href="#"><i class="fa fa-database"></i>Katalog</a></li>
    <li class="active"><i class="fa {{$icon}}"></i> {{$title}}</li>
@endsection

@section('css')
<style>
    .help-block {
        font-size: 11px;
        margin-bottom: 0;
    }

</style>
@endsection

@section('content')
    <div class="col-xs-12">
        @include('admin.partials.flash-message')
        <x-box class="box-info" title="{{$desc}}">
            <div style="margin-bottom: 20px;">
                <a href="{{route('admin.product.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Kategori</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Berat </th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
        </x-box>
    </div>
    <x-modal title="">
        <form id="option-product">
            <div id="form-body" class="modal-body">
            </div>
            <div class="modal-footer">
                <span style="float: left;color:red" class="help-block">(+) untuk penambahan harga, &nbsp; (-) untuk pengurangan harga </span>
                <button data-dismiss="modal" class="btn btn-default">Tutup</button>
                <button id="submit" class="btn btn-primary" type="submit"></button>
            </div>
        </form>
    </x-modal>
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
                ajax:"{{route('admin.product.index')}}",
                columns: [
                    {data:'id'},
                    {data:'path',orderable:false,searchable:false},
                    {data:'category',name:'products.categories',orderable:false,searchable:false},
                    {data:'name'},
                    {data:'price',render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp. ' )},
                    {data:'weight'},
                    {data:'status'},
                    {data:'action',orderable:false,searchable:false}
                ]
            });

            $('#option-product').on('submit',function(e){
                e.preventDefault();
                $('#submit').text('Memproses...').attr('disabled',true);
                $.ajax({
                    data: $(this).serializeArray(),
                    url: "{{URL::to('admin/katalog/update-option')}}",
                    type: "POST",
                    dataType:"JSON",
                    success:function(res){
                        console.log(res)
                        msg('success','Atribut berhasil diperbaharui')
                        $('#submit').attr('disabled',false);
                        $('#modal-form').modal('hide');
                    },
                    error:function(err){
                        msg('error','Atribut gagal diperbaharui')
                        $('#submit').attr('disabled',false)
                        $('#modal-form').modal('hide')
                    }
                })
            })
        })

        function optionProduct(id){
            $('#option-product')[0].reset();
            $('.modal-title').text('Atur harga atribut produk');
            $('#submit').text('Ubah');
            $('#modal-form').modal('show');
            $('#form-body').empty();
            $.get("{{URL::to('admin/katalog/product-option')}}/"+id,function(res){
                let data = res.data
                console.log(data)
                let vHtml = '';
                $.each(data,function(key, data){
                    vHtml += '<div class="form-group"><label class="control-label">'+data.value+'</label>';
                    vHtml += '<input type="hidden" name="id[]" value="'+data.pivot.id+'">';
                    vHtml += '<div class="row"><div class="col-xs-6">';
                    vHtml += '<input class="form-control" onkeypress="return err(this)" type="text" name="value[]" value="'+data.pivot.option_price+'">';
                    vHtml += '<span class="help-block">selisih dengan harga awal produk</span></div>';
                    vHtml += '<div class="col-xs-2"> <select class="form-control" name="prefix[]">';
                    if(data.pivot.price_prefix == '+')
                        vHtml += '<option value="+" selected>+</option><option value="-">-</option>';
                    else
                        vHtml += '<option value="+">+</option><option value="-" selected>-</option>';
                    vHtml += '</select></div></div></div>';
                });
                $('#form-body').append(vHtml)
            })
        }
    </script>
@endsection