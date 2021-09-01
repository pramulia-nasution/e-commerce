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
                <div id="load-images"></div>
            </div>
        </x-box>
    </div>
    @include('admin.partials.modal-images')
@endsection

@section('js')
    <script>
        var id = '{{$id}}';
        $(function (){
            loadImages()
        })
                $(document).on('click','#select-image',function (){
                let image_id = $('.thumbnail.selected').children('img').attr('alt');
                $.ajax({
                    url: "{{URL::to('admin/katalog/insert-images')}}",
                    data: {
                        product_id: id,
                        image_id: image_id
                    },
                    type: "POST",
                    dataType: "JSON",
                    beforeSend:function(){
                        Swal.showLoading()
                    },
                    success:function(res){
                    loadImages()
                    msg('success','Gambar telah ditambahkan')
                    },
                    error:function(jqXHR, textStatus, errorThrown){
                        msg('error','Gambar gagal ditambahkan')
                    }
                })
            })
    function loadImages(){
        $('#load-images').empty();
        $.get("{{URL::to('admin/katalog/load-images')}}/"+id,function(res){
            let data = res.data
            let vHtml ='';
            $.each(data,function(key,value){
                vHtml += '<div class="col-xs-4 col-md-2 margin-bottomset"><div class="thumbnail"><div class="caption pull-right">';
                vHtml += '<a class="badge bg-red"  onclick="deleteImage('+value.id+')"><i class="fa fa-trash " aria-hidden="true"></i></a></div>';
                vHtml += '<img  src="/'+value.path+'" alt="..." class="hover"></div></div>';
            })
            $('#load-images').append(vHtml)
        })
    }

    function deleteImage(param){
        Swal.fire({
          title: 'Yakin ingin hapus gambar?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya'
      }).then((res)=>{
          if(res.value){
              $.ajax({
                  url: "{{URL::to('admin/katalog/load-images')}}/"+param,
                  type:"DELETE",
                  success:function(res){
                    loadImages()
                    msg('success','Gambar telah dihapus')
                  },
                  error:function(jqXHR, textStatus, errorThrown){
                      msg('error','Gambar gagal dihapus')
                  }
              });
          }
      });
    }
    </script>
@endsection