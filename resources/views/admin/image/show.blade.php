@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li class="active"><i class="fa {{$icon}}"></i> {{$title}}</li>
@endsection

@section('content')
    <div class="col-xs-12">
        @include('admin.partials.flash-message')
        <x-box class="box-info" title="{{$desc}}">
            @foreach ($images as $image)
                <div class="row">
                    <div class="col-sm-12">
                        <div class="caption">
                            <h2>{{$image->image_type}}  ({{$image->height}} X {{$image->width}})</h2>
                        </div>
                        <div class="thumbnail">
                            <img src="{{asset($image->path)}}" alt="{{$image->height}} X {{$image->width}}">
                            <div class="col-md-6 col-md-offset-3">
                                  @if($image->image_type !='ACTUAL')
                                  <form action="{{route('admin.gambar.generate')}}" class="form-horizontal form-validate" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$image->id}}">
                                        <input type="hidden" name="image_id" value="{{$image->image_id}}">
                                        <div class="caption">
                                            <div class="input-group">
                                                <span class="input-group-addon">Ukuran</span>
                                                <input required type="text" onkeypress="return err(this)" class="form-control" name="height" value="{{$image->height}}">
                                                <span class="input-group-addon">X</span>
                                                <input required type="text" onkeypress="return err(this)" class="form-control" name="width" value="{{$image->width}}">
                                                <span class="input-group-addon" style="padding: 0">
                                                    <button type="submit" class="btn btn-primary">Regenerate</button>
                                                </span>                                                
                                            </div>
                                        </div>
                                </form>
                                  @endif

                              </div>
                            </div>
                    </div>
                </div>
            @endforeach
        </x-box>
    </div>
@endsection
