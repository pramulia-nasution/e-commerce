@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li class="active"><i class="fa {{$icon}}"></i> {{$title}}</li>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/min/dropzone.min.css"> 
@endsection

@section('content')
<style>
    article, aside, figure, footer, header, hgroup,
    menu, nav, section { display: block; }
    ul { list-style: none; }
    ul li { display: inline; }
    img { border: 2px solid white; cursor: pointer; }
    img:hover { border: 2px solid black; }
    img.hover { border: 2px solid black; }
    .margin-bottomset .thumbnail { margin-bottom: 0; }
  </style>
    <div class="col-xs-12">
        <x-box class="box-info" title="{{$desc}}">
            <div style="margin-bottom: 20px;">
                <button data-toggle="modal" data-target="#modal-form" class="btn btn-info"><i class="fa fa-plus"></i> Tambah</button>
                <a href="{{route('admin.gambar.index')}}"  class="btn btn-warning"><i class="fa fa-refresh"></i> Reload</a>
            </div>
            <div class="row">
                @if(isset($images))
                    @foreach($images as $image)
                    <div class="col-xs-4 col-md-2 margin-bottomset">
                        <div class="thumbnail thumbnail-imges">
                            <img class="test_image" image_id="{{$image->image_id}}" src="{{asset($image->path)}}" alt="...">
                        </div>
                        <a class="btn btn-block btn-primary" href="{{url('admin/media/detail')}}/{{$image->image_id}}"> Detail Gambar</a>
                    </div>
                    @endforeach
                @endif
            </div>
        </x-box>
    </div>
<x-modal title="Tambah Gambar">
    <div class="modal-body">
        <form method="post" action="{{route('admin.gambar.store')}}" enctype="multipart/form-data"
          class="dropzone" id="dropzone">
        @csrf
    </form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
    </div>
</x-modal>
@endsection

@section('js')
<script type="text/javascript">
   $(function (){
        Dropzone.options.dropzone =
        {
            maxFilesize: 10,
            renameFile: function (file) {
                var dt = new Date();
                var time = dt.getTime();
                return time + file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 60000,
            success: function (file, response) {
                console.log(response);
            },
            error: function (file, response) {
                return false;
            }
        };
   })

</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.0/dropzone.js"></script>
@endsection
