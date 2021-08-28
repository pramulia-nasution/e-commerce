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
                <form enctype="multipart/form-data" class="form-validate" action="{{route('admin.category.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="parent_id" class="control-label">Jenis Kategori</label>
                        <select name="parent_id" class="form-control">
                                {{print_r($option)}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Kategori<span style="color:red">*</span></label>
                        <input type="text" value="{{old('name')}}" name="name" class="form-control field-validate">
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option value="0">Draft</option>
                            <option value="1">Publish</option>
                        </select>
                    </div>
                    <div class="form-group" id="imageIcone">
                        <label for="image" class="control-label">Gambar<span style="color:red">*</span></label>
                        <input type="hidden" class="field-validate" name="image_id" id="image_id">
                        <div id="imagesselected">
                            <button type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-info">Tambah Gambar</button>
                            <div class="selectedthumbnail" id="selectedthumbnailIcon"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </x-box>
    </div>
    @include('admin.partials.modal-images')
@endsection