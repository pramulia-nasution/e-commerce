@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li class="active"><i class="fa {{$icon}}"></i> {{$title}}</li>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css">
    <style>
        .space-between{
            margin-bottom: 20px;
        }
    </style> 
@endsection

@section('content')
    <div class="col-xs-12">
        <x-box class="box-info" title="{{$desc}}">
            <form id="form-size">
                <div class="row space-between">
                    <div class="col-md-12"><h4>Thumbnail</h4></div>
                    <div class="col-md-4">
                        <label for="thumb-height" class="control-label">Tinggi</label>
                        <input type="text" class="form-control" name="thumb_height">
                    </div>
                    <div class="col-md-4">
                        <label for="thumb-width" class="control-label">Lebar</label>
                        <input type="text" class="form-control" name="thumb_width">
                    </div>
                </div>
                <div class="row space-between">
                    <div class="col-md-12"><h4>Medium</h4></div>
                    <div class="col-md-4">
                        <label for="medium-height" class="control-label">Tinggi</label>
                        <input type="text" class="form-control" name="medium_height">
                    </div>
                    <div class="col-md-4">
                        <label for="thumb-width" class="control-label">Lebar</label>
                        <input type="text" class="form-control" name="medium_width">
                    </div>
                </div>
                <div class="row space-between">
                    <div class="col-md-12"><h4>Large</h4></div>
                    <div class="col-md-4">
                        <label for="large-height" class="control-label">Tinggi</label>
                        <input type="text" class="form-control" name="large_height">
                    </div>
                    <div class="col-md-4">
                        <label for="large-width" class="control-label">Lebar</label>
                        <input type="text" class="form-control" name="large_width">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" id="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </x-box>
    </div>
@endsection

@section('js')
    <script>
        $(function(){
            getSize()
            $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
            $('#form-size').on('submit',function(e){
                e.preventDefault();
                $('#simpan').text('menyimpan...').attr('disabled',true);
                $.ajax({
                    data: $(this).serialize(),
                    url: "{{route('admin.gambar.size')}}",
                    type: "POST",
                    dataType: "JSON",
                    success:function(){
                        $('#simpan').text('Simpan').attr('disabled',false);
                        Swal.fire('Updated', 'Ukuran berhasil diubah', 'success')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        $('#simpan').text('Simpan').attr('disabled',false);
                        Swal.fire('Error', 'Terjadi kesalahan', 'error')
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                })
            })
        })

        function getSize(){
            $.get("{{route('admin.gambar.size')}}",function (response){
                let data = response.data
                $('[name="thumb_height"]').val(data['thumbnail'][0])
                $('[name="thumb_width"]').val(data['thumbnail'][1])
                $('[name="medium_height"]').val(data['medium'][0])
                $('[name="medium_width"]').val(data['medium'][1])
                $('[name="large_height"]').val(data['large'][0])
                $('[name="large_width"]').val(data['large'][1])
            })
        }
    </script>
@endsection

