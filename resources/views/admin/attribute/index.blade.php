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
                <a href="{{route('admin.attribute.create')}}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-stripped">
                    <thead>
                        <th width="10%" >ID</th>
                        <th>Nama Atribut</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
        </x-box>
    </div>
    <x-modal title="">
        <form  id="form-value">
            <div class="modal-body">
                <div class="form-group">
                    <label for="value" class="control-label">Nilai</label>
                    <input type="hidden" name="id">
                    <input type="hidden" name="attribute_id">
                    <input type="text" class="form-control" name="value">
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
                ajax:"{{route('admin.attribute.index')}}",
                columns: [
                    {data:'id'},
                    {data:'name'},
                    {data:'options',name:'attributes.options',orderable:false,searchable:false},
                    {data:'action',orderable:false,searchable:false}
                ]
            });
            $('#form-value').on('submit',function (e){
                e.preventDefault();
                $('#submit').text('Memproses...').attr('disabled',true);
                $.ajax({
                    data:$(this).serialize(),
                    url: "{{URL::to('admin/katalog/value')}}",
                    type: "POST",
                    success:function(res){
                        tabel.ajax.reload()
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

        function editValue(id){
            $('#form-value')[0].reset();
            $('.modal-title').text('Ubah Nilai');
            $('#submit').text('Ubah');
            $('#modal-form').modal('show');
            $.get("{{URL::to('admin/katalog/value/edit')}}/"+id,function(res){
                let data = res.data;
                $('[name="id"]').val(data.id);
                $('[name="attribute_id"]').val(data.attribute_id);
                $('[name="value"]').val(data.value);
            })
        }
        
        function tambahValue(id){
            $('#form-value')[0].reset();
            $('.modal-title').text('Tambah Nilai');
            $('#submit').text('Simpan');
            $('#modal-form').modal('show');
            $('[name="attribute_id"]').val(id);
        }
    </script>
@endsection