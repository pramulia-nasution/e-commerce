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
                <form class="form-validate" action="{{route('admin.attribute.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="control-label">Nama Atribut<span style="color:red">*</span></label>
                        <input type="text" value="{{old('name')}}" name="name" class="form-control field-validate">
                    </div>
                    <div class="form-group after-add-more">
                        <label class="control-label" for="value">Nilai<span style="color:red">*</span></label>
                        <div class="input-group margin">
                            <input type="text" name="value[]" class="form-control field-validate">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-info btn-flat add-more"><i class="fa fa-plus"></i></button>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                <div class="copy hide">
                    <div class="form-group">
                        <div class="input-group margin">
                            <input type="text" name="value[]" class="form-control">
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-danger btn-flat remove"><i class="fa fa-trash"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </x-box>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function (){
            $('.add-more').on('click',function(){
                var html = $('.copy').html();
                $(".after-add-more").after(html);
            })
            $("body").on("click",".remove",function(){ 
                $(this).parents(".form-group").remove();
            })
        })
    </script>
@endsection