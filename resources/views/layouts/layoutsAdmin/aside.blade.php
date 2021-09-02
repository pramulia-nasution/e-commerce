<aside class="main-sidebar">
    <section class="sidebar">
      <div class="user-panel">
        <div class="pull-left image">
          <img src="/assets-admin/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="{{active('admin')}}">
          <a href="{{route('admin.dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li> 
        <li class="treeview {{active('admin/image/*')}} {{active('admin/image')}}">
          <a href="#">
            <i class="fa fa-picture-o"></i>
            <span>Gambar</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{active('admin/image')}}"><a href="{{route('admin.gambar.index')}}"><i class="fa fa-circle-o"></i> List Gambar</a></li>
            <li class="{{active('admin/image/settings')}}"><a href="{{route('admin.gambar.settings')}}"><i class="fa fa-circle-o"></i> Pengaturan Gambar</a></li>
          </ul>
        </li>
        <li class="treeview {{active('admin/katalog/*')}}">
          <a href="#">
            <i class="fa fa-database"></i>
            <span>Katalog</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{active('admin/katalog/manufacture')}} {{active('admin/katalog/manufacture/*')}}"><a href="{{route('admin.manufacture.index')}}"><i class="fa fa-circle-o"></i> Brand</a></li>
            <li class="{{active('admin/katalog/category')}} {{active('admin/katalog/category/*')}}"><a href="{{route('admin.category.index')}}"><i class="fa fa-circle-o"></i> Kategori</a></li>
            <li class="{{active('admin/katalog/attribute')}} {{active('admin/katalog/attribute/*')}}"><a href="{{route('admin.attribute.index')}}"><i class="fa fa-circle-o"></i> Atribut Produk</a></li>
            <li class="{{active('admin/katalog/product')}} {{active('admin/katalog/product/*')}}"><a href="{{route('admin.product.index')}}"><i class="fa fa-circle-o"></i> Produk</a></li>
            <li class="{{active('admin/katalog/inventory')}} {{active('admin/katalog/inventory/*')}}"><a href="{{route('admin.inventory.index')}}"><i class="fa fa-circle-o"></i> Stok Produk</a></li>
            <li class="{{active('admin/katalog/coupon')}} {{active('admin/katalog/coupon/*')}}"><a href="{{route('admin.coupon.index')}}"><i class="fa fa-circle-o"></i> Kupon</a></li>
          </ul>
        </li>
      </ul>
    </section>
  </aside>