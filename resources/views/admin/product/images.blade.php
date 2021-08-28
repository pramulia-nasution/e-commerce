@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li> <a href="#"><i class="fa fa-database"></i>Katalog</a></li>
    <li class="active"><i class="fa {{$icon}}"></i> {{$title}}</li>
@endsection

@section('content')
    <div class="col-xs-12">
        <x-box class="box-info" title="{{$desc}}"> 
            <div class="clearfix" style="margin-bottom: 20px;">
                <button type="button" data-toggle="modal" data-target="#modal-form" class="btn btn-info">Tambah Gambar</button>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 margin-bottomset">
                    <div class="thumbnail">
                        <div class="caption">
                          <a class="badge bg-light-blue editProductImagesModal" href="https://jualkom.com/admin/products/images/editproductimage/32"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                          <a products_id="32" id="32" class="badge bg-red deleteProductImagesModal"><i class="fa fa-trash " aria-hidden="true"></i></a>
                        </div>
                        <img  src="https://jualkom.com/images/media/2021/04/E7yq328508.jpg" alt="..." class="hover">
                         Sort Order : 1
                    </div>
                </div>
            </div>
        </x-box>
    </div>
    @include('admin.partials.modal-images')
@endsection