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
    <x-modal title="">
        <form id="form-stock">
            <div class="modal-body">
                <div class="form-group">
                    <label for="stock" class="control-label">Jumlah Stok</label>
                    <input type="text" autocomplete="off" class="form-control" onkeypress="return err(this)" name="stock">
                </div> 
                <input type="hidden" name="product_id" id="product_id">
                <div class="form-group">
                    <label for="type" class="control-label">Status</label>
                    <select name="type" class="form-control">
                        <option value="in">Stok Masuk</option>
                        <option value="out">Stok Keluar</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
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
                ajax:"{{route('admin.inventory.index')}}",
                columns: [
                    {data:'product_id'},
                    {data:'product.name'},
                    {data:'stock'},
                    {data:'status',orderable:false,searchable:false},
                    {data:'updated_at'},
                    {data:'action',orderable:false,searchable:false}
                ]
            });

            $('#form-stock').on('submit',function (e){
                e.preventDefault()
                $('#submit').text('Mengupdate...').attr('disabled',true);
                $.ajax({
                    data:$(this).serialize(),
                    url: "{{route('admin.inventory.store')}}",
                    type: "POST",
                    dataType:"JSON",
                    success:function(res){
                        console.log(res)
                        tabel.ajax.reload()
                        msg('success','Stock berhasil diperbaharui');
                        $('#modal-form').modal('hide');
                        $('#submit').text('Update').attr('disabled',false);
                    },
                    error:function(err){
                        console.log(err.responseText)
                        msg('error','Stock gagal diperbaharui');
                        $('#modal-form').modal('hide');
                        $('#submit').text('Update').attr('disabled',false);
                    }
                })
            })
        })

        function setStock(id){
            $('#form-stock')[0].reset();
            $('#product_id').val(id);
            $('.modal-title').text('Update Stock');
            $('#submit').text('Update');
            $('#modal-form').modal('show');
        }
    </script>
@endsection