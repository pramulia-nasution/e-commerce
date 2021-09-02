@extends('layouts.layoutsAdmin.templateAdmin')

@section('breadcrumb')
    <li> <a href="#"><i class="fa fa-database"></i>Katalog</a></li>
    <li class="active"><i class="fa {{ $icon }}"></i> {{ $title }}</li>
@endsection

@section('css')
<link rel="stylesheet" href="/assets-admin/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<link rel="stylesheet" href="/assets-admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="/assets-admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <style>
        .help-block {
            font-size: 11px;
            margin-bottom: 0;
        }

    </style>
@endsection

@section('content')
    <div class="col-xs-12">
        <x-box class="box-info" title="{{ $desc }}">
            @if (count($errors) > 0)
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color:red">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form class="form-validate" action="{{ route('admin.product.update',$product->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="name" class="control-label">Nama Produk<span style="color:red">*</span></label>
                            <input type="text" autocomplete="off" class="form-control field-validate" value="{{$product->name}}" name="name">
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group">
                            <label for="manufacture_id" class="control-label">Brand Produk</label>
                            <select name="manufacture_id" class="form-control select2">
                                <option value="0">Tanpa Brand</option>
                                @foreach ($result['manufactures'] as $manufacture)
                                    @if ($product->manufacture_id == $manufacture->id)
                                        <option value="{{ $manufacture->id }}" selected>{{ $manufacture->name }}</option>
                                    @else
                                    <option value="{{ $manufacture->id }}">{{ $manufacture->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="help-block">
                                Pilih brand produk, anda dapat menambahkan brand atau pilih tanpa brand jika produk tidak
                                memiliki brand.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                        <div class="form-group">
                            <label for="categories" class="control-label">Kategori Produk<span
                                    style="color:red">*</span></label>
                                    <?php print_r($result['categories']); ?>
                            <span class="help-block">
                                Pilih setidaknya satu kategori
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                            <label for="kind" class="control-label">Jenis Produk</label>
                            <select id="kind" name="kind" class="form-control">
                                <option value="physical">Produk Fisik</option>
                                <option value="digital" {{($product->kind == 'digital') ? 'selected' : ''}}>Produk Digital</option>
                            </select>
                            <span class="help-block">pilih jenis produk yang akan anda tambahkan</span>
                        </div>
                        <div class="form-group">
                            <label for="price" class="control-label">Harga Produk<span style="color:red">*</span></label>
                            <input type="text" autocomplete="off" value="{{ $product->price }}" class="form-control field-validate" onkeypress="return err(this)" name="price">
                            <span class="help-block">input hanya berupa angka</span>
                        </div>
                        <div class="form-group">
                            <label for="model" class="control-label">Model Produk</label>
                            <input type="text" autocomplete="off" class="form-control" value="{{ $product->model }}" name="model">
                            <span class="help-block">input model produk jika ada</span>
                        </div>
                        <div class="form-group">
                            <label for="status" class="control-label">Status Produk</label>
                            <select name="status" class="form-control">
                                <option value="1">Publish</option>
                                <option value="0" {{($product->status == '0') ? 'selected' : ''}}>Draft</option>
                            </select>
                        </div>
                        <div class="form-group" id="imageIcone">
                            <label for="image" class="control-label">Gambar Produk<span style="color:red">*</span></label>
                            <input type="hidden" class="field-validate" name="image_id" value="{{$product->image_id}}" id="image_id">
                            <div id="imagesselected">
                                <button type="button" data-toggle="modal" data-target="#modal-form"
                                    class="btn btn-info">Tambah Gambar</button>
                                <div class="selectedthumbnail" id="selectedthumbnailIcon">
                                    @if(($product->image->path!== null))
                                    <img class="thumbnail" style="max-height: 100px; margin-top: 20px; " src="{{asset($product->image->path)}}">                      
                                @endif
                                </div>
                            </div>
                            <span class="help-block">Gambar utama produk</span>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="container-weight"  style="display:{{$product->kind == 'physical' ? 'block': 'none'}}">
                            <div class="form-group">
                                <label for="weight" class="control-label">Berat Produk<span style="color:red">*</span></label>
                                <input type="text" id="weight" autocomplete="off" class="form-control field-validate" onkeypress="return err(this)" value="{{ $product->weight }}" name="weight">
                                <span class="help-block">input hanya berupa angka tanpa koma dalam satuan gr/gram</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="link" class="control-label">Link Video Produk</label>
                            <input type="text" autocomplete="off" class="form-control"  value="{{ $product->link}}"  name="link">
                            <span class="help-block">anda dapat menambahkan link embed youtube disini</span>
                        </div>
                        <div class="form-group">
                            <label for="status" class="control-label">Produk Unggulan ?</label>
                            <select name="is_feature" class="form-control">
                                <option value="0">Tidak</option>
                                <option value="1" {{($product->is_feature == '1') ? 'selected' : ''}} >Iya</option>
                            </select>
                            <span class="help-block">Apakah produk tersebut termasuk unggulan atau tidak</span>
                        </div>
                        <div class="form-group">
                            <label for="status" class="control-label">Tipe Produk</label>
                            <select id="attribute" name="attribute" class="form-control">
                                <option value="0">Tanpa Atribut</option>
                                <option value="1" {{count($result['option_product']) > 0 ? 'selected' : ''}}>Produk dengan Atribut</option>
                            </select>
                            <span class="help-block">jika produk memiliki atribut, pengaturan tambahan akan ditampilkan setelah produk ini disimpan</span>
                        </div>
                        <div class="container-attribute" style="display:{{count($result['option_product']) > 0 ? 'block' : 'none'}}">
                            <div class="form-group">
                                <label for="attribute" class="control-label">Atribut Produk<span style="color:red">*</span></label>
                                <select id="value-attribute" data-placeholder=" Pilih nilai atribut" name="value_attribute[]" class="form-control select2" multiple="multiple">
                                    @foreach ($result['attributes'] as $attribute)
                                        <optgroup label="{{$attribute->name}}">
                                            @foreach ($attribute->options as $item)
                                                @if (in_array($item->id,$result['option_product']))
                                                    <option value="{{$item->id}}" selected>{{$item->value}}</option>
                                                @else
                                                    <option value="{{$item->id}}">{{$item->value}}</option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <span class="help-block">pilih minimal satu nilai</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="control-label">Flash Sale / Produk Spesial ?</label>
                            <select name="deal" id="deal" class="form-control">
                                @php($deal = $product->deal->type ?? 0);
                                <option value="0">Tidak</option>
                                <option value="1" {{( $deal == '1') ? 'selected' : ''}}>Flash Sale</option>
                                <option value="2" {{( $deal == '2') ? 'selected' : ''}}>Produk Spesial</option>
                            </select>
                        </div>
                        <div class="flash-container" style="display:{{$product->deal != null ? 'block': 'none'}}">
                            <div class="form-group">
                                <label for="name" class="control-label">Harga Penawaran<span style="color:red;">*</span></label>
                                <input class="form-control" autocomplete="off" value="{{$product->deal->price ?? ''}}"  onkeypress="return err(this)" type="text" id="deal_price" name="deal_price">
                                <div class="help-block">harga yang akan ditampilkan pada tampilan produk</div>
                            </div>
                            <div class="form-group">
                                <label>Rentang Waktu<span style="color:red;">*</span></label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                  </div>
                                  <input type="hidden" value="{{$product->deal->start ?? ''}}" id="start" name="start">
                                  <input type="hidden" value="{{$product->deal->end ?? ''}}" id="end" name="end">
                                  <input type="text" value="{{$product->deal->start ?? now()}} - {{$product->deal->end ?? now()}}" name="waktu" class="form-control pull-right" id="reservationtime">
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="description" class="control-label">Deskripsi Produk<span style="color:red;">*</span></label>
                            <textarea name="description" rows="15" class="textarea form-control field-validate"> {{ $product->description }}</textarea>
                            <div class="help-block">tambahkan deskripsi produk anda disini</div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </x-box>
    </div>
    @include('admin.partials.modal-images')
@endsection

@section('js')
<script src="/assets-admin/bower_components/moment/min/moment.min.js"></script>
<script src="/assets-admin/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="/assets-admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="/assets-admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/id.js"></script>

<script>
    $(function(){
        $('.textarea').wysihtml5({
            toolbar: {
                "image":false
            }
        })
    })
     $('#reservationtime').daterangepicker({ 
         timePicker: true, 
         timePickerIncrement: 05,
         language: 'id', 
         locale: { format: 'YYYY-MM-DD hh:mm:ss' }},
         function start(start, end){
            $('#start').val(start.format('YYYY-MM-DD hh:mm:ss'));
            $('#end').val(end.format('YYYY-MM-DD hh:mm:ss'));
     })
</script>
@endsection
