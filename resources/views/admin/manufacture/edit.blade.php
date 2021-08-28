@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li> <a href="#"><i class="fa fa-database"></i>Katalog</a></li>
    <li class="active"><i class="fa {{$icon}}"></i> {{$title}}</li>
@endsection

@section('content')
    <div class="col-xs-12">
        <x-box class="box-info" title="{{$desc}}"> 
            <div class="col-xs-12 col-md-6 col-md-offset-3">
                @if(count($errors) > 0)
                    <ul>
                        @foreach($errors->all() as $error)
                            <li style="color:red">{{$error}}</li>
                        @endforeach
                    </ul>
                @endif
                <form enctype="multipart/form-data" class="form-validate" action="{{route('admin.manufacture.update',$manufacture->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Brand<span style="color:red">*</span></label>
                        <input type="text" class="form-control field-validate" value="{{$manufacture->name}}" name="name">
                    </div>
                    <div class="form-group">
                        <label for="url" class="control-label">Link URL</label>
                        <input type="text" class="form-control" value="{{$manufacture->url}}" name="url">
                    </div>
                    <div class="form-group" id="imageIcone">
                        <label for="image" class="control-label">Gambar<span style="color:red">*</span></label>
                        <input type="hidden" class="field-validate" name="image_id" value="{{$manufacture->image_id}}" id="image_id">
                        <div id="imagesselected">
                            <button type="button"  data-toggle="modal" data-target="#modal-form" class="btn btn-info">Ubah Gambar</button>
                            <div class="selectedthumbnail" id="selectedthumbnailIcon">
                                @if(($manufacture->path!== null))
                                    <img class="thumbnail" style="max-height: 100px; margin-top: 20px; " src="{{asset($manufacture->path)}}">                      
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </x-box>
    </div>
    @include('admin.partials.modal-images')
@endsection