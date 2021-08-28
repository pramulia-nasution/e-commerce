<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Images\ImagesRepository;
use App\Repositories\Products\ProductsRepository;
use App\Repositories\Categories\CategoriesRepository;
use App\Repositories\Attributes\AttributesRepository;
use App\Repositories\Manufactures\ManufacturesRepository;

class ProductController extends Controller
{
    function __construct(ManufacturesRepository $manufacture, CategoriesRepository $category, ImagesRepository $image, AttributesRepository $attribute, ProductsRepository $product){
        $this->product = $product;
        $this->manufacture = $manufacture;
        $this->category = $category;
        $this->image = $image;
        $this->attribute = $attribute;
    }

    public function index(){
        $header = [
            'title' => 'Produk',
            'desc'  => 'List Produk',
            'icon'  => 'fa-cubes'
        ];
        if(request()->ajax()){  
            $products = $this->product->pagingAllProducts(); 
            return DataTables::of($products)
            ->editColumn('path',function ($item){
                return '<img style="max-width:100px" src="/'.$item->image->path.'">';
            })
            ->editColumn('category', function ($item){
                return $item->categories->map(function ($category){
                    return '<span class="label label-default">'.$category->name.'</span>';
                })->implode('<br>');
            })
            ->editColumn('status',function ($item){
                if($item->status == '1')
                    return '<span class="label bg-green">Publish</span>';
                else
                    return '<span class="label bg-yellow">Draft</span>';
            })
            ->editColumn('name',function ($item){
                if($item->model != null)
                    return $item->name.' ('.$item->model.')';
                else
                    return $item->name;
            })
            ->editColumn('weight',function ($item){
                return $item->weight.' gr';
            })
            ->addColumn('action',function($item){
                $plus = '';
                if($item->type == '1')
                    $plus = '<a title="Atur Atribut" href="#" onclick="optionProduct('.$item->id.')" style="color:white;cursor:pointer;margin-bottom:3px;" class="btn bg-purple btn-sm"><i class="fa fa-folder"></i></a><br>';
                return '<a title="Ubah" href="/admin/katalog/product/'.$item->id.'/edit" style="color:white;cursor:pointer;margin-bottom:3px;" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a><br>'.
                $plus.
                '<a title="Atur Gambar" href="/admin/katalog/product/'.$item->id.'/images" style="color:white;cursor:pointer;margin-bottom:3px;" class="btn bg-navy btn-sm"><i class="fa fa-picture-o"></i></a><br>'.
                '<a title="Hapus" style="color:white;cursor:pointer" onclick="deleteData('.$item->id.',5)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['path','category','status','info','action'])
            ->make(true);
        }
        return view('admin.product.index',$header);
    }

    public function create(){
        $header = [
            'title' => 'Produk',
            'desc'  => 'Tambah Produk',
            'icon'  => 'fa-cubes'
        ];
        $manufactures = $this->manufacture->getAllManufactures();
        $attibutes = $this->attribute->pagingAllAttributes()->get();
        $categories = $this->category->recursiveCategories();
        $parent_id = array();
        $option = '<ul class="list-group list-group-root well">';
        foreach ($categories as $parents) {
            if (in_array($parents->id, $parent_id))
                $checked = 'checked';
            else
                $checked = '';
            $option .= '<li href="#" class="list-group-item"><label style="width:100%">
            <input id="categories_' . $parents->id . '" ' . $checked . ' type="checkbox" class=" required_one categories sub_categories" name="categories[]" value="' . $parents->id . '">
          ' . $parents->name . '</label></li>';

            if (isset($parents->childs)) {
                $option .= '<ul class="list-group"><li class="list-group-item">';
                $option .= $this->childcat($parents->childs, $parent_id);
                $option .= '</li></ul>';
            }
        }
        $option .= '</ul>';
        $result['categories'] = $option;
        $result['manufactures'] = $manufactures;
        $result['attributes'] = $attibutes;
        $images = $this->image->getAllThumbnails();
        return view('admin.product.create',$header)->with(['result'=> $result, 'images' => $images]);
    }

    public function childcat($childs, $parent_id){
        $contents = '';
        foreach ($childs as $key => $child) {
            if (in_array($child->id, $parent_id))
                $checked = 'checked';
            else
                $checked = '';
            $contents .= '<label> <input id="categories_' . $child->id . '" parents_id="' . $child->parent_id . '"  type="checkbox" name="categories[]" class="required_one sub_categories categories sub_categories_' . $child->parent_id . '" value="' . $child->id . '" ' . $checked . '> ' . $child->name . '</label>';
            if (isset($child->childs)) {
                $contents .= '<ul class="list-group"><li class="list-group-item">';
                $contents .= $this->childcat($child->childs, $parent_id);
                $contents .= "</li></ul>";
            }
        }
        return $contents;
    }

    public function store(ProductRequest $request){
        $newData = $this->product->insertProduct($request);
            return redirect()->route('admin.product.index')->with('success','Produk baru berhasil ditambahkan');
        return redirect()->route('admin.manufacture.index')->with('error','Terjadi kesalahan saat input Produk baru');
    }

    public function edit($id){
        $header = [
            'title' => 'Produk',
            'desc'  => 'Edit Produk',
            'icon'  => 'fa-cubes'
        ];
        $product = $this->product->editProduct($id);
        $images = $this->image->getAllThumbnails();
        $categories = $this->category->recursiveCategories();
        $parent_id = $product->categories->pluck('id')->toArray();
        $option = '<ul class="list-group list-group-root well">';
        foreach ($categories as $parents) {
            if (in_array($parents->id, $parent_id))
                $checked = 'checked';
            else
                $checked = '';
            $option .= '<li href="#" class="list-group-item"><label style="width:100%">
            <input id="categories_' . $parents->id . '" ' . $checked . ' type="checkbox" class=" required_one categories sub_categories" name="categories[]" value="' . $parents->id . '">
          ' . $parents->name . '</label></li>';
            if (isset($parents->childs)) {
                $option .= '<ul class="list-group"><li class="list-group-item">';
                $option .= $this->childcat($parents->childs, $parent_id);
                $option .= '</li></ul>';
            }
        }
        $option .= '</ul>';
        $result['manufactures'] = $this->manufacture->getAllManufactures();;
        $result['attributes'] = $this->attribute->pagingAllAttributes()->get();;
        $result['option_product'] = $product->options->pluck('id')->toArray();
        $result['categories'] = $option;
        return view('admin.product.edit',$header)->with(['result'=> $result, 'images' => $images, 'product' => $product]);
    }

    public function update(ProductRequest $request, $id){
        $updateData = $this->product->updateProdcut($request,$id);
            return redirect()->route('admin.product.index')->with('success','Produk berhasil diubah');
        return redirect()->route('admin.product.index')->with('error','Produk gagal diubah');
    }

    public function destroy($id){
        $product = $this->product->deleteProduct($id);
        if($product)
            return response()->json(['status'=>true],200);
    }

    public function option_product($id){
        $options = $this->product->getOptionProduct($id);
        if($options)
            return response()->json(['data' => $options->get()],200);
    }

    public function option_update(){
        $options = $this->product->setValueOption(request()->all());
        if($options)
            return response()->json(['data' => $options],200);
    }

    public function product_image($id){
        $header = [
            'title' => 'Gambar Produk',
            'desc'  => 'Edit Produk',
            'icon'  => 'fa-picture-o'
        ];
        $images = $this->image->getAllThumbnails();
        return view('admin.product.images',$header)->with(['images' => $images]);
    }
}
