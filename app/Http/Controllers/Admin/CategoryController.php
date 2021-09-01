<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\CategoryRequest;
use App\Repositories\Images\ImagesRepository;
use App\Repositories\Categories\CategoriesRepository;

class CategoryController extends Controller
{
    public $category;
    public $image;
    function __construct(CategoriesRepository $category, ImagesRepository $image){
        $this->category = $category;
        $this->image = $image;
    }

    public function index()
    {
        $header = [
            'title' => 'Kategori',
            'desc'  => 'Daftar Kategori',
            'icon'  => 'fa-list'
        ];
        if(request()->ajax()){
            $categories = $this->category->pagingAllCategories();
            return DataTables::of($categories)
            ->editColumn('status',function ($item){
                if($item->status == 0)
                    return '<span class="label bg-orange">Draft</span>';
                else
                    return '<span class="label bg-green">Publish</span>';
            })
            ->editColumn('path',function ($item){
                return '<img width="70px" src="/'.$item->path.'">';
            })
            ->addColumn('action',function($item){
                return '<a href="/admin/katalog/category/'.$item->id.'/edit" style="color:white;cursor:pointer" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> '.
                '<a style="color:white;cursor:pointer" onclick="deleteData('.$item->id.',2)" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
            })
            ->rawColumns(['status','action','path'])
            ->make(true);
        }
        return view('admin.category.index',$header);
    }

    public function create()
    {
        $header = [
            'title' => 'Kategori',
            'desc'  => 'Tambah Kategori',
            'icon'  => 'fa-industry'
        ];
        $images = $this->image->getAllThumbnails();
        $categories = $this->category->recursiveCategories();
        $parent_id = 0;
        $option = '<option value="0">Kategori Utama</option>';
        foreach($categories as $parent){
            if($parent->id > 0){
                $option .= '<option value="'.$parent->id.'">'.$parent->name.'</option>';
            }
            if(isset($parent->childs)){
                $i = 1;
                $option .= $this->childCat($parent->childs,$i, $parent_id);
            }
        }
        return view('admin.category.create',$header)->with('images',$images)->with('option',$option);
    }

    public function store(CategoryRequest $request)
    {
        $newData = $this->category->insertCategory($request);
        if($newData)
            return redirect()->route('admin.category.index')->with('success','Kategori baru berhasil ditambahkan');
        return redirect()->route('admin.category.index')->with('error','Terjadi kesalah saat input Kategori baru');
    }

    public function edit($id)
    {
        $header = [
            'title' => 'Kategori',
            'desc'  => 'Edit Kategori',
            'icon'  => 'fa-industry'
        ];
        $images = $this->image->getAllThumbnails();
        $category = $this->category->editCategory($id);
        $categories = $this->category->recursiveCategories($category->id);
        $parent_id = $category->parent_id;
        $option = '<option value="0">Kategori Utama</option>';
        foreach($categories as $parent){
            $selected = '';
            if(isset($parent->id)){
                if($parent->id > 0){
                    if($parent->id == $parent_id)
                        $selected = 'selected';
                    $option .= '<option value="'.$parent->id.'"  '.$selected.' >'.$parent->name.'</option>';
                    $i = 1;
                    if(isset($parent->childs))
                        $option .= $this->childCat($parent->childs, $i, $parent_id);
                }
            }
        }
        return view('admin.category.edit',$header)->with(['images' => $images, 'option' => $option, 'category' => $category]);
        
    }

    public function update(CategoryRequest $request, $id)
    {
        $updateData = $this->category->updateCategory($request,$id);
        if($updateData)
            return redirect()->route('admin.category.index')->with('success','Kategori berhasil diubah');
        return redirect()->route('admin.category.index')->with('error','Kategori gagal diubah');

    }

    public function destroy($id)
    {
        $category = $this->category->deleteCategory($id);
        if($category)
            return response()->json(['params'=>'Kategori','data' => $category],200);
    }

    private function childCat($childs,$i,$parent){
        $contents = '';
        foreach($childs as $key => $child){
            $dash = '';
            for($j=1; $j<=$i; $j++){
                $dash .=  '&nbsp; &nbsp; &nbsp;';
            }
            if($child->id==$parent){
                $selected = 'selected';
            }else{
                $selected = '';
            }
            $contents.='<option value="'.$child->id.'" '.$selected.'>'.$dash.$child->name.'</option>';
            if(isset($child->childs)){
                $k = $i+1;
                $contents.= $this->childCat($child->childs,$k,$parent);
            }
            elseif($i>0){
                $i=1;
            }
        }
        return $contents;
    }
}
