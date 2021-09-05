<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel | {{$title}}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link rel="stylesheet" href="/assets-admin/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets-admin/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/assets-admin/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="/assets-admin/dist/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="/assets-admin/styles.css">
  <link rel="stylesheet" href="/assets-admin/bower_components/select2/dist/css/select2.min.css">

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="/assets-admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/image-picker/0.3.1/image-picker.css" integrity="sha512-SMXf5+HiyBHQjtjM3hqAZi0+H8KLyeOEA+gPBKqfOkgbuGTIsb0/sgT7jWQRsBt20TvnoUqM3cDbrIhv6gIiSg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 
  <link rel="stylesheet" href="/assets-admin//dist/css/AdminLTE.min.css">
  
  @yield('css')

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<SCRIPT language=Javascript>
  function err(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode < 48 || charCode > 57)
          return false;
      return true;
  }
  function pf(cr){
    var operations = (cr.which) ? cr.which : cr.keyCode
          if (operations == 43 || operations == 45)
              return true;
          return false;
  }
</SCRIPT>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
  {{-- Header --}}
    @include('layouts.layoutsAdmin.header')
  {{-- Header --}}

  {{-- Asidebar --}}
    @include('layouts.layoutsAdmin.aside')
  {{-- Asidebar --}}

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa {{$icon}}"></i> {{$title}}
        <small>{{$desc}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{route('admin.dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            @yield('breadcrumb')
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
          @yield('content')
        <!-- ./col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>

  <div class="control-sidebar-bg"></div>
</div>


<script src="/assets-admin/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/assets-admin/bower_components/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="/assets-admin/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/assets-admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="/assets-admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/assets-admin/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/assets-admin/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/assets-admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="/assets-admin/bower_components/select2/dist/js/select2.full.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/image-picker/0.3.1/image-picker.min.js" integrity="sha512-76tAVeQq8wkwtFWzKPU03XJGMF/mcLDeBgi9wIlRICXdkLNUYVBiOL3O/R9Bold+u0eN0OUftCcBTjFkchPyBg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="/assets-admin/dist/js/adminlte.min.js"></script>

<script src="/script/common.js"></script>

@yield('js')

<script type="text/javascript">
   $(".select").imagepicker()
   $('.select2').select2({
     width:'100%'
   })
   $(document).ready(function (){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        $('#btn-delete').on('click',function (){
          Swal.fire({
              title: 'Yakin ingin hapus gambar yang di pilih?',
              icon: 'question',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Ya'
            }).then((res)=>{
              if(res.value){
                $.ajax({
                  url: "{{route('admin.gambar.destroy')}}",
                  type:"POST",
                  data: $('#images_form').serialize(),
                  dataType: "JSON",
                  beforeSend:function(){
                    Swal.showLoading()
                  },
                  success:function(res){
                    msg('success','Data telah berhasil dihapus')
                  },
                  error:function(jqXHR, textStatus, errorThrown){
                    msg('error','Data gagal dihapus')
                  }
                });
              }
            });
        })
   })
   const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        width:250,
        timer: 3000,
        timerProgressBar: true,
    })
    function msg(ic,tit){
        Toast.fire({icon: ic,title: tit })
    }

   function deleteData(id,url_id){
      let route = "";
      switch (url_id) {
        case 1:
          route = "{{route('admin.manufacture.index')}}/"+id;
          break;
        case 2:
          route = "{{route('admin.category.index')}}/"+id;
          break;
        case 3:
          route = "{{route('admin.attribute.index')}}/"+id;
          break;
        case 4:
          route = "{{URL::to('admin/katalog/value')}}/"+id;
          break;
        case 5:
          route = "{{route('admin.product.index')}}/"+id;
          break;
        case 6:
          route = "{{route('admin.coupon.index')}}/"+id;
          break;
        default:
          break;
      }
      Swal.fire({
          title: 'Yakin ingin hapus data?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Ya'
      }).then((res)=>{
          if(res.value){
              $.ajax({
                  url: route,
                  type:"DELETE",
                  success:function(res){
                    if(res.data > 0){
                      msg('info', res.params+' tersebut masih terhubung dengan produk, tidak dapat dihapus')
                    }else{
                      tabel.ajax.reload();
                      msg('success','data telah berhasil dihapus')
                    }
                  },
                  error:function(jqXHR, textStatus, errorThrown){
                      msg('error','Data gagal dihapus internal server error')
                  }
              });
          }
      });
}
</script>

</body>
</html>
